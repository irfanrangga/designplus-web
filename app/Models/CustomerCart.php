<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCart extends Model
{
    protected $table = 'customer_cart';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_name',
        'quantity',
        'total_price',
        'color',
        'customer_note'
    ];
}
