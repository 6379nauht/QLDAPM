@extends('main')

@section('content')
    <div class="product-detail">
        <h1>{{ $title }}</h1>
        <div class="product-info">
            <img src="{{ asset($product->thumb) }}" alt="{{ $product->name }}">
            <p>{{ $product->description }}</p>
            <p><strong>Giá: </strong>{{ number_format($product->price) }} VNĐ</p>
            <p><strong>Danh mục: </strong>{{ $product->category ? $product->category->name : 'Không có danh mục' }}</p>

        </div>

        <div class="related-products">
            <h3>Sản phẩm liên quan</h3>
            <div class="row">
                @foreach ($products as $relatedProduct)
                    <div class="col-md-3">
                        <a href="{{ route('product.show', ['id' => $relatedProduct->id, 'slug' => Str::slug($relatedProduct->name)]) }}">
                            <img src="{{ asset($relatedProduct->thumb) }}" alt="{{ $relatedProduct->name }}">
                            <p>{{ $relatedProduct->name }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Hiển thị danh mục trong menu -->
    <div class="menu">
        <ul class="main-menu">
            @foreach ($categories as $category)
                <li>
                    <a href="#">{{ $category->name }}</a>
                    @if($category->children->isNotEmpty())
                        <ul class="sub-menu">
                            @foreach ($category->children as $child)
                                <li><a href="/danh-muc/{{ $child->id }}-{{ Str::slug($child->name, '-') }}.html">{{ $child->name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
