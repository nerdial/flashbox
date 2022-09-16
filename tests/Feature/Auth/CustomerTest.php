<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;


class CustomerTest extends TestCase
{

    use RefreshDatabase;

    private User $user;
    private Shop $shop;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);


        $this->user = User::factory()
            ->create();


        Sanctum::actingAs(
            $this->user,
            ['*']
        );


    }

    public function test_customer_failed_getting_product_list_without_roles_and_permissions()
    {

        $url = route('customer.product.list');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_customer_failed_getting_product_list_with_wrong_role()
    {

        $url = route('customer.product.list');

        $this->user->assignRole('seller');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_customer_failed_purchasing_product_without_roles_and_permissions()
    {

        Shop::factory(1)->has(Product::factory(1))->create([
            'seller_id' => $this->user->id
        ]);
        $product = Product::first();

        $url = route('customer.product.purchase', [
            'product' => $product->id
        ]);

        $response = $this->post($url, []);

        $response->assertStatus(403);
    }

    public function test_customer_failed_purchasing_product_with_wrong_role()
    {

        Shop::factory(1)->has(Product::factory(1))->create([
            'seller_id' => $this->user->id
        ]);
        $this->user->assignRole('seller');

        $product = Product::first();

        $url = route('customer.product.purchase', [
            'product' => $product->id
        ]);

        $response = $this->post($url, []);

        $response->assertStatus(403);
    }


    public function test_customer_purchasing_a_product()
    {

        Shop::factory(1)->has(Product::factory(1))->create([
            'seller_id' => $this->user->id
        ]);
        $this->user->assignRole('customer');

        $product = Product::first();

        $url = route('customer.product.purchase', [
            'product' => $product->id
        ]);

        $response = $this->post($url, []);

        $response->assertStatus(200);

        $this->assertDatabaseHas(Transaction::class, [
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'amount' => $product->price
        ]);

    }


}
