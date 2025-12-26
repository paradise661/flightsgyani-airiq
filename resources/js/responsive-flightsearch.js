// MultiCity Rows Logic
function getDisplayedRowCount() {
    let rows = document.querySelectorAll(".row-container > div");
    let count = 0;
    rows.forEach((row) => {
        if (row.style.display !== "none") {
            count++;
        }
    });
    return count;
}

function toggleButtons() {
    let displayedRowCount = getDisplayedRowCount();
    let addBtn = document.querySelector(".addbtn");
    let removeBtn = document.querySelector(".removebtn");

    if (addBtn && removeBtn) {
        if (displayedRowCount > 2) {
            removeBtn.style.display = "inline-block";
        } else {
            removeBtn.style.display = "none";
        }

        if (displayedRowCount === 5) {
            addBtn.style.display = "none";
        } else {
            addBtn.style.display = "inline-block";
        }
    }
}

function addRow(event) {
    event.preventDefault();
    let rows = document.querySelectorAll(".row-container > div");
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].style.display === "none") {
            rows[i].style.display = "flex";
            toggleButtons();
            return;
        }
    }
}

function removeRow(event) {
    event.preventDefault();
    let rows = document.querySelectorAll(".row-container > div");
    for (let i = rows.length - 1; i >= 0; i--) {
        if (rows[i].style.display !== "none") {
            rows[i].style.display = "none";
            toggleButtons();
            return;
        }
    }
}

document.querySelector(".addbtn")?.addEventListener("click", addRow);
document.querySelector(".removebtn")?.addEventListener("click", removeRow);
toggleButtons();

// International Radio Logic
function handleRadioChange() {
    const radioOne = document.getElementById("international-radio-one");
    const radioTwo = document.getElementById("international-radio-two");
    const radioMulti = document.getElementById("international-radio-multi");

    const singleCityDiv = document.querySelector(".r-singlecity");
    const multiCityDiv = document.querySelector(".r-multicity");
    const returnDiv = document.querySelector(".r-return");

    if (radioOne.checked || radioTwo.checked) {
        singleCityDiv.style.display = "grid";
        multiCityDiv.style.display = "none";
        returnDiv.style.opacity = radioOne.checked ? "0.4" : "1";
    } else if (radioMulti.checked) {
        singleCityDiv.style.display = "none";
        multiCityDiv.style.display = "grid";
    }
}

document
    .getElementById("international-radio-one")
    ?.addEventListener("change", handleRadioChange);
document
    .getElementById("international-radio-two")
    ?.addEventListener("change", handleRadioChange);
document
    .getElementById("international-radio-multi")
    ?.addEventListener("change", handleRadioChange);

document
    .getElementById("returnCross")
    ?.addEventListener("click", function (event) {
        event.stopPropagation();
        document.getElementById("international-radio-one").checked = true;
        handleRadioChange();
    });

document.querySelector(".r-return")?.addEventListener("click", function () {
    document.getElementById("international-radio-two").checked = true;
    handleRadioChange();
});

window.onload = handleRadioChange;

// Domestic Radio Logic
function handleDomesticRadioChange() {
    const radioOne = document.getElementById("domestic-radio-one");
    const radioTwo = document.getElementById("domestic-radio-two");

    const returnDiv = document.querySelector(".r-return-domestic");

    returnDiv.style.opacity = radioOne.checked ? "0.4" : "1";
}

document
    .getElementById("domestic-radio-one")
    ?.addEventListener("change", handleDomesticRadioChange);
document
    .getElementById("domestic-radio-two")
    ?.addEventListener("change", handleDomesticRadioChange);

document
    .getElementById("returnCross-domestic")
    ?.addEventListener("click", function (event) {
        event.stopPropagation();
        document.getElementById("domestic-radio-one").checked = true;
        handleDomesticRadioChange();
    });

document
    .querySelector(".r-return-domestic")
    ?.addEventListener("click", function () {
        document.getElementById("domestic-radio-two").checked = true;
        handleDomesticRadioChange();
    });

window.onload = handleDomesticRadioChange;

// International City/Airport Input Logic
function displayInputValues() {
    const depAirport = $("#r-depairport").val();
    const depCity = $("#r-depcity").val();
    const arrAirport = $("#r-arrairport").val();
    const arrCity = $("#r-arrcity").val();
    const arrCityFull = $('[name="arrcityfull"]').val();
    const depCityFull = $('[name="depcityfull"]').val();

    $(".d-depairport").text(depAirport);
    $(".d-depcity").text(depCity);

    $(".d-arrairport").text(arrAirport);
    $(".d-arrcity").text(arrCity);

    $(".r-depcityfull").text(depCityFull);
    $(".r-arrcityfull").text(arrCityFull);
}

function swapInputValues() {
    let depAirport = $("#r-depairport").val();
    let depCity = $("#r-depcity").val();
    let arrAirport = $("#r-arrairport").val();
    let arrCity = $("#r-arrcity").val();

    $("#r-depairport").val(arrAirport);
    $("#r-arrairport").val(depAirport);
    $('[name="depcity"]').val(arrCity);
    $('[name="destinationcity"]').val(depCity);

    const depCityFull = $('[name="depcityfull"]').val();
    const arrCityFull = $('[name="arrcityfull"]').val();

    $('[name="depcityfull"]').val(arrCityFull);
    $('[name="arrcityfull"]').val(depCityFull);

    displayInputValues();

    // let depAirport = document.getElementById("r-depairport").value;
    // let depCity = document.getElementById("r-depcity").value;
    // let arrAirport = document.getElementById("r-arrairport").value;
    // let arrCity = document.getElementById("r-arrcity").value;

    // document.getElementById("r-depairport").value = arrAirport;
    // document.getElementById("r-depcity").value = arrCity;
    // document.getElementById("r-arrairport").value = depAirport;
    // document.getElementById("r-arrcity").value = depCity;

    // displayInputValues();
}

document
    .getElementById("r-swapinput")
    ?.addEventListener("click", swapInputValues);
window.addEventListener("load", displayInputValues);

// Domestic City/Airport Input Logic
function displayDomesticInputValues() {
    const depAirport = document.getElementById("r-depairport-domestic").value;
    const depCity = document.getElementById("r-depcity-domestic").value;
    const arrAirport = document.getElementById("r-arrairport-domestic").value;
    const arrCity = document.getElementById("r-arrcity-domestic").value;

    document.getElementById("display-depairport-domestic").textContent =
        depAirport;
    document.getElementById("display-depcity-domestic").textContent = depCity;
    document.getElementById("display-arrairport-domestic").textContent =
        arrAirport;
    document.getElementById("display-arrcity-domestic").textContent = arrCity;
}

function swapDomesticInputValues() {
    let depAirport = document.getElementById("r-depairport-domestic").value;
    let depCity = document.getElementById("r-depcity-domestic").value;
    let arrAirport = document.getElementById("r-arrairport-domestic").value;
    let arrCity = document.getElementById("r-arrcity-domestic").value;

    document.getElementById("r-depairport-domestic").value = arrAirport;
    document.getElementById("r-depcity-domestic").value = arrCity;
    document.getElementById("r-arrairport-domestic").value = depAirport;
    document.getElementById("r-arrcity-domestic").value = depCity;

    displayDomesticInputValues();
}

document
    .getElementById("r-swapinput-domestic")
    ?.addEventListener("click", swapDomesticInputValues);
window.addEventListener("load", displayDomesticInputValues);
