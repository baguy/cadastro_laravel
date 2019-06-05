@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.show') }}
@stop

@section('MAIN')

  <div class="row">

    <div class="col-md-4">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">

        <div class="card-body box-profile">

          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="{{ asset('assets/_dist/img/avatar_128x128.png') }}"
                 alt="{{ $user->name }}">
          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->email }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>{{ trans('application.lbl.created-at') }}</b> 
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($user->created_at) }}</a>
            </li>
            @if(strtotime($user->updated_at) > 0)
            <li class="list-group-item">
              <b>{{ trans('application.lbl.updated-at') }}</b> 
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}</a>
            </li>
            @endif

            @if($user->deleted_at)
            <li class="list-group-item {{ ($user->throttle->suspended) ? 'text-warning' : 'text-danger' }}">
              <b>{{ ($user->throttle->suspended) ? trans('application.lbl.suspended-at') : trans('application.lbl.deleted-at') }}</b> 
              <a class="float-right">{{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}</a>
            </li>
            @endif
          </ul>

        </div>

        <div class="card-footer text-right">

          @if(Auth::user()->hasRole('ADMIN'))
            @if($user->trashed())
              <a 
                class="btn btn-light text-warning {{ ($user->userIsAuth($user)) ? 'disabled' : '' }}" 
                href="#modalRestore_{{ $user->id }}" 
                data-toggle="modal" 
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a 
                class="btn btn-light text-danger {{ ($user->userIsAuth($user)) ? 'disabled' : '' }}" 
                href="#modalDelete_{{ $user->id }}" 
                data-toggle="modal" 
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif

          <a 
            href="{{ route('users.edit', [ $user->id ]) }}" 
            class="btn btn-light text-info {{ ($user->trashed()) ? 'disabled' : '' }}" 
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>

          <a 
            href="{{ route('users.change-password', [ $user->id ]) }}" 
            class="btn btn-light text-warning {{ ($user->trashed() || !$user->userIsAuth($user)) ? 'disabled' : '' }}" 
            data-tooltip="tooltip" data-placement="top" title="{{ trans('users.page.title.change-password') }}">
            <i class="fas fa-lock fa-fw"></i>
          </a>

        </div>

      </div>
      <!-- /.Profile Image -->

      <!-- About Me Box -->
      <div class="card card-primary">

        <div class="card-header">
          <h3 class="card-title">{{ trans('application.lbl.about') }}</h3>
        </div>
        
        <div class="card-body">
          <strong><i class="fas fa-user fa-fw mr-1"></i> {{ trans('users.lbl.name') }}</strong>

          <p class="text-muted">{{ $user->name }}</p>

          <hr>

          <strong><i class="fas fa-envelope fa-fw mr-1"></i> {{ trans('users.lbl.email') }}</strong>

          <p class="text-muted">{{ $user->email }}</p>

          <hr>

          <strong class="d-block"><i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}</strong>

          <span class="badge {{ ($user->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
            {{ ($user->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </span>

          <hr>

          <strong class="d-block"><i class="fas fa-layer-group fa-fw mr-1"></i> {{ trans('users.lbl.roles') }}</strong>

          <span class="badge badge-secondary">
            {{ $user->minRole()->name }}
          </span>
        </div>
        
      </div>
      <!-- /.About Me Box -->
      
    </div>
    
    <div class="col-md-8">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active" href="#activity" data-toggle="tab">
                {{ trans('users.tab.activity') }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#logs" data-toggle="tab">
                {{ trans('users.tab.logs') }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content">

            <!-- Tab Pane -->
            <div class="active tab-pane" id="activity">

              <!-- Post -->
              <div class="post">

                <strong><i class="fas fa-sign-in-alt fa-fw mr-1"></i> {{ trans('users.lbl.last-access') }}</strong>

                <p class="text-muted">
                  @if(strtotime($user->throttle->last_access_at) > 0)
                  
                    {{ trans('users.msg.last-access', ['datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at)]) }}

                  @else

                    {{ trans('users.msg.no-access') }}

                  @endif
                </p>

                <hr>

                {{-- */ $minutes = 0 /* --}}

                @if ($user->throttle->suspended)

                  {{-- */

                    $time    = strtotime($user->throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now');

                    $minutes = round(((($time % 604800) % 86400) % 3600) / 60);

                  /* --}}

                @endif

                <strong><i class="fas fa-clock fa-fw mr-1"></i> {{ trans('users.lbl.suspended') }}</strong>

                <p class="text-muted">

                  @if ($minutes > 0)

                    {{ trans('users.msg.suspended', ['minutes' => $minutes]) }}

                  @else

                    @if ($user->throttle->suspended)

                      {{ trans('users.msg.suspension-time-ended') }}

                    @else

                      {{ trans('users.msg.not-suspended') }}

                    @endif

                  @endif

                </p>

                <hr>

                <strong class="d-block"><i class="fas fa-list-ol fa-fw mr-1"></i> {{ trans('users.lbl.attempts') }}</strong>

                <p class="text-muted">
                  {{ trans('users.msg.attempts', ['attempts' => $user->throttle->attempts]) }}
                </p>

                <hr>

                <strong><i class="fas fa-calendar-day fa-fw mr-1"></i> {{ trans('users.lbl.last-attempt') }}</strong>

                <p class="text-muted mb-0">
                  @if(strtotime($user->throttle->last_attempt_at) > 0)
                  
                    {{ 
                      trans('users.msg.last-attempt', [
                        'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_attempt_at)
                      ]) 
                    }}

                  @else

                    {{ trans('users.msg.no-last-attempt') }}

                  @endif
                </p>

                <hr>

                <strong><i class="fas fa-lock fa-fw mr-1"></i> {{ trans('users.ask.default-password-has-been-changed') }}</strong>

                <p class="mb-0">
                  @if($user->throttle->is_default_password)

                    <span class="badge badge-danger badge-pill text-uppercase">
                      {{ trans('application.lbl.no') }}
                    </span>

                  @else

                    <span class="badge badge-success badge-pill text-uppercase">
                      {{ trans('application.lbl.yes') }}
                    </span>

                  @endif
                </p>

              </div>
              <!-- /.Post -->

            </div>
            <!-- /.Tab Pane -->
            
            <!-- Tab Pane -->
            <div class="tab-pane" id="logs">
              
              <ul class="timeline timeline-inverse">

                {{-- */ $counter = 0 /* --}}

                @foreach ($logs as $key => $log)

                  @if (($key + 1) < $logs->count())

                    @if ($counter === 0)
                    
                    <!-- Timeline Time Label -->

                    <li class="time-label">
                      <span class="bg-secondary">
                        {{ $log->created_at->format('d M. Y') }}
                      </span>
                    </li>

                    <!-- /.Timeline Time Label -->

                    @endif

                    {{-- */ $actual = $log->created_at->format('d M. Y') /* --}}
                    {{-- */ $next   = $logs[($key + 1)]->created_at->format('d M. Y') /* --}}

                    @if ($actual === $next)

                      {{-- */ $counter++ /* --}}

                    @else

                      {{-- */ $counter = 0 /* --}}

                    @endif

                  @endif

                <!-- Timeline Item -->

                <li>
                  <i class="fa fa-{{$icons[$log->action]}} bg-{{$colors[$log->action]}}"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> {{ $log->created_at->format('H:i:s') }}</span>

                    <h3 class="timeline-header">
                      <strong class="text-{{$colors[$log->action]}}">{{ $log->action }}</strong>
                    </h3>

                    <div class="timeline-body">
                      {{ $log->message }}
                    </div>
                  </div>
                </li>

                <!-- /.Timeline Item -->

                @endforeach

              </ul>

              @if(Auth::user()->hasRole('ADMIN') && $user->loggers->count() > $take)
                {{ 
                  link_to_route(
                    'logs.index', 
                    trans('application.btn.show-all'), 
                    array(
                      'search' => explode('@', $user->email)[0]
                    ), 
                    array(
                      'class' => 'btn btn-primary btn-block btn-sm'
                    )
                  ) 
                }}
              @endif

            </div>
            <!-- /.Tab Pane -->

          </div>
          <!-- /.Tab Content -->

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

  </div>

  @include('users/_modal-delete')

  @include('users/_modal-restore')

@stop