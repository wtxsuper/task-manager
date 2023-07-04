<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function create(CreateTaskRequest $request)
    {
        $validated = $request->validated();

        $task = new Task;
        $task->project()->associate(Project::find($validated['projectID']));
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->author()->associate(User::find($validated['authorID']));
        $task->assigner()->associate(User::find($validated['assignerID']));
        $task->save();
        return response()->json([
            'success' => true,
            'message' => 'Task successfully created!',
            'createdTaskID' => $task->id
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        if ($request->hasAny('title')) {
            $task->update(['title' => $validated['title']]);
        }
        if ($request->hasAny('description')) {
            $task->update(['description' => $validated['description']]);
        }
        if ($request->hasAny('assignerID')) {
            $task->update(['assigner_id' => $validated['assignerID']]);
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
