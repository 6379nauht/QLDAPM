<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends Controller
{
    use ValidatesRequests;

    /**
     * Hiển thị trang đăng nhập.
     */
    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng Nhập Hệ Thống',
        ]);
    }

    /**
     * Xử lý đăng nhập.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu từ form đăng nhập
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Thử đăng nhập với thông tin người dùng
        if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ], $request->filled('remember'))) {
            // Chuyển hướng đến dashboard nếu đăng nhập thành công
            return redirect()->route('admin');
        }

        // Nếu đăng nhập thất bại, gửi thông báo lỗi và quay lại form đăng nhập
        Session::flash('error', 'Email hoặc Password không đúng');
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
