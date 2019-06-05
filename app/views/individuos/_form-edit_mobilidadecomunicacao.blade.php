<!-- Mobilidade e comunicação -->
<div class="container">
  <div class="row">
    <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#mobilidadecomuicacao"><i class="fas fa-chevron-down"></i></button>
    <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-braille"></i> {{trans('individuos.lbl.mobilidade_comunicacao')}}</h5>
  </div>

  <div id="mobilidadecomuicacao" class="collapse">

    <br>
    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
          <h5> {{trans('individuos.lbl.mobilidade')}}</h5>
    </div>

      <div class="form-group">

        <p>{{trans('individuos.lbl.causa_mobilidade')}}</p>

        {{ Form::select(
          'causa_mobilidade_id[]',
          $data['causa_mobilidade'],
          isset($data['individuo']->mobilidades[0]) ? FormatterHelper::multiSelectValues($data['individuo']->causaMobilidade) : null,
          array(
            'multiple',
            'data-live-search' => 'true',
            'class' => 'form-control selectpicker mobilidade',
            'title' => trans('individuos.plh.multipla')
            )
          )
        }}

      </div>

      <br>
      <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
            <h5> {{trans('individuos.lbl.comunicacao')}}</h5>
      </div>

      <div class='row'>

        <div class="col-12">
          {{ Form::select(
            'tipo_comunicacao_id[]',
            $data['tipo_comunicacao'],
            isset($data['individuo']->comunicacao[0]) ? FormatterHelper::multiSelectValues($data['individuo']->tipoComunicacao) : null,
            array(
              'multiple',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker tipo_comunicacao_id',
              'title' => trans('individuos.plh.multipla')
              )
            )
          }}
        </div>

      </div>
      <div class='row'>

        <div class="col-12 {{ ($errors->has('nome_parente')) ? 'has-error' : '' }}">
          {{ Form::label('outro_comunicacao', trans('individuos.lbl.outro')) }}
          {{ Form::text(
              'outro_comunicacao',
              isset($data['individuo']->comunicacao[0])? $data['individuo']->comunicacao[0]->outro : null,
              array(
                'class'       => 'form-control',
              )
            )
          }}
        </div>

      </div><!-- .Row -->

  </div><!-- .Collapse -->

</div><!-- .Container -->
