<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only users can access the orders page.</h2>";
    exit;
}

$user = $_SESSION['username'];

// Fetch user's orders
$res = mysqli_query($conn, "SELECT * FROM orders WHERE username='$user' ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 25px;
    }

    .order-card {
      border-bottom: 1px solid #ddd;
      padding: 20px 0;
    }

    .order-card:last-child {
      border-bottom: none;
    }

    .order-date {
      color: #555;
      font-weight: bold;
    }

    .order-items {
      margin: 10px 0;
      color: #444;
    }

    .order-total {
      color: #27ae60;
      font-size: 16px;
      font-weight: bold;
    }

    .no-orders {
      text-align: center;
      color: #999;
      margin-top: 40px;
    }

    .logout {
      color: #e74c3c;
    }

    
  </style>
</head>
<body>

<?php include "navbar.php"?>

<div class="container">
  <h2><i class="fa fa-receipt"></i> My Orders</h2>

  <?php if (mysqli_num_rows($res) === 0): ?>
    <div class="no-orders">
      <p><i class="fa fa-box-open" style="font-size:40px; color:#ccc;"></i></p>
      <p>You haven't placed any orders yet.</p>
      <a href="user.php">Start Shopping</a>
    </div>
  <?php else: ?>
    <?php while ($order = mysqli_fetch_assoc($res)): ?>
      <div class="order-card">
        <div class="order-date">
          <i class="fa fa-calendar"></i> Ordered on: <?= date('d M Y, h:i A', strtotime($order['order_date'])) ?>
        </div>
        <div class="order-items">
          <i class="fa fa-box"></i> <strong>Items:</strong><br>
          <?= nl2br(htmlspecialchars($order['items'])) ?>
        </div>
        <div class="order-total">
          <i class="fa fa-money-bill-wave"></i> Total: ₹<?= number_format($order['total_amount'], 2) ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

</body>
</html>
