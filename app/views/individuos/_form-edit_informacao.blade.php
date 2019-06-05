<!-- Estudo e trabalho -->
<div class="container">
<div class="row">
  <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#informacao"><i class="fas fa-chevron-down"></i></button>
  <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-comment"></i> {{trans('individuos.lbl.informacao_sugestao')}}</h5><span class="obrigatorio">*</span>
</div>

<div id="informacao" class="collapse">

  <br>
  <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
        <h5> {{trans('individuos.lbl.informacao')}}</h5>
  </div>

    <div class="form-group {{ ($errors->has('numero')) ? 'has-error' : '' }}">

        <div class='row'>

          <!-- Tipo informação -->
          <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
            {{ Form::label('tipo_informacao', trans('individuos.lbl.tipo_informacao')) }} <span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_informacao_id',
                $data['tipo_informacao'],
                isset($data['individuo']->informacao->tipo_informacao_id)? $data['individuo']->informacao->tipo_informacao_id : null,
                array("class" => 'form-control do-not-ignore required',
              )
              )
            }}
          </div>

          <!-- Origem das informacoes -->
          <div class="col-6 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
            {{ Form::label('origem_informacao', trans('individuos.lbl.origem_informacao')) }} <span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_informacao_origem_id',
                $data['tipo_informacao_origem'],
                isset($data['individuo']->informacao->tipo_informacao_origem_id)? $data['individuo']->informacao->tipo_informacao_origem_id : null,
                array("class" => 'form-control do-not-ignore required',
              )
              )
            }}
          </div>

        </div>

          <div class='form-group row'>

            <div class="col-12 {{ ($errors->has('obs_informacao')) ? 'has-error' : '' }}">
              {{ Form::label('obs_informacao', trans('individuos.lbl.obs')) }}
              {{ Form::text(
                  'obs_informacao',
                  isset($data['individuo']->informacao->obs)? $data['individuo']->informacao->obs : null,
                  array(
                    'class' => 'form-control',
                  )
                )
              }}
            </div>

          </div><!-- .Row -->

          <br>
          <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
                <h5> {{trans('individuos.lbl.sugestao')}}</h5>
          </div>

        <div class='form-group row'>

            <div class="col-12 {{ ($errors->has('instituicao_ensino')) ? 'has-error' : '' }}">
              {{ Form::label('sugestao', trans('individuos.lbl.sugestao')) }} <span class="obrigatorio">*</span>

              <p>{{trans('individuos.lbl.dificuldade')}}</p>

              {{ Form::textarea(
                  'sugestao',
                  isset($data['individuo']->sugestao->sugestao)? $data['individuo']->sugestao->sugestao : null,
                  array(
                    'class' => 'form-control do-not-ignore required',
                    'rows' => 2,
                  )
                )
              }}
            </div>

        </div><!-- .Row -->

     </div><!-- Form-group -->

  </div><!-- .Collapse -->

</div><!-- .Container -->
