<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only regular users can access this page.</h2>";
    exit;
}

$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$cat_name = "";

if ($cat_id > 0) {
    $cat_res = mysqli_query($conn, "SELECT name FROM categories WHERE id = $cat_id");
    if ($row = mysqli_fetch_assoc($cat_res)) {
        $cat_name = $row['name'];
    } else {
        echo "<h3>Invalid category.</h3>";
        exit;
    }
} else {
    echo "<h3>No category selected.</h3>";
    exit;
}

$products = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $cat_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo ($cat_name); ?> Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        .container {
            padding: 30px 20px;
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 26px;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .product {
            background: white;
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            padding: 15px;
            transition: transform 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .product h3 {
            margin: 10px 0 5px;
            font-size: 18px;
            color: #333;
        }

        .strikethrough {
            text-decoration: line-through;
            color: red;
            margin-right: 8px;
        }

        .discounted {
            color: green;
            font-weight: bold;
        }

        .offer {
            color: orange;
            font-size: 14px;
            margin-top: 4px;
        }

        .product .view-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            width: 90%;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .product .view-btn:hover {
            background-color: #0056b3;
        }

        .fa {
            margin-right: 6px;
        }

        @media (max-width: 600px) {
            .products {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h2><i class="fa fa-tags"></i> <?php echo ($cat_name); ?> Products</h2>
    <div class="products">
        <?php while ($row = mysqli_fetch_assoc($products)): ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo ($row['name']); ?>" onerror="this.src='default.png';">
                <h3><?php echo ($row['name']); ?></h3>
                <p>
                    <?php if ($row['old_price']): ?>
                        <span class="strikethrough">₹<?php echo $row['old_price']; ?></span>
                    <?php endif; ?>
                    <?php if ($row['discounted_price']): ?>
                        <span class="discounted">₹<?php echo $row['discounted_price']; ?></span>
                        <div class="offer">(Save ₹<?php echo $row['old_price'] - $row['discounted_price']; ?>)</div>
                    <?php else: ?>
                        <span class="discounted">₹<?php echo $row['price']; ?></span>
                    <?php endif; ?>
                </p>
                <a class="view-btn" href="view_product.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye"></i> View Description</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
