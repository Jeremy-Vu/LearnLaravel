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

class AuthController extends Controller
{
    protected $_user;
    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function returnResponse($status, $message, $data = null): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @throws JsonException
     */
    public function register(Request $request): JsonResponse
    {
        $result = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $validator  = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'email'=> ['required', 'email', 'unique:users','max:255'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            $dataError = $this->returnResponse(400,'Validate fail, pls check again');
            return response()->json($dataError, 400);
        }

        $userInfo = $this->_user;
        $userInfo->name = $result['name'];
        $userInfo->email = $result['email'];
        $userInfo->password = Hash::make($result['password']);
        $userInfo->save();

        $dataSuccess  = $this->returnResponse(200,'Register successfully', $result);
        return response()->json($dataSuccess, 200);
    }

    public function login(Request $request): JsonResponse
    {
        $result = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $infoUser = [
            'email' => $result['email'],
            'password' => $result['password']
        ];
        if (Auth::attempt($infoUser)){
//            $authUser = Auth::user();
            $dataSuccess = $this->returnResponse(200, 'U are logged in!');
            return response()->json($dataSuccess,200);
        }

        $dataError = $this->returnResponse(401,'Login failed, pls check your email or pwd');
        return response()->json($dataError,401);

    }

    public function logout() {

    }

}
