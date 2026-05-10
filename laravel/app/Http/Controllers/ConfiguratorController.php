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
                'brands' => collect(),
                'availableValueIds' => [],
                'attributeValuesMap' => [],
            ]);
        }

        $category = Category::with(['attributes.values' => function($q) {
            $q->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
        }])->findOrFail($categoryId);

         $query = Product::query()
            ->where('category_id', $categoryId)
            ->with([
                'brand',
                'attributeValues',
            ]);

        // --- LOGIKA KOMPATYBILNOŚCI ---
        $currentCategoryAttributeIds = $category->attributes->pluck('id')->toArray();

        foreach ($build as $builtCategoryId => $builtItem) {

            if ((int)$builtCategoryId === $categoryId) {
                continue;
            }

        // Obsługa produktów pojedynczych i list (RAM/Dyski)
        $items = in_array($builtCategoryId, [4, 5]) ? $builtItem : [$builtItem];

            foreach ($items as $item) {

            if (!isset($item['attributes'])) {
                continue;
            }

            foreach ($item['attributes'] as $attrId => $attrValueIds) {

                $valueIds = is_array($attrValueIds)
                    ? $attrValueIds
                    : [$attrValueIds];

                if (in_array($attrId, $currentCategoryAttributeIds)) {

                    $query->whereHas('attributeValues', function ($q) use ($attrId, $valueIds) {

                        $q->where('product_attributes.attribute_category_id', $attrId)
                            ->whereIn('product_attributes.attribute_value_id', $valueIds);
                    });
                }
            }
        }

            // Kompatybilność wymiarów
            // Przeglądamy Obudowy (7), mamy wybrane GPU (2) lub Chłodzenie (12)
            if ($categoryId == 7) {
                if ($builtCategoryId == 2) { // Limit karty
                    $gpuLen = $this->getNumericValueFromSession($builtItem, 40);
                    if ($gpuLen) {
                        $query->whereHas('attributeValues', function($q) use ($gpuLen) {
                            $q->where('product_attributes.attribute_category_id', 24)
                            ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                            ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$gpuLen]);
                        });
                    }
                }
                if ($builtCategoryId == 12) { // Limit chłodzenia
                    $coolerH = $this->getNumericValueFromSession($builtItem, 41);
                    $radS = $this->getNumericValueFromSession($builtItem, 49);
                    $query->where(function($q) use ($coolerH, $radS) {
                        if ($coolerH) {
                            $q->whereHas('attributeValues', function($sq) use ($coolerH) {
                                $sq->where('product_attributes.attribute_category_id', 25)
                                   ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                                   ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$coolerH]);
                            });
                        }
                        if ($radS) {
                            // Jeśli w koszyku jest AIO, filtrujemy obudowy po limicie radiatora (ID 50)
                            $q->whereHas('attributeValues', function($sq) use ($radS) {
                                $sq->where('product_attributes.attribute_category_id', 50)
                                   ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                                   ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$radS]);
                            });
                        }
                    });
                }
            }
            // Przeglądamy GPU (2) a mamy wybrane Obudowy (7)
            if ($categoryId == 2 && $builtCategoryId == 7) {
                $caseMaxGpu = $this->getNumericValueFromSession($builtItem, 24);
                if ($caseMaxGpu) {
                    $query->whereHas('attributeValues', function($q) use ($caseMaxGpu) {
                        $q->where('product_attributes.attribute_category_id', 40)
                        ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                        ->whereRaw("CAST(attribute_values.value AS DECIMAL) <= ?", [$caseMaxGpu]);
                    });
                }
            }

            // Przeglądamy Chłodzenie (12) a mamy wybrane Obudowy (7)
            if ($categoryId == 12 && $builtCategoryId == 7) {
                $caseMaxCooler = $this->getNumericValueFromSession($builtItem, 25);
                $caseMaxRadiator = $this->getNumericValueFromSession($builtItem, 50);

                $query->where(function($q) use ($caseMaxCooler, $caseMaxRadiator) {
                    // 1. Opcja dla chłodzeń powietrznych
                    if ($caseMaxCooler) {
                        $q->whereHas('attributeValues', function($sq) use ($caseMaxCooler) {
                            $sq->where('product_attributes.attribute_category_id', 41)
                            ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                            ->whereRaw("CAST(attribute_values.value AS DECIMAL) <= ?", [$caseMaxCooler]);
                        });
                    }
                    // 2. Opcja dla chłodzeń wodnych (AIO)
                    if ($caseMaxRadiator) {
                        $method = $caseMaxCooler ? 'orWhereHas' : 'whereHas';

                        $q->{$method}('attributeValues', function($sq) use ($caseMaxRadiator) {
                            $sq->where('product_attributes.attribute_category_id', 49)
                            ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                            ->whereRaw("CAST(attribute_values.value AS DECIMAL) <= ?", [$caseMaxRadiator]);
                        });
                    }
                });
            }
        }

        // FILTRY
        if (!empty($selectedAttrs)) {
            foreach ($selectedAttrs as $attrId => $valIds) {
                // Logika "od tej wartości w górę" dla Obudów
                if (($attrId == 24 || $attrId == 25 || $attrId == 50) && $categoryId == 7) {
                    $values = \DB::table('attribute_values')->whereIn('id', $valIds)->pluck('value');
                    $minVal = $values->map(fn($v) => (float) preg_replace('/[^0-9.]/', '', $v))->min();

                    $query->whereHas('attributeValues', function($q) use ($attrId, $minVal) {
                        $q->where('product_attributes.attribute_category_id', $attrId)
                        ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                        ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$minVal]);

                        });
                }
                // Logika "od tej wartości w dół" dla GPU
                elseif ($attrId == 40 && $categoryId == 2) {
                    $values = \DB::table('attribute_values')->whereIn('id', $valIds)->pluck('value');
                    $maxVal = $values->map(fn($v) => (float) preg_replace('/[^0-9.]/', '', $v))->max();

                    $query->whereHas('attributeValues', function($q) use ($attrId, $maxVal) {
                        $q->where('product_attributes.attribute_category_id', $attrId)
                        ->whereRaw("CAST(NULLIF(regexp_replace(attribute_values.value, '[^0-9.]', '', 'g'), '') AS DECIMAL) <= ?", [$maxVal]);
                    });
                }
                else {
                    // Standardowe filtrowanie atrybutów
                    foreach ($valIds as $valId) {
                        $query->whereHas('attributeValues', function($q) use ($valId) {
                            $q->where('product_attributes.attribute_value_id', $valId);
                        });
                    }
                }
            }
        }


        // Filtry marek
        if (!empty($selectedBrands)) {
            $query->whereIn('brand_id', $selectedBrands);
        }

        // Filtry ceny
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Filtry Producentów
        $brands = Brand::whereHas('products', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get();

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
        $allMatchingProductIds = (clone $query)->pluck('id');
        $availableValueIds = \DB::table('product_attributes')
            ->whereIn('product_id', $allMatchingProductIds)
            ->distinct()
            ->pluck('attribute_value_id')
            ->toArray();

         $products = $query->paginate(8)->withQueryString();

         $buildLimits = [
            'gpu_len'       => $this->getNumericValueFromSession($build[2] ?? null, 40),
            'cooler_h'      => $this->getNumericValueFromSession($build[12] ?? null, 41),
            'radiator_s'    => $this->getNumericValueFromSession($build[12] ?? null, 49),
            'case_gpu'      => $this->getNumericValueFromSession($build[7] ?? null, 24),
            'case_cooler'   => $this->getNumericValueFromSession($build[7] ?? null, 25),
            'case_radiator' => $this->getNumericValueFromSession($build[7] ?? null, 50),
        ];

        return view('konfigurator', compact('products', 'category', 'brands', 'availableValueIds', 'buildLimits'));
    }

    // Pobiera wartość liczbową konkretnego atrybutu dla produktu z bazy
    private function getSingleNumericValue($productOrId, $attrCategoryId)
    {
        if (is_numeric($productOrId)) {
            $val = \DB::table('product_attributes')
                ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
                ->where('product_attributes.product_id', $productOrId)
                ->where('product_attributes.attribute_category_id', $attrCategoryId)
                ->value('attribute_values.value');
        } else {
            $val = $productOrId->attributeValues->where('pivot.attribute_category_id', $attrCategoryId)->first()?->value;
        }

        if (!$val) return null;
        $clean = preg_replace('/[^0-9.]/', '', $val);
        return is_numeric($clean) ? (float)$clean : null;
    }
    // Pobiera wartość liczbową konkretnego atrybutu dla produktu z sesji
   public function getNumericValueFromSession($builtItem, $attrCategoryId)
   {
       if (!isset($builtItem['attributes'][$attrCategoryId])) {
            return null;
        }

        $valIds = $builtItem['attributes'][$attrCategoryId];
        $valId = is_array($valIds) ? $valIds[0] : $valIds;

        $val = \DB::table('attribute_values')->where('id', $valId)->value('value');

        $cleanVal = preg_replace('/[^0-9.]/', '', $val);

        return is_numeric($cleanVal) ? (float)$cleanVal : null;
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
            $attrId = (int) $val->pivot->attribute_category_id;

            if (in_array($attrId, $requiredAttributeIds, true)) {
               $attrs[$attrId][] = $val->id;
            }
        }

        $selection = session()->get('configurator_build', []);
        $multiSelectCategories = [4, 5];

        try {
            $this->validateCompatibility($product, $categoryId, $selection);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        if (in_array($categoryId, $multiSelectCategories)) {
        $motherboard = $selection[3] ?? null;

            if ($motherboard) {
                // 1. Walidacja RAM (Kategoria 4)
                if ($categoryId == 4) {
                    $maxSlots = $this->getNumberFromAttr($motherboard['id'], 44);
                    $usedSlots = 0;

                    if (isset($selection[4])) {
                        foreach ($selection[4] as $ramItem) {
                            $usedSlots += $this->getNumberFromAttr($ramItem['id'], 45);
                        }
                    }

                    $newProductSlots = $this->getNumberFromAttr($product->id, 45);

                    if (($usedSlots + $newProductSlots) > $maxSlots) {
                        return back()->with('error', "Brak wolnych slotów RAM! (Dostępne: $maxSlots, Zajęte: $usedSlots)");
                    }
                }

                // 2. Walidacja Dysków (Kategoria 5)
                if ($categoryId == 5) {
                    $maxM2 = $this->getNumberFromAttr($motherboard['id'], 48);
                    $usedDisks = isset($selection[5]) ? count($selection[5]) : 0;

                    if (($usedDisks + 1) > $maxM2) {
                        return back()->with('error', "Brak wolnych złącz M.2/SATA na płycie głównej!");
                    }
                }
            }
        }

        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $finalPrice,
            'attributes' => $attrs,
        ];

        if (in_array($categoryId, $multiSelectCategories)) {
            $selection[$categoryId][] = $productData;
        } else {
            $selection[$categoryId] = $productData;
        }

        session()->put('configurator_build', $selection);

        return redirect()->route('konfigurator.index', [
            'category_id' => $categoryId,
        ]);
    }

        // Czyścimy dane w sesji
    public function resetBuild()
    {
        session()->forget('configurator_build');
        return redirect()->route('konfigurator.index')->with('success', 'Zestaw został zresetowany.');
    }



    private function validateCompatibility($newProduct, $newCategoryId, $currentBuild)
    {
        foreach ($currentBuild as $catId => $items) {
            // Jeśli to RAM lub Dysk, to $items jest tablicą produktów
           $productsToCompare = (is_array($items) && is_array(reset($items)))
                         ? $items
                         : [$items];

            foreach ($productsToCompare as $item) {
                // Kompatybilność Obudowa (7) vs GPU (2)
                if (($newCategoryId == 2 && $catId == 7) || ($newCategoryId == 7 && $catId == 2)) {
                    $gpuLength = ($newCategoryId == 2) ? $this->getSingleNumericValue($newProduct->id, 40)  : $this->getSingleNumericValue($item['id'], 40);
                    $caseMaxGpu = ($newCategoryId == 7) ? $this->getSingleNumericValue($newProduct, 24) : $this->getSingleNumericValue($item['id'], 24);

                    if ($gpuLength && $caseMaxGpu && $gpuLength > $caseMaxGpu) {
                        throw new \Exception("Karta graficzna ({$gpuLength}mm) nie zmieści się w tej obudowie (max {$caseMaxGpu}mm)!");
                    }
                }

                // Kompatybilność Obudowa (7) vs Chłodzenie CPU (12)
                if (($newCategoryId == 12 && $catId == 7) || ($newCategoryId == 7 && $catId == 12)) {
                    $coolerHeight = ($newCategoryId == 12) ? $this->getSingleNumericValue($newProduct, 41) : $this->getSingleNumericValue($item['id'], 41);
                    $radiatorSize = ($newCategoryId == 12) ? $this->getSingleNumericValue($newProduct, 49) : $this->getSingleNumericValue($item['id'], 49);
                    $caseMaxCooler = ($newCategoryId == 7) ? $this->getSingleNumericValue($newProduct, 25) : $this->getSingleNumericValue($item['id'], 25);
                    $caseMaxRadiator = ($newCategoryId == 7) ? $this->getSingleNumericValue($newProduct, 50) : $this->getSingleNumericValue($item['id'], 50);

                    if ($coolerHeight && $caseMaxCooler && $coolerHeight > $caseMaxCooler) {
                        throw new \Exception("Chłodzenie CPU ({$coolerHeight}mm) jest za wysokie dla tej obudowy (max {$caseMaxCooler}mm)!");
                    }
                    if ($radiatorSize && $caseMaxRadiator && $radiatorSize > $caseMaxRadiator) {
                        throw new \Exception("Radiator ({$radiatorSize}mm) nie zmieści się w tej obudowie (max {$caseMaxRadiator}mm)!");
                    }
                }
            }
        }
    }


        // Wyciąga pierwszą napotkaną cyfrę z ciągu znaków
    private function getNumberFromAttr($productId, $attrCategoryId)
    {
        $val = \DB::table('product_attributes')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->where('product_attributes.product_id', $productId)
            ->where('product_attributes.attribute_category_id', $attrCategoryId)
            ->value('attribute_values.value');

        if (!$val) return 0;
        preg_match('/\d+/', $val, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 0;
    }


    public function getAvailableProducts($categoryId)
    {
        $query = Product::where('category_id', $categoryId);
        $selection = session()->get('configurator_build', []);

        foreach ($selection as $selectedCatId => $item) {
            $rules = \DB::table('category_attributes')
                        ->where('category_id', $categoryId)
                        ->where('is_required', true)
                        ->get();

            foreach ($rules as $rule) {
                $selectedValues = $item['attributes'][$rule->attribute_id] ?? [];

                if (!empty($selectedValues)) {
                    $query->whereHas('attributeValues', function($q) use ($rule, $selectedValues) {
                        $q->where('attribute_category_id', $rule->attribute_id)
                        ->whereIn('id', $selectedValues);
                    });
                }
            }
        }
        return $query->get();
    }
}
