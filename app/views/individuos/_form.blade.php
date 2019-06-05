{{-- Método para criar form update e create
SE indivíduo já existir, chamar update
SENÃO chama create --}}

{{-- Form create e edit separados — editar em _form-edit.blade.php --}}
@if (isset($individuo->id))

{{ Form::model($individuo, array('id' => 'IndividuoForm', 'data-individuo_id' => $individuo->id, 'method' => 'PATCH', 'route' => array('individuos.update', $individuo->id))) }}

@else

{{ Form::open(array('id' => 'IndividuoForm', 'route' => 'individuos.store', 'data-individuo_id' => null)) }}

@endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
        @if (isset($individuo->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create-individuo', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>

    <div class="card-body">

<div class="form-group">

  {{-- Campo input invisível para pegar $ondeEstou --}}
  {{Form::hidden(
    'ondeEstou',
    isset($data['ondeEstou']) ? $data['ondeEstou'] : null
  )}}

<!-- Nome -->
      <div class="form-group {{ ($errors->has('nome')) ? 'has-error' : '' }}">
        {{ Form::label('nome', trans('individuos.lbl.nome')) }}<span class="obrigatorio">*</span>
        {{ Form::text(
            'nome',
            Input::old('nome'),
            array(
              'class'       => 'form-control nome',
              'placeholder' => trans('individuos.plh.nome'),
              'required'
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

<!-- CPF — text com máscara -->
        <div class="col-6 {{ ($errors->has('cpf')) ? 'has-error' : '' }}">
          {{ Form::label('cpf', trans('individuos.lbl.cpf')) }}<span class="obrigatorio">*</span>
            {{ Form::text(
              'cpf',
              Input::old('cpf'),
              array(
                'id' => 'cpf',
                'class' => 'form-control cpf',
                'placeholder' => trans('individuos.plh.cpf'),
                'required'
              )
            )
          }}

          @if ($errors->has('cpf'))
          <div class="invalid-feedback">
            {{ $errors->first('cpf') }}
          </div>
          @endif
        </div>


<!-- Sexo — radio -->
        <div class="col-6 {{ ($errors->has('sexo_id')) ? 'has-error' : '' }}">
          {{ Form::label('sexo_id', trans('individuos.lbl.sexo_id')) }}<span class="obrigatorio">*</span>
          <div class="form-group">
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

            </div>
          </div>
          @if ($errors->has('sexo_id'))
          <div class="invalid-feedback">
            {{ $errors->first('sexo_id') }}
          </div>
          @endif
        </div>


      </div>
</div>


  <div class="row" style="margin-top:-10px;">
<!-- Data de nascimento — text com máscara -->
      <div class="col-8 {{ ($errors->has('data_nascimento')) ? 'has-error' : '' }}">
        {{ Form::label('data_nascimento', trans('individuos.lbl.data_nascimento')) }}<span class="obrigatorio">*</span>
          {{ Form::text(
            'data_nascimento',
            Input::old('data_nascimento'),
            array(
              'class'       => 'form-control data_nascimento datas getAge',
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


<!-- Estado Civil — select -->
      {{-- <div class="col-6 {{ ($errors->has('tipo_estado_civil')) ? 'has-error' : '' }}">
        {{ Form::label('tipo_estado_civil', trans('individuos.lbl.tipo_estado_civil')) }}<span class="obrigatorio">*</span>
        {{
          Form::select(
            'tipo_estado_civil',
            $data['tipo_estado_civil'],
            Input::old('tipo_estado_civil'),
            array("class" => 'form-control estado_civil')
          )
        }}

        @if ($errors->has('tipo_estado_civil'))
        <div class="invalid-feedback">
          {{ $errors->first('tipo_estado_civil') }}
        </div>
        @endif
      </div> --}}

    </div>


  {{-- <div class="row"> --}}



<!-- NIS -->
      {{-- <div class="col-4 {{ ($errors->has('nis')) ? 'has-error' : '' }}">
        {{ Form::label('nis', trans('individuos.lbl.nis')) }}
          {{ Form::text(
            'nis',
            Input::old('nis'),
            array(
              'class'       => 'form-control nis',
              'placeholder' => trans('individuos.plh.nis'),
              'required'
            )
          )
        }}

        @if ($errors->has('nis'))
        <div class="invalid-feedback">
          {{ $errors->first('nis') }}
        </div>
        @endif
      </div> --}}


<!-- SUS — text com máscara -->
{{-- Cartão do SUS não é obrigatório --}}
      {{-- <div class="col-4 {{ ($errors->has('sus')) ? 'has-error' : '' }}">
        {{ Form::label('sus', trans('individuos.lbl.sus')) }}
          {{ Form::text(
            'sus',
            Input::old('sus'),
            array(
              'class'       => 'form-control sus',
              'placeholder' => trans('individuos.plh.sus'),
            )
          )
        }}

        @if ($errors->has('sus'))
        <div class="invalid-feedback">
          {{ $errors->first('sus') }}
        </div>
        @endif
      </div> --}}


<!-- Data de casamento — text com máscara -->
{{-- Por padrão, input desabilitado. É habilitado apenas se Estado Civil com id 6, 7ou 8 for selecionado --}}
      {{-- <div class="col-4 {{ ($errors->has('data_casamento')) ? 'has-error' : '' }}">
        {{ Form::label('data_casamento', trans('individuos.lbl.data_casamento')) }}
        {{ Form::text(
          'data_casamento',
          Input::old('data_casamento'),
          array(
            'class'       => 'form-control data_casamento datas',
            'placeholder' => trans('individuos.plh.data_casamento'),
            'disabled'
          )
        )
      }}
        @if ($errors->has('data_casamento'))
        <div class="invalid-feedback">
          {{ $errors->first('data_casamento') }}
        </div>
        @endif
      </div> --}}

    {{-- </div> --}}


<br>
<div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
      <h5><i class="fas fa-phone"></i> {{trans('individuos.lbl.contato')}}</h5>
</div>

<!-- Email — text -->
      <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
        {{ Form::label('nome', trans('individuos.lbl.email')) }}
        {{ Form::text(
            'email',
            Input::old('email'),
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
<?php
  $telefones = ['telefones'];
?>

{{-- Bloco de telefone pode ser clonado --}}
  <div class="form-group cloned-main {{ ($errors->has('numero')) ? 'has-error' : '' }}">
    @foreach ($telefones as $offset => $numero)

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
                Input::old('tipo_telefone'),
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
                      Input::old('telefone'),
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
              Input::old('ramal'),
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


    </div><!-- FIM form -->


    <div class="card-footer text-right">

{{-- Botão de cancelar --}}
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

{{-- Botão de salvar --}}
      <button type="submit" name="action" value="save" class="btn btn-primary save">{{trans('application.btn.save')}}</button>
      <button type="submit" name="action" value="saveredirect" class="btn btn-success save">{{trans('application.btn.save_atendimento')}}</button>

    </div>

  </div>

{{ Form::close() }}
