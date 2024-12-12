<?php
class Database
{
    private $db_file = 'DATABASE/school_management.db'; // Path to the SQLite database file
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            // Use PDO to connect to the SQLite database
            $this->conn = new PDO("sqlite:" . $this->db_file);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>