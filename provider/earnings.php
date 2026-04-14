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
<title>My Earnings</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<h2>My Earnings</h2>
<table class="table table-striped">
<thead>
<tr><th>Job ID</th><th>Client</th><th>Service</th><th>Payment</th><th>Admin Commission</th><th>Net</th></tr>
</thead>
<tbody>
<?php while($job = $jobs->fetch_assoc()): 
    $payment = $conn->query("SELECT * FROM payments WHERE job_id=".$job['id'])->fetch_assoc();
    if($payment):
?>
<tr>
<td><?php echo $job['id']; ?></td>
<td><?php echo $job['client_name']; ?></td>
<td><?php echo $job['service_name']; ?></td>
<td><?php echo $payment['amount']; ?></td>
<td><?php echo $payment['admin_commission']; ?></td>
<td><?php echo $payment['amount'] - $payment['admin_commission']; ?></td>
</tr>
<?php endif; endwhile; ?>
</tbody>
</table>
<a href="dashboard.php" class="btn btn-secondary mt-2">Back</a>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
