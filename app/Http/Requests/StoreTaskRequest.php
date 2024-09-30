<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends BaseTaskRequest
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
        $isTaskController = $this->routeIs('tasks.store');
        $user_categories = Auth::user()->categories;
        $categories = implode(',', $user_categories->pluck('id')->toArray());
//        C: completed, D: Doing, P: Pending
        $rules = [
            'data' => 'required|array',
            'data.attributes' => 'required|array',
            'data.attributes.title' => 'required|string|max:255',
            'data.attributes.description' => 'nullable|string|max:500',
            'data.attributes.status' => 'required|string|in:C,D,P',
            'data.attributes.due_date' => 'nullable|date',
            'data.relationships.category.data.id' => 'required|integer|in:' . $categories
        ];

        if ($isTaskController) {
            $rules['data.relationships'] = 'required|array';
            $rules['data.relationships.category'] = 'required|array';
            $rules['data.relationships.category.data'] = 'required|array';
        }

        return $rules;
    }
}
