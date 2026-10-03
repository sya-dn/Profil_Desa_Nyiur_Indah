<?php
$title='Struktur Organisasi';
require 'header.php';

$pdo->exec("CREATE TABLE IF NOT EXISTS organization_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    jabatan VARCHAR(150) NOT NULL,
    nama VARCHAR(150) NOT NULL,
    foto VARCHAR(255) NULL,
    urutan INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(parent_id), INDEX(urutan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $action=$_POST['action']??'';
    if($action==='save'){
        $id=(int)($_POST['id']??0);
        $parentId=(int)($_POST['parent_id']??0);
        $jabatan=trim($_POST['jabatan']??'');
        $nama=trim($_POST['nama']??'');
        $urutan=max(0,(int)($_POST['urutan']??0));
        if($jabatan==='' || $nama===''){
            flash('err','Jabatan dan nama wajib diisi.');
        } elseif($id>0 && $parentId===$id){
            flash('err','Atasan tidak boleh sama dengan data yang sedang diedit.');
        } else {
            $foto=upload_file('foto','uploads',['jpg','jpeg','png','webp']);
            if($id>0){
                $old=$pdo->prepare('SELECT foto FROM organization_members WHERE id=?'); $old->execute([$id]); $old=$old->fetch();
                if($foto){
                    $pdo->prepare('UPDATE organization_members SET parent_id=?,jabatan=?,nama=?,foto=?,urutan=? WHERE id=?')->execute([$parentId?:null,$jabatan,$nama,$foto,$urutan,$id]);
                } else {
                    $pdo->prepare('UPDATE organization_members SET parent_id=?,jabatan=?,nama=?,urutan=? WHERE id=?')->execute([$parentId?:null,$jabatan,$nama,$urutan,$id]);
                }
                flash('ok','Data struktur organisasi berhasil diperbarui.');
            } else {
                $pdo->prepare('INSERT INTO organization_members(parent_id,jabatan,nama,foto,urutan) VALUES(?,?,?,?,?)')->execute([$parentId?:null,$jabatan,$nama,$foto,$urutan]);
                flash('ok','Data struktur organisasi berhasil ditambahkan.');
            }
        }
        header('Location: pemerintahan.php'); exit;
    }
    if($action==='delete'){
        $id=(int)($_POST['id']??0);
        $pdo->prepare('UPDATE organization_members SET parent_id=NULL WHERE parent_id=?')->execute([$id]);
        $pdo->prepare('DELETE FROM organization_members WHERE id=?')->execute([$id]);
        flash('ok','Data struktur organisasi berhasil dihapus.');
        header('Location: pemerintahan.php'); exit;
    }
}

$ok=flash('ok'); $err=flash('err');
$editId=(int)($_GET['edit']??0);
$edit=null;
if($editId){ $q=$pdo->prepare('SELECT * FROM organization_members WHERE id=?');$q->execute([$editId]);$edit=$q->fetch(); }
$members=$pdo->query('SELECT * FROM organization_members ORDER BY parent_id IS NOT NULL,parent_id,urutan,id')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-end mb-4"><div><div class="section-kicker">Profil Desa</div><h2 class="fw-bold mb-1">Struktur Organisasi Pemerintahan</h2><p class="text-muted mb-0">Kelola jabatan, nama perangkat desa, foto, dan hubungan atasan-bawahan.</p></div><a class="btn btn-outline-success" href="../pemerintahan.php" target="_blank"><i class="bi bi-eye me-1"></i>Lihat Bagan</a></div>
<?php if($ok): ?><div class="alert alert-success"><?=e($ok)?></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?=e($err)?></div><?php endif; ?>
<div class="row g-4">
<div class="col-lg-5">
<div class="admin-card p-4">
<h5 class="fw-bold mb-1"><?= $edit ? 'Edit Anggota Struktur' : 'Tambah Anggota Struktur' ?></h5>
<p class="text-muted small">Foto opsional. Jika tidak diisi saat edit, foto lama tetap digunakan.</p>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=e($edit['id']??0)?>">
<div class="mb-3"><label class="form-label fw-semibold">Jabatan</label><input name="jabatan" class="form-control" required placeholder="Contoh: Kepala Desa" value="<?=e($edit['jabatan']??'')?>"></div>
<div class="mb-3"><label class="form-label fw-semibold">Nama</label><input name="nama" class="form-control" required placeholder="Nama lengkap" value="<?=e($edit['nama']??'')?>"></div>
<div class="mb-3"><label class="form-label fw-semibold">Atasan / Parent</label><select name="parent_id" class="form-select"><option value="0">Tidak ada — posisi paling atas</option><?php foreach($members as $m): if((int)$m['id']===$editId) continue; ?><option value="<?=$m['id']?>" <?=((int)($edit['parent_id']??0)===(int)$m['id'])?'selected':''?>><?=e($m['jabatan'].' — '.$m['nama'])?></option><?php endforeach;?></select><div class="form-text">Pilih atasan agar bagan otomatis membentuk hubungan organisasi.</div></div>
<div class="mb-3"><label class="form-label fw-semibold">Urutan</label><input type="number" min="0" name="urutan" class="form-control" value="<?=e($edit['urutan']??0)?>"><div class="form-text">Angka kecil tampil lebih dulu pada tingkat yang sama.</div></div>
<div class="mb-3"><label class="form-label fw-semibold">Foto</label><input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG, atau WebP. Disarankan foto formal dengan latar rapi.</div></div>
<?php if(!empty($edit['foto'])): ?><div class="mb-3"><img src="../<?=e($edit['foto'])?>" class="admin-org-preview" alt="Foto saat ini"></div><?php endif; ?>
<button class="btn btn-primary"><i class="bi bi-save me-1"></i><?= $edit ? 'Simpan Perubahan' : 'Tambah ke Struktur' ?></button>
<?php if($edit): ?><a href="pemerintahan.php" class="btn btn-light ms-1">Batal</a><?php endif; ?>
</form></div></div>
<div class="col-lg-7">
<div class="admin-card p-4"><h5 class="fw-bold mb-3">Daftar Struktur</h5>
<?php if(!$members): ?><div class="text-center text-muted py-5"><i class="bi bi-diagram-3 fs-1 d-block mb-2"></i>Belum ada data struktur organisasi.</div><?php else: ?>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Foto</th><th>Jabatan & Nama</th><th>Atasan</th><th>Urutan</th><th></th></tr></thead><tbody>
<?php foreach($members as $m): $parentName='—'; foreach($members as $p){if((int)$p['id']===(int)$m['parent_id']){$parentName=$p['jabatan'].' — '.$p['nama'];break;}} ?>
<tr><td><?php if($m['foto']): ?><img src="../<?=e($m['foto'])?>" class="admin-org-thumb" alt="<?=e($m['nama'])?>"><?php else: ?><div class="admin-org-thumb placeholder"><i class="bi bi-person"></i></div><?php endif; ?></td><td><strong><?=e($m['jabatan'])?></strong><br><span class="text-muted"><?=e($m['nama'])?></span></td><td class="small"><?=e($parentName)?></td><td><?=e($m['urutan'])?></td><td class="text-end"><a href="pemerintahan.php?edit=<?=$m['id']?>" class="btn btn-sm btn-outline-success"><i class="bi bi-pencil"></i></a> <form method="post" class="d-inline" onsubmit="return confirm('Hapus data ini? Anak/anggota di bawahnya akan dipindahkan menjadi posisi teratas.');"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$m['id']?>"><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
<?php endforeach; ?></tbody></table></div><?php endif; ?></div></div>
</div>
<?php require 'footer.php'; ?>
