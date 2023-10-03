<?php

namespace App\Http\Controllers\Admin;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->_customerRepository->all();
        $search = $request->get('q');

//        $data = $this->_customerRepository->paginateWhere()
//            ->where('name', 'like', '%'. $search. '%')
//            ->paginate(10);

        return view('admin.customer.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }


    public function create() {

        return view('admin.customer.create');
    }

    public function store(Request $request){

        $request->validate([
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'name' => 'required|string',
            'phone' => 'required|numeric|digits:10|unique:customers',
            'birthdate' => 'before:today',
            'address' => 'required|string'
        ],[
            'email.required' => 'Email không được trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được trống',
            'password.min:6' => 'Mật khẩu ít nhất 6 ký tự',
            'confirm_password.required' => 'Mật khẩu xác thực không được trống',
            'confirm_password.same' => 'Mật khẩu xác thực không đúng',
            'name.required' => 'Tên không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'phone.numeric' => 'Số điện thoại không hợp lệ',
            'phone.digits' => 'Số điện thoại không hợp lệ',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được trống',
        ]);

        try {
            $this->_customerRepository->create($request->all());
            return redirect()->route('admin.customer.index')->with('success', 'Thêm khách hàng thành công');
        } catch (\Throwable $e){
            return redirect()->back()->with('error', 'Something wrong');
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

    public function edit($id)
    {
        try {
            $customerById = $this->_customerRepository->findById($id);
            if ($customerById) {
                return view('admin.customer.edit', [
                    'each' => $customerById
                ]);
            }
            return redirect()->back()->with('error', 'Customer không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.customer.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:customers,email,'.$id.',id',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'name' => 'required|string',
            'phone' => 'required|numeric|digits:10|unique:customers,phone,'.$id.',id',
            'birthdate' => 'before:today',
            'address' => 'required|string'
        ],[
            'email.required' => 'Email không được trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được trống',
            'password.min:6' => 'Mật khẩu ít nhất 6 ký tự',
            'confirm_password.required' => 'Mật khẩu xác thực không được trống',
            'confirm_password.same' => 'Mật khẩu xác thực không đúng',
            'name.required' => 'Tên không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'phone.numeric' => 'Số điện thoại không hợp lệ',
            'phone.digits' => 'Số điện thoại không hợp lệ',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được trống',
        ]);
        try {
            $customerById = $this->_customerRepository->findById($id);
            if ($customerById) {
                $this->_customerRepository->update($id , $request->all());
                return redirect()->route('admin.customer.index')->with('success', 'Sửa thông tin khách hàng thành công');
            }
            return redirect()->back()->with('error', 'Customer không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.customer.index')->with('error', $e->getMessage());
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
            $customerById = $this->_customerRepository->findById($id);
            if ($customerById) {
                $this->_customerRepository->delete($id);
                return redirect()->route('admin.customer.index')->with('success', 'Xoá thông tin khách hàng thành công');
            }
            return redirect()->back()->with('error', 'Customer không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.customer.index')->with('error', $e->getMessage());
        }
    }
}
