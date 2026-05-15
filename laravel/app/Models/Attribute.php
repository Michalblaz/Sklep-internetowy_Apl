<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Schema;

class Attribute extends Model
{
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
}
