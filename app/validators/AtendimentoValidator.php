<?php

class AtendimentoValidator {

  private static $attributes = [
    'individuo_id'              => 'Munícipe',
    'tipo_atendimento_id'       => 'Categoria',
    'status_id'                 => 'Status',
    'titulo'                    => 'Título',
    'descricao'                 => 'Descrição',
    'new_assentamento'          => 'Assentamento',
    'assentamento'              => 'Assentamento',
    'data_criacao'              => 'Data de Criação',
    'ligacao'                   => 'Status da ligação',
    'assentamento_ligacao'      => 'Status da ligação',
    'new_assentamento_ligacao'  => 'Status da ligação',
    'cep'										    => "CEP",
    'estado'								    => "Estado",
    'cidade'							      => "Cidade",
    'bairro'								    => "Bairro",
    'regiao'								    => "Região",
    'tipo_logradouro'			      => "Tipo do logradouro",
    'logradouro'					      => "Logradouro",
    'numero'								    => "Número",
    'complemento'						    => "Complemento",
  ];

  private static $rules = [];

  private static $messages = [];

  public static function store($input) {

    self::$rules = [
      'individuo_id'          => 'required',
      'tipo_atendimento_id'   => 'required',
      'titulo'                => 'required|min:3|max:200',
      'descricao'             => 'required|min:3',
    ];

    if(isset($input['assentamento'])) {
      self::$rules['assentamento'] = 'array';

      foreach ($input['assentamento'] as $key => $value) {
        self::$rules['assentamento.'.$key] = 'min:3';
        }
    }

    if(isset($input['new_assentamento'])) {
      self::$rules['new_assentamento'] = 'array';

      foreach ($input['new_assentamento'] as $key => $value) {
        self::$rules['new_assentamento.'.$key] = 'min:3';
        }
    }

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

  public static function update($input, $id) {

    self::$rules = [
      'individuo_id'        => 'required',
      'tipo_atendimento_id' => 'required',
      'titulo'              => 'required|min:3|max:200',
      'descricao'           => 'required|min:3',
    ];

    if(isset($input['assentamento'])) {
      self::$rules['assentamento'] = 'array';

      foreach ($input['assentamento'] as $key => $value) {
        self::$rules['assentamento.'.$key] = 'min:3';
        }
    }

    if(isset($input['new_assentamento'])) {
      self::$rules['new_assentamento'] = 'array';

      foreach ($input['new_assentamento'] as $key => $value) {
        self::$rules['new_assentamento.'.$key] = 'min:3';
        }
    }


    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

  public static function updateAssentamentos($input, $id) {

    self::$rules = [
      'new_assentamento' => 'array'
    ];

    foreach ($input['new_assentamento'] as $key => $value) {
      self::$rules['new_assentamento.'.$key] = 'min:3';
    }

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

}
