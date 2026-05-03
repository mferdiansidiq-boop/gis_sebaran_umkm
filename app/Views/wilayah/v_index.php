 <?php /** @var string $judul */ ?>
 <?php /** @var array $wilayah */ ?>
 
 <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>

                <div class="card-tools">
                  <a href=" <?= base_url('Wilayah/Input') ?>" class="btn btn-flat btn-primary btm-sm ">
                    <i class="fas fa-plus"></i> Tambah
                  </a>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
              <?php 
               if (session()->getFlashdata('insert')) {
          echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>';
          echo session()->getFlashdata('insert');
          echo '</h5></div>';
        }
              
              
              ?>

              <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                    <th width="50px">No</th>
                    <th>Nama Wilayah</th>
                    <th>Warna</th>
                    <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                     foreach ($wilayah as $key => $value) { ?>
                     <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $value['nama_wilayah'] ?></td>
                        <td style="background-color: <?= $value['warna'] ?> ;"></td>
                        <td></td>
                     </tr>

                  <?php } ?>
                </tbody>

              </table>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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



<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
