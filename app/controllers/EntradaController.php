<?php

class EntradaController extends \BaseController {

	protected $entrada;

	public function __construct(Entrada $entrada){
		$this->entrada = $entrada;
		$this->beforeFilter('role:ADMIN', array('only' => array('destroy', 'restore'))); // Permissão para acessar apenas como admin
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index()
	{
				// Array para Pesquisa
				$data = array(
					'individuos' => array('' => 'SELECIONE O INDIVÍDUO'),
		      'categorias' => array_except(MainHelper::fixArray(TipoAtendimento::all(), 'id', 'tipo'), ''),
		      'status' => MainHelper::fixarray(Status::all(), 'id', 'tipo', 'SELECIONE O STATUS')
				);

				$id = Auth::user()->id;

				try{

					$aberto = [];
					$statusA = 1;
					$aberto = MainHelper::contadorView($aberto, $statusA);
					$pendente = [];
					$statusP = 2;
					$pendente = MainHelper::contadorView($pendente, $statusP);

					$atendimentos = $aberto + $pendente;

					$individuo = User::withTrashed()->find($id);

					$colors = LoggerHelper::getColors();

					$icons  = LoggerHelper::getIcons();

					return View::make('entrada.index', compact(['individuo', 'colors', 'icons', 'data', 'atendimentos']));

				}catch(Exception $e){

					return Redirect::to('users/'.Auth::user()->id)
					->with('_error', Lang::get('application.msg.error.datatable'));

				}
	}


	/**
	 * Exibe atendimentos em aberto de determinado setor
	 *
	 * @return View
	 */
	public function aberto()
	{

		try{

		$id = Auth::user()->id;

		$aberto = [];
		$status = 1;

		$aberto = MainHelper::contadorView($aberto, $status);

			$individuo = User::withTrashed()->find($id);

			$colors = LoggerHelper::getColors();

			$icons  = LoggerHelper::getIcons();

			return View::make('entrada.aberto', compact(['individuo', 'colors', 'icons', 'aberto']));

		}catch(Exception $e){

			return Redirect::to('users/'.Auth::user()->id)
			->with('_error', Lang::get('application.msg.error.datatable'));

		}

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function pendente()
	{
		$id = Auth::user()->id;

		try{

			$pendente = [];
			$status = 2;

			$pendente = MainHelper::contadorView($pendente, $status);

			$individuo = User::withTrashed()->find($id);

			$colors = LoggerHelper::getColors();

			$icons  = LoggerHelper::getIcons();

			return View::make('entrada.pendente', compact(['individuo', 'colors', 'icons', 'pendente']));

		}catch(Exception $e){

			return Redirect::to('users/'.Auth::user()->id)
			->with('_error', Lang::get('application.msg.error.datatable'));

		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function encerrado()
	{
		$id = Auth::user()->id;

		try{

			$encerrado = [];
			$status = 3;

			$encerrado = MainHelper::contadorView($encerrado, $status);

			$individuo = User::withTrashed()->find($id);

			$colors = LoggerHelper::getColors();

			$icons  = LoggerHelper::getIcons();

			return View::make('entrada.encerrado', compact(['individuo', 'colors', 'icons', 'encerrado']));

		}catch(Exception $e){

			return Redirect::to('users/'.Auth::user()->id)
			->with('_error', Lang::get('application.msg.error.datatable'));

		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 * Soft delete
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$this->service->destroy($id);

			return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

		} catch (\Exception $e) {
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

	public function restore($id) {
		try {
			$this->service->restore($id);

			return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

		} catch (\Exception $e) {
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

}
