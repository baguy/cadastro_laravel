<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('application.config.name') }}{{ trans('application.config.nickname') }} - @yield('PAGE_TITLE')</title>

    {{-- Ícone tab --}}
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- iCheck 1.0.1 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/square/blue.css') }}">

    <!-- AdminLTE 3.0.0 Alpha -->
    <link rel="stylesheet" href="{{ asset('assets/_dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Style: Folha de estilo personalizada -->
    <link rel="stylesheet" href="{{ asset('assets/css/_style.css') }}">

    @if(!Request::is('errors/js'))
    <noscript><meta http-equiv="Refresh" content="1; url={{ url('/errors/js') }}"></noscript>
    @endif
  </head>

  <body id="body" class="hold-transition login-page" data-url="{{ url('/') }}">

    @yield('MAIN')

    <!-- ### BASIC SCRIPTS ### -->

    <!-- JQuery 3.3.1 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/$_auth.js') }}"></script>

    <!-- Bootstrap 4.1.3 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- AdminLTE 3.0.0 Alpha -->
    <script src="{{ asset('assets/_dist/js/adminlte.min.js') }}"></script>

    <script>
		  $(function () {

		    $('.icheck').iCheck({
		      checkboxClass: 'icheckbox_square-blue',
		      radioClass   : 'iradio_square-blue',
		      increaseArea : '20%' // optional
		    });

		  })
		</script>

  </body>

</html>
