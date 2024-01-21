<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity',
        
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
