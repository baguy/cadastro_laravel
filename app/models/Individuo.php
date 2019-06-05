<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Individuo extends Eloquent {

	use SoftDeletingTrait;

  	protected $table    = 'individuo';
    protected $fillable = array('nome', 'data_nascimento', 'sexo_id', 'email');

    public function telefones(){
      return $this->hasMany('Telefone', 'individuo_id', 'id');
    }

		public function beneficios(){
			return $this->hasMany('Beneficio', 'individuo_id', 'id');
		}

		public function tipoBeneficio() {
			return $this->belongsToMany('TipoBeneficio', 'beneficio', 'individuo_id', 'tipo_beneficio_id');
		}

		public function saudes(){
			return $this->hasMany('AssistenciaSaude', 'individuo_id', 'id');
		}

		public function tipoSaude() {
			return $this->belongsToMany('TipoSaude', 'saude', 'individuo_id', 'tipo_saude_id');
		}

		public function mobilidades(){
			return $this->hasMany('Mobilidade', 'individuo_id', 'id');
		}

		public function causaMobilidade() {
			return $this->belongsToMany('CausaMobilidade', 'mobilidade', 'individuo_id', 'causa_mobilidade_id');
		}

		public function comunicacao(){
			return $this->hasMany('Comunicacao', 'individuo_id', 'id');
		}

		public function tipoComunicacao() {
			return $this->belongsToMany('TipoComunicacao', 'comunicacao', 'individuo_id', 'tipo_comunicacao_id');
		}

		public function tecnologiaAssistiva(){
			return $this->hasMany('tecnologiaAssistiva', 'individuo_id', 'id');
		}

		public function tipoTecnologiaAssistiva() {
			return $this->belongsToMany('TipoTecnologiaAssistiva', 'tecnologia_assistiva', 'individuo_id', 'tipo_tecnologia_assistiva_id');
		}

		public function medicacao(){
			return $this->hasMany('Medicacao', 'individuo_id', 'id');
		}

		public function acompanhamento(){
			return $this->hasOne('Acompanhamento', 'individuo_id', 'id');
		}

		public function quedas(){
			return $this->hasMany('Queda', 'individuo_id', 'id');
		}

		public function consequenciaQueda() {
			return $this->belongsToMany('ConsequenciaQueda', 'queda', 'individuo_id', 'consequencia_queda_id');
		}

		public function credenciais(){
			return $this->hasMany('Credencial', 'individuo_id', 'id');
		}

		public function vidaDiaria(){
			return $this->hasMany('VidaDiaria', 'individuo_id', 'id');
		}

		public function documentos(){
			return $this->hasMany('Documento', 'individuo_id', 'id');
		}

		public function grupoSociais(){
			return $this->hasMany('GrupoSocial', 'individuo_id', 'id');
		}

		public function ligacoes(){
			return $this->hasMany('Ligacao', 'individuo_id', 'id');
		}

    public function endereco(){
      return $this->hasOne('Endereco', 'individuo_id', 'id');
    }

    public function sexo(){
      return $this->hasOne('Sexo', 'id', 'sexo_id');
    }

		public function estadoCivil(){
			return $this->hasOne('EstadoCivil', 'individuo_id', 'id');
		}

		public function escolaridade(){
			return $this->hasOne('Escolaridade', 'individuo_id', 'id');
		}

		public function sugestao(){
			return $this->hasOne('Sugestao', 'individuo_id', 'id');
		}

		public function ubsCras(){
			return $this->hasOne('UbsCras', 'individuo_id', 'id');
		}

		public function parecerTecnico(){
			return $this->hasMany('ParecerTecnico', 'individuo_id', 'id');
		}

		public function informacao(){
			return $this->hasOne('Informacao', 'individuo_id', 'id');
		}

		public function moradia(){
			return $this->hasOne('Moradia', 'individuo_id', 'id');
		}

		public function renda(){
			return $this->hasOne('Renda', 'individuo_id', 'id');
		}

		public function interditado(){
			return $this->hasOne('InterditadoJudicialmente', 'individuo_id', 'id');
		}

		public function trabalho(){
			return $this->hasOne('Trabalho', 'individuo_id', 'id');
		}

		public function esporte(){
			return $this->hasOne('Esporte', 'individuo_id', 'id');
		}

		public function cultural(){
			return $this->hasOne('Cultural', 'individuo_id', 'id');
		}

		public function transporte(){
			return $this->hasMany('Transporte', 'individuo_id', 'id');
		}

		public function atendimentos(){
			return $this->hasMany('Atendimento');
		}

		public function parentescos(){
			return $this->hasMany('Parentesco', 'individuo_id', 'id');
		}

		public function deficiencias(){
			return $this->hasMany('Deficiencia', 'individuo_id', 'id');
		}

		public function tipoDeficienciaFisica() {
			return $this->belongsToMany('TipoDeficienciaFisica', 'deficiencia', 'individuo_id', 'fisica_id');
		}

		public function tipoDeficienciaAuditiva() {
			return $this->belongsToMany('TipoDeficienciaAuditiva', 'deficiencia', 'individuo_id', 'auditiva_id');
		}

		public function tipoDeficienciaVisual() {
			return $this->belongsToMany('TipoDeficienciaVisual', 'deficiencia', 'individuo_id', 'visual_id');
		}

		public function tipoDeficienciaMental() {
			return $this->belongsToMany('TipoDeficienciaMental', 'deficiencia', 'individuo_id', 'mental_id');
		}

		public function tipoDeficienciaPsicossocial() {
			return $this->belongsToMany('TipoDeficienciaPsicossocial', 'deficiencia', 'individuo_id', 'psicossocial_id');
		}

		public function telefonesFormatados(){
			$telefones = "";
			foreach($this->telefones as $key => $telefone){
				$telefones .= ($key == 0 ? '' : ' | ')."{$telefone->numero}";
			}
			return $telefones;
		}

		public function documentosFormatados(){
			$documentos = "";
			foreach($this->documentos as $key => $doc){
				$tipo = strtoupper($doc->tipoDocumento->nome);
				$documentos .= ($key == 0 ? '' : ' | ')."{$tipo} {$doc->numero}";
			}
			return $documentos;
		}

		public function getDataNascimentoAttribute(){
			if($this->attributes['data_nascimento'] != null){
	    	return FormatterHelper::dateToPtBR($this->attributes['data_nascimento']);
			}
	  }

	  public function setDataNascimentoAttribute($data){
	    	$this->attributes['data_nascimento'] = FormatterHelper::dateToMySQL($data);
	  }

}
