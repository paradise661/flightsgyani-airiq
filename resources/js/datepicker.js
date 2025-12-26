$(function () {
    $(".multi-depdate").datepicker({
        minDate: "0",
        dateFormat: "yy-mm-dd",
    });

    $(".depdate").datepicker({
        minDate: "0",
        dateFormat: "yy-mm-dd",
        onSelect: function (date) {
            $('[name="flightdate"]').val(date);
            $("#returndate").datepicker("option", "minDate", date);
        },
    });

    $("#depdate").datepicker({
        minDate: "0",
        dateFormat: "yy-mm-dd",
        onSelect: function (date) {
            $('[name="flightdate"]').val(date);
            $("#returndate").datepicker("option", "minDate", date);
        },
    });

    $("#returndate").datepicker({
        dateFormat: "yy-mm-dd",
        startDate: "today",
        minDate: new Date($('#depdate').val()),
        onSelect: function (date) {
            $("#depdate").datepicker("option", "maxDate", date);
        },
    });
    $("#r-depdate").datepicker({
        minDate: "0",
        dateFormat: "yy-mm-dd",
        onSelect: function (date) {
            $('[name="flightdate"]').val(date);
            $(".depdate").val(date);
            $("#r-returndate").datepicker("option", "minDate", date);
        },
    });

    $("#r-returndate").datepicker({
        dateFormat: "yy-mm-dd",
        startDate: "today",
        minDate: "0",
        onSelect: function (date) {
            $("#r-depdate").datepicker("option", "maxDate", date);
        },
    });
    $("#depdate-domestic").datepicker({
        minDate: "0",
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    });
    $("#returndate-domestic").datepicker({
        minDate: "0",
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    });
    $("#r-depdate").datepicker({
        minDate: "0",
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    });
    $("#r-returndate").datepicker({
        minDate: "0",
        format: "yyyy-mm-dd",
        startDate: "today",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    });
    $("#r-depdate-domestic").datepicker({
        minDate: "0",
    });
    $("#r-returndate-domestic").datepicker({ minDate: "0" });
    $("#r-multicity1").datepicker({ minDate: "0" });
    $("#r-multicity2").datepicker({ minDate: "0" });
    $("#r-multicity3").datepicker({ minDate: "0" });
    $("#r-multicity4").datepicker({ minDate: "0" });
    $("#r-multicity5").datepicker({ minDate: "0" });
    $("#dob").datepicker();
    $("#dash-dob").datepicker();
    $("#d-report-from").datepicker();
    $("#d-report-to").datepicker();
    $("#i-report-from").datepicker();
    $("#i-report-to").datepicker();
    $("#filter-dep").datepicker();
   
});
