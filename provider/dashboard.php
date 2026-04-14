<?php
include '../config.php';
session_start();
if ($_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];
$profile = $conn->query("SELECT * FROM users WHERE id=$provider_id")->fetch_assoc();
$jobs = $conn->query("SELECT j.*, u.fullname as client_name, s.service_name 
    FROM jobs j 
    JOIN users u ON j.client_id=u.id 
    JOIN services s ON j.service_id=s.id 
    WHERE j.provider_id=$provider_id 
    ORDER BY j.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Provider Dashboard - CamJobConnect</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
        }
        .welcome-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        .welcome-card h1 {
            color: #0056b3;
            font-weight: bold;
        }
        .job-table {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
        table th {
            background: #007bff;
            color: white;
            text-align: center;
        }
        table td {
            text-align: center;
            vertical-align: middle;
        }
        footer {
            margin-top: 50px;
            padding: 15px 0;
            background: #222;
            color: #ddd;
            text-align: center;
            border-top: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">CamJobConnect</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Welcome Card -->
    <div class="container mt-4">
        <div class="welcome-card">
            <h1>Welcome, <?php echo $profile['fullname']; ?> 👋</h1>
            <p class="lead">This is your personalized provider dashboard.  
               Manage your jobs, track requests, and keep your services up to date.</p>
        </div>

        <!-- Jobs Table -->
        <div class="job-table">
            <h3 class="mb-3">Your Jobs</h3>
            <table class="table table-hover table-bordered" style="border: 1px solid #ccc; border-collapse: collapse; width:100%;">
    <thead style="background-color: #f8f9fa; border-bottom: 1px solid #ccc;">
        <tr>
            <th style="border: 1px solid #ccc; padding: 8px;">ID</th>
            <th style="border: 1px solid #ccc; padding: 8px;">Client</th>
            <th style="border: 1px solid #ccc; padding: 8px;">Service</th>
            <th style="border: 1px solid #ccc; padding: 8px;">Status</th>
            <th style="border: 1px solid #ccc; padding: 8px;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php while($job = $jobs->fetch_assoc()): ?>
        <tr>
            <td style="border: 1px solid #ccc; padding: 8px;"><?php echo $job['id']; ?></td>
            <td style="border: 1px solid #ccc; padding: 8px;"><?php echo $job['client_name']; ?></td>
            <td style="border: 1px solid #ccc; padding: 8px;"><?php echo $job['service_name']; ?></td>
            <td style="border: 1px solid #ccc; padding: 8px;">
                <span class="badge 
                    <?php echo ($job['status']=='completed') ? 'bg-success' : 'bg-warning'; ?>">
                    <?php echo ucfirst($job['status']); ?>
                </span>
            </td>
            <td style="border: 1px solid #ccc; padding: 8px;">$<?php echo number_format($job['amount'], 2); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> CamJobConnect. All Rights Reserved.
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
