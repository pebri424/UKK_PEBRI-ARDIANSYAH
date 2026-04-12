<?php 
class AdminController extends Controller {

    public function __construct() {

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function index() {
        header('Location: ' . BASEURL . '/admin/user');
        exit;
    }

    // ========================
    // CRUD USER
    // ========================

    public function user() {
        $data['users'] = $this->model('User_model')->getAllUsers();
        $this->view('admin/user', $data);
    }

    public function tambahUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nama_lengkap' => $_POST['nama_lengkap'],
                'role' => $_POST['role']
            ];

            $this->model('User_model')->register($data);

            header('Location: ' . BASEURL . '/admin/user');
            exit;
        }
    }

    public function editUser($id){
        $data['user'] = $this->model('User_model')->getUserById($id);
        $this->view('admin/edit_user',$data);
    }

    public function updateUser(){

        $data = [
            'id'=>$_POST['id'],
            'username'=>$_POST['username'],
            'nama_lengkap'=>$_POST['nama_lengkap'],
            'role'=>$_POST['role']
        ];

        $this->model('User_model')->updateUser($data);

        header('Location: '.BASEURL.'/admin/user');
    }

    public function hapusUser($id)
    {
        $this->model('User_model')->deleteUser($id);

        header('Location: ' . BASEURL . '/admin/user');
        exit;
    }


    // ========================
    // CRUD ALAT
    // ========================

    public function alat() {

        $data['equipment'] = $this->model('Alat_model')->getAllEquipment();
        $data['categories'] = $this->model('Kategori_model')->getAllCategories();

        $this->view('admin/alat', $data);
    }

    public function tambahAlat() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'category_id' => $_POST['category_id'],
                'nama_alat' => $_POST['nama_alat'],
                'stok' => $_POST['stok'],
                'harga_sewa' => $_POST['harga_sewa']
            ];

            $this->model('Alat_model')->addEquipment($data);

            header('Location: ' . BASEURL . '/admin/alat');
            exit;
        }
    }

    // UPDATE ALAT (dipakai modal edit)
    public function updateAlat()
    {

        $data = [
            'id'=>$_POST['id'],
            'nama_alat'=>$_POST['nama_alat'],
            'category_id'=>$_POST['category_id'],
            'stok'=>$_POST['stok'],
            'harga_sewa'=>$_POST['harga_sewa']
        ];

        $this->model('Alat_model')->updateAlat($data);

        header('Location: '.BASEURL.'/admin/alat');
        exit;
    }

    // HAPUS ALAT
    public function hapusAlat($id)
    {
        $this->model('Alat_model')->deleteEquipment($id);

        header('Location: '.BASEURL.'/admin/alat');
        exit;
    }


    // ========================
    // CRUD KATEGORI
    // ========================

    public function kategori() {

        $data['categories'] = $this->model('Kategori_model')->getAllCategories();

        $this->view('admin/kategori', $data);
    }

    public function tambahKategori() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama_kategori'];
            $this->model('Kategori_model')->addCategory($nama);
            header('Location: ' . BASEURL . '/admin/kategori');
            exit;
        }
    }

    public function updateKategori() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'nama_kategori' => $_POST['nama_kategori']
            ];
            $this->model('Kategori_model')->updateCategory($data);
            header('Location: ' . BASEURL . '/admin/kategori');
            exit;
        }
    }

    public function hapusKategori($id) {

        $this->model('Kategori_model')->deleteCategory($id);

        header('Location: ' . BASEURL . '/admin/kategori');
        exit;
    }


    // ========================
    // DATA PEMINJAMAN
    // ========================

    public function peminjaman() {

        $data['loans'] = $this->model('Peminjaman_model')->getAllLoans();

        $this->view('admin/peminjaman', $data);
    }


    // ========================
    // DATA PENGEMBALIAN
    // ========================

    public function pengembalian() {

        $data['returns'] = $this->model('Peminjaman_model')->getReturnedLoans();

        $this->view('admin/pengembalian', $data);
    }


    // ========================
    // LOG AKTIVITAS
    // ========================

    public function log() {

        $data['logs'] = $this->model('Log_model')->getAllLogs();

        $this->view('admin/log', $data);
    }

}
?>