<?php

Class FuncionarioValidator {

// Validações backend

	private static $attributes = [
    'nome'                  => "Nome",
    'matricula'             => "Matrícula",
    'email'                 => "Email",
  ];

  private static $rules = [];

  private static $messages = [];

	public static function store($input) {

		self::$rules = [
			'nome'                  => "required|max:100",
      'matricula'             => "required",
		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

	public static function update($input, $id) {

    self::$rules = [
      'nome'                  => "required|max:100",
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

}
