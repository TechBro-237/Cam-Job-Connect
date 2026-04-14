<?php
include '../config.php';
session_start();
if($_SESSION['role'] != 'admin') die("Access denied");

// Fetch stats
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$total_providers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='provider'")->fetch_assoc()['total'];
$total_clients = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='client'")->fetch_assoc()['total'];
$total_jobs = $conn->query("SELECT COUNT(*) as total FROM jobs")->fetch_assoc()['total'];
$total_commission = $conn->query("SELECT SUM(commission) as total FROM payments")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - CamJobConnect</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .dashboard-header {
        margin: 30px 0;
        text-align: center;
    }
    h1 {
        font-weight: 700;
        color: #333;
    }
    .card h5 {
        color: #6c757d;
    }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">⚙ Admin Panel</a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="manage_users.php">👤 Users</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_reviews.php">⭐ Reviews</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">⏻ Logout</a></li>
    </ul>
</div>
</nav>

<div class="container">
    <div class="dashboard-header">
        <h1>📊 Admin Dashboard</h1>
        <p class="text-muted">Overview of platform statistics</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center p-3 bg-primary text-white">
                <h5>Total Users</h5>
                <h3><?php echo $total_users; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-success text-white">
                <h5>Providers</h5>
                <h3><?php echo $total_providers; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-info text-white">
                <h5>Clients</h5>
                <h3><?php echo $total_clients; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-warning text-dark">
                <h5>Jobs</h5>
                <h3><?php echo $total_jobs; ?></h3>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card text-center p-3 bg-danger text-white">
                <h5>Total Commission</h5>
                <h3><?php echo number_format($total_commission, 0); ?> XAF</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="text-center">Job Growth Trend</h5>
                <canvas id="jobsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    const ctx = document.getElementById('jobsChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"], // You can fetch months dynamically
            datasets: [{
                label: 'Jobs Posted',
                data: [5, 8, 12, 15, 20, <?php echo $total_jobs; ?>], // Example + latest total
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });
</script>
</body>
</html>
