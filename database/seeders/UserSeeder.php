<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $latitude = 35.689198;
        $longitude = 51.388973;



        $admin = User::factory(1)->create([
            'email' => 'admin@test.com'
        ])
            ->first();
        $admin->createToken('vueApp');
        $admin->assignRole('admin');


        #---------------------------------------------------


        $seller = User::factory(1)->create([
            'email' => 'seller@test.com'
        ])->first();

        $admin->createToken('vueApp');
        $seller->assignRole('seller');

        $shop = Shop::create([
            'title' => 'Shop 1',
            'lat' => $latitude,
            'lng' => $longitude,
            'seller_id' => $seller->id
        ]);

        Product::factory(10)->create([
            'shop_id' => $shop->id
        ]);

        #---------------------------------------------------

        $customer = User::factory(1)->create([
            'email' => 'customer@test.com'
        ])->first();
        $customer->profile()->create([
            'lat' => $latitude,
            'lng' => $longitude,
        ]);
        $customer->assignRole('customer');


    }
}
