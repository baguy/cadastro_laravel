<?php

class FuncionarioService extends BaseService {

	protected $funcionario;

  public function __construct(Funcionario $funcionario) {

    $this->funcionario = $funcionario;
  }

	/**
	 * Salvar novo funcionario
	 * Retorna para funcionarioController
	 * @return Response
	 */
  public function store($input) {

		DB::beginTransaction();

		try {

			$funcionario = Funcionario::create($input);

			foreach ($input['setor_id'] as $setor) {
				$funcionario->setor()->attach($setor);
			}

			$funcionario->save();

			LoggerHelper::log('CREATE', Lang::get('logs.msg.create', [
				'resource'     => Self::getTable($this->funcionario),
				'id' 					 => $funcionario->id,
			]));

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}

  }

	/**
	 * Atualizar novo funcionario
	 * Retorna para funcionarioController
	 * @return Response
	 */
  public function update($input, $id) {

			DB::beginTransaction();

			try {

				$funcionario = $this->funcionario->find($id);
				$funcionario->fill($input);

				Self::hasChanges($funcionario, array());

				// Atualizar tabela funcionario
				$funcionario->update();

				LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', [
					'resource'     => Self::getTable($this->funcionario),
					'id' 					 => $funcionario->id,
				]));

				DB::commit();

			} catch (Exception $e) {

				Log::warning(sprintf('Exception: %s', $e->getMessage()));

				DB::rollback();

				throw $e;
			}

  }

	/**
	 * Deletar novo funcionario (soft delete)
	 * Retorna para funcionarioController
	 * @return Response
	 */
  public function destroy($id) {

		DB::beginTransaction();

		try {

			$this->funcionario->find($id)->delete();

			LoggerHelper::log('DESTROY', Lang::get('logs.msg.destroy', [
					'resource' => Self::getTable($this->funcionario),
					'id' 			 => $id]
			));

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}

  }

	/**
	 * Restaurar novo funcionario
	 * Retorna para funcionarioController
	 * @return Response
	 */
  public function restore($id) {

    DB::beginTransaction();

    try {

      $funcionario = $this->funcionario->withTrashed()->find($id);

      $funcionario->restore();

      LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', ['resource' => Self::getTable($this->funcionario), 'id' => $id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

}
