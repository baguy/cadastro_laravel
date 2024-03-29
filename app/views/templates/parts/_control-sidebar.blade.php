<aside class="control-sidebar control-sidebar-dark">

  <ul class="list-unstyled">

    @if(Auth::check())
      <li class="d-block p-2">
        {{ trans('menus.ctrl-sidebar.welcome') }}
      </li>
      <li>
        <a href="{{ route('users.show', [Auth::user()->id]) }}" class="d-block p-2">
          <i class="fas fa-user text-info"></i> {{ trans('menus.ctrl-sidebar.profile') }}
        </a>
      </li>
      <li>
        <a href="{{ url('logout') }}" class="d-block p-2">
          <i class="fas fa-sign-out-alt text-danger"></i> {{ trans('menus.ctrl-sidebar.logout') }}
        </a>
      </li>
    @endif

  </ul>

</aside>