<div id="modalRestore_{{ $data['setor']->id }}" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('application.modal.confirmation.title') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>{{ trans('application.modal.confirmation.text') }}</strong></p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            {{ $data['setor']->nome }}
            <span class="badge badge-dark badge-pill">{{ trans('setor.lbl.nome') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-1">
            <span class="text-secondary">{{ $data['setor']->created_at }}</span>
            <span class="badge badge-secondary badge-pill">{{ trans('setor.lbl.created') }}</span>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('application.btn.cancel') }}</button>
        {{ Form::model($data['setor'], array('method' => 'PATCH', 'route' => array('setor.restore', $data['setor']->id))) }}
          <button type="submit" class="btn btn-warning">{{ trans('application.btn.confirm') }}</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
