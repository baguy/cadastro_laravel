<?php

class UserController extends BaseController {

  protected $user;

  protected $role;

  protected $service;

  public function __construct(User $user, Role $role, UserService $service) {

    $this->user    = $user;
    $this->role    = $role;
    $this->service = $service;

    $this->beforeFilter('role:ROOT', array('only' => array('redefinePassword')));
    $this->beforeFilter('role:ADMIN', array('only' => array('index', 'create', 'store', 'destroy', 'restore')));
  }

  public function index() {

    $selects = [
      'status'              => MainHelper::fixArray2('status', [
                                '1' => mb_strtoupper(Lang::get('application.lbl.active'), 'UTF-8'),
                                '2' => mb_strtoupper(Lang::get('application.lbl.inactive'), 'UTF-8') ,
                                '3' => mb_strtoupper(Lang::get('users.lbl.suspended'), 'UTF-8')
                              ]),
      'roles'               => MainHelper::fixArray2('nível', Role::where('id', '>=', Auth::user()->minRole()->id)
                                                                    ->orderBy('id', 'ASC')->lists('name', 'id')),
      'attempts'            => MainHelper::fixArray2('tentativas', [
                                '0' => mb_strtoupper(Lang::get('users.filter.attempts.opt.successful'), 'UTF-8'),
                                '1' => mb_strtoupper(Lang::get('users.filter.attempts.opt.unsuccessful'), 'UTF-8')
                              ]),
      'is_default_password' => MainHelper::fixArray2('senhas', [
                                true  => mb_strtoupper(Lang::get('users.filter.is_default_password.opt.default'), 'UTF-8'),
                                false => mb_strtoupper(Lang::get('users.filter.is_default_password.opt.changed'), 'UTF-8')
                              ])
    ];

    return View::make('users.index', compact('selects'));
  }

  public function create() {

    $roles = $this->role->orderBy('id', 'ASC')->get(['id', 'name']);
    $data = [
      'setor'   => array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
    ];

    return View::make('users.create', compact('data'))->with('roles', $roles);
  }

  public function store() {

      $input = FormatterHelper::filter(Input::all(), array('name'));

      $validator = UserValidator::store($input);

      if ($validator->passes()) {

        try {

          $this->service->store($input);

          return Redirect::route('users.index')
                          ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

        } catch (Exception $e) {

          Session::flash('_old_input', Input::all());

          return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
        }
      }

      return Redirect::route('users.create')
                      ->withInput()
                      ->withErrors($validator)
                      ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function show($id) {

    $user = $this->user->withTrashed()->find($id);

    $this->service->accessVerification($user);

    LoggerHelper::log('SHOW', Lang::get('logs.msg.show', [
      'resource'  => $this->service->getTable($this->user),
      'id'        => $user->id
    ]));

    $take   = 10;

    $colors = LoggerHelper::getColors();

    $icons  = LoggerHelper::getIcons();

    $logs   = $user->loggers()->orderBy('created_at', 'DESC')->take($take)->get();

    return View::make('users.show', compact(['user', 'logs', 'colors', 'icons', 'take']));
  }

  public function edit($id) {

    $user = $this->user->find($id);

    $roles = $this->role->orderBy('id', 'ASC')->get(['id', 'name']);

    $this->service->accessVerification($user);

    $data = [
      'funcionario' => funcionario::find($id),
      'setor'   		=> array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
    ];

    return View::make('users.edit', compact('user', 'data'))->with('roles', $roles);
  }

  public function update($id) {

    $input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('name'));

    $validator = UserValidator::update($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->update($input, $id);

        return Redirect::route('users.show', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('users.edit', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function destroy($id) {

    $user = $this->user->find($id);

    $this->service->accessVerification($user, false, true);

    try {

      $this->service->destroy($id);

      return Redirect::route('users.index')
                      ->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  public function restore($id) {

    $user = $this->user->withTrashed()->find($id);

    $this->service->accessVerification($user, false, true);

    try {

      $this->service->restore($id);

      return Redirect::route('users.index')
                      ->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  public function changePassword($id) {

    $user = $this->user->find($id);

    $this->service->accessVerification($user, true);

    if ($user->throttle->is_default_password)

      Session::flash('_warn', Lang::get('users.msg.is-default-password'));

    return View::make('users.change-password', compact('user'));
  }

  public function alterPassword($id) {

    $input = Input::except('_method');

    $validator = UserValidator::alterPassword($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->alterPassword($input, $id);

        return Redirect::route('users.show', $id)
                        ->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('users.change-password', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function redefinePassword($id) {

    try {

      $this->service->redefinePassword($id);

      return Redirect::route('users.index')
                      ->with('_status', Lang::get('users.msg.password-redefined-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }
}
