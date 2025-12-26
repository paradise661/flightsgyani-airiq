$(document).ready(function () {
    $('#hide-payment').click(function () {
        if ($(this).is(':checked')) {
            $('.payment-details-ticket').addClass('hide');
        } else {
            $('.payment-details-ticket').removeClass('hide');
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
                    case 1:
                        $(this).find('.price-section').addClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-1');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 2:
                        // price section
                        $(this).find('.price-section').addClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-1');
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
                        $(this).find('.price-section').removeClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-1');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 4:
                        // price section
                        $(this).find('.price-section').addClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-1');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 5:
                        // price section
                        $(this).find('.price-section').addClass('p-item-5');
                        $(this).find('.price-section').removeClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-6');

                        // button section
                        $(this).find('.button-section').addClass('p-item-5');
                        $(this).find('.button-section').removeClass('p-item-1');
                        $(this).find('.button-section').removeClass('p-item-3');
                        $(this).find('.button-section').removeClass('p-item-4');
                        $(this).find('.button-section').removeClass('p-item-2');
                        $(this).find('.button-section').removeClass('p-item-6');
                        break;
                    case 6:
                        // price section
                        $(this).find('.price-section').addClass('p-item-6');
                        $(this).find('.price-section').removeClass('p-item-1');
                        $(this).find('.price-section').removeClass('p-item-2');
                        $(this).find('.price-section').removeClass('p-item-3');
                        $(this).find('.price-section').removeClass('p-item-4');
                        $(this).find('.price-section').removeClass('p-item-5');

                        // button section
                        $(this).find('.button-section').addClass('p-item-6');
                        $(this).find('.button-section').removeClass('p-item-1');
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
    });

    $('.overlay').on('click', function (e) {
        var adultCount = parseInt($('#adt_count').val());
        var childCount = parseInt($('#chd_count').val());
        var infantCount = parseInt($('#inf_count').val());

        var totalCount = adultCount + childCount + infantCount;

        if (infantCount > adultCount) {
            e.preventDefault();
            alert('Infants cannot be more than Adults..');
            return;
        }
        if (totalCount > 9) {
            e.preventDefault();
            // console.log(totalCount);
            alert('Maximum Passenger Limit Exceeded..');
            return;
        }
        // console.log($('#class_select').val());

        var classSelect = $('#class_select').val();
        var nationalitySelect = $('#nationality_select').val();

        $('#pax_class_nationality').val(totalCount + ' Pax, ' + classSelect + ', ' + nationalitySelect);

        $('#search_box_popup').slideUp(200);

        $('.overlay').css('display', 'none');

    });

    $(window).scroll(function () {
        if (window.pageYOffset > 200) {
            $('.navbar-top').addClass('navbar-top-fixed');
            $('.contact-info-top').addClass('hide');
            $('.navbar-brand img').css({'width': 'auto'});
        } else {
            $('.navbar-top').removeClass('navbar-top-fixed');
            $('.contact-info-top').removeClass('hide');
            $('.navbar-brand img').css({'width': ''});
        }
    });

    // Mouse-enter dropdown
    if ($(window).width > 991) {
        $('#navbar li').on("mouseenter", function () {
            $(this).find('ul').first().stop(true, true).delay(350).slideDown(500, 'easeInOutQuad');
        });
        // Mouse-leave dropdown
        $('#navbar li').on("mouseleave", function () {
            $(this).find('ul').first().stop(true, true).delay(200).slideUp(150, 'easeInOutQuad');
        });
    }

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

    $('#dep1').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });
    $('#dep2').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });
    $('#dep3').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });
    $('#dep4').datepicker({
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

    function valueTransfer(elem) {

        switch ($(elem).attr('id')) {
            case "int_to":
                var value = $(elem).val();
                $('#multi_from1').val(value);
                break;
            case "multi_to1":
                var value = $(elem).val();
                $('#multi_from2').val(value);
                break;
            case "multi_to2":
                var value = $(elem).val();
                $('#multi_from3').val(value);
                break;
            case "multi_to3":
                var value = $(elem).val();
                $('#multi_from4').val(value);
                break;
            default:
                // statements_def
                break;
        }
    }


});


