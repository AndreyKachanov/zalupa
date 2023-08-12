<?php

namespace Database\Seeders\Prod;

use App\Models\Admin\Cart\Token;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartTokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            //$newTableName = 'carts_tokens2';
            //
            //Schema::table('orders_contacts2', function (Blueprint $table) {
            //    if (Schema::hasColumn('orders_contacts2', 'token_id')) {
            //        if (Schema::hasForeign('orders_contacts2', 'fk_token_orders_contacts2')) {
            //            $table->dropForeign('fk_token_orders_contacts2');
            //        }
            //
            //        //$table->dropIndex('idx_token_id2');
            //    }
            //});

            //Schema::table('cart_items2', function (Blueprint $table) {
            //    if (Schema::hasColumn('cart_items2', 'token_id')) {
            //        $table->dropForeign('fk_token2');
            //        $table->dropIndex('idx_token_id2');
            //    }
            //});

            //Schema::dropIfExists($newTableName);
            //
            //Schema::create($newTableName, function (Blueprint $table) {
            //    $table->smallIncrements('id');
            //    $table->string('token', 64)->unique();
            //    $table->ipAddress('ip')->nullable();
            //    $table->timestamps();
            //});
            $tokens = Token::on('mysql_prod')->get();
            foreach ($tokens as $token) {
                DB::table(Token::getTableName())->insert([
                    'id' => $token->id,
                    'token' => $token->token,
                    'ip' => $token->ip,
                    'created_at' => $token->created_at,
                    'updated_at' => $token->updated_at,
                ]);
            }
            //$this->command->info('Таблица ' . $newTableName . ' удачно создана и наполнена');
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
