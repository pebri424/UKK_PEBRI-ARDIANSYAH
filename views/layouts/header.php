<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar { min-height: 100vh; width: 250px; }
        @media print {
            .sidebar, .btn, .no-print { display: none !important; }
            .flex-grow-1 { width: 100%; margin: 0; padding: 0; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body class="d-flex bg-light">
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="sidebar bg-dark text-white p-3 no-print">
        <h4>Camping App</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li><a href="<?= BASEURL ?>/admin/user" class="nav-link text-white">CRUD User</a></li>
                <li><a href="<?= BASEURL ?>/admin/alat" class="nav-link text-white">CRUD Alat</a></li>
                <li><a href="<?= BASEURL ?>/admin/kategori" class="nav-link text-white">CRUD Kategori</a></li>
                <li><a href="<?= BASEURL ?>/admin/peminjaman" class="nav-link text-white">Data Peminjaman</a></li>
                <li><a href="<?= BASEURL ?>/admin/pengembalian" class="nav-link text-white">Pengembalian</a></li>
                <li><a href="<?= BASEURL ?>/admin/log" class="nav-link text-white">Log Aktifitas</a></li>
            <?php elseif ($_SESSION['role'] === 'petugas'): ?>
                <li><a href="<?= BASEURL ?>/petugas/persetujuan" class="nav-link text-white">Setujui Peminjaman</a></li>
                <li><a href="<?= BASEURL ?>/petugas/pantau" class="nav-link text-white">Pantau Pengembalian</a></li>
                <li><a href="<?= BASEURL ?>/petugas/laporan" class="nav-link text-white">Cetak Laporan</a></li>
            <?php elseif ($_SESSION['role'] === 'peminjam'): ?>
                <li><a href="<?= BASEURL ?>/peminjam/daftar" class="nav-link text-white">Daftar Alat</a></li>
                <li><a href="<?= BASEURL ?>/peminjam/pinjaman_saya" class="nav-link text-white">Pinjaman Saya</a></li>
            <?php endif; ?>
        </ul>
        <hr>
        <a href="<?= BASEURL ?>/auth/logout" class="btn btn-danger w-100">Logout</a>
    </div>
    <?php endif; ?>
    <div class="flex-grow-1 p-4 app-content">
