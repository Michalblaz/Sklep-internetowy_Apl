<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{


    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'base_price',
        'promo_price',
        'stock_quantity',
        'power_draw_w',
        'image_url',
        'isarchival',
        'archivaldate',
    ];

    protected function casts(): array
    {
        return [
            'isarchival' => 'boolean',
            'archivaldate' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('isarchival'), 0);
        });
    }

    public static function attributeCategoryPivotColumn(): string
    {
        return Schema::hasColumn('product_attributes', 'attribute_cathegory_id')
            ? 'attribute_cathegory_id'
            : 'attribute_category_id';
    }

    public function attributes() {

    return $this->belongsToMany(Attribute::class, 'product_attributes')
                ->withPivot('value');
    }
    public function attributeValues() {
   return $this->belongsToMany(
        AttributeValue::class, 'product_attributes', 'product_id', 'attribute_value_id' )
            ->withPivot(self::attributeCategoryPivotColumn());
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    /**
     * Pobiera spersonalizowane rekomendacje produktów na podstawie historii zamówień zalogowanego użytkownika.
     * Metoda statyczna, dostępna w całej aplikacji.
     *
     * @param int $limit Całkowita liczba produktów do zwrócenia (domyślnie 10)
     * @return \Illuminate\Support\Collection
     */
    public static function getPersonalizedRecommendations($limit = 10)
        {
            if (!Auth::check()) {
                return self::getDefaultRecommendations($limit);
            }

            $user = Auth::user();

            // Pobranie ID kategorii z 20 ostatnich przeglądanych produktów
            $recentCategories = DB::table('product_browsing_history')
                ->join('products', 'product_browsing_history.product_id', '=', 'products.id')
                ->where('product_browsing_history.user_id', $user->id)
                ->where('products.isarchival', 0)
                ->latest('product_browsing_history.viewed_at')
                ->take(20)
                ->pluck('products.category_id');

            if ($recentCategories->isEmpty()) {
                return self::getDefaultRecommendations($limit);
            }

            $categoryCounts = $recentCategories->countBy();
            $sortedCategories = $categoryCounts->sortByDesc(fn($count) => $count)->keys();

            $topCategoryId = $sortedCategories->get(0);
            $secondCategoryId = $sortedCategories->get(1);

            $recommendedProducts = collect();

            if ($topCategoryId && !$secondCategoryId) {
                $topProducts = self::with(['brand', 'category'])
                    ->where('category_id', $topCategoryId)
                    ->withAvg('reviews', 'rating')
                    ->orderByRaw('reviews_avg_rating DESC NULLS LAST') 
                    ->orderByDesc('id')
                    ->take($limit)
                    ->get();
                    
                $recommendedProducts = $recommendedProducts->merge($topProducts);
            } else {
                $topCategoryLimit = (int) round($limit * 0.70);
                $secondCategoryLimit = $limit - $topCategoryLimit;

                if ($topCategoryId) {
                    $topProducts = self::with(['brand', 'category'])
                        ->where('category_id', $topCategoryId)
                        ->withAvg('reviews', 'rating')
                        ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                        ->orderByDesc('id')
                        ->take($topCategoryLimit)
                        ->get();
                    $recommendedProducts = $recommendedProducts->merge($topProducts);
                }

                if ($secondCategoryId) {
                    $secondProducts = self::with(['brand', 'category'])
                        ->where('category_id', $secondCategoryId)
                        ->withAvg('reviews', 'rating')
                        ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                        ->orderByDesc('id')
                        ->take($secondCategoryLimit)
                        ->get();
                    $recommendedProducts = $recommendedProducts->merge($secondProducts);
                }
            }

            if ($recommendedProducts->count() < $limit) {
                $missingCount = $limit - $recommendedProducts->count();
                $excludedIds = $recommendedProducts->pluck('id')->toArray();

                $fillerProducts = self::with(['brand', 'category'])
                    ->whereNotIn('id', $excludedIds)
                    ->withAvg('reviews', 'rating')
                    ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                    ->take($missingCount)
                    ->get();

                $recommendedProducts = $recommendedProducts->merge($fillerProducts);
            }

           return $recommendedProducts->sortByDesc(function ($product) {
                return (float) ($product->reviews_avg_rating ?? 0);
            })->values();
        }

        /**
         * Zapasowa metoda (dla gości)
         */
        public static function getDefaultRecommendations($limit)
        {
            return self::with(['brand', 'category'])
                ->withAvg('reviews', 'rating')
                ->orderByRaw('reviews_avg_rating DESC NULLS LAST')
                ->orderByDesc('id')
                ->take($limit)
                ->get();
        }
}
