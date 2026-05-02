<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $fillable = ['id_users', 'end_time', 'reason'];

    protected $casts = [
        'end_time' => 'datetime',
    ];

    public $timestamps = false;
}
