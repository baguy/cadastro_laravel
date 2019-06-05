@extends('templates.application')

@section('PAGE_TITLE')
 {{ trans('application.lbl.manual') }}
@stop

@section('CSS')
  <link rel="stylesheet" href="{{ asset('assets/css/_atendimento.css') }}">
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">

  </div><!-- .Card-header -->

  <div class="card-body">

    @include('manual/_faq')

  <div class="card-footer">

  </div><!-- .Card.footer -->
</div><!-- .Card-body -->

@section('SCRIPTS')
@stop

@stop
