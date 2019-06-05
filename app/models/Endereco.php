<?php

class Endereco extends Eloquent{

		public $timestamps  = false;
  	protected $table    = 'endereco_individuo';
    protected $fillable = array(
								'cep', 'numero',
								'logradouro', 'complemento',
								'cidade_id', 'tipo_logradouro_id',
								'bairro_id', 'bairro',
								'latitude', 'longitude',
							);

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoLogradouro(){
      return $this->belongsTo('TipoLogradouro');
    }

    public function cidade(){
      return $this->belongsTo('Cidade');
    }

		public function bairro(){
			return $this->belongsTo('Bairro');
		}

		public function setCepAttribute($cep){
			$this->attributes['cep'] = FormatterHelper::somenteNumeros($cep);
		}

}
