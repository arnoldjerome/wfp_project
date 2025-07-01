<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'food_id', 'quantity', 'price', 'note'];

    //Relasi
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function addOns()
    {
        return $this->hasMany(OrderItemAddOn::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class, 'add_on_id');
    }
}
