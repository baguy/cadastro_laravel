<!-- Vida diária -->
@if( isset($individuo->vidaDiaria[0]) )
  <h5 style='padding-left: 64px;'><i class="fas fa-sun"></i><b> {{ trans('individuos.lbl.vida_diaria') }}</b></h5>

  <table class="table table-hover table-sm">
    <tbody>
    @foreach( $individuo->vidaDiaria as $key => $vida )
      <tr>
          <td class="align-left">
            <span class="ellipsis">{{ $vida->tipoVidaDiariaAssunto->nome }}</span>
          </td>
          <td class="align-right">
            <span class="ellipsis">{{ $vida->tipoVidaDiaria->nome }}</span>
          </td>
     </tr>
   @endforeach
  </tbody>
  </table>

<hr>
@endif

<!-- Estudo/escolaridade -->
@if( $individuo->escolaridade != '' )
  <h5 style='padding-left: 64px;'><i class='fas fa-user-graduate'></i><b> {{ trans('individuos.lbl.estudo') }}</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->escolaridade->status == 1 )
          <i class="fas fa-check"></i><b> {{ trans('individuos.lbl.status_ensino') }}</b>
        @endif
        @if( $individuo->escolaridade->alfabetizado == 1 )
          <i style='padding-left: 10px;' class="fas fa-check"></i><b style='padding-right: 10px;'> {{ trans('individuos.lbl.alfabetizado') }}</b>
        @else
          <p>Não alfabetizado</p>
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->escolaridade->tipo_transporte_id != '' )
          <b>{{ trans('individuos.lbl.transporte_escola') }}</b> {{ $individuo->escolaridade->transporte->nome }}
        @endif
      </div>
    </div>
  </p>
  @if( $individuo->escolaridade->instituicao != '' )
    <p><b>{{ trans('individuos.lbl.instituicao_ensino') }}</b> {{ $individuo->escolaridade->instituicao }}</p>
  @endif
  @if( $individuo->escolaridade->tipo_escolaridade_id != '' )
    <p><b>{{ trans('individuos.lbl.escolaridade') }}</b> {{ ucwords(mb_strtolower($individuo->escolaridade->tipoEscolaridade->nome, 'UTF-8')) }}</p>
  @endif

  <hr>
@endif

<!-- Trabalho -->
@if( $individuo->trabalho != '' )
  <h5 style='padding-left: 64px;'><i class="fas fa-business-time"></i><b> {{trans('individuos.lbl.trabalho')}}</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->trabalho->tipo_trabalho_id != '' )
          <b>{{trans('individuos.lbl.status_trabalho')}}</b> {{ $individuo->trabalho->tipoTrabalho->nome }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->trabalho->tipo_transporte_id != '' )
          <b style='padding-left: 10px;'>{{trans('individuos.lbl.transporte_trabalho')}}</b> {{ $individuo->trabalho->transporte->nome }}
        @endif
      </div>
    </div>
  </p>
  @if( $individuo->trabalho->profissao != '' )
    <p><b>{{trans('individuos.lbl.profissao')}}</b> {{ ucwords(mb_strtolower($individuo->trabalho->profissao, 'UTF-8')) }}</p>
  @endif
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->trabalho->local != '' )
          <b>{{trans('individuos.lbl.local_trabalho')}}</b> {{ $individuo->trabalho->local }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->trabalho->periodo != '' )
          <b style='padding-left: 10px;'>{{trans('individuos.lbl.periodo_trabalho')}}</b> {{ $individuo->trabalho->periodo }}
        @endif
      </div>
    </div>
  </p>

<hr>
@endif

<!-- Grupos Sociais -->
@if( isset($individuo->grupoSociais[0]) )
  <h5 style='padding-left: 64px;'><i class="far fa-handshake"></i><b> {{ trans('individuos.lbl.grupos_sociais') }}</b></h5>
    @foreach( $individuo->grupoSociais as $key => $grupo )
      {{ $grupo->tipoGrupoSocial->nome }}
      @if( (count($individuo->grupoSociais) > 1) && isset($individuo->grupoSociais[$key+1]) )
        ,
      @endif
      @if( isset($grupo->outro) )
        <p><b>{{ trans('individuos.lbl.outro') }}</b> {{ $grupo->outro }}</p>
      @endif
    @endforeach

  <hr>
@endif

