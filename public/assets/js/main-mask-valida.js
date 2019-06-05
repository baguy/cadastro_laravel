/**
* Máscaras para campos do formulário de indivíduos
* @author Mayra Dantas Bueno
*/

$(document).ready(function(){
  $("#nis").mask("999.99999.99-9");
  $(".data").mask("99/99/9999");
  $("#cpf").mask("999.999.999-99");
  $("#cep").mask("99999-999");
  $("#ramal").mask("0000");
  $(".ddd_mask").mask("00");
  $('.renda_familiar').mask('000.000.000.000.000,00', {reverse: true});
  $('.datas').mask('00/00/0000');

  /**
  * Máscara de telefone caso número tenha 8 ou 9 dígitos
  * @author Mayra Dantas Bueno / Rodrigo Borges
  */

  var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
  };
  $('.telefone_mask').mask(SPMaskBehavior, spOptions);


  var idIndividuo = null;
  var idIndividuoEdit = null;

  if($('#IndividuoForm').attr('data-individuo_id')){
    idMunicipe = $('#IndividuoForm').attr('data-individuo_id');
  }
  if($('#IndividuoFormEdit').attr('data-individuoedit_id')){
    idIndividuoEdit = $('#IndividuoFormEdit').attr('data-individuoedit_id');
  }

  /**
  * Mensagens de validação
  * @author Mayra Dantas Bueno
  */

  jQuery.extend(jQuery.validator.messages, {
    required: "Esse campo é obrigatório",
    email: "Digite um email válido",
    validaDataBR: "Digite uma data válida",
    digits: "Digite apenas números",
    minlength: "Este campo deve ter no mínimo {0} caracteres",
    maxlength: "Este campo não deve ultrapassar {0} caracteres",
    number: "Digite apenas números",
    letras: "Este campo não aceita números nem caracteres especiais",
  });

  /**
  * Requisitos de validação front-end
  * alguns métodos adicionais se encontram em validate-methods.js
  * @author Mayra Dantas Bueno
  */

  $.each($("form"), function(i){
    $(this).validate({
      ignore: ":hidden:not(.do-not-ignore)",
      rules: {
      //====================== VIEWS WITH SEARCH INPUTS====================//
      buscar: {
        required:true,
        maxlength:70,
        letras:true,
      },
      // ===================== MUNÍCIPES ===================== //
      nome: {
        required: true,
        maxlength: 100,
        minlength: 3,
        letras: true,
      },
      sexo_id: {
        required: true
      },
      email:{
        email: true,
      },
      data_nascimento: {
        required: true,
        validaDataBR: true,
      },
      tipo_estado_civil: {
        required: true,
      },
      data_casamento: {
        validaDataBR: true,
      },
      ddd_mask:{
        required: true,
        minlength: 1,
        number: true,
      },
      telefone_mask:{
        required: true,
        minlength: 8,
        number: true,
      },
      tipo_telefone_id:{
        required: true,
      },
      cep:{
        // number: true,
      },
      estado:{
        required: true,
      },
      cidade:{
        required: true,
      },
      logradouro:{
        required: true,
        maxlength: 100,
        minlength: 3,
      },
      numero:{
        number: true,
      },
      bairro:{
        required: true,
      },
      complemento:{
        maxlength: 200,
        minlength: 2,
      },
      nome_parente:{
        required: true,
        maxlength: 100,
        minlength: 3,
        letras: true,
      },
      tipo_parentesco_id:{
        required: true,
      },
      tipo_escolaridade_id:{
        required: true,
      },
      tipo_trabalho_id:{
        required: true,
      },
      vida_diaria:{
        required: true,
      },
      tipo_atividade_esporte:{
        required: true,
      },
      tipo_atividade_cultural:{
        required: true,
      },
      tipo_moradia_id:{
        required: true,
      },
      tipo_imovel_id:{
        required: true,
      },
      tipo_renda_id:{
        required: true,
      },
      tipo_renda_id:{
        required: true,
        digits:true,
      },
      sugestao:{
        required:true,
        minlength: 3,
      },
      tipo_informacao_origem_id:{
        required:true,
      },
      tipo_informacao_id:{
        required:true,
      },

      // ===================== DOCUMENTO ===================== //

      cpf: {
        regex: "^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$",
        verificaCPF: true,
      },
      sus:{
        digits: true,
      },
      estado: {
        required: true,
      },
      nis: {
        // required: true,
        regex: "^[0-9]{3}.[0-9]{5}.[0-9]{2}-[0-9]{1}$",
      },
    },

      // ===================== MAPA ===================== //

    messages:{
      longitude: {
        required: "É obrigatória a marcação no mapa"
      }
    },
    //
    // invalidHandler: function(e,validator) {
    //     for (var i=0;i<validator.errorList.length;i++){
    //         $(validator.errorList[i].element).parents('.collapse').collapse('show');
    //     },

    /**
    * Inserir mensagem de validação após o elemento
    * @author Mayra Dantas Bueno
    */

    errorPlacement: function (error, element) {
      if (element.hasClass('telefone-mask')){
        error.insertAfter(element).addClass('tel-erro');
      // }
      // if ( element.attr('type') == 'select' || element.attr('type') == 'radio'){
      //         error.addClass('not_icon');
      }else {
        error.insertAfter(element).parents('.collapse').collapse('show');
      }
    },

    /**
    * "Iluminar" de vermelho os inputs com informações erradas — desabilitado
    * @author Mayra Dantas Bueno
    */

    highlight: function(element, errorClass){
      $(element).parent().parent().removeClass('has-success has-error');
      // $(element).parent().find('.check-icon').remove();
      $(element).parent().find('.material-input').remove();
      // $(element).insertBefore(element).addClass('control-label');
      // $(element).parent().parent().addClass('has-error');
      // if ($(element).attr('type') !== 'radio') {
      //   $(element).parent().append('<div class="input-group-addon check-icon"><span class="form-control-feedback"><i class="fa fa-exclamation" aria-hidden="true" style="color:red"></i></span></div>');
      // }
    },

    /**
    * Inserir ícones de correto ou errado caso a validação falhe ou não — desabilitado
    * @author Mayra Dantas Bueno
    */

    // success: function(label){
    //   label.parent().parent().removeClass('has-error has-success');
    //   // label.parent().find('.check-icon').remove();
    //   label.parent().find('.material-input').remove();
    //   label.addClass('control-label');
    //   // if (!label.hasClass('not_icon')) {
    //   //   label.parent().append('<div class="input-group-addon check-icon"><span class="form-control-feedback"><i class="fa fa-check" aria-hidden="true" style="color:green"></i></span></div>');
    //   //   label.parent().parent().addClass('has-success');
    //   // }
    // },

  });

})

})
