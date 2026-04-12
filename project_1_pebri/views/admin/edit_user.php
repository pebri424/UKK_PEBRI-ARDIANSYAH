<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Edit User</h2>

<div class="card p-4">

<form action="<?= BASEURL ?>/admin/updateUser" method="POST">

<input type="hidden" name="id" value="<?= $data['user']['id']; ?>">

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" name="username" class="form-control"
value="<?= $data['user']['username']; ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Nama Lengkap</label>
<input type="text" name="nama_lengkap" class="form-control"
value="<?= $data['user']['nama_lengkap']; ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Role</label>

<select name="role" class="form-select">

<option value="admin"
<?= $data['user']['role']=='admin'?'selected':'' ?>>
Admin
</option>

<option value="petugas"
<?= $data['user']['role']=='petugas'?'selected':'' ?>>
Petugas
</option>

<option value="peminjam"
<?= $data['user']['role']=='peminjam'?'selected':'' ?>>
Peminjam
</option>

</select>

</div>

<button type="submit" class="btn btn-primary">
Update
</button>

<a href="<?= BASEURL ?>/admin/user" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>