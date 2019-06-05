@extends('templates.application')

@section('PAGE_TITLE')
 {{ trans('atendimento.page.title.index') }}
@stop

@section('CSS')
  <link rel="stylesheet" href="{{ asset('assets/css/_atendimento.css') }}">
  {{-- CSS para o MAPA --}}
  <link href='{{ asset('assets/plugins/mapbox/mapbox.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster-default.css') }}' rel='stylesheet' />
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">

    <span style="float:right;">
      {{
        link_to_route('atendimento.index', trans('atendimento.atendimento'), null, array('class' => 'btn btn-success btn-sm'))
      }}
    </span>

  </div>

  <div class="card-body">
    @include('mapa_atendimento/_search-form')


  {{-- MAPA — Div para mapa --}}
      <div id="mapa" style="height:600px;width:100%;"></div>

      <div id="mapa_atendimentoDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  <div class="card-footer">

    <span class="float-right">
      {{
        link_to_route('atendimento.create', trans('application.btn.add-new'), null, array('class' => 'btn btn-success btn-sm'))
      }}
    </span>
  </div>
</div>

@section('SCRIPTS')
  <script src="{{ asset('assets/js/search.panel.js') }}"></script>
  <script src="{{ asset('assets/js/table.description.js') }}"></script>
  <script src="{{ asset('assets/js/datatable.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  Uncaught ReferenceError:
  {{-- JS — MAPA --}}
  <script src="{{ asset('assets/plugins/mapbox/mapbox.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/markercluster.js') }}"></script>
  <script src="{{ asset('assets/js/mapbox_index.js') }}"></script>

  <script type="text/javascript">

    $(function() {

      var searchPanel = new AdminTR.SearchPanel('MAPA_ATENDIMENTO');

      searchPanel.initialize();

      new AdminTR.DataTable('mapa_atendimento', $('#mapa_atendimentoDataTableContainer')).initialize();

      $("#mapa_atendimentoFilterForm").submit(function(e) {

        e.preventDefault()

        new AdminTR.DataTable('mapa_atendimento', $('#mapa_atendimentoDataTableContainer'), $('#mapa_atendimentoFilterForm')).initialize();
      });

      $("#mapa_atendimentoFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');

        new AdminTR.DataTable('mapa_atendimento', $('#mapa_atendimentoDataTableContainer')).initialize();
      });
    });

  </script>
@stop

@stop
