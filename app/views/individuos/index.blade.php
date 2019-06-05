@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.index') }}
@stop

@section('CSS')
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
          'individuos.create',
          trans('application.btn.add-new'),
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
    @include('individuos/_search-form')

{{-- TABELA  — Div para inseção da tabela de lista de indivíduos --}}
    <div id="individuosDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div><!-- .card-body -->

  <div class="card-footer">

    @include('individuos/_legends')

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
  <script src="{{ asset('assets/js/bairro.js') }}"></script>
  <!-- Data Export -->
  <script src="{{ asset('assets/js/()_data.export.js') }}"></script>

  <script type="text/javascript">


  // Função para iniciar painel de busca, inserir tabela na div #individuosDataTableContainer
  // submeter filtros #individuosFilterForm e limpar busca #individuosFilterClean
    $(function() {

      var searchPanel = new AdminTR.SearchPanel('INDIVIDUOS');

      searchPanel.initialize();

      new AdminTR.DataTable('individuos', $('#individuosDataTableContainer')).initialize();

      $("#individuosFilterForm").submit(function(e) {

        e.preventDefault()

        new AdminTR.DataTable('individuos', $('#individuosDataTableContainer'), $('#individuosFilterForm')).initialize();
      });

      $("#individuosFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');

        new AdminTR.DataTable('individuos', $('#individuosDataTableContainer')).initialize();
      });
    });

  </script>

@stop

@stop
