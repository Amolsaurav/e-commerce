<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only users can access the cart.</h2>";
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 20px; }
    h2 { margin-bottom: 20px; }
    table { width: 80%; border-collapse: collapse; margin: auto; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    th, td { padding: 15px; text-align: center; border-bottom: 1px solid #ccc; }
    th { background-color: #333; color: white; }
    img { height: 60px; }
    .btn { padding: 8px 15px; color: white; background: red; border: none; cursor: pointer; }
    .btn:hover { background: darkred; }
    .total { font-size: 20px; margin-top: 20px; text-align: right; padding-right: 80px; }
    .back { display: block; margin-top: 30px; text-align: center; }
  </style>
</head>
<body>

<h2 style="text-align:center;">🛒 My Cart</h2>

<?php if (empty($cart)): ?>
  <p style="text-align:center;">Your cart is empty. <a href="user.php">Browse products</a></p>
<?php else: ?>
  <table>
    <tr>
      <th>Image</th>
      <th>Product</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Subtotal</th>
      <th>Action</th>
    </tr>
    <?php
    $total = 0;
    foreach ($cart as $id => $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <tr>
      <td><img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>"></td>
      <td><?= $item['name'] ?></td>
      <td>₹<?= $item['price'] ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>₹<?= $subtotal ?></td>
      <td>
        <form action="remove_cart.php" method="post" style="display:inline;">
          <input type="hidden" name="product_id" value="<?= $id ?>">
          <button type="submit" class="btn">Remove</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <p class="total">Total: ₹<?= $total ?></p>
  <div style="text-align:center; margin-top:20px;">
    <a href="checkout.php"><button class="btn">Checkout</button></a>

  </div>
<?php endif; ?>

<div class="back"><a href="user.php">← Back to categories</a></div>

</body>
</html>
