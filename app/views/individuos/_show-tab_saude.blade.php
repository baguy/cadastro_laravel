<!-- Assistência à saúde -->
@if( isset($individuo->saudes[0]) )

  <h5 style='padding-left: 64px;'><i class='fas fa-heartbeat'></i><b> {{trans('individuos.lbl.assistencia_saude')}}</b></h5>

  @foreach( $individuo->saudes as $key => $assistencia )
    {{ $assistencia->tipoSaude->nome }}
    @if( (count($individuo->saudes) > 1) && isset($individuo->saudes[$key+1]) )
      ,
    @endif
  @endforeach
  <p><b>{{trans('individuos.lbl.transporte_saude')}}</b>
     {{ $individuo->saudes[0]->tipoTransporte->nome }}
  </p>

  <hr>
@endif



<!-- Medicação -->
@if( isset($individuo->medicacao[0]) )

  <h5 style='padding-left: 64px;'><i class='fas fa-pills'></i><b> {{trans('individuos.lbl.medicacao')}}</b></h5>

  @foreach( $individuo->medicacao as $key => $medicacao )
    <p><b>{{ ucwords(mb_strtolower($medicacao->tipoMedicacao->nome, 'UTF-8')) }}</b>
      {{ $medicacao->nome }}
    </p>
  @endforeach
  @if( $individuo->medicacao[0]->processo_farmacia_municipal == 1 )
     <p><i class="fas fa-check"></i> {{trans('individuos.lbl.processo_farmacia_municipal')}}</p>
  @endif

  <hr>
@endif

<!-- Acompanhamento médico e terapêutico -->
@if( $individuo->acompanhamento != '' )

  <h5 style='padding-left: 64px;'><i class="fas fa-stethoscope"></i><b> {{trans('individuos.lbl.acompanhamento')}}</b></h5>

  @if( $individuo->acompanhamento->medico != '' )
    <p><b>{{trans('individuos.lbl.medico')}} </b> {{ $individuo->acompanhamento->medico }}</p>
  @endif
  @if( $individuo->acompanhamento->terapeutico != '' )
    <p><b>{{trans('individuos.lbl.terapeutico')}} </b> {{ $individuo->acompanhamento->terapeutico }}</p>
  @endif
  <hr>
@endif

<!-- Mobilidade -->
@if( isset($individuo->mobilidades[0]) )

  <h5 style='padding-left: 64px;'><i class="fas fa-walking"></i><b> {{trans('individuos.lbl.prob_mobilidade')}}</b></h5>

  @foreach( $individuo->mobilidades as $key => $mobilidade )
    {{ ucwords(mb_strtolower($mobilidade->causaMobilidade->nome, 'UTF-8')) }}
    @if( (count($individuo->mobilidades) > 1) && isset($individuo->mobilidades[$key+1]) )
      ,
    @endif
  @endforeach

  <hr>
@endif

<!-- Queda -->
@if( isset($individuo->quedas[0]) )

  <h5 style='padding-left: 64px;'><i class="fas fa-running"></i><b> {{trans('individuos.lbl.queda')}}</b></h5>

  <p><b>{{trans('individuos.lbl.local_queda')}}</b> {{ $individuo->quedas[0]->local }}</p>
  <p><b>{{trans('individuos.lbl.consequencia_queda')}}</b>
    @foreach( $individuo->quedas as $key => $queda )
      {{ ucwords(mb_strtolower($queda->consequenciaQueda->nome, 'UTF-8')) }}
      @if( (count($individuo->quedas) > 1) && isset($individuo->quedas[$key+1]) )
        ,
      @endif
    @endforeach
  </p>
  <hr>
@endif

<!-- Comunicação -->
@if( isset($individuo->comunicacao[0]) )

  <h5 style='padding-left: 64px;'><i class="fas fa-comments"></i><b> {{trans('individuos.lbl.comunicação')}}</b></h5>

  @foreach( $individuo->comunicacao as $key => $comunicacao )
    {{ ucwords(mb_strtolower($comunicacao->tipoComunicacao->nome, 'UTF-8')) }}
    @if( (count($individuo->comunicacao) > 1) && isset($individuo->comunicacao[$key+1]) )
      ,
    @endif
  @endforeach
  @if( isset($individuo->comunicacao[0]->outro) && ($individuo->comunicacao[0]->outro != '') )
    <p><b>{{trans('individuos.lbl.outro')}}</b> {{ $individuo->comunicacao[0]->outro }}</p>
  @endif

  <hr>
@endif

<!-- Tecnologia assistiva -->
@if( isset($individuo->tecnologiaAssistiva[0]) )

  <h5 style='padding-left: 64px;'><i class="fas fa-keyboard"></i><b> {{trans('individuos.lbl.tecnologia')}}</b></h5>

  @foreach( $individuo->tecnologiaAssistiva as $key => $tecnologiaAssistiva )
    {{ ucwords(mb_strtolower($tecnologiaAssistiva->tipoTecnologiaAssistiva->nome, 'UTF-8')) }}
    @if( (count($individuo->tecnologiaAssistiva) > 1) && isset($individuo->tecnologiaAssistiva[$key+1]) )
      ,
    @endif
  @endforeach
  @if( $individuo->tecnologiaAssistiva[0]->prefeitura != '' )
    <p><i class="fas fa-check"></i> {{trans('individuos.lbl.prefeitura_tecnologia')}}</p>
  @endif
  @if( isset($individuo->tecnologiaAssistiva[0]->outro) && ($individuo->tecnologiaAssistiva[0]->outro != ''))
    <p><b>{{trans('individuos.lbl.outro')}}</b> {{ $individuo->tecnologiaAssistiva[0]->outro }}</p>
  @endif

  <hr>
@endif

<!-- UBS -->
@if( isset($individuo->ubsCras->cras) || isset($individuo->ubsCras->ubs) )

  <h5 style='padding-left: 64px;'><i class="fas fa-hospital"></i><b> {{trans('individuos.lbl.ubs_cras')}} </b></h5>

  @if(isset($individuo->ubsCras->cras))
    <p><b>{{trans('individuos.lbl.cras')}}</b> {{ $individuo->ubsCras->cras }}</p>
  @endif
  @if(isset($individuo->ubsCras->ubs))
    <p><b>{{trans('individuos.lbl.ubs')}}</b> {{ $individuo->ubsCras->ubs }}</p>
  @endif

@endif
