<!-- Benefícios -->

  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#beneficio"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-gifts"></i> {{trans('individuos.lbl.beneficios')}}</h5>
    </div>

    <div id="beneficio" class="collapse">

        <div class="form-group" style='margin-top:10px'>

            {{ Form::label('beneficios', trans('individuos.lbl.beneficios')) }}

            {{ Form::select(
              'tipo_beneficio_id[]',
              $data['tipo_beneficio'],
              isset($data['individuo']->beneficios[0]) ? FormatterHelper::multiSelectValues($data['individuo']->tipoBeneficio) : null,
              array(
                'multiple',
                'data-live-search' => 'true',
                'class' => 'form-control selectpicker tipo_beneficio',
                'title' => trans('individuos.plh.multipla')
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
                {{ Form::label('outro_beneficio', trans('individuos.lbl.outro')) }}
                {{ Form::text(
                    'outro_beneficio',
                    isset($data['individuo']->beneficios[0])? $data['individuo']->beneficios[0]->outro : null,
                    array(
                      'class' => 'form-control',
                    )
                  )
                }}
                @if ($errors->has('outro_beneficio'))
                <div class="invalid-feedback">
                  {{ $errors->first('outro_beneficio') }}
                </div>
                @endif
              </div>

            </div><!-- .Row -->

            <div class='row'>
                <!-- Obs -->
                <div class="col-12 {{ ($errors->has('obs')) ? 'has-error' : '' }}">
                  {{ Form::label('obs_beneficio', trans('individuos.lbl.obs')) }}
                    <div>
                      {{
                        Form::text(
                          'obs_beneficio',
                          isset($data['individuo']->beneficios[0]) ? $data['individuo']->beneficios[0]->obs : null,
                          array(
                            'class' => 'form-control',
                            'style' => 'margin-bottom:20px;',
                          )
                        )
                      }}
                    </div>
                  </div>

            </div><!-- .Row -->

         </div><!-- Form-group Cloned-main -->

      </div><!-- .Collapse -->

    </div><!-- .Container -->
