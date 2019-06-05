@if (isset($data['funcionario']->id))

{{ Form::model($data['funcionario'], array('id' => 'funcionarioForm', 'method' => 'PATCH', 'route' => array('funcionario.update', $data['funcionario']->id))) }}

@else

{{ Form::open(array('id' => 'funcionarioForm', 'route' => 'funcionario.store', 'method' => 'POST')) }}

@endif


<div class="card">
  <div class="card-header">
    <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">

      {{-- Botão superior direito para Adicionar Novo --}}
      <div>
          <span class="float-right">
            {{
              link_to_route(
                'setor.create',
                trans('application.btn.add-new-setor'),
                null,
                array(
                  'class' => 'btn btn-success btn-sm',
                  'style' => "margin-top:-3px;margin-right:2px",
                )
              )
            }}
          </span>
      </div>

      @if (isset($data['funcionario']->id))
      {{ trim(trans('application.action.edit-funcionario', ['icon' => '<i class="fas fa-edit"></i>'])) }}
      @else
      {{ trim(trans('application.action.create-funcionario', ['icon' => '<i class="fas fa-save"></i>'])) }}
      @endif

    </h3>
  </div>
  <div class="card-body">

    <div class="form-row">

      <div class="form-group col-md-12">

        {{ Form::label('setor', trans('funcionario.lbl.setor')) }}<span class="obrigatorio">*</span>
        <div class="input-group {{ ($errors->has('individuo_id')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-user fa-fw"></i>
            </span>
          </div>

          {{ Form::select(
            'setor_id[]',
            $data['setor'],
            isset($data['funcionario']) ? FormatterHelper::multiSelectValues($data['funcionario']->setor) : null,
            array(
              'multiple',
              'title' => 'SELECIONE O SETOR',
              'class' => 'form-control selectpicker setor',
              'data-live-search' => 'true',
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important;">
            @if ($errors->has('setor_id'))
              {{ $errors->first('setor_id') }}
            @endif
          </div>

        </div>
      </div>
    </div>

{{-- Nome --}}
    <div class="form-row">
      <div class="form-group col-md-12">

        {{ Form::label('nome', trans('funcionario.lbl.nome')) }}<span class="obrigatorio">*</span>

        <div class="input-group {{ ($errors->has('nome')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-align-left fa-fw"></i>
            </span>
          </div>

          {{ Form::text(
            'nome',
            isset($data['funcionario']) ? $data['funcionario']->nome : null,
            array(
              (isset($data['funcionario']) && !Auth::user()->hasRole('ADMIN')) ? 'readonly' : '',
              'class' => 'form-control nome',
              'placeholder' => trans('funcionario.plh.nome')
              )
            )
          }}

          <div class="invalid-feedback" style="display:block !important">
            @if ($errors->has('nome'))
              {{ $errors->first('nome') }}
            @endif
          </div>

        </div>
      </div>
</div>

  <div class="row">

<!-- Matrícula-->
      <div class="col-4 {{ ($errors->has('matricula')) ? 'has-error' : '' }}">
        {{ Form::label('matricula', trans('funcionario.lbl.matricula')) }}<span class="obrigatorio">*</span>
        {{
          Form::text(
            'matricula',
            isset($data['funcionario']->endereco->matricula)? $data['funcionario']->endereco->matricula : null,
            array(
              'class'       => 'form-control',
              'placeholder' => trans('funcionario.plh.matricula')
            )
          )
        }}

        @if ($errors->has('matricula'))
        <div class="invalid-feedback">
          {{ $errors->first('matricula') }}
        </div>
        @endif
      </div>

<!-- Email — text -->
      <div class="col-8 {{ ($errors->has('email')) ? 'has-error' : '' }}">
        {{ Form::label('nome', trans('individuos.lbl.email')) }}
        {{ Form::text(
            'email',
            Input::old('email'),
            array(
              'id'          => 'email',
              'class'       => 'form-control email',
              'placeholder' => trans('individuos.plh.email'),
              'placeholder'      => trans('users.lbl.email'),
              'aria-describedby' => 'emailHelp',
              'aria-labelledby'  => 'emailAddon'
            )
          )
        }}
        <small id="emailHelp" class="form-text text-muted">
          {{ trans('application.misc.institutional-email') }} - <code class="text-info"
          data-tooltip="tooltip"
          data-placement="bottom"
          data-container="small"
          title="{{ trans('application.misc.click-to-copy') }}" style="cursor: pointer;">
            {{'@'}}{{ trans('application.config.site-domain') }}
          </code>
        </small>
        @if ($errors->has('email'))
        <div class="invalid-feedback">
          {{ $errors->first('email') }}
        </div>
        @endif
      </div>

    </div>

  </div>

  <div class="card-footer text-right">
    {{
      link_to_route(
      'funcionario.index',
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
