<?php

namespace App\Services;

use App\Models\Admin\Setting;

class SettingsService
{
    private static ?int $priceIncrease = null;
    private static ?int $priceRegulation = null;

    public static function getPriceIncrease(): ?int
    {
        if (self::$priceIncrease === null) {
            self::$priceIncrease = (int)Setting::firstWhere('prop_key', 'price_increase')->prop_value;
        }
        return self::$priceIncrease;
    }

    public static function getPriceRegulation(): ?int
    {
        if (self::$priceRegulation === null) {
            self::$priceRegulation = (int)Setting::firstWhere('prop_key', 'price_regulation')->prop_value;
        }
        return self::$priceRegulation;
    }
}
