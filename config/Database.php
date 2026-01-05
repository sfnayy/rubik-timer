<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "db_rubik_uas";
    
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        } catch(Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>