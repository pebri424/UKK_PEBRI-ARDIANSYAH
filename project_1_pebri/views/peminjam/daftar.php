<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Daftar Alat Camping</h2>
<div class="row">
    <?php if (empty($data['equipment'])): ?>
        <div class="col-12">
            <div class="alert alert-info">Daftar alat masih kosong. Silakan tunggu admin menginput data alat.</div>
        </div>
    <?php endif; ?>
    <?php foreach ($data['equipment'] as $e): ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-img-top bg-light text-center py-4 text-secondary">
                <?php 
                $nama = strtolower(isset($e['nama_alat']) ? $e['nama_alat'] : (isset($e['nama_kategori']) ? $e['nama_kategori'] : ''));
                $imgSrc = '';
                if (strpos($nama, 'tend') !== false) $imgSrc = 'tenda.png';
                elseif (strpos($nama, 'carriel') !== false || strpos($nama, 'tas') !== false) $imgSrc = 'carriel.png';
                elseif (strpos($nama, 'traking') !== false || strpos($nama, 'pole') !== false || strpos($nama, 'tongkat') !== false) $imgSrc = 'traking_pol.png';
                elseif (strpos($nama, 'nesting') !== false || strpos($nama, 'masak') !== false || strpos($nama, 'panci') !== false) $imgSrc = 'nesting.png';
                elseif (strpos($nama, 'slep') !== false || strpos($nama, 'sleep') !== false || strpos($nama, 'tidur') !== false) $imgSrc = 'sleping_bag.png';
                elseif (strpos($nama, 'headlamp') !== false || strpos($nama, 'senter') !== false || strpos($nama, 'lampu') !== false) $imgSrc = 'headlamp.png';
                
                if ($imgSrc): ?>
                    <img src="<?= BASEURL ?>/public/img/<?= $imgSrc ?>" alt="<?= htmlspecialchars($e['nama_alat']) ?>" style="height: 100px; object-fit: contain; width: auto;">
                <?php else: ?>
                    <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $e['nama_alat'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $e['nama_kategori'] ?></h6>
                <p class="card-text">
                    Stok: <?= $e['stok'] ?><br>
                    Harga: Rp <?= number_format($e['harga_sewa']) ?>/hari
                </p>
                <form action="<?= BASEURL ?>/peminjam/pinjam" method="POST">
                    <input type="hidden" name="equipment_id" value="<?= $e['id'] ?>">
                    <div class="input-group mb-3">
                        <input type="number" name="jumlah" class="form-control" value="1" min="1" max="<?= $e['stok'] ?>" required>
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
