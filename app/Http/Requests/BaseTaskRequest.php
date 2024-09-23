<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BaseTaskRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.relationships.category.data.id' => 'category_id',
        ], $otherAttributes);

        $attributesToUpdate = [];

        foreach ( $attributeMap as $key => $attribute ) {
            if ( $this->has($key) ) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        $attributesToUpdate['user_id'] = Auth::user()->id;

        return $attributesToUpdate;
    }

    public function messages() : array
    {
        return [
            'data.attributes.status' => 'The data.attributes.status value is invalid. Please use C,P or D.'
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'data.attributes.title' => [
                'description' => "The task's title",
                'example' => 'Buy milk',
            ],
            'data.attributes.description' => [
                'description' => "The task's description",
                'example' => 'Buy milk from the store',
            ],
            'data.attributes.status' => [
                'description' => "The task's status",
                'example' => 'P',
            ],
            'data.relationships.category.data.id' => [
                'description' => "The category associated with the task",
                'example' => '2',
            ],
        ];
    }
}
