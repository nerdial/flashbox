<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'lat',
        'lng',
        'title'
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function scopeClosestTo($query, $lat, $lng)
    {
        return $query->orderByRaw(
            '(3959 * acos(cos(radians(' . floatval($lat) . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . floatval($lng) . ')) + sin(radians(' . intval($lat) . ')) * sin(radians(lat)))) ASC'
        );
    }
}
