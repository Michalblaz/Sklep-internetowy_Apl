<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
            $categoryId = $request->query('category_id', 1);
            // 1. Pobieramy produkty z paginacją
            $products = Product::where('category_id', $categoryId)->paginate(8)->withQueryString();

            // 2. Pobieramy kategorię wraz z jej atrybutami
           $category = Category::with(['attributes.values' => function($query) {
                $query->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
            }])->find($categoryId);
            
            // 3. Pobieramy unikalne marki (brand_id) tylko dla tej kategorii
            $brands = Product::where('category_id', $categoryId)
                            ->select('brand_id')
                            ->distinct()
                            ->with('brand')
                            ->get();

            return view('konfigurator', compact('products', 'category', 'brands'));
    }
}