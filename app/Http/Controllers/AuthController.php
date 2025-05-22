<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
            'email.exists' => 'El correo electrónico no está registrado',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                $token = request()->user()->createToken('auth_token')->plainTextToken;
                return response()->json(['message' => 'Usuario autenticado con éxito', 'token' => $token]);
            } else {
                return response()->json([
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ],[
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validation->fails()) {
            return response()->json([
            'errors' => $validation->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            Auth::login($user);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'Usuario registrado correctamente', 'token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        try {
            $bearerToken = $request->bearerToken();

            if (!$bearerToken) {
                return response()->json(['message' => 'No hay token proporcionado'], 401);
            }

            $user = $request->user();
            if ($user) {
                $request->user()->tokens()->delete();

                return response()->json([
                    'message' => 'Usuario deslogueado con éxito',
                ], 200);
            }

            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
