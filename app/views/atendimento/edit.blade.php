@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('atendimento.page.title.edit') }}
@stop

@section('CSS')
  <link href='{{ asset('assets/plugins/mapbox/mapbox.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster-default.css') }}' rel='stylesheet' />
@stop

@section('MAIN')

  @include('atendimento/_form')

@stop

@section('SCRIPTS')
  <script src="{{ asset('assets/js/autosize_textarea.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento_validation.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  <script src="{{ asset('assets/js/cep_automatico.js') }}"></script>
  <script src="{{ asset('assets/js/estado_cidade.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/mapbox.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/markercluster.js') }}"></script>
  <script src="{{ asset('assets/js/mapbox.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

  <script type="text/javascript">
    autosize($('textarea'));
  </script>
@stop
