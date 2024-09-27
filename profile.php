<?php
include('config.php');

// ตรวจสอบว่าเข้าสู่ระบบแล้วหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ดึงข้อมูลโปรไฟล์จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // อัพเดตข้อมูลโปรไฟล์
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $user_id);
    
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile.";
    }
}
?>
<!-- HTML แสดงโปรไฟล์ -->
<form method="POST">
    Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    <button type="submit">Update Profile</button>
</form>