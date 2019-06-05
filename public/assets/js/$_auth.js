$(document).ready(function () {
  $('#emailHelp').on('click', function() {
    var str = $('#email').val()
    var n = str.search('@')

    if (n == -1) {
      $('#email').val($('#email').val()+'@caraguatatuba.sp.gov.br')
      console.log('clicou')
    } else {
      str = str.split('@')
      $('#email').val(str[0]+'@caraguatatuba.sp.gov.br')
    }

  })

  $('code').click(function() {

    var $temp = $("<input>");

    $('body').append($temp);

    $temp.val($.trim($(this).text())).select();

    document.execCommand("copy");

    $temp.remove();

    doBounce($(this), 2, '3px', 100);
  });

  function doBounce(element, times, distance, speed) {

    for(i = 0; i < times; i++) {

        element.animate({ marginLeft: '-=' + distance }, speed)
            .animate({ marginLeft: '+=' + distance }, speed);
    }
  }
});
