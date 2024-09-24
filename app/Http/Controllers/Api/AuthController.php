<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;


    /**
     * Register.
     *
     * Register the user and returns the user's token.
     *
     * @unauthenticated
     * @group Authentication
     * @response 200 {
    "data": {
    "token": "{YOUR_AUTH_KEY}"
    },
    "message": "Authenticated",
    "status": 200
    }
     */
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        $user->categories()->createMany([
            ['title' => 'Personal', 'slug' => 'personal'],
            ['title' => 'Work', 'slug' => 'work'],
            ['title' => 'Others', 'slug' => 'others'],
        ]);

        return $this->ok(
            'Register successfully',
            [
                'token' => $user->createToken(
                    'API Token for ' . $user->email,
                    [ '*' ],
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }


    /**
     * Login.
     *
     * Authenticates the user and returns the user's token.
     *
     * @unauthenticated
     * @group Authentication
     * @response 200 {
      "data": {
        "token": "{YOUR_AUTH_KEY}"
      },
      "message": "Authenticated",
      "status": 200
      }
     */
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if ( ! Auth::attempt($request->only('email', 'password')) ) {
            return $this->error('Invalid credentials.', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API Token for ' . $user->email,
                    [ '*' ],
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }


    /**
     * Logout.
     *
     * Signs out the user and destroys the API token.
     *
     * @group Authentication
     * @response 200 {}
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }
}
