<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TaskFilter;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class TaskController extends ApiController
{
    use ApiResponses;


    protected $policyClass = TaskPolicy::class;
    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilter $filters)
    {
        return TaskResource::collection(
            Task::where('user_id', Auth::user()->id)->filter($filters)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return new TaskResource(Task::create($request->mappedAttributes()));
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
        if ($this->isAble('update', $task)){
            $task->update($request->mappedAttributes());
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
