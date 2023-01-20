<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'parent_id' => isset($this->parent_id) ? (int)$this->parent_id : null
        ];
    }
}
