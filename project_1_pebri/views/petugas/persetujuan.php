<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Persetujuan Peminjaman</h2>
<table class="table table-bordered bg-white shadow-sm mt-3">
    <thead class="table-primary text-white">
        <tr>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['pending_loans'] as $l): ?>
        <tr>
            <td><?= $l['nama_lengkap'] ?></td>
            <td><?= $l['nama_alat'] ?></td>
            <td><?= $l['jumlah'] ?></td>
            <td><?= $l['tanggal_pinjam'] ?></td>
            <td>
                <a href="<?= BASEURL ?>/petugas/prosesSetuju/<?= $l['id'] ?>" class="btn btn-success btn-sm">Setujui</a>
                <a href="<?= BASEURL ?>/petugas/prosesTolak/<?= $l['id'] ?>" class="btn btn-danger btn-sm">Tolak</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
