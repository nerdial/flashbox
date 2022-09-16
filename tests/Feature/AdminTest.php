<?php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SellerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class AdminTest extends TestCase
{

    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);


        $this->seed(SellerSeeder::class);

        $this->user = User::factory()
            ->create();


        Sanctum::actingAs(
            $this->user,
            ['*']
        );


    }

    public function test_admin_failed_getting_seller_list_without_roles_and_permissions()
    {

        $url = route('admin.seller.list');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_admin_failed_creating_seller_without_roles_and_permissions()
    {

        $url = route('admin.seller.create');

        $response = $this->post($url);

        $response->assertStatus(403);
    }

    public function test_admin_failed_getting_seller_list_with_wrong_role()
    {

        $url = route('admin.seller.list');

        $this->user->assignRole('seller');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_admin_failed_creating_seller_with_wrong_role()
    {

        $url = route('admin.seller.create');

        $this->user->assignRole('seller');

        $response = $this->post($url,[]);

        $response->assertStatus(403);
    }


    public function test_admin_gets_all_sellers()
    {

        $url = route('admin.seller.list');

        $this->user->assignRole('admin');

        $response = $this->get($url);

        $response->assertStatus(200);
    }

    public function test_admin_gets_all_sellers_and_validate_response()
    {

        $url = route('admin.seller.list');

        $this->user->assignRole('admin');

        $sellersCounted = User::role('seller')->get()->count();

        $response = $this->get($url);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                "*" => [
                    'id', 'name', 'shop'
                ]
            ]
        ])->assertJsonCount($sellersCounted, 'data');
    }

    public function test_admin_creates_new_seller()
    {

        $url = route('admin.seller.create');

        $shop = Shop::factory()->make();

        $seller = User::factory()->make();

        $this->user->assignRole('admin');

        $newSellerData = [
            'name' => $seller->name,
            'shopTitle' => $shop->title,
            'address' => $shop->address,
            'email' => $seller->email,
            'password' => 'password',
            'lng' => $shop->lng,
            'lat' => $shop->lat
        ];
        $response = $this->json('post', $url, $newSellerData);

        $response->assertStatus(201);

        $newSeller = User::where('email', $newSellerData['email'])->first();

        $role = $newSeller->getRoleNames()->first();

        $this->assertDatabaseHas(User::class,[
            'email' => $newSellerData['email']
        ]);
        $this->assertDatabaseHas(Shop::class,[
            'title' => $newSellerData['shopTitle'],
            'seller_id' => $newSeller->id
        ]);

        $this->assertEquals('seller', $role);
    }

    public function test_admin_failed_creating_seller_with_wrong_data()
    {

        $url = route('admin.seller.create');

        $shop = Shop::factory()->make();

        $seller = User::factory()->make();

        $this->user->assignRole('admin');

        $newSellerData = [
            'name' => '',
            'shopTitle' => '',
            'address' => '',
            'email' => '',
            'password' => '',
            'lng' => 1200,
            'lat' => 1400
        ];
        $response = $this->json('post', $url, $newSellerData);

        $response->assertStatus(422);
    }




}
