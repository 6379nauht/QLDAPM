<?php


namespace App\Http\Services\Product;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProductAdminService
{
    public function getCategory()
    {
        return Category::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }

    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            $request->except('_token');
            Product::create($request->all());

            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            return  false;
        }

        return  true;
    }

    public function get()
    {
        return Product::with('menu')
            ->orderByDesc('id')->paginate(15);
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Cập nhật thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi vui lòng thử lại');
            return false;
        }
        return true;
    }

    public function destroy($productId)
    {
        // Tìm sản phẩm theo ID
        $product = Product::findOrFail($productId);
    
        // Đảm bảo đường dẫn ảnh không chứa URL đầy đủ
        $thumbPath = $product->thumb;
    
        // Chuyển đường dẫn đầy đủ thành đường dẫn thực tế trong thư mục public
        $relativePath = str_replace(url('/') . '/public/', '', $thumbPath);
        $fullPath = public_path($relativePath);
    
        // Xóa file ảnh nếu tồn tại
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    
        // Xóa sản phẩm khỏi database
        $product->delete();
    }
}