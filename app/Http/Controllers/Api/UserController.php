<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User successfully registered!'
        ]);
    }

    // TODO: not working!
    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'min:4',
            'email' => 'email',
            'password' => 'min:6',
        ]);

        $user = User::find($id);
        if ($request->hasAny('name'))
        {
            $user->name = $request->name;
        }
        if ($request->hasAny('email'))
        {
            $user->email = $request->email;
        }
        if ($request->hasAny('password'))
        {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User successfully updated!'
        ]);
    }

    public function info(int $id)
    {
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User successfully deleted!'
        ]);
    }
}
