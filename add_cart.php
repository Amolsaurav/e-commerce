<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only logged-in users can access the cart.</h2>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    // Fetch product details
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    if ($product = mysqli_fetch_assoc($res)) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If product already in cart, increment quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['discounted_price'] ?: $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }

        header("Location: product.php?cat={$product['category_id']}&added=1");
        exit;
    } else {
        echo "Invalid product.";
    }
} else {
    echo "No product selected.";
}
?>
