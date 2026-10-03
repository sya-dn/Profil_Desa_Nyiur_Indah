<?php
$title='Profil Desa';
require 'includes/header.php';
$education=[
 'pendidikan_sd'=>'SD / Sederajat','pendidikan_smp'=>'SMP / Sederajat','pendidikan_sma'=>'SMA / Sederajat',
 'pendidikan_d3'=>'Diploma (D1–D3)','pendidikan_s1'=>'S1 / Sarjana','pendidikan_s2'=>'S2 / Magister','pendidikan_s3'=>'S3 / Doktor'
];
$jobs=[
 'pekerjaan_pns'=>'PNS / ASN','pekerjaan_tni_polri'=>'TNI / Polri','pekerjaan_karyawan'=>'Karyawan / Swasta','pekerjaan_wiraswasta'=>'Wiraswasta',
 'pekerjaan_petani'=>'Petani','pekerjaan_nelayan'=>'Nelayan','pekerjaan_buruh'=>'Buruh','pekerjaan_pedagang'=>'Pedagang',
 'pekerjaan_ibu_rumah_tangga'=>'Ibu Rumah Tangga','pekerjaan_pelajar'=>'Pelajar / Mahasiswa','pekerjaan_pensiunan'=>'Pensiunan',
 'pekerjaan_lainnya'=>'Pekerjaan Lainnya','pekerjaan_tidak_bekerja'=>'Tidak / Belum Bekerja'
];
$totalPekerjaan=0; foreach($jobs as $f=>$label){$totalPekerjaan+=(int)($set[$f]??0);}
?>
<section class="page-head"><div class="container"><h1 class="section-title">Profil Desa</h1><p class="text-muted">Mengenal Desa Nyiur Indah lebih dekat melalui sejarah, visi misi, dan data kependudukan.</p></div></section>
<main class="container py-5">
    <section class="card card-soft p-4 p-lg-5 mb-4">
        <div class="section-kicker mb-1">Sejarah</div><h3 class="mb-3">Sejarah Desa</h3>
        <div class="profile-prose"><?=nl2br(e($set['sejarah']??''))?></div>
    </section>

    <section class="card card-soft p-4 p-lg-5 mb-4">
        <div class="section-kicker mb-1">Arah Pembangunan</div><h3 class="mb-4">Visi & Misi</h3>
        <div class="row g-4"><div class="col-lg-6"><div class="profile-highlight h-100"><div class="feature-icon mb-3"><i class="bi bi-eye"></i></div><h4>Visi</h4><div class="profile-prose"><?=nl2br(e($set['visi']??''))?></div></div></div><div class="col-lg-6"><div class="profile-highlight h-100"><div class="feature-icon mb-3"><i class="bi bi-list-check"></i></div><h4>Misi</h4><div class="profile-prose"><?=nl2br(e($set['misi']??''))?></div></div></div></div>
    </section>

    <section class="card card-soft p-4 p-lg-5 mb-4">
        <div class="section-kicker mb-1">Kependudukan</div><h3 class="mb-4">Data Penduduk</h3>
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="stat"><div class="stat-icon"><i class="bi bi-person-standing"></i></div><small class="text-muted">Laki-laki</small><div class="dashboard-number"><?=number_format((int)($set['penduduk_laki_laki']??0),0,',','.')?></div><small class="text-muted">Jiwa</small></div></div>
            <div class="col-6 col-md-3"><div class="stat"><div class="stat-icon"><i class="bi bi-person-standing-dress"></i></div><small class="text-muted">Perempuan</small><div class="dashboard-number"><?=number_format((int)($set['penduduk_perempuan']??0),0,',','.')?></div><small class="text-muted">Jiwa</small></div></div>
            <div class="col-6 col-md-3"><div class="stat"><div class="stat-icon"><i class="bi bi-people-fill"></i></div><small class="text-muted">Total Penduduk</small><div class="dashboard-number"><?=number_format((int)($set['jumlah_penduduk']??0),0,',','.')?></div><small class="text-muted">Jiwa</small></div></div>
            <div class="col-6 col-md-3"><div class="stat"><div class="stat-icon"><i class="bi bi-house-heart-fill"></i></div><small class="text-muted">Kepala Keluarga</small><div class="dashboard-number"><?=number_format((int)($set['jumlah_kk']??0),0,',','.')?></div><small class="text-muted">KK</small></div></div>
        </div>
    </section>

    <section class="card card-soft p-4 p-lg-5 mb-4">
        <div class="section-kicker mb-1">Pendidikan</div><h3 class="mb-4">Data Pendidikan Penduduk</h3>
        <div class="row g-3"><?php foreach($education as $f=>$label): ?><div class="col-6 col-md-4 col-lg-3"><div class="border rounded-3 p-3 h-100 bg-light"><small class="text-muted d-block"><?=e($label)?></small><strong class="fs-4"><?=number_format((int)($set[$f]??0),0,',','.')?></strong> <small class="text-muted">jiwa</small></div></div><?php endforeach; ?></div>
    </section>

    <section class="card card-soft p-4 p-lg-5">
        <div class="section-kicker mb-1">Pekerjaan</div><h3 class="mb-4">Data Penduduk Berdasarkan Jenis Pekerjaan</h3>
        <div class="alert alert-success d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4"><span><i class="bi bi-briefcase me-2"></i>Total data pada kategori pekerjaan</span><strong><?=number_format($totalPekerjaan,0,',','.')?> jiwa</strong></div>
        <div class="row g-3"><?php foreach($jobs as $f=>$label): $jumlah=(int)($set[$f]??0); $persen=$totalPekerjaan>0?round(($jumlah/$totalPekerjaan)*100,1):0; ?><div class="col-6 col-md-4 col-lg-3"><div class="border rounded-3 p-3 h-100 bg-light"><small class="text-muted d-block"><?=e($label)?></small><strong class="fs-4"><?=number_format($jumlah,0,',','.')?></strong> <small class="text-muted">jiwa</small><div class="progress mt-2" style="height:6px"><div class="progress-bar" style="width:<?=$persen?>%"></div></div><small class="text-muted"><?=$persen?>%</small></div></div><?php endforeach; ?></div>
    </section>
</main>
<?php require 'includes/footer.php'; ?>
