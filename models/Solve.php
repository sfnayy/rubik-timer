<?php
class Solve {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($user_id, $time_ms, $scramble) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO solves (user_id, time_ms, scramble) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $time_ms, $scramble);
        return $stmt->execute();
    }

    public function delete($id, $user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM solves WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    public function countByUser($user_id, $keyword = null) {
        $conn = $this->db->getConnection();
        $sql = "SELECT COUNT(*) as total FROM solves WHERE user_id = ?";
        if ($keyword) $sql .= " AND scramble LIKE ?";
        
        $stmt = $conn->prepare($sql);
        if ($keyword) {
            $param = "%$keyword%";
            $stmt->bind_param("is", $user_id, $param);
        } else {
            $stmt->bind_param("i", $user_id);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getPaginated($user_id, $start, $limit, $keyword = null) {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM solves WHERE user_id = ?";
        if ($keyword) $sql .= " AND scramble LIKE ?";
        $sql .= " ORDER BY created_at DESC LIMIT ?, ?";
        
        $stmt = $conn->prepare($sql);
        if ($keyword) {
            $param = "%$keyword%";
            $stmt->bind_param("isii", $user_id, $param, $start, $limit);
        } else {
            $stmt->bind_param("iii", $user_id, $start, $limit);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    // --- FITUR BARU: STATISTIK ---
    public function getStats($user_id) {
        $conn = $this->db->getConnection();
        $stats = [
            'total' => 0,
            'best'  => '-',
            'ao5'   => '-',
            'ao12'  => '-'
        ];

        // 1. Total Solves
        $res = $conn->query("SELECT COUNT(*) as total FROM solves WHERE user_id = $user_id");
        if($res) $stats['total'] = $res->fetch_assoc()['total'];

        // 2. Best Time
        $res = $conn->query("SELECT MIN(time_ms) as best FROM solves WHERE user_id = $user_id");
        if($res) {
            $row = $res->fetch_assoc();
            if($row['best']) $stats['best'] = $this->formatTime($row['best']);
        }

        // 3. Ambil 12 data terakhir (DESC) untuk Ao5/Ao12
        $res = $conn->query("SELECT time_ms FROM solves WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 12");
        $times = [];
        while($row = $res->fetch_assoc()) {
            $times[] = $row['time_ms'];
        }

        // Hitung Ao5 (Rata-rata 5 terakhir)
        if (count($times) >= 5) {
            $slice5 = array_slice($times, 0, 5);
            // Standar WCA membuang time tercepat & terlambat, tapi ini rata-rata simpel dulu
            $avg5 = array_sum($slice5) / 5;
            $stats['ao5'] = $this->formatTime($avg5);
        }

        // Hitung Ao12 (Rata-rata 12 terakhir)
        if (count($times) >= 12) {
            $avg12 = array_sum($times) / 12;
            $stats['ao12'] = $this->formatTime($avg12);
        }

        return $stats;
    }

    private function formatTime($ms) {
        $sec = floor($ms / 1000);
        $milli = floor(($ms % 1000) / 10);
        return sprintf('%02d.%02d', $sec, $milli);
    }

    // ... fungsi stats, delete, dll tetap ada ...

    // AMBIL 1 DATA TERAKHIR (Untuk ditampilkan di Timer setelah stop)
    public function getLastSolve($user_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT time_ms FROM solves WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePenalty($id, $user_id, $penalty) {
        $conn = $this->db->getConnection();
        // Penalty hanya boleh: 'OK', '+2', atau 'DNF'
        $stmt = $conn->prepare("UPDATE solves SET penalty = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $penalty, $id, $user_id);
        return $stmt->execute();
    }

    // ... (kode sebelumnya tetap ada) ...

    // ADMIN: Ambil SEMUA data solve milik user tertentu
    public function getAllSolvesByUserId($user_id) {
        $conn = $this->db->getConnection();
        // Urutkan dari terbaru
        $stmt = $conn->prepare("SELECT * FROM solves WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}