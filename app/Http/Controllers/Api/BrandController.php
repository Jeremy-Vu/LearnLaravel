<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Eloquent\Brand\BrandRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    protected $_brandRepository;

    public function __construct(
        BrandRepository $categoryRepository
    )
    {
        $this->_brandRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->_brandRepository->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addBrand(Request $request)
    {
        $result = $request->all();
        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'phone' => ['numeric', 'digits:10'],
            'logo' => ['nullable'],
            'email' => ['required', 'max:255', 'email','unique:brand'],
            'description' => ['nullable']
        ]);

        $brandModel = new Brand();

        $result['slug'] = $brandModel->setBrandSlug($result['name']);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'error' => $validator->errors()
            ], 400);
        }

        $this->_brandRepository->create($result);
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
        $result = $this->_brandRepository->findById($id);

        if ($result){
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Category not found',
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
        $brandById = $this->_brandRepository->findById($id);

        if ($brandById) {
            $result = $request->all();
            $validator = Validator::make($result, [
                'name' => ['required', 'max:255'],
                'phone' => ['numeric', 'digits:10'],
                'logo' => ['nullable'],
                'email' => ['required', 'max:255', 'email','unique:brand'],
                'description' => ['nullable']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validate failed, pls check again',
                ], 400);
            }

            $this->_brandRepository->update($id, $result);
            return response()->json([
                'status' => 200,
                'message' => 'Updated',
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Category not found',
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
        $brandById = $this->_brandRepository->findById($id);
        if ($brandById) {
            $this->_brandRepository->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'Deleted',
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Category not found',
        ], 401);
    }
}
