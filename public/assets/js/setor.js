$(document).on('keydown keyup paste', '.setor', function() {
 var search = $(this).find("input").val()

 if ($("select[name=S_setor_id]").length) {
   var select = $("select[name=S_setor_id]")
 } else {
   var select = $("select[name=setor_id]")
 }

 if(search.length > 2) {
   $.ajax({
     method: 'GET',
     url: main_url + 'ajaxfindDepartment',
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
