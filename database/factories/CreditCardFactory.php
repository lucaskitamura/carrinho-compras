<?php

namespace Database\Factories;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_number' => $this->faker->creditCardNumber('MasterCard'),
            'holder' => $this->faker->name(),
            'expiration_date' => $this->faker->dateTimeBetween('+0 days', '+2 years')->format('m/Y'),
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Mastercard',
        ];
    }
}
