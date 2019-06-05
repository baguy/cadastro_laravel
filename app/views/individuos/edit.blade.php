@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.edit') }}
@stop

@section('CSS')
  <link href='{{ asset('assets/plugins/mapbox/mapbox.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster-default.css') }}' rel='stylesheet' />
@stop

@section('MAIN')

  @include('individuos/_form-edit')

@stop

@section('SCRIPTS')

  <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
  {{-- MÁSCARAS = C:\xampp\htdocs\call_gabinete\public\assets\js/main.js --}}
  <script src="{{ asset('assets/js/individuos.js') }}"></script>
  <script src="{{ asset('assets/js/cep_automatico.js') }}"></script>
  <script src="{{ asset('assets/js/estado_cidade.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script src="{{ asset('assets/js/main-mask-valida.js') }}"></script>
  <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script>
  <script src="{{ asset('assets/plugins/mapbox/mapbox.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/markercluster.js') }}"></script>
  <script src="{{ asset('assets/js/mapbox.js') }}"></script>

@stop
