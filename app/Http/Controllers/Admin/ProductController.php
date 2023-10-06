<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Eloquent\Brand\BrandRepository;
use App\Repositories\Eloquent\Category\CategoryRepository;
use App\Repositories\Eloquent\Product\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $_productRepository;

    protected $_brandRepository;

    protected $_categoryRepositoty;

    public function __construct(
        ProductRepository  $productRepository,
        BrandRepository    $brandRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->_brandRepository = $brandRepository;
        $this->_productRepository = $productRepository;
        $this->_categoryRepositoty = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
//        $data = $this->_productRepository->all();
        $search = $request->get('q');
        $data = $this->_productRepository->paginateWhereLikeOrderBy(['status'=> '1'], ['name' => $search]);

        return view('admin.product.index', [
            'data' => $data,
            'search' => $search,
        ]);
    }

    public function create()
    {
        $categories = $this->_categoryRepositoty->all();
        $brands = $this->_brandRepository->all();
        return view('admin.product.create',[
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product',
            'price' => 'required',
            'sku' => 'required|unique:product',
            'detail_product' => 'max:255|nullable',
            'quantity' => 'required',
            'description' => 'nullable',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'status' => 'nullable',
            'slug' => 'nullable'
        ], [
            'name.required' => 'Tên không được trống.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'price.required' => 'Giá không được trống.',
            'sku.required' => 'SKU không được trống.',
            'sku.unique' => 'SKU đã tồn tại.',
            'detail_product.max' => 'Chi tiết sản phẩm không được vượt quá 255 ký tự.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
        ]);

        $data = [
            'name' => $request['name'],
            'slug' => str()->slug($request['name']),
            'price' => $request['price'],
            'sku' => $request['sku'],
            'detail_product' => $request['detail_product'],
            'quantity' => $request['quantity'],
            'description' => $request['description'],
            'brand_id' => $request['brand_id'],
            'category_id' => $request['category_id'],
            'image' => $request['image']
        ];
        if ($img = $request->file('image')) {
            $filename = time() . '.' . $img->extension();
            $img->move(public_path('storage/uploads/products/'), $filename);
            $data['image'] = 'storage/uploads/products/'. $filename;
        }
        try {
            $this->_productRepository->create($data);
            return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something wrong');
        }

    }

    public function edit($id)
    {
        try {
            $productById = $this->_productRepository->findById($id);
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
        $result = $this->_productRepository->findById($id);

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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:product,name' . $id . ',id',
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
            $customerById = $this->_productRepository->findById($id);
            if ($customerById) {
                $this->_productRepository->update($id, $request->all());
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $productById = $this->_productRepository->findById($id);
            if ($productById) {
                $this->_productRepository->delete($id);
                return redirect()->route('admin.product.index')->with('success', 'Xoá thông tin sản phẩm thành công');
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.product.index')->with('error', $e->getMessage());
        }
    }
}
