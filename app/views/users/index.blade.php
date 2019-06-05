@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.index') }}
@stop

@section('STYLES')

  <!-- &_Users -->
  <link rel="stylesheet" href="{{ asset('assets/css/&_users.css') }}">

@stop

@section('MAIN')

<div class="card">
  <div class="card-header">
    
    @include('users/_legends')

    <span class="float-right">
      {{ 
        link_to_route(
          'users.create', 
          trans('application.btn.add-new'), 
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        ) 
      }}
    </span>
    
  </div>
  <div class="card-body">

    @include('users/_filter-form')

    <div id="usersDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

    @include('users/_legends')

    <span class="float-right">
      {{ 
        link_to_route(
          'users.create', 
          trans('application.btn.add-new'), 
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>
  </div>

</div>

@stop

@section('SCRIPTS')

  <!-- Search Panel -->
  <script src="{{ asset('assets/js/search.panel.js') }}"></script>
  
  <!-- Table Description -->
  <script src="{{ asset('assets/js/table.description.js') }}"></script>

  <!-- DataTable -->
  <script src="{{ asset('assets/js/datatable.js') }}"></script>

  <!-- DataTable - Initialize -->
  <script type="text/javascript">
    
    $(function() {

      var searchPanel = new AdminTR.SearchPanel('USERS');
      
      searchPanel.initialize();
    
      new AdminTR.DataTable('users', $('#usersDataTableContainer')).initialize();

      $("#usersFilterForm").submit(function(e) {

        e.preventDefault()
        
        new AdminTR.DataTable('users', $('#usersDataTableContainer'), $('#usersFilterForm')).initialize();
      });

      $("#usersFilterClean").click(function(e) {

        e.preventDefault()

        $(this).closest('form').trigger('reset');
        
        new AdminTR.DataTable('users', $('#usersDataTableContainer')).initialize();
      });
    });

  </script>

@stop