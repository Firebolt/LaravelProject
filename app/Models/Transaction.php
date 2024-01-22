<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id', 'payment_method', 'status',
        
    ];

    protected $casts = [
        'order_id' => 'integer',
        
    ];
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);

    }
}
