<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function create()
    {
        return view('admin.slider.add', [
           'title' => 'Thêm SLider mới'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $this->slider->insert($request);

        return redirect()->back();
    }
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->slider->update($request, $slider);
        if ($result) {
            return redirect('/admin/slider/list');
        }

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider Mới Nhất',
            'sliders' => $this->slider->get()
        ]);
    }

    public function show(Slider $slider)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider' => $slider
        ]);
    }

    public function destroy(Slider $slider)
    {
        // Gọi ProductService để xử lý việc xóa
        $this->slider->destroy($slider->id);
 
        // Trở về danh sách sản phẩm với thông báo
        return redirect()->route('admin.slider.list')->with('success', 'Slider đã được xóa thành công!');
    }
}
