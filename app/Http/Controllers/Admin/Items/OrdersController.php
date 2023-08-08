<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;
use Exception;

class OrdersController extends Controller
{
    public function index()
    {
        $contacts = Contact::has('orders')
            ->with(['orders.item', 'token.invoice'])
            ->orderByDesc('created_at')
            ->paginate(config('app.pagination_default_value'));
        //dd($contacts);
        return view('admin.orders.index', compact('contacts'));
    }

    public function show(Contact $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * @param Contact $order
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Contact $order) {
        try {
            $order->delete();
            return redirect()->route('admin.orders.index');
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            dd($errorMsg);
        }
    }
}
