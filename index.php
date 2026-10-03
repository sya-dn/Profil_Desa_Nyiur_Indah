<?php $title='Dashboard';require 'header.php';$profil=$pdo->query('SELECT * FROM settings WHERE id=1')->fetch();
$cards=[['Berita','posts','bi-newspaper'],['Kegiatan','activities','bi-calendar-event'],['Potensi','potentials','bi-tree'],['UMKM','umkm','bi-shop'],['Dokumen','documents','bi-file-earmark-text'],['Galeri','galleries','bi-images'],['Pengaduan','complaints','bi-chat-left-text']];
$populationCards=[
 ['Penduduk Laki-laki','penduduk_laki_laki','bi-person-standing',' jiwa'],
 ['Penduduk Perempuan','penduduk_perempuan','bi-person-standing-dress',' jiwa'],
 ['Jumlah Penduduk','jumlah_penduduk','bi-people-fill',' jiwa'],
 ['Jumlah KK','jumlah_kk','bi-house-heart-fill',' KK'],
 ['Data Pendidikan','education','bi-mortarboard-fill',' jenjang'],
 ['Data Pekerjaan','jobs','bi-briefcase-fill',' kategori']
];?>
<div class="d-flex justify-content-between align-items-end mb-4"><div><div class="section-kicker">Pusat kendali desa</div><h2 class="fw-bold mb-1">Selamat datang, <?=e($_SESSION['admin_nama'])?> 👋</h2><p class="text-muted mb-0">Kelola seluruh informasi Desa Nyiur Indah dari satu dashboard.</p></div><a class="btn btn-primary d-none d-md-inline-flex" href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i>Lihat Website</a></div>
<div class="row g-3 mb-4">
<?php foreach($cards as $c):$n=$pdo->query("SELECT COUNT(*) c FROM {$c[1]}")->fetch()['c'];?>
<div class="col-6 col-md-4 col-lg-3"><a href="manage.php?type=<?=$c[1]?>" class="text-decoration-none"><div class="stat"><div class="stat-icon"><i class="bi <?=$c[2]?>"></i></div><small class="text-muted"><?=e($c[0])?></small><div class="dashboard-number"><?=$n?></div><small class="text-muted">Kelola data <i class="bi bi-arrow-right"></i></small></div></a></div>
<?php endforeach;?>
<?php foreach($populationCards as $c):
    if($c[1]==='education'){
        $value=(int)$profil['pendidikan_sd']+(int)$profil['pendidikan_smp']+(int)$profil['pendidikan_sma']+(int)$profil['pendidikan_d3']+(int)$profil['pendidikan_s1']+(int)$profil['pendidikan_s2']+(int)$profil['pendidikan_s3'];
    }elseif($c[1]==='jobs'){
        $value=0;
        foreach(['pekerjaan_pns','pekerjaan_tni_polri','pekerjaan_karyawan','pekerjaan_wiraswasta','pekerjaan_petani','pekerjaan_nelayan','pekerjaan_buruh','pekerjaan_pedagang','pekerjaan_ibu_rumah_tangga','pekerjaan_pelajar','pekerjaan_pensiunan','pekerjaan_lainnya','pekerjaan_tidak_bekerja'] as $jobField){
            $value+=(int)($profil[$jobField]??0);
        }
    }else{
        $value=(int)($profil[$c[1]]??0);
    }
?>
<div class="col-6 col-md-4 col-lg-3"><a href="settings.php" class="text-decoration-none"><div class="stat"><div class="stat-icon"><i class="bi <?=$c[2]?>"></i></div><small class="text-muted"><?=e($c[0])?></small><div class="dashboard-number"><?=$value?></div><small class="text-muted"><?=$c[3]?> · Pengaturan <i class="bi bi-arrow-right"></i></small></div></a></div>
<?php endforeach;?>
</div>
<div class="row g-4"><div class="col-lg-7"><div class="admin-card p-4 h-100"><div class="section-kicker mb-2">Pengaturan</div><h5 class="fw-bold">Profil & identitas desa</h5><p class="text-muted">Perbarui nama desa, alamat, kepala desa, visi, misi, sambutan, dan informasi kontak.</p><a href="settings.php" class="btn btn-primary me-1">Buka Pengaturan <i class="bi bi-arrow-right ms-1"></i></a><a href="pemerintahan.php" class="btn btn-outline-success">Struktur Organisasi</a></div></div><div class="col-lg-5"><div class="admin-card p-4 h-100"><div class="section-kicker mb-2">Terbaru</div><h5 class="fw-bold">Pengaduan masyarakat</h5><?php $rs=$pdo->query('SELECT * FROM complaints ORDER BY id DESC LIMIT 5')->fetchAll();foreach($rs as $r):?><div class="border-bottom py-2"><b><?=e($r['nama'])?></b><br><small class="text-muted"><?=e(mb_substr($r['isi'],0,70))?>…</small> <span class="badge text-bg-light"><?=e($r['status'])?></span></div><?php endforeach;if(!$rs):?><p class="text-muted">Belum ada pengaduan.</p><?php endif;?></div></div></div><?php require 'footer.php';?>
