<?php

namespace App\Http\Requests\Cart;

use App\Models\Admin\Cart\Token;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class GetInvoiceRequest extends FormRequest
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
            'token' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    //токен должен быть null или 32 символа и в бд
                    //!($value === 'null' || (Str::length($value) === 32 && Token::firstWhere('token', $value))) and $fail($attribute . ' not valid');

                    //$value === 'null' || (Str::length($value) === 32 && Token::firstWhere('token', $value)) ?: $fail($attribute . ' not valid');

                    //!($value === 'null' || (Str::length($value) === 32 && Token::firstWhere('token', $value)))
                    //    ? $fail($attribute . ' not valid')
                    //    : null;

                    //токен должен быть null или 32 символа и в бд
                    if ( !(Str::length($value) === 32 && Token::firstWhere('token', $value)) ) {
                        $fail($attribute . ' not valid');
                    }
                }
            ]
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
