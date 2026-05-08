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
        $categoryId = $request->query('category_id');
        $selectedBrands = $request->input('brands', []);
        $selectedAttrs = $request->input('attrs', []);
        $build = session('configurator_build', []);

        if (!$categoryId) {
            return view('konfigurator', [
                'products' => null,
                'category' => null,
                'brands' => collect()
            ]);
        }
        
        $category = Category::with(['attributes.values' => function($q) {
            $q->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
        }])->findOrFail($categoryId);

        $query = Product::where('category_id', $categoryId);

        // Logika kompatybilności 
        $build = session('configurator_build', []);
        $currentCategoryAttributeIds = $category->attributes->pluck('id')->toArray();

        foreach ($build as $builtCategoryId => $builtItem) {
            if ($builtCategoryId == $category->id) continue;

            if (isset($builtItem['attributes'])) {
            foreach ($builtItem['attributes'] as $attrId => $attrValueId) {
                
                if (in_array($attrId, $currentCategoryAttributeIds)) {
                    
                    $query->whereHas('attributeValues', function($q) use ($attrId, $attrValueId) {
                        $q->where('product_attributes.' . Product::attributeCategoryPivotColumn(), $attrId)
                        ->where('product_attributes.attribute_value_id', $attrValueId);
                    });
                }
            }
        }
        }

        // Filtry marek
        if (!empty($selectedBrands)) {
            $query->whereIn('brand_id', $selectedBrands);
        }

        // Filtry atrybutów
        if (!empty($selectedAttrs)) {
            foreach ($selectedAttrs as $attrId => $values) {
                $query->whereHas('attributeValues', function($q) use ($values) {
                    $q->whereIn('attribute_value_id', $values);
                });
            }
        }

        // Filtry ceny 
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Sortowanie
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

        // Pobieramy produkty 
        $products = $query->paginate(8)->withQueryString();

        $brands = Brand::whereHas('products', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get();

        return view('konfigurator', compact('products', 'category', 'brands'));
    }
        //Zapisujemy wybrany produkt w sesji
    public function selectProduct(Request $request)
    {
        $categoryId = (int) $request->input('category_id');

        $product = Product::with('attributeValues')->findOrFail($request->input('product_id'));
        $category = Category::with(['attributes' => function ($q) {
            $q->wherePivot('is_required', true);
        }])->findOrFail($categoryId);

        $requiredAttributeIds = $category->attributes->pluck('id')->map(fn ($id) => (int) $id)->toArray();

        $finalPrice = ($product->promo_price && $product->promo_price < $product->base_price)
            ? $product->promo_price
            : $product->base_price;

        $attrs = [];

        foreach ($product->attributeValues as $val) {
            $attrId = (int) $val->pivot->{Product::attributeCategoryPivotColumn()};

            if (in_array($attrId, $requiredAttributeIds, true)) {
                $attrs[$attrId] = $val->id;
            }
        }

        $selection = session()->get('configurator_build', []);
        $selection[$categoryId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $finalPrice,
            'attributes' => $attrs,
        ];

        session()->put('configurator_build', $selection);

        return redirect()->route('konfigurator.index', [
            'category_id' => $categoryId,
        ]);
    }

        // Czyścimy dane
    public function resetBuild()
    {
        session()->forget('configurator_build');
        return redirect()->route('konfigurator.index')->with('success', 'Zestaw został zresetowany.');
    }


    }
