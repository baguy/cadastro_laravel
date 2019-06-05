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
        <th>{{ trans('setor.lbl.nome') }}</th>
        {{-- <th>{{ trans('setor.lbl.categoria') }}</th> --}}
        {{-- <th>{{ trans('setor.lbl.individuo') }}</th> --}}
        {{-- <th>{{ trans('setor.lbl.status') }}</th> --}}
        {{-- <th>{{ trans('setor.lbl.data_criacao') }}</th> --}}
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $setor)
      <tr class="{{ $setor->trashed() ? 'table-danger' : 'table-light' }}">
        <td class="text-center align-middle">
          <button
            class="btn btn-primary btn-toggle"
            type="button"
            data-toggle="collapse"
            data-target="#collapseUser_{{ $setor->id }}"
            aria-expanded="false"
            aria-controls="collapseUser_{{ $setor->id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ $setor->nome }}</span>
        </td>


        {{-- <td class="align-middle">
          <span class="badge {{ ($setor->status_id == 1) ? 'badge-success' : ($setor->status_id == 2 ? 'badge-warning' : ($setor->status_id == 3 ? 'badge-danger' : 'badge-primary')) }} badge-pill text-uppercase">
            {{ $setor->status->tipo }}
          </span>
        </td> --}}

        {{-- <td class="align-middle">
          <span class="ellipsis">{{ $setor->data_criacao }}</span>
        </td> --}}

        <td class="align-middle col-options">
          @if(Auth::user()->hasRole('ADMIN'))
            @if($setor->trashed())
              <a
                class="btn btn-warning"
                href="#modalRestore_{{ $setor->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-danger {{ ($setor->trashed()) ? 'disabled' : '' }}"
                href="#modalDelete_{{ $setor->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif
          <a
            href="{{ URL::to('setor/'.$setor->id.'/edit') }}"
            class="btn btn-info {{ ($setor->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('setor/'.$setor->id) }}"
            class="btn btn-default"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
            <i class="fas fa-search fa-fw"></i>
          </a>
        </td>
      </tr>

      <tr>
        <td class="description">
          <div class="collapse" id="collapseUser_{{ $setor->id }}">
            <div class="p-3">

              <blockquote class="blockquote">
                <p class="mb-0">Data de Criação no Sistema</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($setor->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($setor->updated_at) > 0)
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.updated-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($setor->updated_at) }}
                </footer>
              </blockquote>
              @endif

              @if($setor->deleted_at)
              <blockquote class="blockquote">
                <p class="mb-0">
                  {{ trans('application.lbl.deleted-at') }}
                </p>
                <footer class="blockquote-footer text-danger">
                  {{ FormatterHelper::dateTimeToPtBR($setor->deleted_at) }}
                </footer>
              </blockquote>
              @endif
            </div>
          </div>
        </td>
      </tr>


      @endforeach

    </tbody>
  </table>

</div>

{{ $elements->links() }}

@foreach ($elements as $data['setor'])

  @include('setor/_modal-delete')

  @include('setor/_modal-restore')

@endforeach

@else

<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
