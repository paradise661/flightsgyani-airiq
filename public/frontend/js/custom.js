$(document).ready(function () {
    // $.fn.datepicker.defaults.format = 'yyyy-mm-dd';

    var d = new Date();
    var y = d.getFullYear();
    var m = d.getMonth();
    var day = d.getDate();

    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: false,
        toggleActive: true,
    });

    $(".old-datepicker").datepicker({
        format: "yyyy-mm-dd",
        showAnim: "drop",
        autoclose: true,
        endDate: new Date(),
        startDate: new Date(y - 100, m, day),
    });

    $("#dep_date")
        .datepicker({
            format: "yyyy-mm-dd",
            startDate: "today",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
        })
        .on("changeDate", function (selected) {
            $("#ret_date").datepicker(
                "setStartDate",
                new Date(selected.date.valueOf())
            );
            $(this).closest(".form-group").removeClass("has-error");

            $("#dep1").datepicker(
                "setStartDate",
                new Date(selected.date.valueOf())
            );
        });

    $("#ret_date")
        .datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            startDate: new Date(y, m, day + 3),
        })
        .on("changeDate", function (selected) {
            $(this).closest(".form-group").removeClass("has-error");
            $("#dep_date").datepicker(
                "setEndDate",
                new Date(selected.date.valueOf())
            );
        });

    $("#dep1").datepicker("setStartDate", new Date($("#dep_date").val()));

    $("#dep1").on("changeDate", function (selected) {
        $(this).closest(".form-group").removeClass("has-error");
        $("#dep2").datepicker(
            "setStartDate",
            new Date(selected.date.valueOf())
        );
    });

    $("#dep2").on("changeDate", function (selected) {
        $(this).closest(".form-group").removeClass("has-error");
        $("#dep3").datepicker(
            "setStartDate",
            new Date(selected.date.valueOf())
        );
    });

    $("#dep3").on("changeDate", function (selected) {
        $(this).closest(".form-group").removeClass("has-error");
        $("#dep4").datepicker(
            "setStartDate",
            new Date(selected.date.valueOf())
        );
    });

    $(".adt-dob").datepicker({
        dateFormat: "yy-mm-dd",
        yearRange: "-200:+0",

        // minDate: new Date(y - 100, m, day),
        maxDate: new Date(y - 12, m, day),
        changeYear: true,
        changeMonth: true,
    });

    $(".chd-dob").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        minDate: new Date(y - 12, m, day),
        maxDate: new Date(y - 2, m, day),
    });

    $(".inf-dob").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        minDate: new Date(y - 2, m, day),
        maxDate: new Date(y, m, day - 2),
    });

    $(".passport").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date(y, m + 6, day),
        changeMonth: true,
        changeYear: true,
    });

    $("#connectIps").on("click", function () {
        var booking = $(this).data("content");
        var token = $('meta[name="csrf_token"]').attr("content");
        $.ajax({
            type: "post",
            data: { code: booking, _token: token },
            url: "/flight/connectips",
            success: function (response) {
                $("#connectIpsPayment").attr("action", response.url);
                $("#merchantId").val(response.merchant);
                $("#appId").val(response.appId);
                $("#appName").val(response.appName);
                $("#txnId").val(response.txnId);
                $("#txnDate").val(response.date);
                $("#txnCrncy").val(response.currency);
                $("#txnAmt").val(response.amount);
                $("#referenceId").val(response.reference);
                $("#reMarks").val(response.remarks);
                $("#particulars").val(response.particulars);
                $("#token").val(response.token);

                $("#connectIpsPayment").submit();
                console.log(response);
                console.log(response.status);
            },
        });
    });

    $("#domestic-filter-dep").datepicker({
        dateFormat: "yy-mm-dd",
        startDate: "today",
        minDate: "0",
    });
    $("#domestic-filter-return").datepicker({
        dateFormat: "yy-mm-dd",
        startDate: "today",
        minDate: "0",
    });
});

