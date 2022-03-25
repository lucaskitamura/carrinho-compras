<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\User;
use App\Models\CreditCard;
use Database\Seeders\CartSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        Artisan::call('cache:clear');

        $this->seed([
            UserSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
        ]);

        CreditCard::factory()->create();
    }

    /**
     * Required fields for sale create
     * @return void
     * @test
     */
    public function required_fields_for_create()
    {
        $response = $this->post(route('sales.store'), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(422)
            ->assertJson([
            "data" => [
                "user_id" => ["The user id field is required."],
                "user_name" => ["The user name field is required."],
                "credit_card_id" => ["The credit card id field is required."]
            ]
        ]);
    }

    /**
     * Create sale
     * @return void
     * @test
     */
    public function can_create_sale()
    {
        $params = [
            'user_id' => 1,
            'user_name' => 'teste',
            'credit_card_id' => 1
        ];

        $response = $this->post(route('sales.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * List sale
     * @test
     * @return void
     */
    public function can_list_sale()
    {
        Sale::factory()->count(5)->create();

        $response = $this->get(route('sales.list'), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * List sale by user id
     * @return void
     * @test
     */
    public function can_list_sale_by_user_id()
    {
        Sale::factory()->count(5)->create();

        $user = User::first();

        $response = $this->get(route('sales.list', $user->id), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                "message" => "Operation success"
            ]);
    }
}
