@if (isset($user->id))

{{ Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id))) }}

@else

{{ Form::open(array('route' => 'users.store')) }}

@endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        @if (isset($user->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>
    <div class="card-body">

      <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">

        {{ Form::label('name', trans('users.lbl.name')) }}<span class="obrigatorio">*</span>

        <div class="input-group">

          <div class="input-group-append">
            <span id="nameAddon" class="input-group-text">
              <i class="fas fa-user fa-fw"></i>
            </span>
          </div>

          {{ Form::text(
              'name',
              Input::old('name'),
              array(
                'class'            => 'form-control',
                'placeholder'      => trans('users.plh.name'),
                'aria-describedby' => 'nameAddon'
              )
            )
          }}


          @if ($errors->has('name'))
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
          @endif

        </div>

      </div>


        <div class="form-row">

          <div class="col-4 {{ ($errors->has('matricula')) ? 'has-error' : '' }}">
            {{ Form::label('matricula', trans('funcionario.lbl.matricula')) }}<span class="obrigatorio">*</span>
            <div class="input-group">

              <div class="input-group-append">
                <span id="nameAddon" class="input-group-text">
                  <i class="fas fa-certificate fa-fw"></i>
                </span>
              </div>
            {{ Form::text(
                'matricula',
                // Input::old('matricula'),
                isset($user->funcionario->matricula)? $user->funcionario->matricula : null,
                array(
                  'class'       => 'form-control',
                  'placeholder' => trans('funcionario.plh.matricula')
                )
              )
            }}

            @if ($errors->has('matricula'))
            <div class="invalid-feedback">
              {{ $errors->first('matricula') }}
            </div>
            @endif
          </div>
        </div>

          <div class="form-group col-md-8">

            {{-- Setor --}}

            {{ Form::label('setor', trans('atendimento.lbl.setor')) }}

            <div class="input-group {{ ($errors->has('setor')) ? 'has-error' : '' }}">

              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-list-ol fa-fw"></i>
                </span>
              </div>

              {{ Form::select(
                'setor_id[]',
                $data['setor'],
                isset($user->funcionario) ? FormatterHelper::multiSelectValues($user->funcionario->setor) : null,
                array(
                  'multiple',
                  'data-live-search' => 'true',
                  'class'       => 'form-control selectpicker setor',
                  'title' => 'SELECIONE O SETOR'
                  )
                )
              }}

              <div class="invalid-feedback" style="display:block !important">
                @if ($errors->has('tipo_atendimento_id'))
                  {{ $errors->first('tipo_atendimento_id') }}
                @endif
              </div>

            </div>
          </div>



  </div>

      <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">

        {{ Form::label('email', trans('users.lbl.email')) }}<span class="obrigatorio">*</span>

        <div class="input-group">

          <div class="input-group-append">
            <span id="emailAddon" class="input-group-text">
              <i class="fas fa-envelope fa-fw"></i>
            </span>
          </div>

          {{
            Form::email(
              'email',
              // Input::old('email'),
              null,
              array(
                'class'            => 'form-control',
                'placeholder'      => trans('users.plh.email'),
                'aria-describedby' => 'emailHelp',
                'aria-labelledby'  => 'emailAddon',
                'autocomplete'     => 'off'
              )
            )
          }}


          @if ($errors->has('email'))
          <div class="invalid-feedback">
            {{ $errors->first('email') }}
          </div>
          @endif

        </div>

        <small id="emailHelp" class="form-text text-muted">
          {{ trans('application.misc.institutional-email') }} - <code class="text-info"
          data-tooltip="tooltip"
          data-placement="bottom"
          data-container="small"
          title="{{ trans('application.misc.click-to-copy') }}" style="cursor: pointer;">
            {{'@'}}{{ trans('application.config.site-domain') }}
          </code>
        </small>

      </div>

      @if (isset($user->id))

        @if (!Auth::user()->hasRole('ADMIN') || $user->userIsAuth($user))

          <div class="form-group {{ ($errors->has('actual_password')) ? 'has-error' : '' }}">

            {{ Form::label('actual_password', trans('users.lbl.actual-password')) }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'actual_password',
                  Input::old('actual_password'),
                  array(
                    'class'            => 'form-control',
                    'placeholder'      => trans('users.plh.actual-password'),
                    'aria-describedby' => 'actualPasswordHelp',
                    'aria-labelledby'  => 'actualPasswordAddon'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="actualPasswordAddon" class="input-group-text rounded-right">
                  <i class="fas fa-lock fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('actual_password'))
              <div class="invalid-feedback">
                {{ $errors->first('actual_password') }}
              </div>
              @endif

            </div>

            <small id="actualPasswordHelp" class="form-text text-muted">
              <i class="fas fa-asterisk"></i> {{ trans('users.help.actual.password') }}
            </small>

          </div>

          @endif

        @endif

          <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">

            {{ Form::label('password', (isset($user->id)) ? trans('users.lbl.new-password') : trans('users.lbl.password')) }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'password',
                  // Input::old('password'),
                  null,
                  array(
                    'class'            => 'form-control password',
                    'placeholder'      => (isset($user->id)) ? trans('users.plh.new-password') : trans('users.plh.password'),
                    'aria-describedby' => 'passwordHelp',
                    'aria-labelledby'  => 'passwordAddon',
                    'autocomplete'     => 'new-password',
                    'required'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="passwordAddon" class="input-group-text rounded-right">
                  <i class="fas fa-lock fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('password'))
              <div class="invalid-feedback">
                {{ $errors->first('password') }}
              </div>
              @endif

            </div>

            <small id="passwordHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('reminders.password') }}
            </small>

            @if (isset($user->id))
            <small id="passwordHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('users.help.password') }}
            </small>
            @endif


          </div>

          <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">

            {{
              Form::label(
                'password_confirmation',
                (isset($user->id)) ? trans('users.lbl.new-password-confirmation') : trans('users.lbl.password-confirmation')
              )
            }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'password_confirmation',
                  // Input::old('password_confirmation'),
                  null,
                  array(
                    'class'            => 'form-control',
                    'placeholder'      => (isset($user->id)) ?
                      trans('users.plh.new-password-confirmation') :
                      trans('users.plh.password-confirmation'),
                    'aria-describedby' => 'passwordConfirmationHelp',
                    'aria-labelledby'  => 'passwordConfirmationAddon'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="passwordConfirmationAddon" class="input-group-text rounded-right">
                  <i class="fas fa-check-square fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('password_confirmation'))
              <div class="invalid-feedback">
                {{ $errors->first('password_confirmation') }}
              </div>
              @endif

            </div>

            <small id="passwordHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('reminders.password-confirmation') }}
            </small>

            @if (isset($user->id))
            <small id="passwordConfirmationHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('users.help.password') }}
            </small>
            @endif

          </div>

        {{-- @endif --}}

      {{-- @endif --}}

      @if (Auth::user()->hasRole('ADMIN'))

      <div class="form-group {{ ($errors->has('roles')) ? 'has-error' : '' }}">

        {{ Form::label('roles', trans('users.lbl.roles'))}}<span class="obrigatorio">*</span>

        <div id="roles">
          @foreach ($roles as $role)

            <label class="form-check-label">
              @if (isset($user->id))

                @if ($user->userIsAuth($user) || ($user->minRole()->id <= Auth::user()->minRole()->id))

                  @if (in_array($role->name, $user->roles->lists('name')))

                    <span class="badge badge-secondary">{{ $role->name }}</span>

                  @endif

                @else

                  @if ($role->id > Auth::user()->minRole()->id)

                    {{
                      Form::checkbox(
                        'roles['.$role->id.']',
                        $role->id,
                        in_array($role->name, $user->roles->lists('name')) ? 'checked' : null,
                        array(
                          'id'    => 'role_'.$role->id,
                          'class' => 'icheck'
                        )
                      )
                    }}

                    {{ $role->name }}

                  @endif

                @endif

              @else

                @if ($role->id > Auth::user()->minRole()->id)

                  {{
                    Form::checkbox(
                      'roles['.$role->id.']',
                      $role->id,
                      null,
                      array(
                        'id'    => 'role_'.$role->id,
                        'class' => 'icheck'
                      )
                    )
                  }}

                  {{ $role->name }}

                @endif

              @endif

            </label>

          @endforeach
        </div>

        @if ($errors->has('roles'))
        <div class="invalid-feedback">
          {{ $errors->first('roles') }}
        </div>
        @endif

      </div>

      @endif

      @if(Auth::user()->hasRole('ADMIN') &&
          isset($user->id) &&
          !$user->userIsAuth($user) &&
          ($user->minRole()->id > Auth::user()->minRole()->id))

      <div class="form-group">

        {{ Form::label('active', trans('application.lbl.status'), array('class' => 'd-block'))}}

          {{
            Form::checkbox(
              'active',
              1,
              ($user->trashed()) ? null : 'checked',
              array(
                'data-toggle'   => 'toggle',
                'data-on'       => trans('application.lbl.active'),
                'data-off'      => trans('application.lbl.inactive'),
                'data-onstyle'  => 'success',
                'data-offstyle' => 'danger'
              )
            )
          }}

      </div>

      @endif

    </div>

    <div class="card-footer text-right">
      @if (isset($user->id))

        {{
          link_to_route(
            'users.show',
            trans('application.btn.cancel'),
            $user->id,
            array(
              'class' => 'btn btn-default'
            )
          )
        }}

        {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

      @else

        {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary')) }}

      @endif
    </div>

  </div>

{{ Form::close() }}
