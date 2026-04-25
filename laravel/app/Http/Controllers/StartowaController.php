<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
class StartowaController extends Controller
{
public function startowa()
{
    $products = Product::take(10)->get();
    $promo_products = Product::whereNotNull('promo_price')
        ->whereColumn('promo_price', '<', 'base_price')
        ->take(10)->get();

    // Pobieramy wszystkie kategorie z bazy
    $categories = Category::all();

    return view('startowa', compact('products', 'promo_products', 'categories'));
}

}
