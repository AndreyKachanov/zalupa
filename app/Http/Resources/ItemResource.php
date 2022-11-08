<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'article_number' => $this->article_number,
            'price1' => $this->price1,
            'price2' => $this->price2,
            'price3' => $this->price3,
            'link' => $this->link,
            'img' => Storage::disk('uploads')->url($this->img),
            'category' => $this->category_id
        ];
    }
}
