var w = document.getElementsByTagName("input");
for (var i = 0; i < w.length; i++) {
    if (
        (w[i].type === "checkbox" || w[i].type === "radio") &&
        w[i].name !== "type"
    ) {
        w[i].checked = false;
    }
}

function ajaxCall(type, dir) {
    // console.log(airline);
    // console.log(flights);

    var stops = (function () {
        var stop = [];
        $('input[type="checkbox"][name="stop[]"]').each(function () {
            if ($(this).is(":checked")) {
                stop.push($(this).val());
            }
        });
        return stop;
    })();

    var airlines = (function () {
        var airline = [];
        $('input[type="checkbox"][name="air[]"]').each(function () {
            if ($(this).is(":checked")) {
                airline.push($(this).val());
            }
        });
        return airline;
    })();

    var refund = (function () {
        var ref = "";
        $('input[type="radio"][name="refund"]').each(function () {
            if ($(this).is(":checked")) {
                ref = $(this).val();
            }
        });
        return ref;
    })();
    var departime = (function () {
        var time = [];
        $('input[type="checkbox"][name="departime[]"]').each(function () {
            if ($(this).is(":checked")) {
                time.push($(this).val());
            }
        });
        return time;
    })();

    var arrivaltime = (function () {
        var time = [];
        $('input[type="checkbox"][name="arrivaltime[]"]').each(function () {
            if ($(this).is(":checked")) {
                time.push($(this).val());
            }
        });
        return time;
    })();

    var token = $('meta[name="csrf_token"]').attr("content");
    $.ajax({
        method: "POST",
        dataType: "html",
        data: {
            airline: airlines,
            stops: stops,
            refund: refund,
            departime: departime,
            arrivaltime: arrivaltime,
            _token: token,
            type: type,
            dir: dir,
        },
        url: "sort-airline",
        beforeSend: function () {
            if(type == 'mobile') {
                $(".responsive-flight-data").hide();
            } else {
                $(".flight-data").hide();
            }
        },
        success: function (data) {
            if(type == 'mobile') {
                $(".responsive-flight-data").html(data);
            } else {
                $(".flight-data").html(data);
            }
        },
        complete: function () {
            if(type == 'mobile') {
                $('.responsive-flight-data').show();
            } else {
                // $('#preloader').hide();
                $(".flight-data").show();
            }
        },
    });
}

// $('.stop,.air,.refund,.depart,.arrival').on('click', function () {
//     ajaxCall();
// })
$(".filter-call").on("click", function () {
    const type = $(this).data("type");
    ajaxCall(type);
});

$(".sort").on("click", function () {
    var dir = $(this).data("content");
    var type = $(this).data("type");
    $("#sort-type").html(type.toUpperCase() + " -> " + dir.toUpperCase());
    if (dir === "asc") {
        $(this).attr("data-content", "des");
    } else {
        $(this).attr("data-content", "asc");
    }
    ajaxCall(type, dir);
});

$("#filter-reset").on("click", function () {
    $(":checkbox").each(function () {
        $(this).removeAttr("checked");
    });
    $('input[type="radio"]').each(function () {
        if ($(this).val() == "all") {
            $(this).attr("checked", "checked");
        } else {
            $(this).removeAttr("checked");
        }
        // $(this).removeAttr('checked')
    });
    ajaxCall();
});

$(".fare-rule").on("click", function (data, callback) {
    var index = $(this).attr("data");
    var token = $('meta[name="csrf_token"]').attr("content");
    console.log(index);
    // console.log(flights);
    $.ajax({
        method: "POST",
        cache: true,
        url: "/flight/fare-rule",
        data: { index: index, _token: token },
        dataType: "html",
        beforeSend: function () {
            //
            $(".fare-rule" + index).html(
                '<img src="/frontend/images/search-loader.gif" style="display:block;margin:0 auto">'
            );
        },
        success: function (response) {
            $(".fare-rule" + index).html(response);
        },
        complete: function () {
            $("#preloader").hide();
        },
    });
});

