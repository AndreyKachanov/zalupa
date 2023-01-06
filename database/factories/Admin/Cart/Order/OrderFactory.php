<?php

namespace Database\Factories\Admin\Cart\Order;

use App\Models\Admin\Item\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Cart\Order\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_id' => Item::inRandomOrder()->value('id'),
            'cnt' => $this->faker->randomDigitNotNull
        ];
    }
}
