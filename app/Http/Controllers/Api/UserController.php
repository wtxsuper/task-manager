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

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'min:4',
            'email' => 'email',
            'password' => 'min:6',
        ]);
        if ($request->hasAny('name'))
        {
            $user->update(['name' => $request->post('name')]);
        }
        if ($request->hasAny('email'))
        {
            $user->update(['email' => $request->post('email')]);
        }
        if ($request->hasAny('password'))
        {
            $user->update(['password' => bcrypt($request->post('password'))]);
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User successfully updated!'
        ]);
    }

    public function info(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User successfully deleted!'
        ]);
    }
}
