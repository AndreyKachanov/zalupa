<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Category;
use Illuminate\Database\Seeder;
use Exception;
use Illuminate\Support\Facades\File;
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

        Storage::disk('uploads')->deleteDirectory('categories');
        Storage::disk('uploads')->createDirectory('categories');

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
            //папка с картинками
            $dir = 'seeders/seeder_data/categories_img';
            if (!Storage::disk('database')->directoryExists($dir)) {
                throw new Exception('Directory ' . $dir . ' not exists');
            }

            //копируем папку в public
            File::copyDirectory(Storage::disk('database')->path($dir), Storage::disk('uploads')->path('categories'));

            $file = Storage::disk('database')->get('seeders/seeder_data/items_categories_new.json');
            $json =  json_decode($file);
            foreach ($json as $item) {
                //if (!isset($item->deleted_at)) {
                //    if ($item->parent_id === null) {
                //        $sorting = Category::whereParentId(null)->max('sorting') + 1;
                //    } else {
                //        $sorting = Category::whereParentId($item->parent_id)->max('sorting') + 1;
                //    }
                    Category::create([
                        'id' => $item->id,
                        'sorting' => !isset($item->deleted_at)
                            ? $item->parent_id === null
                                ? Category::whereParentId(null)->max('sorting') + 1
                                : Category::whereParentId($item->parent_id)->max('sorting') + 1
                            : null,
                        'title' =>  $item->title,
                        //'img' => 'categories/1b84d4bb7c069c7eba13abfa09fa265b.jpg',
                        //'img' => null,
                        'img' => $item->img,
                        'slug' => $item->slug,
                        'deleted_at' => $item->deleted_at,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'parent_id' => $item->parent_id,
                    ]);
                //}
            }

            foreach (Category::whereNull('parent_id')->orderBy('id')->get() as $key => $category) {
                $category->update(['sorting' => $key + 1]);
            }

            //$parentCategories = Category::all();
            //foreach ($parentCategories as $category) {
            //    for ($i = 1; $i <= 10; $i++) {
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
