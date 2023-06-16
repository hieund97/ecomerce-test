@extends('client.layout.main')
@section('title', 'Index')
@section('content')
    <style>
        .tab-content>.active {
            display: flex !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #b7b7b7;
            font-size: 24px;
            font-weight: 700;
            list-style: none;
            display: inline-block;
            margin-right: 88px;
            cursor: pointer;
        }
    </style>
    @php
        $config = config('handle.home_category');
        $firstCategory = reset($config);
    @endphp
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            @foreach ($arySlider as $slider)
                @foreach ($slider->image as $image)
                    <div class="hero__items set-bg" data-setbg="{{ asset('storage/images/' . $image->name) }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-5 col-lg-7 col-md-8">
                                    <div class="hero__text">
                                        <h6>{{ $slider->name }}</h6>
                                        <h2>{{ $slider->title }}</h2>
                                        <p>{{ $slider->description }}</p>
                                        <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                        <div class="hero__social">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                            <a href="#"><i class="fa fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                @foreach ($aryCategory as $key => $cate)
                    <div class="{{ $loop->even ? 'col-lg-7' : 'col-lg-5' }} {{ $loop->first ? 'offset-lg-4' : '' }}">
                        <div
                            class="banner__item {{ $loop->last ? 'banner__item--last' : '' }} {{ !$loop->first && !$loop->last ? 'banner__item--middle' : '' }}">
                            <div class="banner__item__pic" style="max-width: 70%">
                                <img class="img-fluid"
                                    src="{{ asset(config('handle.show_image_path') . $cate['image']['name']) }}"
                                    alt="">
                            </div>
                            <div class="banner__item__text">
                                <h2>{{ $cate['name'] }}</h2>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class=" mb-5 filter__controls" id="pills-tab" role="tablist">
                        @foreach ($homeCategory as $cate)
                            <li
                                class="nav-item {{ $loop->first ? 'active' : '' }} mixitup-control{{ $loop->first ? '-active' : '' }}">
                                <button class="nav-link btn-home-category" id="{{ $cate->slug }}"
                                    data-id="{{ $cate->id }}" data-toggle="pill"
                                    data-target="#{{ $cate->slug }}-tab" type="button" role="tab"
                                    aria-controls="{{ $cate->slug }}-tab"
                                    aria-selected="true">{{ $cate->name }}</button>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                @foreach ($homeCategory as $cate)
                    <div class="tab-pane fade row " id="{{ $cate->slug }}-tab" role="tabpanel"
                        aria-labelledby="{{ $cate->slug . '-' . $cate->id }}"></div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="img/product-sale.png" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$29.99</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Multi-pocket Chest Bag Black</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-1.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-2.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-3.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-4.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-5.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-6.jpg"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.</p>
                        <h3>#Male_Fashion</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-1.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 16 February 2020</span>
                            <h5>What Curling Irons Are The Best Ones</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-2.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 21 February 2020</span>
                            <h5>Eternity Bands Do Last Forever</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-3.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 28 February 2020</span>
                            <h5>The Health Benefits Of Sunglasses</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var cateName = $('#pills-tab:first-child button').attr('id');
            var tabId = '#' + cateName + '-tab';
            getProductByCategory('{{ $firstCategory }}', tabId);

            $('.nav-link').on('click', function() {
                $('#pills-tabContent .active').html('');
                var cateId = $(this).data('id');
                var id = $(this).attr('id');
                var tabId = '#' + id + '-tab';

                $('#' + id + '-tab').removeClass('show').removeClass('active');
                getProductByCategory(cateId, tabId);
            });

        });

        function getProductByCategory(categoryId, tabId) {
            var path = window.location.origin + '/' + "{{ config('handle.show_image_path') }}";
            var product = '';
            $.ajax({
                type: "POST",
                url: "{{ route('get.product.by.category') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    cateID: categoryId
                },
                beforeSend: function() {
                    $('.spinner-border').show();
                },
                success: function(response) {
                    $('.spinner-border').hide();
                    response.forEach(prod => {
                        product += `<div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="${path + prod.image[0].name}">
                                                    <span class="label">New</span>
                                                    <ul class="product__hover">
                                                        <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                                        <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="product__item__text">
                                                    <h6>${prod.name}</h6>
                                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                                    <h5>$${prod.price}</h5>
                                                </div>
                                            </div>
                                        </div>`
                        $(tabId).html(product).addClass(
                                'active')
                            .addClass('show').show();
                    });

                    $('.set-bg').each(function() {
                        var bg = $(this).data('setbg');
                        $(this).css('background-image', 'url(' + bg + ')');
                    });

                }
            });
        }
    </script>
@endpush
