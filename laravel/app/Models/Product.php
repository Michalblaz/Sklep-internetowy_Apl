<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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
        'image_url'
    ];

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
}
