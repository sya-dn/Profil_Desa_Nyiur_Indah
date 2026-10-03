<footer class="footer">
  <div class="container py-5">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-5">
        <div class="footer-brand d-flex align-items-center gap-3 mb-3">
          <div class="brand-icon brand-icon-footer">
    <img src="assets/img/logo.png" 
         alt="Logo Desa Nyiur Indah"
         style="width:50px; height:50px; object-fit:contain;">
</div>
          <div><strong>Desa Nyiur Indah</strong><small>Kecamatan Takabonerate</small></div>
        </div>
        <p class="footer-desc">Media informasi, transparansi, pelayanan, dan pengembangan potensi masyarakat Desa Nyiur Indah, Kecamatan Takabonerate, Kabupaten Kepulauan Selayar.</p>
        <div class="footer-social">
          <a href="mailto:<?=e($set['email']?:'')?>" aria-label="Email"><i class="bi bi-envelope"></i></a>
          <a href="tel:<?=e($set['telepon']?:'')?>" aria-label="Telepon"><i class="bi bi-telephone"></i></a>
          <a href="peta.php" aria-label="Lokasi"><i class="bi bi-geo-alt"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <h6>Menu Utama</h6>
        <a href="profil.php">Profil Desa</a>
        <a href="berita.php">Berita Desa</a>
        <a href="kegiatan.php">Kegiatan</a>
        <a href="potensi.php">Potensi Desa</a>
        <a href="pelayanan.php">Pelayanan</a>
      </div>
      <div class="col-6 col-lg-4">
        <h6>Hubungi Pemerintah Desa</h6>
        <p class="footer-contact"><i class="bi bi-geo-alt-fill"></i><span><?=e($set['alamat']?:'-')?></span></p>
        <p class="footer-contact"><i class="bi bi-telephone-fill"></i><span><?=e($set['telepon']?:'-')?></span></p>
        <p class="footer-contact"><i class="bi bi-envelope-fill"></i><span><?=e($set['email']?:'-')?></span></p>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 py-3">
      <span>© <?=date('Y')?> Pemerintah Desa Nyiur Indah</span>
      <span>Website Resmi Desa · Kabupaten Kepulauan Selayar</span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
