<?php
if (!isset($_SESSION)) session_start();

$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>

<style>
    .navbar {
        background-color: #111;
        padding: 14px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .navbar .left {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .navbar .logo img {
        height: 40px;
        margin-right: 20px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 12px;
        font-weight: bold;
        font-size: 16px;
        position: relative;
    }

    .navbar a:hover {
        text-decoration: underline;
    }

    .navbar form {
        margin-left: 20px;
        display: flex;
        align-items: center;
    }

    .navbar input[type="text"] {
        padding: 6px 10px;
        border-radius: 4px;
        border: none;
        font-size: 14px;
    }

    .navbar button {
        padding: 6px 10px;
        margin-left: 5px;
        border: none;
        background-color: rgb(13, 15, 14);
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .navbar button:hover {
        background-color: rgb(105, 107, 105);
    }

    .logout {
        color: red;
    }

    .cart-badge {
        background-color: red;
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50%;
        position: absolute;
        top: -8px;
        right: -10px;
    }

    @media (max-width: 600px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar .logo {
            margin-bottom: 10px;
        }

        .navbar a {
            margin: 8px 0;
        }

        .navbar form {
            margin: 10px 0 0 0;
            width: 100%;
        }

        .navbar input[type="text"] {
            width: 70%;
        }

        .navbar button {
            width: 25%;
        }
    }
</style>

<div class="navbar">
    <div class="left">
        <div class="logo">
    <a href="user.php">
        <video autoplay loop muted playsinline height="40">
            <source src="logo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </a>
</div>

        <a href="user.php"><i class="fa fa-home"></i> Home</a>
        <a href="user.php#categories"><i class="fa fa-list"></i> Categories</a>
        <a href="cart.php" class="cart-link">
            <i class="fa fa-shopping-cart"></i> My Cart
            <?php if ($cart_count > 0): ?>
                <span class="cart-badge"><?php echo $cart_count; ?></span>
            <?php endif; ?>
        </a>
        <a href="orders.php"><i class="fa fa-box"></i> My Orders</a>
        <a href="profile.php"><i class="fa fa-user"></i> Profile</a>

        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search products...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="right">
        <a class="logout" href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
