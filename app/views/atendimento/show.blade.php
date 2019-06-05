@extends('templates.application')


@section('PAGE_TITLE')
  {{ trans('atendimento.page.title.show') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-12">

      <!-- Profile Image -->
      <div class="card card-primary">

        <div class="card-header">
          <p class="card-title col-md-10">{{ trans('atendimento.lbl.detail') }} | {{ trans('atendimento.lbl.status') }}: {{ $data['atendimento']->status->tipo }} {{ $data['atendimento']->trashed() ? " | INATIVO" : ""}}</p>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="info col-md-6">
              <h5><b>{{ trans('atendimento.lbl.titulo') }}: </b> {{ $data['atendimento']->titulo }}</h5>

              <p><b>{{ trans('atendimento.lbl.requerente') }}: </b> {{ $data['atendimento']->individuo->nome }} <b> | CPF: </b> {{ FormatterHelper::setCPF($data['atendimento']->individuo->documentos[0]->numero) }}</p>

              <p><b>{{ trans('atendimento.lbl.categoria') }}: </b> {{ ucwords(mb_strtolower($data['atendimento']->tipoAtendimentoFormatado(), 'UTF-8')) }}</p>

              <p><b>{{ trans('setor.setor') }}: </b>
                @if(isset($data['atendimento']->setor[0]))
                  {{ ucwords(mb_strtolower($data['atendimento']->setorFormatado(), 'UTF-8')) }}
                @else
                  Não informado
                @endif
                </p>

              <p>
                <b>{{ trans('individuos.lbl.endereco') }}: </b>
                @if(isset($data['atendimento']->endereco->logradouro) && ($data['atendimento']->endereco->logradouro != ''))
                  {{ ucwords(mb_strtolower($data['atendimento']->endereco->logradouro), 'UTF-8')}},
                  {{ $data['atendimento']->endereco->numero }} —
                  {{ $data['atendimento']->endereco->bairro }}
                @else
                  Não informado
                @endif
              </p>
              @if(isset($data['atendimento']->endereco->complemento))
                <p> {{ $data['atendimento']->endereco->complemento }} </p>
              @endif

            </div>

            <div class="row col-md-6" style="text-align:right;">
              <span class="col-md-12">
                <b>{{ trans('application.lbl.created-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['atendimento']->created_at) }}</a>
              </span>

              <span class="col-md-12">
                @if(strtotime($data['atendimento']->updated_at) > 0)
                <b>{{ trans('application.lbl.updated-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['atendimento']->updated_at) }}</a>
                @endif
              </span>

              @if($data['atendimento']->deleted_at)
              <span class="col-md-12">
                <b>{{ trans('application.lbl.deleted-at') }}: </b>
                <a>{{ FormatterHelper::dateTimeToPtBR($data['atendimento']->deleted_at) }}</a>
              </span>
              @endif

              <span class="col-md-12">
                <b>{{ trans('atendimento.lbl.created-by') }}: </b>
                <a>{{ $data['atendimento']->user->name }}</a>
              </span>

              @if($data['atendimento']->encerrado)
                <span class="col-md-12">
                  <b><span class="obrigatorio"> Encerrado: </span></b>
                  <a>{{ $data['atendimento']->encerrado->tipo_encerrado->nome }}</a>
                </span>
              @endif


            </div>
          </div>

          <div class="spacer"></div>

          <h5><b>{{ trans('atendimento.lbl.descricao') }}</b></h5>

          <div class="descricao">
            <textarea readonly class="form-control">{{ $data['atendimento']->descricao }}</textarea>
          </div>

        </div>

        <div class="card-footer text-right">

          @if(Auth::user()->hasRole('ADMIN'))
            @if($data['atendimento']->trashed())
              <a
                class="btn btn-light btn-sm text-warning"
                href="#modalRestore_{{ $data['atendimento']->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-light btn-sm text-danger"
                href="#modalDelete_{{ $data['atendimento']->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif

          <a
            href="{{ URL::to('atendimento/'.$data['atendimento']->id.'/edit') }}"
            class="btn btn-light btn-sm text-info {{ ($data['atendimento']->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            class="btn btn-light btn-sm text-secondary"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.print-this') }}"
            onclick="printPage()">
            <i class="fas fa-print fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('atendimento/'.$data['atendimento']->id.'/pdf') }}"
            class="btn btn-light btn-sm text-secondary {{ ($data['atendimento']->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.pdf') }}">
            <i class="fas fa-file-pdf"></i>
          </a>

        </div>

      </div>
      <!-- /.Profile Image -->

      <!-- About Me Box -->
      <div class="card card-primary">

        <div class="card-header">
          <div class="row">
            <h3 class="card-title col-md-11">{{ trans('atendimento.lbl.assentamentos') }}</h3>

            @if(!$data['atendimento']->trashed())
              <div class="col-md-1">
                {{-- <a class="btn btn-sm btn-default text-primary add-assentamento" style="border:1px solid #62c9ea">Adicionar</a> --}}
              </div>
            @endif
          </div>
        </div>

        <div class="card-body">
          {{ Form::model($data['atendimento'], array('method' => 'PATCH', 'route' => array('atendimento.update', $data['atendimento']->id))) }}

          @if(count($data['atendimento']->assentamentos) >= 1)
            @foreach($data['atendimento']->assentamentos as $key => $assentamento)

            <div class="assentamento">
              <div class="row">
                <div class='col-md-4'>
                  <strong>{{ $key+1 }}º {{ trans('atendimento.lbl.assentamento') }}</strong>
                </div>
                <div class='col-md-4'>
                    <b>{{ trans('setor.setor') }}:</b>
                    @if(isset($assentamento->setor[0]))
                      {{ ucwords(mb_strtolower( $data['atendimento']->setoresFormatados($assentamento->setor), 'UTF-8')) }}
                    @else
                      Não informado
                    @endif
                </div>

                <span class="col-md-4" style="text-align:right;">
                  <b>{{ trans('application.lbl.created-at') }}: </b>
                  {{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}
                </span>
              </div>

              <div class="assentamento input-group {{ ($errors->has('assentamento')) ? 'has-error' : '' }}">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <div style="display:flex;flex-direction:column">
                      <i class="fa fa-user-circle"></i>
                      <div style="font-size:13px;">
                        <b>{{ trans('atendimento.lbl.created-by') }}: </b>
                        <p style="margin-bottom:-5px;">{{ $assentamento->user->name }}</p>
                      </div>
                    </div>
                  </span>
                </div>

                <textarea readonly class="form-control" name="assentamento[]">{{ $assentamento->descricao }}</textarea> <hr>

              </div>
            </div>

            @endforeach
          @else
            <div class="assentamento alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>
          @endif

          {{ Form::submit('Salvar', array('class' => 'save float-right btn btn-light btn-sm text-primary', 'style' => 'display:none;margin:5px 0 5px 0;')) }}
          {{ Form::button('Cancelar', array('class' => 'cancel float-right btn btn-light btn-sm text-danger', 'style' => 'display:none;margin:5px 3px 5px 0;')) }}

          {{ Form::close() }}

        </div>

      </div>

    </div>

  </div>

  @include('atendimento/_modal-delete')

  @include('atendimento/_modal-restore')

@stop

@section('SCRIPTS')
<script src="{{ asset('assets/js/autosize_textarea.js') }}"></script>
<script src="{{ asset('assets/js/assentamento.js') }}"></script>
<script type="text/javascript">
  autosize($('textarea'));
</script>

@stop

<script>
  function printPage() {
    window.print();
  }
</script>
