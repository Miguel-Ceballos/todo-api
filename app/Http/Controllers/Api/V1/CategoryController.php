<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CategoryFilter;
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
     * Get all categories
     *
     * @group Managing Categories
     *
     */
    public function index()
    {
        return CategoryResource::collection(Auth::user()->categories);
    }

    /**
     * Create a category
     *
     * Creates a new category for the authenticated user.
     *
     * @group Managing Categories
     * @response 201
     * {
     * "data": {
     * "type": "category",
     * "id": 31,
     * "attributes": {
     * "title": "Test 2",
     * "slug": "test-2"
     * },
     * "relationships": {
     * "user": {
     * "data": {
     * "type": "user",
     * "id": 2
     * }
     * }
     * },
     * "links": {
     * "self": "http://localhost/api/v1/categories/31"
     * }
     * }
     * }
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->mappedAttributes()));
    }

    /**
     * Show a category
     *
     * Displays the specified category.
     *
     * @group Managing Categories
     * @response 201
     * {
     * "data": {
     * "type": "category",
     * "id": 31,
     * "attributes": {
     * "title": "Test 2",
     * "slug": "test-2",
     * "createdAt": "2024-09-23T18:04:38.000000Z",
     * "updatedAt": "2024-09-23T18:04:38.000000Z"
     * },
     * "relationships": {
     * "user": {
     * "data": {
     * "type": "user",
     * "id": 2
     * }
     * }
     * },
     * "links": {
     * "self": "http://localhost/api/v1/categories/31"
     * }
     * }
     * }
     */
    public function show(Category $category, CategoryFilter $filters)
    {
        if ( $this->isAble('view', $category) ) {
            return CategoryResource::collection(
                $category->filter($filters)->get()
            );
        }
        return $this->notAuthorized('You are not authorized to view that category');
    }

    /**
     * Update a category
     *
     * Update the specified category.
     *
     * @group Managing Categories
     * @response 201
     * {
     * "data": {
     * "type": "category",
     * "id": 31,
     * "attributes": {
     * "title": "category updated",
     * "slug": "category-updated"
     * },
     * "relationships": {
     * "user": {
     * "data": {
     * "type": "user",
     * "id": 2
     * }
     * }
     * },
     * "links": {
     * "self": "http://localhost/api/v1/categories/31"
     * }
     * }
     * }
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
     * Delete a category
     *
     * Delete the specified category.
     *
     * @group Managing Categories
     * @response 200
     * {
     * "data": [],
     * "message": "Category deleted successfully",
     * "status": 200
     * }
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
