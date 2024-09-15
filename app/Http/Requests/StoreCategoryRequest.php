<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class StoreCategoryRequest extends BaseCategoryRequest
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
        $isCategoryExists = Category::where('slug', Str::slug($this->input('data.attributes.title')))
            ->where('user_id', Auth::user()->id)
            ->exists();
        if ($isCategoryExists) {
            return [
                'data.attributes.title' => 'required|string|max:50|unique:categories,title',
                'data.attributes.slug' => 'string|unique:categories,slug',
            ];
        }

        return [
            'data.attributes.title' => 'required|string|max:50',
            'data.attributes.slug' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'data.attributes.title.unique' => 'The category already exists',
        ];
    }
}
