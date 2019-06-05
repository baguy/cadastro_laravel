$(document).on('keydown keyup paste', '.funcionario', function() {
 var search = $(this).find("input").val()

 if ($("select[name=S_funcionario_id]").length) {
   var select = $("select[name=S_funcionario_id]")
 } else {
   var select = $("select[name=funcionario_id]")
 }

 if(search.length > 2) {
   $.ajax({
     method: 'GET',
     url: main_url + 'ajaxfindEmployee',
     data: {parameter: search},
     dataType: 'JSON',
     success: function(data) {
       select.empty()

       $.each(data, function(i, val) {
         select.append($('<option></option>').val(val.id).html(`${val.nome} | ${val.matricula}`))
       })

       $('.selectpicker').selectpicker('refresh')
     }
   })
 } else {
   select.empty()
   $('.selectpicker').selectpicker('refresh')
 }
})
