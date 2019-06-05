<div style="margin-left:80px">
  <img src="https://i.ibb.co/18KXc77/cabecalho-resize2.png" alt="header" border="0">
</div>

<div>

  <br>

  <p><b>{{ $individuo->nome }}</b></p>

  <p>
    <b>{{ trans('application.lbl.created-at') }}</b> {{ FormatterHelper::dateTimeToPtBR($individuo->created_at) }}
    <b>{{ trans('application.lbl.updated-at') }}</b> {{ FormatterHelper::dateTimeToPtBR($individuo->updated_at) }}
  </p>

  {{ $individuo->documentosFormatados() }}

  <p>
    @if($individuo->data_nascimento != null)
      <strong>{{ trans('individuos.lbl.data_nascimento') }}</strong>  {{ $individuo->data_nascimento }}
    @endif
    @if(isset($individuo->sexo_id))
      <strong>{{ trans('individuos.lbl.sexo_id') }}</strong> {{ $individuo->sexo->tipo }}
    @endif
    @if(isset($individuo->estadoCivil->tipoEstadoCivil->estado))
      <strong>{{ trans('individuos.lbl.tipo_estado_civil') }}</strong> {{ $individuo->estadoCivil->tipoEstadoCivil->estado }}
    @endif
<br>
    @if(!empty($individuo->email))
      <strong>{{ trans('individuos.lbl.email') }}</strong> {{ $individuo->email }}
    @endif
    <strong>{{ trans('individuos.lbl.telefone') }}</strong> {{ $individuo->telefonesFormatados() }}
<br>
    @if(isset($individuo->endereco->logradouro))
      <strong>{{ trans('individuos.lbl.endereco') }}</strong> {{ $individuo->endereco->logradouro  }}, {{ $individuo->endereco->numero  }}
    @endif
    @if(isset($individuo->endereco->bairro))
      — {{ $individuo->endereco->bairro  }}
    @endif
    @if((!isset($individuo->endereco->cep)) || $individuo->endereco->cep == 0)
      <br>
       {{ trans('individuos.lbl.n_cep') }}
    @else
      <br>
      {{ trans('individuos.lbl.cep') }} {{ FormatterHelper::setCEP($individuo->endereco->cep) }}
    @endif
    @if(isset($individuo->endereco->cidade_id))
        {{ $individuo->endereco->cidade->nome  }} /
        {{ $individuo->endereco->cidade->estado->uf }}
    @endif
  </p>

  <!-- PARECER -->
  <div class='row'>
    <div>
      @if( isset($individuo->deficiencias[0]) )
        • {{ trans('individuos.lbl.c_def') }}
      @endif
    </div>
    <div>
      @if( isset($individuo->mobilidades[0]) )
        • {{ trans('individuos.lbl.m_prej') }}
      @endif
    </div>
    <div>
      @if( isset($individuo->data_nascimento) )
        <?php $idade = MainHelper::calculaIdade(FormatterHelper::dateToMySQL($individuo->data_nascimento)) ?>
        @if( $idade > 60 )
          • {{ trans('individuos.lbl.idosa') }}
        @endif
      @endif
    </div>
  </div>

  @if( $individuo->parecerTecnico[0] != '' )
    <p><strong> {{trans('individuos.tab.parecer') }}</strong></p>
    @foreach($individuo->parecerTecnico as $key => $parecer)
      @if( $parecer != '' )
        <p><b>{{trans('individuos.lbl.parecer')}} {{ $key+1 }}</b></p>
        <p> {{ $parecer->parecer }}</p>
      @endif
        <div class='form-row'>
          @if( $parecer->acompanhante == 1 )
            • {{ trans('individuos.lbl.acompanhante') }}
          @else
            • {{trans('individuos.lbl.n_acompanhante') }}
          @endif

          @if( $parecer->comportamento_funcional == 1 )
            • {{ trans('individuos.lbl.comportamento_funcional') }}
          @else
            • {{ trans('individuos.lbl.comportamento_funcional') }}
          @endif
        </div>

        @if( $parecer->user_id != '' )
          <small> <b>{{ trans('individuos.lbl.tecnico') }} </b> {{ $parecer->user->name }}</small>
          @if( isset($parecer->user->funcionario) )
            <small> <b>{{ trans('funcionario.lbl.matricula') }}</b> {{ $parecer->user->funcionario->matricula }} </small>
          @endif
          <small> <b>{{ trans('individuos.lbl.data_parecer') }}</b> {{ FormatterHelper::dateTimeToPtBR($parecer->created_at) }} </small>
        @endif
  <hr>
      @endforeach

  @else

    <p>{{ trans('individuos.lbl.n_parecer') }}</p>

  @endif

    <!-- INFORMAÇÃO -->
    @if( $individuo->informacao != '' )
      <p><strong> {{ trans('individuos.lbl.informacao') }} </strong></p>
      @if( $individuo->informacao->tipoInformacao != '' )
        <b>{{trans('individuos.lbl.tipo_informacao')}} </b> {{ $individuo->informacao->tipoInformacao->nome }}
      @endif
      @if( $individuo->informacao->tipoInformacaoOrigem != '' )
        <b>{{trans('individuos.lbl.origem_informacao')}} </b> {{ $individuo->informacao->tipoInformacaoOrigem->nome }}
      @endif
      @if( $individuo->informacao->obs != '' )
        <p><b>{{trans('individuos.lbl.obs')}} </b> {{ $individuo->informacao->obs }}</p>
      @endif
    @endif
    <!-- SUGESTÃO -->
    <br>
    @if( $individuo->sugestao != '' )
      <b> {{trans('individuos.lbl.sugestao')}} </b> {{ $individuo->sugestao->sugestao }}
    @endif

    <!-- RESPONSÁVEL -->
    @if( isset($individuo->parentescos[0]) )
      <p><b> {{trans('individuos.lbl.parentesco_responsavel')}} </b></p>
      @foreach( $individuo->parentescos as $key => $value )
        {{ $value->nome }}
        @if($value->telefone)
          —
          {{ $value->telefone }}
        @endif
        <b>Vínculo</b> {{ $value->tipoParentesco->nome }}
      @endforeach
    @endif
    <!-- INTERDITADO -->
    @if( $individuo->interditado != '' )
      @if( $individuo->interditado->curador != '' )
        <p><b> {{trans('individuos.lbl.interditado')}}</b></p>
        <b>{{trans('individuos.lbl.curador')}} </b> {{ $individuo->interditado->curador }}
      @endif
    @endif

 <!-- DEFICIÊNCIAS -->
