<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\TaskResource;
use App\Models\Category;
use App\Models\Task;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryTasksController extends Controller
{
    use ApiResponses;
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
        if ($task->category_id === $category->id){
            return new TaskResource($task);
        }
        return $this->error('Task not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $task_id)
    {
        $task = Task::findOrFail($task_id);
        if ($task->category_id === $category->id){
            $task->delete();
            return $this->ok('Task deleted successfully');
        }
        return $this->error('Task not found', 404);
    }
}
