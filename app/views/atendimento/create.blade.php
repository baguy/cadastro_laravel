@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('atendimento.page.title.create') }}
@stop

@section('CSS')
  <link href='{{ asset('assets/plugins/mapbox/mapbox.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster.css') }}' rel='stylesheet' />
  <link href='{{ asset('assets/plugins/mapbox/markercluster-default.css') }}' rel='stylesheet' />
@stop

@section('MAIN')

{{-- <div>
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#individuo">
      <h5 style="margin-top:5px;margin-left:5px;"><i class="fas fa-chevron-down"></i> Cadastrar Novo Indivíduo</h5></button>
    </div>

    <div id="individuo" class="collapse">

      @include('individuos._form')

    </div>
  </div>
</div> --}}

  @include('atendimento/_form')

@stop

@section('SCRIPTS')

  <script src="{{ asset('assets/js/autosize_textarea.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento_validation.js') }}"></script>
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>
  {{-- <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script> --}}
  {{-- MAPA --}}
  <script src="{{ asset('assets/plugins/mapbox/mapbox.js') }}"></script>
  <script src="{{ asset('assets/plugins/mapbox/markercluster.js') }}"></script>
  <script src="{{ asset('assets/js/mapbox.js') }}"></script>
  {{-- Preencher endereço após inserir CEP --}}
  <script src="{{ asset('assets/js/cep_automatico.js') }}"></script>
  {{-- Listagem de cidades dependendo do ESTADO selecionado --}}
  <script src="{{ asset('assets/js/estado_cidade.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script src="{{ asset('assets/js/individuos.js') }}"></script>
  <script src="{{ asset('assets/js/main-mask-valida.js') }}"></script>
  <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script>

  <script type="text/javascript">
    autosize($('textarea'));
  </script>

@stop
