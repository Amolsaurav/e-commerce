<?php
session_start();
include "config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Access Denied. You are not an admin.</h2>";
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background:url('admin.jpg');background-size:cover; }
    .navbar {
      background-color: #1e1e1e;
      padding: 10px 20px;
      position: sticky;
      top: 0;
      display: flex;
      align-items: center;
      z-index: 1000;
    }
    .navbar a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .navbar a:hover {
      background-color: #444;
    }
    .navbar video {
      height: 40px;
      margin-right: auto;
      border-radius: 5px;
    }
    section {
      display: none;
      padding: 30px 20px;
      background: white;
      margin: 20px;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    section.active {
      display: block;
    }
    h2 { color: #333; }
    form input, form select, form textarea, form button {
      display: block;
      margin: 10px 0;
      padding: 10px;
      width: 100%;
      max-width: 400px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    form button {
      background: #28a745;
      color: white;
      border: none;
      cursor: pointer;
    }
    form button:hover {
      background: #218838;
    }
    .logout {
      color: red;
      margin-left: auto;
      background: white;
      padding: 6px 12px;
      border-radius: 5px;
    }
    .strikethrough { text-decoration: line-through; color: red; }
    .price-highlight { color: green; font-weight: bold; }
    .offer { color: orange; }
    img { border-radius: 5px; margin: 5px 0; }
    .item-box {
      padding: 15px;
      background: #fafafa;
      margin-bottom: 15px;
      border-radius: 8px;
      box-shadow: 0 0 4px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<div class="navbar">
  
  <video src="logo.mp4" autoplay muted loop></video>
  <a onclick="showSection('addCategory')">Add Category</a>
  <a onclick="showSection('addProduct')">Add Product</a>
  <a onclick="showSection('viewCategories')">View Categories</a>
  <a onclick="showSection('viewProducts')">View Products</a>
  <a href="logout.php" class="logout">Logout</a>
</div>

<h1 style="padding: 20px;">Welcome, Admin <?php echo htmlspecialchars($username); ?>!</h1>


<section id="addCategory" class="active">
  <h2>Add New Category</h2>
  <form action="add_category.php" method="post" enctype="multipart/form-data">
    <input type="text" name="category_name" placeholder="Category Name" required>
    <input type="text" name="image_url" placeholder="Or paste image URL">
    <input type="file" name="image_file" accept="image/*">
    <button type="submit">Add Category</button>
  </form>
</section>

<!-- 📦 Add Product -->
<section id="addProduct">
  <h2>Add New Product</h2>
  <form action="add_product.php" method="post" enctype="multipart/form-data">
    <input type="text" name="product_name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" name="old_price" placeholder="Old Price (Optional)" step="0.01">
    <input type="number" name="discounted_price" placeholder="Discounted Price (Optional)" step="0.01">
    <input type="number" name="price" placeholder="Final Price" step="0.01" required>
    <select name="category_id" required>
      <option value="">Select Category</option>
      <?php
      $res = mysqli_query($conn, "SELECT * FROM categories");
      while ($cate = mysqli_fetch_assoc($res)) {
          echo "<option value='{$cate['id']}'>{$cate['name']}</option>";
      }
      ?>
    </select>
    <input type="text" name="image_url" placeholder="Or paste image URL">
    <input type="file" name="image_file" accept="image/*">
    <button type="submit">Add Product</button>
  </form>
</section>

<!-- 📋 View Categories -->
<section id="viewCategories">
  <h2>All Categories</h2>
  <?php
  $res = mysqli_query($conn, "SELECT * FROM categories");
  while ($row = mysqli_fetch_assoc($res)) {
      echo "<div class='item-box'><strong>{$row['name']}</strong><br>";
      if (!empty($row['image'])) {
          echo "<img src='{$row['image']}' width='100'><br>";
      }
      echo "<a href='delete.php?type=category&id={$row['id']}'>Delete</a></div>";
  }
  ?>
</section>

<!-- 🛍️ View Products -->
<section id="viewProducts">
  <h2>All Products</h2>
  <?php
  $res = mysqli_query($conn, "SELECT products.*, categories.name AS cate_name 
                               FROM products 
                               JOIN categories ON products.category_id = categories.id");
  while ($row = mysqli_fetch_assoc($res)) {
      echo "<div class='item-box'><strong>{$row['name']}</strong><br>";
      if ($row['old_price']) {
          echo "<span class='strikethrough'>₹{$row['old_price']}</span> ";
      }
      if ($row['discounted_price']) {
          echo "<span class='price-highlight'>₹{$row['discounted_price']}</span> ";
          $saving = $row['old_price'] - $row['discounted_price'];
          echo "<span class='offer'>(Save ₹{$saving})</span><br>";
      } else {
          echo "<span class='price-highlight'>₹{$row['price']}</span><br>";
      }
      echo "Category: {$row['cate_name']}<br>";
      if (!empty($row['image'])) {
          echo "<img src='{$row['image']}' width='100'><br>";
      }
      echo "<a href='delete.php?type=product&id={$row['id']}'>Delete</a></div>";
  }
  ?>
</section>

<script>
function showSection(id) {
  document.querySelectorAll("section").forEach(section => {
    section.classList.remove("active");
  });
  document.getElementById(id).classList.add("active");
}
</script>

</body>
</html>
