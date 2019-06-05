<?php

class PreCadastroService extends BaseService {

	protected $individuo;

  public function __construct(PreCadastro $individuo) {
    $this->individuo = $individuo;
  }

	/**
	 * Salvar novo indivíduo
	 * Retorna para IndividuoController
	 * @return Response
	 */
  public function store($input) {

		DB::beginTransaction();

		try {

			$individuo = new PreCadastro($input);
			$individuo->pre_cadastro = 1;
			$individuo->save();

			// TELEFONE
			foreach ($input['tipo_telefone'] as $offset => $telefone) {
				$telefone = new Telefone([
												'tipo_telefone_id' => $input['tipo_telefone'][$offset],
												'ramal' 					 => $input['ramal'][$offset],
												'numero' 					 => $input['telefone'][$offset]
												]);
				$telefone->individuo()->associate($individuo)->save();
			}

			// CPF
			$cpf = new Documento([
											'tipo_documento_id' => 1,
											'numero' 					  => $input['cpf'],
											]);
			$cpf->individuo()->associate($individuo)->save();

			// ESTADO CIVIL
			// $estadoCivil = new EstadoCivil($input);
			// $estadoCivil->tipo_estado_civil_id = $input['tipo_estado_civil'];
			// $estadoCivil->individuo()->associate($individuo)->save();

			// ENDEREÇO
			// $endereco = new Endereco($input);
			// $endereco->bairro	  		= $input['bairro'];
			// $input['bairro'] 				= FormatterHelper::bairroId($input['bairro'], $input['cidade']);
			// $input['cidade'] 				= FormatterHelper::cidadeId($input['cidade']);
			// $endereco->cidade_id 		= $input['cidade'];
			// if( is_numeric($input['bairro']) ){
			// 	$endereco->bairro_id	= $input['bairro'];
			// }
			//
			// $endereco->individuo()->associate($individuo)->save();

			LoggerHelper::log('CREATE', Lang::get('logs.msg.create', [
				'resource'     => Self::getTable($this->individuo),
				'id' 					 => $individuo->id,
			]));

			DB::commit();

		} catch (Exception $e) {

			Log::warning(sprintf('Exception: %s', $e->getMessage()));

			DB::rollback();

			throw $e;
		}

  }

