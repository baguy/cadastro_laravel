<!-- Deficiências tabela -->
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
        <th class='col-10' style='font-size:20px;'><i class='fas fa-wheelchair'></i> {{trans('individuos.lbl.deficiencia')}}</th>
        <th class='col-2'></th>
      </tr>
    </thead>

    <tbody>

    @foreach( $individuo->deficiencias as $key => $deficiencia )
      <?php $id = mt_rand() ?>
      <tr>
        <td>
          <button
            class="btn btn-primary btn-toggle"
            type="button"
            data-toggle="collapse"
            data-target="#collapseAt_{{ $id }}"
            aria-expanded="false"
            aria-controls="collapseAt_{{ $id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>

            @if($deficiencia->auditiva_id)
              <td class="align-middle">
                <span class="ellipsis">{{ $deficiencia->tipoDeficienciaAuditiva->nome }}</span>
              </td>
              <td class="align-middle">
                <span class="ellipsis">{{trans('individuos.lbl.auditiva')}}</span>
              </td>
            @endif
            @if($deficiencia->fisica_id)
              <td class="align-middle">
                <span class="ellipsis">{{ $deficiencia->tipoDeficienciaFisica->nome }}</span>
              </td>
              <td class="align-middle">
                <span class="ellipsis">{{trans('individuos.lbl.fisica')}}</span>
              </td>
            @endif
            @if($deficiencia->mental_id)
              <td class="align-middle">
                <span class="ellipsis">{{ $deficiencia->tipoDeficienciaMental->nome }}</span>
              </td>
              <td class="align-middle">
                <span class="ellipsis">{{trans('individuos.lbl.mental')}}</span>
              </td>
            @endif
            @if($deficiencia->psicossocial_id)
              <td class="align-middle">
                <span class="ellipsis">{{ $deficiencia->tipoDeficienciaPsicossocial->nome }}</span>
              </td>
              <td class="align-middle">
                <span class="ellipsis">{{trans('individuos.lbl.psicossocial')}}</span>
              </td>
            @endif
            @if($deficiencia->visual_id)
              <td class="align-middle">
                <span class="ellipsis">{{ $deficiencia->tipoDeficienciaVisual->nome }}</span>
              </td>
              <td class="align-middle">
                <span class="ellipsis">{{trans('individuos.lbl.visual')}}</span>
              </td>
            @endif

     </tr>
     <tr>
       <td class="description">
         <div class="collapse" id="collapseAt_{{ $id }}">
           <div>

             {{-- Informações dentro do botão collapse --}}
           @if(isset($deficiencia->data_laudo))
             <p><b>{{trans('individuos.lbl.data_laudo')}} </b>{{ $deficiencia->data_laudo }}</p>
           @endif
           @if(isset($deficiencia->causa_id))
             <p><b>{{trans('individuos.lbl.causa_deficiencia')}} </b>{{ $deficiencia->causaDeficiencia->nome }}</p>
           @endif
           @if(isset($deficiencia->quando_id))
             <p><b>{{trans('individuos.lbl.quando_deficiencia')}} </b>{{ $deficiencia->quandoDeficiencia->nome }}</p>
           @endif
           @if(isset($deficiencia->outro))
             <p><b>{{trans('individuos.lbl.outro')}} </b>{{ $deficiencia->outro }}</p>
           @endif

           </div>
         </div>
       </td>
     </tr>
    @endforeach

  </tbody>
</table>
