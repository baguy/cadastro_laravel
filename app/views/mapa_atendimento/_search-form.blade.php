@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'mapa_atendimentoFilterForm', 'method' => 'PUT')) }}

  <div class="form-row">

    <div class="form-group col-md-4">

      {{ Form::label('parecer', trans('atendimento.lbl.titulo')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Pesquise pelo título' class="fas fa-align-left fa-fw"></i>
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

      {{ Form::label('parecer', trans('individuos.individuo')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Insira nome ou cpf' class="fas fa-users fa-fw"></i>
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

      {{ Form::label('parecer', trans('atendimento.lbl.categoria')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Pesquise por categoria' class="fas fa-list-ol fa-fw"></i>
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

      {{ Form::label('parecer', trans('atendimento.lbl.status')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Status aberto, em andamento, encerrado ou inativo' class="fas fa-sync-alt fa-fw"></i>
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

      {{ Form::label('parecer', trans('atendimento.lbl.data_inicio')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Atendimento com data idual ou menor' class="fas fa-calendar-alt fa-fw"></i>
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

      {{ Form::label('parecer', trans('setor.setor')) }}

      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Setor do atendimento' class="fas fa-project-diagram fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_setor[]',
            $data['setor'],
            null,
            array(
              'multiple',
              'title' => 'SELECIONE SETOR',
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

    <div class="form-group col-md-12">

      {{ Form::submit(
          trans('application.btn.search'),
          array(
            'id' => 'mapa_atendimentoFilterSubmit',
            'class' => 'btn btn-info btn-sm float-right'
          )
        )
      }}

      {{ link_to_route(
          'atendimento.index',
          trans('application.btn.clean'),
          null,
          array(
            'id'    => 'mapa_atendimentoFilterClean',
            'class' => 'btn btn-secondary btn-sm float-right mr-1',
            'onclick' => "clean();"
          )
        )
      }}

      {{
        Form::button(
          '<span>Buscar no mapa</span>',
          array(
            'class' => 'btn btn-warning btn-sm float-right mr-1',
            'onclick' => "buscar();",
            'id' => 'mapa_atendimentoFilterSubmit'
          )
        )
       }}

      <button onclick="printPage()" data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.print-this') }}" class="btn btn-secondary btn-sm float-right mr-1"><i class="fas fa-print"></i></button>

    </div>


  </div>

  {{ Form::close() }}

  @stop

  <script>
    function printPage() {
      window.print();
    }
  </script>
