<?php

Class IndividuoValidator {

// Validações backend

	private static $attributes = [
    'nome'                  => "Nome",
    'data_nascimento'       => "Data de nascimento",
    'sexo_id'               => "Sexo",
    'cpf'                   => "CPF",
		'tipo_estado_civil'			=> "Estado civil",
		'data_casamento' 		 	  => "Data de casamento",
		'tipo_telefone'					=> "Tipo de telefone",
		'ramal'								  => "Ramal",
		'ddd'									  => "DDD",
		'telefone'							=> "Número do telefone",
		'cep'										=> "CEP",
		'estado'								=> "Estado",
		'cidade'							  => "Cidade",
		'bairro'								=> "Bairro",
		'regiao'								=> "Região",
		'tipo_logradouro'			  => "Tipo do logradouro",
		'logradouro'					  => "Logradouro",
		'numero'								=> "Número",
		'nome_parente'					=> "Nome do Responsável",
		'complemento'						=> "Complemento",
		'tipo_parentesco_id'    => "Vínculo de parentesco",
		'tipo_escolaridade_id'  => "Escolaridade",
		'tipo_trabalho_id'      => "Trabalhando",
		'vida_diaria'						=> "Vida Diária",
		'tipo_atividade_esporte'=> "Atividade Esporte",
		'tipo_atividade_cultural' => "Atividade Cultural",
		'tipo_moradia_id'			 => "Situação Moradia",
		'tipo_imovel_id'			 => "Referente ao Imóvel",
		'tipo_renda_id'				 => "Renda Pessoal",
		'renda_familiar'			 => "Renda Familiar",
		'sugestao'						 => "Sugestão",
		'tipo_informacao_id'   => "Quem prestou a Informação",
		'tipo_informacao_origem_id' => "Origem das Informações",
		'parecer'							 => "Parecer Técnico",
		'acompanhante'				 => "Acompanhante",
    'roles'                => "Nível"
  ];

  private static $rules = [];

  private static $messages = [];

	public static function store($input) {

		self::$rules = [
			'nome'                  => "required|min:3|max:100",
			'data_nascimento'       => "required|date_format:d/m/Y",
	    'sexo_id'               => "required",
	    'cpf'                   => "required|min:11",
			'telefone'							=> "required|array",

		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

	public static function update($input, $id) {

    self::$rules = [
      'nome'                  => "required|max:100",
			'data_nascimento'       => "required|date_format:d/m/Y",
      'sexo_id'               => "required",
      'cpf'                   => "unique:documento,numero,$id",
			'tipo_estado_civil'			=> "required",
			'data_casamento '       => "date_format:d/m/Y",
			'telefone'							=> "required|array",
			'logradouro'					  => "required",
			'numero'							  => "required",
			'nome_parente'				  => "required|array",
			'tipo_parentesco_id'    => "required|array",
			'vida_diaria'           => "required|array",
			// 'tipo_escolaridade_id'  => "required",
			// 'tipo_trabalho_id'      => "required",
			// 'tipo_atividade_esporte'=> "required",
			// 'tipo_atividade_cultural'=> "required",
			// 'tipo_moradia_id'				=> "required",
			// 'tipo_imovel_id'				=> "required",
			// 'tipo_renda_id'			    => "required",
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

	public static function update_parecer($input) {

		self::$rules = [
			'parecer'               => "required|min:3",
		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

}