$(document).ready(function () {

    function handleRadioChange(e, type) {
        if(type !== null && type !== "R") {
            type = $(this).val() || "O";
        }

        switch(type) {
            case "M":
                $(".multi-container").css("display", "grid");
                $(".twoway-block").css("display", "none");
                break;
            case "O":
                $(".multi-container").css("display", "none");
                $(".twoway-block").css("display", "block");
                $(".one-two-container").css("display", "grid");
                $(".twoway-block").css("opacity", "0.4");
                break;
            case "R":
                $(".multi-container").css("display", "none");
                $(".twoway-block").css("display", "block");
                $(".one-two-container").css("display", "grid");
                $(".twoway-block").css("opacity", "1");
                break;
            default:
                $(".multi-container").css("display", "none");
                break;
        }
    }

    function handleTwoWayBlockClick() {
        if ($("#filter-oneway").is(":checked")) {
            $("#filter-twoway").prop("checked", true);
            handleRadioChange(null, "R");
        }

        if ($("#r-filter-oneway").is(":checked")) {
            $("#r-filter-twoway").prop("checked", true);
            handleRadioChange(null, "R");
        }
    }
    $("input[name='type']").on("change", handleRadioChange);
    $(".twoway-block").on("click", handleTwoWayBlockClick);
    $(".oneway-cross").on("click", function (event) {
        event.stopPropagation(); // Prevent triggering the twoway-block click
        handleOneWayCrossClick();
    });

    // handleRadioChange();

});

$(document).ready(function () {
    const $addButton = $(".add-filter-multi");
    const $removeButton = $(".remove-filter-multi");
    const $filters = $(".filter-multi");

    // Function to update button visibility
    function updateButtons() {
        const visibleCount = $filters.filter(function () {
            return $(this).css("display") !== "none";
        }).length;

        console.log("Visible count: " + visibleCount);
        console.log("Filter length: " + $filters.length);

        // Hide add button if all are visible
        if (visibleCount === $filters.length) {
            $addButton.hide();
        } else {
            $addButton.show();
        }

        // Hide remove button if only 2 are visible
        if (visibleCount <= 2) {
            $removeButton.hide();
        } else {
            $removeButton.show();
        }
    }

    // Add button functionality
    $addButton.on("click", function (e) {
        e.preventDefault();
        $filters.each(function () {
            if ($(this).css("display") === "none") {
                $(this).css("display", "grid"); // Show the first hidden filter
                return false; // Break the loop
            }
        });
        updateButtons();
    });

    // Remove button functionality
    $removeButton.on("click", function (e) {
        e.preventDefault();

        let removeBtns = $filters.filter(function () {
            return $(this).css("display") !== "none";
        });

        removeBtns.last().css("display", "none"); // Hide the last visible filter

        updateButtons();
    });

    // Initial button visibility check
    updateButtons();
});

$(document).ready(function () {
    $(".open-international-search").on("click", function () {
        $(".international-from-to-search").css("display", "block");
    });
    $(".close-international-search").on("click", function () {
        $(".international-from-to-search").css("display", "none");
    });
    $(".open-domestic-search").on("click", function () {
        $(".domestic-from-to-search").css("display", "block");
    });

    $(".close-domestic-search").on("click", function () {
        $(".domestic-from-to-search").css("display", "none");
    });


    // Multi search offcanvas

    $(".open-multi-search-offcanvas").on("click", function () {
        const isDeparture = $(this).parents(".r-multi-from").length;
        const isArrival = $(this).parents(".r-multi-to").length;

        const index = $(this).index();

        $(".multi-search-offcanvas").css("display", "block");


        // Find the ancestor with class 'multi-city-group'
        const ancestorGroup = $(this).closest('.multi-city-group');

        // Determine the index for 'int_multi_from[]' within its global context
        const multiInputFromIndex = $("[name='int_multi_from[]']").index(
            ancestorGroup.find("[name='int_multi_from[]']")
        );

        // Determine the index for 'int_multi_to[]' within its global context
        const multiInputToIndex = $("[name='int_multi_to[]']").index(
            ancestorGroup.find("[name='int_multi_to[]']")
        );

        console.log("From Index:", multiInputFromIndex);
        console.log("To Index:", multiInputToIndex);


        if(isDeparture) {
            $("#multiCityDeparture").data("multi-input-index", multiInputFromIndex);
            $("#multiCityDeparture").val(null);
            $("#multiCityDeparture").focus();
        } else if (isArrival) {
            $("#multiCityArrival").data("multi-input-index", multiInputToIndex);
            $("#multiCityArrival").val(null);
            $("#multiCityArrival").focus();
        }
    });

    $(".close-multi-search-offcanvas").on("click", function () {
        $(".multi-search-offcanvas").css("display", "none");
    });

});
