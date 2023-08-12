<?php

namespace Database\Seeders\Prod;

use App\Models\Admin\Cart\Token;
use App\Models\Admin\Item\Category;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class ItemsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            //$newTableName = 'items_categories2';
            //Schema::dropIfExists($newTableName);
            //Schema::create($newTableName, function (Blueprint $table) {
            //    $table->smallIncrements('id');
            //    $table->string('title')->nullable();
            //    $table->string('img')->nullable();
            //    //$table->unsignedSmallInteger('parent_id')->nullable();
            //    NestedSet::columns($table);
            //    $table->string('slug', 1200)->nullable();
            //    $table->softDeletes();
            //    $table->timestamps();
            //});

            $categories = Category::on('mysql_prod')->withTrashed()->get();
            //dd($categories[0]);

            foreach ($categories as $category) {

                $category = $category->getAttributes();

                Category::create([
                    'id' => $category['id'],
                    'title' =>  $category['title'],
                    'img' => $category['img'],
                    'slug' => $category['slug'],
                    'deleted_at' => $category['deleted_at'],
                    'created_at' => $category['created_at'],
                    'updated_at' => $category['updated_at'],
                    'parent_id' => $category['parent_id'],
                ]);

                //DB::table(Category::getTableName())->insert([
                //    'id' => $category->id,
                //    'title' => $category->title,
                //    'img' => $category->img,
                //    //'_lft' => $category->_lft,
                //    //'_rgt' => $category->_rgt,
                //    'parent_id' => $category->parent_id,
                //    'slug' => $category->slug,
                //    'deleted_at' => $category->deleted_at,
                //    'created_at' => $category->created_at,
                //    'updated_at' => $category->updated_at,
                //]);
            }
            //$this->command->info('Таблица ' . $newTableName . ' удачно создана и наполнена');
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
