<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Data Peminjaman Alat</h2>
<table class="table table-bordered bg-white shadow-sm">
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Status</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['loans'] as $l): ?>
        <tr>
            <td><?= $l['nama_lengkap'] ?></td>
            <td><?= $l['nama_alat'] ?></td>
            <td><?= $l['jumlah'] ?></td>
            <td><?= $l['tanggal_pinjam'] ?></td>
            <td>
                <span class="badge bg-<?= $l['status'] === 'approved' ? 'success' : ($l['status'] === 'pending' ? 'warning' : 'info') ?>">
                    <?= ucfirst($l['status']) ?>
                </span>
            </td>
            <td>Rp <?= number_format($l['total_harga']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
