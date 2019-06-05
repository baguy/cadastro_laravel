@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.create') }}
@stop

@section('MAIN')

	@include('users/_form')

@stop

@section('SCRIPTS')

  <!-- $_Auth -->
  <script src="{{ asset('assets/js/$_auth.js') }}"></script>

  <!-- $_Users -->
  <script src="{{ asset('assets/js/$_users.js') }}"></script>

@stop
