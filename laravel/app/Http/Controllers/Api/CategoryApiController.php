<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->get()
            ->map(fn (Category $category) => $this->formatCategory($category));

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load(['attributes.values'])->loadCount('products');

        return response()->json([
            'data' => $this->formatCategory($category, true),
        ]);
    }

    private function formatCategory(Category $category, bool $withAttributes = false): array
    {
        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'products_count' => $category->products_count ?? null,
        ];

        if ($withAttributes) {
            $data['attributes'] = $category->attributes
                ->map(fn ($attribute) => [
                    'id' => $attribute->id,
                    'name' => $attribute->display_name,
                    'is_required' => (bool) ($attribute->pivot->is_required ?? false),
                    'values' => $attribute->values
                        ->map(fn ($value) => [
                            'id' => $value->id,
                            'value' => $value->value,
                        ])
                        ->values(),
                ])
                ->values();
        }

        return $data;
    }
}
