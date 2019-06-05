$(document).ready(function() {
  $('.datas').mask('00/00/0000')

  /**
  * Habilitar campo select Tipo Encerrado quando
  * selecionado checkbox Encerrar Atendimento
  * @author Mayra Dantas Bueno
  */

    // var status_encerrado = $('#status_encerrado');
    // var tipo_encerrado = $('#tipo_encerrado');
    //
    // $(status_encerrado).change(async function () {
    //   mudaEncerrado(status_encerrado.val());
    //   console.log('dfkjgv')
    // });

    function mudaEncerrado(){
      var status_encerrado = document.getElementById('status_encerrado');
      var tipo_encerrado = document.getElementById('tipo_encerrado');
      console.log('status_encerrado')
      if(status_encerrado.checked == 3){
        $('#tipo_encerrado').removeAttr('disabled');
      }else{
        $('#tipo_encerrado').attr('disabled', true);
      }
    }


})

// pesquisar indivíduo por nome ou CPF
$(document).on('keydown keyup paste', '.individuo', function() {
 var search = $(this).find("input").val()

 if ($("select[name=S_individuo_id]").length) {
   var select = $("select[name=S_individuo_id]")
 } else {
   var select = $("select[name=individuo_id]")
 }

 if(search.length > 2) {
   $.ajax({
     method: 'GET',
     url: main_url + 'ajaxfindPerson',
     data: {parameter: search},
     dataType: 'JSON',
     success: function(data) {
       select.empty()

       $.each(data, function(i, val) {
         select.append($('<option></option>').val(val.id).html(`${val.nome} | ${val.numero}`))
       })

       $('.selectpicker').selectpicker('refresh')
     }
   })
 } else {
   select.empty()
   $('.selectpicker').selectpicker('refresh')
 }
})

$(document).on('change','.idoso',function(){
   if($(this).find("option:selected").attr('value') == 1){

   }
}); // pesquisar por pessoa

$(document).on('click', '.delClonedAssentamento', function(e){
  $(this).parents('.clone-main').remove()
  // if( !$('.clone').length ) {
  //   cloneAssentamento('')
  // }
})

$(document).ready(function(){
  $('.add-assentamento').on('click', function() {
    cloneAssentamento()
  })
})

function cloneAssentamento() {
  var clone = "<div class='form-group col-md-12 clone'>"+
                "<div class='assentamento'>"+

                  "<div class='input-group'>"+
                    "<div class='input-group-prepend'>"+
                      "<span class='input-group-text'>"+
                        "<i class='fas fa-comments fa-fw'></i>"+
                      "</span>"+
                    "</div>"+

                    "<textarea class='form-control' name='new_assentamento[]' placeholder='Assentamento'></textarea>"+
                  "</div><hr>"+
                "</div>"+
              "</div>"
  if( !$('.clone').length ) {
    $(clone).insertAfter($('.clone-main').first())
  }
  else {
    $(clone).insertBefore($('.clone-main').first())
  }
  autosize($('textarea'));
}
