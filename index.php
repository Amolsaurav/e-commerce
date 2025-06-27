<?php
session_start();
include 'config.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['Username'];
    $pass = $_POST['Password'];

    if (isset($_POST['register'])) {
        if (strlen($pass) < 8 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[0-9]/', $pass) || !preg_match('/[^a-zA-Z\d]/', $pass)) {
            $message = "Password must be 8+ characters, with a capital letter, number, and special character.";
        } else {
            $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
            if (mysqli_num_rows($check) > 0) {
                $message = "Username already exists.";
            } else {
                mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$user', '$pass', 'user')");
                $message = "Registration successful. You may now log in.";
            }
        }
    } elseif (isset($_POST['login'])) {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit;
        } else {
            $message = "Invalid login credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('login.jpg');
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    form {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      width: 320px;
      animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      margin-bottom: 25px;
      text-align: center;
      color: #333;
    }
    .input {
      position: relative;
      margin-bottom: 20px;
    }
    .input i {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #888;
    }
    .input input {
      width: 100%;
      padding: 10px 10px 10px 35px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border-color 0.3s;
    }
    .input input:focus {
      border-color: #4a90e2;
      outline: none;
    }
    .button {
      display: flex;
      justify-content: space-between;
    }
    .button button {
      width: 48%;
      padding: 10px;
      background: #4a90e2;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
      font-weight: bold;
    }
    .button button:hover {
      background: #357ab8;
    }
    .message {
      margin-top: 15px;
      color: red;
      text-align: center;
      font-weight: 500;
    }
  </style>
</head>
<body>
   <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <h2>Login</h2>
    <div class="input">
      <i class="fa fa-user-circle-o" aria-hidden="true"></i>
      <input type="text" placeholder="Username" name="Username" required />
    </div>
    <div class="input">
      <i class="fa fa-lock" aria-hidden="true"></i>
      <input type="password" placeholder="Password" name="Password" required />
    </div>
    <div class="button">
      <button type="submit" name="login">Login</button>
      <button type="submit" name="register">Sign Up</button>
    </div>
    <?php if ($message): ?>
      <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
  </form>
</body>
</html>
