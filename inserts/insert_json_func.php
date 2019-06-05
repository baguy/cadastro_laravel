Route::get('/insert', 'AtendimentoController@insert');
public function insert() {
  $path = base_path().'/inserts/pessoas.json';
  $inserts = json_decode(file_get_contents($path), true);

  DB::beginTransaction();
  try {
    foreach ($inserts as $key => $registro) {
      $individuo = new Individuo(array(
        'nome' => $registro['nome'],
        'email' => isset($registro['email']) ? $registro['email'] : null,
        'cpf' => $registro['documento'],
      ));
      $individuo->save();

      $telefone_1 = new Telefone(array(
        'tipo_telefone_id' => ((strlen($registro['telefonePrincipal']) == 11) ? 2 : 1),
        'ddd' => substr($registro['telefonePrincipal'], 0, 2),
        'numero' => substr($registro['telefonePrincipal'], 2)
      ));
      $telefone_1->individuo()->associate($individuo)->save();

      if(isset($registro['telefoneSecundario']) && !empty($registro['telefoneSecundario'])) {
        $telefone_2 = new Telefone(array(
          'tipo_telefone_id' => ((strlen($registro['telefoneSecundario']) == 11) ? 2 : 1),
          'ddd' => substr($registro['telefoneSecundario'], 0, 2),
          'numero' => substr($registro['telefoneSecundario'], 2)
        ));
        $telefone_2->individuo()->associate($individuo)->save();
      }

      $bairro = Bairro::where('nome', $registro['bairro'])->first();

      $endereco = new Endereco(array(
        'logradouro' => $registro['rua'],
        'numero' => $registro['numero'],
        'bairro' => $registro['bairro'],
        'bairro_id' => $bairro['id'],
        'cep' => (isset($registro['cep']) && !empty($registro['cep'])) ? FormatterHelper::removeSignals($registro['cep']) : null,
        'cidade_id' => 3388
      ));
      $endereco->individuo()->associate($individuo)->save();

    }
    DB::commit();
    return 'success';
  } catch (\Exception $e) {
    DB::rollback();
    return $e->getMessage();
  }
}
