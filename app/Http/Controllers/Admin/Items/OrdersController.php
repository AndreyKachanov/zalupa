<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;

class OrdersController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('created_at')->paginate(50);
        //dd($contacts);
        return view('admin.orders.index', compact('contacts'));
    }

    public function show(Contact $order)
    {
        return view('admin.orders.show', compact('order'));
    }
}
