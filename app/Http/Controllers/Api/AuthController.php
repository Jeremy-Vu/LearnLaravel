<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JsonException;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    protected $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    /**
     * @throws JsonException
     */
    public function register(Request $request): JsonResponse
    {
        $result = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            $dataError = $this->returnResponse(400, 'Validate fail, pls check again');
            return response()->json($dataError, 400);
        }

        $userInfo = $this->_user;
        $userInfo->name = $result['name'];
        $userInfo->email = $result['email'];
        $userInfo->password = Hash::make($result['password']);
        $userInfo->save();

        $token =  $userInfo->createToken('API Token')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'Register successfully',
            'data' => $result,
            'token' => $token
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $result = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $infoUser = [
            'email' => $result['email'],
            'password' => $result['password']
        ];
        if (Auth::attempt($infoUser)) {
            $user = $this->_user->where('email', $result['email'])->first();
            $token = $user->createToken('apiToken')->plainTextToken;

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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'You are logout!'
        ], 200);
    }

}
