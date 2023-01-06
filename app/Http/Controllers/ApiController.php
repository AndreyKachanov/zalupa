<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Items\CategoryController;
use App\Http\Requests\Cart\CartLoadRequest;
use App\Http\Requests\Cart\CheckTokenRequest;
use App\Http\Requests\Cart\StoreOrderRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\CategoriesResource;
use App\Models\Admin\Cart\CartItem;
use App\Models\Admin\Cart\Invoice;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Token;
use App\Models\Admin\Item\Category;
use App\Models\Admin\Item\Item;
use App\UseCases\ApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function __construct(ApiService $service)
    {
        $this->service = $service;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function items()
    {
        try {
            //return ItemResource::collection(Item::paginate(20));
            return ItemResource::collection(Item::paginate(3));
            //return Item::paginate(11);
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
                //$issetToken ?: $newToken = Token::create(['token' => generateToken(), 'ip' => $request->ip()]);
                if (!$issetToken) {
                    $newToken = $this->generateNewToken($request);
                }
                $json = [
                    'needUpdate' => !$issetToken,
                    'cart'       => $issetToken ? Token::firstWhere('token', $oldToken)->rCartItems->toArray() : [],
                    'products' => $issetToken
                        ? ItemResource::collection(Item::find(Token::firstWhere('token', $oldToken)->rCartItems->modelKeys()))
                        : [],
                    'token'      => $issetToken ? $oldToken : $newToken->token
                ];
                return response()->json($json);
            }
            throw new HttpResponseException(response("Input field 'token' not found", 422));
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
    public function addsItemsToCart(Token $token, Item $item, int $cnt)
    {
        //dd($cnt);
        try {
            $cartItem = new CartItem(['token_id' => $token->id, 'item_id' => $item->id, 'cnt' => $cnt]);
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

    /**
     * @param Token $token
     * @param Item $item
     * @param int $cnt
     * @return Application|ResponseFactory|Response
     */
    public function setCnt(Token $token, Item $item, int $cnt)
    {
        try {
            return response($token->rCartItems()
                ->whereItemId($item->id)
                ->update(['cnt' => $cnt]) ? 'true' : 'false', 200);
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    public function getBillNumber(CheckTokenRequest $request)
    {
        //Если приходит запрос на этот роут, значит токен полюбому есть в бд
        //Если токен есть в таблице invoice - вернуть старый bill_number, иначе новый
        try {
            $token = Token::firstWhere('token', $request->get('token'));
            //если у токена нет invoice, создаем новый, иначе возвращаем существующий
            $invoice = $this->getInvoice($token);
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
        return response()->json(['bill_number' => $invoice->bill_number]);
    }

    /**
     * @param StoreOrderRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function storeOrder(StoreOrderRequest $request)
    {
        $oldToken = Token::firstWhere('token', $request->token);
        $items = array_map(fn($item) => ['item_id' => $item['id'], 'cnt' => $item['cnt']], $request->items);

        DB::beginTransaction();
        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->contact = $request->contact;
            $contact->email = $request->email;
            $contact->token()->associate($oldToken);
            $contact->save();
            $contact->orders()->createMany($items);
            DB::commit();
            $newToken = $this->generateNewToken($request);
            //$invoice = $this->getInvoice($newToken);
        } catch (QueryException $e) {
            DB::rollback();
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
        return response()->json([
            'new_token' => $newToken->token,
            //'new_bill_number' => $invoice->bill_number
        ]);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getCategories()
    {
        try {
            //return ParentsCategoriesResource::collection(Category::whereParentId(null)->get());
            return CategoriesResource::collection(Category::all());
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    //Selection items from the category + from subcategories.
    public function getItemsFromParentCategoryAndSubcategories(Category $category)
    {
        //dd($category->children[0]->items);
        try {
            $items = Item::whereHas('rCategory', function ($query) use ($category) {
                /** @var Category $query */
                $query->whereParentId($category->id)
                    ->orWhere('id', $category->id);
            })->paginate(4);
            //})->paginate(2);
            //dd($items->pluck('category_id')->toArray());

            return ItemResource::collection($items);

            //return ItemResource::collection($category->children[0]->items);
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    /**
     * //Selection items from the category
     * @param Category $category
     * @return AnonymousResourceCollection
     */
    public function getItemsFromCategory(Category $category)
    {
        //dd($request->page);
        try {
            return ItemResource::collection(Item::whereCategoryId($category->id)
                ->paginate(config('app.pagination_default_value')));
            //->paginate(config('app.pagination_default_value'), ['*'], 'page', 4));
        } catch (QueryException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    /**
     * @param Request $request
     * @return Token|\Illuminate\Database\Eloquent\Model
     */
    private function generateNewToken(Request $request): Token
    {
        return Token::create(['token' => generateToken(), 'ip' => $request->ip()]);
    }

    /**
     * @param Token $token
     * @return Invoice
     */
    private function getInvoice(Token $token): Invoice
    {
        return !$token->invoice
            ? Invoice::create([
                'bill_number' => $this->service->getInvoiceNumber(),
                'token_id' => $token->id
            ])
            : $token->invoice;
    }
}
