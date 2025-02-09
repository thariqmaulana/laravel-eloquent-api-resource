<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'value' => ProductResource::collection($this->collection), //data => value =>
            'data' => ProductResource::collection($this->collection),//mengisi value data
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->header('Author', 'thariq');
    }
}
