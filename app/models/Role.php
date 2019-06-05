<?php

class Role extends Eloquent {

	protected $table     = 'roles';

	public $timestamps   = false;

	protected $guarded   = array();

	public static $rules = array(
		'name' => 'required|unique:roles'
	);

	public function users() {
    return $this->belongsToMany('User', 'users_roles');
  }
}
