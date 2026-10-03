<?php
$title = 'Pengaturan Profil';
require 'header.php';

$s = $pdo->query('SELECT * FROM settings WHERE id=1')->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'nama_desa','kecamatan','kabupaten','provinsi','alamat','telepon','email','whatsapp',
        'kepala_desa','visi','misi','sejarah','sambutan',
        'jumlah_penduduk','penduduk_laki_laki','penduduk_perempuan','jumlah_kk',
        'pendidikan_sd','pendidikan_smp','pendidikan_sma','pendidikan_d3',
        'pendidikan_s1','pendidikan_s2','pendidikan_s3',
        'pekerjaan_pns','pekerjaan_tni_polri','pekerjaan_karyawan',
        'pekerjaan_wiraswasta','pekerjaan_petani','pekerjaan_nelayan',
        'pekerjaan_buruh','pekerjaan_pedagang','pekerjaan_ibu_rumah_tangga',
        'pekerjaan_pelajar','pekerjaan_pensiunan','pekerjaan_lainnya',
        'pekerjaan_tidak_bekerja'
    ];

    $numericFields = [
        'jumlah_penduduk','penduduk_laki_laki','penduduk_perempuan','jumlah_kk',
        'pendidikan_sd','pendidikan_smp','pendidikan_sma','pendidikan_d3',
        'pendidikan_s1','pendidikan_s2','pendidikan_s3',
        'pekerjaan_pns','pekerjaan_tni_polri','pekerjaan_karyawan',
        'pekerjaan_wiraswasta','pekerjaan_petani','pekerjaan_nelayan',
        'pekerjaan_buruh','pekerjaan_pedagang','pekerjaan_ibu_rumah_tangga',
        'pekerjaan_pelajar','pekerjaan_pensiunan','pekerjaan_lainnya',
        'pekerjaan_tidak_bekerja'
    ];

    $sets = [];
    $vals = [];

    foreach ($data as $f) {

        if (in_array($f, $numericFields)) {
            $vals[] = max(0, (int)($_POST[$f] ?? 0));
        } else {
            $vals[] = trim($_POST[$f] ?? '');
        }

        $sets[] = "$f=?";
    }

    $vals[] = 1;

    $pdo->prepare(
        'UPDATE settings SET ' . implode(',', $sets) . ' WHERE id=?'
    )->execute($vals);

    flash('ok', 'Pengaturan profil dan data kependudukan berhasil disimpan.');

    header('Location: settings.php');
    exit;
}

$ok = flash('ok');
?>

<h2 class="fw-bold">Pengaturan Profil Desa</h2>
<p class="text-muted">
    Perubahan di sini langsung tampil pada website publik.
</p>

<?php if ($ok): ?>
<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i><?= e($ok) ?>
</div>
<?php endif; ?>


<!-- ========================================================= -->
<!-- SATU CARD BESAR -->
<!-- ========================================================= -->