$(".book-form").on("submit", function () {
    Swal.fire({
        title: "Please Wait",
        text: "Confirming your Flight.",
        imageUrl: "/frontend/images/search-loader.gif",
        imageAlt: "FlightGyani",
        animation: true,
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        showCloseButton: false,
        allowEscapeKey: false,
    });
});

$.ajax({
    url: "/flight/token-time",
    method: "get",
    success: function (response) {
        return response.responseText;
    },
}).done(function (response) {
    setTimeout(function () {
        Swal.fire({
            title: "Search Again",
            text: "Air Fares has been changed.",
            imageUrl: "/frontend/images/search-loader.gif",
            imageAlt: "FlightsGyani",
            animation: true,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: true,
            showCloseButton: false,
            allowEscapeKey: false,
        }).then(function () {
            window.location.href = "/";
        });
    }, response);
});
$(".s-button").on("click", function () {
    Swal.fire({
        title: "Please Wait",
        text: "We are searching best fares for you.",
        imageUrl: "/frontend/images/search-loader.gif",
        imageAlt: "FlightsGyani",
        animation: true,
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        showCloseButton: false,
        allowEscapeKey: false,
    });
});

$('input[type="radio"][name="type"]').on("change", function () {
    var type = $(this).val();
    if (type === "M") {
        $("#parent-multi-city").show();
    } else {
        $("#parent-multi-city").hide();
    }
});

$("#multi-add-more-button").on("click", function () {
    if ($(".multi-city-area").length < 4) {
        var form =
            '<br><div class="col-12 multi-city-area pos-rel">\n' +
            '                                                <div class="col-12 ">\n' +
            '                                                    <button type="button" class="close pos-abs close-button-multi-city" aria-label="Close">\n' +
            '                                                        <span aria-hidden="true" class="" id="multi-city-close-button" onclick="hideMultiCity(this)">&times;</span>\n' +
            "                                                    </button>\n" +
            "                                                    From\n" +
            '                                                    <input type="text" class="form-control typeahead takeoff"  autocomplete="off" placeholder="From" name="int_multi_from[]"  required>\n' +
            '                                                    <span class="error hide"></span>\n' +
            "                                                </div>\n" +
            '                                                <div class="col-12">\n' +
            "                                                    To\n" +
            '                                                    <input type="text" class="form-control typeahead landing"  autocomplete="off" placeholder="To" name="int_multi_to[]" required>\n' +
            '                                                    <span class="error hide"></span>\n' +
            "                                                </div>\n" +
            '                                                <div class="col-12">\n' +
            "                                                    Departure\n" +
            '                                                    <input placeholder="Departure"   data-date-format="dd-mm-yyyy" class="form-control calendar" type="text" name="int_multi_departure[]" required autocomplete="off" readonly />\n' +
            '                                                    <span class="error hide"></span>\n' +
            "                                                </div>\n" +
            '                                                <a href="#!" title="" class="float-left remove-btn padd-4-rl" >Remove</a>\n' +
            "\n" +
            "                                            </div>";

        $(".multi-form").append(form);
        $.getScript("/front/js/typehead.js");
        $(".calendar").datepicker({
            todayBtn: 1,
            autoclose: true,
            startDate: "today",
            todayHighlight: true,
            dateFormat: "dd-mm-yyyy",
        });
        $(".remove-btn").on("click", function () {
            $(this).parent(".multi-city-area").prev($("br")).remove();
            $(this).parent(".multi-city-area").remove();

            if ($(".multi-city-area").length < 4) {
                $("#multi-add-more-button").removeClass("hide");
            }
        });
    } else {
        $(this).addClass("hide");
    }
});

$(".remove-btn").on("click", function () {
    $(this).parent(".multi-city-area").prev($("br")).remove();
    $(this).parent(".multi-city-area").remove();

    if ($(".multi-city-area").length < 4) {
        $("#multi-add-more-button").removeClass("hide");
    }
});
