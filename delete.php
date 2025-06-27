<?php
include 'config.php';

$id = $_GET['id'];
$type = $_GET['type'];

if ($type === 'category') {
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    mysqli_query($conn, "DELETE FROM products WHERE category_id = $id"); // Optional: cascade delete products
} elseif ($type === 'product') {
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
}

header("Location: admin.php");
?>
