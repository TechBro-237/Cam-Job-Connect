<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$fullname = $_SESSION['fullname']; // Assuming you stored it in session
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - CamJobConnect</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 240px;
        background: #0d6efd;
        color: white;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 20px 0;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
    }
    .sidebar ul {
        list-style: none;
        padding: 0;
    }
    .sidebar ul li {
        padding: 15px 20px;
        transition: 0.3s;
    }
    .sidebar ul li a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    .sidebar ul li a i {
        margin-right: 10px;
    }
    .sidebar ul li:hover {
        background: rgba(255,255,255,0.15);
    }

    /* Main */
    .main {
        margin-left: 240px;
        padding: 20px;
        flex: 1;
    }
    .topbar {
        background: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .topbar h4 {
        margin: 0;
        font-weight: bold;
        color: #0d6efd;
    }

    /* Cards */
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .card-box {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 5px 15px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.2s;
    }
    .card-box:hover {
        transform: translateY(-5px);
    }
    .card-box i {
        font-size: 2rem;
        color: #0d6efd;
        margin-bottom: 10px;
    }
    .card-box h3 {
        margin: 0;
        font-size: 1.4rem;
        color: #333;
    }
    .card-box p {
        margin: 5px 0 0;
        color: #666;
    }

    /* Footer */
    footer {
        margin-top: 40px;
        text-align: center;
        color: #777;
        font-size: 0.9rem;
    }
</style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>CamJobConnect</h2>
        <ul>
            <li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
            <li><a href="#"><i class="fa fa-briefcase"></i> Requests</a></li>
            <li><a href="#"><i class="fa fa-envelope"></i> Messages</a></li>
            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Topbar -->
        <div class="topbar">
            <h4>Welcome, <?php echo htmlspecialchars($fullname); ?> 👋</h4>
            <div>
                <i class="fa fa-bell"></i>
                <i class="fa fa-user-circle" style="margin-left:15px;"></i>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="cards">
            <div class="card-box">
                <i class="fa fa-briefcase"></i>
                <h3>12</h3>
                <p>Active Requests</p>
            </div>
            <div class="card-box">
                <i class="fa fa-users"></i>
                <h3>48</h3>
                <p>Available Providers</p>
            </div>
            <div class="card-box">
                <i class="fa fa-envelope"></i>
                <h3>5</h3>
                <p>New Messages</p>
            </div>
            <div class="card-box">
                <i class="fa fa-star"></i>
                <h3>4.8</h3>
                <p>Average Rating</p>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            &copy; <?php echo date("Y"); ?> CamJobConnect. All Rights Reserved.
        </footer>
    </div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
