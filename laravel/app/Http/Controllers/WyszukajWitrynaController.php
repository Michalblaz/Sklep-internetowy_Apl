<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WyszukajWitrynaController extends Controller
{
    public function PrzeniesNaStrone(Request $request)
    {
        $validated = $request->validate([ // validacja ogracznica typy danych  blokuje xss oraz dziwne typy , okreslamy trukre jaki moga byc typy przekzane
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', Rule::in(['newest', 'price_asc', 'price_desc', 'name_asc'])],
            'brands' => ['nullable', 'array'],
            'brands.*' => ['integer', 'exists:brands,id'],
            'attrs' => ['nullable', 'array'],
            'attrs.*' => ['nullable', 'array'],
            'attrs.*.*' => ['integer', 'exists:attribute_values,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'page' => ['nullable', 'integer', 'min:1'],
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
        $selectedAttrs = $validated['attrs'] ?? [];
        $sort = $validated['sort'] ?? 'newest';
        $likeOperator = config('database.default') === 'pgsql' ? 'ILIKE' : 'LIKE';

        $filterProductIds = Product::query()
            ->tap(fn ($baseQuery) => $this->applySearch($baseQuery, $search, $likeOperator))
            ->pluck('id');

        $recommendedProducts = Product::with(['brand', 'category'])
            ->whereIn('id', $filterProductIds)
            ->orderByDesc('id')
            ->take(10)
            ->get();

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
            ->orderBy('name')
            ->get();

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

        $query->where(function ($q) use ($search, $likeOperator) {
            $q->where('name', $likeOperator, "%{$search}%")
                ->orWhereHas('brand', function ($brandQuery) use ($search, $likeOperator) { // laravel budowanie sql a nie podaje recznie
                    $brandQuery->where('name', $likeOperator, "%{$search}%");
                })
                ->orWhereHas('category', function ($categoryQuery) use ($search, $likeOperator) {
                    $categoryQuery->where('name', $likeOperator, "%{$search}%");
                })
                ->orWhereHas('attributeValues', function ($attributeQuery) use ($search, $likeOperator) {
                    $attributeQuery->where('value', $likeOperator, "%{$search}%");
                });
        });
    }
}
