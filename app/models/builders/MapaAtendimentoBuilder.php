<?php

	class MapaAtendimentoBuilder {

		private $instance;

		public function __construct() {

			$this->instance = new MapaAtendimento();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance;

			return $this;
		}

		public function getSpecificRestrictions($parameters = array()) {

			// MUNICIPE
			if (array_key_exists('S_individuo_id', $parameters)) {

				if (!empty($parameters['S_individuo_id'])) { // Active

					$this->instance = $this->instance
            ->whereHas('individuo', function ($q) use($parameters) {
              $q->where('id', $parameters['S_individuo_id']);
          });
				}
			}

			// CATEGORIA
      if (array_key_exists('S_tipo_atendimento_id', $parameters)) {

				if (!empty($parameters['S_tipo_atendimento_id'])) { // Active

					$this->instance = $this->instance
            ->whereHas('tipoAtendimento', function ($q) use($parameters) {
							$q->whereIn('atendimento_tipo_atendimento.tipo_atendimento_id', $parameters['S_tipo_atendimento_id']);
          });
				}
			}

			// SETOR
			if (array_key_exists('S_setor', $parameters)) {

				if (!empty($parameters['S_setor'])) { // Active

					$this->instance = $this->instance
						->whereHas('setor', function ($q) use($parameters) {
							$q->whereIn('atendimento_setor_atendimento.setor_id', $parameters['S_setor']);
					});
				}
			}

			// STATUS
			if (array_key_exists('S_status_id', $parameters)) {

				if (!empty($parameters['S_status_id']) && $parameters['S_status_id'] != 4) { // Active

					$this->instance = $this->instance
            ->whereHas('status', function ($q) use($parameters) {
              $q->where('id', $parameters['S_status_id']);
          });

				} elseif(!empty($parameters['S_status_id']) && $parameters['S_status_id'] == 4) {

					$this->instance = $this->instance->withTrashed()->whereNotNull('deleted_at');
				}
			}

			// DATA INICIO E FIM
			if (array_key_exists('S_data_inicio', $parameters) && array_key_exists('S_data_fim', $parameters)) {

				if (!empty($parameters['S_data_inicio']) && !empty($parameters['S_data_fim'])) { // Active

					$this->instance = $this->instance
						->where('created_at', '>=', FormatterHelper::dateToEn($parameters['S_data_inicio']))
						->where('created_at', '<=', FormatterHelper::dateToEn($parameters['S_data_fim']));
					}
			}

			// DATA INICIO
			if (array_key_exists('S_data_inicio', $parameters)) {

				if (!empty($parameters['S_data_inicio'])) { // Active

					$this->instance = $this->instance
						->where('created_at', '>=', FormatterHelper::dateToEn($parameters['S_data_inicio']));
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

			$this->instance = $this->instance->orderBy('created_at', 'DESC');

			return $this;
		}

		public function getContent() {

			$this->instance = $this->instance->paginate(100);

			return $this;
		}

		public function build() {

			return $this->getModel();
		}
	}

?>
