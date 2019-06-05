<?php

class BaseService {

	public function hasChanges($model, $guarded = array()) {

		foreach ($model->getDirty() as $attribute => $value) {

			if (!in_array($attribute, $guarded)) {

				$original = $model->getOriginal($attribute);

				LoggerHelper::log('EDIT', Lang::get('logs.msg.edit.field', [
					'resource'  => $this->getTable($model),
					'attribute' => $attribute,
					'original'  => $original,
					'value'     => $value,
					'id'        => $model->id
				]));
			}
		}
	}

	public function getTable($model) {

		return mb_strtoupper(str_replace('_', ' ', $model->getTable()), 'UTF-8');
	}

	public function getElements($resource) {

		$builder = $this->getBuilder($resource);

		if ($builder) {

			$objects = [

				'users' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'users',
				],

				'atendimento' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'atendimento',
				],

				'individuos' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'individuos',
				],

				'setor' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'setor',
				],

				'funcionario' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'funcionario',
				],

				'entrada' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'entrada',
				],

				'mapa_individuo' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'mapa_individuo',
				],

				'mapa_atendimento' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'mapa_atendimento',
				],

				'pre_cadastro' => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => 'pre_cadastro',
				],

				/*
				'example' => [
					'model'  => Example::orderBy('name','ASC'),
					'folder' => 'examples',
				],

				'example' => [
					'model'  => new Example,
					'folder' => 'examples',
				]
				*/
			];

			if(isset($objects[$resource]))

				return $objects[$resource];

		}

		return null;
	}

	public function abort() {

		App::abort(404, Lang::get('application.error.404.msg'));
	}

	private function getBuilder($resource) {

		switch ($resource) {

			case 'users':

				return new UserBuilder();

			case 'atendimento':

				return new AtendimentoBuilder();

			case 'individuos':

				return new IndividuoBuilder();

			case 'setor':

				return new SetorBuilder();

			case 'funcionario':

				return new FuncionarioBuilder();

			case 'entrada':

				return new EntradaBuilder();

			case 'mapa_individuo':

				return new MapaIndividuoBuilder();

			case 'mapa_atendimento':

				return new MapaAtendimentoBuilder();

			case 'pre_cadastro':

				return new PreCadastroBuilder();

			default:

				return null;
		}
	}
}
