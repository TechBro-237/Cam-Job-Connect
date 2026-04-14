<?php
session_start();
include '../config.php';
include '../functions.php';
if($_SESSION['role'] != 'client') die("Access denied");

$client_id = $_SESSION['user_id'];
$service_id = $_GET['service_id'];
$provider_id = $_GET['provider_id'];

$service = $conn->query("SELECT * FROM services WHERE id=$service_id")->fetch_assoc();
$provider = $conn->query("SELECT * FROM users WHERE id=$provider_id")->fetch_assoc();

if(isset($_POST['request'])){
    $hours = floatval($_POST['hours']); // Number of hours client wants
    $amount = $service['rate_per_hour'] * $hours; // Total payment
    $payment_method = $_POST['payment_method'];

    // Insert job
    $stmt = $conn->prepare("INSERT INTO jobs(client_id,provider_id,service_id,payment_method,amount,hours) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("iiisdi",$client_id,$provider_id,$service_id,$payment_method,$amount,$hours);
    $stmt->execute();
    $job_id = $stmt->insert_id;

    // Process payment
    $msg = processPayment($job_id,$amount,$payment_method);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Request Service</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<h2>Request Service: <?php echo $service['service_name']; ?> from <?php echo $provider['fullname']; ?></h2>
<p>Rate per Hour: <?php echo number_format($service['rate_per_hour'],2); ?> XAF</p>
<?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
<form method="POST">
<div class="mb-3">
    <label>Number of Hours</label>
    <input type="number" class="form-control" name="hours" step="0.1" required>
</div>
<div class="mb-3">
    <label>Payment Method</label>
    <select class="form-select" name="payment_method" required>
        <option value="mtn">MTN</option>
        <option value="orange">Orange Money</option>
    </select>
</div>
<button class="btn btn-success" name="request">Request & Pay</button>
<a href="browse.php" class="btn btn-secondary">Back</a>
</form>-
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
