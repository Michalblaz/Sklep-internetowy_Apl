<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Attribute extends Model
{
    protected $table = 'attribute_category'; 
    
    public function categories()
    {
       return $this->belongsToMany(Category::class, 'category_attributes', 'attribute_id', 'category_id');
    }
    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_cathegory_id');
    }
}
