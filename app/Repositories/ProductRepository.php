<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

class ProductRepository
{

    public function createNewProduct(array $data, User $user): Product
    {
        $shopId = $user->shop->id;
        $newProduct = $data + ['shop_id' => $shopId];
        return Product::create($newProduct);
    }

    public function getNearestProducts($lat, $lng)
    {

//        $maxDistance = 10;
//
//        $radius = 3959;


        $shopIds = Shop::select('id')->closestTo($lat, $lng)->pluck('id');

        return Product::select([
            'id', 'title', 'description', 'price', 'shop_id'
        ])->
        whereIn('shop_id', $shopIds)->with('shop:title,id')->get();


    }

}
