<?php
class SolveController {
    public function store() {
        if (!isset($_SESSION['user_id'])) exit;
        
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['time_ms'])) {
            require_once 'models/Solve.php';
            $solveModel = new Solve();
            if ($solveModel->create($_SESSION['user_id'], $input['time_ms'], $input['scramble'])) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }

    // UPDATE PENALTY (+2 / DNF / OK)
    public function update() {
        if (!isset($_SESSION['user_id'])) exit;

        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['id']) && isset($input['penalty'])) {
            require_once 'models/Solve.php';
            $solveModel = new Solve();
            
            if ($solveModel->updatePenalty($input['id'], $_SESSION['user_id'], $input['penalty'])) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) exit;
        
        require_once 'models/Solve.php';
        $solveModel = new Solve();
        
        $solveModel->delete($id, $_SESSION['user_id']);
        
        // HILANGKAN ALERT: Langsung redirect kembali ke dashboard
        header('Location: index.php');
        exit;
    }
}