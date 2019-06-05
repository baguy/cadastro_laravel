@if ($elements->count())

<div class="text-center text-secondary border-top py-3">
  {{ 
    trans('pagination.table.caption', [
      'total' => $elements->getTotal(), 
      'currentPage' => $elements->getCurrentPage(), 
      'lastPage' => $elements->getLastPage(), 
      'perPage' => $elements->getPerPage()
    ]) 
  }}
</div>

<div class="table-responsive">

  <table class="table table-hover table-sm table-collapse">

    <caption class="text-center">
      {{ 
        trans('pagination.table.caption', [
          'total' => $elements->getTotal(), 
          'currentPage' => $elements->getCurrentPage(), 
          'lastPage' => $elements->getLastPage(), 
          'perPage' => $elements->getPerPage()
        ]) 
      }}
    </caption>

    <thead>
      <tr>
        <th class="text-center text-primary th-collapse-all">
          <i 
            class="fas fa-expand fa-fw" 
            data-tooltip="tooltip" 
            data-placement="top" 
            data-original-title="{{ trans('application.btn.expand') }}"></i>
          <i 
            class="fas fa-compress fa-fw d-none" 
            data-tooltip="tooltip" 
            data-placement="top" 
            data-original-title="{{ trans('application.btn.compress') }}"></i>
        </th>
        <th>{{ trans('users.lbl.name') }}</th>
        <th class="d-none d-md-table-cell">{{ trans('users.lbl.email') }}</th>
        <th class="d-none d-sm-table-cell col-status">{{ trans('application.lbl.status') }}</th>
        <th class="col-roles">{{ trans('users.lbl.roles') }}</th>
        <th class="col-options">{{ trans('application.lbl.options') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($elements as $user)
      
      <tr class="{{ ($user->trashed()) ? (($user->throttle->suspended) ? 'table-warning' : 'table-danger') : '' }}">
        <td class="text-center align-middle">
          <button 
            class="btn btn-primary btn-toggle" 
            type="button" 
            data-toggle="collapse" 
            data-target="#collapseUser_{{ $user->id }}" 
            aria-expanded="false" 
            aria-controls="collapseUser_{{ $user->id }}">
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </td>
        <td class="align-middle w-auto">
          <span class="ellipsis">{{ $user->name }}</span>
        </td>
        <td class="d-none d-md-table-cell align-middle w-auto">{{ $user->email }}</td>
        <td class="d-none d-sm-table-cell align-middle px-2 text-uppercase col-status">
          <span class="badge {{ ($user->trashed()) ? (($user->throttle->suspended) ? 'badge-warning' : 'badge-danger') : 'badge-success' }} badge-pill d-block">
            {{ 
              ($user->trashed()) ? 
                (($user->throttle->suspended) ? 
                  trans('users.lbl.suspended') : 
                  trans('application.lbl.inactive')) : 
              trans('application.lbl.active') 
            }}
          </span>
        </td>
        <td class="align-middle px-2 col-roles">
          <span class="badge badge-secondary d-block">
            {{ $user->minRole()->name }}
          </span>
        </td>
        <td class="align-middle col-options">
          @if(Auth::user()->hasRole('ADMIN'))
            @if($user->trashed())
              <a 
                class="btn btn-warning {{ $user->userIsAuth($user) || (!$user->userIsAuth($user) && $user->userMinRoleIsLessOrEqualThanAuthMinRole($user)) ? 'disabled' : '' }}" 
                href="#modalRestore_{{ $user->id }}" 
                data-toggle="modal" 
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>
            @else
              <a 
                class="btn btn-danger {{ $user->userIsAuth($user) || (!$user->userIsAuth($user) && $user->userMinRoleIsLessOrEqualThanAuthMinRole($user)) ? 'disabled' : '' }}" 
                href="#modalDelete_{{ $user->id }}" 
                data-toggle="modal" 
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>
            @endif
          @endif
          <a 
            href="{{ URL::to('users/'.$user->id.'/edit') }}" 
            class="btn btn-info {{ ($user->trashed() || (!$user->userIsAuth($user) && $user->userMinRoleIsLessOrEqualThanAuthMinRole($user))) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>
          <a 
            href="{{ URL::to('users/'.$user->id) }}" 
            class="btn btn-default {{ (!$user->userIsAuth($user) && $user->userMinRoleIsLessOrEqualThanAuthMinRole($user)) ? 'disabled' : '' }}" 
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
            <i class="fas fa-search fa-fw"></i>
          </a>
        </td>
      </tr>
      <tr>
        <td class="description">

          <div class="collapse" id="collapseUser_{{ $user->id }}">

            <div class="pt-3 px-3 pb-0">

              <div class="row">

                <div class="col-md-6">

                  <blockquote class="blockquote d-block d-md-none">
                    <p class="mb-0"><i class="fas fa-envelope fa-fw mr-1"></i> {{ trans('users.lbl.email') }}</p>
                    <footer class="blockquote-footer">{{ $user->email }}</footer>
                  </blockquote>

                  <blockquote class="blockquote d-block d-sm-none">
                    <p class="mb-0"><i class="fas fa-signal fa-fw mr-1"></i> {{ trans('application.lbl.status') }}</p>
                    <footer class="blockquote-footer">
                      <span class="badge {{ ($user->trashed()) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                        {{ ($user->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                      </span>
                    </footer>
                  </blockquote>

                  <blockquote class="blockquote">
                    <p class="mb-0"><i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}</p>
                    <footer class="blockquote-footer">
                      {{ FormatterHelper::dateTimeToPtBR($user->created_at) }}
                    </footer>
                  </blockquote>

                  @if(strtotime($user->updated_at) > 0)
                  <blockquote class="blockquote">
                    <p class="mb-0"><i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}</p>
                    <footer class="blockquote-footer">
                      {{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}
                    </footer>
                  </blockquote>
                  @endif

                  @if($user->deleted_at)
                  <blockquote class="blockquote">
                    <p class="mb-0">
                      <i class="fas fa-calendar fa-fw mr-1"></i> 
                      {{ ($user->throttle->suspended) ? trans('application.lbl.suspended-at') : trans('application.lbl.deleted-at') }}
                    </p>
                    <footer class="blockquote-footer {{ ($user->throttle->suspended) ? 'text-warning' : 'text-danger' }}">
                      {{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}
                    </footer>
                  </blockquote>
                  @endif

                  <blockquote class="blockquote">
                    <p class="mb-0">
                      <i class="fas fa-lock fa-fw mr-1"></i> {{ trans('users.ask.default-password-has-been-changed') }}
                    </p>
                    <footer class="blockquote-footer {{ ($user->throttle->is_default_password) ? 'text-danger' : 'text-success' }}">
                      @if($user->throttle->is_default_password)

                        <span class="badge badge-danger badge-pill text-uppercase">
                          {{ trans('application.lbl.no') }}
                        </span>

                      @else

                        <span class="badge badge-success badge-pill text-uppercase">
                          {{ trans('application.lbl.yes') }}
                        </span>

                      @endif
                    </footer>
                  </blockquote>

                </div>

                <div class="col-md-6">

                  <blockquote class="blockquote d-block">
                    <p class="mb-0"><i class="fas fa-sign-in-alt fa-fw mr-1"></i> {{ trans('users.lbl.last-access') }}</p>
                    <footer class="blockquote-footer">
                      @if(strtotime($user->throttle->last_access_at) > 0)
                    
                        {{ 
                          trans('users.msg.last-access', [
                            'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at)
                          ]) 
                        }}

                      @else

                        {{ trans('users.msg.no-access') }}

                      @endif
                    </footer>
                  </blockquote>

                  {{-- */ $minutes = 0 /* --}}

                  @if ($user->throttle->suspended)

                    {{-- */

                      $time    = strtotime($user->throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now');

                      $minutes = round(((($time % 604800) % 86400) % 3600) / 60);

                    /* --}}

                  @endif

                  <blockquote class="blockquote d-block">
                    <p class="mb-0"><i class="fas fa-clock fa-fw mr-1"></i> {{ trans('users.lbl.suspended') }}</p>
                    <footer class="blockquote-footer">
                      @if ($minutes > 0)

                        {{ trans('users.msg.suspended', ['minutes' => $minutes]) }}

                      @else

                        @if ($user->throttle->suspended)

                          {{ trans('users.msg.suspension-time-ended') }}

                        @else

                          {{ trans('users.msg.not-suspended') }}

                        @endif

                      @endif
                    </footer>
                  </blockquote>

                  <blockquote class="blockquote d-block">
                    <p class="mb-0"><i class="fas fa-list-ol fa-fw mr-1"></i> {{ trans('users.lbl.attempts') }}</p>
                    <footer class="blockquote-footer">
                      {{ trans('users.msg.attempts', ['attempts' => $user->throttle->attempts]) }}
                    </footer>
                  </blockquote>

                  <blockquote class="blockquote d-block">
                    <p class="mb-0"><i class="fas fa-calendar-day fa-fw mr-1"></i> {{ trans('users.lbl.last-attempt') }}</p>
                    <footer class="blockquote-footer">
                      @if(strtotime($user->throttle->last_attempt_at) > 0)
                    
                        {{ 
                          trans('users.msg.last-attempt', [
                            'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_attempt_at)
                          ]) 
                        }}

                      @else

                        {{ trans('users.msg.no-last-attempt') }}

                      @endif
                    </footer>
                  </blockquote>

                </div>

              </div>

              @if(Auth::user()->hasRole('ROOT'))
              <a 
                class="btn btn-warning mb-3 {{ $user->userIsAuth($user) ? 'disabled' : '' }}" 
                href="#modalRedefinePassword_{{ $user->id }}" 
                data-toggle="modal">
                {{ trans('application.btn.redefine') }} {{ trans('users.lbl.password') }}
              </a>
              @endif

            </div>

          </div>

        </td>
      </tr>

      @endforeach

    </tbody>

  </table>

</div>

{{ $elements->links() }}

@foreach ($elements as $user)
      
  @if (!$user->userIsAuth($user) && !$user->userMinRoleIsLessOrEqualThanAuthMinRole($user))

    @include('users/_modal-delete')

    @include('users/_modal-restore')

    @if(Auth::user()->hasRole('ROOT'))

      @include('users/_modal-redefine-password')

    @endif

  @endif

@endforeach

@else

<div class="alert alert-warning">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif