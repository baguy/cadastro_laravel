@if ($elements->count())

<div class="text-center text-secondary border-top py-3 aqui">
  {{
    trans('pagination.table.caption', [
      'total' => $elements->getTotal(),
      'currentPage' => $elements->getCurrentPage(),
      'lastPage' => $elements->getLastPage(),
      'perPage' => $elements->getPerPage()
    ])
  }}
</div>

<div class="table-responsive">

  <table class="table table-hover table-sm table-collapse" style="table-layout: auto; width: 100%;">

    <caption class="text-center">
      {{
        trans('pagination.table.caption', [
          'total' => $elements->getTotal(),
          'currentPage' => $elements->getCurrentPage(),
          'lastPage' => $elements->getLastPage(),
          'perPage' => $elements->getPerPage()
        ])
      }}
    </caption>

    <thead>
      <tr>
        <th class="text-center text-primary th-collapse-all" style="width:50px;">
          <i
            class="fas fa-expand fa-fw"
            data-tooltip="tooltip"
            data-placement="top"
            data-original-title="{{ trans('application.btn.expand') }}"></i>
          <i
            class="fas fa-compress fa-fw d-none"
            data-tooltip="tooltip"
            data-placement="top"
            data-original-title="{{ trans('application.btn.compress') }}"></i>
        </th>
        <th>{{ trans('atendimento.lbl.titulo') }}</th>
        <th>{{ trans('atendimento.lbl.categoria') }}</th>
        {{-- <th>{{ trans('atendimento.lbl.individuo') }}</th> --}}
        <th>{{ trans('atendimento.lbl.status') }}</th>
        {{-- <th>{{ trans('atendimento.lbl.data_criacao') }}</th> --}}
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $entrada)
      {{-- <tr class="{{ $entrada->trashed() ? 'table-danger' : 'table-light' }}"> --}}
      <tr class="{{ $entrada ? 'table-danger' : 'table-light' }}">
        <td class="text-center align-middle">
          <button
            class="btn btn-primary btn-toggle"
            type="button"
            data-toggle="collapse"
            data-target="#collapseEntrada_{{ $entrada->id }}"
            aria-expanded="false"
            aria-controls="collapseEntrada_{{ $entrada->id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ $entrada->titulo }}</span>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ str_limit(ucwords(mb_strtolower($entrada->tipoAtendimentoFormatado(), 'UTF-8')), $limit = 20, $end = '...') }}</span>
        </td>

        {{-- <td class="align-middle">
          <span class="ellipsis">{{ ucwords(mb_strtolower($atendimento->individuo->nome, 'UTF-8')) }}</span>
        </td> --}}

        <td class="align-middle">
          <span class="badge {{ ($entrada->status_id == 1) ? 'badge-success' : ($entrada->status_id == 2 ? 'badge-warning' : ($entrada->status_id == 3 ? 'badge-danger' : 'badge-primary')) }} badge-pill text-uppercase">
            {{ $entrada->status->tipo }}
          </span>
        </td>

        {{-- <td class="align-middle">
          <span class="ellipsis">{{ $atendimento->data_criacao }}</span>
        </td> --}}

        <td class="align-middle col-options">
          @if(Auth::user()->hasRole('ADMIN'))
            @if($entrada->trashed())
              <a
                class="btn btn-warning"
                href="#modalRestore_{{ $entrada->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-danger {{ ($entrada->trashed()) ? 'disabled' : '' }}"
                href="#modalDelete_{{ $entrada->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif
          <a
            href="{{ URL::to('entrada/'.$entrada->id.'/edit') }}"
            class="btn btn-info {{ ($entrada->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('entrada/'.$entrada->id) }}"
            class="btn btn-default"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
            <i class="fas fa-search fa-fw"></i>
          </a>
        </td>
      </tr>

      <tr>
        <td class="description">
          <div class="collapse" id="collapseEntrada_{{ $entrada->id }}">
            <div class="p-3">

              {{-- <blockquote class="blockquote">
                <p class="mb-0">Contato Munícipe</p>
                <footer class="blockquote-footer">{{ $atendimento->individuo->telefonesFormatados() }}</footer>
              </blockquote> --}}

              <blockquote class="blockquote">
                <p class="mb-0">Data de Criação no Sistema</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($entrada->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($entrada->updated_at) > 0)
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.updated-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($entrada->updated_at) }}
                </footer>
              </blockquote>
              @endif

              @if($entrada->deleted_at)
              <blockquote class="blockquote">
                <p class="mb-0">
                  {{ trans('application.lbl.deleted-at') }}
                </p>
                <footer class="blockquote-footer text-danger">
                  {{ FormatterHelper::dateTimeToPtBR($entrada->deleted_at) }}
                </footer>
              </blockquote>
              @endif
            </div>
          </div>
        </td>
      </tr>


      {{-- Inputs invisíveis —
      Latitudes e Longitudes para inserir marcador no MAPA —
      Div 'descrição' inclui nome, endereço e telefone do indivíduo para criar POPUP no mapa  —
      Informações são enviadas para arquivo JS mapbox_index --}}
      @if (isset($entrada->endereco->latitude))
        {{Form::hidden(
          "latitude",
          isset($entrada->endereco->latitude) ? $entrada->endereco->latitude : null
        )}}
        {{Form::hidden(
          "longitude",
          isset($entrada->endereco->longitude) ? $entrada->endereco->longitude : null
        )}}

        <div class="descricao" hidden>
          {{Form::text(
            "titulo",
            isset($individuo->titulo) ? 'Título: '.$individuo->titulo : null
          )}}

          {{Form::text(
            "endereco",
            isset($entrada->endereco->logradouro) ? 'Endereço: '.$entrada->endereco->logradouro.', '.$entrada->endereco->numero.', '.$entrada->endereco->bairro  : null
          )}}

        </div>
      @endif


      @endforeach

    </tbody>
  </table>

</div>

{{ $elements->links() }}

@foreach ($elements as $data['entrada'])

  @include('entrada/_modal-delete')

  @include('entrada/_modal-restore')

@endforeach

@else

<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
