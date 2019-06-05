@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('individuos.page.title.show') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-4">

      {{-- Card superior --}}
      <div class="card card-primary card-outline">

        <div class="card-body box-profile">

          {{-- Nome --}}
          <h3 class="profile-username text-center">{{ $individuo->nome }}</h3>

          <ul class="list-group list-group-unbordered mb-3">

            {{-- Data de criação --}}
            <li class="list-group-item">
              <b>{{ trans('application.lbl.created-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($individuo->created_at) }}</a>
            </li>

            {{-- Última atualização --}}
            @if(strtotime($individuo->updated_at) > 0)
            <li class="list-group-item">
              <b>{{ trans('application.lbl.updated-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($individuo->updated_at) }}</a>
            </li>
            @endif

            {{-- Data de exclusão --}}
            @if($individuo->deleted_at)
            <li class="list-group-item">
              <b>{{ trans('application.lbl.deleted-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($individuo->deleted_at) }}</a>
            </li>
            @endif

          </ul>

        </div>

        <div class="card-footer text-right">
          {{-- Restaurar / deletar --}}
            @if($individuo->trashed())
              <a
                class="btn btn-light btn-sm"
                href="#modalRestore_{{ $individuo->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw text-warning"></i>
              </a>
            @else
              <a
                class="btn btn-light btn-sm"
                href="#modalDelete_{{ $individuo->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw text-danger"></i>
              </a>
            @endif
            {{-- Editar --}}
          <a
            href="{{ URL::to('individuos/'.$individuo->id.'/edit') }}"
            class="btn btn-light btn-sm text-info {{ ($individuo->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a
            href="{{ URL::to('individuos/'.$individuo->id.'/parecer') }}"
            class="btn btn-light btn-sm text-secondary {{ ($individuo->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.parecer') }}">
            <i class="fas fa-stamp fa-fw"></i>
          </a>
          <a
            class="btn btn-light btn-sm text-secondary"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.print-this') }}"
            onclick="printPage()">
            <i class="fas fa-print"></i>
          </a>
          <a
            href="{{ URL::to('individuos/'.$individuo->id.'/pdf') }}"
            class="btn btn-light btn-sm text-secondary {{ ($individuo->trashed()) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.pdf') }}">
            <i class="fas fa-file-pdf"></i>
          </a>

        </div>

      </div>
      <!-- /.Fim Card -->

      <!-- Sobre -->
      <div class="card card-primary">

        <div class="card-header">
          <h3 class="card-title">{{ trans('application.lbl.about') }}</h3>
        </div>

        <div class="card-body">

          {{-- Sexo --}}
          <strong><i class="fa fa-transgender mr-1"></i> {{ trans('individuos.lbl.sexo_id') }}</strong>

          @if(isset($individuo->sexo_id))
            <p class="text-muted">{{ $individuo->sexo->tipo }}</p>
          @else
            <p class="text-muted"> Não informado </p>
          @endif

          <hr>

          {{-- Estado civil --}}
          <strong><i class="fas fa-user mr-1"></i> {{ trans('individuos.lbl.tipo_estado_civil') }}</strong>

          @if(isset($individuo->estadoCivil->tipoEstadoCivil->estado))
            <p class="text-muted">{{ $individuo->estadoCivil->tipoEstadoCivil->estado }}</p>
          @else
            <p class="text-muted"> Não informado </p>
          @endif

          <hr>

          {{-- Data nascimento --}}
          <strong><i class="fas fa-birthday-cake mr-1"></i> {{ trans('individuos.lbl.data_nascimento') }}</strong>

          @if($individuo->data_nascimento != null)
            <p class="text-muted">{{ $individuo->data_nascimento }}</p>
          @else
            <p class="text-muted"> Não informado </p>
          @endif
          <hr>

          {{-- Documentos --}}
          <strong><i class="fas fa-id-card mr-1"></i> {{ trans('individuos.lbl.documentos') }}</strong>

          @foreach($individuo->documentos as $key => $value)
            @if ($value->tipo_documento_id == 1)
              <p class="text-muted">CPF {{ FormatterHelper::setCPF($value->numero) }}</p>
            @else
              <p class="text-muted"> {{ $value->getTipoDocumento($value->tipo_documento_id) }} {{ $value->numero }}</p>
            @endif
          @endforeach

          <hr>

          {{-- Email --}}
          <strong><i class="fas fa-at mr-1"></i> {{ trans('individuos.lbl.email') }}</strong>

          @if(!empty($individuo->email))
            <p class="text-muted">{{ $individuo->email }}</p>
          @else
            <p class="text-muted"> Não informado </p>
          @endif

          <hr>

          {{-- Telefone --}}
          <strong><i class="fas fa-phone mr-1"></i> {{ trans('individuos.lbl.telefone') }}</strong>

          @foreach($individuo->telefones as $key => $tel)
            <p class="text-muted"> {{ $tel->numero }}</p>
          @endforeach

          <hr>

          {{-- Endereço --}}
          <strong><i class="fas fa-home mr-1"></i> {{ trans('individuos.lbl.endereco') }}</strong>

            <p class="text-muted">
                  {{-- Logradouro e número --}}
                  @if(isset($individuo->endereco->logradouro))
                    {{ $individuo->endereco->logradouro  }},
                    {{ $individuo->endereco->numero  }}
                  @else
                    <p class="text-muted"> Logradouro não informado <p>
                  @endif

                  {{-- Bairro --}}
                  @if(isset($individuo->endereco->bairro))
                    <p class="text-muted"> {{ $individuo->endereco->bairro  }} <p>
                  @else
                    <p class="text-muted"> Bairro não informado <p>
                  @endif

                  {{-- CEP --}}
                  @if((!isset($individuo->endereco->cep)) || $individuo->endereco->cep == 0)
                     <p class="text-muted"> CEP não informado</p>
                  @else
                      <p class="text-muted"> CEP {{ FormatterHelper::setCEP($individuo->endereco->cep) }}</p>
                  @endif

                  @if(isset($individuo->endereco->complemento))
                    <p class="text-muted"> {{ $individuo->endereco->complemento  }}</p>
                  @else
                    <p class="text-muted"> Complemento não informado</p>
                  @endif

                  @if(isset($individuo->endereco->cidade_id))
                    <p class="text-muted">
                      {{ $individuo->endereco->cidade->nome  }} /
                      {{ $individuo->endereco->cidade->estado->uf }}
                    </p>
                  @else
                    <p class="text-muted">Cidade não informada</p>
                  @endif

          </p>

          <hr>

          {{-- Status do indivíduo --}}
          <strong class="d-block"><i class="fas fa-toggle-on mr-1"></i> {{ trans('application.lbl.status') }}</strong>

          <span class="badge {{ ($individuo->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
            {{ ($individuo->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </span>

        </div>

      </div>
      <!-- /.Sobre -->

    </div>

    <div class="col-md-8">

      <!-- Nav Tabs Custom -->
      <div class="card card-primary">

        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link" href="#parecer" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="Visualizar e cadastrar parecer técnico">
                {{ trans('individuos.tab.parecer') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#informacao" data-tooltip="tooltip" data-placement="top" data-toggle="tab" title="Informação do cadastro e Sugestão">
                {{ trans('individuos.tab.informacao') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#saude" data-tooltip="tooltip" data-placement="top" data-toggle="tab" title="Deficiência, Assistência, Medicação, Acompanhamento, Mobilidade, Queda, Comunicação, Tecnologia Assistiva, UBS/CRAS">
                {{ trans('individuos.tab.saude') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#situacao" data-tooltip="tooltip" data-placement="top" data-toggle="tab" title="Vida diária, Estudo, Trabalho, Grupo Social, Esporte, Cultura, Moradia, Renda, Benefício, Credencial">
                {{ trans('individuos.tab.situacao') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#responsavel" data-tooltip="tooltip" data-placement="top" data-toggle="tab" title="Parentes e Curador">
                {{ trans('individuos.tab.responsavel') }}
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#atendimento" data-tooltip="tooltip" data-placement="top" data-toggle="tab" title="Atendimentos requeridos">
                {{ trans('individuos.tab.chamado') }}
              </a>
            </li>
          </ul>

        </div>


        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content">

            <!-- Tab Pane -->
            <div class="active tab-pane" id="parecer">
              @include('individuos/_show-tab_parecer')
            </div>
            <!-- /.Tab Pane -->

            <!-- Tab Pane -->
            <div class="tab-pane" id="informacao">
              @include('individuos/_show-tab_informacao')
            </div>
            <!-- /.Tab Pane -->

            <!-- Tab Pane -->
            <div class="tab-pane" id="saude">
              @include('individuos/_show-tab_deficiencia')
              @include('individuos/_show-tab_saude')
            </div>
            <!-- /.Tab Pane -->

            <!-- Tab Pane -->
            <div class="tab-pane" id="situacao">
              @include('individuos/_show-tab_situacao')
            </div>
            <!-- /.Tab Pane -->

            <!-- Tab Pane -->
            <div class="tab-pane" id="responsavel">
              @include('individuos/_show-tab_responsavel')
            </div>
            <!-- /.Tab Pane -->

            <!-- Tab Pane -->
            <div class="tab-pane" id="atendimento">
              @include('individuos/_show-tab_atendimento')
            </div>
            <!-- /.Tab Pane -->

          </div>
          <!-- /.Tab Content -->

          {{-- <pre>{{ print_r( $individuo->deficienciaVisual->data_laudo ) }}</pre> --}}

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

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

<script>
  function printPage() {
      window.print();
    }
</script>
