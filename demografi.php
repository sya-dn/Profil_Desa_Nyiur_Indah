<?php
$title='Data Kependudukan';
require 'header.php';

$allowed=['pendidikan','pekerjaan'];
$edit=null;
if(isset($_GET['edit'])){
    $st=$pdo->prepare('SELECT * FROM demographic_data WHERE id=?');
    $st->execute([(int)$_GET['edit']]);
    $edit=$st->fetch();
}

if(isset($_GET['delete'])){
    $pdo->prepare('DELETE FROM demographic_data WHERE id=?')->execute([(int)$_GET['delete']]);
    flash('ok','Data berhasil dihapus.');
    header('Location: demografi.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)($_POST['id']??0);
    $jenis=$_POST['jenis']??'';
    $kategori=trim($_POST['kategori']??'');
    $jumlah=max(0,(int)($_POST['jumlah']??0));
    $urutan=(int)($_POST['urutan']??0);

    if(!in_array($jenis,$allowed,true) || $kategori===''){
        flash('err','Jenis dan kategori data wajib diisi.');
    }elseif($id){
        $pdo->prepare('UPDATE demographic_data SET jenis=?,kategori=?,jumlah=?,urutan=? WHERE id=?')
            ->execute([$jenis,$kategori,$jumlah,$urutan,$id]);
        flash('ok','Data kependudukan berhasil diperbarui.');
    }else{
        $pdo->prepare('INSERT INTO demographic_data(jenis,kategori,jumlah,urutan) VALUES(?,?,?,?)')
            ->execute([$jenis,$kategori,$jumlah,$urutan]);
        flash('ok','Data kependudukan berhasil ditambahkan.');
    }
    header('Location: demografi.php');
    exit;
}

$ok=flash('ok');$err=flash('err');
$pendidikan=$pdo->query("SELECT * FROM demographic_data WHERE jenis='pendidikan' ORDER BY urutan ASC,id ASC")->fetchAll();
$pekerjaan=$pdo->query("SELECT * FROM demographic_data WHERE jenis='pekerjaan' ORDER BY urutan ASC,id ASC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-end mb-4">
  <div>
    <div class="section-kicker">Profil Desa</div>
    <h2 class="fw-bold mb-1">Data Kependudukan</h2>
    <p class="text-muted mb-0">Kelola jumlah penduduk berdasarkan pendidikan dan pekerjaan.</p>
  </div>
  <a href="settings.php" class="btn btn-outline-success">← Pengaturan Profil</a>
</div>

<?php if($ok):?><div class="alert alert-success"><?=e($ok)?></div><?php endif;?>
<?php if($err):?><div class="alert alert-danger"><?=e($err)?></div><?php endif;?>

<div class="card card-soft p-4 mb-4">
<h5 class="fw-bold"><?=($edit?'Edit':'Tambah')?> Data</h5>
<form method="post">
<input type="hidden" name="id" value="<?=e($edit['id']??0)?>">
<div class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Jenis Data</label>
    <select name="jenis" class="form-select" required>
      <option value="pendidikan" <?=($edit['jenis']??'')==='pendidikan'?'selected':''?>>Pendidikan</option>
      <option value="pekerjaan" <?=($edit['jenis']??'')==='pekerjaan'?'selected':''?>>Pekerjaan</option>
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Kategori</label>
    <input name="kategori" class="form-control" value="<?=e($edit['kategori']??'')?>" placeholder="Contoh: SMA / Petani" required>
  </div>
  <div class="col-md-2">
    <label class="form-label">Jumlah</label>
    <input name="jumlah" type="number" min="0" class="form-control" value="<?=e($edit['jumlah']??0)?>" required>
  </div>
  <div class="col-md-2">
    <label class="form-label">Urutan</label>
    <input name="urutan" type="number" class="form-control" value="<?=e($edit['urutan']??0)?>">
  </div>
</div>
<button class="btn btn-primary mt-3"><i class="bi bi-save me-1"></i> Simpan</button>
<?php if($edit):?><a href="demografi.php" class="btn btn-light mt-3">Batal</a><?php endif;?>
</form>
</div>

<?php foreach([['Pendidikan',$pendidikan],['Pekerjaan',$pekerjaan]] as $group):?>
<div class="card card-soft p-4 mb-4">
<h5 class="fw-bold mb-3">Data <?=e($group[0])?></h5>
<div class="table-responsive">
<table class="table">
<thead><tr><th>No.</th><th>Kategori</th><th>Jumlah</th><th>Urutan</th><th>Aksi</th></tr></thead>
<tbody>
<?php if(!$group[1]):?><tr><td colspan="5" class="text-center text-muted py-4">Belum ada data.</td></tr><?php endif;?>
<?php foreach($group[1] as $i=>$r):?>
<tr>
<td><?=($i+1)?></td><td><?=e($r['kategori'])?></td><td><?=number_format((int)$r['jumlah'],0,',','.')?></td><td><?=e($r['urutan'])?></td>
<td><a class="btn btn-sm btn-outline-primary" href="demografi.php?edit=<?=$r['id']?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')" href="demografi.php?delete=<?=$r['id']?>">Hapus</a></td>
</tr>
<?php endforeach;?>
</tbody></table>
</div>
</div>
<?php endforeach;?>
<?php require 'footer.php';?>
