<?php

namespace App\Http\Controllers;

use App\Exceptions\MyHttpResponseException;
use App\Http\Resources\ItemResource;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\SettingsResource;
use App\Models\Admin\Cart\CartItem;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Token;
use App\Models\Admin\Item\Category;
use App\Models\Admin\Item\Item;
use App\Models\Admin\Setting;
use App\UseCases\ApiService;
use App\UseCases\SendOrderService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;


/**
 * @property ApiService $service
 * @property SendOrderService $sendOrderService
 */
class ApiController extends Controller
{
    /**
     * @param ApiService $service
     * @param SendOrderService $sendOrderService
     */
    public function __construct(ApiService $service, SendOrderService $sendOrderService)
    {
        $this->service = $service;
        $this->sendOrderService = $sendOrderService;
    }

    /**
     * Метод возвращает товары добавленные в корзину.
     * Принимаем token. Возвращаем json с информацией о товарах в корзине.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cartLoad(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
            ]);

            $oldToken = $request->get('token');
            //Токен может приходить 'null' или (32 символа + быть в бд)
            if (!$this->service->isValidToken($oldToken)) {
                throw new MyHttpResponseException(
                    'Validation error',
                    'Входящий token не равен null или его нет в бд',
                    422
                );
            }

            $tokenIsNull = $oldToken === 'null';
            //Если $tokenIsNull === false, значит входящий токен уже существует в бд, иначе
            //сработало бы исключение MyHttpResponseException

            $json = [
                //needUpdateToken = true - значит токена нет в бд.
                //needUpdateToken = false - значит токен есть в бд
                'needUpdateToken' => $tokenIsNull,
                //возвращаем массив id, cnt товаров, добавленных в корзину
                'cart' => !$tokenIsNull
                    ? Token::firstWhere('token', $oldToken)->rCartItems()->whereHas('rItem')->get()->toArray()
                    : [],
                //возвращаем товары с полным описание для сохранения в Vuex
                'products' => !$tokenIsNull
                    ? ItemResource::collection(Item::find(Token::firstWhere('token', $oldToken)->rCartItems))
                    : [],
                //возвращаем старый или новый токен
                'token' => !$tokenIsNull ? $oldToken : $this->service->generateNewToken($request),
            ];
            return response()->json($json);
        } catch (ValidationException $e) {
            throw new MyHttpResponseException($e->getMessage(), null, 422);
        } catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function addsItemsToCart(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token',
                'id'    => 'required|exists:items,id',
                'cnt'   => 'required|integer|min:1|max:65535',
            ]);

            $token = Token::firstWhere('token', $request->get('token'));
            $item = Item::firstWhere('id', $request->get('id'));
            $cnt = $request->get('cnt');

            $cartItem = new CartItem(['token_id' => $token->id, 'item_id' => $item->id, 'cnt' => $cnt]);
            return response($cartItem->save() ? 'true' : 'false', 200);
        } catch (Exception $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function removeItemsFromCart(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token',
                'id'    => 'required|exists:items,id'
            ]);
            $token = Token::firstWhere('token', $request->get('token'));
            $item = Item::firstWhere('id', $request->get('id'));
            return response($token->rCartItems()->where('item_id', $item->id)->delete() ? 'true' : 'false', 200);
        } catch (Exception $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function setCnt(Request $request)
    {
        //Используем валидацию + try catch в контроллере для отлова ошибок, возникающих с бд во
        // время валидации (exists:carts_tokens и exists:items)
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token',
                'id'    => 'required|exists:items,id',
                'cnt'   => 'required|integer|min:1|max:65535',
            ]);

            $token = Token::firstWhere('token', $request->get('token'));
            $result = $token->rCartItems()
                ->where('item_id', $request->get('id'))
                ->update(['cnt' => $request->get('cnt')]);

            return response($result ? 'true' : 'false', 200);
          //Обрабатывает ошибки валидации
        } catch (ValidationException $e) {
            throw new MyHttpResponseException($e->getMessage(), null, 422);
        }
          //Обрабатывает ошибки связанные с бд
        catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function setOrderInfo(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token',
                'value'    => 'nullable|string:max:255',
            ]);

            // Проверка $request->get('field'). Должен быть равен имени колонки в order_contacts таблице
            $tableName = Contact::getTableName();
            $columnNames = Schema::getColumnListing($tableName);
            $excludedColumns = ['id', 'token_id', 'created_at', 'updated_at', 'deleted_at'];
            $filteredColumns = array_diff($columnNames, $excludedColumns);

            if (!in_array($request->get('field'), $filteredColumns)) {
                throw new MyHttpResponseException('Validation error', null, 422);
            }

            $token = Token::firstWhere('token', $request->get('token'));
            return response(
                $token->contact()->updateOrCreate([], [$request->get('field') => $request->get('value')])
                    ? 'true'
                    : 'false',
                200);

        } catch (ValidationException $e) {
            throw new MyHttpResponseException($e->getMessage(), null, 422);
        }
        catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getBillNumber(Request $request)
    {
        //Если приходит запрос на данный маршрут - значит токен по-любому есть в бд
        //Если токен есть в таблице invoice - вернуть старый bill_number, иначе новый
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token',
            ]);
            $token = Token::firstWhere('token', $request->get('token'));
            //если у токена нет invoice, создаем новый, иначе возвращаем существующий
            $invoice = $this->service->getInvoice($token);
            return response()->json(['bill_number' => $invoice->bill_number]);
        } catch (ValidationException $e) {
            throw new MyHttpResponseException($e->getMessage(), null, 422);
        }
        catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function storeOrder(Request $request)
    {
        //Используем валидацию + try catch в контроллере для отлова ошибок, возникающих с бд во
        // время валидации (exists:carts_tokens)
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'street' => 'required|string|max:255',
                'house_number' => 'required|string|max:255',
                'transport_company' => 'required|string|max:255',
                'token' => 'required|size:32|exists:carts_tokens,token',
                'items' => 'required|array|min:1'
            ]);

            //Проверка, чтобы items из таблицы carts_items соответствовали тем что пришли с фронта для заказа

            $oldToken = Token::firstWhere('token', $request->get('token'));
            $dbArr = $oldToken->rCartItems->toArray();
            $frontArr = $request->get('items');
            //dd($dbArr, $frontArr);

            if (count($dbArr) !== count($frontArr)) {
                throw new MyHttpResponseException('Validation error', null, 422);
            } else {
                foreach ($dbArr as $k => $v) {
                    if (!($dbArr[$k]['id'] === $frontArr[$k]['id'] && $dbArr[$k]['cnt'] === $frontArr[$k]['cnt'])) {
                        throw new MyHttpResponseException('Validation error', null, 422);
                    }
                }
            }

            $items = array_map(fn($item) => ['item_id' => $item['id'], 'cnt' => $item['cnt']], $request->get('items'));
            $oldToken->contact->orders()->createMany($items);
            $newToken = $this->service->generateNewToken($request);
            //Обрабатывает ошибки валидации
        } catch (ValidationException $e) {
            throw new MyHttpResponseException($e->getMessage(), null, 422);
        } catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        } catch (Exception $e) {
            throw new MyHttpResponseException('Error. See logs', $e->getMessage(), 500);
        }

        $this->sendOrderService->sendTelegram($oldToken->contact);
        $this->sendOrderService->sendEmail($oldToken->contact);

        return response()->json([
            'new_token' => $newToken,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loadOrder(Request $request) {
        try {
            $request->validate([
                'token' => 'required|size:32|exists:carts_tokens,token'
            ]);
            $token = Token::firstWhere('token', $request->get('token'));
            $existsContact = $token->contact()->exists();
            $response = $existsContact
                ? $token->contact->only(['name', 'phone', 'city', 'street', 'house_number', 'transport_company'])
                : [];
            return response()->json($response);
        } catch (ValidationException $e) {
            throw new MyHttpResponseException(
                'Validation error',
                $e->getMessage() . "'token' => 'required|size:32|exists:carts_tokens,token'",
                422
            );
        }
        catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getCategories()
    {
        try {
            return CategoriesResource::collection(Category::defaultOrder()->get());
        } catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getSettings()
    {
        try {
            return SettingsResource::collection(
                Setting::whereNotNull('prop_value')
                    ->whereIsIcon(true)
                    ->orWhere('prop_key', 'min_order_cost')
                    ->get()
            );
        } catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function items()
    {
        try {
            return ItemResource::collection(Item::orderByDesc('created_at')->get());
        } catch (QueryException $e) {
            throw new MyHttpResponseException('Database Error. See logs', $e->getMessage(), 500);
        }
    }
}
