<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// CSRF Validation
Route::when('*', 'csrf', array('post'));

Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

Route::get('password/remind', 'AuthController@getRemind');
Route::post('password/remind', 'AuthController@postRemind');
Route::get('password/reset/{token}', 'AuthController@getReset');
Route::post('password/reset', 'AuthController@postReset');

Route::resource('pre_cadastro', 'PreCadastroController');

// Error JS Route
Route::get('errors/js', function() {
	return View::make('errors.js');
});

// Authentication Filter Verification
Route::group(array('before' => 'auth'), function() {

	// Logout
	Route::get('logout', 'AuthController@getLogout');

	// DataTable
Route::get('list/{resource}', 'BaseController@getElements');

	// Change Password
	Route::get('users/{id}/change-password', [
		'as' => 'users.change-password',
		'uses' => 'UserController@changePassword'
	])->where('id', '[0-9]+');

	Route::patch('users/{id}/alter-password', [
		'as' => 'users.alter-password',
		'uses' => 'UserController@alterPassword'
	])->where('id', '[0-9]+');

	// Is Default Password Filter Verification
	Route::group(array('before' => 'is-default-password'), function() {

		Route::get('/', function() {
			return Redirect::to('users/'.Auth::user()->id);
		});

		// Bases
		Route::get('list/{resource}', 'BaseController@getElements');

	  // Users
	  Route::resource('users', 'UserController');

	  Route::patch('users/{id}/restore', ['as' => 'users.restore', 'uses' => 'UserController@restore'])->where('id', '[0-9]+');

	  Route::get('users/{id}/redefine-password', [
	  	'as' => 'users.redefine-password', 'uses' => 'UserController@redefinePassword'
	  ])->where('id', '[0-9]+');

	  // Logs
	  Route::resource('logs', 'LoggerController');

		// Atendimentos
		// Excel
		Route::get('atendimento/export/{type}/{categoria}/{status}/{data}/{setor}/{bairro}', ['as' => 'atendimento.export', 'uses' => 'AtendimentoController@export']);
		Route::get('atendimento/report', 'AtendimentoController@report');
		// PDF
		Route::get('atendimento/{id}/pdf', ['as' => 'atendimento.pdf', 'uses' => 'AtendimentoController@pdf'])->where('id', '[0-9]+');
		Route::patch('atendimento/{id}/restore', ['as' => 'atendimento.restore', 'uses' => 'AtendimentoController@restore'])->where('id', '[0-9]+');
		Route::post('atendimento/search', 'AtendimentoController@search');
		Route::resource('atendimento', 'AtendimentoController');

		// Individuos
		// Parecer
		Route::patch('individuos/{id}/restore', ['as' => 'individuos.restore', 'uses' => 'IndividuoController@restore'])->where('id', '[0-9]+');
		Route::get('individuos/{id}/parecer', ['as' => 'individuos.parecer', 'uses' => 'IndividuoController@parecer'])->where('id', '[0-9]+');
		Route::put('individuos/{id}/parecer', ['as' => 'individuos.parecer_update', 'uses' => 'IndividuoController@parecer_update'])->where('id', '[0-9]+');
		// Excel
		Route::get('individuos/export/{type}/{ano}/{status}/{sexo}/{bairro}/{mobilidade}/{def_fisica}/{def_auditiva}/{def_visual}/{def_mental}/{def_psicossocial}/{parecer}/{interditado}/{data_nascimento}/{data_cadastro}', ['as' => 'individuos.export', 'uses' => 'IndividuoController@export']);
		Route::get('individuos/report', 'IndividuoController@report');
		// PDF
		Route::get('individuos/{id}/pdf', ['as' => 'individuos.pdf', 'uses' => 'IndividuoController@pdf'])->where('id', '[0-9]+');
		Route::resource('individuos', 'IndividuoController');

		// Setor
		Route::resource('setor', 'SetorController');
		Route::patch('setor/{id}/restore', ['as' => 'setor.restore', 'uses' => 'SetorController@restore'])->where('id', '[0-9]+');

		// Funcionario
		Route::resource('funcionario', 'FuncionarioController');
		Route::patch('funcionario/{id}/restore', ['as' => 'funcionario.restore', 'uses' => 'FuncionarioController@restore'])->where('id', '[0-9]+');

		// Manual
		Route::resource('manual', 'ManualController');

		// Caixa de Entrada
		Route::get('entrada/aberto', array('as' => 'entrada.aberto', 'uses' => 'EntradaController@aberto'));
		Route::get('entrada/pendente', array('as' => 'entrada.pendente', 'uses' => 'EntradaController@pendente'));
		Route::get('entrada/encerrado', array('as' => 'entrada.encerrado', 'uses' => 'EntradaController@encerrado'));
		Route::resource('entrada', 'EntradaController');
		Route::patch('entrada/{id}/restore', ['as' => 'entrada.restore', 'uses' => 'EntradaController@restore'])->where('id', '[0-9]+');

		// MAPAs
		Route::resource('mapa_atendimento', 'MapaAtendimentoController');
		Route::resource('mapa_individuo', 'MapaIndividuoController');
  });

	//ROTAS DE USO EXCLUSIVO AJAX/REQUEST
	Route::post('unique/{tabela}/{campo}/{tipo}/{id}', 'QuerieHelper@unique');
	Route::get('unique/{tabela}/{campo}/{tipo}/{id}', 'QuerieHelper@unique');
	Route::get('findelements/{uf}', 'QuerieHelper@findCidades');
	Route::get('finddate/{date}', 'QuerieHelper@findDate');
	// Busca de indivíduos por nome ou cpf — assets/js/atendimento.js
	Route::get('/ajaxfindPerson', 'BaseController@searchPerson');
	// Busca de funcionários por nome ou matrícula — assets/js/funcionario.js
	Route::get('/ajaxfindEmployee', 'BaseController@searchEmployee');
	// Busca Setor por nome
	Route::get('/ajaxfindDepartment', 'BaseController@searchDepartment');
	// Verifica se CPF é único
	Route::get('/findCPF/{cpf}', 'BaseController@searchCPF');
});
