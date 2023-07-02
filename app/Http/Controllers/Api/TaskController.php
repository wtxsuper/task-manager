<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'projectID' => 'required',
            'authorID' => 'required',
            'assignerID' => 'required',
            'title' => 'required|min:4',
            'description' => 'required|min:6'
        ]);

        $task = new Task;
        $task->project()->associate(Project::find($request->post('projectID')));
        $task->title = $request->post('title');
        $task->description = $request->post('description');
        $task->author()->associate(User::find($request->post('authorID')));
        $task->assigner()->associate(User::find($request->post('assignerID')));
        $task->save();
        return response()->json([
            'success' => true,
            'message' => 'Task successfully created!',
            'createdTaskID' => $task->id
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'min:4',
            'description' => 'min:6'
        ]);
        if ($request->hasAny('title')) {
            $task->update(['title' => $request->post('title')]);
        }
        if ($request->hasAny('description')) {
            $task->update(['description' => $request->post('description')]);
        }
        if ($request->hasAny('assignerID')) {
            $task->update(['assigner_id' => $request->post('assignerID')]);
        }
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task successfully updated!'
        ]);
    }

    public function info(Task $task)
    {
        return response()->json(['task' => $task]);
    }

    public function delete(Task $task)
    {
        $task->delete();
        return response()->json([
            'success' => true,
            'message' => 'Task successfully deleted!'
        ]);
    }
}
