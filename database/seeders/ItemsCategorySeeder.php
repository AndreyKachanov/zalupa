<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Category;
use Illuminate\Database\Seeder;
use Exception;
use Illuminate\Support\Facades\Storage;

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

        //$arr = [
        //    'Популярные товары',
        //    'Развивающие',
        //    'Летающие игрушки',
        //    'Мягкие игрушки',
        //    'Игрушечное оружие',
        //];
        //
        //foreach ($arr as $item) {
        //    Category::create(['title' => $item]);
        //}
        try {
            $file = Storage::disk('database')->get('seeders/seeder_data/items_categories_new.json');
            $json =  json_decode($file);
            foreach ($json as $item) {
                Category::create([
                    'id' => $item->id,
                    'title' =>  $item->title,
                    'slug' => $item->slug,
                    'deleted_at' => $item->deleted_at,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'parent_id' => $item->parent_id,
                ]);
            }

            //$parentCategories = Category::all();
            //foreach ($parentCategories as $category) {
            //    for ($i = 1; $i <= 2; $i++) {
            //        Category::create([
            //            'title' =>  'Sub ' . $i . ', main - ' . $category->title,
            //            'parent_id' => $category->id
            //        ]);
            //    }
            //}

        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
