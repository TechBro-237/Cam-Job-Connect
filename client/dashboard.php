<?php
include '../config.php';
session_start();
if($_SESSION['role'] != 'client') die("Access denied");

$client_id = $_SESSION['user_id'];

// Fetch jobs made by client
$jobs = $conn->query("SELECT j.*, u.fullname as provider_name, s.service_name 
                      FROM jobs j 
                      JOIN users u ON j.provider_id=u.id 
                      JOIN services s ON j.service_id=s.id 
                      WHERE j.client_id=$client_id 
                      ORDER BY j.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard - CamJobConnect</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        h1, h2 {
            color: #0056b3;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .btn {
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-primary {
            background: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .table-wrapper {
            background: white;
            padding: 20px;
            border-radius: 15px;
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

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Welcome Card -->
    <div class="card text-center">
        <h1>Welcome, Client!</h1>
        <p>Find and hire trusted service providers on-demand: plumbers, electricians, civil engineers, and more.</p>
        <a href="browse.php" class="btn btn-primary">Browse Services</a>
    </div>

    <!-- Job Requests -->
    <div class="card table-wrapper">
        <h2>Your Job Requests</h2>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Provider</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($job = $jobs->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $job['id']; ?></td>
                    <td><?php echo $job['provider_name']; ?></td>
                    <td><?php echo $job['service_name']; ?></td>
                    <td><?php echo ucfirst($job['status']); ?></td>
                    <td><?php echo number_format($job['amount'], 2); ?></td>
                    <td>
                        <!-- Review button -->
                        <?php if($job['status'] == 'completed'): ?>
                            <a href="reviews.php?provider_id=<?php echo $job['provider_id']; ?>&job_id=<?php echo $job['id']; ?>" 
                               class="btn btn-sm btn-success">Leave Review</a>
                        <?php else: ?>
                            <span class="text-muted">Not Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Logout -->
    <div class="text-center">
        <a href="../logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
