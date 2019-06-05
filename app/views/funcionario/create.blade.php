@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('funcionario.page.title.create') }}
@stop

@section('MAIN')
  @include('funcionario/_form')
@stop

@section('SCRIPTS')

  <script src="{{ asset('assets/js/autosize_textarea.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento_validation.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script>
  <script src="{{ asset('assets/js/main-mask-valida.js') }}"></script>
  <script src="{{ asset('assets/js/$_auth.js') }}"></script>

  <script type="text/javascript">
    autosize($('textarea'));
  </script>

@stop
