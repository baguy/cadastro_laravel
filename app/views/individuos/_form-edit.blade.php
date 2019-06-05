{{ Form::model($data['individuo'], array('id' => 'IndividuoFormEdit', 'data-individuo_id' => $data['individuo']->id, 'method' => 'PUT', 'route' => array('individuos.update', $data['individuo']->id))) }}

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">

          {{ trim(trans('application.action.edit-individuo', ['icon' => '<i class="fas fa-edit"></i>'])) }}

      </h3>
    </div>

    <div class="card-body">

<!-- Nome -->
      <div class="form-group {{ ($errors->has('nome')) ? 'has-error' : '' }}">
        {{ Form::label('nome', trans('individuos.lbl.nome')) }}<span class="obrigatorio">*</span>
        {{ Form::text(
            'nome',
            isset($data['individuo'])? $data['individuo']->nome : null,
            array(
              'class'       => 'form-control',
              'required',
            )
          )
        }}
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
          {{ $errors->first('nome') }}
        </div>
        @endif
      </div>

<div class="form-group">
  <div class="row">

  <!-- CPF -->
        <div class="col-6 {{ ($errors->has('cpf')) ? 'has-error' : '' }}">
          {{ Form::label('cpf', trans('individuos.lbl.cpf')) }}<span class="obrigatorio">*</span>
            <input id="cpf" type="text" name="cpf" class="form-control" title="O CPF deve conter 11 dígitos"
            placeholder="000.000.000-00" value={{ $cpf }}
            >

          @if ($errors->has('cpf'))
          <div class="invalid-feedback">
            {{ $errors->first('cpf') }}
          </div>
          @endif
        </div>


<!-- Sexo -->
      <div class="col-6 {{ ($errors->has('sexo_id')) ? 'has-error' : '' }}">
        {{ Form::label('sexo_id', trans('individuos.lbl.sexo_id')) }}<span class="obrigatorio">*</span>
        <div class="row">
            @foreach($data['sexos'] as $key => $sexo)
              <div class="form-group">
                {{ Form::radio('sexo_id',
                                $sexo->id,
                                $key == 0 ? true : false,
                                array(
                                  'style' => 'margin-right:2px;margin-left:20px',
                                )) }}
                {{ $sexo->tipo }}
              </div>
            @endforeach

        @if ($errors->has('sexo_id'))
        <div class="invalid-feedback">
          {{ $errors->first('sexo_id') }}
        </div>
        @endif
      </div>

    </div>
  </div>


<div class="form-group">
  <div class="row">
<!-- Data de nascimento -->
      <div class="col-8 {{ ($errors->has('data_nascimento')) ? 'has-error' : '' }}">
        {{ Form::label('data_nascimento', trans('individuos.lbl.data_nascimento')) }}<span class="obrigatorio">*</span>
          {{ Form::text(
            'data_nascimento',
            isset($data['individuo']->data_nascimento) ? $data['individuo']->data_nascimento : null,
            array(
              'class'       => 'form-control data_nascimento datas getAgeEdit getAge',
              'placeholder' => trans('individuos.plh.data_nascimento'),
            )
          )
        }}
        @if ($errors->has('data_nascimento'))
        <div class="invalid-feedback">
          {{ $errors->first('data_nascimento') }}
        </div>
        @endif
      </div>

{{-- Idade --}}
      <div class="col-4 {{ ($errors->has('nome')) ? 'has-error' : '' }}">
        {{ Form::label('idade', trans('individuos.lbl.idade')) }}
        {{ Form::text(
            'idade',
            Input::old('idade'),
            array(
              'class'       => 'form-control idade',
              'placeholder' => trans('individuos.plh.idade'),
              'disabled'
            )
          )
        }}
        @if ($errors->has('idade'))
        <div class="invalid-feedback">
          {{ $errors->first('idade') }}
        </div>
        @endif
      </div>

</div>


<br>
<div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
      <h5><i class="fas fa-phone"></i> {{trans('individuos.lbl.contato')}}</h5>
</div>


<!-- Email -->
      <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
        {{ Form::label('nome', trans('individuos.lbl.email')) }}
        {{ Form::text(
            'email',
            isset($data['individuo']->email) ? $data['individuo']->email : null,
            array(
              'class'       => 'form-control email',
              'placeholder' => trans('individuos.plh.email'),
            )
          )
        }}
        @if ($errors->has('email'))
        <div class="invalid-feedback">
          {{ $errors->first('email') }}
        </div>
        @endif
      </div>

