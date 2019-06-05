<?php

class UserService extends BaseService {

	protected $user;

  public function __construct(User $user) {

    $this->user = $user;
  }

  public function index() {

    /*
    $users = $this->user->withTrashed()
                          ->where('users.id', Auth::user()->id)
                          ->orWhereHas('roles', function ($q) {
                            $q->havingRaw('MIN(roles.id) > ?', [ Auth::user()->minRole()->id ]);
                          })
                          ->orderBy('deleted_at', 'ASC')
                          ->orderBy('name', 'ASC')
                          ->paginate(10);

    LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => Self::getTable($this->user)]));

    $input = Input::all();

    if (count($input))
      LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
        'resource'  => Self::getTable($this->user),
        'parameter' => json_encode($input)
      ]));

    return $users;
    */
  }

  public function store($input) {

  	DB::beginTransaction();

    try {

      $user = new User($input);

      // $user->password = Hash::make(User::DEFAULT_PASSWORD);
			if (!empty($input['password'])) {

				$user->password = Hash::make($input['password']);

			}


			if(isset($input['setor_id'])){
				$funcionario = Funcionario::create($input);
				$funcionario['nome'] = $input['name'];
				foreach ($input['setor_id'] as $setor) {
					$funcionario->setor()->attach($setor);
				}
				$funcionario->save();
				$user['funcionario_id'] = $funcionario->id;
			}

			$user->save();

      $user->roles()->sync($input['roles']);

      $throttle = new Throttle();

			$throttle->is_default_password = false;

      $user->throttle()->save($throttle);


				LoggerHelper::log('CREATE', Lang::get('logs.msg.create', ['resource' => Self::getTable($this->user), 'id' => $user->id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      $user->fill($input);

      if (!empty($input['password'])) {

        $user->password = Hash::make($input['password']);

        LoggerHelper::log('AUTH', Lang::get('logs.msg.password.change', [
          'email' => $user->email, 'id' => $user->id
        ]));
      }

      Self::hasChanges($user, array('password'));

      $user->update();

      if (!empty($input['roles'])) {

        $MIN_ROLE = $user->minRole();

        $user->roles()->sync($input['roles']);

        $NEW_ROLE = Role::find(min($input['roles']));

        if ($MIN_ROLE->id !== $NEW_ROLE->id)
          LoggerHelper::log('EDIT', Lang::get('logs.msg.edit.roles', [
            'email'     => $user->email,
            'original'  => $MIN_ROLE->name,
            'value'     => $NEW_ROLE->name,
            'id'        => $user->id
          ]));
      }

      LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', ['resource' => Self::getTable($this->user), 'id' => $user->id]));

			// Atualizar Funcionário caso Usuário seja relacionado a um funcionário
			if(isset($user->funcionario_id)){
				$funcionario = Funcionario::find($user->funcionario_id);
				$funcionario->fill($input);

				Self::hasChanges($funcionario, array());

				$funcionario->update();
			}

      DB::commit();

      if (empty($input['active']) && ($user->id !== Auth::user()->id))
        $this->destroy($user->id);

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function destroy($id) {

    DB::beginTransaction();

    try {

      $this->user->find($id)->delete();

      LoggerHelper::log('DESTROY', Lang::get('logs.msg.destroy', ['resource' => Self::getTable($this->user), 'id' => $id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function restore($id) {

    DB::beginTransaction();

    try {

      $user = $this->user->withTrashed()->find($id);

      $user->restore();

      if ($user->throttle->suspended) {

        $throttle = $user->throttle()->first();

        $throttle->attempts = 0;

        $throttle->last_attempt_at = null;

        $throttle->suspended = false;

        $throttle->update();
      }

      LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', ['resource' => Self::getTable($this->user), 'id' => $id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function alterPassword($input, $id) {

    DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      if ($input['password']) {

        $user->password = Hash::make($input['password']);

        LoggerHelper::log('AUTH', Lang::get('logs.msg.password.change', [
          'email' => $user->email, 'id' => $user->id
        ]));
      }

      $user->update();

      $throttle = $user->throttle()->first();

      if ($throttle->is_default_password) {

        $throttle->is_default_password = false;

        $throttle->update();
      }

      LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', ['resource' => Self::getTable($this->user), 'id' => $user->id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function redefinePassword($id) {

    DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      // $user->password = Hash::make(User::DEFAULT_PASSWORD);
			if ($input['password']) {

        $user->password = Hash::make($input['password']);

      }

      LoggerHelper::log('AUTH', Lang::get('logs.msg.password.redefined', [
        'email' => $user->email, 'id' => $user->id
      ]));

      $user->update();

      $throttle = $user->throttle()->first();

      // $throttle->is_default_password = true;
			$throttle->is_default_password = false;

      $throttle->update();

      LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', ['resource' => Self::getTable($this->user), 'id' => $user->id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function accessVerification($user, $is_change_password = false, $is_destroy = false) {

    if (is_null($user))
      App::abort(404, Lang::get('application.error.404.msg'));

    switch (true) {

      case !$this->user->userIsAuth($user) && !Auth::user()->hasRole('ADMIN'): // Edit and Show
      case !$this->user->userIsAuth($user) && $this->user->userMinRoleIsLessOrEqualThanAuthMinRole($user): // Edit and Show
      case !$this->user->userIsAuth($user) && $is_change_password: // Change Password
      case  $this->user->userIsAuth($user) && $is_destroy: // Destroy and Restore

        App::abort(403, Lang::get('application.error.403.msg'));

        break;
    }
  }
}
