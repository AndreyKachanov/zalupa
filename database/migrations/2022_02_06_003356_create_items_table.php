<?php

use App\Models\Admin\Item\Item;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    private $itemsTableName;

    public function __construct()
    {
        $this->itemsTableName = Item::getTableName();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->itemsTableName)) {
            Schema::create($this->itemsTableName, function (Blueprint $table) {
                $table->smallIncrements('id');
                $table->string('title')->nullable();
                $table->string('article_number')->nullable();
                $table->decimal('price', $precision = 8, $scale = 2)->nullable();
                $table->string('link')->nullable();
                $table->string('img')->nullable();
                $table->unsignedSmallInteger('category_id')->nullable();
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
        Schema::dropIfExists($this->itemsTableName);
    }
}
