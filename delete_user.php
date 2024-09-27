<?php
include('config.php');

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// ลบข้อมูลผู้ใช้
$user_id = $_GET['id'];
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location: admin.php");
    exit();
} else {
    echo "Error deleting user.";
}
?>