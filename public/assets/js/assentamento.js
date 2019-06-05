// FIXME VERIFICAR O FUNCIONAMENTO DO ADD ASSENTAMENTO QUANDO O ATENDIMENTO AINDA NAO POSSUI ASSENTAMENTOS CADASTRADOS

$(document).ready(function(){
  $('.add-assentamento').on('click', function(e){
    $('.save').css('display', 'block')
    $('.cancel').css('display', 'block')
    $('.alert').css('display', 'none')

    var clone = "<div class='clonedAssentamento'>"+
                  "<p class='float-left' style='margin-bottom:0px;'>"+
                    "<b>Novo Assentamento</b>"+
                  "</p>"+
                  "<button type='button' class='btn btn-light btn-sm float-right delClonedAssentamento' style='margin-bottom:5px;'>"+
                    "<i class='fas fa-trash-alt text-danger'></i>"+
                  "</button>"+
                  "<textarea class='form-control' name='new_assentamento[]'></textarea><hr>"+
                "</div>"
    $(clone).insertAfter($('.assentamento').first())

    autosize($('textarea'));
  });
})

$(document).on('click', '.delClonedAssentamento', function(e){
  $(this).parents('.clonedAssentamento').remove()
  if( !$('.clonedAssentamento').length  ) {
    $('.save').css('display', 'none')
    $('.cancel').css('display', 'none')
    $('.alert').css('display', 'block')
  }
})

$(document).on('click', '.cancel', function(e){
  $('.save').css('display', 'none')
  $('.cancel').css('display', 'none')
  $('.alert').css('display', 'block')

  $('.clonedAssentamento').each(function(e){
    $(this).remove()
  })
})
