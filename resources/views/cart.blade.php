<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Cart
            </span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            @php $sumPriceCart = 0; @endphp
            <ul class="header-cart-wrapitem w-full">
                @if (count($products) > 0)
                    @foreach($products as $key => $product)
                        @php
                            $price = \App\Helpers\Helper::price($product->price, $product->price_sale);
                            $sumPriceCart += $product->price_sale != 0 ? $product->price_sale : $product->price;
                        @endphp
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <!-- Sử dụng asset() để lấy đúng URL hình ảnh -->
                                <img src="{{ asset($product->thumb) }}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    {{ $product->name }}
                                </a>

                                <span class="header-cart-item-info">
                                    {!! $price !!}
                                </span>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-txt p-t-8">
                            <span class="header-cart-item-name m-b-18">
                                Your cart is empty.
                            </span>
                        </div>
                    </li>
                @endif
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    <strong>Total:</strong> {{ number_format($sumPriceCart, 0, '', '.') }} VND
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    @if (count($products) > 0)
                        <a href="{{asset('/carts')}}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="/checkout" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    @else
                        <a href="/" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Shop Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
