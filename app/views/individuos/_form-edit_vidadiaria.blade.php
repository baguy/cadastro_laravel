<!-- Credencial -->

  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#vidadiaria"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-sun"></i> {{trans('individuos.lbl.vida_atividades')}}</h5><span class="obrigatorio">*</span>
    </div>

    <div id="vidadiaria" class="collapse">

        <div class="form-group">

          <div class='row'>

            <!-- Vida Diária -->
            <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                  <h5> {{trans('individuos.lbl.vida_diaria')}}</h5>
            </div>

              @foreach( $data['tipo_vida_diaria_assunto'] as $key => $tipo_vd_assunto )

                <div class="form-group col-6">

                  {{ Form::label('tipo_credencial', $tipo_vd_assunto->nome) }} <span class="obrigatorio">*</span>
                </div>

                <div class="col-6 {{ ($errors->has('vida_diaria')) ? 'has-error' : '' }}">
                  {{ Form::select(
                      'vida_diaria[]',
                      $data['tipo_vida_diaria'],
                      isset($data['individuo']->vidaDiaria[$key]) ? $data['individuo']->vidaDiaria[$key]->tipo_vida_diaria_id : null,
                      array(
                        'class' => 'form-control vida_diaria do-not-ignore required',
                      )
                    )
                  }}
                </div>


              @endforeach

            </div><!-- .Row -->

            <div class='form-group row'>

            <!-- Não sai de casa — Outro -->
              <div class="col-12">
                {{ Form::label('outro_vida_diaria', trans('individuos.lbl.outro_vida_diaria')) }}
                {{ Form::text(
                    'outro_vida_diaria',
                    isset($data['individuo']->vidaDiaria[5])? $data['individuo']->vidaDiaria[5]->outro : null,
                    array(
                      'class' => 'form-control outro_vida_diaria',
                    )
                  )
                }}
                @if ($errors->has('outro_vida_diaria'))
                <div class="invalid-feedback">
                  {{ $errors->first('outro_vida_diaria') }}
                </div>
                @endif
              </div>

            </div><!-- .Row -->


            <br>
            <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                  <h5> {{trans('individuos.lbl.grupo_social')}}</h5>
            </div>


            <!-- Grupos sociais -->
            <div class='row'>

                @foreach( $data['tipo_grupo_social'] as $key => $tipo_grupo_social )

                  <!-- Checa se valor tipo_grupo_social relacionado ao indivíduo está salvo e, se estiver,
                  a variável $verdadeDesafio recebe valor true para ativar o checkbox -->
                  <?php $verdadeDesafio = 0; ?>
                  @foreach( $data['individuo']->grupoSociais as $key2 => $grupo_comparado )
                    @if( $grupo_comparado->tipo_grupo_social_id == $tipo_grupo_social->id )
                       <?php
                       $verdadeDesafio = true;
                       ?>
                    @endif
                  @endforeach

                  <div class="form-group col-4">
                    {{ Form::checkbox('tipo_grupo_social_id[]',
                                    $tipo_grupo_social->id,
                                    // isset($tipo_grupo_social->grupoSociais[$key]) ? true : null,
                                    $verdadeDesafio,
                                    array(
                                      'style' => 'margin-right:0px;margin-left:2px',
                                    ))
                    }}
                    {{ Form::label('$tipo_grupo_social', $tipo_grupo_social->nome) }}
                  </div>

                @endforeach

              </div><!-- .Row -->


              <?php $outro_grupo_social = null; ?>
              @foreach( $data['individuo']->grupoSociais as $key => $grupoSocial_id )
                @if( $grupoSocial_id->tipo_grupo_social_id == 5 )
                  <?php $outro_grupo_social = $grupoSocial_id->outro ?>
                @endif
              @endforeach

                {{ $data['individuo']->grupoSocial }}

              <div class='row'>

            <!-- Grupos Sociais — Outro -->
              <div class="col-12 {{ ($errors->has('outro_grupo_social')) ? 'has-error' : '' }}">
                {{ Form::label('outro_grupo_social', trans('individuos.lbl.outro_grupo_social')) }}
                {{ Form::text(
                    'outro_grupo_social',
                    $outro_grupo_social,
                    array(
                      'class' => 'form-control outro_grupo_social',
                    )
                  )
                }}
                @if ($errors->has('outro_grupo_social'))
                <div class="invalid-feedback">
                  {{ $errors->first('outro_grupo_social') }}
                </div>
                @endif
              </div>

            </div><!-- .Row -->


            <br>
            <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                  <h5> {{trans('individuos.lbl.atividades')}}</h5>
            </div>


            {{-- Pratica de esporte --}}
          <div class='row'>
            <div class="col-6" >
              {{ Form::label('tipo_atividade_esporte', trans('individuos.lbl.esporte')) }} <span class="obrigatorio">*</span>
              {{
                Form::select(
                  'tipo_atividade_esporte',
                  $data['tipo_atividade'],
                  isset($data['individuo']->esporte->tipo_atividade_id)? $data['individuo']->esporte->tipo_atividade_id : null,
                  array("class"=>"form-control tipo_atividade_esporte do-not-ignore required",
                )
                )
              }}

            </div>

            <div class="col-6">
              {{ Form::label('transporte_esporte', trans('individuos.lbl.transporte_esporte')) }}
              {{
                Form::select(
                  'transporte_esporte',
                  $data['tipo_transporte'],
                  isset($data['individuo']->esporte->tipo_transporte_id)? $data['individuo']->esporte->tipo_transporte_id : null,
                  array("class='form-control'",
                )
                )
              }}

            </div>
          </div>

          <div class='row'>
              <!-- Obs -->
              <div class="col-12 {{ ($errors->has('obs')) ? 'has-error' : '' }}">
                {{ Form::label('obs_esporte', trans('individuos.lbl.obs')) }}
                  <div>
                    {{
                      Form::text(
                        'obs_esporte',
                        isset($data['individuo']->esporte->obs) ? $data['individuo']->esporte->obs : null,
                        array(
                          'class' => 'form-control',
                          'style' => 'margin-bottom:20px;',
                        )
                      )
                    }}
                  </div>
                </div>

          </div><!-- .Row -->


          {{-- Atividade cultural --}}
        <div class='row'>
          <div class="col-6" >
            {{ Form::label('tipo_atividade_cultural', trans('individuos.lbl.cultural')) }} {{trans('individuos.lbl.tipo_cultural')}} <span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_atividade_cultural',
                $data['tipo_atividade'],
                isset($data['individuo']->cultural->tipo_atividade_id)? $data['individuo']->cultural->tipo_atividade_id : null,
                array("class"=>"form-control tipo_atividade_cultural do-not-ignore required",
              )
              )
            }}

            @if ($errors->has('tipo_atividade_cultural'))
              <div class="invalid-feedback">
                {{ $errors->first('tipo_atividade_cultural') }}
              </div>
            @endif
          </div>

          <div class="col-6">
            {{ Form::label('transporte_cultural', trans('individuos.lbl.transporte_cultural')) }}
            {{
              Form::select(
                'transporte_cultural',
                $data['tipo_transporte'],
                isset($data['individuo']->cultural->tipo_transporte_id)? $data['individuo']->cultural->tipo_transporte_id : null,
                array("class='form-control'",
              )
              )
            }}

            @if ($errors->has('transporte_cultural'))
              <div class="invalid-feedback">
                {{ $errors->first('transporte_cultural') }}
              </div>
            @endif
          </div>
        </div>

        <div class='row'>
            <!-- Obs -->
            <div class="col-12 {{ ($errors->has('obs')) ? 'has-error' : '' }}">
              {{ Form::label('obs_cultural', trans('individuos.lbl.obs')) }}
                <div>
                  {{
                    Form::text(
                      'obs_cultural',
                      isset($data['individuo']->cultural->obs) ? $data['individuo']->cultural->obs : null,
                      array(
                        'class' => 'form-control',
                        'style' => 'margin-bottom:20px;',
                      )
                    )
                  }}
                </div>
              </div>

        </div><!-- .Row -->


            <!-- Quedas -->
            <br>
            <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                  <h5> {{trans('individuos.lbl.queda')}}</h5>
            </div>


            <div class='form-group row'>

              <!-- Local -->
              <div class="col-12 {{ ($errors->has('local_queda')) ? 'has-error' : '' }}">
                {{ Form::label('local_queda', trans('individuos.lbl.local_queda')) }}
                {{ Form::text(
                    'local_queda',
                    isset($data['individuo']->quedas[0])? $data['individuo']->quedas[0]->local : null,
                    array(
                      'class' => 'form-control',
                    )
                  )
                }}
                @if ($errors->has('local_queda'))
                <div class="invalid-feedback">
                  {{ $errors->first('local_queda') }}
                </div>
                @endif
              </div>

            </div>


            {{ Form::label('consequencia_queda', trans('individuos.lbl.consequencia_queda')) }}


            {{ Form::select(
              'consequencia_queda[]',
              $data['consequencia_queda'],
              isset($data['individuo']->quedas[0]) ? FormatterHelper::multiSelectValues($data['individuo']->consequenciaQueda) : null,
              array(
                'multiple',
                'data-live-search' => 'true',
                'class' => 'form-control selectpicker queda',
                'title' => trans('individuos.plh.multipla')
                )
              )
            }}

            <div class="invalid-feedback" style="display:block !important">
              @if ($errors->has('consequencia_queda'))
                {{ $errors->first('consequencia_queda') }}
              @endif
            </div>

         </div><!-- Form-group -->

      </div><!-- .Collapse -->

    </div><!-- .Container -->
