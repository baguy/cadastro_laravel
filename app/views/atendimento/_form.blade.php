@if (isset($data['atendimento']->id))

{{ Form::model($data['atendimento'], array('id' => 'AtendimentoForm', 'method' => 'PATCH', 'route' => array('atendimento.update', $data['atendimento']->id))) }}

{{-- Campo input invisível para pegar ID de assentamento — usado para salvar ligação --}}
{{Form::hidden(
  "assentamento_id[]",
  isset($assentamento->id) ? $assentamento->id : null
)}}

@else

{{ Form::open(array('id' => 'AtendimentoForm', 'route' => 'atendimento.store', 'method' => 'POST')) }}

@endif

<?php
  $individuo = Session::get('individuo');
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">

      <div>
          <span class="float-right">
            {{
              link_to_route(
                'individuos.create',
                trans('application.btn.add-new-individuo'),
                null,
                array(
                  'class' => 'btn btn-success btn-sm'
                )
              )
            }}
          </span>
      </div>

      @if (isset($data['atendimento']->id))
        {{ trim(trans('application.action.edit-atendimento', ['icon' => '<i class="fas fa-edit"></i>'])) }}
      @else
        {{ trim(trans('application.action.create-atendimento', ['icon' => '<i class="fas fa-save"></i>'])) }}
      @endif

    </h3>


  </div><!-- .card-header -->
  <div class="card-body">

    <div class="form-row">

      <div class="form-group col-md-6">

        {{ Form::label('individuo', trans('atendimento.lbl.individuo')) }}<span class="obrigatorio">*</span>
        <div class="input-group {{ ($errors->has('individuo_id')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-user fa-fw"></i>
            </span>
          </div>

          @if( $individuo != '' )
            {{ Form::text(
              'individuo',
              $individuo->nome,
              array(
                'title' => 'MUNÍCIPE',
                'class' => 'form-control',
                ))
            }}
            {{Form::hidden(
              'individuo_id',
              $individuo->id
            )}}
          @else
            {{ Form::select(
              'individuo_id',
              $data['individuos'],
              isset($data['atendimento']->individuo->id) ? $data['atendimento']->individuo->id : null,
              array(
                'title' => 'MUNÍCIPE',
                'class' => 'form-control selectpicker individuo',
                'data-live-search' => 'true',
                ))
            }}
          @endif

          <div class="invalid-feedback" style="display:block !important;">
            @if ($errors->has('individuo_id'))
              {{ $errors->first('individuo_id') }}
            @endif
          </div>

        </div>
      </div>

      <div class="form-group col-md-6">

        {{ Form::label('categoria', trans('atendimento.lbl.tipo_atendimento_id')) }}<span class="obrigatorio">*</span>

        <div class="input-group {{ ($errors->has('tipo_atendimento_id')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-list-ol fa-fw"></i>
            </span>
          </div>

          {{ Form::select(
            'tipo_atendimento_id[]',
            $data['categorias'],
            isset($data['atendimento']) ? FormatterHelper::multiSelectValues($data['atendimento']->tipoAtendimento) : null,
            array(
              'multiple',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker tipo_atendimento',
              'title' => 'SELECIONE AS CATEGORIAS DO ATENDIMENTO'
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important">
            @if ($errors->has('tipo_atendimento_id'))
              {{ $errors->first('tipo_atendimento_id') }}
            @endif
          </div>

        </div>
      </div>
    </div>

    <div class="form-row">

      <div class="form-group col-md-6">

        {{ Form::label('titulo', trans('atendimento.lbl.titulo')) }}<span class="obrigatorio">*</span>

        <div class="input-group {{ ($errors->has('titulo')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-align-left fa-fw"></i>
            </span>
          </div>

          {{ Form::text(
            'titulo',
            isset($data['atendimento']) ? $data['atendimento']->titulo : null,
            array(
              (isset($data['atendimento']) && !Auth::user()->hasRole('ADMIN')) ? 'readonly' : '',
              'class' => 'form-control titulo',
              'placeholder' => trans('atendimento.plh.titulo')
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important">
            @if ($errors->has('titulo'))
              {{ $errors->first('titulo') }}
            @endif
          </div>

        </div>
      </div>

      <div class="form-group col-md-6">

        {{ Form::label('setor', trans('atendimento.lbl.setor')) }}

        <div class="input-group {{ ($errors->has('setor')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-project-diagram fa-fw"></i>
            </span>
          </div>

          {{ Form::select(
            'setor_id[]',
            $data['setor'],
            isset($data['atendimento']->setor[0]) ? FormatterHelper::multiSelectValues($data['atendimento']->setor) : null,
            array(
              'multiple',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker setor',
              'title' => 'SELECIONE O SETOR'
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important">
            @if ($errors->has('tipo_atendimento_id'))
              {{ $errors->first('tipo_atendimento_id') }}
            @endif
          </div>

        </div>
      </div>

</div>



    <div class="form-row">
      <div class="form-group col-md 12">

        {{ Form::label('descricao', trans('atendimento.lbl.descricao')) }}<span class="obrigatorio">*</span>

        <div class="input-group {{ ($errors->has('descricao')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-layer-group fa-fw"></i>
            </span>
          </div>

          {{ Form::textarea(
              'descricao',
              isset($data['atendimento']) ? $data['atendimento']->descricao : null,
              array(
              (isset($data['atendimento']) && !Auth::user()->hasRole('ADMIN')) ? 'readonly' : '',
              'class'       => 'form-control descricao',
              'placeholder' => trans('atendimento.plh.descricao')
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important">
            @if ($errors->has('descricao'))
              {{ $errors->first('descricao') }}
            @endif
          </div>

        </div>
      </div>
    </div>


    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
          <h5><i class="fas fa-home"></i> Endereço</h5>
    </div>

    <div class="form-group endereco">
      <div class="row">
    <!-- CEP — text com máscara -->
          <div class="col-6 {{ ($errors->has('cep')) ? 'has-error' : '' }}">
            {{ Form::label('cep', trans('individuos.lbl.cep')) }}
            <small><a style='padding-left:5px;' target='_blank' href="http://www.buscacep.correios.com.br/sistemas/buscacep/"> Consultar CEP</a></small>
            {{ Form::text(
              'cep',
              isset($data['atendimento']->endereco->cep) ? $data['atendimento']->endereco->cep : null,
              array(
                'class'       => 'form-control cep',
                'placeholder' => trans('individuos.plh.cep'),
                'maxlength'   => '9',
                'onblur'      => 'pesquisacep(this.value);',
              )
            )
          }}
            @if ($errors->has('cep'))
            <div class="invalid-feedback">
              {{ $errors->first('cep') }}
            </div>
            @endif
          </div>

    <!-- Estado — select -->
          <div class="col-6 {{ ($errors->has('estado')) ? 'has-error' : '' }}">
            {{ Form::label('estado', trans('individuos.lbl.estado')) }}
              {{ Form::select(
                'estado',
                $data['estado'],
                isset($data['atendimento']->endereco->cidade->estado->uf)? $data['atendimento']->endereco->cidade->estado->uf : 'SP',
                array("class" => 'form-control estado')
                )
              }}

            @if ($errors->has('estado'))
            <div class="invalid-feedback">
              {{ $errors->first('estado') }}
            </div>
            @endif
          </div>
        </div>

      <div class="row">
    <!-- Cidade — select -->
    {{-- Condicional — lista select muda dependendo do estado selecionado --}}
          <div class="col-6 {{ ($errors->has('cidade')) ? 'has-error' : '' }}">
            {{ Form::label('cidade', trans('individuos.lbl.cidade')) }}
            {{ Form::select(
              'cidade',
              $data['cidade'],
              isset($data['atendimento']->endereco->cidade->id) ? $data['atendimento']->endereco->cidade->id : 3388,
              array("class" => "form-control cidade")
              )
            }}

            @if ($errors->has('cidade'))
              <div class="invalid-feedback">
                {{ $errors->first('cidade') }}
              </div>
            @endif
          </div>

    <!-- Bairro — text — letras caixa alta -->
    {{-- Input de texto livre para digitação devido à inconsistência da divisão de bairros em Caraguatatuba --}}
          <div class="col-6 {{ ($errors->has('bairro')) ? 'has-error' : '' }}">
            {{ Form::label('bairro', trans('individuos.lbl.bairro')) }}
            {{
              Form::text(
                'bairro',
                isset($data['atendimento']->endereco->bairro) ? $data['atendimento']->endereco->bairro : null,
                array(
                  'class'       => 'form-control bairro',
                  'placeholder' => trans('atendimento.plh.bairro'),
                  'style'       => "text-transform: uppercase",
                )
              )
            }}

            @if ($errors->has('bairro'))
            <div class="invalid-feedback">
              {{ $errors->first('bairro') }}
            </div>
            @endif
          </div>
        </div>

      <div class="row">

    <!-- Logradouro — text livre para digitação -->
          <div class="col-8 {{ ($errors->has('logradouro')) ? 'has-error' : '' }}">
            {{ Form::label('logradouro', trans('individuos.lbl.logradouro')) }}
            {{
              Form::text(
                'logradouro',
              isset($data['atendimento']->endereco->logradouro) ? $data['atendimento']->endereco->logradouro : null,
                array(
                  'class'       => 'form-control logradouro',
                  'placeholder' => trans('individuos.plh.logradouro'),
                )
              )
            }}

            @if ($errors->has('logradouro'))
            <div class="invalid-feedback">
              {{ $errors->first('logradouro') }}
            </div>
            @endif
          </div>

    <!-- Numero — text -->
          <div class="col-4 {{ ($errors->has('numero')) ? 'has-error' : '' }}">
            {{ Form::label('numero', trans('individuos.lbl.numero')) }}
            {{
              Form::text(
                'numero',
                isset($data['atendimento']->endereco->numero) ? $data['atendimento']->endereco->numero : null,
                array(
                  'class'       => 'form-control numero',
                  'placeholder' => trans('individuos.plh.numero')
                )
              )
            }}

            @if ($errors->has('numero'))
            <div class="invalid-feedback">
              {{ $errors->first('numero') }}
            </div>
            @endif
          </div>

        </div>

        <div class="row">
      <!-- Complemento — text -->
            <div class="col-8 {{ ($errors->has('complemento')) ? 'has-error' : '' }}">
              {{ Form::label('complemento', trans('individuos.lbl.complemento')) }}
              {{
                Form::text(
                  'complemento',
                  isset($data['atendimento']->endereco->complemento) ? $data['atendimento']->endereco->complemento : null,
                  array(
                    'class'       => 'form-control complemento',
                    'placeholder' => trans('individuos.plh.complemento')
                  )
                )
              }}

              @if ($errors->has('complemento'))
              <div class="invalid-feedback">
                {{ $errors->first('complemento') }}
              </div>
              @endif
            </div>

      <!-- Botão mapa -->
            <div class="col-4">
              {{
                Form::button(
                  '<span>Buscar no mapa<span class="obrigatorio">*</span></span>',
                  array(
                    'class'   => 'btn btn-md',
                    'style'   => 'width:100%; margin-top:32px;',
                    'onclick' => "buscar();"
                  )
                )
               }}
            </div>
          </div>

      </div>

    {{-- Inputs invisíveis — recebem os valores de latitude e longitude
    após endereço ser buscado pela api do mapbox [mapbox_index.js] --}}
            <div class="col-12">
              <div id="mapa" style="height:200px"></div>
              <div class="text-center">
              {{Form::hidden(
                "latitude",
                isset($data['atendimento']->endereco->latitude) ? $data['atendimento']->endereco->latitude : null
                ) }}
                {{Form::hidden(
                  "longitude",
                  isset($data['atendimento']->endereco->longitude) ? $data['atendimento']->endereco->longitude : null,
                  ['class' => 'do-not-ignore required']
                  ) }}
                </div>
            </div>


    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white; margin-top:20px;">

      <h5><i class="fas fa-map-pin" style="margin-right:8px;"></i>{{ trans('atendimento.lbl.assentamentos') }}</h5>

    </div>

    <div class="spacer"></div>


    <?php $assentamentos = ['assentamento'];
    if(Input::old('assentamento')!= NULL){$assentamentos = Input::old('assentamento');}
    if(isset($data['atendimento']) && count($data['atendimento']->assentamentos) >= 1 ? $assentamentos = $data['atendimento']->assentamentos : $assentamentos = ['assentamento'])
      ?>

    <div class="form-group cloned-main">

      <div class="assentamento cloned-div">

          @foreach($assentamentos as $key => $tel)

              @if( isset($data['atendimento']) && count($data['atendimento']->assentamentos) >= 1 )

                  @if( isset($tel->setor[0]) )
                    {{ ucwords(mb_strtolower( $data['atendimento']->setoresFormatados($tel->setor), 'UTF-8')) }}
                  @else
                    Setor não informado
                  @endif
                    <b class='float-right'>{{ FormatterHelper::dateTimeToPtBR($tel->created_at) }}</b>

              @else
                <div class="row">
                  <!-- Setor -->
                  <div class="form-group col-md-6">

                    <div class="input-group {{ ($errors->has('setor')) ? 'has-error' : '' }}">

                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-project-diagram fa-fw"></i>
                        </span>
                      </div>

                      {{ Form::select(
                        'setor_assentamento_id[]',
                        $data['setor'],
                        isset($tel->setor[0]) ? FormatterHelper::multiSelectValues($tel->setor) : null,
                        array(
                          'multiple',
                          'data-live-search' => 'true',
                          'class'       => 'form-control selectpicker setor',
                          'title' => 'SELECIONE O SETOR'
                          )
                        )
                      }}

                      </div>

                    </div>
                  </div>
                @endif

                <div class='row'>

                      <div class="input-group {{ ($errors->has('assentamento')) ? 'has-error' : '' }}">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            @if(isset($data['atendimento']) && count($data['atendimento']->assentamentos) >= 1)
                              <div style="display:flex;flex-direction:column">
                                <i class="fa fa-user-circle"></i>
                                <div style="font-size:13px;">
                                  <b>Criado por:</b>
                                  <p style="margin-bottom:-5px;">{{ $tel->user->name }}</p>
                                </div>
                              </div>
                            @else
                              <i class="fas fa-comments fa-fw"></i>
                            @endif
                          </span>
                        </div>

                        {{-- Assentamento --}}
                        @if( isset($data['atendimento']) && count($data['atendimento']->assentamentos) >= 1 )
                          <textarea name="assentamento[]" <?php echo !Auth::user()->hasRole('ADMIN') ? 'readonly' : ''; ?> class="form-control assentamento" placeholder="{{ trans('atendimento.plh.assentamento') }}">{{ $tel->descricao }}
                          </textarea>
                        @else
                          <textarea name="new_assentamento[]" class="form-control assentamento" placeholder="{{ trans('atendimento.plh.assentamento') }}">{{ Input::old('new_assentamento')[$key] }}</textarea>
                        @endif

                      </div>

                  </div>

            <hr>

          @endforeach

          @if( empty($data['atendimento']->assentamentos) )
            <div class="form-group">
                <div class="row">
                  <div class="col-md-2">
                    {{
                      Form::button(
                        '<span>Adicionar</span>',
                        array(
                          'class' => 'btn btn-sm addCloned',
                          'style' => 'width:100%;margin-bottom:20px;'
                        )
                      )
                     }}
                   </div>
                   <div class="col-md-2">
                     {{
                       Form::button(
                         '<span>Remover</span>',
                         array(
                           'class' => 'btn btn-sm delCloned',
                           'style' => 'width:100%;margin-bottom:20px;'
                         )
                       )
                     }}
                   </div>
               </div>
             </div>
           @endif

      </div><!-- .cloned-div -->
  </div><!-- .cloned-main -->

  @if( (!empty($data['atendimento']->assentamentos)) && (isset($data['atendimento']->assentamentos[0])) )

    <div class="row">
      <!-- Setor -->
      <div class="form-group col-md-6">

        <div class="input-group {{ ($errors->has('setor')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-project-diagram fa-fw"></i>
            </span>
          </div>

          {{ Form::select(
            'new_setor_assentamento_id[]',
            $data['setor'],
            Input::old(),
            array(
              'multiple',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker setor',
              'title' => 'SELECIONE O SETOR'
              )
            )
          }}

          </div>

        </div>
      </div>

    <div class='row'>

      <div class="input-group {{ ($errors->has('assentamento')) ? 'has-error' : '' }}">
        <div class="input-group-prepend">
          <span class="input-group-text">
           <i class="fas fa-comments fa-fw"></i>
          </span>
        </div>
        {{-- Assentamento --}}
         <textarea name="new_assentamento[]" class="form-control assentamento" placeholder="{{ trans('atendimento.plh.assentamento') }}">{{ Input::old('new_assentamento')[$key] }}</textarea>
        </div>

      </div>

  @endif

{{-- Encerrado --}}
  <?php $status_id = null;
  if( isset($data['atendimento']->id) ){
    if( $data['atendimento']->status_id == 3){
      $status_id = true;
    }
  }
  $verdadeDesafio= false;
  $setores = [];

  if(isset($data['atendimento']->id)){
   if(count($data['atendimento']->assentamentos) >= 1){
     foreach($data['atendimento']->assentamentos as $key => $value){
       foreach($value->setor as $key => $setor){
          $setores[$key] = $setor;
       }
     }
    if(Auth::user()->funcionario_id){
      foreach ( Auth::user()->funcionario->setor as $key => $setor ){
        if( isset($setores[0]) && $setores[0] != '' ){
          if( $setores[0]->nome == $setor->nome){
            $verdadeDesafio = true;
          }
      }
     }
    }
   }
  }
   ?>

  @if(Auth::user()->hasRole('ADMIN') || $verdadeDesafio==true)
    <hr>

    <div class='form-row'>
      <div class='form-group' style='margin-top:5px;margin-left:10px'>
        {{ Form::checkbox(
          'status_encerrado',
          true, $status_id,
          array(
            'id' => 'status_encerrado',
            'class' => 'status_encerrado',
            // 'onclick' => 'mudaEncerrado()'
            'onclick' => "$('#tipo_encerrado').removeAttr('disabled') = this.checked;",
            )
        ) }}
        {{ Form::label('status_ensino', trans('atendimento.lbl.status_encerrado')) }}
      </div>
    </div>

    <div class='form-row'>
      <div class="form-group col-md-3">
        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-check-circle fa-fw"></i>
            </span>
          </div>

          {{ Form::select(
            'tipo_encerrado',
            $data['tipo_encerrado'],
            isset($atendimento->encerrado) ? $atendimento->encerrado->tipo_encerrado : null,
            array(
              'id' => 'tipo_encerrado',
              'class' => 'form-control tipo_encerrado',
              'title' => 'SELECIONE',
              'disabled'
              )
            )
          }}

        </div>
      </div>
    </div>

  @endif


</div><!-- .card-body -->

  {{-- </div> --}}

  <div class="card-footer text-right">
    {{
      link_to_route(
      'atendimento.index',
      trans('application.btn.cancel'),
      null,
      array(
        'class' => 'btn btn-default'
        )
      )
    }}

    {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary save', 'id' => 'save')) }}
  </div>

</div>

{{ Form::close() }}


<script>
function mudaEncerrado(){
  var status_encerrado = document.getElementById('status_encerrado');
  var tipo_encerrado = document.getElementById('tipo_encerrado');
  console.log('status_encerrado')
  if(status_encerrado.checked == true){
    $('#tipo_encerrado').removeAttr('disabled');
  }else{
    $('#tipo_encerrado').attr('disabled', true);
  }
}
</script>
