<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\Cart\Order\Order;

return new class extends Migration
{
    private $tableName;

    public function __construct()
    {
        $this->tableName = Order::getTableName();
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            //создаем  индекс для item_id
            $table->index(['item_id'], 'idx_item_id');

            //создаем внешний ключ для item_id поля
            $table->foreign(['item_id'], 'fk_item_items')
                ->references('id')
                ->on('items')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasColumn($this->tableName, 'item_id')) {
                $table->dropForeign('fk_item_items');
                $table->dropIndex('idx_item_id');
            }
        });
    }
};
