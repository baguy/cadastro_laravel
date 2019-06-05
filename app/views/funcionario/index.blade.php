@extends('templates.application')

@section('PAGE_TITLE')
 {{ trans('funcionario.page.title.index') }}
@stop

@section('CSS')
  <link rel="stylesheet" href="{{ asset('assets/css/_atendimento.css') }}">
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">

    <span style="float:right;">
      {{
        link_to_route('funcionario.create', trans('application.btn.add-new'), null, array('class' => 'btn btn-success btn-sm'))
      }}
    </span>

  </div>

  <div class="card-body">
    @include('funcionario/_search-form')

    <div id="funcionarioDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>


  <div class="card-footer">

    <span class="float-right">
      {{
        link_to_route('funcionario.create', trans('application.btn.add-new'), null, array('class' => 'btn btn-success btn-sm'))
      }}
    </span>
  </div>
</div>

@section('SCRIPTS')
  <script src="{{ asset('assets/js/search.panel.js') }}"></script>
  <script src="{{ asset('assets/js/table.description.js') }}"></script>
  <script src="{{ asset('assets/js/datatable.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  <script src="{{ asset('assets/js/funcionario.js') }}"></script>
  <script type="text/javascript">

    $(function() {

      var searchPanel = new AdminTR.SearchPanel('FUNCIONARIO');

      searchPanel.initialize();

      new AdminTR.DataTable('funcionario', $('#funcionarioDataTableContainer')).initialize();

      $("#funcionarioFilterForm").submit(function(e) {

        e.preventDefault()

        new AdminTR.DataTable('funcionario', $('#funcionarioDataTableContainer'), $('#funcionarioFilterForm')).initialize();
      });

      $("#funcionarioFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');

        new AdminTR.DataTable('funcionario', $('#funcionarioDataTableContainer')).initialize();
      });
    });

  </script>
@stop

@stop
