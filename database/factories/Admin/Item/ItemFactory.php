<?php

namespace Database\Factories\Admin\Item;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Item\Category>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'note' => 'Поставляется в коробке по 12 штук',
            'article_number' => $this->faker->postcode,
            'price' => rand(50, 100),
            'img' => $this->faker->loremflickr(
                Storage::disk('uploads'),
                'items',
                300,
                350,
                'soft_toy'
            ),
            'is_new' => false,
            'is_hit' => false,
            'is_bestseller' => false
        ];
    }
}
