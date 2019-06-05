@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('application.error.500.title') }}
@stop

@section('MAIN')

<div class="error-page">

  <h2 class="headline text-danger">500</h2>

  <div class="error-content">

    <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! {{ trans('application.error.500.msg') }}.</h3>

    <p>
      {{ trans('application.msg.error.something-went-wrong') }}
    </p>
    <p>
      <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> {{ trans('application.lbl.home-page') }}</a>
    </p>
  </div>

</div>

@stop