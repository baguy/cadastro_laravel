<?php

class AtendimentoService extends BaseService {

  protected $atendimento;

  public function __construct(Atendimento $atendimento) {
    $this->atendimento = $atendimento;
  }

  public function store($input) {

    $input['user_id'] = Auth::user()->id;

    DB::beginTransaction();

    try {
      $atendimento = Atendimento::create($input);

      foreach ($input['tipo_atendimento_id'] as $tipoAtendimento) {
        $atendimento->tipoAtendimento()->attach($tipoAtendimento);
      }

      if(!empty($input['setor_id'])){
        foreach ($input['setor_id'] as $setor) {
          $atendimento->setor()->attach($setor);
        }
      }

      if ($input['cidade'] != ""){
        // ENDEREÇO
        $endereco = new EnderecoAtendimento($input);
        $endereco->bairro	  		= $input['bairro'];
        $input['bairro'] 				= FormatterHelper::bairroId($input['bairro'], $input['cidade']);
        $input['cidade'] 				= FormatterHelper::cidadeId($input['cidade']);
        $endereco->cidade_id 		= $input['cidade'];
        if( is_numeric($input['bairro']) ){
        	$endereco->bairro_id	= $input['bairro'];
        }
        $endereco->atendimento()->associate($atendimento)->save();
      }

      // Assentamento
      foreach ($input['new_assentamento'] as $key => $assentamento) {
        if (!empty($assentamento)) {
          $new_assentamento = Assentamento::create(array(
                              'descricao'      => $assentamento,
                              'atendimento_id' => $atendimento->id,
                              'user_id'        => $input['user_id']));

          if(!empty($input['setor_assentamento_id'])){
            foreach ($input['setor_assentamento_id'] as $setor) {
              $new_assentamento->setor()->attach($setor);
            }

            $count = false;
              $assentamento_email = $new_assentamento->id;
              if($assentamento_email['email_enviado'] == null){
                $funcionarios = DB::table('setor_funcionario_setor')->where('setor_id', '=', $input['setor_assentamento_id']);
                if($funcionarios != null){
                  $count = true;
                }
              }
              if($count == true){
                MainHelper::mandaEmail($new_assentamento);
                $new_assentamento['email_enviado'] = 1;
              }

          }

          LoggerHelper::log('CREATE', Lang::get('atendimento.assentamento.msg.create', [
            'resource'     => Self::getTable($new_assentamento),
            'assentamento' => $new_assentamento->id,
            'atendimento'  => $atendimento->id
          ]));
        }
      }

      LoggerHelper::log('CREATE', Lang::get('logs.msg.create', [
        'resource'  => Self::getTable($this->atendimento),
        'id'        => $atendimento->id
      ]));

      // Status
      if( isset($input['status_encerrado']) ){
        $atendimento['status_id'] = 3;
        $atendimento->save();
      }
      elseif( $input['new_assentamento'][0] != '' ){
        $atendimento['status_id'] = 2;
        $atendimento->save();
      }else{
        $atendimento['status_id'] = 1;
        $atendimento->save();
      }

      // Email
      $count = false;
      if(!empty($input['setor_assentamento_id'])){
        $funcionarios = DB::table('setor_funcionario_setor')->where('setor_id', '=', $input['setor_assentamento_id']);
        if($funcionarios != null){
          $count = true;
        }
      }
      elseif(!empty($input['setor_id'])){
        $funcionarios = DB::table('setor_funcionario_setor')->where('setor_id', '=', $input['setor_id']);
        if($funcionarios != null){
          $count = true;
        }
      }
      if($count == true){
        MainHelper::mandaEmail($atendimento);
        $atendimento['email_enviado'] = 1;
        $atendimento->save();
      }

      DB::commit();

    } catch (\Exception $e) {
      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }


  public function update($input, $id) {

    DB::beginTransaction();

    try {
      $atendimento = $this->atendimento->find($id);

      if(isset($input['titulo'])) {
        $atendimento->fill($input);
        $changes = $atendimento->tipoAtendimento()->sync($input['tipo_atendimento_id']);

        foreach ($changes as $operation => $array) {
          foreach ($array as $j => $value) {
            $type = ($operation =='attached') ? 'create' : 'delete';
            LoggerHelper::log(strtoupper($type), Lang::get('atendimento.categoria.msg.'.$type, [
              'resource'  => Self::getTable($atendimento->tipoAtendimento()),
              'tipo'      => $value,
              'id'        => $atendimento->id
            ]));
          }
        }
      }

      if(isset($input['setor_id'])) {
        $atendimento->fill($input);
        $changes = $atendimento->setor()->sync($input['setor_id']);

        foreach ($changes as $operation => $array) {
          foreach ($array as $j => $value) {
            $type = ($operation =='attached') ? 'create' : 'delete';
            LoggerHelper::log(strtoupper($type), Lang::get('atendimento.categoria.msg.'.$type, [
              'resource'  => Self::getTable($atendimento->tipoAtendimento()),
              'tipo'      => $value,
              'id'        => $atendimento->id
            ]));
          }
        }
      }

      $input['user_id'] = Auth::user()->id;

      if($input['cidade'] != ""){
        $atendimento_endereco = $this->atendimento->with('endereco')->find($id)->endereco;
        // Endereço
          if( $atendimento_endereco != '' ){
            $atendimento_endereco->fill($input);
            Self::hasChanges($atendimento_endereco, array());

          $input['cidade'] = FormatterHelper::cidadeId($input['cidade']);
          $atendimento_endereco->cidade_id = $input['cidade'];

          // SE bairro inserido no campo texto for compatível com bairro no banco de dados de Caraguatatuba,
          // salva a ID e o bairro digitado
          // SENÃO salva apenas o bairro digitado
          if( is_numeric($input['bairro']) ){
            $atendimento_endereco->bairro_id = $input['bairro'];
            $atendimento_endereco->bairro    = FormatterHelper::bairroId($input['bairro'], $input['cidade']);
          }else{
            $atendimento_endereco->bairro = $input['bairro'];
          }
          $atendimento_endereco->update();
        }else{
          if ($input['cidade'] != ""){
            // ENDEREÇO
            $endereco = new EnderecoAtendimento($input);
            $endereco->bairro	  		= $input['bairro'];
            $input['bairro'] 				= FormatterHelper::bairroId($input['bairro'], $input['cidade']);
            $input['cidade'] 				= FormatterHelper::cidadeId($input['cidade']);
            $endereco->cidade_id 		= $input['cidade'];
            $endereco->latitude     = $input['latitude'];
            $endereco->longitude    = $input['longitude'];
            if( is_numeric($input['bairro']) ){
              $endereco->bairro_id	= $input['bairro'];
            }
            $endereco->atendimento()->associate($atendimento)->save();
          }
        }
      }

      // Atualiza os existentes ASSENTAMENTOS e deleta os que foram removidos
      foreach ($atendimento->assentamentos as $key => $assentamento) {

        if (isset($input['assentamento'][$key]) && !empty($input['assentamento'][$key])) {

          if (strcasecmp($input['assentamento'][$key], $assentamento->descricao) != 0) {
            $assentamento->fill(array('descricao' => $input['assentamento'][$key], 'user_id' => $input['user_id']));
            $assentamento->update();

            if(!empty($input['setor_assentamento_id'])){
              foreach ($input['setor_assentamento_id'] as $setor) {
                $assentamento->setor()->attach($setor);
              }
            }

            LoggerHelper::log('UPDATE', Lang::get('atendimento.assentamento.msg.update', [
              'resource'     => Self::getTable($assentamento),
              'assentamento' => $assentamento->id,
              'atendimento'  => $atendimento->id
            ]));
          }
        } else {
          $assentamento->delete();

          LoggerHelper::log('DELETE', Lang::get('atendimento.assentamento.msg.delete', [
            'resource'  => Self::getTable($assentamento),
            'assentamento' => $assentamento->id,
            'atendimento'  => $atendimento->id
          ]));
        }
      }


      if (isset($input['new_assentamento'])) {

        foreach ($input['new_assentamento'] as $key => $assentamento) {
          if (!empty($assentamento)) {
            $new_assentamento = Assentamento::create(array('descricao' => $assentamento,'atendimento_id' => $atendimento->id, 'user_id' => $input['user_id']));

            if(!empty($input['setor_assentamento_id'])){
                foreach ($input['setor_assentamento_id'] as $setor) {
                  $new_assentamento->setor()->attach($setor);
                }
            }
            if(!empty($input['new_setor_assentamento_id'])){
                foreach ($input['new_setor_assentamento_id'] as $setor) {
                  $new_assentamento->setor()->attach($setor);
                }
            }

            LoggerHelper::log('CREATE', Lang::get('atendimento.assentamento.msg.create', [
              'resource'     => Self::getTable($new_assentamento),
              'assentamento' => $new_assentamento->id,
              'atendimento'  => $atendimento->id
            ]));
          }
        }
      }


      // Status
      if( isset($input['status_encerrado']) ){
        $atendimento['status_id'] = 3;
        if(isset($input['tipo_encerrado'])){
          $atendimento_encerrado = $this->atendimento->with('encerrado')->find($id)->encerrado;
          // Tipo Encerrado
          if( !is_null($atendimento_encerrado) ){
            $atendimento_encerrado->tipo_encerrado_id = $input['tipo_encerrado'];
            $atendimento_encerrado->update();
          }else{
            $encerrado = new Encerrado($input);
            $encerrado->tipo_encerrado_id = $input['tipo_encerrado'];
            $encerrado->atendimento()->associate($atendimento)->save();
          }
        }
        $atendimento->save();
      }
      elseif( !empty($input['assentamento'][0]) || $input['new_assentamento'][0] != '' ){
        $atendimento['status_id'] = 2;
        $atendimento->save();
      }


      if(!empty($input['new_setor_assentamento_id'])){
        $count = false;
          $assentamento_email = Assentamento::find($new_assentamento->id);
          if($assentamento_email['email_enviado'] == null){
            $funcionarios = DB::table('setor_funcionario_setor')->where('setor_id', '=', $input['new_setor_assentamento_id']);
            if($funcionarios != null){
              $count = true;
            }
          }
          if($count == true){
            MainHelper::mandaEmail($atendimento);
            $atendimento['email_enviado'] = 1;
          }
      }
      else{
        $count = false;
          if( isset($input['setor_id'][0]) || !empty($input['setor_id'])){
            $atendimento_email = Atendimento::find($atendimento->id);
            if($atendimento_email['email_enviado'] == null){
              $funcionarios = DB::table('setor_funcionario_setor')->where('setor_id', '=', $input['setor_id']);
              if($funcionarios != null){
                $count = true;
              }
            }
          }
          if($count == true){
            MainHelper::mandaEmail($atendimento);
            $atendimento['email_enviado'] = 1;
          }
      }

      Self::hasChanges($atendimento);

      $atendimento->save();

      DB::commit();

    } catch (\Exception $e) {
      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function destroy($id) {

    DB::beginTransaction();

    try {
      $atendimento = $this->atendimento->find($id);
      $atendimento->delete();

      LoggerHelper::log('DESTROY', Lang::get('logs.msg.destroy', [
        'resource'  => Self::getTable($this->atendimento),
        'id'        => $atendimento->id
      ]));

      DB::commit();

    } catch (\Exception $e) {
      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function restore($id) {

    DB::beginTransaction();

    try {
      $atendimento = $this->atendimento->withTrashed()->find($id);
      $atendimento->restore();

      LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', [
        'resource'  => Self::getTable($this->atendimento),
        'id'        => $atendimento->id
      ]));

      DB::commit();

    } catch (\Exception $e) {
      Log::warning(sprintf('Exception: %s', $e->getMessage()));

      DB::rollback();

      throw $e;
    }
  }

  public function export($atendimento, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = Lang::get('relatorio_atendimentos');

    $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'xls':

        Excel::create($title . ' - ' . $date, function($excel) use ($atendimento, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($atendimento, $parameters) {

              LoggerHelper::log('REPORT', Lang::get('logs.msg.report', [
                'resource'   => parent::getTable($this->atendimento),
                'parameters' => json_encode($parameters)
              ]));

              $sheet->loadView('atendimento.report', array('atendimento' => $atendimento));

            });

          LoggerHelper::log('EXPORT', Lang::get('logs.msg.export', [
            'resource'   => parent::getTable($this->atendimento),
            'format'     => '.xls',
            'parameters' => json_encode($parameters)
          ]));

        })->download('xls');

        break;

      case 'pdf':

        # code...

        break;
    }
  }

}
