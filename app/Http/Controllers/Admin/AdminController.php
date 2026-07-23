<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Order;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session('admin')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ], [
        'email.required'    => 'Vui lòng nhập email.',
        'email.email'       => 'Email không hợp lệ.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    // Tìm admin trong database
    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()
            ->with('error', 'Email hoặc mật khẩu không đúng!')
            ->withInput(['email' => $request->email]);
    }

    // ====================== SỬA TẠM Ở ĐÂY ======================
    // Nếu password trong DB chưa phải Bcrypt (plain text hoặc hash cũ)
    if (!Hash::check($request->password, $admin->password)) {
        
        // Kiểm tra thêm trường hợp mật khẩu lưu dạng plain text
        if ($request->password === $admin->password) {
            // Nếu đúng plain text → tự động hash lại bằng Bcrypt
            $admin->password = Hash::make($request->password);
            $admin->save();
            
            // Tiếp tục đăng nhập bình thường
        } else {
            // Sai mật khẩu
            return back()
                ->with('error', 'Email hoặc mật khẩu không đúng!')
                ->withInput(['email' => $request->email]);
        }
    }
    // ===========================================================

    // Lưu session admin
    session(['admin' => [
        'id'    => $admin->id, 
        'email' => $admin->email, 
        'name'  => $admin->name
    ]]);

    return redirect()->route('admin.dashboard');
}

    public function logout(Request $request)
    {
        Session::forget('admin');
        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất thành công!');
    }

    public function dashboard()
    {
        $stats = [
            'products'       => Product::where('is_active', true)->count(),
            'orders'         => Order::count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'contacts'       => Contact::where('is_read', false)->count(),
            'users'          => User::count(),
            'revenue'        => Order::whereIn('status', ['confirmed','shipping','delivered'])->sum('total_amount'),
        ];

        $recentOrders = Order::latest()->take(6)->get();

        $topProducts = DB::table('order_items')
            ->select('product_name',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(price * quantity) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
