@extends('client.layout.main')
@section('title', 'Cart')
@section('content')
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr class="product-{{ $item->rowId }}">
                                        <td width='10%' class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="{{ asset(config('handle.show_image_path') . $item->image) }}"
                                                    alt="">
                                            </div>

                                        </td>
                                        <td width='20%' class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5>{{ $item->name }}</h5>
                                            </div>
                                        </td>
                                        <td width='20%' class="quantity__item">
                                            <div class="quantity">
                                                <div class="pro-qty-2" data-rowid="{{ $item->rowId }}"
                                                    data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                                    <input type="text" value="{{ $item->qty }}">
                                                    <input type="hidden" class="quantity-data"
                                                        data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td width='30%' class="cart__price price-{{ $item->id }}">$
                                            {{ $item->price * $item->qty }}</td>
                                        <td width='10%' data-rowid="{{ $item->rowId }}" class="cart__close"><i
                                                class="fa fa-close delete-cart-item"></i></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="{{ route('index.product') }}">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input class="discount-code" type="text" placeholder="Coupon code">
                            <button class="submit-discount" type="button">Apply</button>
                        </form>
                        <div id="code-invalid"></div>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul id="cart-total">
                            {{-- <li>Subtotal <span>$ {{ Cart::subtotal() }}</span></li> --}}
                            <li>Total <span id="total-price">$ {{ Cart::total() }}</span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.delete-cart-item').on('click', function() {
                var rowId = $(this).parent().data('rowid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('delete.item') }}",
                    data: {
                        rowId: rowId,
                    },
                    success: function(response) {
                        $('.product-' + response.rowId).remove();
                        toastr.success("Update cart successfully!");

                        var totalHTML = response.total;
                        $('#total-price').html('$ ' + totalHTML)

                        var countHTML = response.count;
                        $('#number-cart').html(countHTML)
                    }
                });
            });

            $('.submit-discount').on('click', function() {
                var code = $('.discount-code').val();

                $.ajax({
                    type: "POST",
                    url: '{{ route('check.discount') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                    },
                    success: function(response) {
                        var html = `<li>Discount <span>$ ${response.discount}</span></li>
                                    <li>Total <span id="total-price">$ ${response.total}</span></li>`;

                        $('#cart-total').html(html)
                        $('#code-invalid').hide();
                    },
                    error: function(xhr){
                        var html = `<p style="color: red" > ${xhr.responseJSON.message} </p>`
                        $('#code-invalid').show();
                        $('#code-invalid').html(html);
                    }
                });
            });
        });
    </script>
@endpush
