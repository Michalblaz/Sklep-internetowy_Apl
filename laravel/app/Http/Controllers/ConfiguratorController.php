<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ConfiguratorController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'brands' => ['nullable', 'array'],
            'brands.*' => ['integer', 'exists:brands,id'],
            'attrs' => ['nullable', 'array'],
            'attrs.*' => ['array'],
            'attrs.*.*' => ['integer', 'exists:attribute_values,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
            'sort' => ['nullable', 'in:newest,price_asc,price_desc,name_asc,rating_desc,stock_desc'],
            'change' => ['nullable', 'in:1'],
            'replace_index' => ['nullable', 'integer', 'min:0'],
        ]);

        $categoryId = isset($validated['category_id']) ? (int) $validated['category_id'] : null;
        $selectedBrands = $this->sanitizeIdArray($validated['brands'] ?? []);
        $selectedAttrs = $this->sanitizeAttributeFilters($validated['attrs'] ?? []);
        $minPrice = $validated['min_price'] ?? null;
        $maxPrice = $validated['max_price'] ?? null;
        $sort = $validated['sort'] ?? null;
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
            ->with(['brand', 'attributeValues'])
            ->withAvg('reviews', 'rating');

        // --- LOGIKA KOMPATYBILNOŚCI ---
        $currentCategoryAttributeIds = $category->attributes->pluck('id')->map(fn ($id) => (int) $id)->toArray();

        foreach ($build as $builtCategoryId => $builtItem) {

            if ((int)$builtCategoryId == $categoryId) {
                continue;
            }

        // Obsługa produktów pojedynczych i list (RAM/Dyski)
        $items = in_array($builtCategoryId, [4, 5]) ? $builtItem : [$builtItem];

            foreach ($items as $item) {

            if (!isset($item['attributes'])) {
                continue;
            }

            foreach ($item['attributes'] as $attrId => $attrValueIds) {
                $attrId = (int) $attrId;

                $valueIds = $this->sanitizeIdArray(is_array($attrValueIds)
                    ? $attrValueIds
                    : [$attrValueIds]);

                if (!empty($valueIds) && in_array($attrId, $currentCategoryAttributeIds, true)) {

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
                $attrId = (int) $attrId;

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
                    // Znalazłem błąd z wyborem wielu filtrów pętla "foreach ($valIds as $valId)" pętla nakładała AND
                    if (!empty($valIds)) {
                        $query->whereHas('attributeValues', function($q) use ($valIds) {
                            $q->whereIn('product_attributes.attribute_value_id', $valIds);
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
        if ($minPrice !== null) {
            $query->where('base_price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('base_price', '<=', $maxPrice);
        }

        // Filtry Producentów
        $brands = Brand::whereHas('products', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get();

        // Sortowanie
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'rating_desc':
                $query->orderByRaw('reviews_avg_rating DESC NULLS LAST');
                break;
            case 'stock_desc':
                $query->orderBy('stock_quantity', 'desc');
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




        $selectedInThisCategory = $build[$category->id] ?? null;

        $selectedItemData = is_array($selectedInThisCategory) && isset($selectedInThisCategory[0])
            ? $selectedInThisCategory[0]
            : $selectedInThisCategory;

        $isChanging = ($validated['change'] ?? null) == '1';

        $selectedProductModel = $selectedItemData
            ? Product::with(['attributeValues.attribute'])->find($selectedItemData['id'])
            : null;

        $selectedProductAttributes = $selectedProductModel
            ? $selectedProductModel->attributeValues
                ->take(6)
                ->map(fn ($attrVal) => [
                    'value' => $attrVal->value,
                ])
            : collect();

        return view('konfigurator', compact(
            'products',
            'category',
            'brands',
            'availableValueIds',
            'buildLimits',
            'selectedItemData',
            'isChanging',
            'selectedProductModel',
            'selectedProductAttributes'
        ));
    }

    // Pobiera wartość liczbową konkretnego atrybutu dla produktu z bazy
    private function getSingleNumericValue($productOrId, $attrCategoryId)
    {
        if (is_numeric($productOrId)) {
            $val = \DB::table('product_attributes')
                ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
                ->where('product_attributes.product_id', (int) $productOrId)
                ->where('product_attributes.attribute_category_id', (int) $attrCategoryId)
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

        if (!is_numeric($valId)) {
            return null;
        }

        $val = \DB::table('attribute_values')->where('id', (int) $valId)->value('value');

        $cleanVal = preg_replace('/[^0-9.]/', '', $val);

        return is_numeric($cleanVal) ? (float)$cleanVal : null;
    }

    private function getBooleanAttributeValue(Product $product, int $attrCategoryId): ?bool
    {
        $value = $product->attributeValues
            ->where('pivot.attribute_category_id', $attrCategoryId)
            ->first()?->value;

        if ($value === null) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

        //Zapisujemy wybrany produkt w sesji
    public function selectProduct(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'replace_index' => ['nullable', 'integer', 'min:0'],
        ]);

        $categoryId = (int) $validated['category_id'];
        $replaceIndex = isset($validated['replace_index']) ? (int) $validated['replace_index'] : null;

        $product = Product::with('attributeValues')->findOrFail($validated['product_id']);

        if ((int) $product->category_id !== $categoryId) {
            return back()->with('error', 'Wybrany produkt nie nalezy do tej kategorii.');
        }

        if ((int) $product->stock_quantity <= 0) {
            return back()->with('error', 'Wybrany produkt jest niedostepny.');
        }

        $category = Category::with(['attributes' => function ($q) {
            $q->wherePivot('is_required', true);
        }])->findOrFail($categoryId);

        $requiredAttributeIds = $category->attributes->pluck('id')->map(fn ($id) => (int) $id)->toArray();

        $discount = ($product->base_price > 0 && $product->promo_price && $product->promo_price < $product->base_price)
            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
            : 0;

        $finalPrice = $discount > 0
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


        if ($categoryId === 3) {
            $maxSlots = $this->getNumberFromAttr($product->id, 44);
            $maxM2 = $this->getNumberFromAttr($product->id, 48);

            // Walidacja RAM w sesji
            if (isset($selection[4])) {
                $usedSlots = 0;
                foreach ($selection[4] as $ramItem) {
                    $usedSlots += $this->getNumberFromAttr($ramItem['id'], 45);
                }
                if ($usedSlots > $maxSlots) {
                    return back()->with('error', "Nowa płyta ma tylko $maxSlots sloty RAM, a Ty masz już $usedSlots w zestawie");
                }
            }

            // Walidacja Dysków M.2 w sesji
            if (isset($selection[5])) {
                $usedM2InSession = 0;
                foreach ($selection[5] as $diskItem) {
                    // Próbujemy sprawdzić z sesji, a jeśli nie ma - sprawdzamy w bazie
                    $isM2 = false;
                    if (isset($diskItem['attributes'][17]) && in_array(41, $diskItem['attributes'][17])) {
                        $isM2 = true;
                    } else {
                        // Zabezpieczenie: sprawdź w bazie jeśli sesja jest stara
                        $dbCheck = \DB::table('product_attributes')
                            ->where('product_id', $diskItem['id'])
                            ->where('attribute_category_id', 17)
                            ->where('attribute_value_id', 41)
                            ->exists();
                        if ($dbCheck) $isM2 = true;
                    }

                    if ($isM2) $usedM2InSession++;
                }

                if ($usedM2InSession > $maxM2) {
                    return back()->with('error', "Nowa płyta ma tylko $maxM2 sloty M.2, a Ty masz już $usedM2InSession takie dyski");
                }
            }
        }
       if (in_array($categoryId, $multiSelectCategories)) {
            $motherboard = $selection[3] ?? null;
            if ($motherboard) {
                // Walidacja RAM
                if ($categoryId == 4) {
                    $maxSlots = $this->getNumberFromAttr($motherboard['id'], 44);
                    $usedSlots = 0;
                    if (isset($selection[4])) {
                        foreach ($selection[4] as $idx => $ramItem) {
                            if ($replaceIndex !== null && $idx == $replaceIndex) continue;
                            $usedSlots += $this->getNumberFromAttr($ramItem['id'], 45);
                        }
                    }
                    $newProductSlots = $this->getNumberFromAttr($product->id, 45);
                    if (($usedSlots + $newProductSlots) > $maxSlots) {
                        return back()->with('error', "Brak wolnych slotów RAM !!!");
                    }
                }

                // Walidacja Dysków (Tylko M.2)
                if ($categoryId == 5) {
                    $isNewDiskM2 = isset($attrs[17]) && in_array(41, $attrs[17]);
                    if ($isNewDiskM2) {
                        $maxM2 = $this->getNumberFromAttr($motherboard['id'], 48);
                        $usedM2Slots = 0;
                        if (isset($selection[5])) {
                            foreach ($selection[5] as $idx => $diskItem) {
                                if ($replaceIndex !== null && $idx == $replaceIndex) continue;

                                $isM2 = false;
                                if (isset($diskItem['attributes'][17]) && in_array(41, $diskItem['attributes'][17])) {
                                    $isM2 = true;
                                } else {
                                    $dbCheck = \DB::table('product_attributes')
                                        ->where('product_id', $diskItem['id'])
                                        ->where('attribute_category_id', 17)
                                        ->where('attribute_value_id', 41)
                                        ->exists();
                                    if ($dbCheck) $isM2 = true;
                                }
                                if ($isM2) $usedM2Slots++;
                            }
                        }
                        if (($usedM2Slots + 1) > $maxM2) {
                            return back()->with('error', "Brak wolnych złącz M.2 !!!");
                        }
                    }
                }
            }
        }

        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $finalPrice,
            'base_price' => $product->base_price,
            'promo_price' => $discount > 0 ? $product->promo_price : null,
            'discount' => $discount,
            'power_draw_w' => (int) ($product->power_draw_w ?? 0),
            'attributes' => $attrs,
        ];

        if ($categoryId === 1) {
            $hasIntegratedGpu = $this->getBooleanAttributeValue($product, 7);
            $hasIncludedFan = $this->getBooleanAttributeValue($product, 38);

            $productData['requires_gpu'] = $hasIntegratedGpu === false;
            $productData['requires_cooler'] = $hasIncludedFan === false;
        }

        if (in_array($categoryId, $multiSelectCategories)) {
            if ($replaceIndex !== null && isset($selection[$categoryId][$replaceIndex])) {
                $selection[$categoryId][$replaceIndex] = $productData;
            } else {
                $selection[$categoryId][] = $productData;
            }
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
        if (!is_numeric($productId) || !is_numeric($attrCategoryId)) {
            return 0;
        }

        $val = \DB::table('product_attributes')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->where('product_attributes.product_id', (int) $productId)
            ->where('product_attributes.attribute_category_id', (int) $attrCategoryId)
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


    public function moveToCart(Request $request)
    {
        // 1. Pobieramy produkty z konfiguratora
        $buildItems = session('configurator_build', []);

        if (empty($buildItems)) {
            return back()->with('error', 'Twój konfigurator jest pusty! Dodaj produkty przed przejściem do koszyka.');
        }

        // 2. Sprawdzamy, czy użytkownik jest zalogowany
        if (auth()->check()) {

            // Jeśli użytkownik jest zalogowany (ZAPIS DO BAZY DANYCH) ---
            $userId = auth()->id();

            foreach ($buildItems as $categoryId => $data) {
                // Jeśli to pojedynczy produkt
                if (isset($data['id'])) {
                    $this->addProductToDatabaseCart($userId, $data['id']);
                }
                // Jeśli to tablica produktów (np. wiele kości RAM / dysków)
                elseif (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['id'])) {
                            $this->addProductToDatabaseCart($userId, $item['id']);
                        }
                    }
                }
            }

        } else {

            // Gość (ZAPIS DO SESJI COŚĆ) ---
            $cart = session('cart', []);

            foreach ($buildItems as $categoryId => $data) {
                // Jeśli to pojedynczy produkt
                if (isset($data['id'])) {
                    $this->addProductToSessionCart($cart, $data);
                }
                // Jeśli to tablica produktów
                elseif (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['id'])) {
                            $this->addProductToSessionCart($cart, $item);
                        }
                    }
                }
            }

            // Zapisujemy zaktualizowaną tablicę koszyka z powrotem do sesji
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Cały zestaw został pomyślnie dodany do Twojego koszyka!');
    }

    // Zapis produktu bezpośrednio do bazy danych

    private function addProductToDatabaseCart($userId, $productId)
    {
        if (!is_numeric($productId) || !Product::whereKey((int) $productId)->exists()) {
            return;
        }

        // Sprawdzamy, czy ten użytkownik ma już ten sam produkt w koszyku
        $existingItem = DB::table('cart_items')
            ->where('user_id', (int) $userId)
            ->where('product_id', (int) $productId)
            ->first();

        if ($existingItem) {
            // Jeśli produkt istnieje, zwiększamy jego ilość o 1
            DB::table('cart_items')
                ->where('id', $existingItem->id)
                ->increment('quantity');
        } else {
            // Jeśli produktu nie ma, tworzymy nowy rekord w koszyku bazy danych
            DB::table('cart_items')->insert([
                'user_id'    => (int) $userId,
                'product_id' => (int) $productId,
                'quantity'   => 1,
            ]);
        }
    }

    // Metoda pomocnicza: Zapis produktu do tradycyjnej sesji (dla gości)
    private function addProductToSessionCart(&$cart, $product)
    {
        if (!isset($product['id']) || !is_numeric($product['id']) || !Product::whereKey((int) $product['id'])->exists()) {
            return;
        }

        $productId = (int) $product['id'];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'id'       => $productId,
                'name'     => $product['name'],
                'price'    => (float) $product['price'],
                'quantity' => 1,
            ];
        }
    }
    public function removeFromBuild(int $categoryId, int $index)
    {
        $build = session('configurator_build', []);

        if (isset($build[$categoryId])) {
            if (is_array(reset($build[$categoryId]))) {
                // Jeśli to kategoria z wieloma elementami, usuwamy po indeksie
                unset($build[$categoryId][$index]);
                // Naprawiamy indeksy tablicy (0, 1, 2...)
                $build[$categoryId] = array_values($build[$categoryId]);

                if (empty($build[$categoryId])) {
                    unset($build[$categoryId]);
                }
            } else {
                // Jeśli to kategoria pojedyncza
                unset($build[$categoryId]);
            }
        }

        session(['configurator_build' => $build]);
        return redirect()->back();
    }

    private function sanitizeIdArray(array $values): array
    {
        return collect($values)
            ->filter(fn ($value) => is_numeric($value) && (int) $value > 0)
            ->map(fn ($value) => (int) $value)
            ->unique()
            ->values()
            ->all();
    }

    private function sanitizeAttributeFilters(array $attrs): array
    {
        $sanitized = [];

        foreach ($attrs as $attrId => $valueIds) {
            if (!is_numeric($attrId) || !is_array($valueIds)) {
                continue;
            }

            $cleanValueIds = $this->sanitizeIdArray($valueIds);

            if (!empty($cleanValueIds)) {
                $sanitized[(int) $attrId] = $cleanValueIds;
            }
        }

        return $sanitized;
    }
}
