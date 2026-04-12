<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Pinjaman Saya</h2>
<table class="table table-bordered bg-white shadow-sm mt-3">
    <thead class="table-dark">
        <tr>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['my_loans'] as $l): ?>
        <tr>
            <td><?= $l['nama_alat'] ?></td>
            <td><?= $l['jumlah'] ?></td>
            <td><?= $l['tanggal_pinjam'] ?></td>
            <td><?= $l['tanggal_kembali'] ?: '-' ?></td>
            <td>
                <span class="badge bg-<?= $l['status'] === 'approved' ? 'success' : ($l['status'] === 'pending' ? 'warning' : 'info') ?>">
                    <?= ucfirst($l['status']) ?>
                </span>
            </td>
            <td>Rp <?= number_format($l['total_harga']) ?></td>
            <td>
                <?php if ($l['status'] === 'approved'): ?>
                    <a href="<?= BASEURL ?>/peminjam/kembalikan/<?= $l['id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Kembalikan alat?')">Kembalikan</a>
                <?php elseif ($l['status'] === 'pending'): ?>
                    <a href="<?= BASEURL ?>/peminjam/batalPinjaman/<?= $l['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan permintaan pinjaman ini?')">Batalkan Peminjaman</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
