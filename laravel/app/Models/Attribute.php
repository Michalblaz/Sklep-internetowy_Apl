<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute as EloquentAttribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Schema;

class Attribute extends Model
{
    protected $appends = ['display_name'];
    public function getTable()
    {
        return Schema::hasTable('attribute_cathegory')
            ? 'attribute_cathegory'
            : 'attribute_category';
    }

    public static function valuesForeignKey(): string
    {
        return Schema::hasColumn('attribute_values', 'attribute_cathegory_id')
            ? 'attribute_cathegory_id'
            : 'attribute_category_id';
    }

    public function categories()
    {
       return $this->belongsToMany(Category::class, 'category_attributes', 'attribute_id', 'category_id');
    }
    public function values()
    {
        return $this->hasMany(AttributeValue::class, self::valuesForeignKey());
    }
    protected function displayName(): EloquentAttribute
    {
        return EloquentAttribute::make(
            get: fn () => $this->translateKey($this->name),

        );
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
    public function formatValue(mixed $value): string
    {
        return match ((string)$value) {
            'true', '1' => 'Posiada',
            'false', '0' => 'Nie posiada',
            default => (string)$value,
        };
    }
}
