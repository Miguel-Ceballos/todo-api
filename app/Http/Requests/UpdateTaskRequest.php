<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        $user_categories = $this->user()->categories;
        $categories = implode(',', $user_categories->pluck('id')->toArray());
        return [
            'data.relationships.user.data.id' => 'prohibited',
            'data.relationships.category.data.id' => 'required|integer|in:' . $categories,
            'data.attributes.title' => 'required|string|max:255',
            'data.attributes.description' => 'string|max:500',
            'data.attributes.status' => 'required|string|in:C,D,P',
        ];
    }
}
