<?php
class User {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($name, $email, $password, $phone_number) {
        $result = $this->db->query("SELECT * FROM users WHERE email = ?", [$email], "s");
        if ($result && $result->num_rows === 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertResult = $this->db->insert("INSERT INTO users (name, email, password, phone_number) VALUES (?, ?, ?, ?)", [$name, $email, $hashed_password, $phone_number], "ssss");
            return $insertResult; // คืนค่าที่แสดงถึงการสร้างผู้ใช้ใหม่
        } else {
            return false; // ผู้ใช้มีอยู่แล้ว
        }
    }

    public function registerWithGoogle($google_id, $name, $email, $picture) {
        $result = $this->db->query("SELECT * FROM users WHERE google_id = ?", [$google_id], "s");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id']; // Get existing user ID

            // อัปเดตข้อมูลผู้ใช้
            $updateResult = $this->db->query("UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ?", [$name, $email, $picture, $userId], "sss");
            return $updateResult !== false; // คืนค่าที่แสดงถึงการอัปเดตสำเร็จ
        } else {
            // สร้างผู้ใช้ใหม่
            return $this->db->insert("INSERT INTO users (google_id, name, email, profile_picture) VALUES (?, ?, ?, ?)", [$google_id, $name, $email, $picture], "ssss") !== false;
        }
    }
}

?>