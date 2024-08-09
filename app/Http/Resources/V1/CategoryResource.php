<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'category',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                $this->mergeWhen($request->routeIs('categories.show'), [
                    'createdAt' => $this->created_at,
                    'updatedAt' => $this->updated_at,
                ])
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ]
                ]
            ],
            'links' => [
                'self' => route('categories.show', ['category' => $this->id])
            ]
        ];
    }
}