<!-- Telefones -->
<?php $telefones = ['telefones'];
  if(Input::old('tipo_telefone_id')!= NULL){$telefones = Input::old('tipo_telefone_id');}
  if( isset($individuo) ){ if (!empty($individuo->telefones[0])) { $telefones = $individuo->telefones;} }
?>

<!-- Bloco de telefone pode ser clonado -->
  <div class="form-group cloned-main {{ ($errors->has('numero')) ? 'has-error' : '' }}">
    @foreach ($data['individuo_tel'] as $offset => $tel)

      <div class="ddd cloned-div">

<!-- Tipo de telefone — select -->
        <div class='row'>
          <div class="col-3 {{ ($errors->has('tipo_telefone')) ? 'has-error' : '' }}">
            {{ Form::label('tipo_telefone', trans('individuos.lbl.tipo_telefone')) }}<span class="obrigatorio">*</span>
            <div>
            {{
              Form::select(
                'tipo_telefone['.$offset.']',
                $data['tipo_telefone'],
                isset($tel->tipo_telefone_id) ? $tel->tipo_telefone_id : null,
                array('class' => "form-control do-not-ignore required",
                'style' => 'margin-bottom:20px;',
                'id' => 'tipo_telefone_id_'.$offset)
              )
            }}
          </div>
        </div>

        <!-- Número do telefone — texto com máscara -->
              <div class="col-6 {{ ($errors->has('telefone')) ? 'has-error' : '' }}">
              {{ Form::label('telefone', trans('individuos.lbl.telefone')) }}<span class="obrigatorio">*</span>
                <div>
                  {{
                    Form::text(
                      'telefone['.$offset.']',
                      isset($tel->numero) ? $tel->numero : null,
                      array(
                        'class'       => 'form-control telefone_mask',
                        'placeholder' => trans('individuos.plh.telefone'),
                        'style' => 'margin-bottom:20px;',
                        'id' => 'telefone'.$offset,
                        'required'
                      )
                    )
                  }}
                </div>
              </div>

<!-- Ramal — number -->
          <div class="col-2 {{ ($errors->has('ramal')) ? 'has-error' : '' }}">
          {{ Form::label('ramal', trans('individuos.lbl.ramal')) }}
          <div>
          {{
            Form::number(
              'ramal['.$offset.']',
              isset($tel->ramal) ? $tel->ramal : null,
              array(
                'class'       => 'form-control ramal',
                'placeholder' => trans('individuos.plh.ramal'),
                'style' => 'margin-bottom:20px;',
                'id' => 'ramal'.$offset
              )
            )
          }}
        </div>
      </div>

      {{-- Botão para remover bloco de telefone --}}
               <div class="col-md-1">
                 {{
                   Form::button(
                     '<span><i class="fas fa-trash-alt"></i> <i class="fas fa-phone"></i></span>',
                     array(
                       'class' => 'btn delCloned',
                       'style' => 'margin-bottom:20px;margin-top:32px;margin-left:10px'
                     )
                   )
                 }}
               </div>

           </div><!-- .row -->
         </div><!-- .cloned-div -->

          @endforeach

          @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-phone"></i>'))

        </div><!-- .cloned-main -->


<hr>
<div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
      <h5><i class="fas fa-ellipsis-h" ></i> {{trans('individuos.lbl.informacao_adicional')}}</h5>
</div>

  <div class="form-group">
    <div class="row">

      <!-- Estado Civil -->
          <div class="col-4 {{ ($errors->has('tipo_estado_civil')) ? 'has-error' : '' }}">
            {{ Form::label('tipo_estado_civil', trans('individuos.lbl.tipo_estado_civil')) }}<span class="obrigatorio">*</span>
            {{
              Form::select(
                'tipo_estado_civil',
                $data['tipo_estado_civil'],
                isset($data['individuo']->estado_civil->tipo_estado_civil_id)? $data['individuo']->estado_civil->tipo_estado_civil_id : null,
                array("class"=>"form-control tipo_estado_civil",
                      'required'
              )
                )
              }}

              @if ($errors->has('tipo_estado_civil'))
              <div class="invalid-feedback">
                {{ $errors->first('tipo_estado_civil') }}
              </div>
              @endif
            </div>

      <!-- NIS -->
      <div class="col-4 {{ ($errors->has('nis')) ? 'has-error' : '' }}">
        {{ Form::label('nis', trans('individuos.lbl.nis')) }}
          {{ Form::text(
            'nis',
            $nis,
            array(
              'class'       => 'form-control nis',
              'placeholder' => trans('individuos.plh.nis'),
            )
          )
        }}

        @if ($errors->has('nis'))
        <div class="invalid-feedback">
          {{ $errors->first('nis') }}
        </div>
        @endif
      </div>


