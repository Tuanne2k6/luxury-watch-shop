<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ContactAdminController;

// ── Trang chủ & Giới thiệu ──────────────────────────────────
Route::get('/',           [HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');

// ── Sản phẩm ────────────────────────────────────────────────
Route::get('/san-pham',        [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tim-kiem',        [ProductController::class, 'search'])->name('products.search');

// ── Giỏ hàng ────────────────────────────────────────────────
Route::get('/gio-hang',                [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{id}',     [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/cap-nhat/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/gio-hang/xoa/{id}',      [CartController::class, 'remove'])->name('cart.remove');
Route::post('/gio-hang/xoa-het',       [CartController::class, 'clear'])->name('cart.clear');

// ── Đặt hàng ────────────────────────────────────────────────
Route::get('/dat-hang',             [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/dat-hang',            [OrderController::class, 'placeOrder'])->name('order.place');
Route::get('/dat-hang/{code}/xong', [OrderController::class, 'success'])->name('order.success');

// ── Liên hệ ─────────────────────────────────────────────────
Route::get('/lien-he',  [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

// ── Auth ─────────────────────────────────────────────────────
Route::get('/dang-ky',    [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/dang-ky',   [AuthController::class, 'register'])->name('auth.register.post');
Route::get('/dang-nhap',  [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('auth.login.post');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('auth.logout');

// ════════════════════════════════════════════════════════════
// ADMIN ROUTES
// ════════════════════════════════════════════════════════════
Route::prefix('admin')->group(function () {

    // Login/Logout (không cần middleware)
    Route::get('/dang-nhap',  [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/dang-nhap', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/dang-xuat', [AdminController::class, 'logout'])->name('admin.logout');

    // Protected routes
    Route::middleware('admin')->group(function () {

        Route::get('/trangchu', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Sản phẩm
        Route::get('/san-pham',                      [ProductAdminController::class, 'index'])->name('admin.products.index');
        Route::get('/san-pham/them-moi',             [ProductAdminController::class, 'create'])->name('admin.products.create');
        Route::post('/san-pham',                     [ProductAdminController::class, 'store'])->name('admin.products.store');
        Route::get('/san-pham/{product}/sua',        [ProductAdminController::class, 'edit'])->name('admin.products.edit');
        Route::put('/san-pham/{product}',            [ProductAdminController::class, 'update'])->name('admin.products.update');
        Route::delete('/san-pham/{product}',         [ProductAdminController::class, 'destroy'])->name('admin.products.destroy');
        Route::post('/san-pham/{product}/noi-bat',   [ProductAdminController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');
        Route::post('/san-pham/{product}/hien-thi',  [ProductAdminController::class, 'toggleActive'])->name('admin.products.toggle-active');

        // Đơn hàng
        Route::get('/don-hang',                      [OrderAdminController::class, 'index'])->name('admin.orders.index');
        Route::get('/don-hang/{order}',              [OrderAdminController::class, 'show'])->name('admin.orders.show');
        Route::post('/don-hang/{order}/trang-thai',  [OrderAdminController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::delete('/don-hang/{order}',           [OrderAdminController::class, 'destroy'])->name('admin.orders.destroy');

        // Liên hệ
        Route::get('/lien-he',                       [ContactAdminController::class, 'index'])->name('admin.contacts.index');
        Route::get('/lien-he/{contact}',             [ContactAdminController::class, 'show'])->name('admin.contacts.show');
        Route::delete('/lien-he/{contact}',          [ContactAdminController::class, 'destroy'])->name('admin.contacts.destroy');
        Route::post('/lien-he/da-doc-tat-ca',        [ContactAdminController::class, 'markAllRead'])->name('admin.contacts.mark-all-read');
    });
});
