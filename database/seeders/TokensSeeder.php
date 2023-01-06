<?php

namespace Database\Seeders;

use App\Models\Admin\Cart\Token;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Token::count() != 0) {
            throw new Exception(Token::getTableName() . ' table is not empty. Stop all seeds!!!');
        }
        try {
            Token::factory()
                ->count(100)
                ->create();
            //for ( $i = 0; $i <= 50; $i++ ) {
            //    $token = new Token();
            //    $token->ip = '127.0.0.1';
            //    $token->token = generateToken();
            //    $token->save();
            //}
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
