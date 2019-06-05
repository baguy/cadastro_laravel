<?php
	class SetorBuilder {

		private $instance;

		public function __construct() {

			$this->instance = new Setor();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance;

			return $this;
		}

		// Método com filtros de buscas da página INDEX de setor
		public function getSpecificRestrictions($parameters = array()) {

			// Status — apenas setores ATIVOs
			if (array_key_exists('S_setor_id', $parameters)) {

				if (!empty($parameters['S_setor_id'])) { // Active

					$this->instance = $this->instance->where('id', $parameters['S_setor_id']);

				}
			}
			// Status — apenas usuários INATIVOs
			if (array_key_exists('S_status_id', $parameters)) {

				if (!empty($parameters['S_status_id']) && $parameters['S_status_id'] == 2 ) { // Active

					$this->instance = $this->instance->onlyTrashed();

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

		public function getContent() {

			$this->instance = $this->instance->paginate(10);

			return $this;
		}

		public function build() {

			return $this->getModel();
		}
	}

?>
