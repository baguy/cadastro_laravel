<?php

class SetorController extends \BaseController {

	protected $setor;
	protected $service;

	public function __construct(Setor $setor, SetorService $service){
		$this->setor = $setor;
		$this->service = $service;

		$this->beforeFilter('role:ADMIN', array('only' => array('destroy', 'restore')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
				LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($this->setor)]));

				$input = Input::all();

				// Enviar todos os resources
				if (count($input))
				LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
					'resource'  => $this->service->getTable($this->setor),
					'parameter' => json_encode($input)
				]));

				// Array para Pesquisa
				$data = array(
					'funcionarios' => array('' 	  => 'SELECIONE O SETOR'),
					'status' 		 => array('' 		=> 'SELECIONE STATUS','1' => "ATIVO", '2' => "INATIVO"),
				);

		    return View::make('setor.index', compact('data'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('setor.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = FormatterHelper::filter(Input::all(), array('name'));
		$input = Input::all();
		$validator = SetorValidator::store($input);

		if($validator->passes()){
			try{

				$this->service->store($input);

				return Redirect::route('setor.index')
				->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

			}catch(Exception $e){
				Session::flash('_old_input', Input::all());
				return Redirect::back()->withInput()
				->with('_error', Lang::get('application.msg.error.something-went-wrong'));
			}
		}
		return Redirect::back()->withInput()
		->withErrors($validator)
		->with('_error', Lang::get('application.msg.error.validation-errors'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{
			$data = [
				'setor' => Setor::find($id),
			];
			$atendimentos = $data['setor']->atendimento;

			$contadorFuncionario = $data['setor']->funcionario->count();
			$contadorAtendimentoAberto = 0;
		  foreach($data['setor']->atendimento as $a => $atendimento){
				if($atendimento->status_id == 1){
					$contadorAtendimentoAberto += 1;
				}
			}
			$contadorAtendimentoPendente = 0;
			foreach($data['setor']->atendimento as $a => $atendimento){
				if($atendimento->status->id == 2){
					$contadorAtendimentoPendente += 1;
				}
			}
			$contadorAtendimentoEncerrado = 0;
			foreach($data['setor']->atendimento as $a => $atendimento){
				if($atendimento->status->id == 3){
					$contadorAtendimentoEncerrado += 1;
				}
			}

			$setor = $this->setor->withTrashed()->find($id);
			$colors = LoggerHelper::getColors();
			$icons = LoggerHelper::getIcons();

			return View::make('setor.show', compact(['setor', 'colors', 'icons', 'data', 'contadorFuncionario', 'contadorAtendimentoAberto', 'contadorAtendimentoPendente', 'contadorAtendimentoEncerrado']));

		}catch(Exception $e){
			return Redirect::back()
			->with('_error', Lang::get('application.msg.error.inactive-user'));
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function edit($id)
	{
		$data = [
			'setor' => Setor::find($id),
		];
		return View::make('setor.edit', compact('data'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('nome'));
		$validator = SetorValidator::update($input, $id);

		if($validator->passes()){
			try{

				$this->service->update($input, $id);
				return Redirect::route('setor.index', $id)
				->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

			}catch(Exception $e){
				Session::flash('_old_input', Input::all());
				return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try{
			$this->service->destroy($id);
			return Redirect::route('setor.index')
			->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));
		}catch(Exception $e){
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

	/**
	* Restaurar Setor
	* @param  int  $id
	* @return Response
	*/
	public function restore($id){
		DB::beginTransaction();

		try {

			$setor = $this->setor->withTrashed()->find($id);

			$setor->restore();

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}
		return Redirect::route('setor.index');
	}


}
