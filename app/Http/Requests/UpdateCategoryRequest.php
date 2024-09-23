<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends BaseCategoryRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.attributes' => 'required|array',
            'data.attributes.title' => 'required|string|max:50',
            'data.attributes.slug' => 'string',
            'data.relationships.user.data.id' => ['prohibited'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'data.relationships.user.data.id' => [
                'description' => "The category's user. This is not editable",
                'example' => '2',
            ],
        ];
    }
}
