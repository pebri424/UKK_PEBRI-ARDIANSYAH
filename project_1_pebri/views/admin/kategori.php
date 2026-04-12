<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Manajemen Kategori Alat</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addKategori">
Tambah Kategori
</button>

<table class="table table-bordered bg-white shadow-sm">
<thead>
<tr>
<th>No</th>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $no = 1; ?>
<?php foreach ($data['categories'] as $c): ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $c['nama_kategori'] ?></td>

<td>

<a href="<?= BASEURL ?>/admin/hapusKategori/<?= $c['id'] ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus kategori ini?')">
Hapus
</a>

<button 
class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#editKategori<?= $c['id'] ?>">
Edit
</button>

</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>


<!-- ===================== -->
<!-- MODAL TAMBAH KATEGORI -->
<!-- ===================== -->

<div class="modal fade" id="addKategori" tabindex="-1">
<div class="modal-dialog">

<form action="<?= BASEURL ?>/admin/tambahKategori" method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Tambah Kategori</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label>Nama Kategori</label>
<input type="text" name="nama_kategori" class="form-control" required>
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

</div>
</div>


<!-- ===================== -->
<!-- MODAL EDIT KATEGORI -->
<!-- ===================== -->

<?php foreach ($data['categories'] as $c): ?>

<div class="modal fade" id="editKategori<?= $c['id'] ?>" tabindex="-1">
<div class="modal-dialog">

<form action="<?= BASEURL ?>/admin/updateKategori" method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Kategori</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="id" value="<?= $c['id'] ?>">

<div class="mb-3">
<label>Nama Kategori</label>
<input type="text" name="nama_kategori" class="form-control" value="<?= $c['nama_kategori'] ?>" required>
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