@if(isset($individuo->deficiencias[0]))
  <p><b> {{trans('individuos.lbl.deficiencias')}}</b></p>
 @foreach( $individuo->deficiencias as $key => $deficiencia )
   @if($deficiencia->auditiva_id)
       <p>{{ $deficiencia->tipoDeficienciaAuditiva->nome }} —
       {{trans('individuos.lbl.auditiva')}}</p>
   @endif
   @if($deficiencia->fisica_id)
     <p>{{ $deficiencia->tipoDeficienciaFisica->nome }} —
       {{trans('individuos.lbl.fisica')}}</p>
   @endif
   @if($deficiencia->mental_id)
     <p>{{ $deficiencia->tipoDeficienciaMental->nome }} —
       <span class="ellipsis">{{trans('individuos.lbl.mental')}}</p>
   @endif
   @if($deficiencia->psicossocial_id)
     <p>{{ $deficiencia->tipoDeficienciaPsicossocial->nome }} —
       {{trans('individuos.lbl.psicossocial')}}</p>
   @endif
   @if($deficiencia->visual_id)
     <p>{{ $deficiencia->tipoDeficienciaVisual->nome }} —
       {{trans('individuos.lbl.visual')}}</p>
   @endif
 @endforeach
    <br>
@endif

  <!-- SAÚDE -->
  @if( isset($individuo->saudes[0]) )
    <hr>
    <p><b> {{trans('individuos.lbl.assistencia_saude')}}</b></p>
    @foreach( $individuo->saudes as $key => $assistencia )
      {{ $assistencia->tipoSaude->nome }}
      @if( (count($individuo->saudes) > 1) && isset($individuo->saudes[$key+1]) )
        ,
      @endif
    @endforeach
    <br>
    <b>{{trans('individuos.lbl.transporte_saude')}}</b>
       {{ $individuo->saudes[0]->tipoTransporte->nome }}
  @endif
  @if( isset($individuo->medicacao[0]) )
    <p><b> {{trans('individuos.lbl.medicacao')}}</b></p>
    @foreach( $individuo->medicacao as $key => $medicacao )
      <b>{{ ucwords(mb_strtolower($medicacao->tipoMedicacao->nome, 'UTF-8')) }}</b>
        {{ $medicacao->nome }}
      </br>
    @endforeach
    @if( $individuo->medicacao[0]->processo_farmacia_municipal == 1 )
      <br>
       <i class="fas fa-check"></i>{{trans('individuos.lbl.processo_farmacia_municipal')}}
    @endif
    <br>
  @endif
  @if( $individuo->acompanhamento != '' )
    <p><b> {{trans('individuos.lbl.acompanhamento')}}</b></p>
    @if( $individuo->acompanhamento->medico != '' )
      <b>{{trans('individuos.lbl.medico')}} </b> {{ $individuo->acompanhamento->medico }}
    @endif
    @if( $individuo->acompanhamento->terapeutico != '' )
      <br>
      <b>{{trans('individuos.lbl.terapeutico')}} </b> {{ $individuo->acompanhamento->terapeutico }}
    @endif
    <br>
  @endif
  @if( isset($individuo->mobilidades[0]) )
    <p><b> {{trans('individuos.lbl.prob_mobilidade')}}</b></p>
    @foreach( $individuo->mobilidades as $key => $mobilidade )
      {{ ucwords(mb_strtolower($mobilidade->causaMobilidade->nome, 'UTF-8')) }}
      @if( (count($individuo->mobilidades) > 1) && isset($individuo->mobilidades[$key+1]) )
        ,
      @endif
    @endforeach
    <br>
  @endif
  @if( isset($individuo->quedas[0]) )
    <p><b> {{trans('individuos.lbl.queda')}}</b></p>
    <b>{{trans('individuos.lbl.local_queda')}}</b> {{ $individuo->quedas[0]->local }}
    <br>
    <b>{{trans('individuos.lbl.consequencia_queda')}}</b>
      @foreach( $individuo->quedas as $key => $queda )
        {{ ucwords(mb_strtolower($queda->consequenciaQueda->nome, 'UTF-8')) }}
        @if( (count($individuo->quedas) > 1) && isset($individuo->quedas[$key+1]) )
          ,
        @endif
      @endforeach
      <br>
  @endif
  @if( isset($individuo->comunicacao[0]) )
    <p><b> {{trans('individuos.lbl.comunicação')}}</b></p>
    @foreach( $individuo->comunicacao as $key => $comunicacao )
      {{ ucwords(mb_strtolower($comunicacao->tipoComunicacao->nome, 'UTF-8')) }}
      @if( (count($individuo->comunicacao) > 1) && isset($individuo->comunicacao[$key+1]) )
        ,
      @endif
    @endforeach
    @if( isset($individuo->comunicacao[0]->outro) && ($individuo->comunicacao[0]->outro != '') )
      <br>
      <b>{{trans('individuos.lbl.outro')}}</b> {{ $individuo->comunicacao[0]->outro }}
    @endif
    <br>
  @endif
  @if( isset($individuo->tecnologiaAssistiva[0]) )
    <p><b> {{trans('individuos.lbl.tecnologia')}}</b></p>
    @foreach( $individuo->tecnologiaAssistiva as $key => $tecnologiaAssistiva )
      {{ ucwords(mb_strtolower($tecnologiaAssistiva->tipoTecnologiaAssistiva->nome, 'UTF-8')) }}
      @if( (count($individuo->tecnologiaAssistiva) > 1) && isset($individuo->tecnologiaAssistiva[$key+1]) )
        ,
      @endif
    @endforeach
    @if( $individuo->medicacao[0]->processo_farmacia_municipal == 1 )
      <br>
       {{trans('individuos.lbl.prefeitura_tecnologia')}}
    @endif
    @if( isset($individuo->tecnologiaAssistiva[0]->outro) && ($individuo->tecnologiaAssistiva[0]->outro != ''))
      <br>
      <b>{{trans('individuos.lbl.outro')}}</b> {{ $individuo->tecnologiaAssistiva[0]->outro }}
    @endif
    <br>
  @endif
  @if( $individuo->ubsCras != '' )
    <p><b> {{trans('individuos.lbl.ubs_cras')}} </b></p>
    @if(isset($individuo->ubsCras->cras))
      <b>{{trans('individuos.lbl.cras')}}</b> {{ $individuo->ubsCras->cras }}
    @endif
    @if(isset($individuo->ubsCras->ubs))
      <br>
      <b>{{trans('individuos.lbl.ubs')}}</b> {{ $individuo->ubsCras->ubs }}
    @endif
    <br>
    <hr>
  @endif

  <!-- SITUAÇÃO -->
  @if( isset($individuo->vidaDiaria[0]) )
    <p><b> {{ trans('individuos.lbl.vida_diaria') }}</b></p>
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
    <br>
  @endif
  <!-- Estudo/escolaridade -->
  @if( $individuo->escolaridade != '' )
    <p><b> {{ trans('individuos.lbl.estudo') }}</b></p>
    @if( $individuo->escolaridade->status == 1 )
      • {{ trans('individuos.lbl.status_ensino') }}
    @endif
    @if( $individuo->escolaridade->alfabetizado == 1 )
      • {{ trans('individuos.lbl.alfabetizado') }}
    @else
      • {{ trans('individuos.lbl.n_alfabetizado') }}
    @endif
    @if( $individuo->escolaridade->tipo_transporte_id != '' )
      <b>{{ trans('individuos.lbl.transporte_escola') }}</b> {{ $individuo->escolaridade->transporte->nome }}
    @endif
    @if( $individuo->escolaridade->instituicao != '' )
      <b>{{ trans('individuos.lbl.instituicao_ensino') }}</b> {{ $individuo->escolaridade->instituicao }}
    @endif
    @if( $individuo->escolaridade->tipo_escolaridade_id != '' )
      <b>{{ trans('individuos.lbl.escolaridade') }}</b> {{ ucwords(mb_strtolower($individuo->escolaridade->tipoEscolaridade->nome, 'UTF-8')) }}
    @endif
  @endif
  <!-- Trabalho -->
  @if( $individuo->trabalho != '' )
    <p><b> {{trans('individuos.lbl.trabalho')}}</b></p>
    @if( $individuo->trabalho->tipo_trabalho_id != '' )
      <b>{{trans('individuos.lbl.status_trabalho')}}</b> {{ $individuo->trabalho->tipoTrabalho->nome }}
    @endif
    @if( $individuo->trabalho->tipo_transporte_id != '' )
      <b>{{trans('individuos.lbl.transporte_trabalho')}}</b> {{ $individuo->trabalho->transporte->nome }}
    @endif
    @if( $individuo->trabalho->profissao != '' )
      <b>{{trans('individuos.lbl.profissao')}}</b> {{ ucwords(mb_strtolower($individuo->trabalho->profissao, 'UTF-8')) }}
    @endif
    @if( $individuo->trabalho->local != '' )
      <b>{{trans('individuos.lbl.local_trabalho')}}</b> {{ $individuo->trabalho->local }}
    @endif
    @if( $individuo->trabalho->periodo != '' )
      <br>
      <b>{{trans('individuos.lbl.periodo_trabalho')}}</b> {{ $individuo->trabalho->periodo }}
    @endif
  @endif
  <!-- Grupos Sociais -->
  @if( isset($individuo->grupoSociais[0]) )
    <p><b> {{ trans('individuos.lbl.grupos_sociais') }}</b></p>
    @foreach( $individuo->grupoSociais as $key => $grupo )
      {{ $grupo->tipoGrupoSocial->nome }}
      @if( (count($individuo->grupoSociais) > 1) && isset($individuo->grupoSociais[$key+1]) )
        ,
      @endif
      @if( isset($grupo->outro) )
        <br><b>{{ trans('individuos.lbl.outro') }}</b> {{ $grupo->outro }}
      @endif
    @endforeach
  @endif
  <!-- Atividades: Esporte -->
  @if( $individuo->esporte != '' )
    @if( $individuo->esporte->tipo_atividade_id != '' )
      <b>{{trans('individuos.lbl.esporte')}}</b> {{ $individuo->esporte->tipoAtividade->nome }}
    @endif
    @if( $individuo->esporte->tipo_transporte_id != '' )
      <b style='padding-left: 10px;'>{{ trans('individuos.lbl.transporte_esporte') }}</b> {{ $individuo->esporte->transporte->nome }}
    @endif
    @if( $individuo->esporte->obs != '' )
      <br><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->esporte->obs }}
    @endif
  @endif
  <!-- Atividades: Cultural -->
  @if( $individuo->cultural != '' )
    @if( $individuo->cultural->tipo_atividade_id != '' )
      <b>{{trans('individuos.lbl.cultural')}}</b> {{ $individuo->esporte->tipoAtividade->nome }}
    @endif
    @if( $individuo->cultural->tipo_transporte_id != '' )
      <b>{{ trans('individuos.lbl.transporte_cultural') }}</b> {{ $individuo->esporte->transporte->nome }}
    @endif
    @if( $individuo->cultural->obs != '' )
      <br><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->cultural->obs }}
    @endif
  @endif
  <!-- Moradia -->
  @if( $individuo->moradia != '' )
    <p><b> {{trans('individuos.lbl.moradia')}}</b></p>
    @if( $individuo->moradia->tipo_moradia_id != '' )
      <b>{{trans('individuos.lbl.tipo_moradia')}}</b> {{ $individuo->moradia->tipoMoradia->nome }}
    @endif
    @if( $individuo->moradia->tipo_imovel_id != '' )
      <b>{{ trans('individuos.lbl.tipo_imovel') }}</b> {{ $individuo->moradia->tipoImovel->nome }}
    @endif
    @if( $individuo->moradia->outro != '' )
      <br><b>{{ trans('individuos.lbl.outro') }}</b> {{ $individuo->moradia->outro }}
    @endif
  @endif
  <!-- Renda -->
  @if( $individuo->renda != '' )
    <p><b> {{trans('individuos.lbl.renda')}}</b></p>
    @if( $individuo->renda->tipo_renda_id != '' )
      <b>{{trans('individuos.lbl.renda_pessoal')}}</b> {{ $individuo->renda->tipoRenda->nome }}
    @endif
    @if( $individuo->renda->numero != '' )
      <b style='padding-left: 10px;'>{{ trans('individuos.lbl.renda_familiar') }}</b> {{ FormatterHelper::formatarDinheiro( $individuo->renda->numero ) }}
    @endif
  @endif
  <!-- Benefícios -->
  @if( isset($individuo->beneficios[0]) )
    <p><b> {{trans('individuos.lbl.beneficio')}}</b></p>
    @foreach( $individuo->beneficios as $key => $value )
      {{ ucwords(mb_strtolower($value->tipoBeneficio->nome, 'UTF-8')) }}
      @if( (count($individuo->beneficios) > 1) && isset($individuo->beneficios[$key+1]) )
        ,
      @endif
    @endforeach
    @if( $individuo->beneficios[0]->outro != '' )
      <br><b>{{ trans('individuos.lbl.outro') }}</b> {{ $individuo->beneficios[0]->outro }}
    @endif
    @if( $individuo->beneficios[0]->obs != '' )
      <br><b>{{ trans('individuos.lbl.obs') }}</b> {{ $individuo->beneficios[0]->obs }}
    @endif
  @endif
  <!-- Credenciais -->
  @if( isset($individuo->credenciais[0]) )
    <p><b> {{trans('individuos.lbl.credencial')}}</b></p>
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
  @endif

  <!-- ATENDIMENTOS -->
  @if(isset($individuo->atendimentos[0]))
    <hr>
    <p><b> {{trans('atendimento.atendimentos')}}</b></p>
  @endif
  @foreach( $individuo->atendimentos as $key => $atendimento )
  <br>
  <b>{{ $atendimento->titulo }}</b>
  <br>
  <b>{{ trans('individuos.lbl.status') }}</b> {{ $atendimento->status->tipo }}
  <b>{{ trans('individuos.lbl.data_criacao') }}</b> {{ $atendimento->created_at }}
  <br>
  {{ $atendimento->descricao }}
  <br>
    @foreach($atendimento->assentamentos as $key => $assentamento)
     <b>{{ trans('atendimento.lbl.assentamento') }} {{ $key+1 }} | {{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}</b>
     <br>{{ $assentamento->descricao }}
    @endforeach
  @endforeach

  </div>

<footer style='position: absolute; bottom: 0;'>
  <br>
  <img src="https://i.ibb.co/BfvzDCV/rodape-resize2.png" alt="footer" border="0">
  <small>Gerado em: {{ date('d/m/Y H:i:s') }}</small>
</footer>
