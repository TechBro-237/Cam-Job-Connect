<?php
session_start();
include '../config.php';
include '../functions.php';
if($_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];
$jobs = getProviderJobs($provider_id);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Jobs</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<h2>My Jobs</h2>
<table class="table table-striped">
<thead>
<tr><th>ID</th><th>Client</th><th>Service</th><th>Status</th><th>Amount</th></tr>
</thead>
<tbody>
<?php while($job = $jobs->fetch_assoc()): ?>
<tr>
<td><?php echo $job['id']; ?></td>
<td><?php echo $job['client_name']; ?></td>
<td><?php echo $job['service_name']; ?></td>
<td><?php echo $job['status']; ?></td>
<td><?php echo $job['amount']; ?></td>
<td><?php echo $job['hours']; ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<a href="dashboard.php" class="btn btn-secondary mt-2">Back</a>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
