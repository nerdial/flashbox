<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SellerTest extends TestCase
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


        $this->shop = Shop::factory(1)->has(
            Product::factory(10)
        )->create([
            'seller_id' => $this->user->id
        ])->first();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );


    }

    public function test_seller_failed_getting_product_list_without_roles_and_permissions()
    {

        $url = route('seller.product.list');

        $response = $this->get($url);

        $response->assertStatus(403);
    }


    public function test_seller_failed_creating_product_without_roles_and_permissions()
    {

        $url = route('seller.product.create');

        $response = $this->post($url);

        $response->assertStatus(403);
    }

    public function test_seller_failed_getting_product_list_with_wrong_role()
    {

        $url = route('seller.product.list');

        $this->user->assignRole('admin');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_seller_failed_creating_product_list_with_wrong_role()
    {

        $url = route('seller.product.create');

        $this->user->assignRole('admin');

        $response = $this->post($url);

        $response->assertStatus(403);
    }

    public function test_seller_gets_all_products()
    {

        $url = route('seller.product.list');

        $this->user->assignRole('seller');

        $response = $this->get($url);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'price', 'shopName']
                ]
            ])
            ->assertJsonCount(10, 'data');
    }


    public function test_seller_creates_new_product()
    {

        $url = route('seller.product.create');

        $product = Product::factory()->make();

        $this->user->assignRole('seller');

        $newProduct = [
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
        ];
        $response = $this->json('post', $url, $newProduct);

        $response->assertStatus(201);

        $this->assertDatabaseHas(Product::class, [
            'shop_id' => $this->shop->id,
            'title' => $newProduct['title']
        ]);
        $this->assertDatabaseCount(Product::class, 11);
    }

    public function test_seller_failed_creating_new_product_with_wrong_data()
    {

        $url = route('seller.product.create');

        $this->user->assignRole('seller');

        $newProduct = [
            'title' => '',
            'description' => '',
            'price' => '',
        ];
        $response = $this->json('post', $url, $newProduct);
        $response->assertStatus(422);
    }


}
