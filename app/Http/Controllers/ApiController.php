<?php

namespace App\Http\Controllers;

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
     * @return JsonResponse
     */
    public function cartLoad(CartLoadRequest $request)
    {
        try {
            if ($request->filled('token')) {
                $oldToken = $request->get('token');
                $issetToken = Token::whereToken($oldToken)->exists();
                $issetToken ?: $newToken = Token::create(['token' => generateToken(), 'ip' => $request->ip()]);
                $json = [
                    'needUpdate' => !$issetToken,
                    'cart'       => $issetToken ? Token::firstWhere('token', $oldToken)->rCartItems->toArray() : [],
                    'token'      => $issetToken ? $oldToken : $newToken->token
                ];
                return response()->json($json);
            }
            throw new HttpResponseException(response('Input token not found', 422));
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    /**
     * @param Token $token
     * @param Item $item
     * @return Application|ResponseFactory|Response
     */
    public function addsItemsToCart(Token $token, Item $item)
    {
        try {
            $cartItem = new CartItem(['token_id' => $token->id, 'item_id' => $item->id, 'cnt' => 1]);
            return response($cartItem->save() ? 'true' : 'false', 200);
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    /**
     * @param Token $token
     * @param Item $item
     * @return Application|ResponseFactory|Response
     */
    public function removeItemsFromCart(Token $token, Item $item)
    {
        try {
            return response($token->rCartItems()->whereItemId($item->id)->delete() ? 'true' : 'false', 200);
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }
}
