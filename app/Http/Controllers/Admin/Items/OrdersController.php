<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Order\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('created_at')->paginate(10);
        //dd(Contact::find(1));
        return view('admin.orders.index', compact('contacts'));
    }
}
