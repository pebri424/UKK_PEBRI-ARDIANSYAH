<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Selamat Datang, <?= $data['nama'] ?>!</h2>
<p class="text-muted">Anda login sebagai <strong><?= ucfirst($data['role']) ?></strong></p>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-4 glass-card border-0">
            <h5 class="mb-3" style="color: #d88a31 !important;">Ringkasan Aktifitas</h5>
            <p>Statistik dasar akan tampil di sini.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
