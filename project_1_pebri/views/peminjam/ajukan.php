<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Ajukan Peminjaman</h2>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<div class="row">
    <?php if (empty($data['equipment'])): ?>
        <div class="col-12">
            <div class="alert alert-info">Tidak ada alat tersedia saat ini.</div>
        </div>
    <?php endif; ?>
    <?php foreach ($data['equipment'] as $e): ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
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