<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StartowaController extends Controller
{
    public function startowa(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'brands' => ['nullable', 'array', 'max:50'],
            'brands.*' => ['integer', 'distinct', 'exists:brands,id'],
            'attrs' => ['nullable', 'array', 'max:100'],
            'attrs.*' => ['nullable', 'array', 'max:100'],
            'attrs.*.*' => ['integer', 'distinct', 'exists:attribute_values,id'],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'min_rating' => ['nullable', Rule::in(['1', '2', '3', '4', '5'])],
            'availability' => ['nullable', Rule::in(['in_stock', 'low_stock', 'out_of_stock'])],
            'sort' => ['nullable', Rule::in(['newest', 'price_asc', 'price_desc', 'name_asc', 'rating_desc', 'stock_desc'])],
            'page' => ['nullable', 'integer', 'min:1', 'max:10000'],
        ]);

        if (
            isset($validated['min_price'], $validated['max_price'])
            && (float) $validated['max_price'] < (float) $validated['min_price']
        ) {
            return back()
                ->withErrors(['max_price' => 'Cena maksymalna nie może być mniejsza od minimalnej.'])
                ->withInput();
        }

        $selectedCategory = $validated['category_id'] ?? $validated['category'] ?? null;
        $selectedBrands = $validated['brands'] ?? [];
        $rawSelectedAttrs = $validated['attrs'] ?? [];
        $selectedAttrs = collect($rawSelectedAttrs)
            ->filter(fn ($values, $attributeId) => ctype_digit((string) $attributeId))
            ->all();

        if (count($selectedAttrs) !== count($rawSelectedAttrs)) {
            throw ValidationException::withMessages([
                'attrs' => 'Filtry atrybutów mają nieprawidłowy format.',
            ]);
        }

        $products = Product::getPersonalizedRecommendations(20)
            ->sort(function ($firstProduct, $secondProduct) {
                $firstWithoutRating = $firstProduct->reviews_avg_rating === null ? 1 : 0;
                $secondWithoutRating = $secondProduct->reviews_avg_rating === null ? 1 : 0;

                if ($firstWithoutRating !== $secondWithoutRating) {
                    return $firstWithoutRating <=> $secondWithoutRating;
                }

                return ((float) ($secondProduct->reviews_avg_rating ?? 0) <=> (float) ($firstProduct->reviews_avg_rating ?? 0))
                    ?: ((int) $secondProduct->id <=> (int) $firstProduct->id);
            })
            ->values();

        $promoProductsQuery = Product::query()
            ->select('products.*')
            ->withAvg('reviews', 'rating')
            ->whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price');

        if (Auth::check()) {
            $viewedProducts = DB::table('product_browsing_history')
                ->select('product_id', DB::raw('MAX(viewed_at) as last_viewed_at'))
                ->where('user_id', Auth::id())
                ->groupBy('product_id');

            $promoProductsQuery
                ->leftJoinSub($viewedProducts, 'viewed_products', function ($join) {
                    $join->on('products.id', '=', 'viewed_products.product_id');
                })
                ->orderByRaw('CASE WHEN viewed_products.product_id IS NULL THEN 1 ELSE 0 END');
        }

        $promo_products = $promoProductsQuery
            ->orderByRaw('CASE WHEN (SELECT AVG(reviews.rating) FROM reviews WHERE reviews.product_id = products.id) IS NULL THEN 1 ELSE 0 END')
            ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
            ->when(Auth::check(), fn ($query) => $query->orderByDesc('viewed_products.last_viewed_at'))
            ->orderByDesc('products.id')
            ->take(25)
            ->get();

        $categories = Category::all();
        $selectedCategoryModel = null;
        $brands = Brand::orderBy('name')->get();
        $availableValueIds = [];
        $filterCategories = Category::with(['attributes.values' => function ($query) {
            $query->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
        }])->get();
        $brandsByCategory = Brand::query()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->where('products.isarchival', 0)
            ->select('brands.id', 'brands.name', 'products.category_id')
            ->distinct()
            ->orderBy('brands.name')
            ->get()
            ->groupBy('category_id');
        $filterDataByCategory = [
            'allBrands' => Brand::orderBy('name')->get(['id', 'name'])
                ->map(fn ($brand) => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                ])->values(),
            'categories' => $filterCategories
                ->mapWithKeys(function ($category) use ($brandsByCategory) {
                    return [
                        (string) $category->id => [
                            'brands' => $brandsByCategory->get($category->id, collect())
                                ->map(fn ($brand) => [
                                    'id' => $brand->id,
                                    'name' => $brand->name,
                                ])->values(),
                            'attributes' => $category->attributes
                                ->map(fn ($attribute) => [
                                    'id' => $attribute->id,
                                    'name' => $attribute->name,
                                    'display_name' => $attribute->display_name,
                                    'values' => $attribute->values
                                        ->map(fn ($value) => [
                                            'id' => $value->id,
                                            'value' => $attribute->formatValue($value->value),
                                        ])->values(),
                                ])->values(),
                        ],
                    ];
                }),
        ];

        $all_products = Product::withAvg('reviews', 'rating')
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            });

        if ($selectedCategory) {
            $selectedCategoryModel = Category::with(['attributes.values' => function ($query) {
                $query->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
            }])->find($selectedCategory);

            if ($selectedCategoryModel) {
                $brands = Brand::whereHas('products', function ($query) use ($selectedCategory) {
                    $query->where('category_id', $selectedCategory);
                })->orderBy('name')->get();
            }
        }

        if (!empty($selectedAttrs) && $selectedCategory) {
            foreach ($selectedAttrs as $attrId => $valueIds) {
                if (!is_array($valueIds) || empty($valueIds)) {
                    continue;
                }

                if (in_array((int) $attrId, [24, 25, 50], true) && (int) $selectedCategory === 7) {
                    $values = DB::table('attribute_values')->whereIn('id', $valueIds)->pluck('value');
                    $minValue = $values->map(fn ($value) => (float) preg_replace('/[^0-9.]/', '', $value))->min();

                    $all_products->whereHas('attributeValues', function ($query) use ($attrId, $minValue) {
                        $query->where('product_attributes.attribute_category_id', $attrId)
                            ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                            ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$minValue]);
                    });
                } elseif ((int) $attrId === 40 && (int) $selectedCategory === 2) {
                    $values = DB::table('attribute_values')->whereIn('id', $valueIds)->pluck('value');
                    $maxValue = $values->map(fn ($value) => (float) preg_replace('/[^0-9.]/', '', $value))->max();

                    $all_products->whereHas('attributeValues', function ($query) use ($attrId, $maxValue) {
                        $query->where('product_attributes.attribute_category_id', $attrId)
                            ->whereRaw("CAST(NULLIF(regexp_replace(attribute_values.value, '[^0-9.]', '', 'g'), '') AS DECIMAL) <= ?", [$maxValue]);
                    });
                } else {
                    foreach ($valueIds as $valueId) {
                        $all_products->whereHas('attributeValues', function ($query) use ($valueId) {
                            $query->where('product_attributes.attribute_value_id', $valueId);
                        });
                    }
                }
            }
        }

        if (!empty($selectedBrands)) {
            $all_products->whereIn('brand_id', $selectedBrands);
        }

        if (array_key_exists('min_price', $validated) && $validated['min_price'] !== null) {
            $all_products->where('base_price', '>=', $validated['min_price']);
        }

        if (array_key_exists('max_price', $validated) && $validated['max_price'] !== null) {
            $all_products->where('base_price', '<=', $validated['max_price']);
        }

        $selectedRating = null;

        if (isset($validated['min_rating'])) {
            $selectedRating = (float) $validated['min_rating'];

            $all_products->whereRaw(
                '(SELECT AVG(reviews.rating) FROM reviews WHERE reviews.product_id = products.id) >= ?',
                [$selectedRating]
            );
        }

        match ($validated['availability'] ?? null) {
            'in_stock' => $all_products->where('stock_quantity', '>', 0),
            'low_stock' => $all_products->whereBetween('stock_quantity', [1, 3]),
            'out_of_stock' => $all_products->where('stock_quantity', '<=', 0),
            default => null,
        };

        if ($selectedCategory) {
            $allMatchingProductIds = (clone $all_products)->pluck('id');
            $availableValueIds = DB::table('product_attributes')
                ->whereIn('product_id', $allMatchingProductIds)
                ->distinct()
                ->pluck('attribute_value_id')
                ->toArray();
        }

        if ($selectedRating !== null) {
            $all_products
                ->orderByRaw('CASE WHEN (SELECT AVG(reviews.rating) FROM reviews WHERE reviews.product_id = products.id) IS NULL THEN 1 ELSE 0 END')
                ->orderByRaw(
                    'ABS((SELECT AVG(reviews.rating) FROM reviews WHERE reviews.product_id = products.id) - ?) ASC',
                    [$selectedRating]
                )
                ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                ->orderByDesc('id');
        } else {
            $all_products->orderByRaw('CASE WHEN (SELECT AVG(reviews.rating) FROM reviews WHERE reviews.product_id = products.id) IS NULL THEN 1 ELSE 0 END');

            switch ($validated['sort'] ?? 'newest') {
                case 'price_asc':
                    $all_products->orderBy('base_price', 'asc');
                    break;
                case 'price_desc':
                    $all_products->orderBy('base_price', 'desc');
                    break;
                case 'name_asc':
                    $all_products->orderBy('name', 'asc');
                    break;
                case 'stock_desc':
                    $all_products->orderBy('stock_quantity', 'desc');
                    break;
                case 'newest':
                case 'rating_desc':
                default:
                    $all_products
                        ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                        ->orderByDesc('id');
                    break;
            }
        }

        $all_products = $all_products
            ->paginate(24)
            ->withQueryString();

        return view('startowa', compact(
            'products',
            'promo_products',
            'categories',
            'all_products',
            'selectedCategory',
            'selectedCategoryModel',
            'brands',
            'availableValueIds',
            'filterDataByCategory'
        ));
    }

    public function recordPageView(Request $request)
    {
        $validated = $request->validate([
            'page_path' => ['required', 'string', 'max:255'],
            'is_reload' => ['nullable', 'boolean'],
        ]);

        if (($validated['is_reload'] ?? false) || $validated['page_path'] !== '/' || !Schema::hasTable('site_page_views')) {
            return response()->noContent();
        }

        if ($request->session()->has('home_page_view_recorded')) {
            return response()->noContent();
        }

        DB::table('site_page_views')->insert([
            'page_path' => $validated['page_path'],
            'session_id' => $request->session()->getId(),
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            'viewed_at' => now(),
        ]);

        $request->session()->put('home_page_view_recorded', true);

        return response()->noContent();
    }

}
