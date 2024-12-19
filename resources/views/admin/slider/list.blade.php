@extends('admin.main')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tiêu Đề</th>
            <th>Link</th>
            <th>Ảnh</th>
            <th>Trang Thái</th>
            <th>Cập Nhật</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sliders as $key => $slider)
        <tr>
            <td>{{ $slider->id }}</td>
            <td>{{ $slider->name }}</td>
            <td>{{ $slider->url }}</td>
            <td>
                <a href="{{ $slider->url . $slider->thumb }}" target="_blank">
                    <img src="{{ $slider->url . $slider->thumb }}" height="40px">
                </a>
            </td>

            <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>
            <td>{{ $slider->updated_at }}</td>
            <td>
                <!-- Nút Edit -->
                <a class="btn btn-primary btn-sm" href="{{ route('admin.slider.edit', ['slider' => $slider->id]) }}">
                    <i class="fas fa-edit"></i>
                </a>

                <!-- Form Xóa Sản Phẩm -->
                <form action="{{ route('admin.slider.destroy', ['slider' => $slider->id]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $sliders->links() !!}
@endsection