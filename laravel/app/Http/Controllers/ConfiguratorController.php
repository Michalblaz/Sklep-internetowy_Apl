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
        $category->attributes->transform(function($attribute) {

            $attribute->display_name = $this->translateKey($attribute->name);
            return $attribute;
        });

         $query = Product::query()
            ->where('category_id', $categoryId)
            ->with([
                'brand',
                'attributeValues',
            ]);

        // --- LOGIKA KOMPATYBILNOŚCI ---
        $currentCategoryAttributeIds = $category->attributes->pluck('id')->toArray();

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

        $brands = Brand::whereHas('products', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get();

        return view('konfigurator', compact('products', 'category', 'brands'));
    }
        //Zapisujemy wybrany produkt w sesji
    public function selectProduct(Request $request)
    {
        $categoryId = (int) $request->input('category_id');
        $replaceIndex = $request->input('replace_index');

        $product = Product::with('attributeValues')->findOrFail($request->input('product_id'));
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
            $attrId = (int) $val->pivot->{Product::attributeCategoryPivotColumn()};

            if (in_array($attrId, $requiredAttributeIds, true)) {
               $attrs[$attrId][] = $val->id;
            }
        }

        $selection = session()->get('configurator_build', []);
        $selection[$categoryId] = [
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


    }
