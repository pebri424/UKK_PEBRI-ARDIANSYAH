<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Data Pengembalian Alat</h2>
<table class="table table-bordered bg-white shadow-sm mt-3">
    <thead class="table-success">
        <tr>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['returns'] as $r): ?>
        <tr>
            <td><?= $r['nama_lengkap'] ?></td>
            <td><?= $r['nama_alat'] ?></td>
            <td><?= $r['tanggal_pinjam'] ?></td>
            <td><?= $r['tanggal_kembali'] ?></td>
            <td><span class="badge bg-success">Returned</span></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
