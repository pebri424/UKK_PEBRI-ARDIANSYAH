<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Manajemen User</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
Tambah User
</button>

<table class="table table-bordered bg-white shadow-sm">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

        <?php $no=1; ?>
        <?php foreach ($data['users'] as $u): ?>

        <tr>

            <td><?= $no++; ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['nama_lengkap'] ?></td>
            <td><?= ucfirst($u['role']) ?></td>

            <td>

                <!-- Tombol Edit -->
                <a href="<?= BASEURL ?>/admin/editUser/<?= $u['id'] ?>" 
                class="btn btn-warning btn-sm">
                Edit
                </a>

                <!-- Tombol Hapus -->
                <a href="<?= BASEURL ?>/admin/hapusUser/<?= $u['id'] ?>" 
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus user?')">
                Hapus
                </a>

            </td>

        </tr>

        <?php endforeach; ?>

    </tbody>

</table>


<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">

       <form action="<?= BASEURL ?>/admin/tambahUser" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="peminjam">Peminjam</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>