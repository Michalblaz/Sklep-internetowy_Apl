<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    
    public function shippingMethod()
    {
        return $this->belongsTo(\App\Models\ShippingMethod::class, 'shipping_method_id');
    }
}
