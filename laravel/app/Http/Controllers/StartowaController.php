<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StartowaController extends Controller
{
    public function startowa()
    {
        $products = Product::whereNull('promo_price')->take(10)->get();

        $promo_products = Product::whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price')
            ->get();

        $categories = Category::all();

        $all_products = Product::paginate(80);

        return view('startowa', compact('products', 'promo_products', 'categories', 'all_products'));
    }
}
