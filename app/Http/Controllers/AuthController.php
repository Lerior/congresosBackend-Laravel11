<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('user', 'pass');

        // Busca al usuario en la base de datos
        $user = User::where('user_app', $credentials['user'])->first();

        if (!$user || !Hash::check($credentials['pass'], $user->user_password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Crea el token con los datos del usuario
        $secretKey = env('JWT_SECRET');
        $token = JWT::create((object)[
            'id' => $user->id,
            'user' => $user->user_app
        ], $secretKey);
        //ya se esta enviando en data... checar frontend
        $user_app = JWT::get_data($token, $secretKey)['user'];
        return response()->json(['token' => $token, 'user' => $user_app]);
    }
}
