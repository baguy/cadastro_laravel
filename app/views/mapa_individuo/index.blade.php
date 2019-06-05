@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.mapa') }}
@stop

@section('CSS')
  {{-- CSS para o MAPA --}}
  <link href='{{ asset('assets/plugins/mapbox/mapbox.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster-default.css') }}' rel='stylesheet' />
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">

    @include('individuos/_legends')

{{-- Botão superior direito para Adicionar Novo --}}
<div>
    <span class="float-right">
      {{
        link_to_route(
          'individuos.index',
          trans('individuos.individuo'),
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>
</div>

  </div><!-- /Card header -->

  <!-- Card Body -->
  <div class="card-body">

{{-- Pesquisa --}}
    @include('mapa_individuo/_search-form')

{{-- MAPA — Div para mapa --}}
    <div id="mapa" style="height:600px;width:100%;"></div>

    {{-- TABELA  — Div para inseção da tabela de lista de indivíduos --}}
        <div id="mapa_individuoDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

    <span class="float-right">
      {{
        link_to_route(
          'individuos.create',
          trans('application.btn.add-new'),
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>

  </div><!-- Card Footer -->

</div>

@stop

@section('SCRIPTS')

  {{-- JS — painel de busca --}}
  <script src="{{ asset('assets/js/search.panel.js') }}"></script>
  {{-- JS — inserção da tabela --}}
  <script src="{{ asset('assets/js/table.description.js') }}"></script>
  <script src="{{ asset('assets/js/datatable.js') }}"></script>
  {{-- JS — busca dinâmica de indivíduos/munícipes --}}
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  {{-- JS — MAPA --}}
  <script src="{{ asset('assets/plugins/mapbox/mapbox.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/markercluster.js') }}"></script>
  <script src="{{ asset('assets/js/mapbox_index.js') }}"></script>
  <script src="{{ asset('assets/js/bairro.js') }}"></script>
  <!-- Data Export -->
  <script src="{{ asset('assets/js/()_data.export.js') }}"></script>

  <script type="text/javascript">


  // Função para iniciar painel de busca, inserir tabela na div #individuosDataTableContainer
  // submeter filtros #individuosFilterForm e limpar busca #individuosFilterClean
    $(function() {

      var searchPanel = new AdminTR.SearchPanel('MAPA_INDIVIDUO');

      searchPanel.initialize();

      new AdminTR.DataTable('mapa_individuo', $('#mapa_individuoDataTableContainer')).initialize();

      $("#mapa_individuoFilterForm").submit(function(e) {

        e.preventDefault()

        new AdminTR.DataTable('mapa_individuo', $('#mapa_individuoDataTableContainer'), $('#mapa_individuoFilterForm')).initialize();
      });

      $("#mapa_individuoFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');

        new AdminTR.DataTable('mapa_individuo', $('#mapa_individuoDataTableContainer')).initialize();
      });
    });

  </script>

@stop

@stop
