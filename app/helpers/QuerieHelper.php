<?php

class QuerieHelper extends Controller{

  public function unique($tabela,$campo,$tipo=null,$id=null){
    $dados = Input::all();

    foreach ($dados as $offset => $dado) {
      if(is_array($dado)){
        foreach ($dado as $value) {
          $dado = $value;
        }
      }
      $data['value'] = ($offset != 'email')? FormatterHelper::removeSinais($dado): $data['value'] = $dado;

      if($offset == 'email_institucional') $data['value'] = $dado."@caraguatatuba.sp.gov.br";
    }

    $validacao = Validator::make($data, UniqueValidator::rules($tabela,$campo,$tipo,$id), UniqueValidator::msgs($data));
    if($validacao->passes()) return 'true';
    return 'false';
  }


  /**
  * Função estática - retorna resultado(s) conforme busca em relação do modelo
  * @param string $model - Model onde será buscado a relação
  * @param string $relacao - relação referente ao modelo informado
  * @return object Resultado(s) da relação c/ o modelo
  * @author Rafael Domingues Teixeira
  */
  public static function findElements($model, $relacao, $id){
    $result = $model::find($id);
    return $result->$relacao;
  }

  /**
	 * Encontrar cidades dependendo do estado selecionado no formulário de Indivíduo e Atendimento
	 * Recebe UF do estado -> encontra ID do estado -> pega lista de cidades relacionadas à ID do estado
   * @author Mayra Dantas Bueno
	 */
  public static function findCidades($uf){
      $id = DB::table('estado')->select('id')->where('uf', '=', $uf)->first()->id;
      $cidades = DB::table('cidade')->select('id', 'nome')->orderBy('nome', 'asc')->where('estado_id','=', $id)->get();
      return $cidades;
  }

  public static function relationsFilters(){
    return $whereHas = [
      'idosos'          => ['participantes'],               'situacao_rua'   => ['participantes', 'moradia'],
      'deficiencia'     => ['participantes','deficiencia'], 'cronica'        => ['participantes', 'deficiencia'],
      'm_chefe_familia' => ['participantes', 'social'],     'area_risco'     => ['participantes', 'social'],
      'coabitacao'      => ['participantes', 'social'],     'lei_m_penha'    => ['participantes', 'social'],
      'beneficio'       => ['participantes', 'social'],     'aluguel_social' => ['participantes', 'social'],
      'bairro'          => ['titular', 'enderecos'],        'regiao'         => ['titular', 'enderecos'],
      'tipo_data'       => ['titular', 'alteracoes'],       'microcefalia'   => ['participantes', 'deficiencia'],
      'aguardando'      => ['titular','aprovacoes'],        'aprovado'       => ['titular','aprovacoes'],
      'usuario'         => ['usuario','nivel']
    ];
  }

  public static function filterWhere($query, $filtro, $input){
    $booleanWhere = ['m_chefe_familia','area_risco','coabitacao','cronica','situacao_rua','lei_m_penha','aluguel_social'];

    if($filtro == 'idosos'){
      $query->where('data_nascimento','<=',date(Carbon\Carbon::now()->subYears(65)));
    }elseif ($filtro == 'deficiencia') {
      $query->where('tipo_deficiencia_id','!=',0);
    }elseif ($filtro == 'beneficio') {
      $query->where('tipo_beneficio_id','!=',0);
    }elseif (in_array($filtro,$booleanWhere)) {
      $query->where($filtro,true);
    }elseif ($filtro == 'tipo_data') {
      $inicial = FormatterHelper::brToEnDate($input['data_inicio']).' 00:00:00';
      $final = FormatterHelper::brToEnDate($input['data_final']).' 23:59:59';
      if ($input['data_inicio'] !== '' && $input['data_final'] !== '') {
        if ($input['filtro'][$filtro] == 'create') {
          $query = $query->whereBetween('aprovacoes.created_at', array($inicial, $final));
          ($input['tipo_origem'] != 'externo')?$query->where('tipo',$input['tipo_origem'])->where('alteracao','cadastro'):$query->where('tipo',"!=", 'web')->where('tipo',"!=", 'SECHAB')->where('alteracao','cadastro');
        }elseif ($input['filtro'][$filtro] == 'update') {
          $query = $query->whereBetween('alteracoes.updated_at', array($inicial, $final))->whereRaw('alteracoes.created_at != alteracoes.updated_at');
          $query->whereHas('unidade', function($query) use($input) {
            $query->whereHas('secretaria', function($query) use($input) {
              if ($input['tipo_origem'] != 'externo') {
                $query->where('sigla', $input['tipo_origem']);
              }else {
                $query->where('sigla', '!=','SECHAB');
              }
            });
          });
        }
      }
    }elseif ($filtro == 'bairro') {
      $query->where('bairro',$input['filtro']['bairro']);
    }elseif ($filtro == 'regiao') {
      $query->whereHas('bairro', function($regiao) use($input) {
        $regiao->where('regiao_id',$input['filtro']['regiao']);
      });
    }elseif($filtro == 'portaria_nome'){
      $query->withTrashed()->where('nome','like','%'.$input.'%');
    }elseif ($filtro == 'portaria_data_nascimento') {
      $query->where('data_nascimento',$input);
    }elseif ($filtro == 'portaria_nis') {
      $input = FormatterHelper::removeSinais($input);
      $query->where('numero',$input)->where(function ($query) {
        $query->where('tipo','nis');
      });
    }elseif ($filtro == 'portaria_cpf') {
      $input = FormatterHelper::removeSinais($input);
      $query->where('numero',$input)->where(function ($query) {
        $query->where('tipo','cpf');
      });
    }elseif ($filtro == 'portaria_rg') {
      $input = FormatterHelper::removeSinais($input);
      $query->where('numero',$input)->where(function ($query) {
        $query->where('tipo_documento_id', '=', 8);
      });
    }elseif ($filtro == 'microcefalia'){
        $query->where('microcefalia', 1);
    }elseif ($filtro == 'aguardando') {
      $query->where('id',DB::raw("(SELECT MAX(id) AS maxid FROM aprovacoes where aprovacoes.individuo_id = grupo_familiar.individuo_id GROUP BY individuo_id ORDER BY individuo_id desc)"))->whereRaw('(aprovado is null or aprovado = 0)');
    }elseif ($filtro == 'aprovado') {
      $query->where('id',DB::raw("(SELECT MAX(id) AS maxid FROM aprovacoes where aprovacoes.individuo_id = grupo_familiar.individuo_id GROUP BY individuo_id ORDER BY individuo_id desc)"))->where('aprovado', 1);
    }
  }

  /**
  * Função estática - Transforma valores em um objeto de paginação do laravel
  * @param array $values - valores a serem paginados
  * @param int $perPage - Quantidade de valores por página
  * @return object $pagination - Retorna valores páginados
  * @author Rafael Domingues Teixeira
  */
  public static function PaginationMake($values,$perPage){
    $pagination = App::make('paginator');
    $count = $values->count();
    $page = $pagination->getCurrentPage($count);
    $items = $values->slice(($page - 1) * $perPage, $perPage)->all();
    $pagination = $pagination->make($items, $count, $perPage);
    return $pagination;
  }

}
?>
