<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\ProductRepository;

class CustomerService
{

    public function __construct(
        private ProductRepository $productRepository,
        private PaypalGateway     $paypalGateway
    )
    {
    }

    public function findNearbyProducts(User $user)
    {
        $profile = $user->profile;
        $lat = $profile->lat;
        $lng = $profile->lng;
        return $this->productRepository->getNearestProducts($lat, $lng);
    }

    public function purchaseAnItem(Product $product, User $user): Transaction
    {
        $data = $this->paypalGateway->pay();
        return Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'metadata' => $data
        ]);
    }

}
