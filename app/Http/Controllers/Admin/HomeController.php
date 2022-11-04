<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 25.12.18
 * Time: 14:43
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        //dd(123);
        return view('admin.home');
//        dd(route('admin.items.index'));
//        dd(redirect()->route('admin.items.index'));
//        return redirect()->route('admin.items.index');
    }
}
