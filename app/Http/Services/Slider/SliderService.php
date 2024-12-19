<?php


namespace App\Http\Services\Slider;


use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request)
    {
        try {
            #$request->except('_token');
            Slider::create($request->input());
            Session::flash('success', 'Thêm Slider mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider LỖI');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function get()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }

    public function update($request, $slider)
    {
        try {
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Cập nhật Slider thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật slider Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }
    public function destroy($sliderId)
    {
        // Tìm sản phẩm theo ID
        $slider = Slider::findOrFail($sliderId);
    
        // Đảm bảo đường dẫn ảnh không chứa URL đầy đủ
        $thumbPath = $slider->thumb;
    
        // Chuyển đường dẫn đầy đủ thành đường dẫn thực tế trong thư mục public
        $relativePath = str_replace(url('/') . '/public/', '', $thumbPath);
        $fullPath = public_path($relativePath);
    
        // Xóa file ảnh nếu tồn tại
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    
        // Xóa sản phẩm khỏi database
        $slider->delete();
    }

    public function show()
    {
        return Slider::where('active', 1)->orderByDesc('sort_by')->get();
    }
}