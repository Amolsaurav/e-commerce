<?php
include 'config.php';

$name = $_POST['product_name'];
$desc = $_POST['description'];
$old_price = $_POST['old_price'];
$discounted_price = $_POST['discounted_price'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];
$image = '';

if (!empty($_FILES['image_file']['name'])) {
    $filename = basename($_FILES['image_file']['name']);
    $target = "uploads/" . time() . "_" . $filename;
    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target)) {
        $image = $target;
    }
} elseif (!empty($_POST['image_url'])) {
    $image = $_POST['image_url'];
}

$sql = "INSERT INTO products (name, description, old_price, discounted_price, price, category_id, image) 
        VALUES ('$name', '$desc', '$old_price', '$discounted_price', '$price', '$category_id', '$image')";
mysqli_query($conn, $sql);
header("Location: admin.php");
?>
