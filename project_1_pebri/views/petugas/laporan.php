<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center">
    <h2>Laporan Peminjaman Alat</h2>
    <button onclick="window.print()" class="btn btn-secondary no-print"><i class="bi bi-printer"></i> Cetak PDF/Print</button>
</div>

<div id="printable-area" class="mt-4 p-3 bg-white shadow-sm border rounded">
    <h4 class="text-center">LAPORAN PEMINJAMAN ALAT CAMPING</h4>
    <p class="text-center text-muted">Dicetak pada: <?= date('Y-m-d H:i:s') ?></p>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['loans'] as $idx => $l): ?>
            <tr>
                <td><?= $idx + 1 ?></td>
                <td><?= $l['nama_lengkap'] ?></td>
                <td><?= $l['nama_alat'] ?></td>
                <td><?= $l['tanggal_pinjam'] ?></td>
                <td><?= $l['tanggal_kembali'] ?: '-' ?></td>
                <td><?= ucfirst($l['status']) ?></td>
                <td>Rp <?= number_format($l['total_harga']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
