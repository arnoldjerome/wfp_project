<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    protected $table = 'add_ons';
    protected $fillable = [
        'food_id',
        'name',
        'price',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
