<?php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'otop_database');

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = [], $types = "") {
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            // Log the error for debugging!
            error_log("Prepare statement failed: " . $this->conn->error . " - SQL: " . $sql);
            return false;
        }
    }

    public function insert($sql, $params = [], $types = "") {
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            if ($stmt->execute()) {
                return $this->conn->insert_id;
            } else {
                // Log the error for debugging
                error_log("Execute statement failed: " . $this->conn->error . " - SQL: " . $sql);
                return false;
            }
        } else {
            //Log the error for debugging
            error_log("Prepare statement failed: " . $this->conn->error . " - SQL: " . $sql);
            return false;
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>