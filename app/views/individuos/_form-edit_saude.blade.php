<!-- Saúde, acompanhamento e medicação -->
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#saude"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-heartbeat"></i> {{trans('individuos.lbl.saude_acompanhamento')}}</h5>
    </div>

    <div id="saude" class="collapse">

        <div class="form-group row">

            <div class="col-8">

              {{ Form::label('assistencia_saude', trans('individuos.lbl.assistencia_saude')) }}

              {{ Form::select(
                'tipo_saude_id[]',
                $data['tipo_saude'],
                isset($data['individuo']->saudes[0]) ? FormatterHelper::multiSelectValues($data['individuo']->tipoSaude) : null,
                array(
                  'multiple',
                  'data-live-search' => 'true',
                  'class' => 'form-control selectpicker tipo_saude',
                  'title' => trans('individuos.plh.multipla')
                  )
                )
              }}

              <div class="invalid-feedback" style="display:block !important">
                @if ($errors->has('tipo_atendimento_id'))
                  {{ $errors->first('tipo_atendimento_id') }}
                @endif
              </div>

            </div>


            <div class="col-4">
              {{ Form::label('transporte_saude', trans('individuos.lbl.transporte_saude')) }}
              {{
                Form::select(
                  'tipo_transporte_saude',
                  $data['tipo_transporte'],
                  isset($data['individuo']->saudes[0])? $data['individuo']->saudes[0]->tipo_transporte_id : null,
                  array("class='form-control'",
                )
                )
              }}
            </div>

          </div>


              <br>
              <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                    <h5> {{trans('individuos.lbl.medicacao')}}</h5>
              </div>


              @foreach( $data['tipo_medicacao'] as $key => $tipo_med )

                {{ Form::label('medicacao', $tipo_med->nome ) }} &nbsp; {{ $tipo_med->explicacao }}

                <!-- Quais medicamentos -->
                  <div class="col-12 {{ ($errors->has('nome_medicacao')) ? 'has-error' : '' }}">
                    {{ Form::text(
                        'nome_medicacao[]',
                        isset($data['individuo']->medicacao[$key])? $data['individuo']->medicacao[$key]->nome : null,
                        array(
                          'class'       => 'form-control qual_medicacao',
                          'placeholder' => trans('individuos.plh.qual_medicacao'),
                        )
                      )
                    }}
                  </div>

                  <hr>

              @endforeach


              <div class="row">

                  <div class='col-4'>

                    {{ Form::checkbox(
                      'processo_farmacia_municipal',
                      true, isset($data['individuo']->medicacao[0]) ? $data['individuo']->medicacao[0]->processo_farmacia_municipal : null
                    ) }}
                    {{ Form::label('processo_farmacia_municipal', trans('individuos.lbl.processo_farmacia_municipal')) }}

                  </div>


              </div><!-- .Row -->


              <br>
              <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                    <h5> {{trans('individuos.lbl.acompanhamento')}}</h5>
              </div>

              <!-- Acompanhamento médico -->
                    <div class="form-group">
                      {{ Form::label('acompanhamento_medico', trans('individuos.lbl.acompanhamento_medico')) }} {{trans('individuos.lbl.descreva')}}
                      {{ Form::textarea(
                          'acompanhamento_medico',
                          isset($data['individuo']->acompanhamento->medico) ? $data['individuo']->acompanhamento->medico : null,
                          array(
                            'class' => 'form-control',
                            'rows' => 2,
                          )
                        )
                      }}
                   </div>

              <div class='row'>
                <!-- Terapeutico -->
                <div class="col-12">
                  {{ Form::label('acompanhamento_terapeutico', trans('individuos.lbl.acompanhamento_terapeutico')) }} {{trans('individuos.lbl.descreva')}}
                  {{ Form::textarea(
                      'acompanhamento_terapeutico',
                      isset($data['individuo']->acompanhamento->terapeutico) ? $data['individuo']->acompanhamento->terapeutico : null,
                      array(
                        'name' => 'acompanhamento_terapeutico',
                        'class' => 'form-control',
                        'rows' => 2,
                      )
                    )
                  }}
              </div>
            </div>

        </div><!-- .Collapse -->

    </div><!-- .Container -->
