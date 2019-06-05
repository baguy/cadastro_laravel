<?php

class AtendimentoController extends BaseController {

  protected $atendimento;

  protected $service;

  public function __construct(Atendimento $atendimento, AtendimentoService $service) {

    $this->atendimento = $atendimento;
    $this->service = $service;

    $this->beforeFilter('role:ADMIN', array('only' => array('destroy', 'restore')));
  }

  public function index() {

    $data = array(
      'individuos' => array('' => 'SELECIONE O INDIVÍDUO'),
      'categorias' => array_except(MainHelper::fixArray(TipoAtendimento::all(), 'id', 'tipo'), ''),
      'status' => MainHelper::fixarray(Status::all(), 'id', 'tipo', 'SELECIONE O STATUS'),
      'setor' => array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
    );
    array_push($data['status'], 'INATIVO');

    return View::make('atendimento.index', compact('data'));
  }

  public function create() {

    $data = array(
      'individuos'   => array('' => 'SELECIONE O INDIVÍDUO'),
      'sexos' 			 => 	Sexo::all(),
      'tipo_telefone'	=>	MainHelper::fixArray(TipoTelefone::orderBy('tipo', 'asc')->get(), 'id', 'tipo'),
      'categorias'   => array_except(MainHelper::fixArray(TipoAtendimento::all(), 'id', 'tipo'), ''),
      'status'       => MainHelper::fixarray(Status::all(), 'id', 'tipo', 'SELECIONE O STATUS'),
      'estado'		 	 => MainHelper::fixArray(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
      'bairro'		 	 => MainHelper::fixArray(Bairro::orderBy('nome', 'asc')->get(), 'id', 'nome'),
      'cidade'			 => MainHelper::fixArray(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
      'setor'        => array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
      'tipo_encerrado' => MainHelper::fixArray(TipoEncerrado::orderBy('nome', 'asc')->get(), 'id', 'nome'),
    );

    return View::make('atendimento.create', compact(['data']));
  }

  public function store() {

    $input = Input::all();
    $validator = AtendimentoValidator::store($input);

    if($validator->passes()) {
      try {

        $this->service->store($input);
        return Redirect::route('atendimento.index')->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

      } catch (\Exception $e) {
        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }
    return Redirect::route('atendimento.create')
    ->withErrors($validator)
    ->withInput()->with('_error', Lang::get('application.msg.error.validation-errors'));
  }


  public function show($id) {
    $data = array(
      'atendimento' => $this->atendimento->withTrashed()->find($id),
    );

    LoggerHelper::log('SHOW', Lang::get('logs.msg.show', [
      'resource'  => $this->service->getTable($this->atendimento),
      'id'        => $data['atendimento']->id
    ]));

    if (is_null($data['atendimento'])) {
      App::abort(404, Lang::get('application.error.404.msg'));
    }


    return View::make('atendimento.show', compact('data'));
  }

  public function edit($id) {

    $data = array(
      'atendimento' => $this->atendimento->find($id),
      'categorias'  => array_except(MainHelper::fixArray(TipoAtendimento::all(), 'id', 'tipo'), ''),
      'status'      => MainHelper::fixarray(Status::all(), 'id', 'tipo', 'SELECIONE O STATUS'),
      'estado'		 	=> 	MainHelper::fixArray(Estado::orderBy('uf', 'asc')->get(), 'uf', 'nome'),
      'bairro'		 	=> 	MainHelper::fixArray(Bairro::orderBy('nome', 'asc')->get(), 'id', 'nome'),
      'cidade'			=> 	MainHelper::fixArray(Cidade::orderBy('nome', 'asc')->where('estado_id','=', 35)->get(), 'id', 'nome'),
      'setor'       => array_except(MainHelper::fixArray(Setor::all(), 'id', 'nome'), ''),
      'tipo_encerrado' => MainHelper::fixArray(TipoEncerrado::orderBy('nome', 'asc')->get(), 'id', 'nome'),
    );
    $data['individuos'] = array('' => 'SELECIONE O INDIVÍDUO', $data['atendimento']->individuo->id => $data['atendimento']->individuo->nome. ' | ' .$data['atendimento']->individuo->cpf);
    if (is_null($data['atendimento'])) {
      App::abort(404, Lang::get('application.error.404.msg'));
    }

    return View::make('atendimento.edit', compact('data'));
  }

  public function update($id) {

    $input = array_except(Input::all(), '_method');

    if(isset($input['titulo'])) {
      $validator = AtendimentoValidator::update($input, $id);
    } else {
      $validator = AtendimentoValidator::updateAssentamentos($input, $id);
    }

    if($validator->passes()) {
      try {
        $this->service->update($input, $id);

        return Redirect::route('atendimento.index')->with('_status', Lang::get('application.msg.status.resource-updated-successfully'));

      } catch (\Exception $e) {
        return $e->getMessage();
        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('atendimento.edit', $id)->withInput()->withErrors($validator)->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function destroy($id) {

    try {
      $this->service->destroy($id);

      return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-deleted-successfully'));

    } catch (\Exception $e) {
      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  public function restore($id) {

    try {
      $this->service->restore($id);

      return Redirect::back()->with('_status', Lang::get('application.msg.status.resource-restored-successfully'));

    } catch (\Exception $e) {
      return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
    }
  }

  /**
  * Função necessária para gerar excel
  * Gera view com objetos que serão transferidos para o arquivo excel
  * @return view
  */

  public function report() {

    $individuo = parent::getElements('individuos', true, 'get');
    // return $individuo;
    return View::make('individuos.report', compact('individuo'));
  }


  /**
  * Função necessária para gerar excel
  * Aplicação do filtro e envio do objeto Individuo para gerar excel (IndividuoService)
  */

  public function export($type, $categoria, $status, $data, $setor, $bairro) {
    $atendimento = parent::getElements('atendimento', true, 'get');

    $result = AtendimentoController::applyFilter($atendimento, $categoria, $status, $data, $setor, $bairro);

    $result = $atendimento;

    $this->service->export($result, $type);
  }


  /**
  * Aplicar filtros quando gerar arquivo excel
  *
  * @return object filtrado
  */

  public function applyFilter($atendimento, $categoria, $status, $data, $setor, $bairro){
    $result=[];

    $contador=0;
    $verdadeDesafio=0;
    if(!is_numeric($bairro)){
      $contador+=1;
    }
    if($categoria != 0){
      $contador+=1;
    }
    if($status != 0){
      $contador+=1;
    }
    if($data != 0){
      $contador+=1;
    }
    if($setor != 0){
      $contador+=1;
    }

    foreach ($atendimento as $key => $value) {
      $verdadeDesafio = 0;
      if($contador > 0){
        if(!is_numeric($bairro)){
          if(isset($value->endereco->bairro)){
            if($value->endereco->bairro == $bairro){
              $verdadeDesafio+=1;
            }
          }
        }
        if($categoria != 0){
          if($value->tipoAtendimento[0]){
            if($value->tipoAtendimento[0]->id == $categoria){
              $verdadeDesafio+=1;
            }
          }
        }
        if($setor != 0){
          if($value->setor[0]){
            if($value->setor[0]->id == $setor){
              $verdadeDesafio+=1;
            }
          }
        }
        if($status != 0){
          if($value->status->id == $status){
            $verdadeDesafio+=1;
          }
        }
        if($data != 0){
          $data_atendimento = $value->created_at->format('Y-m-d');
          if($data == $data_atendimento){
            $verdadeDesafio+=1;
          }
        }
        if($verdadeDesafio == $contador){
          $result[$key] = $value;
        }
      }else{
        $result = $atendimento;
      }
    }

    return $result;

  }


  public function pdf($id){

    $atendimento = Atendimento::find($id);

    $pdf = PDF::loadView('atendimento.pdf', compact('atendimento'));
    return $pdf->download('atendimento_'.$atendimento->titulo.'.pdf');
  }

}
