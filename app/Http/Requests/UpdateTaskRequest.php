<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends BaseTaskRequest
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
        $user_categories = Auth::user()->categories;
        $categories = implode(',', $user_categories->pluck('id')->toArray());
        return [
            'data' => 'required|array',
            'data.attributes' => 'required|array',
            'data.relationships.category.data.id' => 'sometimes|integer|in:' . $categories,
            'data.attributes.title' => 'sometimes|string|max:255',
            'data.attributes.description' => 'nullable|string|max:500',
            'data.attributes.status' => 'sometimes|string|in:C,D,P',
        ];
    }
}
