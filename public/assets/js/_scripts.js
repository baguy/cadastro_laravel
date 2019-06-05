jQuery.validator.addMethod("especiais", function(value, element) {
  return this.optional(element) || /^[a-z-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ0-9'"@#$&*()%!?:;+-,.{} ]+$/i.test(value);
}, "O campo deve conter apenas caracteres permitidos (a-z e 0-9 e '@#$&*()%!?:;¨.,-+)");

$(function() {

  $('.sidebar').slimScroll({
    height: 'calc(100% - 28.5px)'
  });

  $('.icheck').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass   : 'iradio_square-blue',
    increaseArea : '20%' // optional
  });
});

$(document).ready(function () {

  $('[data-popover="popover"]').popover();

  $('[data-tooltip="tooltip"]').tooltip();

  /*
  $(".cpf-mask").mask("999.999.999-99");
  $(".cnpj-mask").mask("99.999.999/9999-99");
  $(".hour-mask").mask("99:99");
  $(".date-mask").mask("99/99/9999");
  $(".cep-mask").mask("99999-999");
  $(".since-mask").mask("aaa/9999");

  $('.fone-mask').focusout(function(){

      var phone, element;
      element = $(this);
      element.unmask();
      phone = element.val().replace(/\D/g, '');

      if(phone.length > 10) {

          element.mask("(99) 99999-999?9");

      } else {

          element.mask("(99) 9999-9999?9");
      }
  }).trigger('focusout');
  */

  /*
  $('.price-mask').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.'
  });
  */

  $('#myTabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
  });
});

//Digita apenas números
$(document).ready(function () {
  //called when key is pressed in textbox
  $(".only-numbers").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
   });
});

//Digita apenas números e vígula
$(document).ready(function () {
  //called when key is pressed in textbox
  $(".only-decimals").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which !== 44 && e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
   });
});

// Remove a mensagem de sucesso
$(document).ready(function () {

  if ($('.session-flash')) {

    setTimeout(function(){

      $(".session-flash").slideUp('normal', function() {

        $(this).remove();

      });

    }, 3000);
  }
});

// Bloqueia botão e envia formulário de votação
$(document).ready(function () {

  $('.js-submit-manager-button').each(function(index) {

    $(this).click(function(e) {

      e.preventDefault();

      $(this).prop('disabled', true);

      $(`.js-submit-manager-form-${index}`).submit();
    });

  });

});
