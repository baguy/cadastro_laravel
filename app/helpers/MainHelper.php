<?php

class mainHelper{

	/**
	* Função estática - Trata array de dados da tabela p/ exibição em selects
	* @param array $array - array c/ valores da tabela
	* @param string $value - Valor do option do select
	* @param string $descri - Texto do option
	* @return array $newArray - Array c/ valores atribuidos
	* @author Rafael Domingues Teixeira
	*/
	public static function fixArray2($field, $originals) {

		$prepend = array('' => mb_strtoupper(Lang::get('application.form.select.empty', [ 'field' => $field ]), 'UTF-8'));

		return $prepend + $originals;
	}

	public static function fixArray($array,$value,$descri,$firstopt='Selecione',$descri2=null) {
		$newArray = array(''=>$firstopt);

		foreach ($array as $array) {
			if ($descri2!=null) {
				$newArray[$array[$value]] = "nome: " . $array[$descri]. ", {$descri2}: " . $array[$descri2];
			} else {
				$newArray[$array[$value]] = $array[$descri];
			}
		}
		return $newArray;
	}

	/**
	* Função estática - Transforma valores de array em maiusculas
	* OBS: Todo os valores de array e sub-arrays serão modificados.
	* @param array $array - array c/ valores a serem alterados
	* @param array $excepts - array c/ valores a serem ignorados
	* @return array $values - Array c/ valores alterados
	* @author Rafael Domingues Teixeira
	*/
	public static function toUpperCase($values,$excepts){
		foreach ($values as $key => $value) {
			if (in_array($key,$excepts)) continue;

			if (is_array($value)) {
				$values[$key] = mainHelper::toUpperCase($value,$excepts);
			}else {
				$values[$key] = mb_strtoupper($value);
			}
		}
		return $values;
	}

	/**
	* Função estática - Retorna as cidades de acordo ID do estado
	* com os valores formatados p/ exibição em select
	* @param int $id - ID de Estado
	* @author Rafael Domingues Teixeira
	*/
	public static function selectCidades($id){
		$cidades = QuerieHelper::findelements('estado', 'cidades', $id);
		return Self::fixArray($cidades,'id','nome');
	}

	/**
	* Função estática - Retorna as unidades de acordo ID da secretaria
	* com os valores formatados p/ exibição em select
	* @param int $id - ID de Secretaria
	* @author Camila Pereira Sales
	*/
	public static function selectUnidade($id){
		$unidade = QuerieHelper::findelements('Secretaria', 'unidades', $id);
		return Self::fixArray($unidade,'id','nome');
	}

