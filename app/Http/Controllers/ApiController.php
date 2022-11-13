<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartItemsRequest;
use App\Http\Requests\Cart\CartLoadRequest;
use App\Http\Resources\ItemResource;
use App\Models\Admin\Cart\CartItem;
use App\Models\Admin\Cart\Token;
use App\Models\Admin\Item\Item;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function items()
    {
        try {
            return ItemResource::collection(Item::all());
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    /**
     * @param CartLoadRequest $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function cartLoad(CartLoadRequest $request)
    {
        if ($request->token) {
            $tokenFromRequest = $request->token;

            try {
                if ($tokenFromRequest === 'null') {
                    $newToken = generateToken();
                    Token::create(['token' => $newToken, 'ip' => $request->ip()]);
                    $jsonArr = ['cart' => [], 'needUpdate' => true, 'token' => $newToken];
                } else {
                    $cart = Token::whereToken($tokenFromRequest)->firstOr(function () use ($tokenFromRequest) {
                        throw new HttpResponseException(response('Token ' . $tokenFromRequest . ' not found', 422));
                    })->rCartItems->toArray();

                    $jsonArr = [
                        'cart'       => $cart,
                        'needUpdate' => false,
                        'token'      => $tokenFromRequest
                    ];
                }
                return response()->json($jsonArr);
            } catch (QueryException $e) {
                $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
                throw new HttpResponseException(response($errorMsg, 500));
            }
        }
        return response('Not found', 404);
    }

    /**
     * @param CartItemsRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function addsItemsToCart(CartItemsRequest $request)
    {
        if ($request->token && $request->id) {
            $tokenFromRequest = $request->token;
            $idFromRequest = $request->id;
            try {
                $token = Token::select('id')->whereToken($tokenFromRequest)->firstOr(function () use ($tokenFromRequest
                ) {
                    throw new HttpResponseException(response('Token ' . $tokenFromRequest . ' not found', 422));
                });

                $item = Item::findOr($idFromRequest, function () use ($idFromRequest) {
                    throw new HttpResponseException(response('Item with id ' . $idFromRequest . ' not found', 422));
                });

                $cartItem = new CartItem(['token_id' => $token->id, 'item_id' => $item->id, 'cnt' => 1]);
                //dd($cartItem);
                return response($cartItem->save() ? 'true' : 'false', 200);
            } catch (QueryException $e) {
                $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
                throw new HttpResponseException(response($errorMsg, 500));
            }
        }
        return response('Not found', 404);
    }

    ///**
    // * @param Token $token
    // * @param Item $item
    // * @return Application|ResponseFactory|Response
    // */
    //public function removeItemsFromCart(Token $token, Item $item)
    //{
    //    try {
    //        $result = $item->rCartItems()->whereTokenId($token->id)->delete();
    //        return response($result ? 'true' : 'false', 200);
    //    } catch (QueryException $e) {
    //        $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
    //        throw new HttpResponseException(response($errorMsg, 500));
    //    }
    //}

    /**
     * @param CartItemsRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function removeItemsFromCart(CartItemsRequest $request)
    {
        if ($request->token && $request->id) {
            $tokenFromRequest = $request->token;
            $itemIdFromRequest = $request->id;

            try {
                $token = Token::select('id')->whereToken($tokenFromRequest)->firstOr(function () use ($tokenFromRequest
                ) {
                    throw new HttpResponseException(response('Token ' . $tokenFromRequest . ' not found', 422));
                });

                $result = CartItem::whereTokenId($token->id)->whereItemId($itemIdFromRequest)->delete();
                return response($result ? 'true' : 'false', 200);
            } catch (QueryException $e) {
                $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
                throw new HttpResponseException(response($errorMsg, 500));
            }
        }
        return response('Not found', 404);
    }

    public function test(Token $token, Item $item)
    {
        dump($item);
        dd($token);
    }
}
