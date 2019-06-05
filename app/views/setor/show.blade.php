@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('setor.page.title.show') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-12">

      <!-- Profile Image -->
      <div class="card card-primary">

        <div class="card-header">
          {{-- <p class="card-title col-md-10">{{ trans('setor.lbl.detail') }} | Status: {{ $data['setor']->status->tipo }} {{ $data['setor']->trashed() ? " | INATIVO" : ""}}</p> --}}
        </div>

        <div class="card-body">
          <div class="row">
            <div class="info col-md-6">
              <h5><b>Setor: </b> {{ $data['setor']->nome }}</h5>

            </div>

            <div class="row col-md-6" style="text-align:right;">
              <span class="col-md-12">
                <b>{{ trans('application.lbl.created-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['setor']->created_at) }}</a>
              </span>

              <span class="col-md-12">
                @if(strtotime($data['setor']->updated_at) > 0)
                <b>{{ trans('application.lbl.updated-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['setor']->updated_at) }}</a>
                @endif
              </span>

              @if($data['setor']->deleted_at)
              <span class="col-md-12">
                <b>{{ trans('application.lbl.deleted-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['setor']->deleted_at) }}</a>
              </span>
              @endif

            </div>
          </div>

          <div class="spacer"></div>

        </div>

        <div class="card-footer text-right">

          @if(Auth::user()->hasRole('ADMIN'))
            @if($data['setor']->trashed())
              <a
                class="btn btn-light text-warning"
                href="#modalRestore_{{ $data['setor']->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-light text-danger"
                href="#modalDelete_{{ $data['setor']->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif

          <a
            href="{{ URL::to('setor/'.$data['setor']->id.'/edit') }}"
            class="btn btn-light text-info {{ ($data['setor']->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>

        </div>

      </div>
      <!-- /.Profile Image -->

      <!-- Funcionarios -->
      <div class="card card-primary">

        <div class="card-header">
          <div class="row">
            <h3 class="card-title col-md-11">{{ trans('setor.lbl.funcionarios') }}</h3>

            @if(!$data['setor']->trashed())
              <div class="col-md-1">
                <a class="float-right btn btn-sm btn-default text-primary" style="border:1px solid #62c9ea">{{ $contadorFuncionario }}</a>
              </div>
            @endif
          </div>
        </div>

        <div class="card-body">

          @foreach($data['setor']->funcionario as $f => $funcionario)

            <b>{{ $funcionario->nome }}</b> — {{ $funcionario->email }}

            @if(!empty($data['setor']->funcionario[$f+1]))
              &emsp; | &emsp;
            @endif

          @endforeach

        </div>
      </div>

      {{-- <div class="container">
        <div class="row">
          <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#abertoSetor"><i class="fas fa-chevron-down"></i></button>
          <h3 class='col-md-10' style="margin-top:5px;margin-left:5px;"> {{ trans('setor.lbl.atendimento-aberto') }} </h3>
          @if(!$data['setor']->trashed())
            <div class="col-md-1">
              <a class="float-right btn btn-sm btn-default text-primary" style="border:1px solid #62c9ea">{{ $contadorAtendimentoAberto }}</a>
            </div>
          @endif
        </div> --}}


        <!-- Atendimentos Abertos -->
          <div class="card card-primary">

            <div class="card-header">
              <div class="row">
                <h3 class="card-title col-md-11">
                  <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#abertoSetor" style="margin-right:10px;">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                  {{ trans('setor.lbl.atendimento-aberto') }}
                </h3>

                @if(!$data['setor']->trashed())
                  <div class="col-md-1">
                    <a class="float-right btn btn-sm btn-default text-primary" style="border:1px solid #62c9ea">{{ $contadorAtendimentoAberto }}</a>
                  </div>
                @endif

              </div>
            </div>

            <div id="abertoSetor" class="collapse">
              <div class="card-body">

                @foreach($data['setor']->atendimento->reverse() as $a => $atendimento)
                  @if($atendimento->status_id == 1)

                    <p>
                      <a
                        href="{{ URL::to('atendimento/'.$atendimento->id) }}"
                        class="btn btn-default"
                        data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
                        <i class="fas fa-search fa-fw"></i>
                      </a>

                      <b>{{ $atendimento->titulo }}</b> —
                        @foreach($atendimento->tipoAtendimento as $a => $ta)
                          <a class="float-right text-secondary">{{ ($ta->tipo) }}
                              &emsp; | &emsp; </a>
                        @endforeach
                        {{ FormatterHelper::dateTimeToPtBR($atendimento->created_at) }}

                    </p>

                  @endif
                @endforeach

            </div>
        </div>
      </div>

      <!-- Atendimentos Pendentes -->
      <div class="card card-primary">

        <div class="card-header">
          <div class="row">
            <h3 class="card-title col-md-11">{{ trans('setor.lbl.atendimento-pendente') }}</h3>

            @if(!$data['setor']->trashed())
              <div class="col-md-1">
                <a class="float-right btn btn-sm btn-default text-primary" style="border:1px solid #62c9ea">{{ $contadorAtendimentoPendente }}</a>
              </div>
            @endif

          </div>
        </div>

        <div class="card-body">

          @foreach($data['setor']->atendimento->reverse() as $a => $atendimento)
            @if($atendimento->status_id == 2)

              <p>
                <a
                  href="{{ URL::to('atendimento/'.$atendimento->id) }}"
                  class="btn btn-default"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
                  <i class="fas fa-search fa-fw"></i>
                </a>

                <b>{{ $atendimento->titulo }}</b> —
                @foreach($atendimento->tipoAtendimento as $a => $ta)
                  <a class="float-right text-secondary">{{ ($ta->tipo) }}
                      &emsp; | &emsp;
                    </a>
                @endforeach
                {{ FormatterHelper::dateTimeToPtBR($atendimento->created_at) }}
              </p>

            @endif
          @endforeach

      </div>
    </div>

    <!-- Atendimentos Encerrados -->
    <div class="card card-primary">

      <div class="card-header">
        <div class="row">
          <h3 class="card-title col-md-11">{{ trans('setor.lbl.atendimento-encerrado') }}</h3>

          @if(!$data['setor']->trashed())
            <div class="col-md-1">
              <a class="float-right btn btn-sm btn-default text-primary" style="border:1px solid #62c9ea">{{ $contadorAtendimentoEncerrado }}</a>
            </div>
          @endif

        </div>
      </div>

      <div class="card-body">

        @foreach($data['setor']->atendimento->reverse() as $a => $atendimento)
          @if($atendimento->status_id == 3)

            <p>
              <a
                href="{{ URL::to('atendimento/'.$atendimento->id) }}"
                class="btn btn-default"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
                <i class="fas fa-search fa-fw"></i>
              </a>

              <b>{{ $atendimento->titulo }}</b> —
              @foreach($atendimento->tipoAtendimento as $a => $ta)
                <a class="float-right text-secondary">{{ ($ta->tipo) }} &emsp; | &emsp; </a>
              @endforeach
              {{ FormatterHelper::dateTimeToPtBR($atendimento->created_at) }}
            </p>

          @endif
        @endforeach

    </div>
  </div>

  </div><!-- class="col-md-12" -->

  @include('setor/_modal-delete')

  @include('setor/_modal-restore')

@stop

@section('SCRIPTS')
<script src="{{ asset('assets/js/autosize_textarea.js') }}"></script>
<script src="{{ asset('assets/js/assentamento.js') }}"></script>
<script type="text/javascript">
  autosize($('textarea'));
</script>

@stop