	/**
	* Função estática - retorna um valor c/ a mascara solicitada
	* @param string $val - valor a ser atribuido mascara
	* @param string $mask - Mascara utilizada (ex: ###.###.###-##)
	* @return string $maskared - valor c/ mascara atribuida
	* @author Rafael Domingues Teixeira
	*/
	public static function mask($val, $mask){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k]))
				$maskared .= $val[$k++];
			}else{
				if(isset($mask[$i]))
				$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}

	/**
	* Função estática - Exporta tabela p/ arquivo EXCEL
	* @param string $table - tabela formatada
	* @author Rafael Domingues Teixeira
	*/
	public static function exportExcel($table){
		header("Content-type: application/msexcel; charset=utf-8");
		header("Content-Disposition: attachment; filename=relatorio.xls"); // Nome que arquivo será salvo
		print chr(255) . chr(254) . mb_convert_encoding($table, 'UTF-16LE', 'UTF-8');
	}

	/**
	* Função estática - Exporta conteúdo p/ arquivo PDF
	* @param string $content - conteúdo a ser exportado
	* @param string $style - formatação da página importada. *[paper: ... position: ...]*
	* @return $pdf - página em PDF
	* @author Wiatan Oliveira Silva
	* @author Rafael Domingues Teixeira
	*/
	public static function exportPdf($content,$style){
		$pdf = App::make('dompdf');
		$pdf->setPaper($style['paper'], $style['position']);
		$pdf->loadHTML($content);
		return $pdf;
	}

	/**
	* Função estática - Verifica se conexão com IP está disponível ou não.
	* @param string $ip - IP de conexão
	* @param string $port - porta de conexão
	* @return int $connected - Valor true ou false de acordo com conexão
	* @author Rafael Domingues Teixeira
	* @since 23/02/2018
	*/
	public static function check_ip($ip, $port){
		$connected = @fsockopen($ip, $port);
		fclose($connected);
		return $connected;
	}

	/**
	* Função para enviar emails
	* @param object $atendimento
	* @author Mayra Dantas Bueno
	* @since 27/02/2019
	*/
	public static function mandaEmail($atendimento){
		// Iteração para criar dois arrays com nomes e emails apenas dos funcionários
		// do(s) setor(es) selecionado(s) para o atendimento sendo salvo
		$nomes=[];
		$emails=[];
		$count=0;
		foreach($atendimento->setor as $key => $item){
			foreach($item->funcionario as $key2 => $item2){
				$nomes[$key][$key2] = $item2->nome;
				$emails[$key][$key2] = $item2->email;
				$count+=1;
			}
		}

		// Envia os emails para os funcionários
		// (se funcionário é cadastrado com email igual ao de outro, envia apenas para um)
		Mail::send('emails.notificacao', array('key' => $atendimento), function($message) use($atendimento, $nomes, $emails)
		{
			foreach($atendimento->setor as $key => $item){
				foreach($item->funcionario as $key2 => $item2){
					$message->to($emails[$key][$key2],  $nomes[$key][$key2])->subject('Novo Atendimento!');
				}
			}
		});
	}

	/**
	* Função p/ encontrar chave (de array retornado do BD)
	* de cada tipo de deficiência do indivíduo da tabela 'deficiencias'
	* @param object $tipo_deficiencia e $indivíduo
	* @return chave
	* @author Mayra Dantas Bueno
	* @since 28/03/2019
	*/
	public static function deficienciaOffset($tipo_deficiencia, $individuo){
		$offset=null;
		foreach( $individuo->deficiencias as $key  => $value){
		  if($value->$tipo_deficiencia != ''){
		    $offset = $key;
		  }
		}
		return $offset;
	}

	/**
	* Se parâmetro for array —
	* Função p/ retornar apenas atendimentos com determinado status
	* Se parâmetro for variável —
	* Função p/ retornar apenas variável inteira com contagem de status de atendimentos
	* Status: 1.ABERTO, 2.EM ANDAMENTO ou 3.ENCERRADO (valor int do BD)
	* Usado em app/filter.php em app/controllers/EntradaController.php
	* @param object $vetor e $status equivalente ao status do atendimento
	* @return vetor ou int
	* @author Mayra Dantas Bueno
	* @since 29/03/2019
	*/
	public static function contadorView($contador, $status){

		$data = [
			'atendimento' => Atendimento::all(),
		];

		if ( isset(Auth::user()->funcionario_id) ){
			foreach ( $data['atendimento'] as $key2 => $atendimento ){
				if ( $atendimento->status_id == $status ){
					unset($a);
						if( isset($atendimento->assentamentos[0]) ){
							foreach( $atendimento->assentamentos as $key3 => $assentamento ){
								foreach( $assentamento->setor as $key4 => $setor ){
										$a[$key4] = $setor->nome;
								 } //setor
							 } //assentamento
							 if( isset($a[0]) ){
								 foreach ( Auth::user()->funcionario->setor as $key => $setor ){
									 if( $a[0] === $setor->nome ){
										 if(is_array($contador)){
										 	$contador[$key2] = $atendimento;
									   }else{
											$contador += 1;
										}
									 }
								 }
							 }
						}
						else{
							 foreach ( $atendimento->setor as $key5 => $atendimento_setor ){
								 foreach ( Auth::user()->funcionario->setor as $key => $setor ){
									 if( $atendimento_setor->nome == $setor->nome ){
										 if(is_array($contador)){
											$contador[$key2] = $atendimento;
										 }else{
											$contador += 1;
										}
								 }
							 }
						 }
					 }
				 }
			} //atendimento
		}

		if(is_array($contador)){
			foreach($contador as $key => $value){
					if(empty($value)){
						unset($contador[$key]);
					}
				}
		}

		return $contador;

	}


	/**
	* Função p/ retornar valor inteiro de atendimentos de setor(es) do usuário
	* caso usuário tenha cadastrado setores em seu perfil para caixa de Entrada
	* Caixa de Entrada: sidebar (variável global — filter.php)
	* @param object variável inteira
	* @return int variável contador
	* @author Mayra Dantas Bueno
	* @since 29/03/2019
	*/
	public static function contadorEntrada($contador){

		$data = [
			'atendimento' => Atendimento::all(),
		];

		if ( isset(Auth::user()->funcionario_id) ){
			foreach ( $data['atendimento'] as $key2 => $atendimento ){
				if( $atendimento->status_id != 3 ){
					unset($a);
						if( isset($atendimento->assentamentos[0]) ){
							foreach( $atendimento->assentamentos as $key3 => $assentamento ){
								foreach( $assentamento->setor as $key4 => $setor ){
										$a[$key4] = $setor->nome;
								 } //setor
							 } //assentamento
							 if( isset($a[0])){
								 foreach ( Auth::user()->funcionario->setor as $key => $setor ){
									 if( $a[0] === $setor->nome ){
										 $contador += 1;
									 }
								 }
							 }
						}else{
							 foreach ( $atendimento->setor as $key5 => $atendimento_setor ){
								 foreach ( Auth::user()->funcionario->setor as $key => $setor ){
									 if( $atendimento_setor->nome == $setor->nome ){
										 $contador += 1;
								 }
							 }
						 }
					 }
				 }
			} //atendimento
		}

		return $contador;

	}

	/**
	* Função calcular idade
	* @param object data no formato dd/mm/AAAA
	* @return int variável contador
	* @author Mayra Dantas Bueno
	* @since 10/04/2019
	*/