<div class="card card-soft p-4 mb-4">

    <form method="post">

        <!-- ================= IDENTITAS DESA ================= -->

        <div class="section-kicker mb-1">Identitas Desa</div>
        <h5 class="fw-bold mb-3">Profil & Kontak</h5>

        <div class="row g-3">

            <?php
            $fields = [
                'nama_desa'  => 'Nama Desa',
                'kecamatan'  => 'Kecamatan',
                'kabupaten'  => 'Kabupaten',
                'provinsi'   => 'Provinsi',
                'alamat'     => 'Alamat',
                'telepon'    => 'Telepon',
                'email'      => 'Email',
                'whatsapp'   => 'WhatsApp',
                'kepala_desa'=> 'Nama Kepala Desa',
                'visi'       => 'Visi',
                'misi'       => 'Misi',
                'sejarah'    => 'Sejarah Desa',
                'sambutan'   => 'Sambutan Kepala Desa'
            ];

            foreach ($fields as $f => $l):
            ?>

            <div class="col-md-<?= in_array($f, [
                'alamat','visi','misi','sejarah','sambutan'
            ]) ? '12' : '6' ?>">

                <label class="form-label fw-semibold">
                    <?= e($l) ?>
                </label>

                <?php if (in_array($f, [
                    'alamat','visi','misi','sejarah','sambutan'
                ])): ?>

                    <textarea
                        name="<?= e($f) ?>"
                        rows="4"
                        class="form-control"
                    ><?= e($s[$f] ?? '') ?></textarea>

                <?php else: ?>

                    <input
                        type="text"
                        name="<?= e($f) ?>"
                        class="form-control"
                        value="<?= e($s[$f] ?? '') ?>"
                    >

                <?php endif; ?>

            </div>

            <?php endforeach; ?>

        </div>


        <hr class="my-5">


        <!-- ================= DATA KEPENDUDUKAN ================= -->

        <div class="section-kicker mb-1">Data Kependudukan</div>

        <h5 class="fw-bold">
            Jumlah Penduduk & Kepala Keluarga
        </h5>

        <p class="text-muted small">
            Masukkan jumlah penduduk berdasarkan jenis kelamin.
            Total penduduk dihitung otomatis dari penduduk laki-laki
            dan perempuan.
        </p>

        <div class="row g-3">

            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Penduduk Laki-laki
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="penduduk_laki_laki"
                        class="form-control"
                        value="<?= e($s['penduduk_laki_laki'] ?? 0) ?>"
                    >

                    <span class="input-group-text">Jiwa</span>

                </div>

            </div>


            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Penduduk Perempuan
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="penduduk_perempuan"
                        class="form-control"
                        value="<?= e($s['penduduk_perempuan'] ?? 0) ?>"
                    >

                    <span class="input-group-text">Jiwa</span>

                </div>

            </div>


            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Total Penduduk
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="jumlah_penduduk"
                        id="jumlah_penduduk"
                        class="form-control"
                        value="<?= e($s['jumlah_penduduk'] ?? 0) ?>"
                        readonly
                    >

                    <span class="input-group-text">Jiwa</span>

                </div>

            </div>


            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Jumlah KK
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="jumlah_kk"
                        id="jumlah_kk_input"
                        class="form-control"
                        value="<?= e($s['jumlah_kk'] ?? 0) ?>"
                    >

                    <span class="input-group-text">KK</span>

                </div>

            </div>


            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Total Kepala Keluarga
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        id="total_kepala_keluarga"
                        class="form-control"
                        value="<?= e($s['jumlah_kk'] ?? 0) ?>"
                        readonly
                    >

                    <span class="input-group-text">KK</span>

                </div>

            </div>

        </div>


        <hr class="my-5">


        <!-- ================= DATA PENDIDIKAN ================= -->

        <div class="section-kicker mb-1">
            Data Pendidikan
        </div>

        <h5 class="fw-bold">
            Jumlah Penduduk Berdasarkan Pendidikan
        </h5>

        <p class="text-muted small">
            Isi jumlah penduduk pada setiap jenjang pendidikan.
            Gunakan angka 0 jika belum ada data.
        </p>

        <div class="row g-3">

            <?php
            $education = [
                'pendidikan_sd'  => 'SD / Sederajat',
                'pendidikan_smp' => 'SMP / Sederajat',
                'pendidikan_sma' => 'SMA / Sederajat',
                'pendidikan_d3'  => 'Diploma (D1–D3)',
                'pendidikan_s1'  => 'S1 / Sarjana',
                'pendidikan_s2'  => 'S2 / Magister',
                'pendidikan_s3'  => 'S3 / Doktor'
            ];

            foreach ($education as $f => $l):
            ?>

            <div class="col-6 col-md-4">

                <label class="form-label fw-semibold">
                    <?= e($l) ?>
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="<?= e($f) ?>"
                        class="form-control"
                        value="<?= e($s[$f] ?? 0) ?>"
                    >

                    <span class="input-group-text">
                        Jiwa
                    </span>

                </div>

            </div>

            <?php endforeach; ?>

        </div>


        <hr class="my-5">


        <!-- ================= DATA PEKERJAAN ================= -->

        <div class="section-kicker mb-1">
            Pekerjaan
        </div>

        <h5 class="fw-bold mb-1">
            Jumlah Penduduk Berdasarkan Pekerjaan
        </h5>

        <p class="text-muted small">
            Masukkan jumlah penduduk untuk setiap kategori pekerjaan.
            Data ini akan otomatis ditampilkan pada halaman Profil Desa.
        </p>

        <div class="row g-3">

            <?php
            $jobs = [
                'pekerjaan_pns'             => 'PNS / ASN',
                'pekerjaan_tni_polri'       => 'TNI / Polri',
                'pekerjaan_karyawan'        => 'Karyawan / Swasta',
                'pekerjaan_wiraswasta'      => 'Wiraswasta',
                'pekerjaan_petani'          => 'Petani',
                'pekerjaan_nelayan'         => 'Nelayan',
                'pekerjaan_buruh'           => 'Buruh',
                'pekerjaan_pedagang'        => 'Pedagang',
                'pekerjaan_ibu_rumah_tangga' => 'Ibu Rumah Tangga',
                'pekerjaan_pelajar'         => 'Pelajar / Mahasiswa',
                'pekerjaan_pensiunan'       => 'Pensiunan',
                'pekerjaan_lainnya'         => 'Pekerjaan Lainnya',
                'pekerjaan_tidak_bekerja'   => 'Tidak / Belum Bekerja'
            ];

            foreach ($jobs as $f => $label):
            ?>

            <div class="col-6 col-md-4 col-lg-3">

                <label class="form-label fw-semibold">
                    <?= e($label) ?>
                </label>

                <div class="input-group">

                    <input
                        type="number"
                        min="0"
                        name="<?= e($f) ?>"
                        class="form-control"
                        value="<?= e($s[$f] ?? 0) ?>"
                    >

                    <span class="input-group-text">
                        Jiwa
                    </span>

                </div>

            </div>

            <?php endforeach; ?>

        </div>


        <!-- ================= TOMBOL SIMPAN ================= -->

        <div class="border-top mt-5 pt-4">

            <button
                type="submit"
                class="btn btn-primary px-4"
            >
                <i class="bi bi-save me-2"></i>
                Simpan Semua Perubahan
            </button>

        </div>

    </form>

