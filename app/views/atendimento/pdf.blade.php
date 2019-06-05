<div style="margin-left:80px">
  <img src="https://i.ibb.co/18KXc77/cabecalho-resize2.png" alt="header" border="0">
</div>

<div>

  <br>

  <p><b>{{ $atendimento->titulo }}</b></p>

  <p>
    <b>{{ trans('atendimento.lbl.status') }}</b> {{ $atendimento->status->tipo }}
    @if($atendimento->encerrado)
      <a>— {{ $atendimento->encerrado->tipo_encerrado->nome }}</a>
    @endif
    <b>{{ trans('atendimento.lbl.created-by') }} </b> {{ $atendimento->user->name }}
    <br>
    <b>{{ trans('application.lbl.created-at') }}</b> {{ FormatterHelper::dateTimeToPtBR($atendimento->created_at) }}
    <b>{{ trans('application.lbl.updated-at') }}</b> {{ FormatterHelper::dateTimeToPtBR($atendimento->updated_at) }}
    <br>
    <b>{{ trans('atendimento.lbl.categoria') }}: </b> {{ ucwords(mb_strtolower($atendimento->tipoAtendimentoFormatado(), 'UTF-8')) }}
    <b>{{ trans('setor.setor') }}</b>
      @if(isset($atendimento->setor[0]))
        {{ ucwords(mb_strtolower($atendimento->setorFormatado(), 'UTF-8')) }}
      @else
        Não informado
      @endif
  </p>

  <p>
    <b>{{ trans('atendimento.lbl.requerente') }}: </b> {{ $atendimento->individuo->nome }} <b> | CPF: </b> {{ FormatterHelper::setCPF($atendimento->individuo->documentos[0]->numero) }}
  </p>

  <p>
    <b>{{ trans('atendimento.lbl.descricao') }}</b>
    <br>
    {{ $atendimento->descricao }}
  </p>

  @if(isset($atendimento->assentamentos[0]))
    <hr>
    <p>
      <b>{{ trans('atendimento.lbl.assentamentos') }}</b>
    </p>
  @else
    {{ trans('application.msg.warn.no-records-found') }}
  @endif

  @if(count($atendimento->assentamentos) >= 1)
    @foreach($atendimento->assentamentos as $key => $assentamento)
      <p>
        <b>{{ $key+1 }}º </b>{{ trans('atendimento.lbl.assentamento') }}
        <b>{{ trans('setor.setor') }}:</b>
        @if(isset($assentamento->setor[0]))
          {{ ucwords(mb_strtolower( $atendimento->setoresFormatados($assentamento->setor), 'UTF-8')) }}
        @else
          Não informado
        @endif
        <b>{{ trans('application.lbl.created-at') }}: </b>
        {{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}
        <br>
        <b>{{ trans('atendimento.lbl.created-by') }}: </b>
        {{ $assentamento->user->name }}
        <br>
        <b>{{ trans('atendimento.lbl.descricao') }}</b>
        {{ $assentamento->descricao }}
      </p>
    @endforeach
  @endif


  </div>

<footer style='position: absolute; bottom: 0;'>
  <br>
  <img src="https://i.ibb.co/BfvzDCV/rodape-resize2.png" alt="footer" border="0">
  <small>Gerado em: {{ date('d/m/Y H:i:s') }}</small>
</footer>
