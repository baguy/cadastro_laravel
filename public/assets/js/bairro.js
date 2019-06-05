/**
* Buscar Bairro
* no formulário editar
* @author Mayra Dantas Bueno
*/
$(document).on('keydown keyup paste', '.bairro', function() {
 var search = $(this).find("input").val()

 if ($("select[name=S_bairro]").length) {
   var select = $("select[name=S_bairro]")
 } else {
   var select = $("select[name=bairro]")
 }

 if(search.length > 2) {
   $.ajax({
     method: 'GET',
     url: main_url + 'ajaxfindBairro',
     data: {parameter: search},
     dataType: 'JSON',
     success: function(data) {
       select.empty()

       $.each(data, function(i, val) {
         select.append($('<option></option>').val(val.id).html(`${val.nome}`))
       })

       $('.selectpicker').selectpicker('refresh')
     }
   })
 } else {
   select.empty()
   $('.selectpicker').selectpicker('refresh')
 }
})
