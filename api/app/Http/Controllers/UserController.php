<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Silber\Bouncer\Database\Role;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::get();
        return UserResource::collection($users->load('role'));
    }

    public function show(User $user): UserResource {
        return new UserResource($user->load([
            'role',
        ]));
    }

    public function update(Request $request, User $user) {
        $user->fill($request->only(['name']));

        $canMakeRestrictedUpdates = $request->user()->isNot($user);
        if ($canMakeRestrictedUpdates && $user->role->title !== $request->input('role')) {
            $user->retract($user->role->name);
            $user->assign(Role::where('title', '=', $request->input('role'))->first());
        }

        // TODO: Verify email if user email is changed
        // if (($email = $request->input('email')) !== $user->email) {}

        return new UserResource($user->load([
            'role',
        ]));
    }
}