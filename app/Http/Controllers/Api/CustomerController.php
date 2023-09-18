<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Customer\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $_customerRepository;

    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->_customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->_customerRepository->getAll();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createCustomer(Request $request)
    {
        $result = $request->all();
        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'phone' => ['required','numeric', 'digits:10','unique:customers'],
            'birthdate' => ['date_format:Y-m-d','before:today'],
            'address' => ['required'],
            'email' => ['nullable', 'email', 'unique:customers']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
            ], 400);
        }

        $this->_customerRepository->create($result);
        return response()->json([
            'status' => 200,
            'message' => 'Created',
            'data' => $result
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->_customerRepository->find($id);

        if ($result){
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ],400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $customerById = $this->_customerRepository->find($id);

        $result = $request->all();
        if ($customerById) {
            $validator = Validator::make($result, [
                'name' => ['required', 'max:255'],
                'phone' => ['required','numeric', 'digits:10', 'unique:customers'],
                'birthdate' => ['date_format:Y-m-d','before:today'],
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
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $customerById = $this->_customerRepository->find($id);
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
