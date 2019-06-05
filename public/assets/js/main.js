// DATA DO SISTEMA
var data_atual = new Date();

//  auto close bootstrap alerts after x seconds
window.setTimeout(function() {
  $(".time-close").fadeTo(10000, 0).slideUp(700, function(){
    $(this).remove();
  });
}, 5000);

//paginação
function paginacao(target, data, element, method){
  $.ajax({
    url: element.attr('href'),
    data: data,
    type: method,
    success: function(data){
      target.html(data);
    }
  })
}

/** FUNÇÃO DE ATRIBUIÇÃO DE ELEMENTO CLONADO
* --------------------------------------------------------
* Realiza a atribuição de elemento clonado. Os valores de
* inputs do elemento clonado são formatados.
* Utilizado p/ campos de adição de multiplos elementos.
* --------------------------------------------------------
* @param clone - elemento previamente clonado
* @param target - onde o elemento será inserido em seguida
* @author Rafael Domingues Teixeira
*/
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

/** FUNÇÃO DE RECONTAGEM DE ELEMENTOS
* ------------------------------------------------------
* Realiza a atualização de indexes de inputs, titulo, etc.
* ------------------------------------------------------
* @param divs - Seletor de elemento p/ atribuição
* @param callback - Parametro alternativo p/ atribuição de função no laço.
* @author Rafael Domingues Teixeira
*/
function recontar(divs, callback){
    count = 0;
    $.each(divs, function(i) {
        var campos = $(this).find('input, select');
        var label = $(this).find('label');
        var titulo = $(this).find('h4.titulo');

        titulo.text(titulo.text().replace(/\d+/, (count+1)));

        $.each(campos,function(){
          $(this).attr('name', $(this).attr('name').replace(/\d+/, count));
          $(this).attr('id', $(this).attr('name'));
        })
        // CALLBACK PARA USO DE DIVS ESPECÍFICAS
        if(jQuery.isFunction(callback))
            callback(i,$(this));
        count++;
    })
}

function listagem(url,tipo, form = null) {
  setLoading($('div#'+tipo))
  $.ajax({
    url: url+(url.indexOf('?') !== -1 ? "&" : "?")+$("#"+form).serialize(),
    success: function (data) {
      $('div#'+tipo).html(data)
    },
    error: function (jqXHR, exception) {
      $('div#'+tipo).html("<div class='alert alert-danger'>Desculpe, ocorreu um erro. <br> Recarregue a página e tente novamente</div>");
    },
  });
}

function AtivosInativos(resource, form = null) {

  $(document).ready(function(){
    listagem(main_url+"listagem/"+resource+"/ativos",'ativos',form);
    listagem(main_url+"listagem/"+resource+"/inativos",'inativos',form);

    $('#ativos').on('click', 'ul.pagination a', function(e){
      e.preventDefault();
      listagem($(this).attr('href'),'ativos')
    })

    $('#inativos').on('click', 'ul.pagination a', function(e){
      e.preventDefault();
      listagem($(this).attr('href'),'inativos')
    })
  })
}

// FUNÇÃO P/ DESATIVAÇÃO DE INPUTS DE ACORDO C/ VALOR DO SELECT
// SELECT VAZIO APLICA DISABLED NOS INPUTS
function disableElement(element, parent, target) {
  if(element.val() != ''){
    parent.find(target).removeAttr('disabled');
  }else{
    parent.find(target).attr('disabled','disabled');
  }
}

function attSelect(element, target, url, val) {
  var options = "<option value='' selected>Selecione</option>";

  if (element.val() !== "") {
    $.post(main_url + url, function (data) {
      $.each(data, function (index, result) {
        options += "<option value='" + result[val[0]] + "'>" + result[val[1]] + "</option>";
      });

      target.empty();
      target.append(options);
    });
  }
  target.empty();
  target.append(options);
}

