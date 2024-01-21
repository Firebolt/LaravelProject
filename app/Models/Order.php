<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'total_amount', 'status',
        
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'total_amount' => 'decimal:2',
        
    ];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
