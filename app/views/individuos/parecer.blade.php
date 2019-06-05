@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.parecer') }}
@stop

@section('CSS')
@stop

@section('MAIN')

  @include('individuos/_parecer')

@stop

@section('SCRIPTS')

@stop
