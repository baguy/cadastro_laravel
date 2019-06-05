@extends('templates.application')

@section('PAGE_TITLE')
 {{ trans('atendimento.page.title.index') }}
@stop

@section('CSS')
  <link rel="stylesheet" href="{{ asset('assets/css/_atendimento.css') }}">
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">

    <span style="float:right;">
      {{
        link_to_route('atendimento.create', trans('application.btn.add-new'), null, array('class' => 'btn btn-success btn-sm'))
      }}
    </span>

  </div>

  <div class="card-body">
    @include('atendimento/_search-form')

    <div id="atendimentosDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

    <div class="card-footer">
      <span class="float-right">
        {{
          link_to_route('atendimento.create', trans('application.btn.add-new'), null, array('class' => 'btn btn-success btn-sm'))
        }}
      </span>
    </div>
  </div><!-- .card-body -->

@section('SCRIPTS')
  <script src="{{ asset('assets/js/search.panel.js') }}"></script>
  <script src="{{ asset('assets/js/table.description.js') }}"></script>
  <script src="{{ asset('assets/js/datatable.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>

  <script type="text/javascript">

    $(function() {

      var searchPanel = new AdminTR.SearchPanel('ATENDIMENTOS');

      searchPanel.initialize();

      new AdminTR.DataTable('atendimento', $('#atendimentosDataTableContainer')).initialize();

      $("#atendimentosFilterForm").submit(function(e) {

        e.preventDefault()

        new AdminTR.DataTable('atendimento', $('#atendimentosDataTableContainer'), $('#atendimentosFilterForm')).initialize();
      });

      $("#atendimentosFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');

        new AdminTR.DataTable('atendimento', $('#atendimentosDataTableContainer')).initialize();
      });
    });

  </script>
@stop

@stop
