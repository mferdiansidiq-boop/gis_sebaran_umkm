 <?php
 /** @var array $web */
 /** @var string $judul */
 ?>
 
 
 
 <div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>
        </div>

        <div class="card-body">

        <?php
        if (session()->getFlashdata('pesan')) {
          echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>';
          echo session()->getFlashdata('pesan');
          echo '</h5></div>';
        }

        ?>

            <?= form_open('admin/updatesetting', ['id' => 'formSetting']) ?>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>Nama Website</label>
                        <input name="nama_web" value="<?= $web['nama_web'] ?>" class="form-control">
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Coordinat Wilayah</label>
                        <input id="koordinat" name="coordinat_wilayah" value="<?= $web['coordinat_wilayah'] ?>" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Zoom View</label>
                        <input id="zoom" type="number" name="zoom_view" value="<?= $web['zoom_view'] ?>" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>

            <?= form_close() ?>

        </div>
    </div>
</div>

<div class="col-md-12">
    <div id="map" style="width: 100%; height: 620px;"></div>
</div>




          

        <script>
   

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
var map = L.map('map').setView([-7.244352002019807, 108.97745250919617], 12);

// DEFAULT (WAJIB pakai ini)
peta1.addTo(map);

// CONTROL
var baseMaps = {
  "OpenStreetMap": peta1,
  "Satellite": peta2,
  "Streets": peta3,
  "Night": peta4
};

L.control.layers(baseMaps).addTo(map);

</script>

