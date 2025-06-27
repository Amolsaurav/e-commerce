<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only regular users can access this page.</h2>";
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('user.jpg');
            background-size: cover;
        }

        .container {
            padding: 30px;
            background: rgba(255,255,255,0.9);
            max-width: 1000px;
            margin: auto;
            border-radius: 10px;
            margin-top: 30px;
        }

        h2, h3 {
            color: #222;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            padding: 20px;
            max-height: 90vh;
            overflow-y: auto;
            box-sizing: border-box;
        }

        .category-card {
            background: #f4f4f4;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, background 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover {
            background: #e2e2e2;
            transform: scale(1.03);
        }

        .category-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-bottom: 1px solid #ccc;
        }

        .category-card p {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }

        .fa {
            margin-right: 5px;
        }

        @media (max-width: 600px) {
            .category-card p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h2>Welcome, <?php echo ($username); ?>!</h2>

    <h3 id="categories"><i class="fa fa-tags"></i> Product Categories</h3>

    <div class="categories-grid">
        <?php
        $cat_query = mysqli_query($conn, "SELECT * FROM categories");
        while ($cat = mysqli_fetch_assoc($cat_query)) {
            $img = $cat['image'] ? $cat['image'] : 'default.jpg';
            echo "
                <div class='category-card'>
                    <a href='product.php?cat={$cat['id']}'>
                        <img src='" . ($img) . "' alt='" . ($cat['name']) . "'>
                        <p>" . ($cat['name']) . "</p>
                    </a>
                </div>
            ";
        }
        ?>
    </div>
</div>

</body>
</html>
