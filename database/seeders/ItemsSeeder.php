<?php

namespace Database\Seeders;

use App\Models\Admin\Item\Item;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

        Storage::disk('uploads')->deleteDirectory('items');
        Storage::disk('uploads')->createDirectory('items');

//        factory(Item::class, 10)->create();
        Item::factory()->count(6)->create();
    }
}
