<div id="map" style="width: 100%; height: 500px;"></div>

<script>
    // 1. DEFINISI PILIHAN TILE LAYER (BASEMAPS)
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

    // STREETS
    var peta3 = L.tileLayer(
      'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19
    });

    var peta4 = L.tileLayer(
      'https://basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'
    );

    // 2. INIT MAP (Set view awal mengikuti data zoom_view web)
    var map = L.map('map').setView([-7.25, 109.0], <?= $web['zoom_view'] ?>);

    // DEFAULT LAYER (Menggunakan Satellite seperti permintaanmu)
    peta2.addTo(map);

    // 3. CONTROL LAYER (Pojok Kanan Atas)
    var baseMaps = {
      "OpenStreetMap": peta1,
      "Satellite": peta2,
      "Streets": peta3,
      "Night": peta4
    };

    var layerControl = L.control.layers(baseMaps).addTo(map);
    map.attributionControl.setPrefix(false);

    // 4. PROSES DRAW GEOJSON WILAYAH KECAMATAN
    var geoData = <?= json_encode($detail_wil['geojson']) ?>; 
    var warnaDaerah = "<?= isset($detail_wil['warna']) ? $detail_wil['warna'] : '#ff7800' ?>";

    if (geoData) {
        // Validasi tipe data jika dari DB berupa string teks murni
        var geojsonObject = (typeof geoData === 'string') ? JSON.parse(geoData) : geoData;

        // Gambar poligon kecamatan ke peta
        var daerahKecamatan = L.geoJSON(geojsonObject, {
            style: function (feature) {
                return {
                    color: warnaDaerah,     // Warna garis tepi
                    fillColor: warnaDaerah, // Warna area dalam poligon
                    weight: 4,
                    fillOpacity: 0.4,
                    opacity: 0.8
                };
            }
        }).addTo(map);

        // OTOMATIS FOKUS & ZOOM PAS DI TENGAH WILAYAH KECAMATAN INI
       // map.fitBounds(daerahKecamatan.getBounds());//
        
        // Munculkan popup info nama kecamatan
        daerahKecamatan.bindPopup("<b><?= $detail_wil['nama_wilayah'] ?></b>").openPopup();
    }
</script>