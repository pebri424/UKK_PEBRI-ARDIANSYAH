<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Manajemen Alat Camping</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEquipModal">
Tambah Alat
</button>

<table class="table table-bordered bg-white shadow-sm">
<thead>
<tr>
<th>Alat</th>
<th>Kategori</th>
<th>Stok</th>
<th>Harga/Hari</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php foreach ($data['equipment'] as $e): ?>

<tr>
<td><?= $e['nama_alat'] ?></td>
<td><?= $e['nama_kategori'] ?></td>
<td><?= $e['stok'] ?></td>
<td>Rp <?= number_format($e['harga_sewa']) ?></td>

<td>

<a href="<?= BASEURL ?>/admin/hapusAlat/<?= $e['id'] ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus alat ini?')">
Hapus
</a>

<button 
class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#editModal<?= $e['id'] ?>">
Edit
</button>

</td>
</tr>

<?php endforeach; ?>
</tbody>
</table>


<!-- ============================= -->
<!-- MODAL TAMBAH ALAT -->
<!-- ============================= -->

<div class="modal fade" id="addEquipModal" tabindex="-1">
<div class="modal-dialog">

<form action="<?= BASEURL ?>/admin/tambahAlat" method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Tambah Alat Baru</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label>Nama Alat</label>
<input type="text" name="nama_alat" class="form-control" required>
</div>

<div class="mb-3">
<label>Kategori</label>

<select name="category_id" class="form-select" required>

<?php foreach ($data['categories'] as $cat): ?>

<option value="<?= $cat['id'] ?>">
<?= $cat['nama_kategori'] ?>
</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" class="form-control" required>
</div>

<div class="mb-3">
<label>Harga Sewa per Hari</label>
<input type="number" name="harga_sewa" class="form-control" required>
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>
</div>
</div>


<!-- ============================= -->
<!-- MODAL EDIT ALAT -->
<!-- ============================= -->

<?php foreach ($data['equipment'] as $e): ?>

<div class="modal fade" id="editModal<?= $e['id'] ?>" tabindex="-1">
<div class="modal-dialog">

<form action="<?= BASEURL ?>/admin/updateAlat" method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Alat</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="id" value="<?= $e['id'] ?>">

<div class="mb-3">
<label>Nama Alat</label>
<input type="text" name="nama_alat" class="form-control" value="<?= $e['nama_alat'] ?>" required>
</div>

<div class="mb-3">
<label>Kategori</label>

<select name="category_id" class="form-select">

<?php foreach ($data['categories'] as $cat): ?>

<option value="<?= $cat['id'] ?>"
<?= $cat['id'] == $e['category_id'] ? 'selected' : '' ?>>

<?= $cat['nama_kategori'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" class="form-control" value="<?= $e['stok'] ?>" required>
</div>

<div class="mb-3">
<label>Harga Sewa</label>
<input type="number" name="harga_sewa" class="form-control" value="<?= $e['harga_sewa'] ?>" required>
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-success">Update</button>
</div>

</form>

</div>
</div>

<?php endforeach; ?>


<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>