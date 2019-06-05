// Datepicker plugin
jQuery(function ($) {

    //link
    $('.date-picker-year').datepicker({
        format: 'yyyy',
        autoclose: true,
        language: "pt-BR",
        viewMode: "years", 
        minViewMode: "years"
    })
    //show datepicker when clicking on the icon
    .next().on('click', function () {
        $(this).prev().focus();
    });
});