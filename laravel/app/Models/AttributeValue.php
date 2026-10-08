<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, Attribute::valuesForeignKey());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_value_id', 'product_id')
            ->withPivot(Product::attributeCategoryPivotColumn());
    }
}
