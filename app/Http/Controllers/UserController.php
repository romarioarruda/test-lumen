<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class UserController extends Controller
{
    
    public function listUsers()
    {
        return User::all();
    }

    public function listOneUser(int $id)
    {
        return User::find($id) ?? [];
    }

    public function createUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Crypt::encrypt($request->password)
        ]);

        if ($user->save()) {
            return response()->json(['inserted_id' => $user->id], 201);
        }
    }

    public function updateUserNameAndEmail(Request $request, int $id)
    {
        $user = User::find($id);

        if (!empty($user)) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users'
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            if ($user->save()) {
                return response()->json(['update_id' => $user->id], 200);
            }
        }

        return response()->json(['user not found' => $id], 404);
    }

    public function deleteUser(int $id)
    {
        $user = User::find($id);
        
        if (!empty($user)) {
            $user->delete();
            return response()->json(null, 204);
        }

        return response()->json(['user not found' => $id], 404);
    }
}
