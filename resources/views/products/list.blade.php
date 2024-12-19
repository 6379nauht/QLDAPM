<div class="row isotope-grid">
    @foreach($products as $key => $product)
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
            <!-- Block2 -->
            <div class="block2">
                <div class="block2-pic hov-img0">
                    <!-- Sử dụng asset() để đảm bảo đường dẫn hình ảnh chính xác -->
                    <img src="{{ asset($product->thumb) }}" alt="{{ $product->name }}" style="width: 100%; height: auto;">
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                    <div class="block2-txt-child1 flex-col-l">
                    <a href="{{ route('product.show', ['id' => $product->id, 'slug' => Str::slug($product->name, '-')]) }}"
   class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
    {{ $product->name }}
</a>


                        <span class="stext-105 cl3">
                            <!-- Hiển thị giá sản phẩm với hàm Helper::price -->
                            {!!  \App\Helpers\Helper::price($product->price, $product->price_sale) !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
