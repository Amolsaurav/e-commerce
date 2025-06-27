<?php
include 'config.php';

$name = $_POST['category_name'];
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

$sql = "INSERT INTO categories (name, image) VALUES ('$name', '$image')";
mysqli_query($conn, $sql);
header("Location: admin.php");
?>
