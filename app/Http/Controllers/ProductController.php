<?php
namespace App\Http\Controllers;

use App\Http\Services\Product\ProductService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Phương thức hiển thị chi tiết sản phẩm
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show($id = '', $slug = '')
    {
        $product = $this->productService->show($id);
        $productsMore = $this->productService->more($id);

                // Lấy tất cả danh mục để hiển thị trong menu
        $categories = Category::where('parent_id', 0)->with('children')->get();


        return view('products.content', [
            'title' => $product->name,
            'product' => $product,
            'products' => $productsMore,
            'categories' => $categories,  // Truyền danh mục vào view
        ]);
    }  
}
