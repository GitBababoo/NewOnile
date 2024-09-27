<?php
session_start();  // เริ่มต้นเซสชัน

if (isset($_SESSION['user_id'])) {
    // ตรวจสอบว่ามีเซสชัน user_id หรือไม่
    session_unset();  // ล้างตัวแปรเซสชันทั้งหมด
    session_destroy();  // ทำลายเซสชัน

    // ตรวจสอบว่า headers ถูกส่งหรือยัง
    if (!headers_sent()) {
        header("Location: login.php");  // เปลี่ยนเส้นทางไปยังหน้า login
        exit();  // หยุดการทำงานของสคริปต์
    } else {
        // ถ้า headers ถูกส่งไปแล้ว จะแสดงข้อความแจ้ง
        echo "You have logged out. Please click <a href='login.php'>here</a> to log in again.";
    }
} else {
    // ถ้าไม่มีเซสชันที่ใช้งานอยู่
    echo "No active session found. Please log in again.";
}
?>