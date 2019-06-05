<?php

class SetorService extends BaseService {

	protected $setor;

  public function __construct(Setor $setor) {

    $this->setor = $setor;
  }

	/**
	 * Salvar novo setor
	 * Retorna para setorController
	 * @return Response
	 */
  public function store($input) {

		DB::beginTransaction();

		try {

			$setor = new setor($input);
			$setor->save();

			LoggerHelper::log('CREATE', Lang::get('logs.msg.create', [
				'resource'     => Self::getTable($this->setor),
				'id' 					 => $setor->id,
			]));

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}

  }

	/**
	 * Atualizar novo setor
	 * Retorna para setorController
	 * @return Response
	 */
  public function update($input, $id) {

			DB::beginTransaction();

			try {

				$setor = $this->setor->find($id);
				$setor->fill($input);

				Self::hasChanges($setor, array());

				// Atualizar tabela setor
				$setor->update();

				LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', [
					'resource'     => Self::getTable($this->setor),
					'id' 					 => $setor->id,
				]));

				DB::commit();

			} catch (Exception $e) {

				Log::warning(sprintf('Exception: %s', $e->getMessage()));

				DB::rollback();

				throw $e;
			}

  }

	/**
	 * Deletar novo setor (soft delete)
	 * Retorna para setorController
	 * @return Response
	 */
  public function destroy($id) {

		DB::beginTransaction();

		try {

			$this->setor->find($id)->delete();

			LoggerHelper::log('DESTROY', Lang::get('logs.msg.destroy', [
					'resource' => Self::getTable($this->setor),
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
	 * Restaurar novo setor
	 * Retorna para setorController
	 * @return Response
	 */
  public function restore($id) {

    DB::beginTransaction();

    try {

      $setor = $this->setor->withTrashed()->find($id);

      $setor->restore();

      LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', ['resource' => Self::getTable($this->setor), 'id' => $id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

}
