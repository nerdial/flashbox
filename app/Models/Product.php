<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'shop_id'
    ];

    protected $casts = [
        'price' => 'float'
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
