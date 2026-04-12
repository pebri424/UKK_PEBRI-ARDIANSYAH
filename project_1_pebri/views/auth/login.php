<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    body {
        background-color: #111 !important;
        background-image: url('<?= BASEURL ?>/public/img/bg_login_with_text.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-attachment: fixed !important;
    }
    .card.shadow {
        background-color: rgba(0, 0, 0, 0.6); /* Transparan gelap tanpa blur */
        backdrop-filter: none;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.5) !important;
    }
    .card-header.theme-header {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    .theme-header h4, .form-label {
        color: #ffffff !important;
        font-weight: 800;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.9);
    }
    .btn-theme {
        background-color: #d88a31; /* Warna emas/senja menyesuaikan gambar */
        border: 2px solid #d88a31;
        color: #111;
        font-weight: bold;
        border-radius: 8px;
    }
    .btn-theme:hover {
        background-color: #b56e20;
        border-color: #b56e20;
        color: white;
        box-shadow: 0 4px 15px rgba(216, 138, 49, 0.4);
    }
    .form-control {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 8px;
        font-weight: bold;
        color: #ffffff !important;
    }
    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.25) !important;
        border-color: #d88a31;
        box-shadow: 0 0 0 0.25rem rgba(216, 138, 49, 0.3);
    }
</style>

<div class="container" style="margin-top: 15vh;">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header theme-header text-center py-3">
                    <h4 class="mb-0">Login Peminjaman Alat</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    <form action="<?= BASEURL ?>/auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-theme w-100 py-2 mt-2">Login</button>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 