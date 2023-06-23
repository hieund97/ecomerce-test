@extends('client.layout.main')
@section('title', 'Product Detail')
@section('content')

    {{-- <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Shop Details Section Begin --> --}}

    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('index.client') }}">Home</a>
                            <a href="{{ route('index.product') }}">Shop</a>
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($product->image as $key => $image)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-{{ $key }}" role="tab">
                                        <div class="product__thumb__pic set-bg"
                                            data-setbg="{{ asset('storage/images/' . $image->name) }}">
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            @foreach ($product->image as $key => $image)
                                <div class="tab-pane {{ $image->is_primary == 1 ? 'active' : '' }}"
                                    id="tabs-{{ $key }}" role="tabpanel">
                                    <div class="product__details__pic__item">
                                        <img src="{{ asset('storage/images/' . $image->name) }}" alt="">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->name }}</h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            <h3 class="price-product">
                                {{-- <span>70.00</span> --}}
                            </h3>
                            <p>{{ $product->description }}</p>
                            <div class="product__details__option row">
                                @foreach ($aryType as $type)
                                    <div
                                        class="product__details__option__{{ strtolower($type->name) }} col-lg-6 col-md-6 col-sm-6 d-flex align-items-center justify-content-center">
                                        <span>{{ $type->name }}:</span>
                                        @foreach ($product->attribute_value as $key => $value)
                                            @if ($value->attribute_id == $type->id)
                                                <label
                                                    class="{{ $value->attribute_id == config('handle.attribute_type.color') ? 'label-color' : 'label-size' }}"
                                                    style="background-color: {{ $value->color_id }}"
                                                    data-id="{{ $value->id }}" for="{{ $value->name }}"
                                                    title="{{ $value->name }}">{{ $value->attribute_id == 1 ? $value->name : '' }}
                                                    <input name="attr-{{ strtolower($type->name) }}"
                                                        class="label-attribute" type="radio" value="{{ $value->id }}"
                                                        id="{{ $value->name }}" data-type="{{ $value->attribute_id }}"
                                                        data-product="{{ $product->id }}">
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input id="prod-quantity" type="text" value="1">
                                    </div>
                                </div>
                                <button id="add-button" type="button" class="primary-btn">add to cart</button>
                                <input id="add-data" type="hidden" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                                <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Guaranteed Safe Checkout</span></h5>
                                <img src="img/shop-details/details-payment.png" alt="">
                                <ul>
                                    <li><span>SKU:</span> {{ $product->sku }}</li>
                                    <li><span>Categories:
                                            @foreach ($product->categories as $item)
                                        </span> {{ $item->name }} |
                                        @endforeach
                                    </li>
                                    <li><span>Tag:</span>
                                        @foreach ($product->tag as $tag)
                                            {{ $tag->name . ', ' }}
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                        role="tab">Description</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                        Previews(5)</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Additional
                                        information</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                            pharetras loremos.</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            {!! $product->description !!}
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                                worn all year round.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                            pharetras loremos.</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            {!! $product->additional_information !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Product</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProducts as $relatedProduct)
                    @foreach ($relatedProduct->image as $image)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="{{ asset('storage/images/' . $image->name) }}">
                                    <span class="label">New</span>
                                    <ul class="product__hover">
                                        <li><a href="#"><img src="{{ asset('img/icon/heart.png') }}"
                                                    alt=""></a></li>
                                        <li><a href="#"><img src="{{ asset('img/icon/compare.png') }}"
                                                    alt="">
                                                <span>Compare</span></a></li>
                                        <li><a href="{{ route('index.product.detail', $relatedProduct->slug) }}"><img
                                                    src="{{ asset('img/icon/search.png') }}" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $relatedProduct->name }}</h6>
                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>${{ $relatedProduct->price }}</h5>
                                    <div class="product__color__select">
                                        <label for="pc-1">
                                            <input type="radio" id="pc-1">
                                        </label>
                                        <label class="active black" for="pc-2">
                                            <input type="radio" id="pc-2">
                                        </label>
                                        <label class="grey" for="pc-3">
                                            <input type="radio" id="pc-3">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Section End -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var parentColor = $('.product__details__option__color');
            var parentSize = $('.product__details__option__size');

            parentColor.find('.label-color:first').addClass('active');
            parentSize.find('.label-size:first').addClass('active');

            var colorID = parentColor.find('.active').data('id');
            var sizeID = parentSize.find('.active').data('id');
            getVariant(colorID, sizeID, '{{ $product->id }}')

            $('.label-attribute').on('change', function() {
                var id = $(this).val();
                var type = $(this).data('type');
                var productID = $(this).data('product');
                if (type == "{{ config('handle.attribute_type.size') }}") {
                    sizeID = id;
                } else {
                    colorID = id;
                }
                getVariant(colorID, sizeID, productID);
            });

            $('#add-button').on('click', function() {
                var addUrl = `{{ route('add.to.cart') }}`
                var prodId = $('#add-data').data('id');
                var prodName = $('#add-data').data('name');
                var prodQty = $('#prod-quantity').val();
                var prodPrice = $('#data-price').data('price');
                var prodWeight = 500;
                var prodOption = {
                    'color': colorID,
                    'size': sizeID,
                };

                addToCart(addUrl, prodId, prodName, prodQty, prodPrice, prodWeight, prodOption)
            });
        });

        function getVariant(colorID, sizeID, productID) {
            $.ajax({
                type: "POST",
                url: "{{ route('get.variant') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    color: colorID,
                    size: sizeID,
                    productID: productID
                },
                success: function(response) {
                    var option = `<h3 class="price-product" data-price="${response.price}">$${response.price}</h3>
                                <input id="data-price" type="hidden" data-price="${response.price}">`;
                    $('.price-product').html(option);
                }
            });
        }
    </script>
@endpush
