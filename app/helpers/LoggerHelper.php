<?php

class LoggerHelper {

  // Log Register - First records on database and after 10 days exports them to file text
  public static function log($action, $message) {

    $FOLDER_PATH = storage_path("logs/");

    if (date('d') >= 1 && date('d') <= 10)
      $filename = date('Y-m-30', strtotime(" -1 month"));

    if (date('d') > 10 && date('d') <= 20)
      $filename = date('Y-m-10');

    if (date('d') > 20 && date('d') <= 31)
      $filename = date('Y-m-20');

    $filepath = $FOLDER_PATH.$filename.".log";

    if (!file_exists($filepath)) {

      $file = fopen($filepath, 'a');

      $logs = Logger::all();

      foreach ($logs as $log) {

        $register = Self::getRegister($log);

        fwrite($file, $register);
      }

      fclose($file);

      Logger::truncate();
    }


    $log     = Logger::orderBy('id', 'DESC')->first();
    $today   = date('Y-m-d H:i:s');
    $user    = null;
    $minutes = '+10 minutes';

    if (Auth::check())
      $user = Auth::user()->id;

    if (is_null($log)
        || ($log->message !== $message
        || $log->user_id !== (Auth::guest() ? null : Auth::user()->id)
        || $action === 'AUTH'
        || strtotime($log->created_at . $minutes) < strtotime($today))) {

      Logger::create([
        'action'  => $action,
        'message' => $message,
        'user_id' => $user
      ]);
    }
  }

  // Log Retrieve - Restore logs from files and database from oldest to most recent ones
  public static function get($search = null) {

    $logs = [];

    if ($search) {

      Self::log('SEARCH', Lang::get('logs.msg.index.search', [
        'resource' => 'LOGGER', 'parameter' => $search
      ]));

      $FOLDER_PATH = storage_path("logs/");

      $files       = scandir($FOLDER_PATH);

      $ignored     = ['.', '..', '.gitignore', 'laravel.log'];

      foreach ($files as $file) {

        if (in_array($file, $ignored)) continue;

        $filepath = $FOLDER_PATH.$file;

        $contents = file_get_contents($filepath);

        $pattern  = preg_quote($search, '/');

        $pattern  = "/^.*$pattern.*\$/mi";

        if(preg_match_all($pattern, $contents, $matches))
          $logs[] = $matches[0];
      }

      $loggers = Logger::where('action', 'LIKE', "%{$search}%")
        ->orWhere('message', 'LIKE', "%{$search}%")
        ->orWhere('created_at', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($q) use ($search) {
          $q->where('email', 'LIKE', "%{$search}%");
        })->get();

      foreach ($loggers as $log) {

        $register = Self::getRegister($log);

        $logs[2][] = $register;
      }

    }

    return $logs;
  }

  // Color for each action
  public static function getColors() {

    return [
      'AUTH'    => 'success',
      'CREATE'  => 'primary',
      'DELETE'  => 'dark',
      'DESTROY' => 'danger',
      'EDIT'    => 'info',
      'INDEX'   => 'secondary',
      'RESTORE' => 'warning',
      'SEARCH'  => 'secondary',
      'SHOW'    => 'secondary',
      'UPDATE'  => 'info',
      'EXPORT'  => 'export',
      'REPORT'  => 'report'
    ];
  }

  // Icon for each action
  public static function getIcons() {

    return [
      'AUTH'    => 'lock',
      'CREATE'  => 'plus',
      'DELETE'  => 'times',
      'DESTROY' => 'trash-alt',
      'EDIT'    => 'pencil-alt',
      'INDEX'   => 'list-ul',
      'RESTORE' => 'recycle',
      'SEARCH'  => 'search',
      'SHOW'    => 'eye',
      'UPDATE'  => 'sync',
      'EXPORT'  => 'table',
      'REPORT'  => 'file-alt'
    ];
  }

  // Regiister Maker - Put all the pieces together to make a register line
  private static function getRegister($log) {

    $action     = $log->action;
    $created_at = $log->created_at;
    $message    = $log->message;
    $user       = 'NO USER';
    $role       = 'ANONYMOUS';

    if (!is_null($log->user)) {

      $user = "({$log->user_id}) {$log->user->email}";
      $role = $log->user->minRole()->name;
    }

    $register = "$created_at | [ $user : $role ] | $action | $message \r\n";

    return $register;
  }
}
