<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SellerRepository
{

    public function getAllSellers()
    {
        return User::role('seller')->get()->load('shop');
    }

    public function createNewSeller(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
                'email' => $data['email']
            ]);
            $user->assignRole('seller');
            $user->createToken('vueApp');
            $user->shop()->create([
                'title' => $data['shopTitle'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'address' => $data['address']
            ]);
        }, 2);

    }

}
