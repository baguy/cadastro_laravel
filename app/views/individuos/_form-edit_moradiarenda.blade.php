<!-- Moradia e Renda -->
<div class="container">
  <div class="row">
    <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#moradiarenda"><i class="fas fa-chevron-down"></i></button>
    <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-home"></i> {{trans('individuos.lbl.moradia_renda')}}</h5><span class="obrigatorio">*</span>
  </div>

  <div id="moradiarenda" class="collapse">

    <br>
    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
          <h5> {{trans('individuos.lbl.moradia')}}</h5>
    </div>

      <div class="form-group {{ ($errors->has('numero')) ? 'has-error' : '' }}">

      <div class='row'>

        <!-- Tipo Moradia -->
        <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
          {{ Form::label('tipo_moradia', trans('individuos.lbl.tipo_moradia')) }} <span class="obrigatorio">*</span>
          {{
            Form::select(
              'tipo_moradia_id',
              $data['tipo_moradia'],
              isset($data['individuo']->moradia->tipo_moradia_id)? $data['individuo']->moradia->tipo_moradia_id : null,
              array("class"=>"form-control tipo_moradia_id do-not-ignore required",
            )
            )
          }}
        </div>

        <!-- Imóvel -->
        <div class="col-6 {{ ($errors->has('tipo_imovel_id')) ? 'has-error' : '' }}">
          {{ Form::label('tipo_imovel', trans('individuos.lbl.tipo_imovel')) }} <span class="obrigatorio">*</span>
          {{
            Form::select(
              'tipo_imovel_id',
              $data['tipo_imovel'],
              isset($data['individuo']->moradia->tipo_imovel_id)? $data['individuo']->moradia->tipo_imovel_id : null,
              array("class" => 'form-control tipo_imovel_id do-not-ignore required',
            )
            )
          }}
        </div>

      </div>

      <div class='form-group row'>

        <!-- Outro -->
        <div class="col-12 {{ ($errors->has('local_trabalho')) ? 'has-error' : '' }}">
          {{ Form::label('outro_moradia', trans('individuos.lbl.outro_grupo_social')) }}
          {{ Form::text(
              'outro_moradia',
              isset($data['individuo']->moradia->outro)? $data['individuo']->moradia->outro : null,
              array(
                'class' => 'form-control',
              )
            )
          }}
        </div>

      </div>

      <br>
      <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
            <h5> {{trans('individuos.lbl.renda')}}</h5>
      </div>

    <div class='form-group row'>

        <!-- Renda Pessoal -->
        <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
          {{ Form::label('tipo_renda', trans('individuos.lbl.renda_pessoal')) }} <span class="obrigatorio">*</span>
          {{
            Form::select(
              'tipo_renda_id',
              $data['tipo_renda'],
              isset($data['individuo']->renda->tipo_renda_id)? $data['individuo']->renda->tipo_renda_id : null,
              array("class"=>'form-control tipo_renda_id do-not-ignore required',
            )
            )
          }}
        </div>

        <!-- Renda Familiar -->
          <div class="col-6 {{ ($errors->has('instituicao_ensino')) ? 'has-error' : '' }}">
            {{ Form::label('renda_familiar', trans('individuos.lbl.renda_familiar')) }} <span class="obrigatorio">*</span>
            {{ Form::text(
                'renda_familiar',
                isset($data['individuo']->renda->numero)? $data['individuo']->renda->numero : null,
                array(
                  'class'       => 'form-control renda_familiar do-not-ignore required',
                  'placeholder' => trans('individuos.plh.renda_familiar'),
                )
              )
            }}
          </div>

        </div><!-- .Row -->

    </div><!-- Form-group -->

  </div><!-- .Collapse -->

</div><!-- .Container -->
