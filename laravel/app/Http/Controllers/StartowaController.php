<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartowaController extends Controller
{
    public function startowa(Request $request)
    {
        $selectedCategory = $request->query('category_id', $request->query('category'));
        $selectedBrands = $request->input('brands', []);
        $selectedAttrs = $request->input('attrs', []);

        $products = Product::withAvg('reviews', 'rating')
            ->orderByRaw("
            CASE
                WHEN promo_price IS NOT NULL AND promo_price < base_price THEN 0
                ELSE 1
            END
        ")
            ->take(25)
            ->get();

        $promo_products = Product::withAvg('reviews', 'rating')
            ->whereNotNull('promo_price')
            ->whereColumn('promo_price', '<', 'base_price')
            ->take(25)
            ->get();

        $categories = Category::all();
        $selectedCategoryModel = null;
        $brands = Brand::orderBy('name')->get();
        $availableValueIds = [];
        $filterCategories = Category::with(['attributes.values' => function ($query) {
            $query->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
        }])->get();
        $brandsByCategory = Brand::query()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.name', 'products.category_id')
            ->distinct()
            ->orderBy('brands.name')
            ->get()
            ->groupBy('category_id');
        $filterDataByCategory = [
            'allBrands' => Brand::orderBy('name')->get(['id', 'name'])
                ->map(fn ($brand) => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                ])->values(),
            'categories' => $filterCategories
                ->mapWithKeys(function ($category) use ($brandsByCategory) {
                    return [
                        (string) $category->id => [
                            'brands' => $brandsByCategory->get($category->id, collect())
                                ->map(fn ($brand) => [
                                    'id' => $brand->id,
                                    'name' => $brand->name,
                                ])->values(),
                            'attributes' => $category->attributes
                                ->map(fn ($attribute) => [
                                    'id' => $attribute->id,
                                    'name' => $attribute->name,
                                    'display_name' => $this->translateKey($attribute->name),
                                    'values' => $attribute->values
                                        ->map(fn ($value) => [
                                            'id' => $value->id,
                                            'value' => $value->value,
                                        ])->values(),
                                ])->values(),
                        ],
                    ];
                }),
        ];

        $all_products = Product::withAvg('reviews', 'rating')
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            });

        if ($selectedCategory) {
            $selectedCategoryModel = Category::with(['attributes.values' => function ($query) {
                $query->orderByRaw('LENGTH(value) ASC')->orderBy('value', 'asc');
            }])->find($selectedCategory);

            if ($selectedCategoryModel) {
                $selectedCategoryModel->attributes->transform(function ($attribute) {
                    $attribute->display_name = $this->translateKey($attribute->name);

                    return $attribute;
                });

                $brands = Brand::whereHas('products', function ($query) use ($selectedCategory) {
                    $query->where('category_id', $selectedCategory);
                })->orderBy('name')->get();
            }
        }

        if (!empty($selectedAttrs) && $selectedCategory) {
            foreach ($selectedAttrs as $attrId => $valueIds) {
                if (!is_array($valueIds) || empty($valueIds)) {
                    continue;
                }

                if (in_array((int) $attrId, [24, 25, 50], true) && (int) $selectedCategory === 7) {
                    $values = DB::table('attribute_values')->whereIn('id', $valueIds)->pluck('value');
                    $minValue = $values->map(fn ($value) => (float) preg_replace('/[^0-9.]/', '', $value))->min();

                    $all_products->whereHas('attributeValues', function ($query) use ($attrId, $minValue) {
                        $query->where('product_attributes.attribute_category_id', $attrId)
                            ->whereRaw("attribute_values.value ~ '^[0-9]+(\.[0-9]+)?$'")
                            ->whereRaw("CAST(attribute_values.value AS DECIMAL) >= ?", [$minValue]);
                    });
                } elseif ((int) $attrId === 40 && (int) $selectedCategory === 2) {
                    $values = DB::table('attribute_values')->whereIn('id', $valueIds)->pluck('value');
                    $maxValue = $values->map(fn ($value) => (float) preg_replace('/[^0-9.]/', '', $value))->max();

                    $all_products->whereHas('attributeValues', function ($query) use ($attrId, $maxValue) {
                        $query->where('product_attributes.attribute_category_id', $attrId)
                            ->whereRaw("CAST(NULLIF(regexp_replace(attribute_values.value, '[^0-9.]', '', 'g'), '') AS DECIMAL) <= ?", [$maxValue]);
                    });
                } else {
                    foreach ($valueIds as $valueId) {
                        $all_products->whereHas('attributeValues', function ($query) use ($valueId) {
                            $query->where('product_attributes.attribute_value_id', $valueId);
                        });
                    }
                }
            }
        }

        if (!empty($selectedBrands)) {
            $all_products->whereIn('brand_id', $selectedBrands);
        }

        if ($request->filled('min_price')) {
            $all_products->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $all_products->where('base_price', '<=', $request->max_price);
        }

        if ($selectedCategory) {
            $allMatchingProductIds = (clone $all_products)->pluck('id');
            $availableValueIds = DB::table('product_attributes')
                ->whereIn('product_id', $allMatchingProductIds)
                ->distinct()
                ->pluck('attribute_value_id')
                ->toArray();
        }

        switch ($request->query('sort')) {
            case 'price_asc':
                $all_products->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $all_products->orderBy('base_price', 'desc');
                break;
            case 'name_asc':
                $all_products->orderBy('name', 'asc');
                break;
            default:
                $all_products->orderBy('id', 'desc');
                break;
        }

        $all_products = $all_products
            ->paginate(24)
            ->withQueryString();

        return view('startowa', compact(
            'products',
            'promo_products',
            'categories',
            'all_products',
            'selectedCategory',
            'selectedCategoryModel',
            'brands',
            'availableValueIds',
            'filterDataByCategory'
        ));
    }

    private function translateKey(string $key): string
    {
        return match ($key) {
            'socket' => 'Gniazdo',
            'cores' => 'Liczba rdzeni',
            'cpu_type' => 'Typ procesora',
            'threads' => 'Liczba wątków',
            'base_clock' => 'Taktowanie bazowe',
            'boost_clock' => 'Taktowanie Boost',
            'graphics_card_series' => 'Seria karty graficznej',
            'motherboard_chipset' => 'Chipset płyty głównej',
            'board_standard' => 'Standard płyty głównej',
            'ram_type' => 'Typ pamięci RAM',
            'ram_capacity_gb' => 'Pojemność RAM',
            'ram_speed_mhz' => 'Taktowanie RAM',
            'ram_latency_cl' => 'Opóźnienie CL',
            'storage_type' => 'Typ nośnika',
            'storage_capacity_gb' => 'Pojemność dysku',
            'storage_interface' => 'Interfejs',
            'psu_wattage' => 'Moc zasilacza',
            'psu_efficiency_rating' => 'Certyfikat sprawności',
            'psu_standard' => 'Standard zasilacza',
            'case_type' => 'Typ obudowy',
            'max_gpu_length_mm' => 'Maks. długość GPU',
            'max_cpu_cooler_height_mm' => 'Maks. wysokość chłodzenia CPU',
            'connectivity_type' => 'Typ łączności',
            'sensor_type' => 'Typ sensora',
            'switch_type' => 'Typ przełączników',
            'audio_channels' => 'Kanały audio',
            'cooler_type' => 'Typ chłodzenia',
            'network_standard' => 'Standard sieci',
            'interface_type' => 'Typ interfejsu',
            'monitor_resolution' => 'Rozdzielczość',
            'refresh_rate_hz' => 'Częstotliwość odświeżania',
            'panel_type' => 'Typ matrycy',
            'screen_size_inch' => 'Rozmiar ekranu',
            'integrated_gpu' => 'Zintegrowana grafika',
            'connector_type' => 'Typ złącza',
            'chipset_manufacturer' => 'Producent chipsetu',
            'fan_included' => 'Chłodzenie w zestawie',
            'fan_max_tdp' => 'Maks. TDP chłodzenia',
            'GPU_length' => 'Długość karty graficznej',
            'CPU_cooler_height' => 'Wysokość chłodzenia CPU',
            'cpu_generation' => 'Generacja procesora',
            'supported_cpu_generations' => 'Obsługiwane generacje CPU',
            'ram_slots' => 'Liczba slotów RAM',
            'ram_modules' => 'Liczba modułów RAM',
            'gpu_power_connectors' => 'Złącza zasilania GPU',
            'cpu_power_connector' => 'Złącze zasilania CPU',
            'm2_slots' => 'Liczba slotów M.2',
            'radiator_size' => 'Rozmiar radiatora',
            'max_radiator' => 'Maks. rozmiar radiatora',
            default => str_replace('_', ' ', ucfirst($key)),
        };
    }
}
