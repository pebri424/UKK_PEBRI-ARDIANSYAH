<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Ubah Permintaan Peminjaman</h2>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <form action="<?= BASEURL ?>/peminjam/updatePinjaman" method="POST">
            <input type="hidden" name="id" value="<?= $data['loan']['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Alat</label>
                <input type="text" class="form-control" value="<?= $data['equipment']['nama_alat'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="<?= $data['loan']['jumlah'] ?>" min="1" max="<?= $data['equipment']['stok'] ?>" required>
                <div class="form-text">Stok tersedia: <?= $data['equipment']['stok'] ?>.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga per hari</label>
                <input type="text" class="form-control" value="Rp <?= number_format($data['equipment']['harga_sewa']) ?>" readonly>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="<?= BASEURL ?>/peminjam/pinjaman_saya" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>