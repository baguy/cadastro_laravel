<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

/*
* Variáveis GLOBAIS do sistema
*/

App::before(function($request)
{
	// Singleton (global) object
	 App::singleton('contadorFuncionario', function(){
			 $data = [
				 'setor' => Setor::all(),
			 ];
			 $contadorFuncionario = 0;
			 if (count($data['setor']) > 0){
				 foreach($data['setor'] as $key => $setor){
					 if(count($setor->funcionario) > 0){
						 foreach($setor->funcionario as $key => $funcionario){
				 			$contadorFuncionario += 1;
						 }
				 	 }
				 }
			 }

			 return $contadorFuncionario;

	 });

	 $contadorFuncionario = App::make('contadorFuncionario');
	 View::share('contadorFuncionario', $contadorFuncionario);


	 App::singleton('contadorEntrada', function(){

		 $contadorEntrada=0;

		 $contadorEntrada = MainHelper::contadorEntrada($contadorEntrada);

		 return $contadorEntrada;

	 });

	 $contadorEntrada = App::make('contadorEntrada');
	 View::share('contadorEntrada', $contadorEntrada);


	 App::singleton('contadorAberto', function(){

			 $contadorAberto = 0;
			 $status = 1;

			 $contadorAberto = MainHelper::contadorView($contadorAberto, $status);

			 return $contadorAberto;

	 });

	 $contadorAberto = App::make('contadorAberto');
	 View::share('contadorAberto', $contadorAberto);


	 App::singleton('contadorPendente', function(){

			 $contadorPendente = 0;
			 $status = 2;

			 $contadorPendente = MainHelper::contadorView($contadorPendente, $status);

			 return $contadorPendente;

	 });

	 $contadorPendente = App::make('contadorPendente');
	 View::share('contadorPendente', $contadorPendente);


	 App::singleton('contadorEncerrado', function(){

			 $contadorEncerrado = 0;
			 $status = 3;

			 $contadorEncerrado = MainHelper::contadorView($contadorEncerrado, $status);

			 return $contadorEncerrado;

	 });

	 $contadorEncerrado = App::make('contadorEncerrado');
	 View::share('contadorEncerrado', $contadorEncerrado);

	/*

	$identifier = null;

	if (Cookie::get('laravel_access_id'))

		$identifier = "user_{Cookie::get('laravel_access_id')}";

	if (Auth::check() && !Cache::has($identifier))

		Cache::forever($identifier, Auth::user());

  if (!Auth::check() && !Cookie::get('laravel_session') && Cache::has($identifier))

  	Event::fire('auth.logout', Cache::pull($identifier));

  */

});

App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Role Filter
|--------------------------------------------------------------------------
|
| The Role filter is responsible for blocking routes against
| user without access permissions to do it.
|
*/

Route::filter('role', function($route, $request, $role)
{
	if (Auth::guest() or !Auth::user()->hasRole($role))
	{
		App::abort(403, 'Unauthorized action.');
	}
});

Route::filter('is-default-password', function() {

	if(Auth::user()->throttle->is_default_password)

		return Redirect::route('users.change-password', Auth::user()->id);
});
