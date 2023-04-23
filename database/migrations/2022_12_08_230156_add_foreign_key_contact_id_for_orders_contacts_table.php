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
            //создаем  индекс для contact_id
            $table->index(['contact_id'], 'idx_contact_id');

            //создаем внешний ключ для item_id поля
            $table->foreign(['contact_id'], 'fk_order_contact')
                ->references('id')
                ->on('orders_contacts')
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
            if (Schema::hasColumn($this->tableName, 'contact_id')) {
                $table->dropForeign('fk_order_contact');
                $table->dropIndex('idx_contact_id');
            }
        });
    }
};
