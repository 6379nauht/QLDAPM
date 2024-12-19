<?php

namespace App\Http\Services\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CategoryService{
    public function getParent()
    {
        return Category::where('parent_id', 0)->get();
    }

    public function show()
    {
        return Category::select('name', 'id')
            ->where('parent_id', 0)
            ->orderbyDesc('id')
            ->get();
    }

    public function getAll()
    {
        return Category::orderbyDesc('id')->paginate(20);
    }

    public function create($request)
    {
        try {
            #$request->except('_token');
            Category::create($request->input());
            Session::flash('success', 'Thêm danh mục mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider LỖI');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function update($request, $category)
    {
        try {
            $category->fill($request->input());
            $category->save();
            Session::flash('success', 'Cập nhật danh mục thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật danh mục Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($categoryId)
    {
        // Tìm sản phẩm theo ID
        $category = Category::findOrFail($categoryId);
    
        // Đảm bảo đường dẫn ảnh không chứa URL đầy đủ
        $thumbPath = $category->thumb;
    
        // Chuyển đường dẫn đầy đủ thành đường dẫn thực tế trong thư mục public
        $relativePath = str_replace(url('/') . '/public/', '', $thumbPath);
        $fullPath = public_path($relativePath);
    
        // Xóa file ảnh nếu tồn tại
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    
        // Xóa sản phẩm khỏi database
        $category->delete();
    }

    public function getId($id)
    {
        return Category::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($category, $request)
    {
        $query = $category->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }


    // Lấy danh mục cha với danh mục con
    public function getParentWithChildren()
    {
        return Category::where('parent_id', 0)->get(); // Chỉ lấy danh mục cha
    }

}