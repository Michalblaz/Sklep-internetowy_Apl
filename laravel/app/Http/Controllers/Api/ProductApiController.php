<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'min:1'],
            'brand_id' => ['nullable', 'integer', 'min:1'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'sort' => ['nullable', 'in:newest,price_asc,price_desc,name_asc,rating_desc,stock_desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = Product::query()
            ->with(['brand:id,name', 'category:id,name'])
            ->withAvg('reviews', 'rating');

        if (!empty($validated['search'])) {
            $search = mb_strtolower($validated['search']);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        if (!empty($validated['brand_id'])) {
            $query->where('brand_id', $validated['brand_id']);
        }

        if (array_key_exists('min_price', $validated)) {
            $query->where('base_price', '>=', $validated['min_price']);
        }

        if (array_key_exists('max_price', $validated)) {
            $query->where('base_price', '<=', $validated['max_price']);
        }

        match ($validated['sort'] ?? 'newest') {
            'price_asc' => $query->orderBy('base_price'),
            'price_desc' => $query->orderByDesc('base_price'),
            'name_asc' => $query->orderBy('name'),
            'rating_desc' => $query->orderByDesc('reviews_avg_rating')->orderByDesc('id'),
            'stock_desc' => $query->orderByDesc('stock_quantity'),
            default => $query->orderByDesc('id'),
        };

        $products = $query->paginate($validated['per_page'] ?? 12)->withQueryString();

        return response()->json($products->through(fn (Product $product) => $this->formatProduct($product)));
    }

    public function show(Product $product): JsonResponse
    {
        $product->load([
            'brand:id,name',
            'category:id,name',
            'attributeValues.attribute',
        ])->loadAvg('reviews', 'rating');

        return response()->json([
            'data' => $this->formatProduct($product, true),
        ]);
    }

    private function formatProduct(Product $product, bool $withAttributes = false): array
    {
        $promoPrice = $product->promo_price && $product->promo_price < $product->base_price
            ? (float) $product->promo_price
            : null;

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'base_price' => (float) $product->base_price,
            'promo_price' => $promoPrice,
            'price' => $promoPrice ?? (float) $product->base_price,
            'stock_quantity' => (int) $product->stock_quantity,
            'power_draw_w' => $product->power_draw_w !== null ? (int) $product->power_draw_w : null,
            'image_url' => $product->image_url,
            'rating_avg' => $product->reviews_avg_rating !== null ? round((float) $product->reviews_avg_rating, 2) : null,
            'brand' => $product->brand ? [
                'id' => $product->brand->id,
                'name' => $product->brand->name,
            ] : null,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
            ] : null,
        ];

        if ($withAttributes) {
            $data['attributes'] = $product->attributeValues
                ->map(fn ($value) => [
                    'id' => $value->id,
                    'name' => $value->attribute?->display_name ?? $value->attribute?->name,
                    'value' => $value->value,
                ])
                ->values();
        }

        return $data;
    }
}
