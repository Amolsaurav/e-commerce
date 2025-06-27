<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only regular users can access this page.</h2>";
    exit;
}

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    echo "<h3>Invalid product ID.</h3>";
    exit;
}

$result = mysqli_query($conn, "SELECT products.*, categories.name AS category_name 
                                FROM products 
                                JOIN categories ON products.category_id = categories.id 
                                WHERE products.id = $product_id");

if (!$row = mysqli_fetch_assoc($result)) {
    echo "<h3>Product not found.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($row['name']); ?> - Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .product-details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .product-details img {
            width: 100%;
            max-width: 350px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .info {
            flex-grow: 1;
        }

        .info h2 {
            margin-top: 0;
        }

        .price {
            margin-top: 15px;
            font-size: 20px;
        }

        .strikethrough {
            text-decoration: line-through;
            color: red;
        }

        .discounted {
            color: green;
            font-weight: bold;
        }

        .offer {
            color: orange;
            margin-top: 8px;
            display: block;
        }

        .buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .buttons form, .buttons a {
            display: inline-block;
        }

        .buttons button,
        .buttons a {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .buttons button:hover,
        .buttons a:hover {
            background-color: #0056b3;
        }

        @media (max-width: 700px) {
            .product-details {
                flex-direction: column;
                align-items: center;
            }

            .buttons {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="product-details">
        <img src="<?php echo ($row['image']); ?>" alt="<?php echo ($row['name']); ?>" onerror="this.src='default.png';">
        <div class="info">
            <h2><?php echo ($row['name']); ?></h2>
            <p><strong>Category:</strong> <?php echo ($row['category_name']); ?></p>
            <p><strong>Description:</strong> <?php echo nl2br(($row['description'])); ?></p>
            <div class="price">
                <?php if ($row['old_price']): ?>
                    <span class="strikethrough">₹<?php echo $row['old_price']; ?></span>
                <?php endif; ?>
                <?php if ($row['discounted_price']): ?>
                    <span class="discounted">₹<?php echo $row['discounted_price']; ?></span>
                    <span class="offer">(Save ₹<?php echo $row['old_price'] - $row['discounted_price']; ?>)</span>
                <?php else: ?>
                    <span class="discounted">₹<?php echo $row['price']; ?></span>
                <?php endif; ?>
            </div>

            <div class="buttons">
                <form method="post" action="add_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                </form>
                <a href="product.php?cat=<?php echo $row['category_id']; ?>"><i class="fa fa-arrow-left"></i> Back to Products</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
