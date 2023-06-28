<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Spatie\LaravelIgnition\Exceptions\ViewException;

class WorkspaceController extends Controller
{
    // TODO: NOT WORKING CREATE RELATIONSHIP
    // General error: 1364 Field 'user_id' doesn't have a default value

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'ownerID' => 'required'
        ]);

        /*$owner = User::find($request->ownerID);*/
        $workspace = Workspace::create(['name' => $request->name]);
        $workspace->users()->sync([$request->post('ownerID') => ['is_admin' => true]]);

        /*DB::table('user_workspace')->where([
            ['user_id', '=', $owner->id],
            ['workspace_id', '=', $workspace->id]
        ])->updateOrInsert(['is_admin' => true]);*/

        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully created!'
        ]);
    }

    // TODO: not working!
    public function update(int $id, Request $request)
    {
        $this->validate($request, ['name' => 'min:4']);

        $workspace = User::find($id);
        $workspace->name = $request->name;
        $workspace->save();

        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully updated!'
        ]);
    }

    public function info(int $id)
    {
        $workspace = Workspace::find($id);
        $admins = DB::table('user_workspace')->where('workspace_id', $id)->where('is_admin', true)->get('user_id');
        return response()->json([
            'workspace' => $workspace,
            'admins' => $admins
        ]);
    }

    public function delete(int $id)
    {
        $workspace = Workspace::find($id);
        $workspace->delete();
        DB::table('user_workspace')->where('workspace_id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Workspace successfully deleted!'
        ]);
    }
}
