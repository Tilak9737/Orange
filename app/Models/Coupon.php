<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_order', 'uses_left'];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
    ];
}
