<!-- Parecer Técnico -->
<div class='row'>
  <div>
    @if( isset($individuo->deficiencias[0]) )
      <p style='padding-right:100px;'><i style='padding-left: 10px;' class="fas fa-check"></i> {{ trans('individuos.lbl.c_def') }}</p>
    @endif
  </div>
  <div>
    @if( isset($individuo->mobilidades[0]) )
      <p style='padding-right:100px;'><i style='padding-left: 10px;' class="fas fa-check"></i> {{ trans('individuos.lbl.m_prej') }}</p>
    @endif
  </div>
  <div>
    @if( isset($individuo->data_nascimento) )
      <?php $idade = MainHelper::calculaIdade(FormatterHelper::dateToMySQL($individuo->data_nascimento)) ?>
      @if( $idade > 60 )
        <p><i style='padding-left: 10px;' class="fas fa-check"></i> {{ trans('individuos.lbl.idosa') }}</p>
      @endif
    @endif
  </div>
</div>


@if( $individuo->parecerTecnico[0] != '' )

  <h5 style='padding-left: 64px;'><i class="fas fa-stamp"></i><b> {{trans('individuos.tab.parecer') }}</b></h5>

  @foreach($individuo->parecerTecnico as $key => $parecer)

    @if( $parecer != '' )
      <p><b>{{trans('individuos.lbl.parecer')}} {{ $key+1 }}</b></p>
      <p> {{ $parecer->parecer }}</p>
    @endif

      <div class='form-row'>
        @if( $parecer->acompanhante == 1 )
          <p><i style='padding-left: 10px;' class="fas fa-check"></i> {{ trans('individuos.lbl.acompanhante') }}</p>
        @else
          <p><i style='padding-left: 10px;' class="fas fa-times"></i> {{trans('individuos.lbl.n_acompanhante') }} </p>
        @endif

        @if( $parecer->comportamento_funcional == 1 )
          <p><i style='padding-left: 10px;' class="fas fa-check"></i> {{ trans('individuos.lbl.comportamento_funcional') }}</p>
        @else
          <p><i style='padding-left: 10px;' class="fas fa-times"></i> {{ trans('individuos.lbl.comportamento_funcional') }} </p>
        @endif
      </div>

      @if( $parecer->user_id != '' )
        <div class='form-row'>
          <div class='col-4'>
            <small> <b>{{ trans('individuos.lbl.tecnico') }} </b> {{ $parecer->user->name }}</small>
          </div>
          <div class='col-4'>
            @if( isset($parecer->user->funcionario) )
              <small> <b>{{ trans('funcionario.lbl.matricula') }}</b> {{ $parecer->user->funcionario->matricula }} </small>
            @endif
          </div>
          <div class='col-4'>
            <small> <b>{{ trans('individuos.lbl.data_parecer') }}</b> {{ FormatterHelper::dateTimeToPtBR($parecer->created_at) }} </small>
          </div>
        </div>
      @endif
<hr>
    @endforeach

@else

  <p>{{ trans('individuos.lbl.n_parecer') }}</p>

@endif



<div class='card-footer text-right'>
  <div class="form-row float-right">
    <!-- Botão Parecer -->
    <div>
      <a
        href="{{ URL::to('individuos/'.$individuo->id.'/parecer') }}"
        class="btn btn-light btn-sm text-secondary {{ ($individuo->trashed()) ? 'disabled' : '' }}"
        data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.parecer') }}">
        <i class="fas fa-stamp fa-fw"></i>
      </a>
    </div>
  </div>
</div>

<script>
  function printPage() {
      window.print();
    }
</script>
