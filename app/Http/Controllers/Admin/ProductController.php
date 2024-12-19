<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $this->productService->get()
        ]);
    }

    public function create()
    {
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'categories' => $this->productService->getCategory()
        ]);
    }


    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);

        return redirect()->back();
    }

    public function show(Product $product)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $product,
            'categories' => $this->productService->getCategory()
        ]);
    }


    public function update(Product $product, ProductRequest $request)
    {
        $this->productService->update($request, $product);

        return redirect('/admin/product/list');
    }

   public function destroy(Product $product)
   {
       // Gọi ProductService để xử lý việc xóa
       $this->productService->destroy($product->id);

       // Trở về danh sách sản phẩm với thông báo
       return redirect()->route('admin.product.list')->with('success', 'Sản phẩm đã được xóa thành công!');
   }
}
