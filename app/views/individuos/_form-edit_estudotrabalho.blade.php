<!-- Estudo e trabalho -->

<div class="container">
  <div class="row">
    <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#estudotrabalho"><i class="fas fa-chevron-down"></i></button>
    <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-user-graduate"></i> {{trans('individuos.lbl.estudo_trabalho')}}</h5><span class="obrigatorio">*</span>
  </div>

  <div id="estudotrabalho" class="collapse">

    <br>
    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
          <h5> {{trans('individuos.lbl.estudo')}}</h5>
    </div>

      <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">

        <div class='row'><!-- Status, alfabetizado e tipo educação -->

          <div class='col-3'>

            {{ Form::checkbox(
              'status',
              true, isset($data['individuo']->escolaridade->status) ? true : null
            ) }}
            {{ Form::label('status_ensino', trans('individuos.lbl.status_ensino')) }}

          </div>

          <div class='col-3'>

            {{ Form::checkbox(
              'alfabetizado',
              true, isset($data['individuo']->escolaridade->alfabetizado) ? true : null
            ) }}
            {{ Form::label('alfabetizado', trans('individuos.lbl.alfabetizado')) }}

          </div>

        </div><!-- .Row -->
        <div class='form-group row'><!-- Instituição e tipo de escolaridade -->

        <!-- Instituição -->
          <div class="col-12 {{ ($errors->has('instituicao')) ? 'has-error' : '' }}">
            {{ Form::label('instituicao', trans('individuos.lbl.instituicao_ensino')) }}
            {{ Form::text(
                'instituicao',
                isset($data['individuo']->escolaridade->instituicao)? $data['individuo']->escolaridade->instituicao : null,
                array(
                  'class'       => 'form-control',
                )
              )
            }}
            @if ($errors->has('instituicao'))
            <div class="invalid-feedback">
              {{ $errors->first('instituicao') }}
            </div>
            @endif
          </div>

        </div><!-- .Row -->

        <div class='row'><!-- Escolaridade e transporte -->

          <!-- Tipo Escolaridade -->
          <div class="col-6 {{ ($errors->has('escolaridade')) ? 'has-error' : '' }}">
            {{ Form::label('tipo_escolaridade_id', trans('individuos.lbl.escolaridade')) }} <span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_escolaridade_id',
                $data['tipo_escolaridade'],
                isset($data['individuo']->escolaridade->tipo_escolaridade_id)? $data['individuo']->escolaridade->tipo_escolaridade_id : null,
                array("class"=>'form-control tipo_escolaridade_id do-not-ignore required'
              )
              )
            }}

            @if ($errors->has('tipo_escolaridade_id'))
              <div class="invalid-feedback">
                {{ $errors->first('tipo_escolaridade_id') }}
              </div>
            @endif
          </div>

          <!-- Trasporte escolar -->
          <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
            {{ Form::label('transporte_escola', trans('individuos.lbl.transporte_escola')) }}
            {{
              Form::select(
                'tipo_transporte_escolar',
                $data['tipo_transporte'],
                isset($data['individuo']->escolaridade->tipo_transporte_id)? $data['individuo']->escolaridade->tipo_transporte_id : null,
                array("class='form-control'",
              )
              )
            }}

            @if ($errors->has('tipo_transporte_escolar'))
              <div class="invalid-feedback">
                {{ $errors->first('tipo_transporte_escolar') }}
              </div>
            @endif
          </div>

        </div>


        <br>
        <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
              <h5> {{trans('individuos.lbl.trabalho')}}</h5>
        </div>


      <div class='form-group row'><!-- Trabalho e transporte -->

          <!-- Trabalhando -->
          <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
            {{ Form::label('tipo_trabalho_id', trans('individuos.lbl.status_trabalho')) }} <span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_trabalho_id',
                $data['tipo_trabalho'],
                isset($data['individuo']->trabalho->tipo_trabalho_id)? $data['individuo']->trabalho->tipo_trabalho_id : null,
                array("class" =>'form-control tipo_trabalho_id do-not-ignore required',
              )
              )
            }}
          </div>

          <!-- Profissão -->
          <div class="col-6 {{ ($errors->has('profissao')) ? 'has-error' : '' }}">
            {{ Form::label('profissao', trans('individuos.lbl.profissao')) }}
            {{ Form::text(
                'profissao',
                isset($data['individuo']->trabalho->profissao)? $data['individuo']->trabalho->profissao : null,
                array(
                  'class'       => 'form-control',
                )
              )
            }}
          </div>

       </div><!-- .Row -->

        <div class='form-group row'><!-- Trabalho e transporte -->

          <!-- Local -->
          <div class="col-12 {{ ($errors->has('local_trabalho')) ? 'has-error' : '' }}">
            {{ Form::label('local_trabalho', trans('individuos.lbl.local_trabalho')) }}
            {{ Form::text(
                'local_trabalho',
                isset($data['individuo']->trabalho->local)? $data['individuo']->trabalho->local : null,
                array(
                  'class'       => 'form-control',
                )
              )
            }}
            @if ($errors->has('local'))
            <div class="invalid-feedback">
              {{ $errors->first('local') }}
            </div>
            @endif
          </div>

        </div>

        <div class='row'>

          <!-- Período -->
            <div class="col-6 {{ ($errors->has('periodo')) ? 'has-error' : '' }}">
              {{ Form::label('periodo', trans('individuos.lbl.periodo_trabalho')) }}
              {{ Form::text(
                  'periodo',
                  isset($data['individuo']->trabalho->periodo)? $data['individuo']->trabalho->periodo : null,
                  array(
                    'class'       => 'form-control',
                  )
                )
              }}
              @if ($errors->has('periodo'))
              <div class="invalid-feedback">
                {{ $errors->first('periodo') }}
              </div>
              @endif
            </div>


            <!-- Transporte trabalho -->
            <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
              {{ Form::label('transporte_escola', trans('individuos.lbl.transporte_trabalho')) }}
              {{
                Form::select(
                  'tipo_transporte_trabalho',
                  $data['tipo_transporte'],
                  isset($data['individuo']->trabalho->tipo_transporte_id)? $data['individuo']->trabalho->tipo_transporte_id : null,
                  array("class='form-control'",
                )
                )
              }}

              @if ($errors->has('tipo_transporte_trabalho'))
                <div class="invalid-feedback">
                  {{ $errors->first('tipo_transporte_trabalho') }}
                </div>
              @endif
            </div>

        </div><!-- .Row -->

     </div><!-- Form-group -->

  </div><!-- .Collapse -->

</div><!-- .Container -->
