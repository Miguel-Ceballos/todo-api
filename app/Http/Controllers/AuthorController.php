<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }
}
