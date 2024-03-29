<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_price', 'status', 'payment_status', 'payment_method',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'total_amount' => 'decimal:2',
    ];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
