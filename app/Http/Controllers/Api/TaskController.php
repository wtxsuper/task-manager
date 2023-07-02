<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request, Project $project)
    {
        // dd($project);
        $this->validate($request, [
            'authorID' => 'required',
            'assignerID' => 'required',
            'title' => 'required|min:4',
            'description' => 'required|min:6'
        ]);

        $task = new Task;
        $task->project()->associate($project);
        $task->title = $request->post('title');
        $task->description = $request->post('description');
        $task->author()->associate(User::find($request->post('authorID')));
        $task->assigner()->associate(User::find($request->post('assignerID')));
        $task->save();
        return response()->json([
            'success' => true,
            'message' => 'Task successfully created!'
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'min:4',
            'email' => 'email',
            'password' => 'min:6',
        ]);
        if ($request->hasAny('name'))
        {
            $user->update(['name' => $request->post('name')]);
        }
        if ($request->hasAny('email'))
        {
            $user->update(['email' => $request->post('email')]);
        }
        if ($request->hasAny('password'))
        {
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
}
