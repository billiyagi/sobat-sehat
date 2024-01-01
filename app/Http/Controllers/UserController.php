<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Menampilkan semua user
    public function indexUsers()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return $this->responseNotFound('User not Found');
        }

        return $this->responseSuccess($users);
    }

    // Menampilkan detail penggguna berdasarkan ID
    public function showUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->responseNotFound('User not found');
        }
        return $this->responseSuccess($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kontributor,user'
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),

        ]);

        $user->save();

        return $this->responseSuccess($user, 'User created succesfully.', 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(), 400);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = empty($request->input('role')) ? $user->role : $request->input('role');
        $user->password = empty($request->input('password')) ? $user->password : Hash::make($request->input('password'));


        $user->save();

        return $this->responseSuccess($user, 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->responseError("User not found.", 404);
        }
        $user->delete();

        return $this->responseSuccess('User deleted', 200);
    }
}
