<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Category;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class CategoryTasksController extends ApiController
{
    use ApiResponses;

    protected $policyClass = TaskPolicy::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        return TaskResource::collection($category->tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Category $category, StoreTaskRequest $request)
    {
        $model = [
            'user_id' => Auth::user()->id,
            'category_id' => $category->id,
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
        ];

        return new TaskResource($category->tasks()->create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, $task_id)
    {
        $task = Task::findOrFail($task_id);
        if ( $this->isAble('view', $task) ) {
            return new TaskResource($task);
        }
        return $this->error('Task not found.', 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, $task_id, UpdateTaskRequest $request)
    {
        $task = Task::findOrFail($task_id);
        if ( $this->isAble('view', $task) ) {
            $model = [
                'user_id' => Auth::user()->id,
                'category_id' => $request->input('data.relationships.category.data.id'),
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
            ];
            $task->update($model);
            return new TaskResource($task);
        }
        return $this->error('Task not found.', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $task_id)
    {
        $task = Task::findOrFail($task_id);
        if ( $this->isAble('view', $task) ) {
            $task->delete();
            return $this->ok('Task deleted successfully');
        }
        return $this->error('Task not found.', 404);
    }
}
