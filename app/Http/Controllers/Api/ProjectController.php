<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'workspaceID' => 'required',
        ]);

        $project = new Project;
        $project->name = $request->post('name');
        $project->workspace()->associate(Workspace::find($request->post('workspaceID')));
        $project->save();
        return response()->json([
            'success' => true,
            'message' => 'Project successfully created!'
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
        ]);

        $project->update(['name' => $request->post('name')]);
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Task successfully updated!'
        ]);
    }

    public function info(Project $project)
    {
        return response()->json(['project' => $project]);
    }

    public function delete(Project $project)
    {
        $project->delete();
        return response()->json([
            'success' => true,
            'message' => 'Project successfully deleted!'
        ]);
    }
}