<!-- SUS — text com máscara -->
{{-- Cartão do SUS não é obrigatório --}}
      <div class="col-4 {{ ($errors->has('sus')) ? 'has-error' : '' }}">
        {{ Form::label('sus', trans('individuos.lbl.sus')) }}
          {{ Form::text(
            'sus',
            $sus,
            array(
              'class'       => 'form-control sus',
              'placeholder' => trans('individuos.plh.sus'),
            )
          )
        }}

      </div>

    </div>

  </div>

    <div class="form-group">
      <div class='form-row'>

        <!-- Cras -->
        <div class="col-6 {{ ($errors->has('cras')) ? 'has-error' : '' }}">
          {{ Form::label('cras', trans('individuos.lbl.cras')) }} <small> Centro de Referência de Assistência Social</small>
            {{ Form::text(
              'cras',
              isset($data['individuo']->ubsCras->cras) ? $data['individuo']->ubsCras->cras : null,
              array(
                'class'       => 'form-control cras',
              )
            )
          }}
      </div>

      <!-- UBS -->
      <div class="col-6 {{ ($errors->has('ubs')) ? 'has-error' : '' }}">
        {{ Form::label('ubs', trans('individuos.lbl.ubs')) }} <small> Unidade Básica de Saúde</small>
          {{ Form::text(
            'ubs',
            isset($data['individuo']->ubsCras->ubs) ? $data['individuo']->ubsCras->ubs : null,
            array(
              'class' => 'form-control ubs',
            )
          )
        }}
    </div>

    </div>
  </div>


<div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
      <h5><i class="fas fa-home"></i> {{trans('individuos.lbl.endereco')}}</h5>
</div>

