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

    public function info(Request $request)
    {
        $user = User::find($request->id);
        return response()->json(['user' => $user]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User successfully deleted!'
        ]);
    }
}
