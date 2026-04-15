<?php

class AuthController extends Controller {

    public function index() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: ' . BASEURL . '/admin/user');
            } elseif ($_SESSION['role'] === 'petugas') {
                header('Location: ' . BASEURL . '/petugas/persetujuan');
            } else {
                header('Location: ' . BASEURL . '/peminjam/daftar');
            }
            exit;
        }
        $this->view('auth/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = $this->model('User_model')->getUserByUsername($username);

            // Cek user dan verifikasi password (support hash & plain text sesuai kode awalmu)
            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];

                // Tetap mencatat log aktivitas login
                $this->model('Log_model')->addLog($user['id'], "User login: " . $user['username']);
                
                if ($_SESSION['role'] === 'admin') {
                    header('Location: ' . BASEURL . '/admin/user');
                } elseif ($_SESSION['role'] === 'petugas') {
                    header('Location: ' . BASEURL . '/petugas/persetujuan');
                } else {
                    header('Location: ' . BASEURL . '/peminjam/daftar');
                }
                exit;
            } else {
                $_SESSION['error'] = 'Username atau password salah!';
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}