<?php

namespace Database\Seeders\Prod;

use App\Models\Admin\Cart\Order\Order;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            //$newTableName = 'orders2';
            //Schema::dropIfExists($newTableName);
            //Schema::create($newTableName, function (Blueprint $table) {
            //    $table->smallIncrements('id');
            //    $table->unsignedSmallInteger('item_id');
            //    $table->unsignedSmallInteger('cnt')->comment('Количество товара');
            //    $table->unsignedSmallInteger('contact_id');
            //    $table->softDeletes();
            //    $table->timestamps();
            //});
            //
            //Schema::table($newTableName, function (Blueprint $table) {
            //    //создаем  индекс для item_id
            //    $table->index(['item_id'], 'idx_item_id2');
            //
            //    //создаем внешний ключ для item_id поля
            //    $table->foreign(['item_id'], 'fk_item_items2')
            //        ->references('id')
            //        ->on('items2')
            //        ->onDelete('restrict')
            //        ->onUpdate('restrict');
            //});

            $orders = Order::on('mysql_prod')->withTrashed()->get();
            foreach ($orders as $order) {
                $order = $order->getAttributes();
                DB::table(Order::getTableName())->insert([
                    'id' => $order['id'],
                    'item_id' => $order['item_id'],
                    'cnt' => $order['cnt'],
                    'contact_id' => $order['contact_id'],
                    'deleted_at' => $order['deleted_at'],
                    'created_at' => $order['created_at'],
                    'updated_at' => $order['updated_at'],
                ]);
            }
            //$this->command->info('Таблица ' . $newTableName . ' удачно создана и наполнена');
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
