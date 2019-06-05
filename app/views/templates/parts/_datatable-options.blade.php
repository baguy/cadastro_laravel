<div class="input-group">
  {{
    Form::select(
      'DT_per_page',
      [
        '10'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 10]), 'UTF-8'),
        '25'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 25]), 'UTF-8'),
        '50'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 50]), 'UTF-8'),
        '100' => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 100]), 'UTF-8')
      ],
      null,
      array(
        'id'    => 'DT_per_page',
        'class' => 'custom-select custom-select-sm'
      )
    )
  }}

  @if ($show_tools)

  <div class="input-group-append">
    <button
      class="btn btn-outline-secondary btn-sm rounded-right"
      type="button"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
      data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.options') }}">
      <i class="fas fa-cog align-middle"></i>
    </button>
    <div class="dropdown-menu">

      @if ($show_export)
      <a href="{{ $route_export }}" class="dropdown-item js-export-xls">
        <i class="fas fa-table fa-fw"></i> {{ trans('application.btn.excel') }}
      </a>
      @endif
    </div>
  </div>

  @endif

</div>
