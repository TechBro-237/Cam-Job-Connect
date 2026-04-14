<?php
session_start();
include 'config.php';

if(isset($_POST['register'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($res->num_rows > 0){
        $error = "Email already registered.";
    } else {
        $conn->query("INSERT INTO users(fullname,email,password,role) VALUES('$fullname','$email','$password','$role')");
        $success = "Registered successfully! You can now login.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - CamJobConnect</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<style>
    body {
        background: url('assets/images/workforce.jpg') center/cover no-repeat fixed;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    /* Navbar */
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(6px);
    }
    nav .logo {
        color: #fff;
        font-weight: bold;
        font-size: 1.3rem;
    }
    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
    }
    nav ul li {
        margin-left: 20px;
    }
    nav ul li a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        padding: 8px 15px;
        border-radius: 20px;
        transition: 0.3s;
    }
    nav ul li a:hover {
        background: #0d6efd;
    }

    /* Hero */
    .hero {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 40px;
        border-radius: 15px;
        margin: 40px auto;
        text-align: center;
        max-width: 700px;
    }
    .hero h1 {
        font-size: 2.2rem;
        font-weight: bold;
        color: #0d6efd;
    }
    .hero p {
        font-size: 1.1rem;
        color: #333;
        margin-top: 10px;
    }

    /* Registration */
    .registration {
        background: white;
        padding: 35px;
        border-radius: 15px;
        max-width: 500px;
        margin: 20px auto;
        box-shadow: 0px 5px 25px rgba(0,0,0,0.15);
    }
    .registration h2 {
        color: #0d6efd;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }
    form .form-control, 
    form .form-select {
        width: 100%;
        border-radius: 10px;
    }

    /* Buttons */
    .btn {
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 500;
    }
    .btn-success {
        background: #28a745;
        border: none;
    }
    .btn-success:hover {
        background: #218838;
    }
    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    /* Footer */
    footer {
        background: rgba(0,0,0,0.9);
        color: white;
        text-align: center;
        padding: 15px 0;
        margin-top: auto;
        font-size: 0.9rem;
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

    <!-- Hero -->
    <section class="hero">
        <h1>Join CamJobConnect Today</h1>
        <p>Your trusted platform to connect with skilled professionals. <br>
        Whether you need services or want to offer your expertise, sign up now!</p>
    </section>

    <!-- Registration Form -->
    <div class="registration">
        <h2>Create Your Account</h2>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select class="form-select" name="role" required>
                    <option value="">Select Role</option>
                    <option value="client">Client</option>
                    <option value="provider">Provider</option>
                </select>
            </div>
            <div class="text-center">
                <button class="btn btn-success" name="register">Register</button><br><br>
                <p>Already have an account?</p>
                <a href="login.php" class="btn btn-secondary">Login</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <
