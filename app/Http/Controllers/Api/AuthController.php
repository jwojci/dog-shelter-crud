<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register user
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password'
        ]);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->save();

        $token = $user->createToken('Access Token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user,
            'accessToken' => $token,
        ], 201);
    }

    /**
     * Login user
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Wrong email or password'], 401);
        }

        $user = request()->user();
        if (!!$user->tokens->first()) {
            $token = $user->tokens->first()->plainTextToken;
        } else {
            $token = $user->createToken('Access Token')->plainTextToken;
        }

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out'
        ]);
    }
}
