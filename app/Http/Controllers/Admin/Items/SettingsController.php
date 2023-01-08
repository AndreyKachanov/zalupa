<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\StorePriceRequest;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $request->flash();
        $priceIncrease = (int)Setting::firstWhere('prop_key', 'price_increase')->prop_value;
        return view('admin.settings.index', compact('priceIncrease'));
    }

    public function editPrice()
    {
        $priceIncrease = (int)Setting::firstWhere('prop_key', 'price_increase')->prop_value;
        return view('admin.settings.edit_price', compact('priceIncrease'));
    }

    /**
     * @param StorePriceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePrice(StorePriceRequest $request)
    {
        $request->flash();
        $newPriceIncrease = (int)$request->price_increase;
        Setting::firstWhere('prop_key', 'price_increase')->update(['prop_value' => $newPriceIncrease]);
        return redirect()->route('admin.items.index');
    }
}
