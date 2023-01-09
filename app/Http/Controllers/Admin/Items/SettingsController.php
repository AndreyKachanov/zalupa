<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\UpdateSettingsRequest;
use App\Models\Admin\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $priceIncrease = (int)Setting::firstWhere('prop_key', 'price_increase')->prop_value;
        $phoneNumber = Setting::firstWhere('prop_key', 'phone_number')->prop_value;
        $instagram = Setting::firstWhere('prop_key', 'instagram')->prop_value;
        $whatsapp = Setting::firstWhere('prop_key', 'whatsapp')->prop_value;
        $site = Setting::firstWhere('prop_key', 'site')->prop_value;
        $viber = Setting::firstWhere('prop_key', 'viber')->prop_value;
        $tiktok = Setting::firstWhere('prop_key', 'tiktok')->prop_value;
        $youtube = Setting::firstWhere('prop_key', 'youtube')->prop_value;
        $customText = Setting::firstWhere('prop_key', 'custom_text')->prop_value;
        return view('admin.settings.index',
            compact(
                'priceIncrease',
                'phoneNumber',
                'instagram',
                'whatsapp',
                'site',
                'viber',
                'tiktok',
                'youtube',
                'customText'
            )
        );
    }

    /**
     * @param UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSettingsRequest $request)
    {
        $inputs = $request->only([
            'price_increase',
            'phone_number',
            'instagram',
            'whatsapp',
            'site',
            'viber',
            'tiktok',
            'youtube',
            'custom_text'
        ]);
        foreach ($inputs as $key => $input) {
            Setting::wherePropKey($key)->update(['prop_value' => $input]);
        }
        return redirect()->route('admin.settings.index');
    }
}
