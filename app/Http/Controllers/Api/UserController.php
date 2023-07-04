<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully registered!',
            'createdUserID' => $user->id
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($request->hasAny('name')) {
            $user->update(['name' => $validated['name']]);
        }
        if ($request->hasAny('email')) {
            $user->update(['email' => $validated['email']]);
        }
        if ($request->hasAny('password')) {
            $user->update(['password' => bcrypt($validated['password'])]);
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User successfully updated!'
        ]);
    }

    public function info(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User successfully deleted!'
        ]);
    }

    public function getWorkspace(User $user)
    {
        $workspaces = $user->workspaces()->get();
        return response()->json([
            'userID' => $user->id,
            'workspaces' => $workspaces
        ]);
    }

    public function getProject(User $user)
    {
        $projects = $user->projects()->get();
        return response()->json([
            'userID' => $user->id,
            'projects' => $projects
        ]);
    }

    public function getTasks(User $user)
    {
        $tasks = new Collection();
        $projects = $user->projects()->get();
        foreach ($projects as $project) {
            $tasks->add($project->tasks()->get());
        }
        return response()->json([
            'userID' => $user->id,
            'tasks' => $tasks
        ]);
    }
}
