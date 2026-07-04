<!DOCTYPE html>
<?php /** @var string $judul */ ?>
<?php /** @var string $page */ ?>
<?php /** @var string $menu */ ?>
<?php /** @var array $wilayah */ ?>
<?php /** @var array $kategori */ ?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GIS Sebaran_UMKM | <?= $judul ?></title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="<?= base_url('/') ?>" class="navbar-brand">
  <img src="<?= base_url('AdminLTE/dist/img/user1.png') ?>" class="me-2" height="45px" width="60px">
</a>
      <h5><b>GIS Sebaran UMKM</b></h5>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
          </li>
          
          <!-- Dropdown Wilayah -->
          <li class="nav-item dropdown">
            <a id="dropdownWilayah" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Wilayah</a>
            <ul aria-labelledby="dropdownWilayah" class="dropdown-menu border-0 shadow">
                <?php foreach ($wilayah as $key => $w) : ?>
                    <li><a href="<?= base_url('wilayah/' . $w['id_wilayah']) ?>" class="dropdown-item"><?= $w['nama_wilayah'] ?></a></li>
                <?php endforeach; ?>
            </ul>
          </li>

          <!-- Dropdown UMKM -->
          <li class="nav-item dropdown">
            <a id="dropdownUmkm" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">UMKM</a>
            <ul aria-labelledby="dropdownUmkm" class="dropdown-menu border-0 shadow">
                <?php foreach ($kategori as $key => $k) : ?>
                    <li><a href="<?= base_url('home/kategori/' . $k['id_kategori_umkm']) ?>" class="dropdown-item"><?= $k['nama_kategori_umkm'] ?></a></li>
                <?php endforeach; ?>
            </ul>
          </li>
        </ul>
      </div>

      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content">
      <div class="row">
        <?php if ($page) { echo view($page); } ?> 
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">Anything you want</div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- Scripts -->
<script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>
</body>
</html>