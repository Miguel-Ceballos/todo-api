<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class TaskController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TaskResource::collection(Auth::user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $model = [
            'user_id' => Auth::user()->id,
            'category_id' => $request->input('data.relationships.category.data.id'),
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
        ];

        return new TaskResource(Task::create($model));

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if ($this->isAble('view', $task)){
            return new TaskResource($task);
        }
        return $this->notAuthorized('You are not authorized to view this task');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // PATCH Request
        if ($this->isAble('update', $task)){
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
        return $this->notAuthorized('You are not authorized to update this task');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($this->isAble('delete', $task)){
            $task->delete();
            return $this->ok('Task successfully deleted');
        }
        return $this->notAuthorized('You are not authorized to delete this task');
    }
}
