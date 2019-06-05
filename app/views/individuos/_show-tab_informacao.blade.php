<!-- Informação -->
@if( $individuo->informacao != '' )

  <h5 style='padding-left: 64px;'><i class="fas fa-comment"></i><b> Informação</b></h5>

  @if( $individuo->informacao->tipoInformacao != '' )
    <p><b>{{trans('individuos.lbl.tipo_informacao')}} </b> {{ $individuo->informacao->tipoInformacao->nome }}</p>
  @endif
  @if( $individuo->informacao->tipoInformacaoOrigem != '' )
    <p><b>{{trans('individuos.lbl.origem_informacao')}} </b> {{ $individuo->informacao->tipoInformacaoOrigem->nome }}</p>
  @endif
  @if( $individuo->informacao->obs != '' )
    <p><b>{{trans('individuos.lbl.obs')}} </b> {{ $individuo->informacao->obs }}</p>
  @endif

  <hr>
@endif

<!-- Sugestão -->
@if( $individuo->sugestao != '' )

  <h5 style='padding-left: 64px;'><i class="fas fa-quote-left"></i><b> Sugestão </b><i class="fas fa-quote-right"></i></h5>

  <p>{{ $individuo->sugestao->sugestao }}</p>

@endif
