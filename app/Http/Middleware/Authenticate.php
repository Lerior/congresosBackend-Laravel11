<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\JWT;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Obtiene el token del encabezado Authorization
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['error' => 'Token no proporcionado'], 401);
            }

            // Verifica la firma y la validez del token
            $secretKey = env('JWT_SECRET');
            $verifyResult = JWT::verify($token, $secretKey);

            switch ($verifyResult) {
                case 1: // Firma no válida
                    return response()->json(['error' => 'Firma del token inválida'], 401);
                case 2: // Token expirado
                    return response()->json(['error' => 'Token expirado'], 401);
                case 0: // Token válido
                    // Extrae los datos del usuario desde el token
                    $userData = JWT::get_data($token, $secretKey);
                    if (!$userData) {
                        return response()->json(['error' => 'Error al obtener datos del token'], 401);
                    }

                    // Agrega los datos del usuario al request
                    $request->setUserResolver(function () use ($userData) {
                        return $userData;
                    });
                    break;
                default:
                    return response()->json(['error' => 'Error al verificar el token'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el token: ' . $e->getMessage()], 500);
        }

        return $next($request);
    }
}
