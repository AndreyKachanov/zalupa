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
     * @throws Exception
     */
    public function run()
    {
        if (Setting::count() != 0) {
            throw new Exception(Setting::getTableName() . ' table is not empty. Stop all seeds!!!');
        }

        try {
            Setting::create([
                'prop_key' => 'price_increase',
                'prop_value' => '0'
            ]);
            Setting::create([
                'prop_key' => 'phone_number',
                'prop_value' => '+79495468124'
            ]);
            Setting::create([
                'prop_key' => 'instagram',
                'prop_value' => '+79495468124'
            ]);
            Setting::create([
                'prop_key' => 'whatsapp',
                'prop_value' => '+79495468124'
            ]);
            Setting::create([
                'prop_key' => 'site',
                'prop_value' => 'https://yandex.ru/'
            ]);
            Setting::create([
                'prop_key' => 'viber',
                'prop_value' => '+79495468124'
            ]);
            Setting::create([
                'prop_key' => 'tiktok',
                'prop_value' => '+79495468124'
            ]);
            Setting::create([
                'prop_key' => 'youtube',
                'prop_value' => 'https://www.youtube.com/watch?v=x4xCSVl833I&ab_channel=%D0%9E%D0%BB%D0%B5%D0%B3%D0%9F%D0%B0%D1%80%D0%B0%D1%81%D1%82%D0%B0%D0%B5%D0%B2'
            ]);
            Setting::create([
                'prop_key' => 'custom_text',
                'prop_value' => 'Обмен брака'
            ]);
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception($errorMsg);
        }
    }
}
