<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Eloquent\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $_categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository
    )
    {
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $data = $this->_categoryRepository->paginateWhereLikeOrderBy(['status' => 1], ['name' => $search]);

        return view('admin.category.index', [
            'data' => $data,
            'search' => $search,
        ]);
    }

    public function create(){
        return view('admin.category.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $result = $request->all();
        $validator = Validator::make($result, [
            'name' => ['required', 'max:255'],
            'content' => ['nullable'],
            'description' => ['nullable', 'max:255'],
            'parent_id' => ['nullable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
            ], 400);
        }
        $categoryModel = new Category();
        $result['slug'] = $categoryModel->setCategorySlug($result['name']);
        $this->_categoryRepository->create($result);
        return response()->json([
            'status' => 200,
            'message' => 'Created',
            'data' => $result
        ], 200);
    }

    public function edit($id){
        try {
            $categoryById = $this->_categoryRepository->findById($id);
            if ($categoryById) {
                return view('admin.category.edit', [
                    'each' => $categoryById
                ]);
            }
            return redirect()->back()->with('error', 'Danh mục sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.category.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->_categoryRepository->findById($id);

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
        $categoryById = $this->_categoryRepository->findById($id);

        if ($categoryById) {
            $result = $request->all();
            $validator = Validator::make($result, [
                'name' => ['required', 'max:255'],
                'content' => ['nullable'],
                'description' => ['nullable', 'max:255'],
                'parent_id' => ['nullable']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validate failed, pls check again',
                ], 400);
            }

            $this->_categoryRepository->update($id, $result);
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
        $categoryById = $this->_categoryRepository->findById($id);
        if ($categoryById) {
            $this->_categoryRepository->delete($id);
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
