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
            'phone_number' => 'sometimes|max:255',
            'instagram' => 'sometimes|max:255',
            'whatsapp' => 'sometimes|max:255',
            'site' => 'sometimes|max:255',
            'viber' => 'sometimes|max:255',
            'tiktok' => 'sometimes|max:255',
            'youtube' => 'sometimes|max:255',
            'custom_text' => 'sometimes|max:255'
        ];
    }
}
