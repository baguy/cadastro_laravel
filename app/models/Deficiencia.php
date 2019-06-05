<?php

class Deficiencia extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'deficiencia';
    protected $fillable = ['outro', 'individuo_id', 'causa_id', 'quando_id', 'data_laudo',
                           'fisica_id', 'auditiva_id', 'visual_id', 'psicossocial_id', 'mental_id', 'braille_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoDeficienciaFisica(){
      return $this->belongsTo('TipoDeficienciaFisica', 'fisica_id', 'id');
    }

		public function tipoDeficienciaAuditiva(){
			return $this->belongsTo('TipoDeficienciaAuditiva', 'auditiva_id', 'id');
		}

		public function tipoDeficienciaMental(){
			return $this->belongsTo('TipoDeficienciaMental', 'mental_id', 'id');
		}

		public function tipoDeficienciaPsicossocial(){
			return $this->belongsTo('TipoDeficienciaPsicossocial', 'psicossocial_id', 'id');
		}

		public function tipoDeficienciaVisual(){
			return $this->belongsTo('TipoDeficienciaVisual', 'visual_id', 'id');
		}

		public function causaDeficiencia(){
			return $this->belongsTo('CausaDeficiencia', 'causa_id', 'id');
		}

		public function tipoBraille(){
			return $this->belongsTo('TipoBraille', 'tipo_braille_id', 'id');
		}

		public function quandoDeficiencia(){
			return $this->belongsTo('QuandoDeficiencia', 'quando_id', 'id');
		}

		public function getDataLaudoAttribute($data_laudo){
			if($this->attributes['data_laudo'] != null){
	    	return FormatterHelper::dateToPtBR($this->attributes['data_laudo']);
			}
		}

}
