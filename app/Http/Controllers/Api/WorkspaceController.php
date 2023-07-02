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
            'message' => 'Workspace successfully created!'
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
            'message' => 'User successfully updated!'
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
}
