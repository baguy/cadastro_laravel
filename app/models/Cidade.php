<?php

class Cidade extends Eloquent{

		public $timestamps  = false;
  	protected $table    = 'cidade';
    protected $fillable = array('nome', 'estado_id');

    public function endereco(){
      return $this->hasMany('Endereco', 'cidade_id', 'id');
    }

    public function bairro(){
      return $this->hasMany('Bairro', 'cidade_id', 'id');
    }

    public function estado(){
      return $this->belongsTo('Estado');
    }

		public function setCidadeAttribute($cidade){
				$this->attributes['cidade'] = DB::table('cidade')->select('id')->where('nome', '=', $cidade)->first()->id;
		}


}
