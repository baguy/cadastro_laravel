@if (Session::has('_error') || Session::has('_status') || Session::has('_info') || Session::has('_warn'))

	@if (Session::has('_error'))
	<div class="alert alert-danger">
	  {{ Session::get('_error') }}
	</div>
	@endif

	@if (Session::has('_status'))
	<div class="alert alert-success">
	  {{ Session::get('_status') }}
	</div>
	@endif

	@if (Session::has('_info'))
	<div class="alert alert-info">
	  {{ Session::get('_info') }}
	</div>
	@endif

	@if (Session::has('_warn'))
	<div class="alert alert-warning">
	  {{ Session::get('_warn') }}
	</div>
	@endif

@endif