	/**
	 * Atualizar novo indivíduo
	 * Retorna para IndividuoController@update
	 * @return Response
	 */
  public function update($input, $id) {

			DB::beginTransaction();

			try {

				$individuo 							= $this->individuo->find($id);
				$individuo_tel 					= $this->individuo->with('telefones')->find($id)->telefones;
				$individuo_doc 					= $this->individuo->with('documentos')->find($id)->documentos;
				$individuo_parente 			= $this->individuo->with('parentescos')->find($id)->parentescos;
				$individuo_estado_civil = $this->individuo->with('estadoCivil')->find($id)->estadoCivil;
				$individuo_endereco     = $this->individuo->with('endereco')->find($id)->endereco;
				$individuo_escolaridade = $this->individuo->with('escolaridade')->find($id)->escolaridade;
				$individuo_trabalho			= $this->individuo->with('trabalho')->find($id)->trabalho;
				$individuo_beneficio		= $this->individuo->with('beneficios')->find($id)->beneficios;
				$individuo_credencial		= $this->individuo->with('credenciais')->find($id)->credenciais;
				$individuo_vidaDiaria 	= $this->individuo->with('vidaDiaria')->find($id)->vidaDiaria;
				$individuo_grupoSocial 	= $this->individuo->with('grupoSociais')->find($id)->grupoSociais;
				$individuo_queda 				= $this->individuo->with('quedas')->find($id)->quedas;
				$individuo_moradia			= $this->individuo->with('moradia')->find($id)->moradia;
				$individuo_renda 				= $this->individuo->with('renda')->find($id)->renda;
				$individuo_interditado 	= $this->individuo->with('interditado')->find($id)->interditado;
				$individuo_esporte 			= $this->individuo->with('esporte')->find($id)->esporte;
				$individuo_cultural 		= $this->individuo->with('cultural')->find($id)->cultural;
				$individuo_saude				= $this->individuo->with('saudes')->find($id)->saudes;
				$individuo_medicacao		= $this->individuo->with('medicacao')->find($id)->medicacao;
				$individuo_acompanhamento	= $this->individuo->with('acompanhamento')->find($id)->acompanhamento;
				$individuo_mobilidade	  = $this->individuo->with('mobilidades')->find($id)->mobilidades;
				$individuo_comunicacao	= $this->individuo->with('comunicacao')->find($id)->comunicacao;
				$individuo_tecassistiva	= $this->individuo->with('tecnologiaAssistiva')->find($id)->tecnologiaAssistiva;
				$individuo_informacao 	= $this->individuo->with('informacao')->find($id)->informacao;
				$individuo_sugestao   	= $this->individuo->with('sugestao')->find($id)->sugestao;
				$individuo_deficiencia_fisica	= $this->individuo->with('deficienciaFisica')->find($id)->deficienciaFisica;
				$individuo_deficiencia_visual	= $this->individuo->with('deficienciaVisual')->find($id)->deficienciaVisual;
				$individuo_deficiencia_psicossocial	= $this->individuo->with('deficienciaPsicossocial')->find($id)->deficienciaPsicossocial;
				$individuo_deficiencia_mental	= $this->individuo->with('deficienciaMental')->find($id)->deficienciaMental;
				$individuo_deficiencia_auditiva	= $this->individuo->with('deficienciaAuditiva')->find($id)->deficienciaAuditiva;
				$individuo_ubs_cras		  = $this->individuo->with('ubsCras')->find($id)->ubsCras;


				$individuo->fill($input);


				// Estado civil — atualizar / criar
				if(isset($individuo_estado_civil)){
					$individuo_estado_civil->tipo_estado_civil_id = $input['tipo_estado_civil'];
					$individuo_estado_civil->update();
				}else{
					$estadoCivil = new EstadoCivil($input);
					$estadoCivil->tipo_estado_civil_id = $input['tipo_estado_civil'];
					$estadoCivil->individuo()->associate($individuo)->save();
				}


				// Documentos
				// CPF
				foreach( $individuo_doc as $key => $value ){
					if( $value->tipo_documento_id == 1 ){
						$value->numero = $input['cpf'];
						$value->update();
					}
				}

				$individuo_nis = 0; $individuo_sus = 0;
				foreach( $individuo_doc as $key => $value ){
					if( $value->tipo_documento_id == 2 ){
						$individuo_nis = $input['nis'];
					}
					if( $value->tipo_documento_id == 3 )
						$individuo_sus = $input['sus'];
				}

				// NIS
				if(!empty($input['nis'])){
					if($individuo_nis != 0){
						foreach( $individuo_doc as $key => $value ){
								if( $value->tipo_documento_id == 2 ){
									$value->numero = $individuo_nis;
									$value->update();
								}
							}
						}
					else{
						$nis = new Documento($input);
								$nis->tipo_documento_id = 2;
								$nis->numero = $input['nis'];
								$nis->individuo()->associate($individuo)->save();
					}
				}

			// SUS
			if(!empty($input['sus'])){
				if($individuo_sus != 0){
					foreach( $individuo_doc as $key => $value ){
							if( $value->tipo_documento_id == 3 ){
								$value->numero = $individuo_sus;
								$value->update();
							}
						}
					}
				else{
					$sus = new Documento($input);
							$sus->tipo_documento_id = 3;
							$sus->numero = $input['nis'];
							$sus->individuo()->associate($individuo)->save();
				}
			}

				Self::hasChanges($individuo, array());

				// Atualizar tabela indivíduo
				$individuo->update();


				// Endereço
				if( isset($individuo_endereco) ){
					$individuo_endereco = $this->individuo->with('endereco')->find($id)->endereco;
					$individuo_endereco->fill($input);
					Self::hasChanges($individuo_endereco, array());

					$input['cidade'] = FormatterHelper::cidadeId($input['cidade']);
					$individuo_endereco->cidade_id = $input['cidade'];

					// SE bairro inserido no campo texto for compatível com bairro no banco de dados de Caraguatatuba,
					// salva a ID e o bairro digitado
					// SENÃO salva apenas o bairro digitado
					if( is_numeric($input['bairro']) ){
						$individuo_endereco->bairro_id = $input['bairro'];
						$individuo_endereco->bairro    = FormatterHelper::bairroId($input['bairro'], $input['cidade']);
					}else{
						$individuo_endereco->bairro = $input['bairro'];
					}
					$individuo_endereco->update();
					}else{
						$endereco = new Endereco($input);
						$endereco->bairro	  		= $input['bairro'];
						$input['bairro'] 				= FormatterHelper::bairroId($input['bairro'], $input['cidade']);
						$input['cidade'] 				= FormatterHelper::cidadeId($input['cidade']);
						$endereco->cidade_id 		= $input['cidade'];
						if( is_numeric($input['bairro']) ){
							$endereco->bairro_id	= $input['bairro'];
						}

					$endereco->individuo()->associate($individuo)->save();
				}


 				// Telefone
				foreach ($individuo_tel as $key => $telefone) {
					if (isset($input['telefone'][$key])) {
						$telefone->numero = $input['telefone'][$key];
						$telefone->ramal  = ($input['ramal'][$key] != '') ? $input['ramal'][$key] : null;
						$telefone->tipo_telefone_id = $input['tipo_telefone'][$key];

						$telefone->update();
					}else{
						$telefone->delete();
					}
				}
				if (count($individuo->telefones) < count($input['telefone']) ) {
					foreach ($input['telefone'] as $key => $telefone) {
						if (!isset($individuo->telefones[$key])) {
							$tel = new Telefone(array('numero' => $telefone, 'ramal' => $input['ramal'][$key], 'tipo_telefone_id' => $input['tipo_telefone'][$key]));
							$tel->individuo()->associate($individuo)->save();
						}
					}
				}


				// Parentesco
				foreach ($individuo_parente as $key => $parente) {
					if ( isset($input['nome_parente'][$key]) ) {
						$parente->nome = $input['nome_parente'][$key];
						$parente->telefone = ($input['telefone_parente'][$key] != '') ? $input['telefone_parente'][$key] : null;
						$parente->tipo_parentesco_id = $input['tipo_parentesco_id'][$key];

						$parente->update();
					}else{
						$parente->delete();
					}
				}
				if (count($individuo->parentescos) < count($input['nome_parente']) ) {
					if( $input['nome_parente'][0] != '' ){
						foreach ($input['nome_parente'] as $key => $parente) {
							if (!isset($individuo->parentescos[$key])) {
								$parente = new Parentesco(array('telefone' => $input['telefone_parente'][$key], 'nome' => $parente, 'tipo_parentesco_id' => $input['tipo_parentesco_id'][$key]));
								$parente->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Estudo — atualizar / criar
				if( !is_null($individuo_escolaridade) ){
					$individuo_escolaridade->tipo_transporte_id = ($input['tipo_transporte_escolar'] != '') ? $input['tipo_transporte_escolar'] : null;
					$individuo_escolaridade->instituicao = ($input['instituicao'] != '') ? $input['instituicao'] : null;
					$individuo_escolaridade->tipo_escolaridade_id = ($input['tipo_escolaridade_id'] != '') ? $input['tipo_escolaridade_id'] : null;
					$individuo_escolaridade->alfabetizado = isset($input['alfabetizado']) ? $input['alfabetizado'] : null;
					$individuo_escolaridade->status = isset($input['status']) ? $input['status'] : null;
					$individuo_escolaridade->update();
				}else{
					if( isset($input['tipo_escolaridade_id']) ){
						$escolaridade = new Escolaridade($input);
						$escolaridade->status = isset($input['status']) ? $input['status'] : null;
						$escolaridade->alfabetizado = isset($input['alfabetizado']) ? $input['alfabetizado'] : null;
						$escolaridade->instituicao = $input['instituicao'];
						$escolaridade->tipo_escolaridade_id = $input['tipo_escolaridade_id'];
						$escolaridade->tipo_transporte_id = $input['tipo_transporte_escolar'];
						$escolaridade->individuo()->associate($individuo)->save();
					}
				}

				// Trabalho — atualizar / criar
				if( !is_null($individuo_trabalho) ){
					$individuo_trabalho->tipo_transporte_id = ($input['tipo_transporte_trabalho'] != '') ? $input['tipo_transporte_trabalho'] :null;
					$individuo_trabalho->local = ($input['local_trabalho'] != '') ? $input['local_trabalho'] :null;
					$individuo_trabalho->tipo_trabalho_id = ($input['tipo_trabalho_id'] != '') ? $input['tipo_trabalho_id'] :null;
					$individuo_trabalho->profissao = ($input['profissao'] != '') ? $input['profissao'] :null;
					$individuo_trabalho->periodo = ($input['periodo'] != '') ? $input['periodo'] :null;
					$individuo_trabalho->update();
				}else{
					if( isset($input['tipo_trabalho_id']) ){
						if( $input['tipo_trabalho_id'] != '' ){
							$trabalho = new Trabalho($input);
							$trabalho->tipo_transporte_id = ($input['tipo_transporte_trabalho'] != '') ? $input['tipo_transporte_trabalho'] :null;
							$trabalho->local = ($input['local_trabalho'] != '') ? $input['local_trabalho'] :null;
							$trabalho->individuo()->associate($individuo)->save();
						}
					}
				}


				// Benefícios
				foreach ($individuo_beneficio as $key => $beneficio) {
					if (isset($input['tipo_beneficio_id'][$key])) {
						$beneficio->tipo_beneficio_id = $input['tipo_beneficio_id'][$key];
						if( isset($input['outro_beneficio']) ){
							$beneficio->outro  = $input['outro_beneficio'];
						}
						if( isset($input['obs_beneficio']) ){
							$beneficio->obs = $input['obs_beneficio'];
						}

						$beneficio->update();
					}else{
						$beneficio->delete();
					}
				}
				if( isset($input['tipo_beneficio_id']) ){
					if ( count($individuo->beneficios) < count($input['tipo_beneficio_id']) ) {
						foreach ($input['tipo_beneficio_id'] as $key => $tipo_beneficio) {
							if ( !isset($individuo->beneficios[$key]) ) {
								$beneficio = new Beneficio( array(
																'tipo_beneficio_id' => $tipo_beneficio,
																'outro' => isset($input['outro_beneficio']) ? $input['outro_beneficio'] : null,
																'obs' => isset($input['obs_beneficio']) ? $input['obs_beneficio'] : null) );
								$beneficio->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Credenciais
				$comparar = 0;
				foreach ( $individuo_credencial as $key => $credencial ) {
					if ( isset($input['tipo_credencial_id'][$key]) ) {
						$credencial->tipo_credencial_id = $input['tipo_credencial_id'][$key];
						if( isset($input['credencial']) ){
							foreach( $input['credencial'] as $key2 => $credencial2 ){
								$comparar+=1;
								if( $input['credencial'][$key2] != "" ){
									if( $comparar == $input['tipo_credencial_id'][$key] ){
										$credencial->credencial = $credencial2;
									}
								}
							}
							$comparar=0;
						}
						$credencial->update();
					}
					else{
						$credencial->delete();
					}
				}
				if( isset($input['tipo_credencial_id']) ){
					if ( count($individuo->credenciais) < count($input['tipo_credencial_id']) ) {
						foreach ($input['tipo_credencial_id'] as $key => $tipo_credencial) {
							if ( !isset($individuo->credenciais[$key]) ) {

								$credencial_credencial = null;
								if( isset($input['credencial'][0]) ){
									foreach( $input['credencial'] as $key2 => $credencial2 ){
										$comparar+=1;
										if( $input['credencial'][$key2] != "" ){
											if( $comparar == $input['tipo_credencial_id'][$key] ){
												$credencial_credencial = $credencial2;
											}
										}
									}
									$comparar=0;
								}

								$credencial = new Credencial( array( 'tipo_credencial_id' => $tipo_credencial, 'credencial' => $credencial_credencial ) );
								$credencial->individuo()->associate($individuo)->save();

							}
						}
					}
				}


				// Vida Diária
				foreach ($individuo_vidaDiaria as $key => $vidaDiaria) {
					if ( isset($input['vida_diaria'][$key]) ) {
						$vidaDiaria->tipo_vida_diaria_id = $input['vida_diaria'][$key];
						$vidaDiaria->tipo_vida_diaria_assunto_id = $key+1;

						if( $key == 5 ){
							if( isset($input['outro_vida_diaria']) ){
								$vidaDiaria->outro = $input['outro_vida_diaria'];
							}
						}

						$vidaDiaria->update();
					}else{
						$vidaDiaria->delete();
					}
				}
				if( $input['vida_diaria'][0] != '' ){
					if ( count($individuo->vidaDiaria) < count($input['vida_diaria']) ) {
						foreach ( $input['vida_diaria'] as $key => $tipo_vida_diaria ) {
							if( $key == 5 ){
								if ( !isset($individuo->vidaDiaria[$key]) ) {
									$vidaDiaria = new VidaDiaria( array( 'tipo_vida_diaria_assunto_id' => $key+1, 'tipo_vida_diaria_id' => $tipo_vida_diaria, 'outro' => $input['outro_vida_diaria'] ) );
									$vidaDiaria->individuo()->associate($individuo)->save();
								}
							}
							elseif ( !isset($individuo->vidaDiaria[$key]) ) {
								$vidaDiaria = new VidaDiaria( array( 'tipo_vida_diaria_assunto_id' => $key+1, 'tipo_vida_diaria_id' => $tipo_vida_diaria ) );
								$vidaDiaria->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Grupos sociais
				foreach ( $individuo_grupoSocial as $key => $grupoSocial ) {
					if ( isset($input['tipo_grupo_social_id'][$key]) ) {
						$grupoSocial->tipo_grupo_social_id = $input['tipo_grupo_social_id'][$key];

						if( $grupoSocial->tipo_grupo_social_id == 5 ){
							if( isset($input['outro_grupo_social']) ){
								$grupoSocial->outro = $input['outro_grupo_social'];
							}
						}

						$grupoSocial->update();
					}else{
						$grupoSocial->delete();
					}
				}
				if( isset($input['tipo_grupo_social_id']) ){
					if ( count($individuo->grupoSociais) < count($input['tipo_grupo_social_id']) ) {
						foreach ( $input['tipo_grupo_social_id'] as $key => $tipo_grupo_social ) {
							if( $tipo_grupo_social == 5 ){
								if ( !isset($individuo->grupoSocial[$key]) ) {
									$grupo_social = new GrupoSocial( array( 'tipo_grupo_social_id' => $tipo_grupo_social, 'outro' => $input['outro_grupo_social'] ) );
									$grupo_social->individuo()->associate($individuo)->save();
								}
							}
							elseif ( !isset($individuo->grupoSocial[$key]) ) {
								$grupo_social = new GrupoSocial( array( 'tipo_grupo_social_id' => $tipo_grupo_social ) );
								$grupo_social->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Esporte
				if( !is_null($individuo_esporte) ){
					$individuo_esporte->tipo_atividade_id = $input['tipo_atividade_esporte'];
					$individuo_esporte->tipo_transporte_id = ($input['transporte_esporte'] != '') ? $input['transporte_esporte'] : null;
					$individuo_esporte->obs = isset($input['obs_esporte']) ? $input['obs_esporte'] : null;
					$individuo_esporte->update();
				}else{
					if( isset($input['tipo_atividade_esporte']) ){
						if( $input['tipo_atividade_esporte'] != '' ){
							$esporte = new Esporte($input);
							$esporte->tipo_atividade_id = $input['tipo_atividade_esporte'];
							$esporte->tipo_transporte_id = ($input['transporte_esporte'] != '') ? $input['transporte_esporte'] : null;
							$esporte->obs = isset($input['obs_esporte']) ? $input['obs_esporte'] : null;
							$esporte->individuo()->associate($individuo)->save();
						}
					}
				}

				// Cultural
				if( !is_null($individuo_cultural) ){
					$individuo_cultural->tipo_atividade_id = $input['tipo_atividade_cultural'];
					$individuo_cultural->tipo_transporte_id = ($input['transporte_cultural'] != '') ? $input['transporte_cultural'] : null;
					$individuo_cultural->obs = isset($input['obs_cultural']) ? $input['obs_cultural'] : null;
					$individuo_cultural->update();
				}else{
					if( isset($input['tipo_atividade_cultural']) ){
						if( $input['tipo_atividade_cultural'] != '' ){
							$cultural = new Cultural($input);
							$cultural->tipo_atividade_id = $input['tipo_atividade_cultural'];
							$cultural->tipo_transporte_id = ($input['transporte_cultural'] != '') ? $input['transporte_cultural'] : null;
							$cultural->obs = isset($input['obs_cultural']) ? $input['obs_cultural'] : null;
							$cultural->individuo()->associate($individuo)->save();
						}
					}
				}

				// Queda
				foreach ($individuo_queda as $key => $queda) {
					if (isset($input['consequencia_queda'][$key])) {
						$queda->consequencia_queda_id = $input['consequencia_queda'][$key];
						if( isset($input['local_queda']) ){
							$queda->local  = $input['local_queda'];
						}

						$queda->update();
					}else{
						$queda->delete();
					}
				}
				if( isset($input['consequencia_queda']) ){
					if ( count($individuo->quedas) < count($input['consequencia_queda']) ) {
						foreach ( $input['consequencia_queda'] as $key => $queda ) {
							if (!isset($individuo->beneficios[$key])) {
								$q = new Queda( array(
										     'consequencia_queda_id' => $queda,
												 'local' => isset($input['local_queda']) ? $input['local_queda'] : null ) );
								$q->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Moradia
				if( !is_null($individuo_moradia) ){
					$individuo_moradia->outro = ($input['outro_moradia'] != '') ? $input['outro_moradia'] : null;
					$individuo_moradia->tipo_moradia_id = ($input['tipo_moradia_id'] != '') ? $input['tipo_moradia_id'] : null;
					$individuo_moradia->tipo_imovel_id = ($input['tipo_imovel_id'] != '') ? $input['tipo_imovel_id'] : null;
					$individuo_moradia->update();
				}else{
					if( ( isset($input['tipo_moradia_id']) ) || ( isset($input['tipo_imovel_id']) ) ){
						if( ($input['tipo_moradia_id'] != '') || ($input['tipo_imovel_id'] != '') ){
							$moradia = new Moradia($input);
							$moradia->outro = ($input['outro_moradia'] != '') ? $input['outro_moradia'] : null;
							$moradia->individuo()->associate($individuo)->save();
						}
					}
				}

				// Renda
				if( !is_null($individuo_renda) ){
					$individuo_renda->numero = ($input['renda_familiar'] != '') ? $input['renda_familiar'] : null;
					$individuo_renda->tipo_renda_id = ($input['tipo_renda_id'] != '') ? $input['tipo_renda_id'] : null;
					$individuo_renda->update();
				}else{
					if( isset($input['tipo_renda_id']) ){
						if( $input['tipo_renda_id'] != '' ){
							$renda = new Renda($input);
							$renda->numero = ($input['renda_familiar'] != '') ? $input['renda_familiar'] : null;
							$renda->individuo()->associate($individuo)->save();
						}
					}
				}


				// Interditado Judicialmente
				if( !is_null($individuo_interditado) ){
					$individuo_interditado->curador = $input['curador'];
					$individuo_interditado->update();
				}else{
					if( isset($input['curador']) ){
						$interditado = new InterditadoJudicialmente($input);
						$interditado->individuo()->associate($individuo)->save();
					}
				}

				// Saude
				foreach ($individuo_saude as $key => $saude) {
					if ( isset($input['tipo_saude_id'][$key]) ) {
						$saude->tipo_saude_id = $input['tipo_saude_id'][$key];
						if( isset($input['tipo_transporte_saude']) &&  $input['tipo_transporte_saude'] != ''){
							$saude->tipo_transporte_id  = $input['tipo_transporte_saude'];
						}
						$saude->update();
					}else{
						$saude->delete();
					}
				}
				if( isset($input['tipo_saude_id']) ){
					if ( count($individuo->saudes) < count($input['tipo_saude_id']) ) {
						foreach ($input['tipo_saude_id'] as $key => $tipo_saude) {
							if ( !isset($individuo->saudes[$key]) ) {
								$saude = new AssistenciaSaude( array(
																'tipo_saude_id' => $tipo_saude,
																'tipo_transporte_id' => ($input['tipo_transporte_saude'] != '') ? $input['tipo_transporte_saude'] : null
															));
								$saude->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Medicação
				if( !is_null($individuo_medicacao) ){
					foreach ($individuo_medicacao as $key => $medicacao) {
						if ( $input['nome_medicacao'][$key] != '' ) {
							if( !isset($input['processo_farmacia_municipal']) ){
								$medicacao->processo_farmacia_municipal = null;
							}elseif( isset($input['processo_farmacia_municipal']) ){
								$medicacao->processo_farmacia_municipal = $input['processo_farmacia_municipal'];
							}
							$medicacao->nome = $input['nome_medicacao'][$key];
							$medicacao->update();
						}else{
							$medicacao->delete();
						}
					}
				}
				$tipo_med = 0;
				if( isset($input['nome_medicacao']) && ($input['nome_medicacao'][0] != '')){
					if ( count($individuo->medicacao) < count($input['nome_medicacao']) ) {
						foreach ( $input['nome_medicacao'] as $key => $nome_med ) {
							if ( !isset($individuo->medicacao[$key]) &&  $nome_med != '' ) {
								if( $key == 0 ){
									$tipo_med = 1;
								}elseif( $key > 0 ){
									$tipo_med = 2;
								}
								$medicacao = new Medicacao( array(
																'nome' => $nome_med,
																'tipo_medicacao_id' => $tipo_med,
																'processo_farmacia_municipal' => isset($input['processo_farmacia_municipal']) ? $input['processo_farmacia_municipal'] : null
															));
								$medicacao->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Acompanhamento médico e terapêutico
				if( !is_null($individuo_acompanhamento) ){
					$individuo_acompanhamento->medico = $input['acompanhamento_medico'];
					$individuo_acompanhamento->terapeutico = $input['acompanhamento_terapeutico'];
					$individuo_acompanhamento->update();
				}else{
					if( isset($input['acompanhamento_medico']) && $input['acompanhamento_medico'] != '' ||
						  isset($input['acompanhamento_terapeutico']) && $input['acompanhamento_terapeutico'] != '' ){
						$acompanhamento = new Acompanhamento($input);
						$acompanhamento->medico = isset($input['acompanhamento_medico']) ? $input['acompanhamento_medico'] : null;
						$acompanhamento->terapeutico = isset($input['acompanhamento_terapeutico']) ? $input['acompanhamento_terapeutico'] : null;
						$acompanhamento->individuo()->associate($individuo)->save();
					}
				}


				// Mobilidade
				foreach ($individuo_mobilidade as $key => $mobilidade) {
					if (isset($input['causa_mobilidade_id'][$key])) {
						$mobilidade->causa_mobilidade_id = $input['causa_mobilidade_id'][$key];
						$mobilidade->update();
					}else{
						$mobilidade->delete();
					}
				}
				if( isset($input['causa_mobilidade_id']) ){
					if ( count($individuo->mobilidades) < count($input['causa_mobilidade_id']) ) {
						foreach ($input['causa_mobilidade_id'] as $key => $causa_mobilidade) {
							if ( !isset($individuo->mobilidades[$key]) ) {
								$mobilidade = new Mobilidade( array(
																'causa_mobilidade_id' => $causa_mobilidade ) );
								$mobilidade->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Comunicação
				foreach ($individuo_comunicacao as $key => $comunicacao) {
					if (isset($input['tipo_comunicacao_id'][$key])) {
						$comunicacao->tipo_comunicacao_id = $input['tipo_comunicacao_id'][$key];
						if( isset($input['outro_comunicacao'][$key]) ){
							$comunicacao->outro  = $input['outro_comunicacao'][$key];
						}

						$comunicacao->update();
					}else{
						$comunicacao->delete();
					}
				}
				if( isset($input['tipo_comunicacao_id']) ){
					if ( count($individuo->comunicacao) < count($input['tipo_comunicacao_id']) ) {
						foreach ($input['tipo_comunicacao_id'] as $key => $comunicacao) {
							if ( !isset($individuo->comunicacao[$key]) ) {
								$comunica = new Comunicacao( array(
																'tipo_comunicacao_id' => $comunicacao,
																'outro' => isset($input['outro_comunicacao'][$key]) ? $input['outro_comunicacao'][$key] : null ));
								$comunica->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Tecnologia Assistiva
				foreach ($individuo_tecassistiva as $key => $tec_assistiva) {
					if (isset($input['tipo_tecnologia_assistiva_id'][$key])) {
						$tec_assistiva->tipo_tecnologia_assistiva_id = $input['tipo_tecnologia_assistiva_id'][$key];
						$tec_assistiva->outro  = isset($input['outro_tecnologia']) ? $input['outro_tecnologia'] : null;
						$tec_assistiva->prefeitura = isset($input['prefeitura_tecnologia']) ? $input['prefeitura_tecnologia'] : null;

						$tec_assistiva->update();
					}else{
						$tec_assistiva->delete();
					}
				}
				if( isset($input['tipo_tecnologia_assistiva_id']) ){
					if ( count($individuo->tecnologiaAssistiva) < count($input['tipo_tecnologia_assistiva_id']) ) {
						foreach ($input['tipo_tecnologia_assistiva_id'] as $key => $tecnologia_assistiva) {
							if ( !isset($individuo->tecnologiaAssistiva[$key]) ) {
								$tec_assistiva = new TecnologiaAssistiva( array(
																'tipo_tecnologia_assistiva_id' => $tecnologia_assistiva,
																'prefeitura' => isset($input['prefeitura_tecnologia']) ? $input['prefeitura_tecnologia'] : null,
																'outro' => isset($input['outro_tecnologia']) ? $input['outro_tecnologia'] : null ));
								$tec_assistiva->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Informação
				if( !is_null($individuo_informacao) ){
					$individuo_informacao->obs = ($input['obs_informacao'] != '') ? $input['obs_informacao'] : null;
					$individuo_informacao->tipo_informacao_id = $input['tipo_informacao_id'];
					$individuo_informacao->tipo_informacao_origem_id = $input['tipo_informacao_origem_id'];
					$individuo_informacao->update();
				}else{
					if( ( isset($input['tipo_informacao_id']) ) ){
						if($input['tipo_informacao_id'] != ''){
							$info = new Informacao($input);
							$info->obs = isset($input['obs_informacao']) ? $input['obs_informacao'] : null;
							$info->individuo()->associate($individuo)->save();
						}
					}
				}


				// Sugestão
				if( !is_null($individuo_sugestao) ){
					$individuo_sugestao->sugestao = $input['sugestao'];
					$individuo_sugestao->update();
				}else{
					if( ( isset($input['sugestao']) ) ){
						if( $input['sugestao'] != '' ){
							$sugestao = new Sugestao($input);
							$sugestao->individuo()->associate($individuo)->save();
						}
					}
				}


				// Deficiência Física
				foreach ($individuo_deficiencia_fisica as $key => $fisica) {
					if ( isset($input['tipo_deficiencia_fisica_id'][$key]) ) {
						$fisica->tipo_deficiencia_fisica_id = $input['tipo_deficiencia_fisica_id'][$key];
						if( $input['data_laudo']['deficienciaFisica']  != '' ){
							$fisica->data_laudo  = FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaFisica']);
						}
						if( $input['quando_deficiencia']['deficienciaFisica']  != '' ){
							$fisica->quando_id = $input['quando_deficiencia']['deficienciaFisica'];
						}
						if( $input['causa_deficiencia']['deficienciaFisica'] != '' ){
							$fisica->causa_id = $input['causa_deficiencia']['deficienciaFisica'];
						}
						if( $input['outro_deficiencia']['deficienciaFisica']  != '' ){
							$fisica->outro = $input['outro_deficiencia']['deficienciaFisica'];
						}

						$fisica->update();
					}else{
						$fisica->delete();
					}
				}
				if( isset($input['tipo_deficiencia_fisica_id']) ){
					if ( count($individuo->deficienciaFisica) < count($input['tipo_deficiencia_fisica_id']) ) {
						foreach ($input['tipo_deficiencia_fisica_id'] as $key => $deficiencia_fisica) {
							if ( !isset($individuo->deficienciaFisica[$key]) ) {
								$def_fisica = new DeficienciaFisica( array(
																'tipo_deficiencia_fisica_id' => $deficiencia_fisica,
																'dauta_laudo' => isset($input['data_laudo']['deficienciaFisica']) ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaFisica']) : null,
																'causa_id' => ($input['causa_deficiencia']['deficienciaFisica'] != '') ? $input['causa_deficiencia']['deficienciaFisica'] : null,
																'quando_id' => ($input['quando_deficiencia']['deficienciaFisica'] != '') ? $input['quando_deficiencia']['deficienciaFisica'] : null,
																'outro' => ($input['outro_deficiencia']['deficienciaFisica'] != '') ? $input['outro_deficiencia']['deficienciaFisica'] : null,
															));
								$def_fisica->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Deficiência Mental
				foreach ($individuo_deficiencia_mental as $key => $mental) {
					if ( isset($input['tipo_deficiencia_mental_id'][$key]) ) {
						$mental->tipo_deficiencia_mental_id = $input['tipo_deficiencia_mental_id'][$key];
						if( $input['data_laudo']['deficienciaMental'] != '' ){
							$mental->data_laudo  = FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaMental']);
						}
						if( $input['quando_deficiencia']['deficienciaMental'] != '' ){
							$mental->quando_id = $input['quando_deficiencia']['deficienciaMental'];
						}
						if( $input['causa_deficiencia']['deficienciaMental'] != '' ){
							$mental->causa_id = $input['causa_deficiencia']['deficienciaMental'];
						}
						if( $input['outro_deficiencia']['deficienciaMental'] != '' ){
							$mental->outro = $input['outro_deficiencia']['deficienciaMental'];
						}

						$mental->update();
					}else{
						$mental->delete();
					}
				}
				if( isset($input['tipo_deficiencia_mental_id']) ){
					if ( count($individuo->deficienciaMental) < count($input['tipo_deficiencia_mental_id']) ) {
						foreach ($input['tipo_deficiencia_mental_id'] as $key => $deficiencia_mental) {
							if ( !isset($individuo->deficienciaMental[$key]) ) {
								$def_mental = new DeficienciaMental( array(
																'tipo_deficiencia_mental_id' => $deficiencia_mental,
																'dauta_laudo' => ($input['data_laudo']['deficienciaMental'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaMental']) : null,
																'causa_id' => ($input['causa_deficiencia']['deficienciaMental'] != '') ? $input['causa_deficiencia']['deficienciaMental'] : null,
																'quando_id' => ($input['quando_deficiencia']['deficienciaMental'] != '') ? $input['quando_deficiencia']['deficienciaMental'] : null,
																'outro' => ($input['outro_deficiencia']['deficienciaMental'] != '') ? $input['outro_deficiencia']['deficienciaMental'] : null,
																));
								$def_mental->individuo()->associate($individuo)->save();
							}
						}
					}
				}

				// Deficiência Psicossocial
				foreach ($individuo_deficiencia_psicossocial as $key => $psicossocial) {
					if ( isset($input['tipo_deficiencia_psicossocial_id'][$key]) ) {
						$psicossocial->tipo_deficiencia_psicossocial_id = $input['tipo_deficiencia_psicossocial_id'][$key];
						if( $input['data_laudo']['deficienciaPsicossocial'] != '' ){
							$psicossocial->data_laudo  = FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaPsicossocial']);
						}
						if( $input['quando_deficiencia']['deficienciaPsicossocial'] != '' ){
							$psicossocial->quando_id = $input['quando_deficiencia']['deficienciaPsicossocial'];
						}
						if( $input['causa_deficiencia']['deficienciaPsicossocial'] != '' ){
							$psicossocial->causa_id = $input['causa_deficiencia']['deficienciaPsicossocial'];
						}
						if( $input['outro_deficiencia']['deficienciaPsicossocial'] != '' ){
							$psicossocial->outro = $input['outro_deficiencia']['deficienciaPsicossocial'];
						}

						$psicossocial->update();
					}else{
						$psicossocial->delete();
					}
				}
				if( isset($input['tipo_deficiencia_psicossocial_id']) ){
					if ( count($individuo->deficienciaPsicossocial) < count($input['tipo_deficiencia_psicossocial_id']) ) {
						foreach ($input['tipo_deficiencia_psicossocial_id'] as $key => $deficiencia_psicossocial) {
							if ( !isset($individuo->deficienciaPsicossocial[$key]) ) {
								$def_psicossocial = new DeficienciaPsicossocial( array(
																'tipo_deficiencia_psicossocial_id' => $deficiencia_psicossocial,
																'dauta_laudo' => ($input['data_laudo']['deficienciaPsicossocial'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaPsicossocial']) : null,
																'causa_id' => ($input['causa_deficiencia']['deficienciaPsicossocial'] != '') ? $input['causa_deficiencia']['deficienciaPsicossocial'] : null,
																'quando_id' => ($input['quando_deficiencia']['deficienciaPsicossocial'] != '') ? $input['quando_deficiencia']['deficienciaPsicossocial'] : null,
																'outro' => ($input['outro_deficiencia']['deficienciaPsicossocial'] != '') ? $input['outro_deficiencia']['deficienciaPsicossocial'] : null,
																));
								$def_psicossocial->individuo()->associate($individuo)->save();
							}
						}
					}
				}


				// Deficiência Auditiva
				if( !is_null($individuo_deficiencia_auditiva) ){
					$individuo_deficiencia_auditiva->tipo_deficiencia_auditiva_id = $input['tipo_deficiencia_auditiva_id'];
					$individuo_deficiencia_auditiva->data_laudo = ($input['data_laudo']['deficienciaAuditiva'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaAuditiva']) : null;
					$individuo_deficiencia_auditiva->quando_id = ($input['quando_deficiencia']['deficienciaAuditiva'] != '') ? $input['quando_deficiencia']['deficienciaAuditiva'] : null;
					$individuo_deficiencia_auditiva->causa_id = ($input['causa_deficiencia']['deficienciaAuditiva'] != '') ? $input['causa_deficiencia']['deficienciaAuditiva'] : null;
					$individuo_deficiencia_auditiva->outro = ($input['outro_deficiencia']['deficienciaAuditiva'] != '') ? $input['outro_deficiencia']['deficienciaAuditiva'] : null;
					$individuo_deficiencia_auditiva->update();
				}else{
					if( isset($input['tipo_deficiencia_auditiva_id']) && $input['tipo_deficiencia_auditiva_id'] != ''){
						$deficiencia_auditiva = new DeficienciaAuditiva($input);
						$deficiencia_auditiva->data_laudo = ($input['data_laudo']['deficienciaAuditiva'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaAuditiva']) : null;
						$deficiencia_auditiva->quando_id = ($input['quando_deficiencia']['deficienciaAuditiva'] != '') ? $input['quando_deficiencia']['deficienciaAuditiva'] : null;
						$deficiencia_auditiva->causa_id = ($input['causa_deficiencia']['deficienciaAuditiva'] != '') ? $input['causa_deficiencia']['deficienciaAuditiva'] : null;
						$deficiencia_auditiva->outro = ($input['outro_deficiencia']['deficienciaAuditiva'] != '') ? $input['outro_deficiencia']['deficienciaAuditiva'] : null;
						$deficiencia_auditiva->individuo()->associate($individuo)->save();
					}
				}

				// Deficiência Visual
				if( !is_null($individuo_deficiencia_visual) ){
					$individuo_deficiencia_visual->tipo_deficiencia_visual_id = $input['tipo_deficiencia_visual_id'];
					$individuo_deficiencia_visual->data_laudo = ($input['data_laudo']['deficienciaVisual'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaVisual']) : null;
					$individuo_deficiencia_visual->quando_id = ($input['quando_deficiencia']['deficienciaVisual'] != '') ? $input['quando_deficiencia']['deficienciaVisual'] : null;
					$individuo_deficiencia_visual->causa_id = ($input['causa_deficiencia']['deficienciaVisual'] != '') ? $input['causa_deficiencia']['deficienciaVisual'] : null;
					$individuo_deficiencia_visual->outro = ($input['outro_deficiencia']['deficienciaVisual'] != '') ? $input['outro_deficiencia']['deficienciaVisual'] : null;
					if(isset($input['tipo_braille'])){
						$individuo_deficiencia_visual->tipo_braille_id = ($input['tipo_braille'] != 0) ? $input['tipo_braille'] : null;
					}
					$individuo_deficiencia_visual->update();
				}else{
					if( isset($input['tipo_deficiencia_visual_id']) && $input['tipo_deficiencia_visual_id'] != ''){
						$deficiencia_visual = new DeficienciaVisual($input);
						$deficiencia_visual->data_laudo = ($input['data_laudo']['deficienciaVisual'] != '') ? FormatterHelper::dateToMySQL($input['data_laudo']['deficienciaVisual']) : null;
						$deficiencia_visual->quando_id = ($input['quando_deficiencia']['deficienciaVisual'] != '') ? $input['quando_deficiencia']['deficienciaVisual'] : null;
						$deficiencia_visual->causa_id = ($input['causa_deficiencia']['deficienciaVisual'] != '') ? $input['causa_deficiencia']['deficienciaVisual'] : null;
						$deficiencia_visual->outro = ($input['outro_deficiencia']['deficienciaVisual'] != '') ? $input['outro_deficiencia']['deficienciaVisual'] : null;
						if(isset($input['tipo_braille'])){
							$deficiencia_visual->tipo_braille_id = ($input['tipo_braille'] != '') ? $input['tipo_braille'] : null;
						}
						$deficiencia_visual->individuo()->associate($individuo)->save();
					}
				}


				// Ubs — Cras
				if( !is_null($individuo_ubs_cras) ){
					$individuo_ubs_cras->ubs = isset($input['ubs']) ? $input['ubs'] : null;
					$individuo_ubs_cras->cras = isset($input['cras']) ? $input['cras'] : null;
					$individuo_ubs_cras->update();
				}else{
					if( (isset($input['ubs'])) || (isset($input['cras'])) ){
						if( $input['ubs'] != '' ||  $input['cras'] != '' ){
							$ubs_cras = new UbsCras($input);
							$ubs_cras->ubs = isset($input['ubs']) ? $input['ubs'] : null;
							$ubs_cras->cras = isset($input['cras']) ? $input['cras'] : null;
							$ubs_cras->individuo()->associate($individuo)->save();
						}
					}
				}


				LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', [
					'resource'     => Self::getTable($this->individuo),
					'id' 					 => $individuo->id,
				]));


				DB::commit();


			} catch (Exception $e) {

				Log::warning(sprintf('Exception: %s', $e->getMessage()));

				DB::rollback();

				throw $e;
			}

  }


	/**
	 * Atualizar parecer técnico do indivíduo
	 * Retorna para IndividuoController@parecer_update
	 * @return Response
	 */
  public function update_parecer($input, $id) {


		DB::beginTransaction();

		try {

			$individuo 							= $this->individuo->find($id);
			$individuo_parecer			= $this->individuo->with('parecerTecnico')->find($id)->parecerTecnico;

			// Parecer — atualizar / criar
			if( !is_null($individuo_parecer) ){
				$individuo_parecer->parecer = ($input['parecer'] != '') ? $input['parecer'] : null;
				$individuo_parecer->acompanhante = isset($input['acompanhante']) ? $input['acompanhante'] : null;
				$individuo_parecer->comportamento_funcional = isset($input['comportamento_funcional']) ? $input['comportamento_funcional'] : null;
				$individuo_parecer->user_id = Auth::user()->id;
				$individuo_parecer->update();
				LoggerHelper::log('UPDATE', Lang::get('logs.msg.update-parecer', [
						'resource' => Self::getTable($this->individuo),
						'id' 			 => $id]
				));
			}else{
				if( isset($input['parecer']) ){
					$parecer_tecnico = new ParecerTecnico($input);
					$parecer_tecnico->parecer = $input['parecer'];
					$parecer_tecnico->user_id = Auth::user()->id;
					$parecer_tecnico->acompanhante = isset($input['acompanhante']) ? $input['acompanhante'] : null;
					$parecer_tecnico->comportamento_funcional = isset($input['comportamento_funcional']) ? $input['comportamento_funcional'] : null;
					$parecer_tecnico->individuo()->associate($individuo)->save();
				}
				LoggerHelper::log('CREATE', Lang::get('logs.msg.create-parecer', [
						'resource' => Self::getTable($this->individuo),
						'id' 			 => $id]
				));
			}

			LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', [
					'resource' => Self::getTable($this->individuo),
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
	 * Deletar novo indivíduo (soft delete)
	 * Retorna para IndividuoController
	 * @return Response
	 */
  public function destroy($id) {

		DB::beginTransaction();

		try {

			$this->individuo->find($id)->delete();

			LoggerHelper::log('DESTROY', Lang::get('logs.msg.destroy', [
					'resource' => Self::getTable($this->individuo),
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
	 * Restaurar novo indivíduo
	 * Retorna para IndividuoController
	 * @return Response
	 */
  public function restore($id) {

    DB::beginTransaction();

    try {

      $individuo = $this->individuo->withTrashed()->find($id);

      $individuo->restore();

      LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', ['resource' => Self::getTable($this->individuo), 'id' => $id]));

      DB::commit();

    } catch (Exception $e) {

      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }


}
