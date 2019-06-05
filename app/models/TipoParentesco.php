<?php

class TipoParentesco extends Eloquent {

		public $timestamps = false;
  	protected $table    = 'tipo_parentesco';

    public function parentesco(){
      return $this->hasMany('Parentesco', 'tipo_parentesco_id', 'id');
    }
  // 
	// 	public function setTipoParentescoAttribute($tipo_parentesco_id){
	// 		$this->attributes['tipo_parentesco'] = DB::table('tipo_parentesco')->select('id')->where('tipo', '=', $tipo)->first()->id;
	// }

}
