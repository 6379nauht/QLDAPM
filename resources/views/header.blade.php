<header>
    <div class="container-menu-desktop">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <!-- Logo -->
                <a href="/" class="logo">
                    <img src="{{ asset('/uploads/logo.jpg') }}" alt="IMG-LOGO">
                </a>

                <!-- Menu Desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a href="/">Trang Chủ</a></li>

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

                        <li><a href="/contact">Liên Hệ</a></li>
                    </ul>
                </div>

                <!-- Icon Header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- Menu Mobile -->
<div class="menu-mobile">
    <ul class="main-menu-m">
        <li class="active-menu"><a href="/">Trang Chủ</a></li>

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

        <li><a href="/contact">Liên Hệ</a></li>
    </ul>
</div>
