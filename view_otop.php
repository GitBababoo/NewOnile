<?php
include('config.php');

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM otop_products";
$result = $conn->query($sql);
?>

<h2>OTOP Products</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Price</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['product_id']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['price']; ?></td>
    </tr>
    <?php } ?>
</table>