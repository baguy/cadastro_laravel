<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

  <!-- Left navbar links -->
  <ul class="navbar-nav">

    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('users.show', [Auth::user()->id]) }}" class="nav-link">{{ trans('application.lbl.home') }}</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('manual.index', [Auth::user()->id]) }}" class="nav-link">{{ trans('application.lbl.manual') }}</a>
    </li>

  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fas fa-th"></i>
      </a>
    </li>

  </ul>

</nav>
