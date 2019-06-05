<?php

class EstadoCivil extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'estado_civil';
    protected $fillable = ['data_casamento', 'tipo_estado_civil_id', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoEstadoCivil(){
      return $this->belongsTo('TipoEstadoCivil', 'tipo_estado_civil_id', 'id');
    }

		public function getDataCasamentoAttribute(){
	    return FormatterHelper::dateToPtBR($this->attributes['data_casamento']);
	  }

	  public function setDataCasamentoAttribute($data){
	    $this->attributes['data_casamento'] = FormatterHelper::dateToEn($data);
	  }

}
