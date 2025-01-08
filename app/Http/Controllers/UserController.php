<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $req)
    {
        return User::all();
    }

    public function show($user)
    {
        $result = User::find($user);
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_app' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,user_email|max:255',
            'user_phone' => 'required|string|max:15',
            'user_rol' => 'required|string|max:50',
            'user_password' => 'required|string|min:8'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = new User;

        $datos->fill($req->except('user_password'));

        $datos->user_password = Hash::make($req->user_password);

        $result = $datos->save();

        if ($result) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function update(Request $req, $user)
    {
        $validator = Validator::make($req->all(), [
            'user_app' => 'filled|string|max:255',
            'user_name' => 'filled|string|max:255',
            'user_email' => 'filled|email|unique:users,user_email,' . $user, // Validación de unicidad con excepción para el usuario actual
            'user_phone' => 'filled|string|max:15',
            'user_rol' => 'filled|string|max:50',
            'user_password' => 'filled|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = User::find($user);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        }

        if ($req->filled('user_password')) {
            $req->merge(['user_password' => Hash::make($req->user_password)]);
        }

        $result = $datos->fill($req->all())->save();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'User updated successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to update user'], 500);
        }
    }

    public function destroy($user)
    {
        $datos = User::find($user);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        }

        $result = $datos->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete user'], 500);
        }
    }
}
