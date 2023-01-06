<?php

namespace Database\Factories\Admin\Cart;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Cart\Token>
 */
class TokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'token' => $this->faker->unique()->md5(),
            'ip' => $this->faker->ipv4,
        ];
    }
}
