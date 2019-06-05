<?php

class MapaIndividuoController extends BaseController {

	protected $mapa;
	protected $service;

	public function __construct(MapaIndividuo $mapa, MapaIndividuoService $service){
		$this->mapa = $mapa;
		$this->service = $service;
	}

	/**
	* Exibir todos os indivíduos no index
	*
	* @return View
	*/
	public function index()
	{
		LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($this->mapa)]));

		$input = Input::all();

		// Enviar todos os resources
		if (count($input))
		LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
			'resource'  => $this->service->getTable($this->mapa),
			'parameter' => json_encode($input)
		]));

		// Array para Pesquisa
		$data = array(
			'individuos' => array('' 	  => 'SELECIONE O INDIVÍDUO'),
			'status' 		 => array('' 		=> 'SELECIONE','1' => "ATIVO", '2' => "INATIVO"),
			'sexo'			 => array(''    => 'SELECIONE O SEXO', '1' => 'FEMININO', '2' => 'MASCULINO', '3' => 'OUTRO'),
			'sim_nao'    => array(''    => 'SELECIONE', '1' => 'SIM', '2' => 'NÃO'),
		);

		return View::make('mapa_individuo.index', compact('data'));
	}


	/**
	* Informações de formulário para criação de indivíduos
	*
	* @return View
	*/
	public function create()
	{
	}

	/**
	* Salvar novo indivíduo
	* Envia dados para mapaService
	* @return Response
	*/
	public function store()
	{
	}


	/**
	* Exibir informações de indivíduo selecionado
	*
	* @param  int  $id
	* @return View
	*/
	public function show($id)
	{
	}


	/**
	* Informações de formulário para editar indivíduo
	*
	* @param  int  $id
	* @return View
	*/
	public function edit($id)
	{
	}


	/**
	* Atualizar indivíduo
	* Envia dados para mapaService
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
	}


	/**
	* Marcar indivíduo como inativo (soft delete)
	* Envia dados para mapaService
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		try {
			$this->service->destroy($id);

			return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

		} catch (Exception $e) {
			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

	/**
	* Restaurar indivíduo
	* Envia dados para mapaService
	* @param  int  $id
	* @return Response
	*/
	public function restore($id){

		try {
			$this->service->restore($id);

			return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

		} catch (Exception $e) {}
		return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
	}

}
