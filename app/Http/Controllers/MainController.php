<?php

namespace App\Http\Controllers;

use App\Http\Services\Category\CategoryService;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;
use App\Models\Product;

class MainController extends Controller
{
    protected $slider;
    protected $category;
    protected $product;

    public function __construct(SliderService $slider, CategoryService $category,
        ProductService $product)
    {
        $this->slider = $slider;
        $this->category = $category;
        $this->product = $product;
    }

    public function index()
    {
        // Lấy tất cả các danh mục cha, sử dụng eager loading để nạp danh mục con
        $categories = $this->category->getParentWithChildren(); // Chỉ lấy danh mục cha

        // Eager load children trong controller sau khi lấy dữ liệu
        foreach ($categories as $category) {
            $category->load('children');
        }

        return view('home', [
            'title' => 'TechMart',
            'sliders' => $this->slider->show(),
            'categories' => $categories, // Truyền danh mục vào view
            'products' => $this->product->get()
        ]);
    }

    

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1); // Get the current page
        $products = Product::paginate(8, ['*'], 'page', $page); // Load 8 products per request

        // Generate the HTML to add to the product list
        $html = view('products.list', compact('products'))->render();

        // Return data as JSON
        return response()->json([
            'html' => $html,
            'hasMore' => $products->hasMorePages()
        ]);
    }
}