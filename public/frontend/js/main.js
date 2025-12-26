(function ($) {

    "use strict";

    $('#hide-payment').click(function () {
        if ($(this).is(':checked')) {
            $('.payment-details-ticket').addClass('hidden');
        } else {
            $('.payment-details-ticket').removeClass('hidden');
        }
    });


    $('.reflow-table').find('th').each(function (index, value) {
        var $this = $(this),
            title = '<b class="cell-label">' + $this.html() + '</b>';
        // add titles to cells
        $('.reflow-table')
            .find('tr').find('td:eq(' + index + ')').wrapInner('<span class="cell-content"></span>').prepend(title);
    });


    $(window).on('load', function () {
        itemCountFunction();
    });

    $(window).on('resize', function () {
        var win = $(this);
        if (win.width() < 991) {
            // price section
            $('.price-section').removeClass('p-item-2');
            $('.price-section').removeClass('p-item-3');
            $('.price-section').removeClass('p-item-4');
            $('.price-section').removeClass('p-item-5');
            $('.price-section').removeClass('p-item-6');

            // button section
            $('.button-section').removeClass('p-item-2');
            $('.button-section').removeClass('p-item-3');
            $('.button-section').removeClass('p-item-4');
            $('.button-section').removeClass('p-item-5');
            $('.button-section').removeClass('p-item-6');
        } else {
            itemCountFunction();
        }
    });

    function itemCountFunction() {

        var itemCount = $('.flight-single');
        itemCount.each(function () {
            var totalFlight = $(this).find('.one-or-two');
            // console.log(totalFlight.length);
            if (totalFlight.length > 1) {
                // console.log('hello');
                var itemsTotal = $(this).find('.one-or-two');

                switch (itemsTotal.length) {
                    case 2:
                        // price section
                        $(this).find('.price-section').addClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 3:
                        // alert('Hello');
                        // console.log(this);
                        // price section
                        $(this).find('.price-section').addClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 4:
                        // price section
                        $(this).find('.price-section').addClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 5:
                        // price section
                        $(this).find('.price-section').addClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 6:
                        // price section
                        $(this).find('.price-section').addClass('p-item-6');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');

                        // button section
                        $(this).find('.button-section').addClass('p-item-6');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-2');
                        break;
                    default:
                        // price section
                        $('.price-section').removeClass('p-item-2');
                        $('.price-section').removeClass('p-item-3');
                        $('.price-section').removeClass('p-item-4');
                        $('.price-section').removeClass('p-item-5');
                        $('.price-section').removeClass('p-item-6');

                        // button section
                        $('.button-section').removeClass('p-item-2');
                        $('.button-section').removeClass('p-item-3');
                        $('.button-section').removeClass('p-item-4');
                        $('.button-section').removeClass('p-item-5');
                        $('.button-section').removeClass('p-item-6');
                }
            }
        });
    }

    $('#pax_class_nationality').on('click', function () {
        $('#search_box_popup').slideDown(300);
        $('.overlay').css({'display': 'block'});
        event.stopPropagation();
    });

    $('#search_box_popup').on('click', function (t) {

        var adultCount = parseInt($('#adt_count').val());
        var childCount = parseInt($('#chd_count').val());
        var infantCount = parseInt($('#inf_count').val());

        var totalCount = adultCount + childCount + infantCount;

        if (infantCount > adultCount) {
            t.preventDefault();
            alert('Infants cannot be more than Adults..');
            return;
        }
        if (totalCount > 9) {
            t.preventDefault();
            // console.log(totalCount);
            alert('Maximum Passenger Limit Exceeded..');
            return;
        }
        // console.log($('#class_select').val());

        var classSelect = $('#class_select').val();
        var nationalitySelect = $('#nationality_select').val();


        $('#pax_class_nationality').val(totalCount + ' Pax, ' + classSelect + ', ' + nationalitySelect);
        event.stopPropagation();

        // console.log($('#pax_class_nationality').val());
        // $('#search_box_popup').slideUp(200);
        // $('.overlay').css('display','none');

    });

    $('body').on('click', function () {
        $('#search_box_popup').slideUp(300);
        $('.overlay').css({'display': 'none'});
    });


    $(window).scroll(function () {
        if (window.pageYOffset > 200) {
            $('.navbar-top').addClass('navbar-top-fixed');
            $('.contact-info-top').addClass('hide');
            $('.navbar-brand img').css({'width': '150px'});
        } else {
            $('.navbar-top').removeClass('navbar-top-fixed');
            $('.contact-info-top').removeClass('hide');
            $('.navbar-brand img').css({'width': ''});
        }
    });


//   var lastScrollTop = 0;
// // element should be replaced with the actual target element on which you have applied scroll, use window in case of no target element.
//   window.addEventListener("scroll", function(){ // or window.addEventListener("scroll"....
//     var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
//     if (st < 200) {
//       //downscroll code more than 200px
//       $('.navbar-top').removeClass('navbar-top-fixed');
//     }
//     else if (st > lastScrollTop){
//       // downscroll code
//       $('.navbar-top').removeClass('navbar-top-fixed');
//     } else {
//       // upscroll code
//       $('.navbar-top').addClass('navbar-top-fixed');
//     }
//     lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
//   }, false);


    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true
    });

    $('.datepicker-today').datepicker({
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true
    });

