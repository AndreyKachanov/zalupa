<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        return view('admin.settings.index');
    }

    public function setPrice() {
        dd(2);
        return view('admin.settings.index');
    }

    public function storePrice(Request $request) {
        dd($request);
    }

}
