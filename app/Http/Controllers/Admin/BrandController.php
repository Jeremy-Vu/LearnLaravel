<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Brand\BrandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $search = $request->get('q');
        $data = $this->_brandRepository->paginateWhereLikeOrderBy(['status' => 1], ['name' => $search]);

        return view('admin.brand.index', [
            'data' => $data,
            'search' => $search,
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
            'name' => 'required|unique:brand',
        ], [
            'name.required' => 'Tên không được trống.',
        ]);
        $data = [
            'name' => $request['name'],
            'slug' => str()->slug($request['name']),
            'phone' => $request['phone'],
            'email' => $request['email'],
            'description' => $request['description'],
            'address' => $request['address'],
        ];

        if ($img = $request->file('logo')) {
            $filename = Str::random(15). '.' . $img->extension();
            $img->move(public_path('storage/uploads/banners/'), $filename);
            $data['logo'] = 'storage/uploads/banners/'. $filename;
        }

        try {

            $this->_brandRepository->create($data);
            return redirect()->route('admin.brand.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something wrong');
        }

    }

    public function edit($id)
    {
        try {
            $brandById = $this->_brandRepository->findById($id);
            if ($brandById) {
                return view('admin.brand.edit', [
                    'each' => $brandById
                ]);
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.brand.index')->with('error', $e->getMessage());
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
                return redirect()->route('admin.brand.index')->with('success', 'Sửa thông tin sản phẩm thành công');
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.brand.index')->with('error', $e->getMessage());
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
            $brandById = $this->_brandRepository->findById($id);
            if ($brandById) {
                $this->_brandRepository->delete($id);
                return redirect()->route('admin.brand.index')->with('success', 'Xoá thông tin thương hiệu thành công');
            }
            return redirect()->back()->with('error', 'Thương hiệu không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.brand.index')->with('error', $e->getMessage());
        }
    }
}
