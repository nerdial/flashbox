<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;

class CustomerService
{

    public function __construct(
        private ProductRepository     $productRepository,
        private PaypalGateway         $paypalGateway,
        private TransactionRepository $transactionRepository
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
        return $this->transactionRepository->createNewTransaction($product, $user, $data);
    }

}
