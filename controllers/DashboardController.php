<?php
class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=auth/login');
            exit;
        }

        require_once 'models/Solve.php';
        $solveModel = new Solve();

        // Config Pagination & Search
        $limit = 5; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $keyword = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : null;

        // Ambil Data Table
        $total_data = $solveModel->countByUser($_SESSION['user_id'], $keyword);
        $total_pages = ceil($total_data / $limit);
        $history = $solveModel->getPaginated($_SESSION['user_id'], $start, $limit, $keyword);

        // Ambil Statistik (Total, Best, Ao5, Ao12)
        $stats = $solveModel->getStats($_SESSION['user_id']);

        // --- LOGIKA TAMPILAN WAKTU UTAMA ---
        // Default: 00.00.00 (Saat baru login)
        $displayTimer = "00.00.00"; 
        
        // Jika ada parameter ?show_last=1 (Dikirim oleh JS setelah solve), ambil waktu terakhir
        if (isset($_GET['show_last']) && $_GET['show_last'] == 1) {
            $lastRow = $solveModel->getLastSolve($_SESSION['user_id']);
            if ($lastRow) {
                // Format manual ke 00.00.00
                $ms = $lastRow['time_ms'];
                $min = floor(($ms % (1000 * 60 * 60)) / (1000 * 60));
                $sec = floor(($ms % (1000 * 60)) / 1000);
                $milli = floor(($ms % 1000) / 10);
                
                $displayTimer = sprintf('%02d.%02d.%02d', $min, $sec, $milli);
            }
        }

        require_once 'views/layouts/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layouts/footer.php';
    }
}