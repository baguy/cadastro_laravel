//ROUTES
Route::get('findaddress', 'AtendimentoController@findAddress');
Route::get('insertaddress', 'AtendimentoController@insertAddress');


//CONTROLLER
public function findAddress() {
  $individuos = Individuo::with('endereco')->get();

  return View::make('individuos.find-address', compact('individuos'));
}

public function insertAddress() {
  $input = Input::get('parameter');

  $endereco = Endereco::where('id', $input[0])->first();

  if($endereco) {
    DB::beginTransaction();
    try {
      $endereco->longitude = $input[1];
      $endereco->latitude = $input[2];

      $endereco->save();

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }

  }
  return $endereco;
}


//HTML
@extends('templates.application')

@section('MAIN')
<div class="">
  <a class="form-control btn btn-md btn-default" id="buscar">BUSCAR</a><br>
  <?php foreach ($individuos as $key => $individuo): ?>
    @if(isset($individuo->endereco->id))
      <input type="text" name="id" value="{{ $individuo->endereco->id }}">
      <input type="text" name="numero" value="{{ $individuo->endereco->numero }}">
      <input type="text" name="rua" value="{{ $individuo->endereco->logradouro }}">
      <input type="text" name="bairro" value="{{ $individuo->endereco->bairro }}">
      <input type="text" name="cidade" value="{{ $individuo->endereco->cidade->nome }}">
    @endif
  <?php endforeach; ?>
</div>
@stop

@section('SCRIPTS')
<script src="{{ asset('assets/js/find_address.js') }}"></script>
@stop


//SCRIPT
$('#buscar').on('click', function(e) {
  buscar()
})

function buscar(){

  var id = []
  var numero = []
  var rua = []
  var bairro = []

  $.each($('[name="id"]'), function() {
    id.push($(this).val())
  })

  $.each($('[name="numero"]'), function() {
    numero.push($(this).val())
  })

  $.each($('[name="rua"]'), function() {
    rua.push($(this).val())
  })

  $.each($('[name="bairro"]'), function() {
    bairro.push($(this).val())
  })

  for (var i = 0; i < id.length; i++) {
    var endereco = findAddress(numero[i], rua[i], bairro[i])
    find(endereco, id[i])
  }
}

function find(address, id){
  $.ajax({
    url: 'http://dev.virtualearth.net/REST/v1/Locations?query='+address+'&key=AhwF2xXetYhATsJ8V-zqHoYmOOd7dBFokCzyN3zsO0TWxZpAdy0I6USR4NnF2GR_&jsonp',
    data: address,
    type: 'GET',
    success: function(data){
      // console.log(data);
      var longitude = data.resourceSets[0].resources[0].point.coordinates[1]
      var latitude = data.resourceSets[0].resources[0].point.coordinates[0]
      $.ajax({
        method: 'GET',
        url: main_url + 'insertaddress',
        data: {parameter: [id, longitude, latitude]},
        dataType: 'JSON',
        success: function(data) {
          console.log('success')
        }
      })
    },
  });
}

function findAddress(numero, rua, bairro){
  return  rua+', '+numero+', '+bairro+', CARAGUATATUBA - SÃO PAULO, BRASIL';
}
