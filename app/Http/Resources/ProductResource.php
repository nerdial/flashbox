<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => Str::limit($this->description, 50),
            'price' => $this->price,
            'shopName' => optional($this->shop)->title
        ];
    }
}
