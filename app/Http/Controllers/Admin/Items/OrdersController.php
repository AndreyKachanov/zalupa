<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Order\Order;

class OrdersController extends Controller
{

    public function index()
    {
        $contacts = Contact::paginate(15);
        return view('admin.orders.index', compact('contacts'));
    }

}
