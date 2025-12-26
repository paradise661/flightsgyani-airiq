$(".airline-typeahead").typeahead({
    source: function (term, process) {
        return $.get(
            "/flight/autocomplete/airline",
            { term: term },
            function (data) {
                return process(data);
            }
        );
    },
});

$(".user-typeahead").typeahead({
    source: function (term, process) {
        return $.get("/admin/user/get", { term: term }, function (data) {
            return process(data);
        });
    },
});

// Slick slider
$(".banner-slider").slick({
    autoplay: true,
    infinite: true,
    autoplaySpeed: 5000,
    speed: 300,
    slidesToShow: 1,
    prevArrow:
        "<button type='button' class='p-3 px-4 rounded-full bg-gray-200 absolute bottom-[50%] left-2 z-10'><i class='fa-solid fa-chevron-left'></i></button>",
    nextArrow:
        "<button type='button' class='p-3 px-4 rounded-full bg-gray-200 absolute bottom-[50%] right-2 z-10'><i class='fa-sharp fa-solid fa-angle-right'></i></button>",
});
$(".flyer-slider").slick({
    autoplay: true,
    infinite: true,
    autoplaySpeed: 3000,
    speed: 300,
    slidesToShow: 1,
    arrows: false,
});
$(".daytrack").slick({
    centerMode: true,
    slidesToShow: 6,
    prevArrow:
        "<button type='button' class='p-3 px-4 rounded-full bg-primary absolute -top-1 left-0 z-10'><i class='fa-solid fa-chevron-left text-white'></i></button>",
    nextArrow:
        "<button type='button' class='p-3 px-4 rounded-full bg-primary absolute -top-1 right-0 z-10'><i class='fa-sharp fa-solid fa-angle-right text-white'></i></button>",
});
$(".r-daytrack").slick({
    centerMode: true,
    slidesToShow: 2,
    arrows: false,
});

// $('[name="flightadults"]').val(1);

// $('.traveller-btn').click(function () {
//   let child = parseInt($('[name="flightchilds"]').val());
//   let adult = parseInt($('[name="flightadults"]').val());
//   let infant = parseInt($('[name="flightinfants"]').val());

//   console.log(child, adult, infant);
//   $("#passenger-count").html(child + adult + infant);
// })

$("#intl_class_radio").change(function () {
    $(".intl-seat-class").html($('[name="class"]:checked').val());
});

$("#rTravellerRadio").change(function () {
    const adults = $(this).find('[name="flightadults"]:checked').val();
    const children = $(this).find('[name="flightchilds"]:checked').val();
    const infants = $(this).find('[name="flightinfants"]:checked').val();

    $("#travellers-count").text(
        parseInt(adults ?? 0) + parseInt(children ?? 0) + parseInt(infants ?? 0)
    );
});
$("#rDomesticTravellerRadio").change(function () {
    const adults = $(this).find('[name="domesticadultcount"]:checked').val();
    const children = $(this)
        .find('[name="domestichildrencount"]:checked')
        .val();

    $("#domestic-travellers-count").text(
        parseInt(adults ?? 0) + parseInt(children ?? 0)
    );
});

window.HSStaticMethods.autoInit();

// const el = HSInputNumber.getInstance('#hsInput');

// el.on('change', ({inputValue}) => {
//   console.log(inputValue);
// })


$(".hs-input-group").each(function () {
    const instance = HSInputNumber.getInstance(this);

    instance.on("change", calculateSum);
});

function calculateSum() {
    let totalSum = 0;

    $(".hs-input-group").each(function () {
        const instance = HSInputNumber.getInstance(this);
        const inputValue = instance.input.value;
        totalSum += parseFloat(inputValue) || 0; // Parse and add to total (default to 0 if NaN)
    });

    $("#passenger-count").text(totalSum);
}

$(".d-hs-input-group").each(function () {
    const instance = HSInputNumber.getInstance(this);

    instance.on("change", domesticCalculateSum);
});

function domesticCalculateSum() {
    let totalSum = 0;

    $(".d-hs-input-group").each(function () {
        const instance = HSInputNumber.getInstance(this);
        const inputValue = instance.input.value;
        totalSum += parseFloat(inputValue) || 0; // Parse and add to total (default to 0 if NaN)
    });

    $("#domestic-passenger-count").text(totalSum);
}


$(".m-hs-input-group").each(function () {
    const instance = HSInputNumber.getInstance(this);

    instance.on("change", mobileCalculateSum);
});

function mobileCalculateSum() {
    let totalSum = 0;

    $(".m-hs-input-group").each(function () {
        const instance = HSInputNumber.getInstance(this);
        const inputValue = instance.input.value;
        totalSum += parseFloat(inputValue) || 0; // Parse and add to total (default to 0 if NaN)
    });

    $("#m-passenger-count").text(totalSum);
}

$(".r-from").on("click", function () {
    $(".r-from-input").focus();
});

$(".r-to").on("click", function () {
    $(".r-to-input").focus();
});

$(".intSearchInputMobile").on("focus", function () {
    const direction = $(this).data("direction");
    $(this).val("");

    if (direction === "from") {
        const arrival = $('[name="destination"]').val();
        $(".r-to-input").val(arrival);
    } else if (direction === "to") {
        const departure = $('[name="departure"]').val();
        $(".r-from-input").val(departure);
    }

    console.log("Focus", direction);
});

$(".intDepartureDrop").on("click", function () {
    $("#intOrigin").focus();
});

$(".intDestinationDrop").on("click", function () {
    $("#intDestination").focus();
});

