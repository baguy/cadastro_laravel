<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="{{ route('users.show', [Auth::user()->id]) }}" class="brand-link">
    <img src="{{ asset('assets/img/brasao_caraguatatuba_prefeitura.png') }}"
         alt="SEPEDI LOGO"
         class="brand-image img-circle elevation-3"
         style="opacity: .8"
         title="{{ trans('application.config.nickname') }}"
         >
    <span class="brand-text font-weight-light">
      <b>{{ trans('application.config.name') }}</b>
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar User (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user-circle fa-2x" style="color:white; opacity:.8"></i>
      </div>
      <div class="info">
        <a href="{{ route('users.show', [Auth::user()->id]) }}" class="d-block ellipsis">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

<!-- Logs -->
        @if(Auth::user()->hasRole('ROOT') || Auth::user()->hasRole('ADMIN'))
        <li class="nav-item">
          <a href="{{ route('logs.index') }}" class="nav-link {{ (Request::is('logs') ? 'active' : '') }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              {{ trans('menus.sidebar.item.logs') }}
            </p>
          </a>
        </li>

        <div class="user-panel mt-3 mb-3 d-flex">
        </div>
        @endif

<!-- Caixa de entrada -->
      <div class="info">
        @if(Auth::user()->funcionario_id != "")
          @foreach(Auth::user()->funcionario->setor as $setor)
            <a class="d-block ellipsis" style="margin-left:20px;"> | {{ $setor->nome }} </a>
          @endforeach
        @endif
      </div>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-inbox"></i>
            <p>
              {{ trans('menus.sidebar.item.entrada') }} &nbsp; <b> [ {{ $contadorEntrada }} ] </b>
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('entrada.index') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('entrada.aberto') }}" class="nav-link">
                <i class="far fa-envelope-open"></i>
                <p>{{ trans('menus.sidebar.action.aberto') }}</p> &nbsp; <b> [ {{ $contadorAberto }} ] </b>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('entrada.pendente') }}" class="nav-link">
                <i class="fas fa-tasks"></i>
                <p>{{ trans('menus.sidebar.action.pendente') }}</p> &nbsp; <b> [ {{ $contadorPendente }} ] </b>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('entrada.encerrado') }}" class="nav-link">
                <i class="far fa-check-circle"></i>
                <p>{{ trans('menus.sidebar.action.encerrado') }}</p> &nbsp; <b> [ {{ $contadorEncerrado }} ] </b>
              </a>
            </li>
          </ul>
        </li>

        <div class="user-panel mt-3 mb-3 d-flex">
{{-- Separação --}}
        </div>

<!-- Atendimento -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-address-book"></i>
            <p>
              {{ trans('menus.sidebar.item.atendimento') }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('atendimento.index') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('atendimento.create') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.add') }}</p>
              </a>
            </li>
          </ul>
        </li>

<!-- Individuo -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              {{ trans('menus.sidebar.item.individuo') }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('individuos.index') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('individuos.create') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.add') }}</p>
              </a>
            </li>
          </ul>
        </li>

        <div class="user-panel mt-3 mb-3 d-flex">
<!-- Separação -->
        </div>


<!-- Setor -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-project-diagram"></i>
            <p>
              {{ trans('menus.sidebar.item.setor') }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('setor.index') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('setor.create') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.add') }}</p>
              </a>
            </li>
          </ul>
        </li>

<!-- Funcionario -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-address-card"></i>
            <p>
              {{ trans('menus.sidebar.item.funcionario') }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('funcionario.index') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('funcionario.create') }}" class="nav-link">
                <i class="far fa-dot-circle"></i>
                <p>{{ trans('menus.sidebar.action.add') }}</p>
              </a>
            </li>
          </ul>
        </li>

<!-- Usuários -->
      @if(Auth::check())
        @if(Auth::user()->hasRole('ADMIN'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                {{ trans('menus.sidebar.item.users') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->hasRole('ADMIN'))
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link {{ (Request::is('users') ? 'active' : '') }}">
                    <i class="far fa-dot-circle"></i>
                    <p>{{ trans('menus.sidebar.action.list') }}</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('users.create') }}" class="nav-link {{ (Request::is('users/create') ? 'active' : '') }}">
                    <i class="far fa-dot-circle"></i>
                    <p>{{ trans('menus.sidebar.action.add') }}</p>
                  </a>
                </li>
              @endif
              <li class="nav-item">
                <a
                  href="{{ route('users.show', [Auth::user()->id]) }}"
                  class="nav-link {{ (Request::is(ltrim(route('users.show', [Auth::user()->id], false), '/'))) ? 'active' : '' }}">
                  <i class="far fa-dot-circle"></i>
                  <p>Perfil</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
      @endif


      </ul>
    </nav>
    <!-- /.Sidebar Menu -->

  </div>
  <!-- /.Sidebar -->

</aside>
