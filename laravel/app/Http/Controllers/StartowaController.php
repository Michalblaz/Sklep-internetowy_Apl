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

    $products = Product::whereNull('promo_price')->take(10)->get();

    $promo_products = Product::whereNotNull('promo_price')
        ->whereColumn('promo_price', '<', 'base_price')
        ->get();

    $categories = Category::all();

    $all_products = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
        $query->where('category_id', $selectedCategory);
    })
    ->paginate(80)
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
