<?php

namespace App\Http\Requests\Cart;

use App\Models\Admin\Cart\Token;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'contact' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'token' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    //токен должен быть null или 32 символа и в бд
                    if (!(Str::length($value) === 32 && Token::firstWhere('token', $value))) {
                        $fail($attribute . ' not valid');
                    }
                }
            ],
            'items' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    $dbArr = Token::firstWhere('token', $this->token)->rCartItems->toArray();
                    $frontArr = $value;

                    if (count($dbArr) !== count($frontArr)) {
                        $fail('The length attribute `' . $attribute . '` !== length cart items in database');
                    } else {
                        foreach ($dbArr as $k => $v) {
                            if (!($dbArr[$k]['id'] === $frontArr[$k]['id'] && $dbArr[$k]['cnt'] === $frontArr[$k]['cnt'])) {
                                $fail('The attribute `' . $attribute . '` not equaled with database');
                            }
                        }
                    }
                }
            ]
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The <b>:attribute</b> field is required',
            'items.min' => 'The :attribute must be at least :min',
            'items.*.id' => 'The :attribute not exists in database'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ])->setStatusCode(422));
    }
}
