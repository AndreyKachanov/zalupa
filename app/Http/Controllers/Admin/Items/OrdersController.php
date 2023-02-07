<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;

class OrdersController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['orders.item', 'token.invoice'])->orderByDesc('created_at')->paginate(config('app.pagination_default_value'));
        //dd($contacts);
        return view('admin.orders.index', compact('contacts'));
    }

    public function show(Contact $order)
    {
        return view('admin.orders.show', compact('order'));
    }
}
