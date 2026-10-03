<?php $title='Peta & Lokasi'; require 'includes/header.php'; ?>

<section class="page-head">
    <div class="container">
        <h1 class="section-title">Peta & Lokasi Desa</h1>
    </div>
</section>

<main class="container py-5">
    <div class="card card-soft p-3">

        <!-- Google Maps Desa Nyiur Indah -->
        <iframe
            src="https://www.google.com/maps?q=-6.8076469,120.7752219&z=15&output=embed"
            style="width:100%;height:480px;border:0;border-radius:14px"
            loading="lazy"
            allowfullscreen>
        </iframe>

        <div class="p-3">
            <h5 class="mb-2">Desa Nyiur Indah</h5>

            <p class="text-muted mb-2">
                Kecamatan Taka Bonerate, Kabupaten Kepulauan Selayar,
                Sulawesi Selatan.
            </p>

            <a href="https://maps.app.goo.gl/ioVFTmBnPfXR2ruH8"
               target="_blank"
               class="btn btn-success">
                <i class="bi bi-geo-alt-fill"></i>
                Buka di Google Maps
            </a>
        </div>

    </div>
</main>

<?php require 'includes/footer.php'; ?>