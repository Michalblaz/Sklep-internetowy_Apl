<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ConfiguratorController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id', 1);
        $selectedBrands = $request->input('brands', []);
        $selectedAttrs = $request->input('attrs', []);

        // 1. Tworzymy zapytanie 
        $query = Product::where('category_id', $categoryId);

        // 2. Filtry marek
        if (!empty($selectedBrands)) {
            $query->whereIn('brand_id', $selectedBrands);
        }

        // 3. Filtry atrybutów
        if (!empty($selectedAttrs)) {
            foreach ($selectedAttrs as $attrId => $values) {
                $query->whereHas('attributeValues', function($q) use ($values) {
                    $q->whereIn('attribute_value_id', $values);
                });
            }
        }

        // 4. Filtry ceny 
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // 5. Sortowanie
        switch ($request->query('sort')) {
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // 6. Pobieramy produkty 
        $products = $query->paginate(8)->withQueryString();

        $category = Category::with(['attributes.values' => function($q) {
            $q->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
        }])->find($categoryId);

        $brands = Brand::whereHas('products', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get();

        return view('konfigurator', compact('products', 'category', 'brands'));
    }

    public function selectProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $categoryId = $request->input('category_id');
        
        $product = Product::find($productId);

        // Zapisujemy wybrany produkt w sesji pod kluczem kategorii
        $selection = session()->get('configurator_build', []);
        $selection[$categoryId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ];
        
        session()->put('configurator_build', $selection);

        return response()->json([
            'status' => 'success',
            'total_price' => collect($selection)->sum('price')
        ]);
    }
    }
