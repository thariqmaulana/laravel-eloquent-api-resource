<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourceConditional extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => new CategorySimpleResource($this->whenLoaded('category')),//fn relasi
            'price' => $this->price,
            'is_expensive' => $this->when($this->price > 10000, true, false),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
