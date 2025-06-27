<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Access Denied. Only users can view their profile.</h2>";
    exit;
}

$username = $_SESSION['username'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newpass = $_POST['new_password'];
    $confirmpass = $_POST['confirm_password'];

    if ($newpass !== $confirmpass) {
        $message = "Passwords do not match.";
    } elseif (strlen($newpass) < 8 || !preg_match('/[A-Z]/', $newpass) || !preg_match('/[0-9]/', $newpass) || !preg_match('/[^a-zA-Z\d]/', $newpass)) {
        $message = "Password must be 8+ characters long and include a capital letter, number, and special character.";
    } else {
        mysqli_query($conn, "UPDATE users SET password='$newpass' WHERE username='$username'");
        $message = "Password updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            padding: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 500px;
            background: white;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #444;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>
        <a href="user.php">Home</a>
        <a href="cart.php">My Cart</a>
        <a href="orders.php">My Orders</a>
        <a href="profile.php">Profile</a>
    </div>
    <a href="logout.php" style="color:red;">Logout</a>
</div>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>

    <?php if ($message): ?>
        <div class="message <?php echo (strpos($message, 'success') !== false) ? 'success' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Change Password</label>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Update Password</button>
    </form>
</div>

</body>
</html>
