<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Kiểm tra xem có file được tải lên không
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');

            // Tạo tên file duy nhất
            $filename = time() . '-' . $file->getClientOriginalName();

            // Lưu file vào thư mục public/uploads
            $file->move(public_path('uploads'), $filename);

            // Trả về URL của ảnh đã upload dưới dạng JSON (chỉ trả về đường dẫn từ /uploads/ trở đi)
            return response()->json([
                'error' => false,
                'url' => '/uploads/' . $filename  // Chỉ trả về phần URL cần thiết
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'No file uploaded or invalid file'
        ]);
    }
}
