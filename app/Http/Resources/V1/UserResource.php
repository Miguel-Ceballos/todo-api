<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                $this->mergeWhen($request->routeIs('authors.show'), [
                    'emailVerifiedAt' => $this->emailVerifiedAt,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                ])
            ],
            'includes' => [
                'message' => 'todo'
            ],
            'links' => [
                'self' => route('authors.show', $this->id),
            ]
        ];
    }
}
