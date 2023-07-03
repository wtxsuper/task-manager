<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'workspaceID' => 'required',
            'ownerID' => 'required'
        ]);

        $project = new Project;
        $project->name = $request->post('name');
        $project->workspace()->associate(Workspace::find($request->post('workspaceID')));
        $project->save();
        $project->users()->sync([$request->post('ownerID') => ['is_admin' => true]]);
        return response()->json([
            'success' => true,
            'message' => 'Project successfully created!',
            'createdProjectID' => $project->id
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
            'message' => 'Project successfully updated!'
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

    public function addUser(Request $request, Project $project)
    {
        $this->validate($request, [
            'userID' => 'required',
            'isAdmin' => 'required'
        ]);


        $project->users()->syncWithoutDetaching([$request->post('userID') => ['is_admin' => json_decode($request->post('isAdmin'))]]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully added to project!'
        ]);
    }

    public function removeUser(Request $request, Project $project)
    {
        $this->validate($request, [
            'userID' => 'required',
        ]);


        $project->users()->detach([$request->post('userID')]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully removed from project!'
        ]);
    }

    public function getUser(Project $project)
    {
        $users = $project->users()->get();
        return response()->json([
            'projectID' => $project->id,
            'users' => $users
        ]);
    }
}