function findElements(principalValue, secundaria, model, relacao, selecionado){
  var options = "<option value=''>Selecione</option>";
  if(principalValue !== "") {
    $.get(main_url + "findElements/"+model+"/"+relacao+"/" + principalValue, function (data) {
      $.each(jQuery.parseJSON(data), function (index, element) {
        options += "<option "+(selecionado == element.id ? 'selected' : '')+" value='" + element.id + "'>" + element.nome + "</option>";
      });
      secundaria.empty();
      secundaria.append(options);
      if(!Number.isInteger(selecionado) && selecionado != null){
        secundaria.find('option:contains('+selecionado.toUpperCase()+')').prop('selected',true)
      }
      if(secundaria.hasClass('chosen-select'))
        secundaria.trigger("chosen:updated");
    });
  }else{
    secundaria.empty();
    secundaria.append(options);

    if(secundaria.hasClass('chosen-select'))
      secundaria.trigger("chosen:updated");
  }
}

function setLoading(target) {
  var loading = $('<h3></h3>').attr({'class': 'text-center'})
  var img = $('<img />').attr({'src': main_url+"assets/img/svg/load.svg"})
  img.appendTo(loading)
  target.html(loading)
}

function clearStorage(){
  if(typeof(Storage) !== "undefined") {
    localStorage.clear();
  }
}

Date.prototype.addDays = function(days) {
  var date = new Date(this.valueOf());
  date.setDate(date.getDate() + days);
  return date;
}

// ********************* ONLOAD PAGE ******************** //
$(document).ready(function(){
  $('.chosen-select').chosen();

  $(".data").mask("99/99/9999");
  $(".data_nascimento").mask("99/99/9999");
  $(".cnpj").mask("99.999.999/9999-99");
  $(".cpf").mask("999.999.999-99");
  $(".cep").mask("99999-999");
  $(".placa").mask("SSS-9999");
  $(".numero").mask("9999")

  var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
  };

  $('input.telefone_numero').mask(SPMaskBehavior, spOptions).rules('add',{
    regex: /\(\d{2}\)\s\d{4,5}-?\d{4}/g,
  })

  $(document).on('click','a.delete-button',function(e){
    e.preventDefault();
    $('<form method="POST" action="'+$(this).attr('href')+'" hidden><input name="_method" value="DELETE"></form>').appendTo('body').submit();
  })

  $(document).on('click','button.show-description', function(){
    $(this).removeClass('btn-primary').addClass('btn-info').find('i').removeClass('fa-plus').addClass('fa-minus');

    if($(this).hasClass('collapsed'))
      $(this).removeClass('btn-info').addClass('btn-primary').find('i').removeClass('fa-minus').addClass('fa-plus');
  })
})

jQuery.extend(jQuery.validator.messages, {
  required: "Este campo é obrigatório!",
  remote: "O valor informado já esta em uso!",
});

jQuery.validator.setDefaults({
  ignore: ":hidden:not(.chosen-select)",
  errorPlacement: function (error, element) {
    if(element.parents('form').hasClass('form-inline'))
      error.attr('hidden','hidden');
    element.parents('.form-group').append(error);
  },

  highlight: function(element, errorClass, validClass){
    var icon  = '<div class="input-group-append check-icon"><span class="input-group-text"><i class="fa fa-exclamation validate-icon" aria-hidden="true" style="color:#f44336"></i></span></div>';
    $(element).addClass(errorClass)
    $(element).parents('.form-group').find('label.error').remove();
    $(element).parents('.input-group').find('.check-icon').remove();

    if($(element).parents('form').hasClass('form-inline')){
      $(icon).insertAfter($(element));
    }else{
      $(element).parents('.input-group').append(icon);
    }
  },

  success: function(label){
    // var icon = '<div class="input-group-append check-icon"><span class="input-group-text"><i class="fa fa-check" aria-hidden="true" style="color:green"></i></span></div>';
    label.parents('.form-group').find('.input-group').find('.check-icon').remove();
    label.parents('.form-group').find('label.error').remove();
  },

  onfocusout: function(element) {
    this.element(element);
  },
});
