<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Services\Category\CategoryService;
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function create()
    {
        return view('admin.category.add', [
            'title' => "Thêm Danh Mục Mới",
            'categories' => $this->categoryService->getParent()
        ]);
    }
    public function index()
    {
        return view('admin.category.list', [
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'categories' => $this->categoryService->getAll()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFormRequest  $request)
    {
        $this->categoryService->create($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.category.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $category->name,
            'category' => $category,
            'categories' => $this->categoryService->getParent()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function destroy(Category $category)
    {
        // Gọi CategoryService để xử lý việc xóa
        $this->categoryService->destroy($category->id);

        // Trở lại danh sách danh mục với thông báo thành công
        return redirect()->route('admin.category.list')->with('success', 'Danh mục đã được xóa thành công!');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, CreateFormRequest $request)
    {
        $this->categoryService->update($request, $category);

        return redirect('/admin/category/list');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    
    
}
