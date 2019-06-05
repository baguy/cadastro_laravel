<?php

class FuncionarioController extends \BaseController {

	protected $funcionario;
	protected $service;

	public function __construct(Funcionario $funcionario, FuncionarioService $service){
		$this->funcionario = $funcionario;
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
		LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($this->funcionario)]));

		$input = Input::all();

		// Enviar todos os resources
		if (count($input))
		LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
			'resource'  => $this->service->getTable($this->funcionario),
			'parameter' => json_encode($input)
		]));

		// Array para Pesquisa
		$data = array(
			'funcionarios' => array('' 	  => 'SELECIONE O FUNCIONÁRIO'),
			'status' 		 => array('' 		=> 'SELECIONE STATUS','1' => "ATIVO", '2' => "INATIVO"),
		);

		return View::make('funcionario.index', compact('data'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = [
			'setor'   => array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
		];
		return View::make('funcionario.create', compact('data'));
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
		$validator = funcionarioValidator::store($input);

		if($validator->passes()){
			try{

				$this->service->store($input);

				return Redirect::route('funcionario.index')
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
				'funcionario' => Funcionario::find($id),
			];

			$atendimentos = Atendimento::all();
			// $users = User::all();
			$funcionario = $this->funcionario->withTrashed()->find($id);
			$colors = LoggerHelper::getColors();
			$icons = LoggerHelper::getIcons();

			return View::make('funcionario.show', compact(['funcionario', 'colors', 'icons', 'data', 'atendimentos']));

		}catch(Exception $e){
			return Redirect::back()
			->with('_error', Lang::get('application.msg.error.inactive-user'));
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data = [
			'funcionario' => funcionario::find($id),
			'setor'   		=> array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
		];
		return View::make('funcionario.edit', compact('data'));
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
		$validator = funcionarioValidator::update($input, $id);

		if($validator->passes()){
			try{

				$this->service->update($input, $id);
				return Redirect::route('funcionario.index', $id)
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
			return Redirect::route('funcionario.index')
			->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));
		}catch(Exception $e){
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

	/**
	* Restaurar funcionario
	* @param  int  $id
	* @return Response
	*/
	public function restore($id){
		DB::beginTransaction();

		try {

			$funcionario = $this->funcionario->withTrashed()->find($id);

			$funcionario->restore();

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}
		return Redirect::route('funcionario.index');
	}


}
