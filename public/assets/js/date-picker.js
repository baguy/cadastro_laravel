// Datepicker plugin
jQuery(function ($) {

    //link
    $('.date-picker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        language: "pt-BR"
    })
    //show datepicker when clicking on the icon
    .next().on('click', function () {
        $(this).prev().focus();
    });
});