<?php
session_start();
include '../config.php';
if($_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];
$service_id = $_GET['id'];
$service = $conn->query("SELECT * FROM services WHERE id=$service_id AND provider_id=$provider_id")->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['service_name'];
    $desc = $_POST['description'];
    $stmt = $conn->prepare("UPDATE services SET service_name=?, description=? WHERE id=? AND provider_id=?");
    $stmt->bind_param("ssii",$name,$desc,$service_id,$provider_id);
    $stmt->execute();
    $success = "Service updated!";
    $service = $conn->query("SELECT * FROM services WHERE id=$service_id AND provider_id=$provider_id")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Service</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
<h2>Edit Service</h2>
<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
<form method="POST">
<div class="mb-3">
<label>Service Name</label>
<input type="text" class="form-control" name="service_name" value="<?php echo $service['service_name']; ?>" required>
</div>
<div class="mb-3">
<label>Description</label>
<textarea class="form-control" name="description" required><?php echo $service['description']; ?></textarea>
</div>
<div class="mb-3">
    <label>Rate per Hour (XAF)</label>
    <input type="number" class="form-control" name="rate_per_hour" value="<?php echo isset($service['rate_per_hour']) ? $service['rate_per_hour'] : ''; ?>" required>
</div>

<button class="btn btn-success" name="update">Update</button>
<a href="profile.php" class="btn btn-secondary">Back</a>
</form>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