$(document).ready(function () {
    $(".flight-select").click(function () {
        $(".round-book-details").show();
    });
});

// Custom new typeahead
let airportObjects = [];
let airportMap = {};

var airport = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: "/flight/autocomplete/airport?term=%QUERY",
        wildcard: "%QUERY",
        transform: function (response) {
            // Assuming response is an array of objects with `airport` and `city` properties
            response.forEach((item) => {
                // Populate airportMap dynamically
                airportMap[item.airport] = { city: item.city };
            });
            return response; // Return the transformed response for the Typeahead suggestions
        },
    },
});


$('.intSearchInput').typeahead({
    hint: true,
    highlight: true,
    minLength: 0,
}, {
    limit: 'Infinity',
    display: "airport",
    name: 'int-search-input',
    source: airport,
    templates: {
        suggestion: function (data) {
            return `<li data- class="bg-white block w-full px-4 py-3 pr-10 border-b hover:bg-primary-background cursor-pointer">${data.airport}</li>`;
        }
    }
})
.on("typeahead:selected", function (event, item) {
    const direction = $(event.currentTarget).data("direction");

    if(direction === "from") {
        $('[name="departure"]').val(item.airport);
        $('[name="depcity"]').val(item.city);
        $('[name="depcity"]').val(item.city);
        $('[name="depcityfull"]').val(item.city_full);

        $(".d-depcity").text(item.city);
        $(".d-depairport").text(item.airport);
    } else if(direction === "to") {
        $('[name="destination"]').val(item.airport);
        $('[name="destinationcity"]').val(item.city);
        $('[name="arrcityfull"]').val(item.city_full);

        $(".d-arrcity").text(item.city);
        $(".d-arrairport").text(item.airport);
    }
})


$(".int-search-typeahead").typeahead({
    hint: false,
    highlight: true,
    minLength: 0,
}, {
    limit: 'Infinity',
    name: "int-search",
    source: airport,
    display: "airport",
    templates: {
        suggestion: function (data) {
            return `<li class="bg-white block w-full px-4 py-3 pr-10 border-b hover:bg-primary-background cursor-pointer">${data.airport}</li>`;
        },
    },
}).on("typeahead:selected", function (event, item) {
    const direction = $(event.currentTarget).attr("id");

    if($(event.currentTarget).data("type") === "mobile") {
        $(this).typeahead('val', item.city);

        switch (direction) {
            case "filter-from":
                $('[name="departure"]').val(item.airport);
                break;
            case "filter-to":
                $('[name="destination"]').val(item.airport);
                break;
        }

    }

    if(direction === "filter-from") {
        $('[name="depcity"]').val(item.city);
    } else if(direction === "filter-to") {
        $('[name="destinationcity"]').val(item.city);
    }
});

$(".int-search-typeahead").on("click", function () {
    $(this).typeahead('val', ''); // Clear the input value
    $(this).typeahead('open'); // Open the suggestion list
});



$(".multi-city-dep-typeahead")
    .typeahead({
        hint: true,
        highlight: true,
        minLength: 0,
    }, {
        limit: 'Infinity',
        display: "airport",
        name: "multi-city-dep",
        source: airport,
        templates: {
            suggestion: function (data) {
                return `<li class="bg-white block w-full px-4 py-3 pr-10 border-b hover:bg-primary-background cursor-pointer">${data.airport}</li>`;
            },
        },
    })
    .on("typeahead:selected", function (event, item) {
        const index = $(event.currentTarget).data("index");

        const depCity = $(`#multiFromCity${index}`);
        const depAirport = $(`#multiFromAirport${index}`);

        $(".multi-dep-drop").removeClass("open");
        $(
            '.multi-dep-drop > [aria-labelledby="international-departure-drop"]'
        ).removeClass("block");
        $(
            '.multi-dep-drop > [aria-labelledby="international-departure-drop"]'
        ).addClass("hidden");

        $(`.d-depcity-${index}`).text(airportMap[item.airport].city);
        $(`.d-depairport-${index}`).text(item.airport);

        depCity.val(airportMap[item.airport].city);
        depAirport.val(item.airport);

        $(`#rMultiFromAirport${index}`).val(item.airport);
    });

$(".multi-city-dest-typeahead")
    .typeahead({
        hint: true,
        highlight: true,
        minLength: 0,
    }, {
        limit: 'Infinity',
        display: "airport",
        source: airport,
        templates: {
            suggestion: function (data) {
                return `<li class="bg-white block w-full px-4 py-3 pr-10 border-b hover:bg-primary-background cursor-pointer">${data.airport}</li>`;
            },
        },
        updater: function (item) {},
    })
    .on("typeahead:selected", function (event, item) {
        const index = $(event.currentTarget).data("index");

        const depCity = $(`#multiToCity${index}`);
        const depAirport = $(`#multiToAirport${index}`);

        $(".multi-dest-drop").removeClass("open");
        $('.multi-dest-drop > [aria-labelledby="international-destination-drop"]'
        ).removeClass("block");
        $(
            '.multi-dest-drop > [aria-labelledby="international-destination-drop"]'
        ).addClass("hidden");

        $(`.d-arrcity-${index}`).text(item.city);
        $(`.d-arrairport-${index}`).text(item.airport);

        depCity.val(item.city);
        depAirport.val(item.airport);

        $(`#rMultiToAirport${index}`).val(item.airport);
    });



const observer = new MutationObserver(() => {
    window.HSStaticMethods.autoInit();
});

observer.observe(document.body, { childList: true, subtree: true });
