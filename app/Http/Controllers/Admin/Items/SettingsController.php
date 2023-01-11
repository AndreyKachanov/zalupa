<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\UpdateSettingsRequest;
use App\Models\Admin\Setting;
use Illuminate\Database\QueryException;
use Exception;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings = Setting::all();
        //dd($settings);
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * @param UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function update(UpdateSettingsRequest $request)
    {
        $inputs = $request->except('_token');
        try {
            foreach ($inputs as $key => $input) {
                Setting::wherePropKey($key)->update(['prop_value' => $input]);
            }
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new Exception(response($errorMsg));
        }
        return redirect()->route('admin.settings.index');
    }
}
