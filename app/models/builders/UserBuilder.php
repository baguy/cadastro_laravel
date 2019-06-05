<?php

	class UserBuilder {

		private $instance;
		
		public function __construct() {
			
			$this->instance = new User();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance->withTrashed();

			return $this;
		}

		public function getSpecificRestrictions($parameters = array()) {

			// Status
			if (array_key_exists('S_status', $parameters)) {

				if ($parameters['S_status'] === '1') { // Active

					$this->instance = $this->instance->where('deleted_at', null);

				} elseif ($parameters['S_status'] === '2') { // Inactive

					$this->instance = $this->instance
																					->whereNotNull('deleted_at')
																					->whereHas('throttle', function ($q) {

																						$q->where('suspended', false);
																		      });

				} elseif ($parameters['S_status'] === '3') { // Suspended

					$this->instance = $this->instance
																					->whereNotNull('deleted_at')
																					->whereHas('throttle', function ($q) {

																						$q->where('suspended', true);
																		      });
				}
			}

			// Attempts
			if (array_key_exists('S_attempts', $parameters)) {

				if ($parameters['S_attempts'] === '0') // 0 attempts

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('attempts', '=', 0);
																		      });

				elseif ($parameters['S_attempts'] === '1') // >= 1 attempts

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('attempts', '>=', 1);
																		      });
			}

			// Is Default Password
			if (array_key_exists('S_is_default_password', $parameters)) {

				if ($parameters['S_is_default_password'] === '1') // Default

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('is_default_password', true);
																		      });

				elseif ($parameters['S_is_default_password'] === '0') // Changed

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('is_default_password', false);
																		      });
			}

			return $this;
		}

		public function getGeneralRestrictions($restrictions = null) {

			if ($restrictions)

				$this->instance = $this->instance->where($restrictions);

			return $this;
		}

		public function getBasicRestrictions($parameters = array()) {

			// Roles
			$this->instance = $this->instance->whereHas('roles', function ($q) use($parameters) {

																					if (array_key_exists('S_roles', $parameters) && !empty($parameters['S_roles'])) {

																							$q->havingRaw('MIN(roles.id) = ?', [ $parameters['S_roles'] ]);

																	      	} else {
																		        
																		        $q->havingRaw('MIN(roles.id) >= ?', [ Auth::user()->minRole()->id ]);
																		      }
																	      });

			return $this;
		}

		public function getOrder() {

			$this->instance = $this->instance->orderBy('name', 'ASC');

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