</div>


<!-- ========================================================= -->
<!-- MENU ADMIN TETAP CARD TERPISAH -->
<!-- ========================================================= -->

<div class="card card-soft p-4 mt-4">

    <h5 class="fw-bold">
        Menu Admin
    </h5>

    <div class="row g-2">

        <?php foreach ([
            'posts'         => 'Berita',
            'announcements' => 'Pengumuman',
            'activities'    => 'Kegiatan',
            'potentials'    => 'Potensi',
            'umkm'          => 'UMKM',
            'documents'     => 'Dokumen',
            'galleries'     => 'Galeri',
            'services'      => 'Pelayanan',
            'complaints'    => 'Pengaduan'
        ] as $k => $v):
        ?>

        <div class="col-6 col-md-3">

            <a
                class="btn btn-outline-success w-100"
                href="manage.php?type=<?= $k ?>"
            >
                <?= e($v) ?>
            </a>

        </div>

        <?php endforeach; ?>

    </div>

</div>


<!-- ================= JAVASCRIPT ================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Total penduduk
    const laki = document.querySelector(
        '[name="penduduk_laki_laki"]'
    );

    const perempuan = document.querySelector(
        '[name="penduduk_perempuan"]'
    );

    const totalPenduduk = document.getElementById(
        'jumlah_penduduk'
    );


    function hitungPenduduk() {

        const l = parseInt(laki.value || 0, 10);
        const p = parseInt(perempuan.value || 0, 10);

        totalPenduduk.value = l + p;
    }


    if (laki && perempuan && totalPenduduk) {

        laki.addEventListener(
            'input',
            hitungPenduduk
        );

        perempuan.addEventListener(
            'input',
            hitungPenduduk
        );

        hitungPenduduk();
    }


    // Total KK
    const jumlahKK = document.getElementById(
        'jumlah_kk_input'
    );

    const totalKK = document.getElementById(
        'total_kepala_keluarga'
    );


    function updateTotalKK() {

        totalKK.value = jumlahKK.value || 0;
    }


    if (jumlahKK && totalKK) {

        jumlahKK.addEventListener(
            'input',
            updateTotalKK
        );

        updateTotalKK();
    }

});

</script>

<?php require 'footer.php'; ?>