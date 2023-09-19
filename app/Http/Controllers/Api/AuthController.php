<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JsonException;

class AuthController extends Controller
{
    protected $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function register(Request $request): JsonResponse
    {
        $result = $request->all();

        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'error' => $validator->errors()
            ], 400);
        }
        $token = Str::random(80);
        $userInfo = $this->_user;
        $userInfo->name = $result['name'];
        $userInfo->email = $result['email'];
        $userInfo->roles = $result['roles'];
        $userInfo->password = Hash::make($result['password']);
        $userInfo->api_token = hash('sha256', $token);
        $userInfo->save();

        return response()->json([
            'status' => 200,
            'message' => 'Register successfully',
            'token' => $token
        ], 200);
    }

    /**
     * @throws JsonException
     */
    public function login(Request $request): JsonResponse
    {
        $result = $request->all();
        $infoUser = [
            'email' => $result['email'],
            'password' => $result['password']
        ];
        if (Auth::attempt($infoUser)) {
            $user = $this->_user->where('email', $result['email'])->first();
            $token = Str::random(80);
            return response()->json([
                'status' => 200,
                'message' => 'U are logged in!',
                'token' => $token
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Login failed, pls check your email or pwd'
        ], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'You are logout!'
        ], 200);
    }

}
