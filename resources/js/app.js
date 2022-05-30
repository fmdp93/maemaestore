const bootstrap = require("bootstrap/dist/js/bootstrap.js");
const sprintf = require("sprintf-js").sprintf;
// import hotkeys from "hotkeys-js";
// window.app_exports.hotkeys = hotkeys;

// require("@popperjs/core/dist/umd/popper.min.js");
// require("./scope/barcode_reader");

import "jquery-ui/ui/widgets/datepicker.js";

$(function () {    
    $("#expiration_date, #eta, .expiration_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
    });

    var dateFormat = "yy-mm-dd",
        from = $("#from")
            .datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: dateFormat,
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
        to = $("#to")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                dateFormat: dateFormat,
            })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
});