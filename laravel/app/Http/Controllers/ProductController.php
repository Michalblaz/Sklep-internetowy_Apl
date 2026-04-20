<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Pobieramy wszystkie produkty z Supabase
        $products = Product::all();

        // Przesyłamy je do pliku resources/views/app.blade.php
        return view('app', compact('products'));
    }
}
