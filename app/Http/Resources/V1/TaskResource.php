<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'task',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'due_date' => $this->due_date,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ]
                ],
                'category' => [
                    'data' => [
                        'type' => 'category',
                        'id' => $this->category_id,
                    ]
                ]
            ],
            'includes' => new CategoryResource($this->whenLoaded('category')),
            'links' => [
                'self' => route('tasks.show', ['task' => $this->id])
            ]
        ];
    }
}
