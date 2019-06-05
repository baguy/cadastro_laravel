<?php
	class PreCadastroBuilder {

		private $instance;

		public function __construct() {

			$this->instance = new PreCadastro();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance;

			return $this;
		}

		// Método com filtros de buscas da página INDEX de indivíduos
		public function getSpecificRestrictions($parameters = array()) {

			// INDIVÍDUOS — nome ou cpf
			if (array_key_exists('S_individuo_id', $parameters)) {

				if (!empty($parameters['S_individuo_id'])) { // Active
					if(!is_numeric($parameters['S_individuo_id'])){

						$this->instance = $this->instance->where('nome', 'LIKE', $parameters['S_individuo_id']."%");

					}else{

						$this->instance = $this->instance
						->whereHas('documentos', function ($q) use($parameters) {
							$q->where('numero', 'LIKE', $parameters['S_individuo_id']."%", 'AND', 'tipo_documento_id', '=', '1');
						});

					}

				}
			}


			// Status — apenas usuários INATIVOs
			if (array_key_exists('S_status_id', $parameters)) {

				if (!empty($parameters['S_status_id']) && $parameters['S_status_id'] == 2 ) { // Inactive

					$this->instance = $this->instance->onlyTrashed();

				}
			}


			// DATA de nascimento
			if (array_key_exists('S_data_nascimento', $parameters)) {

				if (!empty($parameters['S_data_nascimento'])) { // Active

					$this->instance = $this->instance->where('data_nascimento', FormatterHelper::dateToMySQL($parameters['S_data_nascimento']));

				}
			}


			// DATA de cadastro
			if (array_key_exists('S_data_cadastro', $parameters)) {

				if (!empty($parameters['S_data_cadastro'])) { // Active

					$this->instance = $this->instance->whereDate('created_at', '=', FormatterHelper::dateToMySQL($parameters['S_data_cadastro']));

				}
			}


			// IDOSO
			if (array_key_exists('S_ano_nascimento', $parameters)) {

				if (!empty($parameters['S_ano_nascimento']) && $parameters['S_ano_nascimento'] == 1) { // Active

					$this->instance = $this->instance->where( 'data_nascimento', '<=', date('Y-m-d', strtotime("-60 years")) );

				}

				if(!empty($parameters['S_ano_nascimento']) && $parameters['S_ano_nascimento'] == 2){

					$this->instance = $this->instance->where( 'data_nascimento', '>', date('Y-m-d', strtotime("-60 years")) );

				}

			}


			// SEXO
			if (array_key_exists('S_sexo', $parameters)) {

				if (!empty($parameters['S_sexo'])) { // Active

					$this->instance = $this->instance->where('sexo_id', '=', $parameters['S_sexo']);

				}
			}


			// Todos os usuários de determinado BAIRRO
			if (array_key_exists('S_bairro', $parameters)) {

				if (!empty($parameters['S_bairro'])) { // Active

					$this->instance = $this->instance
					->whereHas('endereco', function ($q) use($parameters) {
						$q->where('bairro', 'LIKE', "%{$parameters['S_bairro']}%");
				});

				}
			}


			// Todos os usuários com deficiência FÍSICA
			if (array_key_exists('S_def_fisica', $parameters)) {

				if (!empty($parameters['S_def_fisica']) && $parameters['S_def_fisica'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('deficienciaFisica', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
				});

				}

				if(!empty($parameters['S_def_fisica']) && $parameters['S_def_fisica'] == 2){

					$this->instance = $this->instance
					->whereHas('deficienciaFisica', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com deficiência AUDITIVA
			if (array_key_exists('S_def_auditiva', $parameters)) {

				if (!empty($parameters['S_def_auditiva']) && $parameters['S_def_auditiva'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('deficienciaAuditiva', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
				});

				}

				if(!empty($parameters['S_def_auditiva']) && $parameters['S_def_auditiva'] == 2){

					$this->instance = $this->instance
					->whereHas('deficienciaAuditiva', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com deficiência MENTAL
			if (array_key_exists('S_def_mental', $parameters)) {

				if (!empty($parameters['S_def_mental']) && $parameters['S_def_mental'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('deficienciaMental', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_def_mental']) && $parameters['S_def_mental'] == 2){

					$this->instance = $this->instance
					->whereHas('deficienciaMental', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com deficiência PSICOSSOCIAL
			if (array_key_exists('S_def_psicossocial', $parameters)) {

				if (!empty($parameters['S_def_psicossocial']) && $parameters['S_def_psicossocial'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('deficienciaPsicossocial', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_def_psicossocial']) && $parameters['S_def_psicossocial'] == 2){

					$this->instance = $this->instance
					->whereHas('deficienciaPsicossocial', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com deficiência VISUAL
			if (array_key_exists('S_def_visual', $parameters)) {

				if (!empty($parameters['S_def_visual']) && $parameters['S_def_visual'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('deficienciaVisual', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_def_visual']) && $parameters['S_def_visual'] == 2){

					$this->instance = $this->instance
					->whereHas('deficienciaVisual', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com problema de MOBILIDADE
			if (array_key_exists('S_mobilidade', $parameters)) {

				if (!empty($parameters['S_mobilidade']) && $parameters['S_mobilidade'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('mobilidades', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_mobilidade']) && $parameters['S_mobilidade'] == 2){

					$this->instance = $this->instance
					->whereHas('mobilidades', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários com problema ou sem PARECER
			if (array_key_exists('S_parecer', $parameters)) {

				if (!empty($parameters['S_parecer']) && $parameters['S_parecer'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('parecerTecnico', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_parecer']) && $parameters['S_parecer'] == 2){

					$this->instance = $this->instance
					->whereHas('parecerTecnico', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			// Todos os usuários INTERDITADO JUDICIALMENTE ou não
			if (array_key_exists('S_interditado', $parameters)) {

				if (!empty($parameters['S_interditado']) && $parameters['S_interditado'] == 1) { // Active

					$this->instance = $this->instance
					->whereHas('interditado', function ($q) use($parameters) {
						$q->select(DB::raw('DISTINCT (individuo_id)'));
					});

				}

				if(!empty($parameters['S_interditado']) && $parameters['S_interditado'] == 2){

					$this->instance = $this->instance
					->whereHas('interditado', function ($q) use($parameters) {
						$q->whereNotNull('individuo_id');
					}, '<', 1 );

				}

			}


			return $this;
		}

		public function getGeneralRestrictions($restrictions = null) {

			if ($restrictions)

				$this->instance = $this->instance->where($restrictions);

			return $this;
		}

		public function getBasicRestrictions($parameters = array()) {

			// // Roles
			// $this->instance = $this->instance->whereHas('roles', function ($q) use($parameters) {
      //
			// 																		if (array_key_exists('S_roles', $parameters) && !empty($parameters['S_roles'])) {
      //
			// 																				$q->havingRaw('MIN(roles.id) = ?', [ $parameters['S_roles'] ]);
      //
			// 														      	} else {
      //
			// 															        $q->havingRaw('MIN(roles.id) >= ?', [ Auth::user()->minRole()->id ]);
			// 															      }
			// 														      });

			return $this;
		}

		public function getOrder() {

			$this->instance = $this->instance->orderBy('id', 'ASC');

			return $this;
		}

		public function getContent($type = null, $parameters = array()) {

			switch ($type) {

				case 'get':

					$this->instance = $this->instance->get();

					break;

				default:

					$perPage = 10;

					if (array_key_exists('C_per_page', $parameters))

						$perPage = empty($parameters['C_per_page']) ? $perPage : $parameters['C_per_page'];

					$this->instance = $this->instance->paginate($perPage);

					break;
			}

			return $this;
		}

		public function build() {

			return $this->getModel();
		}
	}

?>
