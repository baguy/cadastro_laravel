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

    <?php
      $s_categoria = 0; $s_status = 0;
      $s_bairro = 0; $s_data_inicio = 0;  $s_setor = 0; $offset = 0;
      if(isset($_GET['S_status_id']) && $_GET['S_status_id'] != ''){
        $s_status = $_GET['S_status_id'];
      }
      if(isset($_GET['S_tipo_atendimento_id'][0]) && $_GET['S_tipo_atendimento_id'][0] != ''){
        $s_categoria = $_GET['S_tipo_atendimento_id'][0];
      }
      if(isset($_GET['S_data_inicio']) && $_GET['S_data_inicio'] != ''){
        $s_data_inicio = FormatterHelper::dateToMySQL($_GET['S_data_inicio']);
        if($s_data_inicio == '1969-12-31'){
          $s_data_inicio = 0;
        }
      }
      if(isset($_GET['S_setor'][0]) && $_GET['S_setor'][0] != ''){
        $s_setor = $_GET['S_setor'][0];
      }
      if(isset($_GET['S_bairro']) && $_GET['S_bairro'] != ''){
        $s_bairro = $_GET['S_bairro'];
      }
    ?>

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
        <th>{{ trans('atendimento.lbl.status') }}</th>
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
        @include('templates/parts/_datatable-options', array(
          'show_tools' => true,
          'show_export' => true,
          'route_export' => route('atendimento.export', [ 'type' => 'xls', 'categoria' => $s_categoria, 'status' => $s_status, 'data' => $s_data_inicio,
                                                         'setor' => $s_setor, 'bairro' => $s_bairro
                                                          ])
        ))
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $atendimento)
      <tr class="{{ $atendimento->trashed() ? 'table-danger' : 'table-light' }}">
        <td class="text-center align-middle">
          <button
            class="btn btn-primary btn-toggle"
            type="button"
            data-toggle="collapse"
            data-target="#collapseAtendimento_{{ $atendimento->id }}"
            aria-expanded="false"
            aria-controls="collapseAtendimento_{{ $atendimento->id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ $atendimento->titulo }}</span>
        </td>

        <td class="align-middle">
          <span class="ellipsis">{{ str_limit(ucwords(mb_strtolower($atendimento->tipoAtendimentoFormatado(), 'UTF-8')), $limit = 20, $end = '...') }}</span>
        </td>

        {{-- <td class="align-middle">
          <span class="ellipsis">{{ ucwords(mb_strtolower($atendimento->individuo->nome, 'UTF-8')) }}</span>
        </td> --}}

        <td class="align-middle">
          <span class="badge {{ ($atendimento->status_id == 1) ? 'badge-success' : ($atendimento->status_id == 2 ? 'badge-warning' : ($atendimento->status_id == 3 ? 'badge-danger' : 'badge-primary')) }} badge-pill text-uppercase">
            {{ $atendimento->status->tipo }}
          </span>
        </td>

        {{-- <td class="align-middle">
          <span class="ellipsis">{{ $atendimento->data_criacao }}</span>
        </td> --}}

        <td class="align-middle col-options">
          @if(Auth::user()->hasRole('ADMIN'))
            @if($atendimento->trashed())
              <a
                class="btn btn-warning"
                href="#modalRestore_{{ $atendimento->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                class="btn btn-danger {{ ($atendimento->trashed()) ? 'disabled' : '' }}"
                href="#modalDelete_{{ $atendimento->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif
          <a
            href="{{ URL::to('atendimento/'.$atendimento->id.'/edit') }}"
            class="btn btn-info {{ ($atendimento->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('atendimento/'.$atendimento->id) }}"
            class="btn btn-default"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
            <i class="fas fa-search fa-fw"></i>
          </a>
        </td>
      </tr>

      <tr>
        <td class="description">
          <div class="collapse" id="collapseAtendimento_{{ $atendimento->id }}">
            <div class="p-3">

              @if(isset($atendimento->endereco->bairro) && ($atendimento->endereco->bairro != ''))
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('individuos.lbl.bairro') }}</p>
                <footer class="blockquote-footer">
                  {{ $atendimento->endereco->bairro }}
                </footer>
              </blockquote>
              @endif

              <blockquote class="blockquote">
                <p class="mb-0">Data de Criação no Sistema</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($atendimento->created_at) }}
                </footer>
              </blockquote>

              @if(strtotime($atendimento->updated_at) > 0)
              <blockquote class="blockquote">
                <p class="mb-0">{{ trans('application.lbl.updated-at') }}</p>
                <footer class="blockquote-footer">
                  {{ FormatterHelper::dateTimeToPtBR($atendimento->updated_at) }}
                </footer>
              </blockquote>
              @endif

              @if($atendimento->deleted_at)
              <blockquote class="blockquote">
                <p class="mb-0">
                  {{ trans('application.lbl.deleted-at') }}
                </p>
                <footer class="blockquote-footer text-danger">
                  {{ FormatterHelper::dateTimeToPtBR($atendimento->deleted_at) }}
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
      @if (isset($atendimento->endereco->latitude))
        {{Form::hidden(
          "latitude",
          isset($atendimento->endereco->latitude) ? $atendimento->endereco->latitude : null
        )}}
        {{Form::hidden(
          "longitude",
          isset($atendimento->endereco->longitude) ? $atendimento->endereco->longitude : null
        )}}

        <div class="descricao" hidden>
          {{Form::text(
            "nome",
            isset($atendimento->titulo) ? $atendimento->titulo : null
          )}}

          {{Form::text(
            "endereco",
            isset($atendimento->endereco->logradouro) ? $atendimento->endereco->logradouro.', '.$atendimento->endereco->numero.' — '.$atendimento->endereco->bairro  : null
          )}}

          {{Form::text(
            "telefone",
            isset($atendimento->status) ? $atendimento->status->tipo : null
          )}}
        </div>
      @endif


      @endforeach

    </tbody>
  </table>

</div>

{{ $elements->links() }}

@foreach ($elements as $data['atendimento'])

  @include('atendimento/_modal-delete')

  @include('atendimento/_modal-restore')

@endforeach

@else

<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
