<?php
$host='localhost'; $db='db_desa_nyiur_indah'; $user='root'; $pass='';
try {
    $pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
    ]);

    // Migrasi ringan otomatis untuk database lama.
    // Tidak menghapus atau menimpa data yang sudah ada.
    $newColumns = [
        'jumlah_penduduk' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER sambutan",
        'penduduk_laki_laki' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER jumlah_penduduk",
        'penduduk_perempuan' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER penduduk_laki_laki",
        'jumlah_kk'       => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER penduduk_perempuan",
        'kk_laki_laki'    => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER jumlah_kk",
        'kk_perempuan'    => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER kk_laki_laki",
        'pendidikan_sd'   => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER jumlah_kk",
        'pendidikan_smp'  => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_sd",
        'pendidikan_sma'  => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_smp",
        'pendidikan_d3'   => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_sma",
        'pendidikan_s1'   => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_d3",
        'pendidikan_s2'   => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s1",
        'pendidikan_s3'   => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s2",
        'pekerjaan_pns' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_tni_polri' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_karyawan' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_wiraswasta' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_petani' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_nelayan' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_buruh' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_pedagang' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_ibu_rumah_tangga' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_pelajar' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_pensiunan' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_lainnya' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
        'pekerjaan_tidak_bekerja' => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pendidikan_s3",
    ];

    foreach ($newColumns as $column => $definition) {
        $check = $pdo->prepare("SHOW COLUMNS FROM settings LIKE ?");
        $check->execute([$column]);
        if (!$check->fetch()) {
            $pdo->exec("ALTER TABLE settings ADD COLUMN `$column` $definition");
        }
    }

    // Struktur organisasi pemerintahan desa. Dibuat otomatis agar database lama tidak perlu diimpor ulang.
    $pdo->exec("CREATE TABLE IF NOT EXISTS organization_members (id INT AUTO_INCREMENT PRIMARY KEY,parent_id INT NULL,jabatan VARCHAR(150) NOT NULL,nama VARCHAR(150) NOT NULL,foto VARCHAR(255) NULL,urutan INT NOT NULL DEFAULT 0,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,INDEX(parent_id),INDEX(urutan)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch(PDOException $e){
    die('Koneksi database gagal. Pastikan MySQL aktif dan database sudah diimpor.');
}
