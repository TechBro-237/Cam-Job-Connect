<?php
session_start();
include 'config.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($res->num_rows > 0){
        $user = $res->fetch_assoc();
        if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            // Redirect based on role
            if($user['role']=='admin') header("Location: admin/dashboard.php");
            elseif($user['role']=='provider') header("Location: provider/dashboard.php");
            else header("Location: client/dashboard.php");
            exit;
        } else $error = "Incorrect password.";
    } else $error = "User not found.";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - CamJobConnect</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('assets/images/connect.jpg') no-repeat center center/cover;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Navbar */
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(0,123,255,0.9);
        padding: 15px 50px;
        position: sticky;
        top: 0;
    }
    nav .logo {
        font-size: 22px;
        font-weight: bold;
        color: white;
    }
    nav ul {
        list-style: none;
        display: flex;
        gap: 20px;
        margin: 0;
    }
    nav ul li a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    nav ul li a:hover {
        color: #ffdd57;
    }

    /* Login container */
    .login-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-box {
        background: rgba(255,255,255,0.95);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .login-box h2 {
        margin-bottom: 20px;
        color: #007bff;
    }

    /* Inputs */
    .form-control {
        border-radius: 8px;
        margin-bottom: 15px;
    }

    /* Buttons */
    .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
        transition: background 0.3s ease;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
    .btn-secondary {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
    }

    /* Footer */
    footer {
        background: #222;
        color: #bbb;
        text-align: center;
        padding: 15px;
    }
</style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">CamJobConnect</div>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="register.php">Sign Up</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>
    </nav>

    <!-- Login Box -->
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <button class="btn btn-primary w-100 mb-2" name="login">Login</button>
                <a href="register.php" class="btn btn-secondary w-100">Register</a>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 CamJobConnect. All Rights Reserved.</p>
    </footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
