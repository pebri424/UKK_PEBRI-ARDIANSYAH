<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Pantau Pengembalian Alat</h2>
<table class="table table-bordered bg-white shadow-sm mt-3">
    <thead class="table-info">
        <tr>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Tgl Pinjam</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['active_loans'] as $l): ?>
        <tr>
            <td><?= $l['nama_lengkap'] ?></td>
            <td><?= $l['nama_alat'] ?></td>
            <td><?= $l['tanggal_pinjam'] ?></td>
            <td>
                <a href="<?= BASEURL ?>/petugas/konfirmasiKembali/<?= $l['id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Sudah dikembalikan?')">Tandai Kembali</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
