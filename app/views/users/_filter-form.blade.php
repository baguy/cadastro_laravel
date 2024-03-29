@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'usersFilterForm', 'method' => 'PUT')) }}

    <div class="form-row">

      <div class="form-group col-md-8">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-search fa-fw"></i>
            </span>
          </div>

          {{ Form::text('name|email', null, array('class' => 'form-control', 'placeholder' => trans('users.filter.plh.name-&-email'))) }}

        </div>

      </div>

      <div class="form-group col-md-4">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-signal fa-fw"></i>
            </span>
          </div>

          {{ Form::select('S_status', $selects['status'], null, array('id' => 'S_status', 'class' => 'form-control')) }}

        </div>

      </div>

    </div>

    <div class="form-row">

      <div class="form-group col-md-4">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-layer-group fa-fw"></i>
            </span>
          </div>

          {{ Form::select('S_roles', $selects['roles'], null, array('id' => 'S_roles', 'class' => 'form-control')) }}

        </div>

      </div>

      <div class="form-group col-md-8">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-list-ol fa-fw"></i>
            </span>
          </div>

          {{ Form::select('S_attempts', $selects['attempts'], null, array('id' => 'S_attempts', 'class' => 'form-control')) }}

        </div>

      </div>

      {{-- <div class="form-group col-md-4">

        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-lock fa-fw"></i>
            </span>
          </div>

          {{
            Form::select(
              'S_is_default_password',
              $selects['is_default_password'],
              null,
              array(
                'id' => 'S_is_default_password', 'class' => 'form-control'
              )
            )
          }}

        </div>

      </div> --}}

    </div>

    <div class="form-row">

      <div class="form-group col-md-12">

        {{
          Form::submit(
            trans('application.btn.search'),
            array(
              'id' => 'usersFilterSubmit',
              'class' => 'btn btn-info btn-sm float-right'
            )
          )
        }}

        {{
          link_to_route(
            'users.index',
            trans('application.btn.clean'),
            null,
            array(
              'id'    => 'usersFilterClean',
              'class' => 'btn btn-secondary btn-sm float-right mr-1'
            )
          )
        }}

      </div>

    </div>

  {{ Form::close() }}

@stop
