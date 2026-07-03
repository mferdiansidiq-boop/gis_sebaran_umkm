<?php /** @var string $judul */ ?>
<?php /** @var array $wilayah */ ?>
<?php /** @var array $provinsi */ ?>
<?php /** @var array $web */ ?>
<?php /** @var array $umkm */ ?>
<?php /** @var array $kategori_umkm */ ?>
<?php /** @var array $skala_usaha */ ?>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div id="map" style="width: 100%; height: 420px;"></div>
                </div>

                <div class="col-sm-6">
                    <img src="<?= base_url('foto/'.$umkm['foto']) ?>" width="100%" height="420px">
                </div>

                <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama UMKM</th>
                        <th width="30px">:</th>
                        <th><?= $umkm['nama_umkm'] ?></th>
                    </tr>
                    <tr>
                        <th>Kategori UMKM</th>
                        <th>:</th>
                        <th><?= $umkm['nama_kategori_umkm'] ?></th>
                    </tr>
                    <tr>
                        <th>Status Usaha</th>
                        <th>:</th>
                        <th><?= $umkm['status'] ?></th>
                    </tr>
                    <tr>
                        <th>Skala Usaha</th>
                        <th>:</th>
                        <th><?= $umkm['skala_usaha'] ?></th>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <th>:</th>
                        <th><?= $umkm['alamat'] ?>,<?= $umkm['nama_kecamatan'] ?>,<?= $umkm['nama_kabupaten'] ?></th>
                    </tr>
                </table>
                <a href="<?= base_url('Umkm') ?>" class="btn btn-success btn-flat">Kembali</a>
            </div>
            
        </div>
    </div>
</div>


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
var map = L.map('map').setView([<?=   $umkm['coordinat'] ?>], <?=  $web['zoom_view'] ?>);

// DEFAULT (WAJIB pakai ini)
peta2.addTo(map);

// CONTROL
var baseMaps = {
  "OpenStreetMap": peta1,
  "Satellite": peta2,
  "Streets": peta3,
  "Night": peta4
};

L.geoJSON(<?= $umkm['geojson'] ?>, {
    fillColor: '<?= $umkm['warna'] ?>',
    fillOpacity: 0.5,
  })
  .bindPopup("<b><?= $umkm['nama_wilayah'] ?></b>")
  .addTo(map);

var icon = L.icon({
    iconUrl: '<?= base_url('marker/' . $umkm['marker']) ?>',
    iconSize: [30, 40], // size of the icon
});

 L.marker([<?= $umkm['coordinat'] ?>], {
    icon: icon
    }).addTo(map);

</script> 