// Mouse-enter dropdown
//
//   if ($(window).width > 991){
    $('#navbar li').on("mouseenter", function () {
        $(this).find('ul').first().stop(true, true).delay(350).slideDown(500, 'easeInOutQuad');
    });
// Mouse-leave dropdown
    $('#navbar li').on("mouseleave", function () {
        $(this).find('ul').first().stop(true, true).delay(200).slideUp(150, 'easeInOutQuad');
    });
    // }

// /**
// *  Arrow for Menu has sub-menu
// */
// if ($(window).width() > 992) {
//   $(".navbar-arrow ul ul > li").has("ul").children("a").append(" <i class='arrow-indicator fa fa-angle-right'></i>");
// };
//
// $(".searchtoggl a").attr("id","searchtoggl");$(function(){var $searchlink=$('#searchtoggl a');var $searchbar=$('#searchbar');$('#navbar li a').on('click',function(e){if($(this).attr('id')=='searchtoggl'){if(!$searchbar.is(":visible")){$searchlink.removeClass('fa-search').addClass('fa-search-minus');}else{$searchlink.removeClass('fa-search-minus').addClass('fa-search');}
//   $searchbar.slideToggle(300,function(){});}});});
//
// $(".searchtoggl a").attr("id","searchtoggl");$(function(){var $searchlink=$('#searchtoggl a');var $searchbar=$('#searchbar');$('.header-social-links-2 li a').on('click',function(e){if($(this).attr('id')=='searchtoggl'){if(!$searchbar.is(":visible")){$searchlink.removeClass('fa-search').addClass('fa-search-minus');}else{$searchlink.removeClass('fa-search-minus').addClass('fa-search');}
//   $searchbar.slideToggle(300,function(){});}});});
// /**
// * Sticky Header
// */
//
// $(window).scroll(function(){
//
//   if( $(window).scrollTop() > 10 ){
//
//     $('.navigation').addClass('navbar-sticky')
//
//   } else {
//     $('.navigation').removeClass('navbar-sticky')
//   }
// });

// /**
// * Slicknav - a Mobile Menu
// */
// var $slicknav_label;
// $('#responsive-menu').slicknav({
//   duration: 500,
//   easingOpen: 'easeInExpo',
//   easingClose: 'easeOutExpo',
//   closedSymbol: '<i class="fa fa-plus"></i>',
//   openedSymbol: '<i class="fa fa-minus"></i>',
//   prependTo: '#slicknav-mobile',
//   allowParentLinks: true,
//   label:""
// });

// Range sliders activation
    $(".range-slider-ui").each(function () {
        var minRangeValue = $(this).attr('data-min');
        var maxRangeValue = $(this).attr('data-max');
        var minName = $(this).attr('data-min-name');
        var maxName = $(this).attr('data-max-name');
        var unit = $(this).attr('data-unit');

        $(this).slider({
            range: true,
            min: minRangeValue,
            max: maxRangeValue,
            values: [minRangeValue, maxRangeValue],
            slide: function (event, ui) {
                event = event;
                var currentMin = parseInt(ui.values[0], 10);
                var currentMax = parseInt(ui.values[1], 10);
                $(this).children(".min-value").text(currentMin + " " + unit);
                $(this).children(".max-value").text(currentMax + " " + unit);
                $(this).children(".current-min").val(currentMin);
                $(this).children(".current-max").val(currentMax);
            }
        });
    });

    $('#datetimepicker1').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });

    $('#datetimepicker2').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });


    $('.package-slider').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.deals-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        dots: false,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.sale-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        dots: false,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.partners-slider').slick({
        infinite: true,
        slidesToShow: 7,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        dots: false,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.countdown').final_countdown({
        'start': 1362139200,
        'end': 1388461320,
        'now': 1387461319
    });

    $(document).on('click', '#back-to-top, .back-to-top', function () {
        $('html, body').animate({scrollTop: 0}, '500');
        return false;
    });
    $(window).on('scroll', function () {

        /* ------------------------------------------------------------------------ */
        /* BACK TO TOP
        /* ------------------------------------------------------------------------ */

        if ($(window).scrollTop() > 500) {
            $("#back-to-top").fadeIn(200);
        } else {
            $("#back-to-top").fadeOut(200);
        }

        /* ------------------------------------------------------------------------ */
        /* BACK TO TOP
        /* ------------------------------------------------------------------------ */

    });


    /**
     * Sidebar Sticky
     */

    // $('.sidebar-sticky').stickit({
    //   screenMinWidth: 992,
    //   top: 60,
    //   zIndex: 9995,
    //   className: 'when-sticky-on',
    //   overflowScrolling: true,
    //   extraHeight: 0
    // });
    //
    // $('.sidebar-sticky.sidebar-sticky-extra-height').stickit({
    //   screenMinWidth: 992,
    //   top: 60,
    //   zIndex: 9995,
    //   className: 'when-sticky-on',
    //   overflowScrolling: true,
    //   extraHeight: 100
    // });
    //
    // $('#sidebar-sticky').stickit({
    //   screenMinWidth: 992,
    //   top: 80,
    //   zIndex: 9995,
    //   className: 'when-sticky-on-id',
    //   overflowScrolling: true,
    //   extraHeight: 100,
    // });


}(jQuery));

// FlightsGyani.Com - Unbeatable offer on Internationals Holidays from Nepal

// Find best deals at FlightsGyani for âœ… Flight Tickets, Hotels, Holiday Packages Reservations for Nepal  & International travel
