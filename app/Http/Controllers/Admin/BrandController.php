<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Brand\BrandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $_brandRepository;

    public function __construct(
        BrandRepository $brandRepository
    )
    {
        $this->_brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->_brandRepository->all();
        $search = $request->get('q');
//        $where = [
//            'name' => $search
//        ];

        return view('admin.brand.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required|unique:product',
            'detail_product' => 'max:255|nullable',
            'quantity' => 'required',
            'description' => 'nullable',
            'brand_id' => 'nullable',
            'image' => 'nullable',
            'category_id' => 'nullable',
            'status' => 'nullable',
            'slug' => 'nullable'
        ], [
            'name.required' => 'Tên không được trống.',
            'price.required' => 'Giá không được trống.',
            'sku.required' => 'SKU không được trống.',
            'sku.unique' => 'SKU đã tồn tại.',
            'detail_product.max' => 'Chi tiết sản phẩm không được vượt quá 255 ký tự.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
        ]);
        $data = [

        ];
        try {
            $this->_brandRepository->create($data);
            return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something wrong');
        }

    }

    public function edit($id)
    {
        try {
            $productById = $this->_brandRepository->findById($id);
            if ($productById) {
                return view('admin.product.edit', [
                    'each' => $productById
                ]);
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.product.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->_brandRepository->findById($id);

        if ($result) {
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Product not found',
        ], 401);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sku' => 'required|unique:product,sku,' . $id . ',id',
            'detail_product' => 'max:255|nullable',
            'quantity' => 'required',
            'description' => 'nullable',
            'brand_id' => 'nullable',
            'image' => 'nullable',
            'category_id' => 'nullable',
            'status' => 'nullable',
            'slug' => 'nullable'
        ], [
            'name.required' => 'Tên không được trống.',
            'price.required' => 'Giá không được trống.',
            'sku.required' => 'SKU không được trống.',
            'sku.unique' => 'SKU đã tồn tại.',
            'detail_product.max' => 'Chi tiết sản phẩm không được vượt quá 255 ký tự.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
        ]);
        try {
            $customerById = $this->_brandRepository->findById($id);
            if ($customerById) {
                $this->_brandRepository->update($id, $request->all());
                return redirect()->route('admin.product.index')->with('success', 'Sửa thông tin sản phẩm thành công');
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.product.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $productById = $this->_brandRepository->findById($id);
            if ($productById) {
                $this->_brandRepository->delete($id);
                return redirect()->route('admin.product.index')->with('success', 'Xoá thông tin sản phẩm thành công');
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.product.index')->with('error', $e->getMessage());
        }
    }
}
