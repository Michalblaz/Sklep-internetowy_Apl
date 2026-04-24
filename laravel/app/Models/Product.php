<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

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
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function attributes() {
    
    return $this->belongsToMany(Attribute::class, 'product_attributes')
                ->withPivot('value');
    }
}