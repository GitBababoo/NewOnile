<?php
include('config.php');

if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM otop_products WHERE product_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $like_keyword = "%".$keyword."%";
    $stmt->bind_param("s", $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<form method="POST">
    Search: <input type="text" name="keyword" required>
    <button type="submit" name="search">Search</button>
</form>

<?php if (isset($result)) { ?>
    <h2>Search Results:</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li><?php echo $row['product_name']; ?> - <?php echo $row['description']; ?></li>
        <?php } ?>
    </ul>
<?php } ?>