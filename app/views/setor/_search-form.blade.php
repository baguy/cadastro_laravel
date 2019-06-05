@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'setorFilterForm', 'method' => 'PUT')) }}

  <div class="form-row">

    <div class="form-group col-md-8">

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-project-diagram fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_setor_id',
            [],
            null,
            array(
              'title' => 'PESQUISE POR NOME DO SETOR',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker setor'
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


  <div class="form-row">

    <div class="form-group col-md-12">

      {{ Form::submit(
          trans('application.btn.search'),
          array(
            'id' => 'setorFilterSubmit',
            'class' => 'btn btn-info btn-sm float-right'
          )
        )
      }}

      {{ link_to_route(
          'setor.index',
          trans('application.btn.clean'),
          null,
          array(
            'id'    => 'setorFilterClean',
            'class' => 'btn btn-secondary btn-sm float-right mr-1'
          )
        )
      }}

    </div>

  </div>

  {{ Form::close() }}

  @stop
