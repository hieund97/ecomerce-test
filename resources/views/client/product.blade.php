@extends('client.layout.main')
@section('title', 'Products')
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
                    <h4>Shop</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('index.client') }}">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            @include('client/partials/filterProduct')

            @include('client/partials/listProduct')
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection