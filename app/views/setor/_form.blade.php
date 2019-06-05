@if (isset($data['setor']->id))

  {{ Form::model($data['setor'], array('id' => 'SetorForm', 'method' => 'PATCH', 'route' => array('setor.update', $data['setor']->id))) }}

@else

  {{ Form::open(array('id' => 'SetorForm', 'route' => 'setor.store', 'method' => 'POST')) }}

@endif


<div class="card">
  <div class="card-header">
    <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">

      {{-- Botão superior direito para Adicionar Novo --}}
      <div >
          <span class="float-right">
            {{
              link_to_route(
                'setor.create',
                trans('application.btn.add-new'),
                null,
                array(
                  'class' => 'btn btn-success btn-sm',
                  'style' => "margin-top:-3px;margin-right:2px",
                )
              )
            }}
          </span>
      </div>

      @if (isset($data['setor']->id))
      {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
      @else
      {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
      @endif

    </h3>
  </div>
  <div class="card-body">

    <div class="form-row">
      <div class="form-group col-md-12">

        {{ Form::label('nome', trans('setor.lbl.nome')) }}<span class="obrigatorio">*</span>

        <div class="input-group {{ ($errors->has('nome')) ? 'has-error' : '' }}">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-align-left fa-fw"></i>
            </span>
          </div>

          {{ Form::text(
            'nome',
            isset($data['setor']) ? $data['setor']->nome : null,
            array(
              (isset($data['setor']) && !Auth::user()->hasRole('ADMIN')) ? 'readonly' : '',
              'class' => 'form-control nome',
              'placeholder' => trans('setor.plh.nome')
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


  </div>

  <div class="card-footer text-right">
    {{
      link_to_route(
      'setor.index',
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