public static function calculaIdade($data){

	$birthDate = FormatterHelper::dateToEn($data);
  //explode the date to get month, day and year
  $birthDate = explode("/", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));

		return $age;

}

public static function deficienciaFisicaVetor($id){
	$deficienciaFisica = [];
	$key2 = 0;
	$individuo = Individuo::find($id);
	foreach($individuo->deficiencias as $key => $value){
		if($value->fisica_id)
			$deficienciaFisica[$key2] = $value;
			$key2+=1;
	}
	return $deficienciaFisica;
}

public static function deficienciaAuditivaVetor(){
	$deficienciaAuditiva = [];
	$key2 = 0;
	$individuo = Individuo::find($id);
	foreach($individuo->deficiencias as $key => $value){
		if($value->auditiva_id != '')
			$deficienciaAuditiva[$key2] = $value;
			$key2+=1;
	}
	return $deficienciaAuditiva;
}

public static function deficienciaMentalVetor(){
	$deficienciaMental = [];
	$key2 = 0;
	$individuo = Individuo::find($id);
	foreach($individuo->deficiencias as $key => $value){
		if($value->auditiva_id != '')
			$deficienciaMental[$key2] = $value;
			$key2+=1;
	}
	return $deficienciaMental;
}

public static function deficienciaVisualVetor(){
	$deficienciaVisual = [];
	$key2 = 0;
	$individuo = Individuo::find($id);
	foreach($individuo->deficiencias as $key => $value){
		if($value->visual_id != '')
			$deficienciaVisual[$key2] = $value;
			$key2+=1;
	}
	return $deficienciaVisual;
}

public static function deficienciaPsicossocialVetor(){
	$deficienciaPsicossocial = [];
	$key2 = 0;
	$individuo = Individuo::find($id);
	foreach($individuo->deficiencias as $key => $value){
		if($value->psicossocial_id != '')
			$deficienciaPsicossocial[$key2] = $value;
			$key2+=1;
	}
	return $deficienciaPsicossocial;
}


}// .mainHelper

?>
