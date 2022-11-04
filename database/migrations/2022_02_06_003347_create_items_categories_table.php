<?php

use App\Models\Admin\Item\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsCategoriesTable extends Migration
{
    private $itemCategoryTableName;

    public function __construct()
    {
        $this->itemCategoryTableName = Category::getTableName();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->itemCategoryTableName)) {
            Schema::create($this->itemCategoryTableName, function (Blueprint $table) {
                $table->smallIncrements('id');
                $table->string('title')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->itemCategoryTableName);
    }
}
