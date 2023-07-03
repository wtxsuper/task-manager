<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'ownerID' => 'required'
        ]);

        $workspace = Workspace::create(['name' => $request->name]);
        $workspace->users()->sync([$request->post('ownerID') => ['is_admin' => true]]);

        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully created!',
            'createdWorkspaceID' => $workspace->id
        ]);
    }

    public function update(Request $request, Workspace $workspace)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
        ]);

        $workspace->update(['name' => $request->post('name')]);
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

    public function addUser(Request $request, Workspace $workspace)
    {
        $this->validate($request, [
           'userID' => 'required',
            'isAdmin' => 'required'
        ]);


        $workspace->users()->syncWithoutDetaching([$request->post('userID') => ['is_admin' => json_decode($request->post('isAdmin'))]]);
        return response()->json([
           'success' => true,
           'message' => 'User successfully added to workspace!'
        ]);
    }

    public function removeUser(Request $request, Workspace $workspace)
    {
        $this->validate($request, [
            'userID' => 'required',
        ]);


        $workspace->users()->detach([$request->post('userID')]);
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
