<?php

use App\Models\Admin\Item\Item;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsForeignKeyCategoryIdForItemsTable extends Migration
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
        Schema::table($this->itemsTableName, function (Blueprint $table) {
            //создаем  индекс для role_id
            $table->index(['category_id'], 'idx_category_id');

            //создаем внешний ключ для role_id поля
            $table->foreign(['category_id'], 'fk_category')
                ->references('id')
                ->on('items_categories')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->itemsTableName, function (Blueprint $table) {
            if (Schema::hasColumn($this->itemsTableName, 'category_id')) {
                $table->dropForeign('fk_category');
                $table->dropIndex('idx_category_id');
            }
        });
    }
}
