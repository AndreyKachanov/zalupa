<?php

namespace Database\Factories\Admin\Item;

use App\Models\Admin\Item\Category;
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
            'article_number' => $this->faker->postcode,
            'price' => rand(50, 100),
            'link' => '4a9f99dc105',
            // 'img' => 'items/' . $this->faker->image(Storage::disk('uploads')->path('items/'), 300, 350, 'cats', false),
            'img' => $this->faker->loremflickr(
                Storage::disk('uploads'),
                'items',
                300,
                350,
                'cats'
            ),
            'category_id' => rand(1, Category::count())
        ];
    }
}
