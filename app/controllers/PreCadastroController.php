<?php

class PreCadastroController extends BaseController {

	protected $preindividuo;
	protected $service;

	public function __construct(PreCadastro $preindividuo, PreCadastroService $service){
		$this->preindividuo = $preindividuo;
		$this->service = $service; // IndividuoService
		$this->beforeFilter('role:ADMIN', array('only' => array('destroy', 'restore'))); // Permissão para acessar apenas como admin
	}


	/**
	* Exibir todos os indivíduos no index
	*
	* @return View
	*/
	public function index()
	{
		LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($this->preindividuo)]));

		$input = Input::all();

		// Enviar todos os resources
		if (count($input))
		LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
			'resource'  => $this->service->getTable($this->preindividuo),
			'parameter' => json_encode($input)
		]));

		// Array para Pesquisa
		$data = array(
      'sexos' 					  	=> 	Sexo::all(),
      'tipo_estado_civil' 	=> 	MainHelper::fixArray(TipoEstadoCivil::orderBy('estado', 'asc')->get(),'id','estado'),
      'tipo_telefone'		 		=>	MainHelper::fixArray(TipoTelefone::orderBy('tipo', 'asc')->get(), 'id', 'tipo'),
      'estado'		 			 		=> 	MainHelper::fixArray(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
      'bairro'		 			 		=> 	MainHelper::fixArray(Bairro::orderBy('nome', 'asc')->get(), 'id', 'nome'),
      'cidade'					 		=> 	MainHelper::fixArray(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
		);

		return View::make('pre_cadastro.index', compact('data'));
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
	* Envia dados para IndividuoService
	* @return Response
	*/
	public function store()
	{
		$input = Input::all();
		$input['nome'] = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ',$input['nome']);

		$cpf = BaseController::searchCPF($input['cpf']);
		if(is_numeric($cpf)){
			return $cpf;
			return Redirect::back()->withInput()
			->with('_error', Lang::get('application.msg.status.individuo-cpf'));
		}else{

			$validator = IndividuoValidator::store($input);

			if($validator->passes()){
				try{

					$this->service->store($input);

						return Redirect::route('pre_cadastro.index')
						->with('_status', Lang::get('application.msg.status.individuo-created-successfully'));

				}catch(Exception $e){
					Session::flash('_old_input', Input::all());
					return Redirect::back()
					->withInput()
					->with('_error', Lang::get('application.msg.error.something-went-wrong'));
				}
			}
		}

		return Redirect::back()->withInput()
		->withErrors($validator)
		->with('_error', Lang::get('application.msg.error.validation-errors'));

	}


	/**
	* Exibir informações de indivíduo selecionado
	*
	* @param  int  $id
	* @return View
	*/
	public function show($id)
	{
		try{
			$data = [
				'individuo' 			  		=> Individuo::find($id),
				'individuo_tel'		  		=> Individuo::with('telefones')->find($id)->telefones,
				'individuo_endereco'	  => Individuo::with('endereco')->find($id)->endereco,
				'individuo_atendimento' => Individuo::with('atendimentos')->find($id)->atendimento,
			];

			$individuo = $this->individuo->withTrashed()->find($id);

			$colors = LoggerHelper::getColors();

			$icons  = LoggerHelper::getIcons();

			return View::make('pre_cadastro.show', compact(['individuo', 'colors', 'icons', 'data']));

		}catch(Exception $e){

			return Redirect::back()
			->with('_error', Lang::get('application.msg.error.inactive-user'));

		}
	}


	/**
	* Informações de formulário para editar indivíduo
	*
	* @param  int  $id
	* @return View
	*/
	public function edit($id)
	{
		$data = [
			'individuo'    				 		=> Individuo::find($id),
			'sexos' 					  			=> Sexo::all(),
			'tipo_estado_civil' 			=> MainHelper::fixArray(TipoEstadoCivil::orderBy('estado', 'asc')->get(),'id','estado'),
			'tipo_telefone'		 				=> DB::table('tipo_telefone')->orderBy('tipo', 'asc')->lists('tipo', 'id'),
			'estado'		 				 			=> DB::table('estado')->orderBy('nome', 'asc')->lists('nome', 'uf', 'id'),
			'bairro'		 				 			=> DB::table('bairro')->orderBy('nome', 'asc')->lists('nome', 'id'),
			'individuo_tel'		 		  	=> Individuo::with('telefones')->find($id)->telefones,
			'tipo_parentesco'					=> MainHelper::fixArray(TipoParentesco::orderBy('nome', 'asc')->get(),'id','nome'),
			'cidade'						 			=> DB::table('cidade')->orderBy('nome', 'asc')->where('estado_id','=', 35)->lists('nome', 'id'),
			'tipo_escolaridade'			  => MainHelper::fixArray(TipoEscolaridade::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_transporte'					=> MainHelper::fixArray(TipoTransporte::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_trabalho'					  => MainHelper::fixArray(TipoTrabalho::orderBy('id', 'asc')->get(),'id','nome'),
			'tipo_beneficio'					=> array_except(MainHelper::fixArray(TipoBeneficio::all(), 'id', 'nome'), ''),
			'tipo_credencial'					=> TipoCredencial::all(),
			'tipo_vida_diaria_assunto'=> TipoVidaDiariaAssunto::all(),
			'tipo_vida_diaria'				=> MainHelper::fixArray(TipoVidaDiaria::orderBy('id', 'asc')->get(),'id','nome'),
			'tipo_grupo_social'				=> TipoGrupoSocial::all(),
			'consequencia_queda'			=> array_except(MainHelper::fixArray(ConsequenciaQueda::all(), 'id', 'nome'), ''),
			'tipo_moradia'					  => MainHelper::fixArray(TipoMoradia::all(), 'id', 'nome'),
			'tipo_imovel'			  		  => MainHelper::fixArray(TipoImovel::all(), 'id', 'nome'),
			'tipo_renda'			  		  => MainHelper::fixArray(TipoRenda::all(), 'id', 'nome'),
			'tipo_atividade'			  	=> MainHelper::fixArray(TipoAtividade::all(), 'id', 'nome'),
			'tipo_saude'			  		  => array_except(MainHelper::fixArray(TipoSaude::all(), 'id', 'nome'), ''),
			'tipo_medicacao'			  	=> TipoMedicacao::all(),
			'causa_mobilidade'			  => array_except(MainHelper::fixArray(CausaMobilidade::all(), 'id', 'nome'), ''),
			'tipo_comunicacao'			  => array_except(MainHelper::fixArray(TipoComunicacao::all(), 'id', 'nome'), ''),
			'tipo_tecnologia_assistiva' => array_except(MainHelper::fixArray(TipoTecnologiaAssistiva::all(), 'id', 'nome'), ''),
			'tipo_informacao' 				=> MainHelper::fixArray(TipoInformacao::all(), 'id', 'nome'),
			'tipo_informacao_origem' 	=> MainHelper::fixArray(TipoInformacaoOrigem::all(), 'id', 'nome'),
			'causa_deficiencia'				=> MainHelper::fixArray(CausaDeficiencia::all(), 'id', 'nome'),
			'quando_deficiencia'			=> MainHelper::fixArray(QuandoDeficiencia::all(), 'id', 'nome'),
			'tipo_deficiencia_fisica'	=> array_except(MainHelper::fixArray(TipoDeficienciaFisica::all(), 'id', 'nome', 'asc'), ''),
			'tipo_deficiencia_auditiva'		  => array_except(MainHelper::fixArray(TipoDeficienciaAuditiva::all(), 'id', 'nome'), ''),
			'tipo_deficiencia_visual'	=> array_except(MainHelper::fixArray(TipoDeficienciaVisual::all(), 'id', 'nome'), ''),
			'tipo_deficiencia_mental'	=> array_except(MainHelper::fixArray(TipoDeficienciaMental::all(), 'id', 'nome'), ''),
			'tipo_deficiencia_psicossocial'	=> array_except(MainHelper::fixArray(TipoDeficienciaPsicossocial::all(), 'id', 'nome'), ''),
			'tipo_braille'	=> array_except(MainHelper::fixArray(TipoBraille::all(), 'id', 'nome'), ''),
		];

		$sus=null;
		$nis=null;
		$cpf=null;
		foreach( $data['individuo']->documentos as $key => $value ){
			if ( $value->tipo_documento_id == 1 ){
				$cpf = $value->numero;
			}
			if ( $value->tipo_documento_id == 2 ){
				$nis = $value->numero;
			}
			if ( $value->tipo_documento_id == 3 ){
				$sus = $value->numero;
			}
		}

		return View::make('pre_cadastro.edit', compact(['data', 'cpf', 'nis', 'sus']));
	}


	/**
	* Atualizar indivíduo
	* Envia dados para IndividuoService
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
		$input = Input::all();
		// $input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('nome'));
		$input['nome'] = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ',$input['nome']);

		$validator = IndividuoValidator::update($input, $id);

		$input['bairro'] = FormatterHelper::toUpperInput($input['bairro']);

		if ($validator->passes()) {

			try {

				$this->service->update($input, $id);

				return Redirect::route('pre_cadastro.show', $id)
				->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

			} catch (Exception $e) {
				Session::flash('_old_input', Input::all());

				return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
			}
		}

		return Redirect::route('pre_cadastro.edit', $id)
										->withInput()
										->withErrors($validator)
										->with('_error', Lang::get('application.msg.error.validation-errors'));
	}


	/**
	* Marcar indivíduo como inativo (soft delete)
	* Envia dados para IndividuoService
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		try {

			$this->service->destroy($id);

			return Redirect::route('pre_cadastro.index')
			->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

		} catch (Exception $e) {

			return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
		}
	}

	/**
	* Restaurar indivíduo
	* @param  int  $id
	* @return Response
	*/
	public function restore($id){
		DB::beginTransaction();

		try {

			$individuo = $this->preindividuo->withTrashed()->find($id);

			$individuo->restore();

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}
		return Redirect::route('pre_cadastro.index');
	}


}
