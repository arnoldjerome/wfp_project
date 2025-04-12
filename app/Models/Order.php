<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'order_number', 'status', 'total_price',
        'payment_method_id', 'payment_status', 'discount_id',
        'discount_amount', 'final_price', 'ordered_at'
    ];

    public static function generateOrderNumber(): string
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'ORD-' . $date;

        $lastOrder = self::where('order_number', 'like', "$prefix-%")
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "$prefix-$newNumber";
    }

    //Relasi
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod() {
        return $this->belongsTo(Payment::class, 'payment_method_id');
    }

    public function discount() {
        return $this->belongsTo(Discount::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
