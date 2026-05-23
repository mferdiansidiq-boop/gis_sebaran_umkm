 <?php /** @var array $wilayah */ ?>
  <?php /** @var array $web */ ?>

<div id="map" style="width: 100%; height: 620px;"></div>

<script>

// LAYER
var peta1 = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png');

var peta2 = L.tileLayer(
  'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    maxZoom: 19,
    minZoom: 0,
    maxNativeZoom: 19,
    noWrap: true,
    updateWhenZooming: false,
    updateWhenIdle: true,
    keepBuffer: 2
});


// STREETS (ganti ke OSM standar lain)
var peta3 = L.tileLayer(
  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
});


var peta4 = L.tileLayer(
  'https://basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'
);

// INIT MAP
var map = L.map('map').setView([<?=  $web['coordinat_wilayah'] ?>], <?=  $web['zoom_view'] ?>);

// DEFAULT (WAJIB pakai ini)
peta2.addTo(map);

// CONTROL
var baseMaps = {
  "OpenStreetMap": peta1,
  "Satellite": peta2,
  "Streets": peta3,
  "Night": peta4
};


L.control.layers(baseMaps).addTo(map);

<?php foreach ($wilayah as $key => $value) { ?>
  L.geoJSON(<?= $value['geojson'] ?>, {
    fillColor: '<?= $value['warna'] ?>',
    fillOpacity: 0.5,
  })
  .bindPopup("<b><?= $value['nama_wilayah'] ?></b>")
  .addTo(map);
 <?php } ?>

</script> 


