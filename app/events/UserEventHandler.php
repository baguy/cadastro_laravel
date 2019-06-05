<?php

class UserEventHandler {

	/*
	protected $service;

  public function __construct(UserService $service) {

    $this->service = $service;
  }
  */

  public function onUserTrying($email) {

  	$user = User::withTrashed()->where('email', $email)->first();

  	if ($user) {

    	$throttle = $user->throttle()->first();

    	if ($throttle->attempts > 4 && strtotime($throttle->last_attempt_at . User::SUSPENSION_TIME) < strtotime('now')) {

	      $throttle->attempts = 0;

		    $throttle->last_attempt_at = null;

		    $throttle->suspended = false;

		    $throttle->update();

		    $user->restore();
    	}
  	}
  }

  public function onUserLogin($user) {

  	$throttle = $user->throttle()->first();

  	$throttle->ip_address = $this->getClientIP() ? $this->getClientIP() : $this->generateFakeIP(explode('@', $user->email)[0]);

    $throttle->last_access_at = new DateTime;

    $throttle->attempts = 0;

    $throttle->last_attempt_at = null;

    $throttle->update();
  }

  public function onUserLogout($user) {

    /*
		if (Cookie::get('laravel_access_id')) {

			$identifier = "user_{Cookie::get('laravel_access_id')}";

			if (Cache::has($identifier))

				Cache::forget($identifier);

			Cookie::forget('laravel_access_id');
		}
		*/
  }

  public function onUserAttempt($email) {

  	$user = User::where('email', $email)->first();

  	if ($user) {

    	$throttle = $user->throttle()->first();

    	//DB::beginTransaction();

	    //try {

	    	if ($throttle->attempts < 5) {

		      $throttle->attempts = $throttle->attempts + 1;

		      $throttle->last_attempt_at = new DateTime;

		      $throttle->update();

	    	} else {

	    		$throttle->suspended = true;

		      $throttle->update();

	    		$user->delete();
	    	}

	    	//DB::commit();

	    //} catch (Exception $e) {

	      //Log::warning(sprintf('Exception: %s', $e->getMessage()));

	      //DB::rollback();

	      //throw $e;
	    //}
  	}
  }


  public function subscribe($events) {

    $events->listen('auth.trying', 'UserEventHandler@onUserTrying');

    $events->listen('auth.login', 'UserEventHandler@onUserLogin');

    $events->listen('auth.logout', 'UserEventHandler@onUserLogout');

    $events->listen('auth.attempting', 'UserEventHandler@onUserAttempt');
  }

	private function getClientIP() {

		$sources = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		];

    foreach ($sources as $source) {

      if (array_key_exists($source, $_SERVER) === true) {

        foreach (explode(',', $_SERVER[$source]) as $IP_ADDRESS) {

          $IP_ADDRESS = trim($IP_ADDRESS);

          if (filter_var($IP_ADDRESS, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)

            return $IP_ADDRESS;
        }
      }
    }

    return null;
  }

  private function generateFakeIP($from) {

		$hex        = bin2hex($from);
		$replace    = preg_replace('/[^0-9]/', '', $hex);
		$IP_ADDRESS = substr($replace, 0, 12);

		if (strlen($IP_ADDRESS) < 12)

		  $IP_ADDRESS = str_pad($IP_ADDRESS, 12, "0");

		return FormatterHelper::mask('###.###.###.###', $IP_ADDRESS);
  }
}
