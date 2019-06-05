@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'funcionarioFilterForm', 'method' => 'PUT')) }}

  <div class="form-row">

    <div class="form-group col-md-8">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-user fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_funcionario_id',
            [],
            null,
            array(
              'title' => 'PESQUISE POR NOME OU MATRÍCULA',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker funcionario'
            )
          )
        }}

      </div>
    </div>

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-layer-group fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_status_id',
            $data['status'],
            null,
            array(
              'class' => 'form-control',
            )
          )
        }}

      </div>
    </div>

</div>
{{-- <div class="form-row">

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-city fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_bairro',
            null,
            array(
              'class'       => 'form-control',
              'placeholder' => 'INSIRA O BAIRRO'
            )
          )
        }}

      </div>
    </div> --}}




{{--    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-calendar-alt fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_data_nascimento',
            null,
            array(
              'id' => 'date',
              'type' => 'text',
              // 'onfocus' => '(this.type = "date")',
              'class'       => 'form-control textbox-n datas',
              'placeholder' => 'DATA DE NASCIMENTO'
            )
          )
        }}

      </div>
    </div>

  </div> --}}

  <div class="form-row">

    <div class="form-group col-md-12">

      {{ Form::submit(
          trans('application.btn.search'),
          array(
            'id' => 'funcionarioFilterSubmit',
            'class' => 'btn btn-info btn-sm float-right'
          )
        )
      }}

      {{ link_to_route(
          'funcionario.index',
          trans('application.btn.clean'),
          null,
          array(
            'id'    => 'funcionarioFilterClean',
            'class' => 'btn btn-secondary btn-sm float-right mr-1'
          )
        )
      }}

    </div>

  </div>

  {{ Form::close() }}

  @stop
