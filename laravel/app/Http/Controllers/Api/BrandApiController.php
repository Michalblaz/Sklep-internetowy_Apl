<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandApiController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::query()
            ->withCount('products')
            ->orderBy('name')
            ->get()
            ->map(fn (Brand $brand) => [
                'id' => $brand->id,
                'name' => $brand->name,
                'products_count' => $brand->products_count,
            ]);

        return response()->json([
            'data' => $brands,
        ]);
    }
}
