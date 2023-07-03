<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => bcrypt($request->post('password'))
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully registered!',
            'createdUserID' => $user->id
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'min:4',
            'email' => 'email',
            'password' => 'min:6',
        ]);
        if ($request->hasAny('name')) {
            $user->update(['name' => $request->post('name')]);
        }
        if ($request->hasAny('email')) {
            $user->update(['email' => $request->post('email')]);
        }
        if ($request->hasAny('password')) {
            $user->update(['password' => bcrypt($request->post('password'))]);
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
        foreach($projects as $project) {
            $tasks->add($project->tasks()->get());
        }
        return response()->json([
            'userID' => $user->id,
            'tasks' => $tasks
        ]);
    }
}
