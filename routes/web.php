<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;

// Routes liên quan đến Login
Route::get('admin/users/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('admin/users/login/store', [LoginController::class, 'store'])->name('admin.login.store');

// Routes bảo vệ bởi middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index'])->name('admin.main');

        // Routes cho Categories
        Route::prefix('category')->group(callback: function () {
            Route::get('add', [CategoryController::class, 'create'])->name('admin.category.add');
            Route::post('add', [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get('list', [CategoryController::class, 'index'])->name('admin.category.list');
            Route::get('edit/{category}', [CategoryController::class, 'show'])->name('admin.category.edit');
            Route::post('edit/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
            Route::delete('destroy/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        });

         #Product
         Route::prefix('product')->group(function () {
            Route::get('add', [ProductController::class, 'create'])->name('admin.product.add');
            Route::post('add', [ProductController::class, 'store'])->name('admin.product.store');
            Route::get('list', [ProductController::class, 'index'])->name('admin.product.list');
            Route::get('edit/{product}', [ProductController::class, 'show'])->name('admin.product.edit');
            Route::post('edit/{product}', [ProductController::class, 'update'])->name('admin.product.update');
            Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        });

         #Slider
         Route::prefix('slider')->group(function () {
            Route::get('add', [SliderController::class, 'create'])->name('admin.slider.add');
            Route::post('add', [SliderController::class, 'store'])->name('admin.slider.store');
            Route::get('list', [SliderController::class, 'index'])->name('admin.slider.list');
            Route::get('edit/{slider}', [SliderController::class, 'show'])->name('admin.slider.edit');
            Route::post('edit/{slider}', [SliderController::class, 'update'])->name('admin.slider.update');
            Route::delete('destroy/{slider}', [SliderController::class, 'destroy'])->name('admin.slider.destroy');
        });

        Route::post('upload/services', [UploadController::class, 'store'])->name('admin.upload.services');
    });
});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
// Route load thêm sản phẩm
Route::get('products/load-more', [App\Http\Controllers\ProductController::class, 'loadMore'])->name('products.loadMore');

Route::get('/danh-muc/{id}-{slug}.html', [CategoryController::class, 'show'])->name('category.show');
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/san-pham/load-more', [App\Http\Controllers\ProductController::class, 'loadMore'])->name('products.loadMore');



