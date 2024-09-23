<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * User.
     *
     * @group Authentication
     * @response 200
     * {
     * "data": {
     * "type": "user",
     * "id": 2,
     * "attributes": {
     * "name": "User example",
     * "email": "example@example.com",
     * "emailVerifiedAt": null,
     * "created_at": "2024-09-15T18:43:53.000000Z",
     * "updated_at": "2024-09-15T18:43:53.000000Z"
     * },
     * "links": {
     * "self": "http://localhost/api/user?2"
     * }
     * }
     * }
 */
    public function show()
    {
        return new UserResource(User::findOrFail(\Auth::user()->id));
    }
}
