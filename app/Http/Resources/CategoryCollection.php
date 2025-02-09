<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // kalau yg extend jasonresource tidak bisa mengakses collection
        return [
            'data' => $this->collection,
            'total' => count($this->collection)//sejajar dengan data
        ];
    }
}
