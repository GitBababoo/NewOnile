<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // เริ่ม session ถ้ายังไม่มี session
}

class Database {
    private $connection;

    public function __construct($host, $username, $password, $dbname) {
        $this->connect($host, $username, $password, $dbname);
    }

    private function connect($host, $username, $password, $dbname) {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $_SESSION['db_success'] = "เชื่อมต่อฐานข้อมูลสำเร็จ!";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}

// ใช้งาน
$db = new Database('127.0.0.1', 'root', '', 'otop_database');
$conn = $db->getConnection();
