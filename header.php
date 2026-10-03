<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../config/app.php';
$set=$pdo->query('SELECT * FROM settings WHERE id=1')->fetch();
$current=basename($_SERVER['PHP_SELF']);
function nav_active($files=[]){global $current; return in_array($current,$files,true)?'active':'';}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#087f5b">
<meta name="description" content="Website resmi Pemerintah Desa Nyiur Indah, Kecamatan Takabonerate, Kabupaten Kepulauan Selayar.">
<title><?=e($title??$set['nama_desa'])?> | Website Resmi Desa Nyiur Indah</title>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-3" href="index.php" aria-label="Beranda Desa Nyiur Indah">

      <div>
        <img src="assets/img/logo.png" alt="Logo Desa Nyiur Indah"
        style="width:50px; height:50px; object-fit:contain;">
      </div>

      <div class="brand-copy">
        <strong>Desa Nyiur Indah</strong>
        <small>Kecamatan Takabonerate</small>
      </div>
    </a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Buka menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link <?=nav_active(['index.php'])?>" href="index.php"><i class="bi bi-house-door me-1 d-lg-none"></i>Beranda</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=nav_active(['profil.php','pemerintahan.php','peta.php'])?>" href="#" data-bs-toggle="dropdown">Profil</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profil.php"><i class="bi bi-building me-2"></i>Profil Desa</a></li>
            <li><a class="dropdown-item" href="pemerintahan.php"><i class="bi bi-people me-2"></i>Struktur Organisasi</a></li>
            <li><a class="dropdown-item" href="peta.php"><i class="bi bi-geo-alt me-2"></i>Peta & Lokasi</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=nav_active(['berita.php','berita_detail.php','kegiatan.php','pengumuman.php'])?>" href="#" data-bs-toggle="dropdown">Informasi</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="berita.php"><i class="bi bi-newspaper me-2"></i>Berita Desa</a></li>
            <li><a class="dropdown-item" href="kegiatan.php"><i class="bi bi-calendar-event me-2"></i>Kegiatan</a></li>
            <li><a class="dropdown-item" href="pengumuman.php"><i class="bi bi-megaphone me-2"></i>Pengumuman</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=nav_active(['potensi.php','umkm.php'])?>" href="#" data-bs-toggle="dropdown">Potensi</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="potensi.php"><i class="bi bi-tree me-2"></i>Potensi Desa</a></li>
            <li><a class="dropdown-item" href="umkm.php"><i class="bi bi-shop me-2"></i>UMKM & Produk</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link <?=nav_active(['galeri.php'])?>" href="galeri.php">Galeri</a></li>
        <li class="nav-item"><a class="nav-link <?=nav_active(['transparansi.php'])?>" href="transparansi.php">Transparansi</a></li>
        <li class="nav-item"><a class="nav-link <?=nav_active(['pelayanan.php'])?>" href="pelayanan.php">Pelayanan</a></li>
        <li class="nav-item ms-lg-2"><a class="btn btn-primary nav-cta" href="pengaduan.php"><i class="bi bi-chat-left-text me-1"></i>Pengaduan</a></li>
        <li class="nav-item"><a class="nav-link admin-link <?=nav_active(['login.php'])?>" href="login.php" title="Masuk panel admin"><i class="bi bi-person-lock me-1"></i>Admin</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php if ($current !== 'index.php'): ?>
<div class="container breadcrumb-wrap">
  <a href="javascript:history.back()" class="back-button"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php endif; ?>
