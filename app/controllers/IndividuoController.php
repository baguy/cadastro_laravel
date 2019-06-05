<?php

class IndividuoController extends BaseController {

	protected $individuo;
	protected $service;

	public function __construct(Individuo $individuo, IndividuoService $service){
		$this->individuo = $individuo;
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
		LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($this->individuo)]));

		$input = Input::all();

		// Enviar todos os resources
		if (count($input))
		LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
			'resource'  => $this->service->getTable($this->individuo),
			'parameter' => json_encode($input)
		]));

		// Array para Pesquisa
		$data = array(
			'individuos' => array('' 	  => 'SELECIONE O INDIVÍDUO'),
			'status' 		 => array('' 		=> 'SELECIONE','1' => "ATIVO", '2' => "INATIVO"),
			'sexo'			 => array(''    => 'SELECIONE O SEXO', '1' => 'FEMININO', '2' => 'MASCULINO', '3' => 'OUTRO'),
			'sim_nao'	   => array(''    => 'SELECIONE', '1' => 'SIM', '2' => 'NÃO'),
		);

		return View::make('individuos.index', compact('data'));
	}


	/**
	* Informações de formulário para criação de indivíduos
	*
	* @return View
	*/
	public function create()
	{
		$data = [
			'sexos' 					  	=> 	Sexo::all(),
			'tipo_estado_civil' 	=> 	MainHelper::fixArray(TipoEstadoCivil::orderBy('estado', 'asc')->get(),'id','estado'),
			'tipo_telefone'		 		=>	MainHelper::fixArray(TipoTelefone::orderBy('tipo', 'asc')->get(), 'id', 'tipo'),
			'estado'		 			 		=> 	MainHelper::fixArray(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
			'bairro'		 			 		=> 	MainHelper::fixArray(Bairro::orderBy('nome', 'asc')->get(), 'id', 'nome'),
			'cidade'					 		=> 	MainHelper::fixArray(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
			'ondeEstou' 				  => 1,
		];
		return View::make('individuos.create', compact('data'));
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

					if( $input['action'] == 'save' ) {

						return Redirect::route('individuos.index')
						->with('_status', Lang::get('application.msg.status.individuo-created-successfully'));
					}else{
						$individuo = Individuo::where('nome', '=', $input['nome'])->get();

	          return Redirect::route('atendimento.create')->with(['individuo' => $individuo[0]]);
					}

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

			return View::make('individuos.show', compact(['individuo', 'colors', 'icons', 'data']));

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
			'bairro'		 				 			=> DB::table('bairro')->orderBy('nome', 'asc')->lists('nome', 'id'),
			'cidade'						 			=> DB::table('cidade')->orderBy('nome', 'asc')->where('estado_id','=', 35)->lists('nome', 'id'),
			'estado'		 				 			=> DB::table('estado')->orderBy('nome', 'asc')->lists('nome', 'uf', 'id'),
			'tipo_estado_civil' 			=> MainHelper::fixArray(TipoEstadoCivil::orderBy('estado', 'asc')->get(),'id','estado'),
			'tipo_telefone'		 				=> DB::table('tipo_telefone')->orderBy('tipo', 'asc')->lists('tipo', 'id'),
			'individuo_tel'		 		  	=> Individuo::with('telefones')->find($id)->telefones,
			'causa_mobilidade'			  => array_except(MainHelper::fixArray(CausaMobilidade::all(), 'id', 'nome'), ''),
			'consequencia_queda'			=> array_except(MainHelper::fixArray(ConsequenciaQueda::all(), 'id', 'nome'), ''),
			'causa_deficiencia'				=> MainHelper::fixArray(CausaDeficiencia::all(), 'id', 'nome'),
			'quando_deficiencia'			=> MainHelper::fixArray(QuandoDeficiencia::all(), 'id', 'nome'),
			'tipo_parentesco'					=> MainHelper::fixArray(TipoParentesco::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_escolaridade'			  => MainHelper::fixArray(TipoEscolaridade::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_trabalho'					  => MainHelper::fixArray(TipoTrabalho::orderBy('id', 'asc')->get(),'id','nome'),
			'tipo_transporte'					=> MainHelper::fixArray(TipoTransporte::orderBy('nome', 'asc')->get(),'id','nome'),
			'tipo_beneficio'					=> array_except(MainHelper::fixArray(TipoBeneficio::all(), 'id', 'nome'), ''),
			'tipo_credencial'					=> TipoCredencial::all(),
			'tipo_vida_diaria_assunto'=> TipoVidaDiariaAssunto::all(),
			'tipo_vida_diaria'				=> MainHelper::fixArray(TipoVidaDiaria::orderBy('id', 'asc')->get(),'id','nome'),
			'tipo_grupo_social'				=> TipoGrupoSocial::all(),
			'tipo_moradia'					  => MainHelper::fixArray(TipoMoradia::all(), 'id', 'nome'),
			'tipo_imovel'			  		  => MainHelper::fixArray(TipoImovel::all(), 'id', 'nome'),
			'tipo_renda'			  		  => MainHelper::fixArray(TipoRenda::all(), 'id', 'nome'),
			'tipo_atividade'			  	=> MainHelper::fixArray(TipoAtividade::all(), 'id', 'nome'),
			'tipo_saude'			  		  => array_except(MainHelper::fixArray(TipoSaude::all(), 'id', 'nome'), ''),
			'tipo_medicacao'			  	=> TipoMedicacao::all(),
			'tipo_comunicacao'			  => array_except(MainHelper::fixArray(TipoComunicacao::all(), 'id', 'nome'), ''),
			'tipo_tecnologia_assistiva' 		=> array_except(MainHelper::fixArray(TipoTecnologiaAssistiva::all(), 'id', 'nome'), ''),
			'tipo_informacao' 				=> MainHelper::fixArray(TipoInformacao::all(), 'id', 'nome'),
			'tipo_informacao_origem' 	=> MainHelper::fixArray(TipoInformacaoOrigem::all(), 'id', 'nome'),
			'tipo_deficiencia_fisica'	=> MainHelper::fixArray(TipoDeficienciaFisica::all(), 'id', 'nome'),
			'tipo_deficiencia_auditiva'     => MainHelper::fixArray(TipoDeficienciaAuditiva::all(), 'id', 'nome'),
			'tipo_deficiencia_visual'	=> MainHelper::fixArray(TipoDeficienciaVisual::all(), 'id', 'nome'),
			'tipo_deficiencia_mental'	=> MainHelper::fixArray(TipoDeficienciaMental::all(), 'id', 'nome'),
			'tipo_deficiencia_psicossocial'	=> MainHelper::fixArray(TipoDeficienciaPsicossocial::all(), 'id', 'nome'),
			'tipo_braille'						=> MainHelper::fixArray(TipoBraille::all(), 'id', 'nome'),
			'parentes'								=> Individuo::with('parentescos')->find($id)->parentescos,
			'deficiencias' 						=> Individuo::with('deficiencias')->find($id)->deficiencias,
			'parentes' 								=> Individuo::with('parentescos')->find($id)->parentescos,
		];

		$deficiencia_fisica_individuo = []; $deficiencia_auditiva_individuo = []; $deficiencia_visual_individuo = [];
		$deficiencia_psicossocial_individuo = []; $deficiencia_mental_individuo = []; $key2=0;
		foreach($data['deficiencias'] as $key => $value){
			if($value->fisica_id != ''){
				$deficiencia_fisica_individuo[$key2] = $value;
				$key2 += 1;
			}
		}
		$key2=0;
		foreach($data['deficiencias'] as $key => $value){
			if($value->auditiva_id != ''){
				$deficiencia_auditiva_individuo[$key2] = $value;
				$key2 += 1;
			}
		}
		$key2=0;
		foreach($data['deficiencias'] as $key => $value){
			if($value->mental_id != ''){
				$deficiencia_mental_individuo[$key2] = $value;
				$key2 += 1;
			}
		}
		$key2=0;
		foreach($data['deficiencias'] as $key => $value){
			if($value->psicossocial_id != ''){
				$deficiencia_psicossocial_individuo[$key2] = $value;
				$key2 += 1;
			}
		}
		$key2=0;
		foreach($data['deficiencias'] as $key => $value){
			if($value->visual_id != ''){
				$deficiencia_visual_individuo[$key2] = $value;
				$key2 += 1;
			}
		}

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

		return View::make('individuos.edit', compact(['data', 'cpf', 'nis', 'sus', 'deficiencia_fisica_individuo',
																									'deficiencia_auditiva_individuo', 'deficiencia_mental_individuo',
																									'deficiencia_psicossocial_individuo', 'deficiencia_visual_individuo'
																								]));
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

				return Redirect::route('individuos.show', $id)
				->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

			} catch (Exception $e) {
				Session::flash('_old_input', Input::all());

				return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
			}
		}

		return Redirect::route('individuos.edit', $id)
										->withInput()
										->withErrors($validator)
										->with('_error', Lang::get('application.msg.error.validation-errors'));
	}


	/**
	* Informações de formulário para editar indivíduo
	*
	* @param  int  $id
	* @return View
	*/
	public function parecer($id)
	{
		$data = [
			'individuo' => Individuo::find($id),
			'parecer' 	=> Individuo::with('parecerTecnico')->find($id)->parecerTecnico
		];

		return View::make('individuos.parecer', compact(['data']));
	}


	public function parecer_update($id)
	{
		$input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('nome'));

		$validator = IndividuoValidator::update_parecer($input, $id);

		if ($validator->passes()) {

			try {
		$input['parecer'] = array_filter($input['parecer']);

				$this->service->update_parecer($input, $id);

				return Redirect::route('individuos.show', $id)
				->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

			} catch (Exception $e) {
				Session::flash('_old_input', Input::all());

				return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
			}
		}

		return Redirect::route('individuos.parecer', $id)
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

			return Redirect::route('individuos.index')
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

			$individuo = $this->individuo->withTrashed()->find($id);

			$individuo->restore();

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}
		return Redirect::route('individuos.index');
	}


	/**
  * Função necessária para gerar excel
  * Gera view com objetos que serão transferidos para o arquivo excel
  * @return view
  */

  public function report() {

    $individuo = parent::getElements('individuos', true, 'get');
		// return $individuo;
    return View::make('individuos.report', compact('individuo'));
  }


	/**
  * Função necessária para gerar excel
  * Aplicação do filtro e envio do objeto Individuo para gerar excel (IndividuoService)
  */

  public function export($type, $ano, $status, $sexo, $bairro, $mobilidade, $def_fisica, $def_auditiva, $def_visual, $def_mental, $def_psicossocial,
													$parecer, $interditado, $data_nascimento, $data_cadastro) {
    $individuos = parent::getElements('individuos', true, 'get');

		$result = IndividuoController::applyFilter($individuos, $ano, $status, $sexo, $bairro, $mobilidade, $def_fisica, $def_auditiva, $def_visual,
							$def_mental, $def_psicossocial, $parecer, $interditado, $data_nascimento, $data_cadastro);

    $this->service->export($result, $type);
  }


	/**
	* Aplicar filtros quando gerar arquivo excel
	*
	* @return object filtrado
	*/

	public function applyFilter($individuo, $ano, $status, $sexo, $bairro, $mobilidade, $def_fisica, $def_auditiva, $def_visual,
															$def_mental, $def_psicossocial, $parecer,	$interditado, $data_nascimento, $data_cadastro){
		$result=[];

		$contador=0;
		$verdadeDesafio=0;
		if(!is_numeric($bairro)){
			$contador+=1;
		}
		if($ano != 0){
			$contador+=1;
		}
		if($status != 0){
			$contador+=1;
		}
		if($sexo != 0){
			$contador+=1;
		}
		if($mobilidade != 0){
			$contador+=1;
		}
		if($def_fisica != 0){
			$contador+=1;
		}
		if($def_auditiva != 0){
			$contador+=1;
		}
		if($def_visual != 0){
			$contador+=1;
		}
		if($def_mental != 0){
			$contador+=1;
		}
		if($def_psicossocial != 0){
			$contador+=1;
		}
		if($parecer != 0){
			$contador+=1;
		}
		if($interditado != 0){
			$contador+=1;
		}
		if($data_nascimento != 0){
			$contador+=1;
		}
		if($data_cadastro != 0){
			$contador+=1;
		}

		foreach ($individuo as $key => $value) {
			$verdadeDesafio = 0;
			if($contador > 0){
				if(!is_numeric($bairro)){
					if(isset($value->endereco->bairro)){
						if($value->endereco->bairro == $bairro){
							$verdadeDesafio+=1;
						}
					}
				}
				if($ano != 0){
					$data = date('Y-m-d', strtotime("-60 years"));
					if($ano == 1){
						if( (FormatterHelper::dateToMySQL($value->data_nascimento) <= $data) ){
							$verdadeDesafio+=1;
						}
					}
					if($ano == 2){
						if( (FormatterHelper::dateToMySQL($value->data_nascimento) > $data) ){
							$verdadeDesafio+=1;
						}
					}
				}
				if($sexo != 0){
					if($value->sexo_id == $sexo){
						$verdadeDesafio+=1;
					}
				}
				if($status != 0){
					if($status == 1){
	          if($value->deleted_at == ''){
	            $verdadeDesafio+=1;
	          }
					}elseif($status == 2){
						if($value->deleted_at != ''){
	            $verdadeDesafio+=1;
	          }
					}
        }
				if($mobilidade != 0){
					if($mobilidade == 1){
						if(isset($value->mobilidades[0])){
							$verdadeDesafio+=1;
						}
					}
					if($mobilidade == 2){
						if(!isset($value->mobilidades[0])){
							$verdadeDesafio+=1;
						}
					}
				}
				if($def_fisica != 0){
					if($def_fisica == 1){
						if(isset($value->deficienciaFisica[0])){
							$verdadeDesafio+=1;
						}
					}
					if($def_fisica == 2){
						if(!isset($value->deficienciaFisica[0])){
							$verdadeDesafio+=1;
						}
					}
				}
				if($def_mental != 0){
					if($def_mental == 1){
						if(isset($value->deficienciaMental[0])){
							$verdadeDesafio+=1;
						}
					}
					if($def_mental == 2){
						if(!isset($value->deficienciaMental[0])){
							$verdadeDesafio+=1;
						}
					}
				}
				if($def_psicossocial != 0){
					if($def_psicossocial == 1){
						if(isset($value->deficienciaPsicossocial[0])){
							$verdadeDesafio+=1;
						}
					}
					if($def_psicossocial == 2){
						if(!isset($value->deficienciaPsicossocial[0])){
							$verdadeDesafio+=1;
						}
					}
				}
				if($def_auditiva != 0){
					if($def_auditiva == 1){
						if(isset($value->deficienciaAuditiva->id)){
							$verdadeDesafio+=1;
						}
					}
					if($def_auditiva == 2){
						if(!isset($value->deficienciaAuditiva->id)){
							$verdadeDesafio+=1;
						}
					}
				}
				if($def_visual != 0){
					if($def_visual == 1){
						if(isset($value->deficienciaVisual->id)){
							$verdadeDesafio+=1;
						}
					}
					if($def_visual == 2){
						if(!isset($value->deficienciaVisual->id)){
							$verdadeDesafio+=1;
						}
					}
				}
				if($parecer != 0){
					if($parecer == 1){
						if(isset($value->parecerTecnico->id)){
							$verdadeDesafio+=1;
						}
					}
					if($parecer == 2){
						if(!isset($value->parecerTecnico->id)){
							$verdadeDesafio+=1;
						}
					}
				}
				if($interditado != 0){
					if($interditado == 1){
						if(isset($value->interditado->id)){
							$verdadeDesafio+=1;
						}
					}
					if($interditado == 2){
						if(!isset($value->interditado->id)){
							$verdadeDesafio+=1;
						}
					}
				}
				if($data_nascimento != 0){
					$data_individuo = FormatterHelper::dateToMySQL($value->data_nascimento);
					if($data_nascimento == $data_individuo){
						$verdadeDesafio+=1;
					}
				}
				if($data_cadastro != 0){
					$data_individuo = $value->created_at->format('Y-m-d');
					if($data_cadastro == $data_individuo){
						$verdadeDesafio+=1;
					}
				}
				if($verdadeDesafio == $contador){
					$result[$key] = $value;
				}
			}else{
				$result = $individuo;
			}
		}

		return $result;

	}


	public function pdf($id){

		$individuo = Individuo::find($id);

		$pdf = PDF::loadView('individuos.pdf', compact('individuo'));
		return $pdf->download('individuo_'.$individuo->nome.'.pdf');
	}


}
