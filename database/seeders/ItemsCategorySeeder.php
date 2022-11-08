<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Category;
use Illuminate\Database\Seeder;
use Exception;

class ItemsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Category::count() != 0) {
            throw new Exception(Category::getTableName() . ' table is not empty. Stop all seeds!!!');
        }

        $arr = [
            'Популярные товары',
            'Развивающие',
            'Летающие игрушки',
            'Мягкие игрушки',
            'Игрушечное оружие',
        ];

        foreach ($arr as $item) {
            Category::create(['title' => $item]);
        }

        //        for ($i = 1; $i <= 4; $i++) {
//            ItemCategory::create(['title' => 'Категория для хуйни № ' . $i]);
//        }

//        Category::create(['title' => 'Настольные игры']);
//        Category::create(['title' => 'Развивающие игрушки']);
//        Category::create(['title' => 'Мягкие игрушки']);
    }
}
