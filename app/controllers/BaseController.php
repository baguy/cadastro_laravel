<?php

class BaseController extends Controller {

	protected $service;

  public function __construct(BaseService $service) {

    $this->service = $service;
  }

	// Busca Indivíduo por nome ou cpf
	public function search() {

    $input = Input::get('parameter');

    $result = Individuo::where('nome', 'LIKE', '%'.$input.'%')
              ->orWhere('cpf', 'LIKE', '%'.$input.'%')
              ->get();

    return $result;
  }

	// Busca Indivíduo por nome ou cpf
	public function searchPerson() {

		$input = Input::get('parameter');

		if( is_numeric($input) ){
			$result = Documento::where(function ($query) use($input){
														$query->where('numero', 'LIKE', $input.'%');
													})
													->where(function ($query){
														$query->where('tipo_documento_id', '=', '1');
													})->join('individuo', 'individuo.id', '=', 'documento.individuo_id')
													->get();
		}else{
			$result = Individuo::where('nome', 'LIKE', $input.'%')
								->join('documento', function($join) use ($input){
									$join->on('individuo.id', '=', 'documento.individuo_id')
									->where('tipo_documento_id', '=', '1', 'AND', 'numero', 'LIKE', $input.'%');
								})->get();
		}

		return $result;
	}

	// Busca Funcionario por nome ou matrícula
	public function searchEmployee() {

		$input = Input::get('parameter');

		$result = Funcionario::where('nome', 'LIKE', $input.'%')
							->orWhere('matricula', 'LIKE', $input.'%')
							->get();

		return $result;
	}

	// Busca Setor por nome
	public function searchDepartment() {

		$input = Input::get('parameter');

		$result = Setor::where('nome', 'LIKE', '%'.$input.'%')->get();

		return $result;
	}

	// Busca equivalência de CPF no bd
	public function searchCPF($input) {

		$input = FormatterHelper::somenteNumeros($input);
		$result = null;
		if( is_numeric($input) ){
			$result = Documento::where(function ($query) use($input){
														$query->where('numero', '=', $input);
													})
													->where(function ($query){
														$query->where('tipo_documento_id', '=', '1');
													})
													->get();
		}

		return $result;
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {

		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	// Método que pega os elementos de qualquer controller e envia para a tabela (table.blade.php)
	public function getElements($resource, $objects = false, $type = null) {

		$object = $this->service->getElements($resource);

		if ($object) {

			LoggerHelper::log('INDEX', Lang::get('logs.msg.index', ['resource' => $this->service->getTable($object['model'])]));

			$elements = $object['query'];

			$parameters = Input::except('_token', '_method');

			$generals = array();
			$specifcs = array();
			$ordering = array();
			$perPage  = array();

			if ($parameters) {

				LoggerHelper::log('SEARCH', Lang::get('logs.msg.index.search', [
					'resource'  => $this->service->getTable($object['model']),
					'parameters' => json_encode($parameters)
				]));

				// Model order by parameters

				if (array_key_exists('C_sort', $parameters))

					$ordering  = array_only($parameters, array('C_sort', 'C_order'));

				if (array_key_exists('C_per_page', $parameters))

					$perPage  = array_only($parameters, array('C_per_page'));

				$parameters = array_except($parameters, array('page', 'C_sort', 'C_order', 'C_per_page'));

				// Model specific restrictions
				$specifcs = array_filter($parameters, function($k) { return starts_with($k, 'S_'); }, ARRAY_FILTER_USE_KEY);

				$elements = $elements->getSpecificRestrictions($specifcs);

				// Model general restrictions (explode("|", $field))
				$generals = array_filter($parameters, function($k) { return !starts_with($k, 'S_'); }, ARRAY_FILTER_USE_KEY);

				foreach ($generals as $key => $parameter) {

					if($parameter) {

						$elements = $elements->getGeneralRestrictions(function($q) use($key, $parameter) {

							foreach(explode("|", $key) as $string) {

								$q = $q->orWhere($string, 'LIKE', "%{$parameter}%");
							}
						});
					}
				}
			}

			$elements = $elements->getBasicRestrictions($specifcs)->getOrder($ordering);

			if ($objects) {

				$elements = $elements->getContent($type, $perPage)->build();

				return $elements;
			}

			$elements = $elements->getContent(null, $perPage)->build();

			return View::make("{$object['folder']}.table", compact('elements'));

		}

		return Response::make('<div class="alert alert-danger">'
														. Lang::get('application.msg.error.resource-not-exists', [ 'resource' => $resource ]) .
													'</div>');
	}

}
