<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Database\Seeders\CartSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @test
     * List all products from client cart
     *
     * @return void
     */
    public function can_list_all_products_from_client_cart()
    {
        Artisan::call('cache:clear');

        $this->seed([
            UserSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
        ]);

        $user = User::find(1);

        $response = $this->get(route('cart.list', $user->id), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * List all products from client cart that have quantity greater than zero
     *
     * @return void
     */
    public function can_list_all_products_quantity_greater_than_zero()
    {
        Artisan::call('cache:clear');

        $this->seed([
            UserSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
        ]);

        Product::find(1)->update(['quantity' => 0]);

        $user = User::find(1);

        $response = $this->get(route('cart.list', $user->id), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                "message" => "Operation success"
            ]);
    }
}
