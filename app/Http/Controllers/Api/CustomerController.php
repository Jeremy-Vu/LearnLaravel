<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Customer\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    protected $_customerRepository;

    public function __construct(
        CustomerRepository $customerRepository,
    ){
        $this->_customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->_customerRepository->all();
    }

    public function register(Request $request)
    {
        $result = $request->all();
        $validator = Validator::make($result, [
            'email' => ['required', 'email', 'unique:customers','max:255'],
            'password' => ['required', 'min:6'],
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:customers'],
            'birthdate' => ['date_format:d-m-Y', 'before:today'],
            'address' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'error' => $validator->errors()
            ], 400);
        }
        $result['birthdate'] = date('Y-m-d', strtotime($result['birthdate']));
        $result['password'] = Hash::make($result['password']);

        $this->_customerRepository->create($result);
        return response()->json([
            'status' => 200,
            'message' => 'Customer register successfully',
        ], 200);

    }

    public function login(Request $request)
    {
        $result = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $token = Str::random(80);
        $customerByEmail = $this->_customerRepository->findByField('email', $result['email']);

        if ($customerByEmail) {
            if (Hash::check($request->password, $customerByEmail->password)) {
                $customerByEmail->api_token = hash('sha256', $token);
                $customerByEmail->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'U are logged in!',
                    'token' => $token
                ], 200);
            }

            $response = ["message" => "Pwd wrong"];
            return response($response, 422);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Login failed, pls check your email or pwd',
            'errors' => $validator->fails()
        ], 401);
    }

    public function logout(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->_customerRepository->findById($id);

        if ($result) {
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $customerById = $this->_customerRepository->findById($id);

        $result = $request->all();
        if ($customerById) {
            $validator = Validator::make($result, [
                'name' => ['required', 'max:255'],
                'phone' => ['required', 'numeric', 'digits:10', 'unique:customers'],
                'birthdate' => ['date_format:Y-m-d', 'before:today'],
                'address' => ['required'],
                'email' => ['nullable', 'email', 'unique:customers']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validate failed, pls check again',
                ], 400);
            }

            $this->_customerRepository->update($id, $result);
            return response()->json([
                'status' => 200,
                'message' => 'Updated',
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $customerById = $this->_customerRepository->findById($id);
        if ($customerById) {
            $this->_customerRepository->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'Deleted',
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ], 401);
    }
}
