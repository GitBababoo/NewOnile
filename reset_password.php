<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // ตรวจสอบว่ามีอีเมลในระบบหรือไม่
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // สร้าง token เพื่อรีเซ็ตรหัสผ่านและส่งไปทางอีเมล
        $token = bin2hex(random_bytes(50));
        
        // บันทึก token ในฐานข้อมูล
        $sql = "UPDATE users SET reset_token = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        
        // ส่งอีเมลรีเซ็ตรหัสผ่าน (ต้องใช้ฟังก์ชัน mail())
        echo "Password reset link has been sent to your email.";
    } else {
        echo "Email not found.";
    }
}
?>
<!-- ฟอร์มกรอกอีเมลเพื่อขอรีเซ็ตรหัสผ่าน -->
<form method="POST">
    Email: <input type="email" name="email" required><br>
    <button type="submit">Send Reset Link</button>
</form>