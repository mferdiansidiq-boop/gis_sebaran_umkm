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
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
              <?php 
              session();
              $validation = \Config\Services::validation();
              if (session()->getFlashdata('validation')) {
                $validation = session()->getFlashdata('validation');
              }
              ?>
              <?php echo form_open_multipart('Umkm/UpdateData/'. $umkm['id_umkm']) ?>

              <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Nama Umkm</label>
                    <input name="nama_umkm" value="<?= old('nama_umkm', $umkm['nama_umkm']) ?>" placeholder="Nama Umkm" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('nama_umkm') ? $validation->getError('nama_umkm'):'' ?></p>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Kategori UMKM</label>
                    <select name="id_kategori_umkm" class="form-control">
                      <option value="">--Pilih Kategori--</option>
                      <?php foreach ($kategori_umkm as $key => $value) { ?>
                        <option value="<?= $value['id_kategori_umkm'] ?>" <?= old('id_kategori_umkm', $umkm['id_kategori_umkm']) == $value['id_kategori_umkm'] ? 'selected' : '' ?>>
                          <?= $value['nama_kategori_umkm'] ?>
                        </option>
                      <?php } ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_kategori_umkm') ? $validation->getError('id_kategori_umkm'):''?></p>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <?php $status_sekarang = old('status', $umkm['status']); ?>
                      <option value="Perorangan" <?= $status_sekarang == 'Perorangan' ? 'selected' : '' ?>>Perorangan</option>
                      <option value="Kemitraan (Franchise)" <?= $status_sekarang == 'Kemitraan (Franchise)' ? 'selected' : '' ?>>Kemitraan (Franchise)</option>
                      <option value="Perseroan Terbatas (PT)" <?= $status_sekarang == 'Perseroan Terbatas (PT)' ? 'selected' : '' ?>>Perseroan Terbatas (PT)</option>
                      <option value="Commanditaire Vennootschap (CV)" <?= $status_sekarang == 'Commanditaire Vennootschap (CV)' ? 'selected' : '' ?>>Commanditaire Vennootschap (CV)</option>
                      <option value="Koperasi" <?= $status_sekarang == 'Koperasi' ? 'selected' : '' ?>>Koperasi</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('status') ? $validation->getError('status'):''?></p>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Skala Usaha</label>
                    <select name="id_skala_usaha" class="form-control">
                      <option value="">--Pilih Skala Usaha--</option>
                      <?php foreach ($skala_usaha as $key => $value) { 
                        // Ambil ID skala usaha dari database ($value)
                        $id_skala = $value['id_skala_usaha']; 
                        
                        // Cek nilai pembanding dari data UMKM yang sedang diedit
                        $id_umkm_skala = isset($umkm['id_skala_usaha']) ? $umkm['id_skala_usaha'] : (isset($umkm['skala_usaha']) ? $umkm['skala_usaha'] : '');
                        
                        // Tentukan apakah option ini harus terpilih (selected)
                        $selected = (old('id_skala_usaha', $id_umkm_skala) == $id_skala) ? 'selected' : '';
                      ?>
                        <option value="<?= $id_skala ?>" <?= $selected ?>>
                          <?= $value['skala_usaha'] ?>
                        </option>
                      <?php } ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_skala_usaha') ? $validation->getError('id_skala_usaha'):''?></p>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Coordinat Umkm</label>
                <div id="map" style="width: 100%; height: 420px;"></div>
                <input name="coordinat" id="Coordinat" value="<?= $umkm['coordinat'] ?>" placeholder="Coordinat Umkm" class="form-control" readonly>
                <p class="text-danger"><?= $validation->hasError('coordinat') ? $validation->getError('coordinat'):''?></p>
                </div>

               <div class="row">
                  <div class="col-sm-4">
                <div class="form-group">
                <label>Provinsi</label>
                <select name="id_provinsi" id="id_provinsi" class="form-control select2" style="width: 100%;">
                  <option value="">--Pilih Provinsi--</option>
                  <?php foreach ($provinsi as $key => $value) { ?>
                  <option value="<?=  $value['id_provinsi'] ?>" <?= $value['id_provinsi'] == $umkm['id_provinsi'] ? 'selected' : '' ?>><?=  $value['nama_provinsi'] ?></option>
                <?php } ?>
                </select>
                <p class="text-danger"><?= $validation->hasError('id_provinsi') ? $validation->getError('id_provinsi'):''?></p>
                </div>
               </div>

               
                  <div class="col-sm-4">
                <div class="form-group">
                <label>Kabupaten</label>
                <select name="id_kabupaten" id="id_kabupaten" class="form-control select2">
                    <option value="<?= $umkm['id_kabupaten'] ?>"><?= $umkm['nama_kabupaten'] ?></option>
                </select>
                <p class="text-danger"><?= $validation->hasError('id_kabupaten') ? $validation->getError('id_kabupaten'):''?></p>
                </div>
               </div>

               
                  <div class="col-sm-4">
                <div class="form-group">
                <label>Kecamatan</label>
                <select name="id_kecamatan" id="id_kecamatan" class="form-control select2">
                     <option value="<?= $umkm['id_kecamatan'] ?>"><?= $umkm['nama_kecamatan'] ?></option>
                </select>
                <p class="text-danger"><?= $validation->hasError('id_kecamatan') ? $validation->getError('id_kecamatan'):''?></p>
                </div>
               </div>
                </div>

                <div class="row">
                  <div class="col-sm-8">
                <div class="form-group">
                <label>Alamat</label>
                <input name="alamat" value="<?= $umkm['alamat'] ?>" placeholder="Alamat Umkm" class="form-control">
                <p class="text-danger"><?= $validation->hasError('alamat') ? $validation->getError('alamat'):''?></p>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                <label>Wilayah Administrasi</label>
                <select name="id_wilayah" class="form-control">
                   <option value="">--Pilih Wilayah Administrasi--</option>
                  <?php foreach ($wilayah as $key => $value) { ?>
                  <option value="<?=  $value['id_wilayah'] ?>" <?= $value['id_wilayah'] == $umkm['id_wilayah'] ? 'selected' : '' ?>><?=  $value['nama_wilayah'] ?></option>
                <?php } ?>
                </select>
                <p class="text-danger"><?= $validation->hasError('id_wilayah') ? $validation->getError('id_wilayah'):''?></p>
                </div>
               </div>
            </div>

           <div class="form-group">
                <label>Ganti Foto Umkm</label>
                <input type="file" accept=".jpg,.jpeg,.png" name="foto" class="form-control">
                <p class="text-info" style="font-size: 12px;">*Kosongkan jika tidak ingin mengganti foto lama</p>
                <p class="text-danger"><?= $validation->hasError('foto') ? $validation->getError('foto'):''?></p>
              </div>

                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                <a href="<?= base_url('Umkm') ?>" type="submit" class="btn btn-success btn-flat">Kembali</a>


              <?php echo form_close() ?>

              </div>
           </div>
         </div>

         <script>
          $(document).ready(function() {
            //Initialize Select2 Elements
          $('.select2').select2();

          $('#id_provinsi').change(function() {
            var id_provinsi = $('#id_provinsi').val();
          $.ajax({
            type: "POST",
            url: "<?= base_url('Umkm/Kabupaten') ?>",
            data: {
              id_provinsi: id_provinsi
            },
            success: function(response) {
              $('#id_kabupaten').html(response);
            }
          });
          });

           $('#id_kabupaten').change(function() {
            var id_kabupaten = $('#id_kabupaten').val();
          $.ajax({
            type: "POST",
            url: "<?= base_url('Umkm/Kecamatan') ?>",
            data: {
              id_kabupaten: id_kabupaten
            },
            success: function(response) {
              $('#id_kecamatan').html(response);
            }
          });
          });

           });
            </script>


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


var layerControl = L.control.layers(baseMaps).addTo(map);

var coordinatInput = document.querySelector("[name=coordinat]");

var curLocation = [<?=   $umkm['coordinat'] ?>];
map.attributionControl.setPrefix(false);
var marker = new L.marker(curLocation, {
  draggable: 'true',
});

//mengambil coordinat saat marker di geser
marker.on('dragend',function(e) {
  var position = marker.getLatLng();
  marker.setLatLng(position, {
    curLocation
  }).bindPopup(position).update();
  $("#Coordinat").val(position.lat + "," + position.lng);
});

//mengambil coordinat saat map onclik
map.on("click", function(e) {
  var lat = e.latlng.lat;
  var lng = e.latlng.lng;
  if (!marker) {
  marker = L.marker(e.latlng).addTo(map);
} else {
  marker.setLatLng(e.latlng);
}
coordinatInput.value = lat + ',' + lng;
});

map.addLayer(marker);

</script> 