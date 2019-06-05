@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'entradaFilterForm', 'method' => 'PUT')) }}

  <div class="form-row">

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-align-left fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'titulo',
            null,
            array(
              'class'       => 'form-control',
              'placeholder' => 'TÍTULO DO ATENDIMENTO'
            )
          )
        }}

      </div>
    </div>

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-users fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_individuo_id',
            [],
            null,
            array(
              'title' => 'SELECIONE O INDIVÍDUO',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker individuo'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-list-ol fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_tipo_atendimento_id[]',
            $data['categorias'],
            null,
            array(
              'multiple',
              'title' => 'SELECIONE AS CATEGORIAS',
              'data-live-search' => 'true',
              'data-selected-text-format' => 'count',
              'class' => 'form-control selectpicker',
            )
          )
        }}

      </div>
    </div>

  </div>

  <div class="form-row">

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-sync-alt fa-fw"></i>
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

    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-calendar-alt fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_data_inicio',
            null,
            array(
              'id' => 'date',
              'type' => 'text',
              'class' => 'form-control datas',
              'placeholder' => 'DATA INICIO'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-4">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-calendar-alt fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_data_fim',
            null,
            array(
              'id' => 'date',
              'type' => 'text',
              'class' => 'form-control datas',
              'placeholder' => 'DATA FIM'
            )
          )
        }}

      </div>
    </div>


  </div>

  <div class="form-row">

    <div class="form-group col-md-12">

      {{ Form::submit(
          trans('application.btn.search'),
          array(
            'id' => 'entradaFilterSubmit',
            'class' => 'btn btn-info btn-sm float-right'
          )
        )
      }}

      {{ link_to_route(
          'entrada.index',
          trans('application.btn.clean'),
          null,
          array(
            'id'    => 'entradaFilterClean',
            'class' => 'btn btn-secondary btn-sm float-right mr-1'
          )
        )
      }}

    </div>

  </div>

  {{ Form::close() }}

  @stop
