<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WyszukajWitrynaController extends Controller
{
    public function suggestions(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['search'] ?? '');

        if (mb_strlen($search) < 2) {
            return response()->json([]);
        }

        $searchPattern = $this->likePattern($search);
        $likeOperator = config('database.default') === 'pgsql' ? 'ILIKE' : 'LIKE';

        $suggestions = Product::query()
            ->where(function ($query) use ($searchPattern, $likeOperator) {
                $query->where('name', $likeOperator, $searchPattern)
                    ->orWhereHas('category', function ($categoryQuery) use ($searchPattern, $likeOperator) {
                        $categoryQuery->where('name', $likeOperator, $searchPattern);
                    });
            })
            ->orderBy('name')
            ->limit(10)
            ->pluck('name');

        return response()->json($suggestions);
    }

    public function PrzeniesNaStrone(Request $request)
    {
        $validated = $request->validate([ // validacja ogracznica typy danych  blokuje xss oraz dziwne typy , okreslamy trukre jaki moga byc typy przekzane
            'search' => ['nullable', 'string', 'min:2', 'max:100'],
            'sort' => ['nullable', Rule::in(['newest', 'price_asc', 'price_desc', 'name_asc'])],
            'brands' => ['nullable', 'array', 'max:50'],
            'brands.*' => ['integer', 'distinct', 'exists:brands,id'],
            'attrs' => ['nullable', 'array', 'max:100'],
            'attrs.*' => ['nullable', 'array', 'max:100'],
            'attrs.*.*' => ['integer', 'distinct', 'exists:attribute_values,id'],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'page' => ['nullable', 'integer', 'min:1', 'max:10000'],
        ]);

        if (
            isset($validated['min_price'], $validated['max_price'])
            && (float) $validated['max_price'] < (float) $validated['min_price']
        ) {
            return back()
                ->withErrors(['max_price' => 'Cena maksymalna nie moze byc mniejsza od minimalnej.'])
                ->withInput();
        }

        $search = trim($validated['search'] ?? '');
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
        $sort = $validated['sort'] ?? 'newest';
        $likeOperator = config('database.default') === 'pgsql' ? 'ILIKE' : 'LIKE';

        $filterProductIds = Product::query()
            ->tap(fn ($baseQuery) => $this->applySearch($baseQuery, $search, $likeOperator))
            ->pluck('id');

        $recommendedProducts = Product::getPersonalizedRecommendations(10);

        $products = Product::whereNull('promo_price')->take(10)->get();

        $query = Product::with([
            'brand',
            'category',
            'attributeValues.attribute',
        ])->withAvg('reviews', 'rating');

        $this->applySearch($query, $search, $likeOperator);

        if (!empty($selectedBrands)) {
            $query->whereIn('brand_id', $selectedBrands);
        }

        foreach ($selectedAttrs as $attrId => $values) {
            $values = array_filter((array) $values, fn ($value) => is_numeric($value));

            if (empty($values) || !is_numeric($attrId)) {
                continue;
            }

            $query->whereHas('attributeValues', function ($q) use ($attrId, $values) { // eloqunet skleja sql selecta
                $q->where('attribute_values.attribute_category_id', (int) $attrId)
                    ->whereIn('attribute_values.id', $values);
            });
        }

        if (array_key_exists('min_price', $validated) && $validated['min_price'] !== null) {
            $query->whereRaw('COALESCE(promo_price, base_price) >= ?', [$validated['min_price']]);
        }

        if (array_key_exists('max_price', $validated) && $validated['max_price'] !== null) {
            $query->whereRaw('COALESCE(promo_price, base_price) <= ?', [$validated['max_price']]);
        }

        match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(promo_price, base_price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(promo_price, base_price) DESC'),
            'name_asc' => $query->orderBy('name'),
            default => $query->orderByDesc('id'),
        };

        $all_products = $query->paginate(8)->withQueryString();

        $brands = Brand::whereHas('products', function ($query) use ($filterProductIds) {
                $query->whereIn('products.id', $filterProductIds);
            })
            ->orderBy('name')
            ->get();

        $attributes = Attribute::with(['values' => function ($query) use ($filterProductIds) {
                $query->whereHas('products', function ($productQuery) use ($filterProductIds) {
                        $productQuery->whereIn('products.id', $filterProductIds);
                    })
                    ->orderBy('value');
            }])
            ->whereHas('values.products', function ($query) use ($filterProductIds) {
                $query->whereIn('products.id', $filterProductIds);
            })
            ->get()
            ->sortBy(fn ($attr) => $attr->display_name)
            ->values();

        return view('Strona_Wyszukiwania', compact(
            'all_products',
            'search',
            'brands',
            'attributes',
            'selectedBrands',
            'selectedAttrs',
            'sort',
            'recommendedProducts',
            'products'
        ));
    }

    private function applySearch($query, string $search, string $likeOperator): void
    {
        if ($search === '') {
            return;
        }

        $searchPattern = $this->likePattern($search);

        $query->where(function ($q) use ($searchPattern, $likeOperator) {
            $q->where('name', $likeOperator, $searchPattern)
                ->orWhereHas('brand', function ($brandQuery) use ($searchPattern, $likeOperator) { // laravel budowanie sql a nie podaje recznie
                    $brandQuery->where('name', $likeOperator, $searchPattern);
                })
                ->orWhereHas('category', function ($categoryQuery) use ($searchPattern, $likeOperator) {
                    $categoryQuery->where('name', $likeOperator, $searchPattern);
                })
                ->orWhereHas('attributeValues', function ($attributeQuery) use ($searchPattern, $likeOperator) {
                    $attributeQuery->where('value', $likeOperator, $searchPattern);
                });
        });
    }

    private function likePattern(string $search): string
    {
        return '%' . addcslashes($search, '\\%_') . '%';
    }
}
