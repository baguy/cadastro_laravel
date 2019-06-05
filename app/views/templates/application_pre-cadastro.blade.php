<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('application.config.name') }} {{ trans('application.config.nickname') }} - @yield('PAGE_TITLE')</title>

    {{-- Ícone tab --}}
    {{-- <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" /> --}}

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Style: Folha de estilo personalizada -->
    <link rel="stylesheet" href="{{ asset('assets/css/_style.css') }}">

    <!-- AdminLTE 3.0.0 Alpha -->
    <link rel="stylesheet" href="{{ asset('assets/_dist/css/adminlte.min.css') }}">

    <!-- Bootstrap Toggle 2.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- iCheck 1.0.1 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/square/blue.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontsgoogleapi/fonts.css') }}">

    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">

    @yield('CSS')

  </head>

  <body id="body" class="hold-transition sidebar-mini" data-url="{{ url('/') }}">

    <!-- Site wrapper -->
    <div class="wrapper">

      {{-- <!-- Navbar -->
      @include('templates/parts/_navbar') --}}

      <!-- Main Sidebar Container -->
      @include('templates/parts/_sidebar_pre-cadastro')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Content Header (Page Title) -->
        {{-- @include('templates/parts/_content-header') --}}

        <!-- Alert Messages -->
        @if (Session::has('_error') || Session::has('_status') || Session::has('_info') || Session::has('_warn'))
        <section class="px-2">

          <div class="container-fluid">

            @include('templates/parts/_messages')

          </div>

        </section>
        @endif

        <!-- Main content -->
        <section class="content">

          <div class="container-fluid">

            @yield('MAIN')

          </div>

        </section>

      </div>
      <!-- /.Content Wrapper -->

      <!-- Footer -->
      @include('templates/parts/_footer')

    </div>
    <!-- ./Wrapper -->

    <!-- ### BASIC SCRIPTS ### -->

    <script type="text/javascript">const main_url = '{{url('/')}}/';</script>

    <!-- JQuery 3.3.1 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery-mask/jquery.mask.min.js') }}"></script>

    <!-- Bootstrap 4.1.3 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- SlimScroll 1.3.3 -->
    <script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Bootstrap Toggle 2.2.0 -->
    <script src="{{ asset('assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>

    <!-- AdminLTE 3.0.0 Alpha -->
    <script src="{{ asset('assets/_dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('assets/js/_scripts.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('assets/js/defaults-pt_BR.min.js') }}"></script>

    @yield('SCRIPTS')


  </body>

</html>
