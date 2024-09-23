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
     * Get all tasks
     *
     * @group Managing Tasks
     * @queryParam sort string Data field(s) to sort by. Multiple fields can be specified by separating them with a comma. Denote descending sort with a minis (-) sign. Example: sort=-created_at,title
     * @queryParam filter[status] Filter by status code: C: completed, D: Doing, P: Pending. No-example
     * @queryParam filter[title] Filter by title. Wildcards ares supported. Example: filter[title]=*test*
     *
     */
    public function index(TaskFilter $filters)
    {
        return TaskResource::collection(
            Task::where('user_id', Auth::user()->id)->filter($filters)->get()
        );
    }

    /**
     * Create a task
     *
     * Creates a new task for the authenticated user.
     *
     * @group Managing Tasks
     * @response 201 {
     * "data": {
     *  "type": "task",
     *  "id": 602,
     *  "attributes": {
     *      "title": "Task test",
     *      "description": "Task description",
     *      "status": "P",
     *      "created_at": "2024-09-23T17:16:52.000000Z",
     *      "updated_at": "2024-09-23T17:16:52.000000Z"
     *  },
     *  "relationships": {
     *      "user": {
     *          "data": {
     *              "type": "user",
     *              "id": 2
     *          }
     *      },
     *      "category": {
     *          "data": {
     *              "type": "category",
     *              "id": 1
     *          }
     *      }
     *  },
     *  "links": {
     *      "self": "http://localhost/api/v1/tasks/602"
     *  },
     * },
     * }
     *
     */
    public function store(StoreTaskRequest $request)
    {
        return new TaskResource(Task::create($request->mappedAttributes()));
    }

    /**
     * Show a task
     *
     * Displays the specified task.
     *
     * @group Managing Tasks
     * @response 200 {
     * "data": {
     * "type": "task",
     * "id": 5,
     * "attributes": {
     * "title": "quis repudiandae",
     * "description": "Sed pariatur earum atque harum porro optio reprehenderit.",
     * "status": "C",
     * "created_at": "2024-09-15T18:43:54.000000Z",
     * "updated_at": "2024-09-19T01:31:30.000000Z"
     * },
     * "relationships": {
     * "user": {
     * "data": {
     * "type": "user",
     * "id": 2
     * }
     * },
     * "category": {
     * "data": {
     * "type": "category",
     * "id": 5
     * }
     * }
     * },
     * "links": {
     * "self": "http://localhost/api/v1/tasks/5"
     * }
     * }
     * }
     *
     */
    public function show(Task $task)
    {
        if ( $this->isAble('view', $task) ) {
            return new TaskResource($task);
        }
        return $this->notAuthorized('You are not authorized to view this task');
    }

    /**
     * Update a task
     *
     * update the specified task.
     *
     * @group Managing Tasks
     * @response 200 {
     * "data": {
     *  "type": "task",
     *  "id": 602,
     *  "attributes": {
     *      "title": "Task test updated",
     *      "description": "Task description updated",
     *      "status": "P",
     *      "created_at": "2024-09-23T17:16:52.000000Z",
     *      "updated_at": "2024-09-23T17:16:52.000000Z"
     *  },
     *  "relationships": {
     *      "user": {
     *          "data": {
     *              "type": "user",
     *              "id": 2
     *          }
     *      },
     *      "category": {
     *          "data": {
     *              "type": "category",
     *              "id": 1
     *          }
     *      }
     *  },
     *  "links": {
     *      "self": "http://localhost/api/v1/tasks/602"
     *  },
     * },
     * }
     *
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ( $this->isAble('update', $task) ) {
            $task->update($request->mappedAttributes());
            return new TaskResource($task);
        }
        return $this->notAuthorized('You are not authorized to update this task');
    }

    /**
     * Delete a task
     *
     * Delete the specified task.
     *
     * @group Managing Tasks
     * @response 200{
     *     "data": [],
     *     "message": "Task deleted successfully",
     *     "status": 200
     * }
     *
     */
    public function destroy(Task $task)
    {
        if ( $this->isAble('delete', $task) ) {
            $task->delete();
            return $this->ok('Task successfully deleted');
        }
        return $this->notAuthorized('You are not authorized to delete this task');
    }
}
