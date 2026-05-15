<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StartowaController extends Controller
{
    public function startowa(Request $request)
    {
        $selectedCategory = $request->query('category');

        $products = Product::withAvg('reviews', 'rating')
            ->orderByRaw("
            CASE
                WHEN promo_price IS NOT NULL AND promo_price < base_price THEN 0
                ELSE 1
            END
        ")
            ->take(10)
            ->get();

        $promo_products = Product::withAvg('reviews', 'rating')
            ->whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price')
            ->get();

        $categories = Category::all();

        $all_products = Product::withAvg('reviews', 'rating')
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            })
            ->paginate(24)
            ->withQueryString();

        return view('startowa', compact(
            'products',
            'promo_products',
            'categories',
            'all_products',
            'selectedCategory'
        ));
    }
}
