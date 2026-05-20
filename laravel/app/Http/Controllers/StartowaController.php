<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartowaController extends Controller
{
    public function startowa(Request $request)
    {
        $selectedCategory = $request->query('category_id', $request->query('category'));
        $selectedBrands = $request->input('brands', []);
        $selectedAttrs = $request->input('attrs', []);

        $products = Product::withAvg('reviews', 'rating')
            ->orderByRaw("
            CASE
                WHEN promo_price IS NOT NULL AND promo_price < base_price THEN 0
                ELSE 1
            END
        ")
            ->take(25)
            ->get();

        $promo_products = Product::withAvg('reviews', 'rating')
            ->whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price')
            ->take(25)
            ->get();

        $categories = Category::all();
        $selectedCategoryModel = null;
        $brands = Brand::orderBy('name')->get();
        $availableValueIds = [];

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

        if ($request->filled('min_price')) {
            $all_products->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $all_products->where('base_price', '<=', $request->max_price);
        }

        if ($selectedCategory) {
            $allMatchingProductIds = (clone $all_products)->pluck('id');
            $availableValueIds = DB::table('product_attributes')
                ->whereIn('product_id', $allMatchingProductIds)
                ->distinct()
                ->pluck('attribute_value_id')
                ->toArray();
        }

        switch ($request->query('sort')) {
            case 'price_asc':
                $all_products->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $all_products->orderBy('base_price', 'desc');
                break;
            case 'name_asc':
                $all_products->orderBy('name', 'asc');
                break;
            default:
                $all_products->orderBy('id', 'desc');
                break;
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
            'availableValueIds'
        ));
    }

}
