<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Category\CategoryService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;

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
        return view('admin.home', [
           'title' => 'Trang Quản Trị Admin'
        ]);
    }

    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products' => $result ])->render();

            return response()->json([ 'html' => $html ]);
        }

        return response()->json(['html' => '' ]);
    }
}
