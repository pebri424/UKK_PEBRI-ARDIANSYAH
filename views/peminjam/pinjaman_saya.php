<?php include dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Pinjaman Saya</h2>
<table class="table table-bordered bg-white shadow-sm mt-3">
    <thead class="table-dark">
        <tr>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Kondisi</th>
            <th>Status</th>
            <th>Sisa Waktu</th>
            <th>Estimasi Denda</th>
            <th>Biaya Sewa</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['my_loans'] as $l): ?>
        <?php 
            $estimasi_denda = 0;
            $sisa_waktu = '-';
            // Jika sudah kembali, tampilkan denda yang sudah tercatat di DB
            if ($l['status'] === 'returned') {
                $estimasi_denda = $l['denda'];
            } elseif ($l['status'] === 'approved') {
                // Hitung denda berjalan berdasarkan waktu sekarang
                $waktu_sekarang = new DateTime();
                $jatuh_tempo = new DateTime($l['tanggal_jatuh_tempo']);
                if ($waktu_sekarang > $jatuh_tempo) {
                    $selisih_detik = $waktu_sekarang->getTimestamp() - $jatuh_tempo->getTimestamp();
                    $jam_telat = ceil($selisih_detik / 3600);
                    $estimasi_denda = $jam_telat * 10000;
                    $sisa_waktu = '<span class="text-danger fw-bold">Waktu Habis</span>';
                } else {
                    $selisih = $waktu_sekarang->diff($jatuh_tempo);
                    $sisa_waktu = '<span class="countdown-timer text-primary fw-bold" data-endtime="' . $jatuh_tempo->format('c') . '">' . 
                                  $selisih->format('%a hr %h j %i m %s s') . 
                                  '</span>';
                }
            }
        ?>
        <tr>
            <td><?= $l['nama_alat'] ?></td>
            <td><?= $l['jumlah'] ?></td>
            <td><?= $l['tanggal_pinjam'] ?></td>
            <td><?= $l['tanggal_kembali'] ?: '-' ?></td>
            <td class="<?= ($l['status'] === 'returned' && $l['kondisi_kembali'] === 'rusak') ? 'text-danger fw-bold' : '' ?>">
                <?= $l['status'] === 'returned' ? ucfirst($l['kondisi_kembali']) : '-' ?>
            </td>
            <td>
                <span class="badge bg-<?= $l['status'] === 'approved' ? 'success' : ($l['status'] === 'pending' ? 'warning' : 'info') ?>">
                    <?= ucfirst($l['status']) ?>
                </span>
            </td>
            <td>
                <?= $sisa_waktu ?>
            </td>
            <td class="<?= $estimasi_denda > 0 ? 'text-danger fw-bold' : '' ?>">
                Rp <?= number_format($estimasi_denda) ?>
                <?php if ($l['status'] === 'returned' && ($l['denda_kerusakan'] ?? 0) > 0): ?>
                    <div class="text-muted fw-normal" style="font-size: 0.75rem;">(Rusak: Rp <?= number_format($l['denda_kerusakan']) ?>)</div>
                <?php endif; ?>
            </td>
            <td>Rp <?= number_format($l['total_harga']) ?></td>
            <td class="fw-bold text-primary">Rp <?= number_format($l['total_harga'] + $estimasi_denda) ?></td>
            <td>
                <?php if ($l['status'] === 'approved'): ?>
                    <a href="<?= BASEURL ?>/peminjam/kembalikan/<?= $l['id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Kembalikan alat?')">Kembalikan</a>
                <?php elseif ($l['status'] === 'pending'): ?>
                    <a href="<?= BASEURL ?>/peminjam/batalPinjaman/<?= $l['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan permintaan pinjaman ini?')">Batalkan Peminjaman</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function updateCountdown() {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            const endTime = new Date(timer.getAttribute('data-endtime')).getTime();
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                timer.innerHTML = "Waktu Habis";
                timer.classList.remove('text-primary');
                timer.classList.add('text-danger');
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                timer.innerHTML = (days > 0 ? days + "hr " : "") + hours + "j " + minutes + "m " + seconds + "s";
            }
        });
    }

    // Jalankan setiap detik jika ada timer aktif
    const activeTimers = document.querySelectorAll('.countdown-timer');
    if(activeTimers.length > 0) {
        setInterval(updateCountdown, 1000);
        updateCountdown();
    }
</script>

<?php include dirname(__DIR__) . '/layouts/footer.php'; ?>
