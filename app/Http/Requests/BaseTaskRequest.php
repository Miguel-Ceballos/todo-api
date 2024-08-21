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

    public function messages()
    {
        return [
            'data.attributes.status' => 'The data.attributes.status value is invalid. Please use C,P or D.'
        ];
    }
}
