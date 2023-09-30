<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Eloquent\Product\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $_productRepository;
    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->_productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->_productRepository->all();
        $search = $request->get('q');

//        $data = $this->_customerRepository->paginateWhere()
//            ->where('name', 'like', '%'. $search. '%')
//            ->paginate(10);

        return view('admin.product.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function addProduct(Request $request)
    {
        $result = $request->all();

        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'price' => ['required'],
            'sku' => ['required','unique:product'],
            'detail_product' => ['max:255','nullable'],
            'description' => ['nullable'],
            'brand_id' => ['nullable','integer'],
            'image' => ['nullable'],
            'category_id'=> ['integer','nullable'],
            'status' => ['nullable', 'integer']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'errors' => $validator->errors()
            ], 400);
        }
        $productModel = new Product();

        $result['slug'] = $productModel->setProductSlug($result['name']);

        $this->_productRepository->create($result);
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
        $result = $this->_productRepository->findById($id);

        if ($result){
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Product not found',
        ],401);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = $request->all();
        $productById = $this->_productRepository->findById($id);
        if ($productById) {
            $validator = Validator::make($result, [
                'name' => ['required', 'max:255'],
                'slug' => ['nullable'],
                'price' => ['required', 'numeric', 'between:0,9999999999.99'],
                'quantity' => ['required', 'numeric'],
                'sku' => ['required','unique:product'],
                'detail_product' => ['max:255','nullable'],
                'description' => ['nullable'],
                'brand_id' => ['nullable','integer'],
                'image' => ['nullable'],
                'category_id'=> ['integer','nullable'],
                'status' => ['nullable', 'integer']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validate failed, pls check again',
                    'errors' => $validator->errors()
                ], 400);
            }

            $this->_productRepository->update($id, $result);
            return response()->json([
                'status' => 200,
                'message' => 'Updated',
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Product not found',
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
        $productById = $this->_productRepository->findById($id);
        if ($productById) {
            $this->_productRepository->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'Deleted',
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Product not found',
        ], 401);
    }
}
