<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WyszukajWitrynaController extends Controller
{
    public function PrzeniesNaStrone(Request $request)
    {
        $selectedCategory = $request->query('category');

        // produkty do karuzeli
        $products = Product::whereNull('promo_price')
            ->take(10)
            ->get();

        // promo (jeśli chcesz mieć sekcję jak na startowej)
        $promo_products = Product::whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price')
            ->get();

        // kategorie
        $categories = Category::all();

        // wszystkie produkty (lista + pagination)
        $all_products = Product::when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            })
            ->paginate(80)
            ->withQueryString();

        return view("Strona_Wyszukiwania", compact(
            'products',
            'promo_products',
            'categories',
            'all_products',
            'selectedCategory'
        ));
    }
}
