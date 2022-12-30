<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Category;
use App\Models\Admin\Item\Item;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Item::count() != 0) {
            throw new Exception(Item::getTableName() . ' table is not empty. Stop all seeds!!!');
        }

        //$dir = 'seeders/seeder_data/items_img';
        //if (!Storage::disk('database')->directoryExists($dir)) {
        //    throw new Exception('Directory ' . $dir . ' not exists');
        //}

        //Storage::disk('uploads')->createDirectory('items');


        //File::copyDirectory(Storage::disk('database')->path($dir), Storage::disk('uploads')->path('items'));
        //
        //try {
        //    $file = Storage::disk('database')->get('seeders/seeder_data/items.json');
        //    $json =  json_decode($file);
        //    foreach ($json as $item) {
        //        Item::create([
        //            'title' =>  $item->title,
        //            'article_number' => $item->article_number,
        //            'price' => (float)$item->price1,
        //            'link' => $item->link,
        //            'img' => $item->img,
        //            'category_id' => $item->category_id
        //        ]);
        //    }
        //} catch (Exception $e) {
        //    $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
        //    throw new Exception($errorMsg);
        //}

        Storage::disk('uploads')->deleteDirectory('items');
        Storage::disk('uploads')->createDirectory('items');

        $parentCategories = Category::whereParentId(null)->pluck('id')->toArray();

        foreach ($parentCategories as $parent) {
            for ($i = 1; $i <= 4; $i++) {
                Item::factory()->count(1)
                    ->state(new Sequence(fn()  => ['category_id' => $parent]))
                    ->create();
            }
        }


        $subCategories = Category::whereNotNull('parent_id')->pluck('id')->toArray();

        //Item::factory()->count(64)
        //    ->state(new Sequence(
        //        function ($sequence) use ($subCategories) {
        //            //dump($sequence->index);
        //            return ['category_id' => Arr::random($subCategories)];
        //        }
        //        //fn ($sequence) => ['category_id' => Arr::random($categories)],
        //    ))
        //    ->create();

        foreach ($subCategories as $sub) {
            for ($i = 1; $i <= 5; $i++) {
                Item::factory()->count(1)
                    ->state(new Sequence(fn()  => ['category_id' => $sub]))
                    ->create();
            }
        }




        //Item::factory()->count(Category::whereParentId(null)->count() * 10)
        //    ->state(new Sequence(
        //        function ($sequence) use ($parentCategories) {
        //            //dump($sequence->index);
        //            return ['category_id' => Arr::random($parentCategories)];
        //        }
        //    ))
        //    ->create();
    }
}
