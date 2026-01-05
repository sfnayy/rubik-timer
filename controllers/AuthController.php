<?php
class AuthController {
    public function login() {
        require_once 'views/layouts/header.php';
        require_once 'views/auth/login.php';
        require_once 'views/layouts/footer.php';
    }

    public function register() {
        require_once 'views/layouts/header.php';
        require_once 'views/auth/register.php';
        require_once 'views/layouts/footer.php';
    }

    public function authenticate() {
        require_once 'models/User.php';
        $userModel = new User();
        $user = $userModel->getUserByUsername($_POST['username']);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        }
        echo "<script>alert('Login Gagal!'); window.location='index.php?url=auth/login';</script>";
    }

    public function store() {
        require_once 'models/User.php';
        $userModel = new User();
        if($userModel->register($_POST['username'], $_POST['password'])) {
            echo "<script>alert('Berhasil daftar!'); window.location='index.php?url=auth/login';</script>";
        } else {
            echo "<script>alert('Gagal daftar!'); window.location='index.php?url=auth/register';</script>";
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?url=auth/login');
    }
}