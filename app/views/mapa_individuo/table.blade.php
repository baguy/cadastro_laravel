{{-- Variável $elements vem de BaseController --}}
{{-- Como estabelecido no Builder, apenas usuários ativos são exibidos --}}
@if ($elements->count())

  {{-- Informação de páginas e registros superior --}}
  <div class="text-center text-secondary border-top py-3">
    {{
      trans('pagination.table.caption', [
        'total'       => $elements->getTotal(),
        'currentPage' => $elements->getCurrentPage(),
        'lastPage'    => $elements->getLastPage(),
        'perPage'     => $elements->getPerPage()
      ])
    }}
 </div>

<div class="table-responsive">

  <table class="table table-hover table-sm table-collapse">

    {{-- Informação de páginas e registros inferior --}}
    <caption class="text-center">
      {{
        trans('pagination.table.caption', [
          'total'       => $elements->getTotal(),
          'currentPage' => $elements->getCurrentPage(),
          'lastPage'    => $elements->getLastPage(),
          'perPage'     => $elements->getPerPage()
        ])
      }}
    </caption>

    {{-- TABELA — cabeçalho --}}

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
        <th>{{ trans('individuos.lbl.nome') }}</th>
        <th>{{ trans('individuos.lbl.data_nascimento') }}</th>
        <th>{{ trans('individuos.lbl.telefone') }}</th>
        <th>{{ trans('application.lbl.status') }}</th>
        <th>{{ trans('individuos.lbl.parecer') }}</th>
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
      
      </tr>
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $individuo)

        {{-- TABELA — corpo --}}

        <tr class="{{ $individuo->trashed() ? 'table-danger' : 'table-light' }}">
          <td class="text-center align-middle">
            <button
              class="btn btn-primary btn-toggle"
              type="button"
              data-toggle="collapse"
              data-target="#collapseAtendimento_{{ $individuo->id }}"
              aria-expanded="false"
              aria-controls="collapseAtendimento_{{ $individuo->id }}">
              <i class="fas fa-plus fa-fw"></i>
            </button>
          </td>

          <td class="align-middle">
            <span class="ellipsis">{{ $individuo->nome }}</span>
          </td>

          <td class="align-middle">
            <span class="ellipsis">{{ $individuo->data_nascimento }}</span>
          </td>

          <td class="align-middle">
            <span class="ellipsis">{{ $individuo->telefonesFormatados() }}</span>
          </td>

          <!-- Status -->
          <td class="align-middle">
            <span class="badge {{ ($individuo->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
              {{
                 ($individuo->trashed()) ?
                   (($individuo->suspended) ?
                     trans('individuos.lbl.suspended') :
                     trans('application.lbl.inactive')) :
                 trans('application.lbl.active')
               }}
            </span>
          </td>

          <!-- Parecer -->
          <td class="align-middle">
            <a
              href="{{ URL::to('individuos/'.$individuo->id.'/parecer') }}"
              class="btn btn-default"
              data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.parecer') }}">
              <i class="fas fa-stamp"></i>
            </a>
            @if(isset($individuo->parecerTecnico->parecer))
              <i class="fas fa-check"></i>
            @else
              <i class="fas fa-times"></i>
            @endif
          </td>

          <td class="align-middle col-options">
            <!-- Deletar / Restaurar -->
            @if(Auth::user()->hasRole('ADMIN'))
              @if($individuo->trashed())
                <a
                  class="btn btn-warning"
                  href="#modalRestore_{{ $individuo->id }}"
                  data-toggle="modal"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                  <i class="fas fa-recycle fa-fw"></i>
                </a>
              @else
                <a
                  class="btn btn-danger {{ ($individuo->trashed()) ? 'disabled' : '' }}"
                  href="#modalDelete_{{ $individuo->id }}"
                  data-toggle="modal"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                  <i class="fas fa-trash-alt fa-fw"></i>
                </a>
              @endif
            @endif
            <!-- Editar -->
            <a
              href="{{ URL::to('individuos/'.$individuo->id.'/edit') }}"
              class="btn btn-info {{ ($individuo->trashed()) ? 'disabled' : '' }}"
              data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
              <i class="fas fa-pencil-alt fa-fw"></i>
            </a>
            <!-- Visualizar -->
            <a
              href="{{ URL::to('individuos/'.$individuo->id) }}"
              class="btn btn-default"
              data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
              <i class="fas fa-search fa-fw"></i>
            </a>
          </td>
        </tr>

      <tr>
        <td class="description">
          <div class="collapse" id="collapseUser_{{ $individuo->id }}">
            <div class="p-3">

              {{-- Informações dentro do botão collapse --}}
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.created-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($individuo->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($individuo->updated_at) > 0)
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.updated-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($individuo->updated_at) }}
                </footer>
              </blockquote>
              @endif

              {{-- Informação de Data de exclusão --}}
              @if($individuo->deleted_at)
              <blockquote class="blockquote">
                <p class="mb-0">
                  {{ ($individuo->suspended) ? trans('application.lbl.suspended-at') : trans('application.lbl.deleted-at') }}
                </p>
                <footer class="blockquote-footer {{ ($individuo->suspended) ? 'text-warning' : 'text-danger' }}">
                  {{ FormatterHelper::dateTimeToPtBR($individuo->deleted_at) }}
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
      @if (isset($individuo->endereco->latitude))
        {{Form::hidden(
          "latitude",
          isset($individuo->endereco->latitude) ? $individuo->endereco->latitude : null
        )}}
        {{Form::hidden(
          "longitude",
          isset($individuo->endereco->longitude) ? $individuo->endereco->longitude : null
        )}}

        <div class="descricao" hidden>
          {{Form::text(
            "nome",
            isset($individuo->nome) ? 'Nome: '.$individuo->nome : null
          )}}

          {{Form::text(
            "endereco",
            isset($individuo->endereco->logradouro) ? 'Endereço: '.$individuo->endereco->logradouro.', '.$individuo->endereco->numero.', '.$individuo->endereco->bairro  : null
          )}}

          {{Form::text(
            "telefone",
            isset($individuo->nome) ? 'Telefone: '.$individuo->telefonesFormatados() : null
          )}}

        </div>
      @endif

      @endforeach

    </tbody>

  </table>

</div>

{{ $elements->links() }}

{{-- Criar modais de Deletar/Restaurar para cada elemento na tabela --}}
@foreach ($elements as $individuo)

    @if ($individuo->id !== Auth::user()->id)

      @include('individuos/_modal-delete')

      @include('individuos/_modal-restore')

    @endif

@endforeach

@else

  {{-- Caso tabela vazia, retorna mensagem --}}
<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