<div class="endereco">
  <div class="form-group">
    <div class="row">
      <!-- CEP — text com máscara -->
            <div class="col-6 {{ ($errors->has('cep')) ? 'has-error' : '' }}">
              {{ Form::label('cep', trans('individuos.lbl.cep')) }} <small><a style='padding-left:5px;' target='_blank' href="http://www.buscacep.correios.com.br/sistemas/buscacep/"> Consultar CEP</a></small>
              {{ Form::text(
                'cep',
                isset($data['individuo']->endereco->cep) ? $data['individuo']->endereco->cep : null,
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

<!-- Estado -->
      <div class="col-6 {{ ($errors->has('estado')) ? 'has-error' : '' }}">
        {{ Form::label('estado', trans('individuos.lbl.estado')) }}<span class="obrigatorio">*</span>
        {{ Form::select(
            'estado',
            $data['estado'],
            isset($data['individuo']->endereco->cidade->estado->uf)? $data['individuo']->endereco->cidade->estado->uf : 'SP',
            array("class='form-control'",
                  'required')
          )
        }}

        @if ($errors->has('estado'))
        <div class="invalid-feedback">
          {{ $errors->first('estado') }}
        </div>
        @endif
      </div>
    </div>
</div>


  <div class="form-group">
  <div class="row">
    <!-- Cidade — select -->
    {{-- Condicional — lista select muda dependendo do estado selecionado --}}
          <div class="col-6 {{ ($errors->has('cidade')) ? 'has-error' : '' }}">
            {{ Form::label('cidade', trans('individuos.lbl.cidade')) }}<span class="obrigatorio">*</span>
            {{ Form::select(
              'cidade',
              $data['cidade'],
              isset($data['individuo']->endereco->cidade->id) ? $data['individuo']->endereco->cidade->id : 3388,
              array("class" => "form-control cidade", 'required')
              )
            }}

            @if ($errors->has('cidade'))
              <div class="invalid-feedback">
                {{ $errors->first('cidade') }}
              </div>
            @endif
          </div>

<!-- Bairro -->
      <div class="col-6 {{ ($errors->has('bairro')) ? 'has-error' : '' }}">
        {{ Form::label('bairro', trans('individuos.lbl.bairro')) }}<span class="obrigatorio">*</span>
        {{
          Form::text(
            'bairro',
            isset($data['individuo']->endereco->bairro)? $data['individuo']->endereco->bairro : null,
            array(
                'class'       => 'form-control bairro',
                'placeholder' => trans('individuos.plh.bairro'),
                'style'       =>"text-transform: uppercase",
                'required'
                )
          )
        }}
        {{-- {{
          Form::select(
            'bairro',
            $data['bairro'],
            isset($data['individuo']->endereco->bairro_id)? $data['individuo']->endereco->bairro_id : null,
            array(
                'class'       => 'form-control bairro',
                'placeholder' => trans('individuos.plh.bairro'),
                'style'       =>"text-transform: uppercase",
                'required'
                )
          )
        }} --}}

        @if ($errors->has('bairro'))
        <div class="invalid-feedback">
          {{ $errors->first('bairro') }}
        </div>
        @endif
      </div>

    </div>
  </div>

<div class="form-group">
  <div class="row">

<!-- Logradouro -->
      <div class="col-8 {{ ($errors->has('logradouro')) ? 'has-error' : '' }}">
        {{ Form::label('logradouro', trans('individuos.lbl.logradouro')) }}<span class="obrigatorio">*</span>
        {{
          Form::text(
            'logradouro',
            isset($data['individuo']->endereco->logradouro)? $data['individuo']->endereco->logradouro : null,
            array(
              'class'       => 'form-control logradouro',
              'placeholder' => trans('individuos.plh.logradouro'),
              'required'
            )
          )
        }}

        @if ($errors->has('logradouro'))
        <div class="invalid-feedback">
          {{ $errors->first('logradouro') }}
        </div>
        @endif
      </div>

<!-- Numero-->
      <div class="col-4 {{ ($errors->has('numero')) ? 'has-error' : '' }}">
        {{ Form::label('numero', trans('individuos.lbl.numero')) }}<span class="obrigatorio">*</span>
        {{
          Form::text(
            'numero',
            isset($data['individuo']->endereco->numero)? $data['individuo']->endereco->numero : null,
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
  </div>

  <div class="row">
<!-- Complemento -->
      <div class="col-8 {{ ($errors->has('complemento')) ? 'has-error' : '' }}">
        {{ Form::label('complemento', trans('individuos.lbl.complemento')) }}
        {{
          Form::text(
            'complemento',
            isset($data['individuo']->endereco->complemento)? $data['individuo']->endereco->complemento : null,
            array(
              'class'       => 'form-control',
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
                    'class' => 'btn btn-md',
                    'style' => 'width:100%; margin-top:32px;',
                    'onclick' => "buscar();"
                  )
                )
               }}
            </div>
          </div>
      </div>
    </div>

      <div class="col-12">
        <div id="mapa" style="height:200px"></div>
        <div class="text-center">
        {{Form::hidden(
          "latitude",
          isset($data['individuo_endereco'])? $data['individuo_endereco']->latitude : null
        ) }}
        {{Form::hidden(
          "longitude",
          isset($data['individuo_endereco'])? $data['individuo_endereco']->longitude : null,
          ['class' => 'do-not-ignore required']
        ) }}
          </div>
      </div>

<br>
<!-- Parentesco -->
<div>
  @include('individuos/_form-edit_parentesco')
</div>

<br>
<!-- Trabalho e Estudo -->
<div>
  @include('individuos/_form-edit_estudotrabalho')
</div>

<br>
<!-- Vida Diária e Quedas -->
<div>
  @include('individuos/_form-edit_vidadiaria')
</div>

<br>
<!-- Moradia e Renda -->
<div>
  @include('individuos/_form-edit_moradiarenda')
</div>

<br>
<!-- Benefícios -->
<div>
  @include('individuos/_form-edit_beneficio')
</div>

<br>
<!-- Credencial -->
<div>
  @include('individuos/_form-edit_credencial')
</div>

<br>
<!-- Interditado Judicialmente -->
<div>
  @include('individuos/_form-edit_interditado')
</div>

<br>
<!-- Saúde, acompanhamento e medicação -->
<div>
  @include('individuos/_form-edit_saude')
</div>

<br>
<!-- Mobilidade e comunicação -->
<div>
  @include('individuos/_form-edit_mobilidadecomunicacao')
</div>

<br>
<!-- Tecnologia Assistiva -->
<div>
  @include('individuos/_form-edit_tecnologiaassistiva')
</div>

<br>
<!-- Deficiências -->
<div>
  @include('individuos/_form-edit_deficiencia')
</div>

<br>
<!-- Informação e sugestão -->
<div>
  @include('individuos/_form-edit_informacao')
</div>


    </div><!-- FIM form -->


    <div class="card-footer text-right">

      <small>{{trans('application.msg.obrigatorio')}}<small> <span class="obrigatorio" style='padding-right:10px;'>*</span>

      {{
        link_to_route(
          'individuos.index',
          trans('application.btn.cancel'),
          null,
          array(
            'class' => 'btn btn-default'
          )
        )
      }}

      {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

    </div>

  </div>

{{ Form::close() }}
