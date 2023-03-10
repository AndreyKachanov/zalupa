<?php

namespace App\Http\Requests\Admin\Items;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'note' => 'string|max:255',
            'article_number' => 'required|string|max:100',
            'price' => 'required|integer',
            'img' => 'required|mimes:jpg,png,jpeg,gif,svg'
        ];
    }
}
