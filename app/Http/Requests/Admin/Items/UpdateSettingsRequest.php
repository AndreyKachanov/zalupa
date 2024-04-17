<?php

namespace App\Http\Requests\Admin\Items;

use App\Models\Admin\Item\Item;
use App\Services\SettingsService;
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
            'price_regulation' => [
                'required',
                'integer',
                'min:-1000',
                'max:1000',
                function ($attribute, $value, $fail) {
                    Item::all()->each(function ($item) use ($value, $fail) {
                        $result = ($item->price / 100) * (int)$value + $item->price;
                        if ($result <= 0) {
                            //$fail('Сильно много ебанул в минус! В итоге будут товары с ценой <= 0');
                            $fail('Нельзя так много! Будут товары с отрицательной ценой!');
                        }
                    });
                }
            ],
            'min_order_cost' => 'nullable|numeric|min:1|max:1000000',
            'phone_number' => 'nullable|max:255',
            'instagram' => 'nullable|max:255',
            'whatsapp' => 'nullable|max:255',
            'site' => 'nullable|max:255',
            'viber' => 'nullable|max:255',
            'tiktok' => 'nullable|max:255',
            'youtube' => 'nullable|max:255',
            'custom_text' => 'nullable|max:255'
        ];
    }
}
