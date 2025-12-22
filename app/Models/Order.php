<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'number', 'total_price', 'payment_status', 'order_status', 'snap_token'
    ];

    //Order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //Order milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
