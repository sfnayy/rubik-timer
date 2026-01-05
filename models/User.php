<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fungsi Login (Cari User by Username)
    public function getUserByUsername($username) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Fungsi Register User Baru
    public function register($username, $password, $role = 'user') {
        $conn = $this->db->getConnection();
        // Hash password (Bcrypt)
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed, $role);
        
        return $stmt->execute();
    }

    // --- FITUR KHUSUS ADMIN ---

    // Ambil SEMUA user (Kecuali Admin sendiri biar gak kehapus)
    public function getAllUsers() {
        $conn = $this->db->getConnection();
        // Urutkan dari yang terbaru daftar
        $res = $conn->query("SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC");
        return $res;
    }

    // Hapus User (Otomatis data solve mereka hilang karena CASCADE di SQL)
    public function delete($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ... (kode sebelumnya tetap ada) ...

    // ADMIN: Ambil detail 1 user berdasarkan ID
    public function getUserById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}