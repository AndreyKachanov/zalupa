<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Token;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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
        //dd($order->orders[0]);
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

    public function incomplete() {
        try {

            //$tokens = Token::with(['cartItems.item', 'invoice', 'contact.orders'])
            //    ->when(function ($query ) {
            //        $query->whereDoesntHave('contact.orders');
            //    });
            //
            //$tokens->orderByDesc('created_at')->paginate(config('app.pagination_default_value'));
            //dd($tokens);
            //DB::enableQueryLog();
            $tokens = Token::with(['cartItems.item', 'contact', 'invoice'])
                ->whereHas('cartItems')
                ->whereDoesntHave('contact.orders')
                ->orderByDesc('created_at')
                //->get();
            //dd($tokens[0]);
                ->paginate(config('app.pagination_default_value'));
            //dd(DB::getQueryLog());
            //$tokens = Token::with(['cartItems', 'invoice', 'contact.orders'])
            //    ->when(function ($query ) {
            //        $query->whereDoesntHave('contact.orders')->whereHas('cartItems.item', function ($subQuery) {
            //            $subQuery->whereNotNull('price');
            //        });;
            //    })
            //    ->orderByDesc('created_at')
            //    ->paginate(config('app.pagination_default_value'));
        } catch (QueryException $exception) {
            dd($exception->getMessage());
        }


            //->paginate(config('app.pagination_default_value'));
        //dump($token[0]);
        return view('admin.orders.incomplete', compact('tokens'));
    }

    public function showIncomplete(Token $token)
    {
        try {
            $token->load('cartItems.item', 'contact');
            if ($token->contact !== null && $token->contact->orders->isNotEmpty()) {
                return redirect()->route('admin.orders.index');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
        return view('admin.orders.show_incomplete', compact('token'));
    }
}
