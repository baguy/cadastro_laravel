<?php

Class AuthValidator {

	private static $attributes = [
    'email'                 => "E-mail",
    'password'              => "Senha",
    'password_confirmation' => "Confirmar Senha"
  ];

  private static $rules = [];

  private static $messages = [];

	public static function login($input) {

		self::$rules = [
			'email'    => "required|email",
	    'password' => "required|min:6"
		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function remind($input) {

    self::$rules = [
      'email'                 => "required|email"
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

  public static function reset($input) {

    self::$rules = [
      'email'                 => "required|email",
      'password'              => "required|min:6|confirmed",
      'password_confirmation' => "min:6|required_with:password"
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}
