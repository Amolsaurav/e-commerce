<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only users can checkout.</h2>";
    exit;
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "<h2>Your cart is empty. <a href='user.php'>Shop Now</a></h2>";
    exit;
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'];

$items = "";
$total = 0;

foreach ($cart as $id => $product) {
    $quantity = $product['quantity'];
    $name = $product['name'];
    $price = $product['price'];
    $lineTotal = $price * $quantity;

    $items .= "{$quantity}x {$name}\n";
    $total += $lineTotal;
}

// Insert into orders table
$escaped_items = mysqli_real_escape_string($conn, $items);
$query = "INSERT INTO orders (username, items, total_amount) VALUES ('$username', '$escaped_items', '$total')";

if (mysqli_query($conn, $query)) {
    // Clear cart
    unset($_SESSION['cart']);
    echo "<h2>Order placed successfully! <a href='orders.php'>View Orders</a></h2>";
} else {
    echo "Something went wrong. Try again.";
}
?>
