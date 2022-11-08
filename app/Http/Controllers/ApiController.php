<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Admin\Cart\Cart;
use App\Models\Admin\Cart\Token;
use App\Models\Admin\Item\Item;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function items()
    {
        return ItemResource::collection(Item::all());
    }

    public function load(Request $request)
    {
        //dd($request->all());
        if ($request->token === "null") {
            $token = md5(microtime() . 'salt' . time());
            Token::create(['token' => $token]);

            return response()->json([
                'cart' => [],
                'needUpdate' => true,
                'token' =>  $token
            ]);
        } else {
            return response()->json([
                'cart' => Cart::all(),
                'needUpdate' => false,
                'token' =>  $request->token
            ]);
        }
        //dd($request->token);
        //dd($request);
    }

    public function add(Request $request)
    {
        //dd($token);
        $token = Token::where('token', $request->token)->first()->id;
        Cart::create([
            'token_id' => $token,
            'item_id' => $request->id,
            'cnt' => 1
        ]);
        return response('true', 200);
    }
}
