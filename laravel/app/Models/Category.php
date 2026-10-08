<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class Category extends Model
{

   public $timestamps = false;
   public function products()
   {
      return $this->hasMany(Product::class, 'category_id');
   }

  public function attributes()
    {
       return $this->belongsToMany(Attribute::class, 'category_attributes', 'category_id', 'attribute_id')
                    ->withPivot('is_required');
    }
}
