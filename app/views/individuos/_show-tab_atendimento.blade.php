<!-- Atendimentos tabela -->
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
      <th>{{ trans('individuos.lbl.data_criacao') }}</th>
      <th>{{ trans('application.lbl.options') }}</th>
    </tr>
  </thead>

  <tbody>
  @foreach( $individuo->atendimentos as $key => $atendimento )
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
           <span class="ellipsis">{{ $atendimento->status->tipo }}</span>
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

           {{-- Informações dentro do botão collapse --}}
           <p><b>{{ trans('application.lbl.descricao') }}</b></p>
           <p>{{ $atendimento->descricao }}</p>
           <hr>
           @foreach($atendimento->assentamentos as $key => $assentamento)
            <p><b>{{ trans('application.lbl.assentamentos') }} {{ $key+1 }} | Criado em: {{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}</b></p>
            <p>{{ $assentamento->descricao }}</p>
            <hr>
           @endforeach

         </div>
       </div>
     </td>
   </tr>
  @endforeach
</tbody>
</table>
