<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TaskFilter;
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
     * Get all tasks
     *
     * @group Managing Tasks by Category
     * @queryParam sort string Data field(s) to sort by. Multiple fields can be specified by separating them with a comma. Denote descending sort with a minis (-) sign. Example: sort=-created_at,title
     * @queryParam filter[status] Filter by status code: C: completed, D: Doing, P: Pending. No-example
     * @queryParam filter[title] Filter by title. Wildcards ares supported. Example: filter[title]=*test*
     *
     */
    public function index(Category $category, TaskFilter $filters)
    {
        if ( $this->isAble('viewAny', $category) ) {
            return TaskResource::collection(
                Task::where('category_id', $category->id)->filter($filters)->get()
            );
        }
        return $this->error('Category Tasks not found.', 404);
    }

    /**
     * Create a task
     *
     * Creates a new task for the authenticated user.
     *
     * @group Managing Tasks by Category
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
    public function store(Category $category, StoreTaskRequest $request)
    {
        if ( $this->isAble('create', $category) ) {
            return new TaskResource($category->tasks()->create($request->mappedAttributes()));
        }
        return $this->error('Category not found.', 404);
    }

    /**
     * Show a task
     *
     * Displays the specified task.
     *
     * @group Managing Tasks by Category
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
     * Update a task
     *
     * update the specified task.
     *
     * @group Managing Tasks by Category
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
     * Delete a task
     *
     * Delete the specified task.
     *
     * @group Managing Tasks by Category
     * @response 200{
     *     "data": [],
     *     "message": "Task deleted successfully",
     *     "status": 200
     * }
     *
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
