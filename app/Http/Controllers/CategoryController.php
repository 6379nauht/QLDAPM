<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Category\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $menuService)
    {
        $this->categoryService = $menuService;
    }

    public function index(Request $request, $id, $slug = '')
    {
        $category = $this->categoryService->getId($id);
        $products = $this->categoryService->getProduct($category, $request);

        return view('category', [
            'title' => $category->name,
            'products' => $products,
            'category'  => $category
        ]);
    }
}