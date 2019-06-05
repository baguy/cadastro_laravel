@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('funcionario.page.title.show') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-4">

      {{-- Card superior --}}
      <div class="card card-primary card-outline" style="color: #02302b;">

        <div class="card-body box-profile">

          {{-- Nome --}}
          <h3 class="profile-username text-center">{{ $funcionario->nome }}</h3>

          {{-- Data de criação --}}
          <ul class="list-group list-group-unbordered mb-3">

            <li class="list-group-item">
              <b>{{ trans('application.lbl.created-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($funcionario->created_at) }}</a>
            </li>
            {{-- Última atualização --}}
            @if(strtotime($funcionario->updated_at) > 0)
            <li class="list-group-item">
              <b>{{ trans('application.lbl.updated-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($funcionario->updated_at) }}</a>
            </li>
            @endif

          {{-- Data de exclusão --}}
            @if($funcionario->deleted_at)
              <b>{{ trans('application.lbl.deleted-at') }}</b>
              <a class="float-right">{{ FormatterHelper::dateTimeToPtBR($funcionario->deleted_at) }}</a>
            </li>
            @endif

            {{-- Setor(es) --}}
            <li class="list-group-item">
              <b>{{ trans('funcionario.lbl.setor') }}</b>
              @foreach($funcionario->setor as $set => $setor)
                <a class="float-right text-secondary">{{ ($setor->nome) }} </a>
                @if(isset($funcionario->setor[$set+1]))
                  ,
                @endif
              @endforeach
            </li>

          </ul>

        </div>

        <div class="card-footer text-right">
          {{-- Restaurar / deletar --}}
            @if($funcionario->trashed())
              <a
                href="#modalRestore_{{ $funcionario->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a
                href="#modalDelete_{{ $funcionario->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
            {{-- Editar --}}
          <a
            href="{{ URL::to('funcionario/'.$funcionario->id.'/edit') }}"
            class="btn btn-light text-info {{ ($funcionario->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>

        </div>

      </div>
      <!-- /.Fim Card -->

      <!-- Sobre -->
      <div class="card card-primary">

        <div class="card-header" style="background-color: #02302b;">
          <h3 class="card-title">{{ trans('application.lbl.about') }}</h3>
        </div>

        <div class="card-body">

          {{-- Matrícula --}}
          <strong><i class="fas fa-id-card mr-1"></i> {{ trans('funcionario.lbl.matricula') }}</strong>

          @if(isset($data['funcionario']->matricula))
            <p class="text-muted">{{ $funcionario->matricula }}</p>
          @else
            <p> Não informado </p>
          @endif

          <hr>

          {{-- Email --}}
          <strong><i class="fas fa-at mr-1"></i> {{ trans('funcionario.lbl.email') }}</strong>

          @if(isset($funcionario->email))
            <p class="text-muted">{{ $funcionario->email }}</p>
          @else
            <p> Não informado </p>
          @endif

          <hr>


          {{-- Status do indivíduo --}}
          <strong class="d-block"><i class="fas fa-toggle-on mr-1"></i> {{ trans('application.lbl.status') }}</strong>

          <span class="badge {{ ($funcionario->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
            {{ ($funcionario->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </span>

          <hr>

        </div>

      </div>
      <!-- /.Sobre -->

    </div>

    <div class="col-md-8">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active" href="#activity" data-toggle="tab">
                {{ trans('funcionario.tab.info-adicional') }}
              </a>
            </li>
          </ul>
        </div>


        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content">

            <!-- Tab Pane -->
            <div class="active tab-pane" id="activity">


            </div>
            <!-- /.Tab Pane -->

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
                      <th>Data</th>
                      <th>{{ trans('application.lbl.options') }}</th>
                    </tr>
                  </thead>

                  <tbody>
                @if(isset( $atendimentos ) )
                  @if(!empty($funcionario->user->id))
                    @foreach( $atendimentos as $key => $atendimento )
                      @if( $atendimento->user_id == $funcionario->user->id )
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
                              <span class="ellipsis">{{ FormatterHelper::dateToPtBR($atendimento->created_at) }}</span>
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

                              <p><b>Assentamentos </b> {{ count($atendimento->assentamentos) }} </p>

                             </div>
                           </div>
                         </td>
                       </tr>
                     @endif
                  @endforeach
                @else
                  <p>Funcionário não cadastrado como usuário do sistema.</p>
                @endif
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

    {{-- <pre>{{ print_r($funcionario->atendimentos()->titulo); }}</pre> --}}

  </div>

  @include('funcionario/_modal-delete')

  @include('funcionario/_modal-restore')

@stop
