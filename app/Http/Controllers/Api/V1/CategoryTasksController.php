<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Category;
use App\Models\Task;
use App\Policies\CategoryTaskPolicy;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class CategoryTasksController extends ApiController
{
    use ApiResponses;

    protected $policyClass = CategoryTaskPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        if ( $this->isAble('viewAny', $category) ) {
            return TaskResource::collection($category->tasks);
        }
        return $this->error('Category Tasks not found.', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Category $category, StoreTaskRequest $request)
    {
        if ( $this->isAble('create', $category) ) {
            return new TaskResource($category->tasks()->create($request->mappedAttributes()));
        }
        return $this->error('Category not found.', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, $task_id)
    {
        if ( $this->isAble('view', $category) ) {
            $task = Task::findOrFail($task_id);
            if ( $category->id === $task->category_id ) {
                return new TaskResource($task);
            }
        }
        return $this->error('Category Task not found.', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, $task_id, UpdateTaskRequest $request)
    {
        if ( $this->isAble('update', $category) ) {
            $task = Task::findOrFail($task_id);
            if ( $category->id === $task->category_id ) {
                $task->update($request->mappedAttributes());
                return new TaskResource($task);
            }
        }
        return $this->error('Category Task not found.', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $task_id)
    {
        if ( $this->isAble('delete', $category) ) {
            $task = Task::findOrFail($task_id);
            if ( $category->id === $task->category_id ) {
                $task->delete();
                return $this->ok('Task deleted successfully');
            }
        }
        return $this->error('Category Task not found.', 404);
    }
}
