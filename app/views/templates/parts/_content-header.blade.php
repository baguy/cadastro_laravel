<section class="content-header">

  <div class="form-group" style='margin-top: 10px; margin-left: 180px'>
    {{-- <img src= "{{ asset('assets/img/sepedi_cabecalho_prancheta1.png') }}" alt="SEPEDI-header" height="100" width="650"> --}}
    <h4 style='font-weight:lighter;'>{{ trans('application.config.nicknameUP') }}<h4>
  </div>

  <div class="container-fluid">
    <div class="row mb-1">
      <div class="col-sm-6">
        <h1>@yield('PAGE_TITLE')</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right mt-1">
          <li class="breadcrumb-item"><a href="{{ route('users.show', [Auth::user()->id]) }}">{{ trans('application.lbl.home') }}</a></li>
          <li class="breadcrumb-item active">@yield('PAGE_TITLE')</li>
        </ol>
      </div>
    </div>
  </div>
</section>
