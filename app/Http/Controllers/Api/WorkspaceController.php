<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateWorkspaceRequest;
use App\Http\Requests\Api\UniversalAddUserRequest;
use App\Http\Requests\Api\UniversalRemoveUserRequest;
use App\Http\Requests\Api\UpdateWorkspaceRequest;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    public function create(CreateWorkspaceRequest $request)
    {
        $validated = $request->validated();

        $workspace = Workspace::create(['name' => $validated['name']]);
        $workspace->users()->sync([$validated['ownerID'] => ['is_admin' => true]]);

        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully created!',
            'createdWorkspaceID' => $workspace->id
        ]);
    }

    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        $validated = $request->validated();

        $workspace->update(['name' => $validated['name']]);
        $workspace->save();

        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully updated!'
        ]);
    }

    public function info(Workspace $workspace)
    {
        $admins = DB::table('user_workspace')->where('workspace_id', $workspace->id)->where('is_admin', true)->get('user_id');
        return response()->json([
            'workspace' => $workspace,
            'admins' => $admins
        ]);
    }

    public function delete(Workspace $workspace)
    {
        $workspace->users()->detach();
        $workspace->delete();
        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully deleted!'
        ]);
    }

    public function addUser(UniversalAddUserRequest $request, Workspace $workspace)
    {
        $validated = $request->validated();


        $workspace->users()->syncWithoutDetaching([$validated['userID'] => ['is_admin' => json_decode($validated['isAdmin'])]]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully added to workspace!'
        ]);
    }

    public function removeUser(UniversalRemoveUserRequest $request, Workspace $workspace)
    {
        $validated = $request->validated();

        $workspace->users()->detach([$validated['userID']]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully removed from workspace!'
        ]);
    }

    public function getUser(Workspace $workspace)
    {
        $users = $workspace->users()->get();
        return response()->json([
            'workspaceID' => $workspace->id,
            'users' => $users
        ]);
    }
}
