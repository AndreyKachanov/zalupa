<?php

namespace Database\Factories\Admin\Cart\Order;

use App\Models\Admin\Cart\Token;
use Database\Factories\Admin\Cart\TokenFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Cart\Order\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dt = $this->faker->dateTimeBetween('-1 week', 'now');
        return [
            'created_at' => $dt,
            'updated_at' => $dt,
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            //'token_id' => Token::factory()
        ];
    }
}
