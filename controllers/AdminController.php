<?php
class AdminController {
    
    public function index() {
        // 1. CEK KEAMANAN: Apakah Login & Apakah Admin?
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            // Kalau bukan admin, tendang ke dashboard biasa
            header('Location: index.php'); 
            exit;
        }

        // 2. Ambil Data Semua User
        require_once 'models/User.php';
        $userModel = new User();
        $users = $userModel->getAllUsers();

        // 3. Tampilkan View Admin
        require_once 'views/layouts/header.php';
        require_once 'views/admin/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function deleteUser($id) {
        // 1. CEK KEAMANAN
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php'); 
            exit;
        }

        require_once 'models/User.php';
        $userModel = new User();
        
        // 2. Hapus User
        if ($userModel->delete($id)) {
            echo "<script>alert('User berhasil dihapus!'); window.location='index.php?url=admin/index';</script>";
        } else {
            echo "<script>alert('Gagal menghapus user.'); window.location='index.php?url=admin/index';</script>";
        }
    }

    // ... (kode index dan deleteUser tetap ada) ...

    // HALAMAN DETAIL USER (Lihat Timer)
    public function viewSolves($user_id) {
        // 1. Cek Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php'); exit;
        }

        require_once 'models/User.php';
        require_once 'models/Solve.php';
        
        $userModel = new User();
        $solveModel = new Solve();

        // 2. Ambil Data
        $targetUser = $userModel->getUserById($user_id);
        $solves = $solveModel->getAllSolvesByUserId($user_id);

        // 3. Tampilkan View
        require_once 'views/layouts/header.php';
        require_once 'views/admin/view_solves.php'; // File baru yang akan kita buat
        require_once 'views/layouts/footer.php';
    }
}