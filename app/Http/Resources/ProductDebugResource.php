<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDebugResource extends JsonResource
{
    public $additional = [
        'author' => 'thariq' //akan sejajardengan data
        // kalau statis taruh disini
    ];
    public function toArray(Request $request): array
    {
        return [
            // kalau nilainya dinamis maka buat disini
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
            ],
            'server_time' => now()->toDateTimeString()
        ];
    }
}
