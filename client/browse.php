<?php
session_start();
include '../config.php';
include '../functions.php';
if($_SESSION['role'] != 'client') die("Access denied");

$clients = getAllProviders();
?>
<!DOCTYPE html>
<html>
<head>
<title>Browse Services - CamJobConnect</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<style>
    body {
        background: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        margin: 0;
    }

    .container {
        margin-top: 40px;
        margin-bottom: 40px;
    }

    h2 {
        color: #0056b3;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 25px;
        background: #fff;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .card-body h4 {
        font-weight: bold;
        color: #007bff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body h4 small {
        font-weight: normal;
        color: #ff9800;
    }

    .rating-stars {
        color: #ffbf00;
    }

    .card-body p {
        color: #555;
        margin-bottom: 10px;
    }

    .card-body h5 {
        margin-top: 10px;
        font-weight: bold;
        color: #333;
    }

    ul {
        list-style: none;
        padding-left: 0;
    }

    ul li {
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 10px;
        transition: background 0.3s;
    }

    ul li:hover {
        background: #e9f0ff;
    }

    ul li a {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 25px;
        text-decoration: none;
        color: #fff;
        background: #007bff;
        transition: background 0.3s;
    }

    ul li a:hover {
        background: #0056b3;
    }

    /* Footer */
    footer {
        background: #007bff;
        color: white;
        text-align: center;
        padding: 15px 0;
        margin-top: 50px;
        border-radius: 10px;
    }

</style>
</head>
<body>
<nav>
    <ul type="none">
        <li><a href="dashboard.php">Back To Dashboard</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Available Services</h2>

    <?php while($provider = $clients->fetch_assoc()): ?>
    <div class="card">
        <div class="card-body">
            <h4>
                <?php echo $provider['fullname']; ?> 
                <small class="rating-stars">★ <?php echo round(getProviderRating($provider['id']),1); ?></small>
            </h4>
            <p><strong>MTN:</strong> <?php echo $provider['mtn_number']; ?> | <strong>Orange:</strong> <?php echo $provider['orange_number']; ?></p>
            <h5>Services Offered:</h5>
            <ul>
                <?php 
                $services = getProviderServices($provider['id']);
                foreach($services as $service): ?>
                <li>
                    <span><?php echo $service['service_name']; ?> - <?php echo $service['description']; ?></span>
                    <a href="request_job.php?service_id=<?php echo $service['id']; ?>&provider_id=<?php echo $provider['id']; ?>">Request</a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> CamJobConnect. All Rights Reserved.
</footer>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
