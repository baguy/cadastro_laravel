@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('entrada.entrada') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-12">

      <!-- Nav Tabs Custom -->
      <div class="card card-primary">

        <div class="card-header">
          <h1 class="card-title">Bem-vind@, {{ $individuo->name }}</h1>
        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content">

            <!-- Tab Pane -->
            <div class="active tab-pane" id="chamado">

                <table class="table table-hover table-sm table-collapse">

                  <thead>
                    <tr>
                      <th class="text-primary th-collapse-all">
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
                      <th>{{ trans('individuos.lbl.titulo') }}</th>
                      <th>{{ trans('individuos.lbl.status') }}</th>
                      <th>{{ trans('setor.setor') }}</th>
                      <th>{{ trans('individuos.lbl.data_criacao') }}</th>
                      <th>{{ trans('application.lbl.options') }}</th>
                    </tr>
                  </thead>

                  <tbody>
                @if(isset( $atendimentos ) )
                  @foreach( $atendimentos as $key => $atendimento )
                    <tr>
                      <td>

                        <button
                          class="btn btn-primary btn-toggle"
                          type="button"
                          data-toggle="collapse"
                          data-target="#collapseAt_{{ $atendimento->id }}"
                          aria-expanded="false"
                          aria-controls="collapseAt_{{ $atendimento->id }}">
                          <i class="fas fa-plus fa-fw"></i>
                        </button>
                      </td>


                        <td class="align-middle">
                          <span class="ellipsis">{{ $atendimento->titulo }}</span>
                        </td>
                         <td class="align-middle">
                           <span class="badge {{ ($atendimento->status_id == 1) ? 'badge-success' : ($atendimento->status_id == 2 ? 'badge-warning' : ($atendimento->status_id == 3 ? 'badge-danger' : 'badge-primary')) }} badge-pill text-uppercase">
                             {{ $atendimento->status->tipo }}
                           </span>
                         </td>
                         <td class="align-middle">
                           <span class="ellipsis">{{  str_limit(ucwords(mb_strtolower($atendimento->setorFormatado(), 'UTF-8')), $limit = 30, $end = '...')  }}</span>
                         </td>
                        <td class="align-middle">
                          <span class="ellipsis">{{ $atendimento->created_at }}</span>
                        </td>
                        <td>
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
                       <div class="collapse" id="collapseAt_{{ $atendimento->id }}">
                         <div>

                           <!-- Informações dentro do botão collapse -->
                           <p><b>Descrição:</b></p>
                           <p>{{ $atendimento->descricao }}</p>
                           <hr>
                           @foreach($atendimento->assentamentos as $key => $assentamento)
                            <p><b>Assentamento {{ $key+1 }} | Criado em: {{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}</b></p>
                            <p>{{ $assentamento->descricao }}</p>
                            <hr>
                           @endforeach

                         </div>
                       </div>
                     </td>
                   </tr>
                @endforeach
              @else<p>Vincule-se a um setor para receber seus atendimentos específicos. Ou acesse <i class="fas fa-address-book"></i> <b>Atendimentos</b> para acessar todos os atendimentos.</p>
              @endif
                </tbody>
              </table>

            </div>
            <!-- /.Tab Pane -->

          </div>
          <!-- /.Tab Content -->

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

    {{-- @foreach($atendimentos as $key => $value)
      <p><pre>{{ $value }}</pre></p>
    @endforeach --}}

  </div>

  @section('SCRIPTS')
  <script src="{{ asset('assets/js/table.description.js') }}"></script>

  <script type="text/javascript">
    var tableDescription = new AdminTR.TableDescription();

    tableDescription.initialize();
  </script>

  @stop

  @include('individuos/_modal-delete')

  @include('individuos/_modal-restore')

@stop
