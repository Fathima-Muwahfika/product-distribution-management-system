<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'category',
        'carton_qty',
        'cost_price',
        'mrp',
        'stock_qty',
        'min_stock_level',
        'source',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function batches()
    {
        return $this->hasMany(StockBatch::class);
    }
}
