<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductPageController extends Controller
{
    public function show(?int $id = null)
    {
        $product = null;
        $specs = collect();
        $reviews = collect();
        $topSpecs = [];
        $rating = 0.0;
        $ratingColorSegments = array_fill(0, 5, 0);

        if ($id !== null) {
            $product = Product::query()
                ->with(['brand', 'category'])
                ->find($id);
        }

        if ($product) {
            $specs = DB::table('product_attributes as pa')
                ->join('attribute_category as ac', 'ac.id', '=', 'pa.attribute_category_id')
                ->leftJoin('attribute_values as av', 'av.id', '=', 'pa.attribute_value_id')
                ->where('pa.product_id', $product->id)
                ->orderBy('ac.name')
                ->get([
                    'ac.name as key',
                    'ac.name as raw_label',
                    'av.value as value',
                ])
                ->map(function ($spec) {
                    return [
                        'label' => $this->translateSpecLabel($spec->raw_label),
                        'value' => $this->translateSpecValue($spec->value),
                    ];
                })
                ->filter(fn ($spec) => filled($spec['value']))
                ->values();

            $reviews = DB::table('reviews as r')
                ->leftJoin('users as u', 'u.id', '=', 'r.user_id')
                ->where('r.product_id', $product->id)
                ->orderByDesc('r.created_at')
                ->get([
                    'r.rating as stars',
                    'r.comment as content',
                    'u.first_name',
                    'u.last_name',
                ])
                ->map(function ($review) {
                    $author = trim(collect([$review->first_name, $review->last_name])->filter()->implode(' '));

                    return [
                        'author' => $author !== '' ? $author : 'Użytkownik',
                        'content' => $review->content,
                        'stars' => (int) $review->stars,
                    ];
                })
                ->filter(fn ($review) => filled($review['content']))
                ->values();

            $rating = round((float) $reviews->avg('stars'), 2);
            $ratingColorSegments = $this->buildRatingSegments($rating);

            $topSpecs = array_values(array_filter([
                ['label' => 'Marka', 'value' => $product->brand->name ?? null],
                ['label' => 'Kategoria', 'value' => $product->category->name ?? null],
                [
                    'label' => 'Stan magazynowy',
                    'value' => isset($product->stock_quantity)
                        ? ((int) $product->stock_quantity === 0 ? 'Brak produktów w magazynie' : $product->stock_quantity)
                        : null,
                ],
                [
                    'label' => 'Pobór mocy',
                    'value' => filled($product->power_draw_w) && (int) $product->power_draw_w !== 0
                        ? $product->power_draw_w . ' W'
                        : null,
                ],
            ], fn ($spec) => filled($spec['value'])));

            if (empty($topSpecs) && $specs->isNotEmpty()) {
                $topSpecs = $specs->take(4)->all();
            }
        }

        $currentPrice = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price
            ? (float) $product->promo_price
            : ($product ? (float) $product->base_price : null);

        $originalPrice = $product ? (float) $product->base_price : null;
        $hasPromotion = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price;
        $discountPercent = $hasPromotion && $originalPrice > 0
            ? (int) round((($originalPrice - $currentPrice) / $originalPrice) * 100)
            : 0;
        $imagePath = $product && filled($product->image_url)
            ? asset('images/' . ltrim($product->image_url, '/'))
            : null;

        return view('produkt', [
            'product' => $product,
            'specs' => $specs,
            'reviews' => $reviews,
            'topSpecs' => $topSpecs,
            'rating' => $rating,
            'ratingColorSegments' => $ratingColorSegments,
            'currentPrice' => $currentPrice,
            'originalPrice' => $originalPrice,
            'hasPromotion' => $hasPromotion,
            'discountPercent' => $discountPercent,
            'imagePath' => $imagePath,
            'description' => null,
        ]);
    }

    private function buildRatingSegments(float $rating): array
    {
        $segments = [];

        for ($segment = 0; $segment < 5; $segment++) {
            $segmentFill = max(0, min(1, $rating - $segment));
            $segments[] = $segmentFill >= 1
                ? 1
                : ($segmentFill <= 0 ? 0 : round(floor($segmentFill * 10) / 10, 1));
        }

        return $segments;
    }

    private function translateSpecValue($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        return match (strtolower($value)) {
            'true' => 'Tak',
            'false' => 'Nie',
            default => $value,
        };
    }

    private function translateSpecLabel(string $key): string
    {
        return match ($key) {
            'storage_capacity_gb' => 'Pojemność (GB)',
            'storage_interface' => 'Interfejs',
            'storage_type' => 'Typ nośnika',
            'storage_read_speed_mb_s' => 'Prędkość odczytu (MB/s)',
            'storage_write_speed_mb_s' => 'Prędkość zapisu (MB/s)',
            'storage_form_factor' => 'Format',
            'storage_controller' => 'Kontroler',
            'storage_has_heatsink' => 'Radiator',
            'ram_capacity_gb' => 'Pojemność (GB)',
            'ram_modules_count' => 'Liczba modułów',
            'ram_latency_cl' => 'Opóźnienie (CL)',
            'ram_type' => 'Typ pamięci',
            'ram_speed_mhz' => 'Taktowanie (MHz)',
            'cpu_cores' => 'Liczba rdzeni',
            'cpu_threads' => 'Liczba wątków',
            'cpu_base_clock_ghz' => 'Taktowanie bazowe (GHz)',
            'cpu_boost_clock_ghz' => 'Taktowanie turbo (GHz)',
            'base_clock' => 'Taktowanie bazowe (MHz)',
            'boost_clock' => 'Taktowanie turbo (MHz)',
            'cores' => 'Liczba rdzeni',
            'threads' => 'Liczba wątków',
            'cpu_type' => 'Typ procesora',
            'fan_included' => 'Chłodzenie w zestawie',
            'integrated_gpu' => 'Zintegrowany układ graficzny',
            'socket' => 'Socket',
            'gpu_memory_gb' => 'Pamięć VRAM (GB)',
            'gpu_chipset' => 'Chipset',
            'gpu_length_mm' => 'Długość (mm)',
            'psu_power_w' => 'Moc zasilacza (W)',
            'psu_wattage' => 'Moc zasilacza (W)',
            'psu_efficiency_rating' => 'Sprawność',
            'psu_standard' => 'Standard zasilacza',
            'motherboard_socket' => 'Socket',
            'motherboard_chipset' => 'Chipset',
            'board_standard' => 'Format płyty',
            'case_form_factor' => 'Obsługiwany format płyty',
            'case_type' => 'Typ obudowy',
            'max_gpu_length_mm' => 'Maks. długość GPU (mm)',
            'max_cpu_cooler_height_mm' => 'Maks. wysokość chłodzenia CPU (mm)',
            'graphics_card_series' => 'Seria karty graficznej',
            'chipset_manufacturer' => 'Producent chipsetu',
            'connector_type' => 'Typ złącza',
            'connectivity_type' => 'Typ łączności',
            'sensor_type' => 'Typ sensora',
            'switch_type' => 'Typ przełączników',
            'audio_channels' => 'Kanały audio',
            'cooler_type' => 'Typ chłodzenia',
            'network_standard' => 'Standard sieciowy',
            'interface_type' => 'Typ interfejsu',
            'monitor_resolution' => 'Rozdzielczość',
            'refresh_rate_hz' => 'Częstotliwość odświeżania (Hz)',
            'panel_type' => 'Typ matrycy',
            'screen_size_inch' => 'Przekątna ekranu (cale)',
            'fan_max_tdp' => 'Maks. TDP chłodzenia (W)',
            default => $key,
        };
    }
}
