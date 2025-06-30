<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $primaryKey = 'id';
    public $timestamps = 'true';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    // Relasi ke AddOn
    public function addOns()
    {
        return $this->hasMany(AddOn::class, 'food_id');
    }

    protected $fillable = [
        'name',
        'description',
        'nutrition_fact',
        'price',
        'category_id',
        'img_url'
    ];

}
