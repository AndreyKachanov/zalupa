<?php

namespace Database\Seeders;

use App\Models\Admin\Setting;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Setting::count() != 0) {
            throw new Exception(Setting::getTableName() . ' table is not empty. Stop all seeds!!!');
        }

        try {
            Setting::create([
                'prop_key' => 'price_increase',
                'prop_value' => '1'
            ]);
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