<!-- Atividades: Esporte -->
@if( $individuo->esporte != '' )
  <h5 style='padding-left: 64px;'><i class="fas fa-basketball-ball"></i><b> Esporte</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->esporte->tipo_atividade_id != '' )
          <b>{{trans('individuos.lbl.esporte')}}</b> {{ $individuo->esporte->tipoAtividade->nome }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->esporte->tipo_transporte_id != '' )
          <b style='padding-left: 10px;'>{{ trans('individuos.lbl.transporte_esporte') }}</b> {{ $individuo->esporte->transporte->nome }}
        @endif
      </div>
    </div>
  </p>
  @if( $individuo->esporte->obs != '' )
    <p><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->esporte->obs }}</p>
  @endif

  <hr>
@endif

<!-- Atividades: Cultural -->
@if( $individuo->cultural != '' )
  <h5 style='padding-left: 64px;'><i class="fas fa-theater-masks"></i><b> Cultura</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->cultural->tipo_atividade_id != '' )
          <b>{{trans('individuos.lbl.cultural')}}</b> {{ $individuo->esporte->tipoAtividade->nome }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->cultural->tipo_transporte_id != '' )
          <b style='padding-left: 10px;'>{{ trans('individuos.lbl.transporte_cultural') }}</b> {{ $individuo->esporte->transporte->nome }}
        @endif
      </div>
    </div>
  </p>
  @if( $individuo->cultural->obs != '' )
    <p><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->cultural->obs }}</p>
  @endif

  <hr>
@endif

<!-- Moradia -->
@if( $individuo->moradia != '' )
  <h5 style='padding-left: 64px;'><i class="fas fa-home"></i><b> {{trans('individuos.lbl.moradia')}}</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->moradia->tipo_moradia_id != '' )
          <b>{{trans('individuos.lbl.tipo_moradia')}}</b> {{ $individuo->moradia->tipoMoradia->nome }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->moradia->tipo_imovel_id != '' )
          <b style='padding-left: 10px;'>{{ trans('individuos.lbl.tipo_imovel') }}</b> {{ $individuo->moradia->tipoImovel->nome }}
        @endif
      </div>
    </div>
  </p>
  @if( $individuo->moradia->outro != '' )
    <p><b>{{ trans('individuos.lbl.outro') }}</b> {{ $individuo->moradia->outro }}</p>
  @endif

  <hr>
@endif

<!-- Renda -->
@if( $individuo->renda != '' )
  <h5 style='padding-left: 64px;'><i class="fas fa-coins"></i><b> {{trans('individuos.lbl.renda')}}</b></h5>
  <p>
    <div class='row'>
      <div class='col-6'>
        @if( $individuo->renda->tipo_renda_id != '' )
          <b>{{trans('individuos.lbl.renda_pessoal')}}</b> {{ $individuo->renda->tipoRenda->nome }}
        @endif
      </div>
      <div class='col-6'>
        @if( $individuo->renda->numero != '' )
          <b style='padding-left: 10px;'>{{ trans('individuos.lbl.renda_familiar') }}</b> {{ FormatterHelper::formatarDinheiro( $individuo->renda->numero ) }}
        @endif
      </div>
    </div>
  </p>

  <hr>
@endif

<!-- Benefícios -->
@if( isset($individuo->beneficios[0]) )
  <h5 style='padding-left: 64px;'><i class="fas fa-gifts"></i><b> {{trans('individuos.lbl.beneficio')}}</b></h5>
  <p>
    @foreach( $individuo->beneficios as $key => $value )
      {{ ucwords(mb_strtolower($value->tipoBeneficio->nome, 'UTF-8')) }}
      @if( (count($individuo->beneficios) > 1) && isset($individuo->beneficios[$key+1]) )
        ,
      @endif
    @endforeach
  </p>
  @if( $individuo->beneficios[0]->outro != '' )
    <p><b>{{ trans('individuos.lbl.outro') }}</b> {{ $individuo->beneficios[0]->outro }}</p>
  @endif
  @if( $individuo->beneficios[0]->obs != '' )
    <p><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->beneficios[0]->obs }}</p>
  @endif

  <hr>
@endif

<!-- Credenciais -->
@if( isset($individuo->credenciais[0]) )
  <h5 style='padding-left: 64px;'><i class="fas fa-id-badge"></i><b> {{trans('individuos.lbl.credencial')}}</b></h5>
  <table class="table table-hover table-sm">
    <tbody>
      @foreach( $individuo->credenciais as $key => $value )
        <tr>
          <td class="align-left">
            <span class='ellipsis'>{{ $value->tipoCredencial->nome }}</span>
          </td>
          <td class="align-right">
            <span class='ellipsis'>{{ $value->credencial }}</span>
        </td>
      </tr>
    @endforeach
  </tbody>
  </table>

  <hr>
@endif
