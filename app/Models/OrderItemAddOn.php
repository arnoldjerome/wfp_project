<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemAddOn extends Model
{
    use HasFactory;

    protected $table = 'order_item_add_on';

    protected $fillable = [
        'order_item_id',
        'add_on_id',
        'quantity',
        'price',
    ];

    // Relasi ke OrderItem
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // Relasi ke AddOn
    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
