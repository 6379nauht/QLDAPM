@extends('admin.main')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Ảnh</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá Gốc</th>
            <th>Giá Khuyến Mãi</th>
            <th>Active</th>
            <th>Update</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key => $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
    <img src="{{ asset('http://localhost/DuAn_Web/public' . $product->thumb) }}" alt="{{ $product->name }}" style="max-width: 100px; max-height: 100px;">
</td>

            <td>{{ $product->name }}</td>
            <td>{{ $product->menu->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->price_sale }}</td>
            <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
            <td>{{ $product->updated_at }}</td>
            <td>
                <!-- Nút Edit -->
                <a class="btn btn-primary btn-sm" href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                    <i class="fas fa-edit"></i>
                </a>

                <!-- Form Xóa Sản Phẩm -->
                <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Phân Trang -->
<div class="card-footer clearfix">
    {!! $products->links() !!}
</div>
@endsection
