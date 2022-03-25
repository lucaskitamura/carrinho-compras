<?php

namespace Tests\Feature;

use App\Models\CreditCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreditCardTest extends TestCase
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
     * Required fields for credit card create
     *
     * @return void
     */
    public function required_fields_for_create()
    {
        $response = $this->post(route('credit-card.store'), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertJson([
            "data" => [
                "card_number" => ["The card number field is required."],
                "holder" => ["The holder field is required."],
                "expiration_date" => ["The expiration date field is required."],
                "security_code" => ["The security code field is required."],
                "brand" => ["The brand field is required."],
            ]
        ]);
    }

    /**
     * @test
     * Create visa credit card
     *
     * @return void
     */
    public function can_create_visa_credit_card()
    {
        $params = [
            'card_number' => $this->faker->creditCardNumber('Visa'),
            'holder' => $this->faker->name,
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Visa'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(201)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * Create mastercard credit card
     *
     * @return void
     */
    public function can_create_mastercard_credit_card()
    {
        $params = [
            'card_number' => $this->faker->creditCardNumber('MasterCard'),
            'holder' => $this->faker->name(),
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Mastercard'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertCreated()
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * Create diners credit card
     *
     * @return void
     */
    public function can_create_diners_credit_card()
    {
        $params = [
            'card_number' => $this->faker->numerify('##############'),
            'holder' => $this->faker->name(),
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Diners'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

            $response
                ->assertCreated()
                ->assertJson([
                    "message" => "Operation success"
                ]);
    }

    /**
     * @test
     * Create diners credit card only with 14 digits card number
     *
     * @return void
     */
    public function can_create_diners_credit_card_only_with_14_digits_card_number()
    {
        $params = [
            'card_number' => $this->faker->numerify('################'),
            'holder' => $this->faker->name(),
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Diners'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "message" => "Invalid credit card: Invalid credit card number digits"
            ]);
    }

    /**
     * @test
     * Create visa credit card only with 16 digits card number
     *
     * @return void
     */
    public function can_create_visa_credit_card_only_with_16_digits()
    {
        $params = [
            'card_number' => $this->faker->numerify('##############'),
            'holder' => $this->faker->name(),
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Visa'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "message" => "Invalid credit card: Invalid credit card number digits"
            ]);
    }

    /**
     * @test
     * Create mastercard credit card only with 16 digits card number
     *
     * @return void
     */
    public function it_can_create_mastercard_credit_card_only_with_16_digits()
    {
        $params = [
            'card_number' => $this->faker->numerify('##############'),
            'holder' => $this->faker->name(),
            'expiration_date' => '06/2025',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Visa'
        ];

        $response = $this->post(route('credit-card.store'), $params, [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "message" => "Invalid credit card: Invalid credit card number digits"
            ]);
    }

    /**
     * @test
     * Required fields for credit card update
     *
     * @return void
     */
    public function required_fields_for_update()
    {
        $creditCard = CreditCard::factory()->create([
            'brand' => 'Visa'
        ]);

        $response = $this->post(route('credit-card.update', $creditCard->id), [
            'Accept' => 'application/json']);

        $response
            ->assertStatus(400)
            ->assertJson([
                "data" => [
                    "card_number" => ["The card number field is required."],
                    "holder" => ["The holder field is required."],
                    "expiration_date" => ["The expiration date field is required."],
                    "security_code" => ["The security code field is required."],
                    "brand" => ["The brand field is required."],
                ]
            ]);
    }

    /**
     * @test
     * Update Visa credit card
     *
     * @return void
     */
    public function it_can_update_visa_credit_card()
    {
        $creditCard = CreditCard::factory()->create([
            'brand' => 'Visa'
        ]);

        $params = [
            'card_number' => $this->faker->numerify('################'),
            'holder' => $this->faker->name(),
            'expiration_date' => '12/2033',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Visa'
        ];

        $response = $this->post(route('credit-card.update', $creditCard->id), $params, [
            'Accept' => 'application/json'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * Update Mastercard credit card
     *
     * @return void
     */
    public function it_can_update_mastercard_credit_card()
    {
        $creditCard = CreditCard::factory()->create([
            'brand' => 'Mastercard'
        ]);

        $params = [
            'card_number' => $this->faker->numerify('################'),
            'holder' => $this->faker->name(),
            'expiration_date' => '12/2033',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Mastercard'
        ];

        $response = $this->post(route('credit-card.update', $creditCard->id), $params, [
            'Accept' => 'application/json'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * Update Diners credit card
     *
     * @return void
     */
    public function it_can_update_diners_credit_card()
    {
        $creditCard = CreditCard::factory()->create([
            'brand' => 'Diners'
        ]);

        $params = [
            'card_number' => $this->faker->numerify('##############'),
            'holder' => $this->faker->name(),
            'expiration_date' => '12/2033',
            'security_code' => $this->faker->numerify('###'),
            'brand' => 'Diners'
        ];

        $response = $this->post(route('credit-card.update', $creditCard->id), $params, [
            'Accept' => 'application/json'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }

    /**
     * @test
     * Delete credit card
     *
     * @return void
     */
    public function it_can_delete_credit_card()
    {
        $creditCard = CreditCard::factory()->create();

        $response = $this->post(route('credit-card.delete', $creditCard->id));

        $response
            ->assertStatus(200)
            ->assertJson([
                "message" => "Operation success"
            ]);
    }
}
