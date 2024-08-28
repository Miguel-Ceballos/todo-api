<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{
    use ApiResponses;

    protected $policyClass = CategoryPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Auth::user()->categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if ( $this->isAble('view', $category) ) {
            return new CategoryResource($category);
        }
        return $this->notAuthorized('You are not authorized to view that category');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ( $this->isAble('update', $category) ) {
            $category->update($request->mappedAttributes());
            return new CategoryResource($category);
        }
        return $this->notAuthorized('You are not authorized to update that category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ( $this->isAble('delete', $category) ) {
            $category->delete();
            return $this->ok('Category successfully deleted');
        }
        return $this->notAuthorized('You are not authorized to delete that category');

    }
}
