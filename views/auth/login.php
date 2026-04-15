<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    body {
        background-image: url('<?= BASEURL ?>/public/img/LOG.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Membuat kartu login transparan tanpa efek buram */
    .card {
        background-color: rgba(0, 0, 0, 0.5) !important; /* Hitam transparan 50% */
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: white;
    }

    .card-header {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    }

    .form-label {
        color: white;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }
</style>

<div class="container" style="margin-top: 15vh;">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-white text-center py-3">
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
                        <button type="submit" class="btn btn-primary w-100 py-2 mt-2">Login</button>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 