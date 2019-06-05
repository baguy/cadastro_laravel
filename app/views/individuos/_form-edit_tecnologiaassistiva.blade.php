<!-- Benefícios -->

  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#tecnologiaassistiva"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-keyboard"></i> {{trans('individuos.lbl.tecnologia')}}</h5>
    </div>

    <div id="tecnologiaassistiva" class="collapse">

        <div class="form-group">

          <!-- Prefeitura -->
          <div class="col-4 {{ ($errors->has('prefeitura_tecnologia')) ? 'has-error' : '' }}" style="margin-top:10px;">
            {{ Form::checkbox(
              'prefeitura_tecnologia',
              true, isset($data['individuo']->tecnologiaAssistiva[0]) ? $data['individuo']->tecnologiaAssistiva[0]->prefeitura : null
              )
            }}
            {{ Form::label('status_ensino', trans('individuos.lbl.prefeitura_tecnologia')) }}
          </div>

              {{ Form::select(
                'tipo_tecnologia_assistiva_id[]',
                $data['tipo_tecnologia_assistiva'],
                isset($data['individuo']->tecnologiaAssistiva[0]) ? FormatterHelper::multiSelectValues($data['individuo']->tipoTecnologiaAssistiva) : null,
                array(
                  'multiple',
                  'data-live-search' => 'true',
                  'class' => 'form-control selectpicker tipo_tecnologia_assistiva',
                  'title' => 'SELECIONE TECNOLOGIA ASSISTIVA'
                  )
                )
              }}

              <div class="invalid-feedback" style="display:block !important">
                @if ($errors->has('tipo_atendimento_id'))
                  {{ $errors->first('tipo_atendimento_id') }}
                @endif
              </div>


              <div class="row">
                <!-- Outro -->
                <div class="col-12 {{ ($errors->has('nome_parente')) ? 'has-error' : '' }}">
                  {{ Form::label('outro_tecnologia', trans('individuos.lbl.outro')) }}
                  {{ Form::text(
                      'outro_tecnologia',
                      isset($data['individuo']->tecnologiaAssistiva[0])? $data['individuo']->tecnologiaAssistiva[0]->outro : null,
                      array(
                        'class' => 'form-control',
                      )
                    )
                  }}
                  @if ($errors->has('outro_tecnologia'))
                  <div class="invalid-feedback">
                    {{ $errors->first('outro_tecnologia') }}
                  </div>
                  @endif
                </div>

              </div><!-- .Row -->

         </div><!-- Form-group Cloned-main -->

        </div><!-- .Collapse -->

    </div><!-- .Container -->
