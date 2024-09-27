<?php
include('config.php');

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// แสดงรายการผู้ใช้ทั้งหมด
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<h2>User Management</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>
            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>