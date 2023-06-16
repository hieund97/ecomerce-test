<div class="col-lg-3">
    <div class="shop__sidebar">
        <div class="shop__sidebar__search">
            <form action="" method="POST">
                @csrf
                <input class='search-bar' type="text" placeholder="Search...">
                <button type="button"><span class="icon_search submit-search-bar"></span></button>
            </form>
        </div>
        <div class="shop__sidebar__accordion">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="shop__sidebar__categories">
                                <ul class="nice-scroll">
                                    @foreach ($aryCategory as $category)
                                        <li class="cate-select" data-id="{{ $category->id }}" style="cursor: pointer">
                                            <a id="cate-{{ $category->id }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                    </div>
                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="shop__sidebar__price">
                                <ul>
                                    <li class="price-select" data-start="0" data-end="50" style="cursor: pointer">
                                        <a id="price-filter-0">$0.00 - $50.00</a>
                                    </li>
                                    <li class="price-select" data-start="50" data-end="100" style="cursor: pointer">
                                        <a id="price-filter-50">$50.00 - $100.00</a>
                                    </li>
                                    <li class="price-select" data-start="100" data-end="150" style="cursor: pointer">
                                        <a id="price-filter-100">$100.00 - $150.00</a>
                                    </li>
                                    <li class="price-select" data-start="150" data-end="200" style="cursor: pointer">
                                        <a id="price-filter-150">$150.00 - $200.00</a>
                                    </li>
                                    <li class="price-select" data-start="200" data-end="250" style="cursor: pointer">
                                        <a id="price-filter-200">$200.00 - $250.00</a>
                                    </li>
                                    <li class="price-select" data-start="250" style="cursor: pointer"><a
                                            id="price-filter-250">250.00+</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                    </div>
                    <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="shop__sidebar__size">
                                @foreach ($arySize as $size)
                                    <label class="size-select" data-id="{{ $size->id }}">{{ $size->name }}
                                        <input type="radio" id="xs">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                    </div>
                    <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="shop__sidebar__color">
                                @foreach ($aryColor as $color)
                                    <label id="color-{{ $color->id }}" class="color-select"
                                        data-id="{{ $color->id }}" style="background: {{ $color->color_id }}">
                                        <input type="radio">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                    </div>
                    <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="shop__sidebar__tags">
                                @foreach ($aryTag as $tag)
                                    <a id="tag-{{ $tag->id }}" class="tag-select" data-id="{{ $tag->id }}"
                                        style="cursor: pointer;">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var currentType = 'all';
        var checkEmpty = false;
        var imagePath = `{{ config('handle.show_image_path') }}`
        $(document).ready(function() {
            $('.spinner-border').hide();

            $('.price-select').on('click', function() {
                var startPrice = $(this).data('start');
                var endPrice = $(this).data('end');
                var data = {
                    type: '{{ config('handle.filter.type.price') }}',
                    start: startPrice,
                    end: endPrice,
                };

            
                if ($('#price-filter-' + startPrice).hasClass('active')) {
                    showIndexProduct();
                } else {
                    $('.shop__sidebar__price ul li a.active').removeClass('active');
                    $('#price-filter-' + startPrice).addClass('active');
                    filterProduct(data);
                }
            });

            $('.color-select').on('click', function(e) {
                e.preventDefault();
                var colorID = $(this).data('id');
                $('.shop__sidebar__color label.active').removeClass('active');

                $('#color-' + colorID).addClass('active');

                var data = {
                    type: '{{ config('handle.filter.type.color') }}',
                    color: colorID,
                };

                getProduct(imagePath, checkEmpty, data);
            });

            $('.size-select').on('click', function(e) {
                e.preventDefault();
                var sizeID = $(this).data('id');
                var data = {
                    type: '{{ config('handle.filter.type.size') }}',
                    size: sizeID,
                };

                getProduct(imagePath, checkEmpty, data);
            });

            $('.tag-select').on('click', function() {
                var tagID = $(this).data('id');
                $('.shop__sidebar__tags a.active').removeClass('active');

                $('#tag-' + tagID).addClass('active');

                var data = {
                    type: '{{ config('handle.filter.type.tag') }}',
                    tag: tagID,
                };

                getProduct(imagePath, checkEmpty, data);
            });

            $('.cate-select').on('click', function() {
                var cateID = $(this).data('id');
                var data = {
                    type: '{{ config('handle.filter.type.category') }}',
                    cate: cateID,
                };

                $('.shop__sidebar__categories ul li a.active').removeClass('active');
                $('#cate-' + cateID).addClass('active');

                getProduct(imagePath, checkEmpty, data);
            });

            $('.submit-search-bar').on('click', function() {
                var searchData = $('.search-bar').val();
                // console.log(searchData);
                var data = {
                    type: '{{ config('handle.filter.type.search') }}',
                    search: searchData,
                }

                getProduct(imagePath, checkEmpty, data);
            });
        });

        // function filterProduct(data) {
        //     var path = window.location.origin + '/' + "{{ config('handle.show_image_path') }}";
        //     var productHTML = '';
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: '{{ route('index.filter') }}',
        //         method: 'POST',
        //         data: data,
        //         beforeSend: function() {
        //             $('.spinner-border').show();
        //         },
        //         success: function(response) {
        //             $('.spinner-border').hide();


        //             response.data.forEach(prod => {
        //                 productHTML += ` <div class="col-lg-4 col-md-6 col-sm-6">
        //                     <div class="product__item">
        //                         <div class="product__item__pic set-bg" data-setbg="${path + prod.image[0].name}">
        //                             <ul class="product__hover">
        //                                                 <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
        //                                                 <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a>
        //                                                 </li>
        //                                                 <li><a href=""><img src="img/icon/search.png" alt=""></a></li>
        //                                                 </ul>
        //                                                 </div>
        //                                                 <div class="product__item__text">
        //                                                     <h6>${prod.name}</h6>
        //                                                     <a href="#" class="add-cart">+ Add To Cart</a>
        //                                                     <h5>${prod.price}</h5>
                                                            
        //                                                     </div>
        //                                                     </div>
        //                                                     </div>`;
        //             });
        //             if(checkEmpty){
        //                 $('#product-item').html('');
        //             }

        //             $('#product-item').html(productHTML);

        //             $('.set-bg').each(function() {
        //                 var bg = $(this).data('setbg');
        //                 $(this).css('background-image', 'url(' + bg + ')');
        //             });
        //             currentType = data.type;
        //         }
        //     });
        // }
    </script>
@endpush
