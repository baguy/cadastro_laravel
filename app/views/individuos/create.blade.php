@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.create') }}
@stop

@section('CSS')
@stop

@section('MAIN')

@include('individuos/_form')

@stop

@section('SCRIPTS')

  {{-- MÁSCARAS --}}
  <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="{{ asset('assets/js/main-mask-valida.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script type="text/javascript" src="{{asset('assets/js/validate-methods.js')}}"></script>
  {{-- Clonar divs, máscara de datas e telefones pós-clone e habilitar data_casamento --}}
  <script src="{{ asset('assets/js/individuos.js') }}"></script>
  {{-- Preencher endereço após inserir CEP --}}
  <script src="{{ asset('assets/js/cep_automatico.js') }}"></script>
  {{-- Listagem de cidades dependendo do ESTADO selecionado --}}
  <script src="{{ asset('assets/js/estado_cidade.js') }}"></script>
  {{-- Busca dinâmica de indivíduos/cpf --}}
  <script src="{{ asset('assets/js/atendimento.js') }}"></script>

@stop
