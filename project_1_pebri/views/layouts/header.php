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
        <?php if (isset($_SESSION['user_id'])): ?>
        body {
            background-color: #111 !important;
            background-image: url('<?= BASEURL ?>/public/img/bg_login.jpg') !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
            color: #f8f9fa;
        }
        .sidebar {
            background-color: rgba(0, 0, 0, 0.25) !important; /* Sangat transparan agar tidak menutupi gambar */
            backdrop-filter: none; /* Hilangkan efek blur */
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }
        .app-content {
            background-color: rgba(0, 0, 0, 0.45); /* Efek gelap agar tulisan tabel terbaca */
            min-height: 100vh;
        }
        .glass-card {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 12px;
            color: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        /* Tabel & Teks Global untuk Contrast */
        .table, .table.bg-white { 
            background-color: transparent !important; 
            border-color: rgba(255, 255, 255, 0.2) !important; 
            --bs-table-color: #ffffff !important;
            --bs-table-bg: transparent !important;
        }
        .table td, .table th { 
            color: #ffffff !important;
            opacity: 1 !important;
            font-weight: bold !important;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 1);
            background-color: rgba(0, 0, 0, 0.65) !important; /* Latar gelap yang lebih padat */
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        .table thead th { 
            background-color: rgba(0,0,0,0.75) !important; 
            color: #d88a31 !important; 
            text-shadow: none;
        }
        .table tbody tr:hover td { 
            background-color: rgba(255,255,255,0.15) !important; 
            color: #fff !important; 
        }
        
        h2, h3, h4, h5 {
            color: #fff !important;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.9);
        }
        .text-muted { color: #d0d0d0 !important; }
        
        .nav-pills .nav-link { color: #f8f9fa; font-weight: 500; transition: 0.3s; }
        .nav-pills .nav-link:hover { background-color: rgba(216, 138, 49, 0.2); }
        .btn-theme {
            background-color: #d88a31;
            border-color: #d88a31;
            color: #111;
            font-weight: bold;
        }
        .btn-theme:hover { background-color: #b56e20; color: #fff; }
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-color: #d88a31;
            box-shadow: 0 0 0 0.25rem rgba(216, 138, 49, 0.25);
        }
        
        /* Tema Modal (Pop-up Tambah User dsb) */
        .modal-content {
            background-color: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #ffffff !important;
            box-shadow: 0 15px 40px rgba(0,0,0,0.8);
        }
        .modal-header, .modal-footer {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        .modal-title { color: #d88a31 !important; text-shadow: none !important; font-weight: bold; }
        .modal-body label { font-weight: bold; color: #fff; margin-bottom: 5px; }
        
        /* Tema Global Tombol Biru (Primary) agar bernuansa senja (Emas/Oranye) */
        .btn-primary {
            background-color: #d88a31 !important;
            border-color: #d88a31 !important;
            color: #111 !important;
            font-weight: bold !important;
        }
        .btn-primary:hover { background-color: #b56e20 !important; color: #fff !important; box-shadow: 0 4px 15px rgba(216, 138, 49, 0.4); }
        
        /* Opsi Dropdown (Role) */
        .form-control option, .form-select option { background-color: #111; color: #fff; }
        
        /* Tema Tombol Aksi (Edit, Hapus, Simpan) */
        .btn-warning {
            background-color: rgba(255, 193, 7, 0.85) !important;
            border-color: rgba(255, 193, 7, 0.6) !important;
            color: #111 !important;
            font-weight: bold;
        }
        .btn-warning:hover { background-color: #ffc107 !important; box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4); }
        
        .btn-danger {
            background-color: rgba(220, 53, 69, 0.85) !important;
            border-color: rgba(220, 53, 69, 0.6) !important;
            color: #fff !important;
            font-weight: bold;
        }
        .btn-danger:hover { background-color: #dc3545 !important; box-shadow: 0 4px 10px rgba(220, 53, 69, 0.4); }
        
        .btn-success {
            background-color: rgba(25, 135, 84, 0.85) !important;
            border-color: rgba(25, 135, 84, 0.6) !important;
            color: #fff !important;
            font-weight: bold;
        }
        .btn-success:hover { background-color: #198754 !important; box-shadow: 0 4px 10px rgba(25, 135, 84, 0.4); }
        
        /* Tema Lencana Status (Badge) */
        .badge {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(4px);
            padding: 6px 10px;
        }
        .badge.bg-success { border-color: #198754; color: #34d08c !important; }
        .badge.bg-warning { border-color: #ffc107; color: #ffda6a !important; }
        .badge.bg-info { border-color: #0dcaf0; color: #6edff6 !important; }
        
        /* Tema Kotak Pendukung (Card Standar) */
        .card {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 12px;
            color: #fff !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .card-header, .card-footer { border-color: rgba(255, 255, 255, 0.1) !important; }
        
        <?php endif; ?>
    </style>
</head>
<body class="d-flex">
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="sidebar text-white p-3 no-print">
        <h4>Camping App</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="<?= BASEURL ?>/dashboard" class="nav-link text-white">Dashboard</a></li>
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
