<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Throwable;

class AuthController extends Controller
{
    protected $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function login(Request $request)
    {
        return view('admin.auth.login');
    }

    public function processLogin(Request $request){

        $request->validate([
            'email' => 'required|string|',
            'password' => 'required|min:6',
        ],[
            'email.required' => 'Email không được phép trống',
            'email.string' => 'Email phải là kiểu chuỗi',
            'password.required' => 'Mật khẩu không được trống',
        ]);
        try {
            $user = User::query()
                ->where('email', $request->get('email'))
                ->firstOrFail();
            if(!Hash::check($request->get('password'), $user->password)){
                throw new Exception('Invalid password');
            }

            session()->put('id', $user->id);
            session()->put('name', $user ->name);
            return redirect()->route('admin.customer.index');

        } catch (Throwable $e) {
            return redirect()->route('login')->with("failed", "Tài khoản hoặc mật khẩu không hợp lệ");
        }

    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ],[
            'name.required' => 'Tên không được phép trống',
            'email.required' => 'Email không được phép trống',
            'email.unique' => 'Email đã tồn tại',
            'email.string' => 'Email phải là kiểu chuỗi',
            'password.required' => 'Mật khẩu không được trống',
            'confirm_password.required' => 'Mật khẩu xác nhận không được trống',
            'confirm_password.same' => 'Mật khẩu xác nhận không trùng khớp'
        ]);

        try {
            $this->_user::query()->create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                ]);
            return redirect()->route('login')->with("success", "Đăng ký thành công, vui lòng nhập thông tin vừa tạo để tiếp tục");
        } catch (\Throwable $th) {
            return redirect()->route('login')->with("failed", "Error Unknown");
        }
    }

    public function logout()
    {
        // session flush là xoá toàn bộ session
        session()->flush();

        return redirect()->route('login')->with("logout", "Đăng xuất thành công");
    }


}
