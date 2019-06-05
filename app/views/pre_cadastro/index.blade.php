@extends('templates.application_pre-cadastro')

<div style="margin-left:450px; margin-top:30px">
  <img src="https://i.ibb.co/7KcPr8k/sepedi-cabecalho-prancheta-resize2.jpg" alt="sepedi-cabecalho-prancheta-resize2" border="0">
</div>

<div style='margin-left:270px; margin-top:30px'>
  <h4>PRÉ-CADASTRO SEPEDI</h4>

  Conhecer, registrar e analisar os principais dados referente às pessoas com deficiência e aos idosos do município são ferramentas essenciais para o desenvolvimento dos serviços e planejamento das políticas públicas específicas da <b>Secretaria Municipal dos Direitos da Pessoa com Deficiência e do Idoso</b>.
  Com o cadastro é possível conhecer, atender e acompanhar demandas, identificando suas necessidades e facilitando o acesso a concessões e benefícios no município, garantindo direitos diversos.
  <br>
  Portanto, se você apresenta alguma deficiência (visual, física, auditiva, intelectual) e/ou é idoso(a) venha realizar seu cadastro!
  <br>
  Em caso de dúvidas ou auxílio procure a Secretaria Municipal dos Direitos da Pessoa com Deficiência e do Idoso por meio do: <b>0800-7747055</b> ou pelo email: <b>sepedi@caraguatatuba.sp.gov.br</b>.
</div>

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.create') }}
@stop

@section('CSS')
@stop

@section('MAIN')

@include('pre_cadastro/_form')

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
