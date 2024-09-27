<?php
include('config.php');

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // เพิ่มสินค้า OTOP ลงฐานข้อมูล
    $sql = "INSERT INTO otop_products (product_name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $product_name, $description, $price);
    
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product.";
    }
}
?>

<form method="POST">
    Product Name: <input type="text" name="product_name" required><br>
    Description: <textarea name="description" required></textarea><br>
    Price: <input type="number" name="price" required><br>
    <button type="submit">Add Product</button>
</form>