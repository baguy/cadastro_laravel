<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ### BOOTSTRAP 3.3.4: Latest compiled and minified CSS ### -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- ### FONT AWESOME: Latest compiled and minified CSS ### -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- ### CUS ICONS: Ícones ### -->
    <link rel="stylesheet" href="{{ asset('css/cus-icons.css') }}">
    <!-- ### LAYOUT: Folha de estilo personalizada ### -->
    <link rel="stylesheet" href="{{ asset('css/_print.css') }}">
</head>

<body id="body" data-url="{{ url('/') }}">
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (Session::has('message'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('message') }}</p>
                </div>
                @endif
                
                @if (Session::has('status'))
                <div class="alert alert-success">
                    <p>{{ Session::get('status') }}</p>
                </div>
                @endif

                @yield('main')

            </div>
        </div>
    </div>

    <!-- ### BASIC SCRIPTS ### -->
    
    <!--[if !IE]> -->
    <script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
    <!-- <![endif]-->

    <!--[if IE]>
        <script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>