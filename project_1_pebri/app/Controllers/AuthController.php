<?php
class AuthController extends Controller {
    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/index');
            exit;
        }
        $this->view('auth/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model('User_model')->getUserByUsername($username);

            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];

                $this->model('Log_model')->addLog($user['id'], "User login: " . $user['username']);
                header('Location: ' . BASEURL . '/dashboard/index');
                exit;
            } else {
                $_SESSION['error'] = 'Username atau password salah!';
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        }
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard/index');
            exit;
        }
        $this->view('auth/register');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nama_lengkap' => $_POST['nama_lengkap'],
                'role' => 'peminjam'
            ];

            if ($_POST['password'] !== $_POST['confirm_password']) {
                $_SESSION['error'] = 'Konfirmasi password tidak cocok!';
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if ($this->model('User_model')->getUserByUsername($data['username'])) {
                $_SESSION['error'] = 'Username sudah digunakan!';
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if ($this->model('User_model')->register($data)) {
                $user = $this->model('User_model')->getUserByUsername($data['username']);
                $this->model('Log_model')->addLog($user['id'], "New user registered: " . $data['username']);
                $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
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
?>
