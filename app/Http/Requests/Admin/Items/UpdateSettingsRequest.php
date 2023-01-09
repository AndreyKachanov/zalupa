<?php

namespace App\Http\Requests\Admin\Items;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'price_increase' => 'required|integer|min:0|max:1000',
            'phone_number' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255'
        ];
    }
}
