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
        <th>{{ trans('funcionario.lbl.nome') }}</th>
        <th>{{ trans('funcionario.lbl.setor') }}</th>
        {{-- Status — ativo/inativo --}}
        <th class="d-none d-sm-table-cell">{{ trans('application.lbl.status') }}</th>
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $funcionario)
      <tr class="{{ $funcionario->trashed() ? 'table-danger' : 'table-light' }}">
        <td class="text-center align-middle">
          <button
            class="btn btn-primary btn-toggle"
            type="button"
            data-toggle="collapse"
            data-target="#collapsefuncionario_{{ $funcionario->id }}"
            aria-expanded="false"
            aria-controls="collapsefuncionario_{{ $funcionario->id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ $funcionario->nome }}</span>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ str_limit(ucwords(mb_strtolower($funcionario->setorFormatado(), 'UTF-8')), $limit = 20, $end = '...') }}</span>
        </td>

        <td class="d-none d-sm-table-cell align-middle px-2 text-uppercase" style="width: 95px;">
          {{-- Ícone de "ativo" em STATUS, que é mudado caso o usuário esteja inativo --}}
          <span class="badge {{ ($funcionario->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill d-block">
            {{
              ($funcionario->trashed()) ?
                (($funcionario->suspended) ?
                  trans('funcionario.lbl.suspended') :
                  trans('application.lbl.inactive')) :
              trans('application.lbl.active')
            }}
          </span>
        </td>

        <td class="align-middle col-options">
          @if(Auth::user()->hasRole('ADMIN'))
            @if($funcionario->trashed())
              <a
                class="btn btn-warning"
                href="#modalRestore_{{ $funcionario->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-danger {{ ($funcionario->trashed()) ? 'disabled' : '' }}"
                href="#modalDelete_{{ $funcionario->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif
          <a
            href="{{ URL::to('funcionario/'.$funcionario->id.'/edit') }}"
            class="btn btn-info {{ ($funcionario->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('funcionario/'.$funcionario->id) }}"
            class="btn btn-default"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
            <i class="fas fa-search fa-fw"></i>
          </a>
        </td>
      </tr>

      <tr>
        <td class="description">
          <div class="collapse" id="collapsefuncionario_{{ $funcionario->id }}">
            <div class="p-3">

              {{-- <blockquote class="blockquote">
                <p class="mb-0">Contato Munícipe</p>
                <footer class="blockquote-footer">{{ $funcionario->individuo->telefonesFormatados() }}</footer>
              </blockquote> --}}

              <blockquote class="blockquote">
                <p class="mb-0">Data de Criação no Sistema</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($funcionario->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($funcionario->updated_at) > 0)
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.updated-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($funcionario->updated_at) }}
                </footer>
              </blockquote>
              @endif

              @if($funcionario->deleted_at)
              <blockquote class="blockquote">
                <p class="mb-0">
                  {{ trans('application.lbl.deleted-at') }}
                </p>
                <footer class="blockquote-footer text-danger">
                  {{ FormatterHelper::dateTimeToPtBR($funcionario->deleted_at) }}
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

@foreach ($elements as $data['funcionario'])

  @include('funcionario/_modal-delete')

  @include('funcionario/_modal-restore')

@endforeach

@else

<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
