<?php

namespace Database\Factories\Admin\Item;

use App\Models\Admin\Item\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
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
        //$categories = Category::where('parent_id', '!=', null)->pluck('id')->toArray();
        //dump('test');
        return [
            'title' => $this->faker->jobTitle,
            'article_number' => $this->faker->postcode,
            'price' => rand(50, 100),
            'link' => '4a9f99dc105',
            'img' => $this->faker->loremflickr(
                Storage::disk('uploads'),
                'items',
                300,
                350,
                'cats'
            ),
            //'category_id' => 1
        ];
    }
}
