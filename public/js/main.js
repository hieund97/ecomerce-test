/*  ---------------------------------------------------
    Template Name: Male Fashion
    Description: Male Fashion - ecommerce teplate
    Author: Colorib
    Author URI: https://www.colorib.com/
    Version: 1.0
    Created: Colorib
---------------------------------------------------------  */
'use strict';
var ENDPOINT = window.location.origin;
(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.product__filter').length > 0) {
            var containerEl = document.querySelector('.product__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Search Switch
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Accordin Active
    --------------------*/
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active');
    });

    //Canvas Menu
    $(".canvas__open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("active");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("active");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    /*-----------------------
        Hero Slider
    ------------------------*/
    $(".hero__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='arrow_left'><span/>", "<span class='arrow_right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*-------------------
		Radio Btn
	--------------------- */
    $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").on('click', function () {
        $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").removeClass('active');
        $(this).addClass('active');
    });

    $(".product__details__option__color label").on('click', function () {
        $(".product__details__option__color label").removeClass('active');
        $(this).addClass('active');
    });

    /*-------------------
		Scroll
	--------------------- */
    $(".nice-scroll").niceScroll({
        cursorcolor: "#0d0d0d",
        cursorwidth: "5px",
        background: "#e5e5e5",
        cursorborder: "",
        autohidemode: true,
        horizrailenabled: false
    });

    /*------------------
        CountDown
    --------------------*/
    // For demo preview start
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if(mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end


    // Uncomment below and use your date //

    /* var timerdate = "2020/12/30" */

    $("#countdown").countdown(timerdate, function (event) {
        $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" + "<div class='cd-item'><span>%H</span> <p>Hours</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Minutes</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Seconds</p> </div>"));
    });

    /*------------------
		Magnific
	--------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    var proQty = $('.pro-qty-2');
    proQty.prepend('<span class="fa fa-angle-left dec qtybtn"></span>');
    proQty.append('<span class="fa fa-angle-right inc qtybtn"></span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
        var id = $button.parent().data('id');
        var price = $button.parent().data('price');
        var rowId = $button.parent().data('rowid');
 
        qtyChange(newVal, id, price, rowId);
    });

    function qtyChange(newVal, id, price, rowId){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = ENDPOINT + '/cart/qty-change';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                qty: newVal,
                rowId: rowId,
            },
            success: function (response) {
                var total = price * response.qty;
                var priceHTML = `$ ${total}`;
                $('.price-' + id).html(priceHTML);

                var totalHTML = response.total;
                $('#total-price').html('$ '+totalHTML)

                var countHTML = response.count;
                $('#number-cart').html(countHTML)
            }
        });
    }

    /*------------------
        Achieve Counter
    --------------------*/
    $('.cn_num').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

})(jQuery);

var page = 1;

function getProduct(imagePath, isLoadMore = false, data = []) {
    isLoadMore ? page = page + 1 : page = 1;
    var path = ENDPOINT + '/' + imagePath;
    var detailUrl = ENDPOINT + '/product/';
    var productHTML = '';
    var url = ENDPOINT + '/product/filter?page=' + page;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        beforeSend: function() {
            $('.spinner-border').show();
        },
        success: function(response) {
            $('.spinner-border').hide();
            response.data.forEach(prod => {
                var urlProd = detailUrl + prod.slug;
                productHTML += `<div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                            <div class="product__item__pic set-bg" data-setbg="${path + prod.image[0].name}">
                                                <ul class="product__hover">
                                                    <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                                    <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a>
                                                    </li>
                                                    <li><a href="${urlProd}"><img src="img/icon/search.png" alt=""></a></li>
                                                </ul>
                                            </div>
                                        <div class="product__item__text">
                                            <h6>${prod.name}</h6>
                                            <a href="#" class="add-cart">+ Add To Cart</a>
                                            <h5>${prod.price}</h5>
                                        </div>
                                    </div>
                                </div>`;
            });

            if (page > 1) {
                $('#product-item').append(productHTML);
            } else {
                $('#product-item').html(productHTML);
            }

            if (page == response.last_page) {
                $("#load-more-button").hide();
            } else {
                $("#load-more-button").prop('disabled', false);
                $("#load-more-button").show();
                var dataJSON = JSON.stringify(data);
                $("#data-load-more").val(dataJSON);
                $('#sort-by-select').data('prod', dataJSON);
            }

            $('#show-result').html(`Showing ${response.to} of ${response.total} results`);

            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });            
        }
    });
}

function addToCart (url, id, name, qty, price, weight, option = []) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url,
        data: {
            id: id,
            name: name,
            qty: qty,
            price: price,
            weight: weight,
            option: option,
        },
        success: function (response) {
            console.log(123);
            toastr.success('The products have been added to your cart!')
        }
    });
}