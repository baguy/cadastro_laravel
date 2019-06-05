<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
  app_path().'/events',
	app_path().'/models',
	app_path().'/models/builders',
	app_path().'/database/seeds',
	app_path().'/helpers',
  app_path().'/services',
	app_path().'/validators',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);

  if (Config::get('app.debug'))
  	return;

  if ($exception instanceof \Illuminate\Session\TokenMismatchException) {

    Session::regenerateToken();

    return Redirect::back()
                      ->withInput(Input::except('_token'))
                      ->with('_warn', Lang::get('application.msg.error.validation-token-expired'));
  }

  switch($code) {

    case 403: /* permission denied */
    	return View::make('errors.403');

    case 404: /* not found */
      return View::make('errors.404');

    case 500: /* internal error */
      return View::make('errors.500');

    default: /* default error */
      return View::make('errors.default', array('code' => $code, 'exception' => $exception));
  }
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});
Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new CustomValidate($translator, $data, $rules, $messages);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

require app_path().'/validators.php';

/*
|--------------------------------------------------------------------------
| Event Handlers
|--------------------------------------------------------------------------
|
| Next we will load the event handlres for the application. This gives us
| a nice separate location to store our application listeners
| instead of putting them all in the main global file.
|
*/

Event::subscribe('UserEventHandler');
