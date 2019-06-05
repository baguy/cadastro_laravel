L.mapbox.accessToken = 'pk.eyJ1IjoicHNzYWxlcyIsImEiOiJjamphMmg1NGowOG50M3ZwOTVmemIyaTFmIn0.SNP_mJlKS48Gnt0ULLGMFg';

var url = location.href;
if(url.indexOf("edit") == -1 || !$('[name="latitude"').val() || !$('[name="longitude"').val()) {
	var lat = -23.62659639859563 , long = -45.42417526245117 ;
} else {
  var lat = $('[name="latitude"').val(), long = $('[name="longitude"').val();
}

var map = L.mapbox.map('mapa', 'mapbox.streets')
    .setView([lat, long], 12);

const clusterGroup = new L.MarkerClusterGroup();

function buscar(){
  if($(".endereco:last").find("input, select").valid()){
		clusterGroup.clearLayers()

    find(findAddress())
  }
}

function find(address){
  $.ajax({
		url: 'http://dev.virtualearth.net/REST/v1/Locations?query='+address+'&key=AhwF2xXetYhATsJ8V-zqHoYmOOd7dBFokCzyN3zsO0TWxZpAdy0I6USR4NnF2GR_&jsonp',
    data: address,
    type: 'GET',
    success: function(data){
					var longitude = data.resourceSets[0].resources[0].point.coordinates[1]
					var latitude = data.resourceSets[0].resources[0].point.coordinates[0]
          marker(longitude,latitude)
      },
  });
}

function marker(longitude,latitude){
	$('[name="latitude"]').val(latitude)
	$('[name="longitude"]').val(longitude)

	var marker = L.marker([latitude,longitude])

	clusterGroup.addLayer(marker)

	map.addLayer(clusterGroup);
}


function findAddress(){
    var cidade = $("[name='cidade'] :selected").text();
    var estado = $("[name='estado'] :selected").text();
    return  $("[name='logradouro']").val()+', '+$("[name='numero']").val()+', '+$("[name=bairro]")+', '+cidade+" - "+estado +', Brasil';
}
