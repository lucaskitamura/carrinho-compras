<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::truncate();

        $json = '[
            {
                "user_id": 1,
                "product_id": 1,
                "quantity": 6
            },
            {
                "user_id": 1,
                "product_id": 2,
                "quantity": 10
            },
            {
                "user_id": 1,
                "product_id": 3,
                "quantity": 8
            },
            {
                "user_id": 1,
                "product_id": 4,
                "quantity": 1
            },
            {
                "user_id": 1,
                "product_id": 5,
                "quantity": 7
            },
            {
                "user_id": 1,
                "product_id": 6,
                "quantity": 3
            },
            {
                "user_id": 2,
                "product_id": 1,
                "quantity": 6
            },
            {
                "user_id": 2,
                "product_id": 2,
                "quantity": 6
            },
            {
                "user_id": 2,
                "product_id": 3,
                "quantity": 2
            },
            {
                "user_id": 2,
                "product_id": 4,
                "quantity": 2
            },
            {
                "user_id": 2,
                "product_id": 5,
                "quantity": 9
            },
            {
                "user_id": 2,
                "product_id": 6,
                "quantity": 10
            }
          ]';

        $carts = json_decode($json);

        foreach ($carts as $value) {
            Cart::create([
                "user_id" => $value->user_id,
                "product_id" => $value->product_id,
                "quantity" => $value->quantity,
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
