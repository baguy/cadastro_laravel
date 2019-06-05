L.mapbox.accessToken = 'pk.eyJ1IjoicHNzYWxlcyIsImEiOiJjamphMmg1NGowOG50M3ZwOTVmemIyaTFmIn0.SNP_mJlKS48Gnt0ULLGMFg'

var lat = -23.62659639859563 , long = -45.42417526245117

var map = L.mapbox.map('mapa', 'mapbox.streets')
    .setView([lat, long], 12);

const clusterGroup = new L.MarkerClusterGroup();

function buscar() {
  clusterGroup.clearLayers()

  var lati = []
  var lon = []
  var descricao = []

  $.each($('[name="latitude"'), function(){
    lati.push($(this).val())
  })

  $.each($('[name="longitude"'), function() {
    lon.push($(this).val())
  })

  $.each($('.descricao'), function() {
    var desc = {nome:$(this).children('[name="nome"]').val(), endereco:$(this).children('[name="endereco"]').val(), telefone:$(this).children('[name="telefone"]').val()}
    descricao.push(desc);
  })

  for (i=0; i<lati.length; i++) {
    marker(lon[i], lati[i], descricao[i])
  }
}

function marker(longitude,latitude,descricao) {

  var marker = L.marker([latitude,longitude]).bindPopup("<h6 style='font-weight:bold;'>"+descricao.nome+"</h6>"+
                                                        "<p>"+descricao.endereco+"</p>"+
                                                        "<p>"+descricao.telefone+"</p>")

  clusterGroup.addLayer(marker)

  map.addLayer(clusterGroup);
}

function clean() {
  clusterGroup.clearLayers()
}

$("#individuosFilterSubmit, #individuosFilterClean").on('click', function(){
  clean()
})
