<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

class ProductRepository
{


    public function getSellerProducts(User $user)
    {
        return Product::where('shop_id', $user->shop->id)->latest()->get();
    }

    public function createNewProduct(array $data, User $user): Product
    {
        $shopId = $user->shop->id;
        $newProduct = $data + ['shop_id' => $shopId];
        return Product::create($newProduct);
    }

    public function getNearestProducts($lat, $lng)
    {
        $shopIds = Shop::select('id')->closestTo($lat, $lng)->pluck('id');
        return Product::select([
            'id', 'title', 'description', 'price', 'shop_id'
        ])->
        whereIn('shop_id', $shopIds)->latest()->with('shop:title,id')->get();

    }

}
