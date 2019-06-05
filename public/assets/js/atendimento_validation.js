$(document).ready(function(e){

  $("#AtendimentoForm").validate({
    rules: {
      individuo_id: {required: true},
      'tipo_atendimento_id[]': {required: true},
      titulo: {required: true, minlength: 3, maxlength: 200},
      descricao: {required: true, minlength: 3},
      ligacao: {required: true},
      'new_assentamento[]': {minlength: 3},
      bairro: {minlength: 3, maxlength: 75},
      numero: {number:true},
      complemento: {minlength: 2, maxlength: 200}
    },
    messages: {
      individuo_id: {required:'O campo Munícipe é obrigatório.'},
      'tipo_atendimento_id[]': {required:'O campo Categoria é obrigatório.'},
      titulo: {
        required: 'O campo Titulo é obrigatorio.',
        minlength: 'O campo Titulo deve conter no mínimo 3 caracteres.',
        maxlength: 'O campo Titulo deve conter no máximo 200 caracteres.'
      },
      descricao: {
        required: 'O campo Descrição é obrigatório.',
        minlength: 'O campo Descrição deve conter no mínimo 3 caracteres.',
      },
      bairro: {
        minlength: 'O campo Bairro deve conter no mínimo 3 caracteres.',
        maxlength: 'O campo Bairro deve conter no máximo 75 caracteres.'
      },
      numero: {
        number: 'Insira apenas números'
      },
      complemento: {
        minlength: 'O campo Complemento deve conter no mínimo 2 caracteres.',
        maxlength: 'O campo Complemento deve conter no máximo 200 caracteres.'
      },
      'new_assentamento[]': {minlength: 'O campo Descrição o assentamento deve conter no mínimo 3 caracteres.'}
    },
    errorPlacement:function(error, element) {
                      if(element.hasClass('status')) {
                        error.appendTo(element.parents().siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('individuo')) {
                        error.appendTo(element.parents().siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('tipo_atendimento')) {
                        error.appendTo(element.parents().siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('titulo')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('descricao')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('assentamento')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('estado')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('cidade')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('bairro')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('logradouro')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('numero')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }

                      if(element.hasClass('complemento')) {
                        error.appendTo(element.siblings('.invalid-feedback'))
                      }
                    }
  })
})
