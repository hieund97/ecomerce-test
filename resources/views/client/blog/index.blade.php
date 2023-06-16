@extends('client.layout.main')
@section('title', 'Blog')
@section('content')
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-blog set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Our Blog</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                @foreach ($aryBlog as $blog)
                    @foreach ($blog->image as $image)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic set-bg" data-setbg="{{ asset('storage/images/'.$image->name) }}"></div>
                                <div class="blog__item__text">
                                    <span><img src="img/icon/calendar.png" alt=""> {{ $blog->created_at->format('d-m-Y') }}</span>
                                    <h5>{{ $blog->name }}</h5>
                                    <a href="{{ route('blog.detail', $blog->slug) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                @endforeach
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
