    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="{{ route('index.client') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="{{ strpos(Request::route()->getName(), 'client') !== false ? 'active' : '' }}"><a
                                    href="{{ route('index.client') }}">Home</a></li>
                            <li class="{{ strpos(Request::route()->getName(), 'product') !== false ? 'active' : '' }}">
                                <a href="{{ route('index.product') }}">Shop</a>
                            </li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="./about.html">About Us</a></li>
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                                    <li><a href="./checkout.html">Check Out</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li class="{{ strpos(Request::route()->getName(), 'blog') !== false ? 'active' : '' }}"><a
                                    href="{{ route('index.blog') }}">Blog</a></li>
                            <li><a href="./contact.html">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img src="{{ asset('img/icon/search.png') }}"
                                alt=""></a>
                        <a class="notification" href="{{ route('index.cart') }}"><img
                                src="{{ asset('img/icon/cart.png') }}" alt=""> <span id="number-cart"
                                class="badge">{{ Cart::count() }}</span></a>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->