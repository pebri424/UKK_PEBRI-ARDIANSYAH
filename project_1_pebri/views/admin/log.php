<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Log Aktifitas Sistem</h2>
<table class="table table-sm table-striped bg-white shadow-sm mt-3">
    <thead class="table-dark">
        <tr>
            <th>Waktu</th>
            <th>User</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['logs'] as $log): ?>
        <tr>
            <td><?= $log['timestamp'] ?></td>
            <td><strong><?= $log['username'] ?></strong></td>
            <td><?= $log['action'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
