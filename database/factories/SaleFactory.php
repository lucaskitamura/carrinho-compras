<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'user_name' => $this->faker->name(),
            'credit_card_id' => 1,
            'amount' => $this->faker->randomFloat(2),
            'date' => $this->faker->dateTimeBetween('+0 days', '+2 years')->format('Ymd'),
        ];
    }
}
