<div id="map" style="width: 100%; height: 620px;"></div>

<script>
   

var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token'<?= env('MAPBOX_TOKEN') ?>, {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	});

var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token'<?= env('MAPBOX_TOKEN') ?>, {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/satellite-v9'
	});


var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token'<?= env('MAPBOX_TOKEN') ?>, {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/dark-v10'
	}); 

   // var map = L.map('map').setView([-7.244352002019807, 108.97745250919617], 12);

	//var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {

		//attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	//}).addTo(map);

    var map = L.map('map', {
	center: [-7.244352002019807, 108.97745250919617],
	zoom: 12,
	layers: [peta3]
    });

    var baseMaps = {
	'OpenStreetMap': peta1,
	'Satellite': peta2,
    'Streets': peta3,
    'Night' : peta4,
};

var layerControl = L.control.layers(baseMaps).addTo(map);
</script>