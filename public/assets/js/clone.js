/**
* Método para CLONAR divs
* @author Mayra Dantas Bueno
*/

function addCloned(element, limit = null) {
  var clonedParent = element.parents('div.cloned-main');
  clonedParent.find('div.alert').remove()
  if(clonedParent.find('div.cloned-div').length == limit){
    clonedParent.find('div.cloned-div').last().after('<div class="time-close alert alert-danger"> <button type="button" class="close" data-dismiss="alert">x</button>Limite Máximo atingido!</div>');
    return false;
  }
  var cloned = clonedParent.find('div.cloned-div').first();
  cloned.clone().insertAfter(clonedParent.find('div.cloned-div').last()).find("input").val("")

  recontar(clonedParent.find('div.cloned-div'))
  return clonedParent.find('div.cloned-div').last()
}

function clonar(clone, target){
  //Atribuição value nulo p/ todos os campos
  clone.find('input:not([type=radio],[type=checkbox]), select').val("");
  clone.find("input:checkbox, input:radio").prop('checked',false);
  //remoção de erros existentes
  clone.find('label.error').remove();
  clone.find('*').removeClass('error');
  //inserção do elemento
  clone.insertAfter(target);
}

/**
* Método para deletar div clonada
* @author Mayra Dantas Bueno
*/

$(document).on('click', 'button.delCloned', function(){
  var clonedParent = $(this).parents('div.cloned-main')

  if(clonedParent.find('div.cloned-div').length != 1)
  $(this).parents('div.cloned-div').remove();
  recontar($('div.cloned-div'))
});

function recontar(divs, callback){
  count = 0;
  $.each(divs, function(i) {
    var campos = $(this).find('input, select');
    var label = $(this).find('label');
    var titulo = $(this).find('h4.titulo');

    titulo.text(titulo.text().replace(/\d+/, (count+1)));

    $.each(campos,function(){
      $(this).attr('name', $(this).attr('name').replace(/\d+/, count));
    })
    // CALLBACK PARA USO DE DIVS ESPECÍFICAS
    if(jQuery.isFunction(callback))
    callback(i,$(this));
    count++;
  })
}
