<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProjectRequest;
use App\Http\Requests\Api\UniversalAddUserRequest;
use App\Http\Requests\Api\UniversalRemoveUserRequest;
use App\Http\Requests\Api\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Workspace;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request)
    {
        $validated = $request->validated();

        $project = new Project;
        $project->name = $validated['name'];
        $project->workspace()->associate(Workspace::find($validated['workspaceID']));
        $project->save();
        $project->users()->sync([$validated['ownerID'] => ['is_admin' => true]]);
        return response()->json([
            'success' => true,
            'message' => 'Project successfully created!',
            'createdProjectID' => $project->id
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->update(['name' => $validated['name']]);
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

    public function addUser(UniversalAddUserRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->users()->syncWithoutDetaching([$validated['userID'] => ['is_admin' => json_decode($validated['isAdmin'])]]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully added to project!'
        ]);
    }

    public function removeUser(UniversalRemoveUserRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->users()->detach([$validated['userID']]);
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
