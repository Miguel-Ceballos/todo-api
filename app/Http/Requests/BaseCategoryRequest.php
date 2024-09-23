<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BaseCategoryRequest extends FormRequest
{
    public function mappedAttributes() : array
    {
        return [
            'user_id' => Auth::user()->id,
            'title' => $this->input('data.attributes.title'),
            'slug' => Str::slug($this->input('data.attributes.title'))
        ];
    }

    public function bodyParameters(): array {
        return [
            'data.attributes.title' => [
                'description' => "The category's title",
                'example' => 'Home',
            ],
            'data.attributes.slug' => [
                'description' => "The category's slug",
                'example' => 'home',
            ],
        ];
    }
}
