<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Daftar Alat Camping</h2>
<div class="row">
    <?php if (empty($data['equipment'])): ?>
        <div class="col-12">
            <div class="alert alert-info">Daftar alat masih kosong. Silakan tunggu admin menginput data alat.</div>
        </div>
    <?php endif; ?>
    <?php $no = 1; foreach ($data['equipment'] as $e): ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-img-top bg-light text-center py-4 text-secondary position-relative">
                <span class="badge bg-secondary position-absolute top-0 start-0 m-2">#<?= $no++ ?></span>
                <?php 
                $imgSrc = Alat_model::getImage($e['nama_alat']);
                if ($imgSrc): ?>
                    <img src="<?= BASEURL ?>/public/img/<?= $imgSrc ?>" alt="<?= htmlspecialchars($e['nama_alat']) ?>" style="height: 100px; object-fit: contain; width: auto;">
                <?php else: ?>
                    <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $e['nama_alat'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $e['nama_kategori'] ?></h6>
                <p class="card-text">
                    Stok: <?= $e['stok'] ?><br>
                    Harga: Rp <?= number_format($e['harga_sewa']) ?>/hari
                </p>
                <form action="<?= BASEURL ?>/peminjam/pinjam" method="POST">
                    <input type="hidden" name="equipment_id" value="<?= $e['id'] ?>">
                    <div class="input-group mb-3">
                        <input type="number" name="jumlah" class="form-control" value="1" min="1" max="<?= $e['stok'] ?>" required>
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
