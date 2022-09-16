<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class TransactionRepository
{

    public function createNewTransaction(Product $product, User $user, array $data = null): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'metadata' => $data
        ]);
    }


}
