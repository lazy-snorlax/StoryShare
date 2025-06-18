<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::get();
        return UserResource::collection($users->load('role'));
    }

    public function show(string $user) {
        return new UserResource(User::find($user)->load('role'));
    }
}