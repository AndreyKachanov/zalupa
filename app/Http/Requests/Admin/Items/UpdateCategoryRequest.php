<?php

namespace App\Http\Requests\Admin\Items;

use App\Models\Admin\Item\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'img' => 'mimes:jpg,png,jpeg,gif,svg',
            'parent' => [
                'nullable',
                'integer',
                'exists:items_categories,id',
                function ($attribute, $value, $fail) {
                    $currentCat = $this->route('category');
                    $selectCat = Category::find($value);
                    if ($selectCat->isDescendantOf($currentCat)) {
                        $fail('Родителем данной категории не может быть её же потомок');
                    }
                    if ($selectCat->id === $currentCat->id) {
                        $fail('Невозможно переместить узел в себя');
                    }
                }
            ],
        ];
    }
}
