<?php
session_start();
include '../config.php';
if($_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];

if(isset($_POST['add'])){
    $name = $_POST['service_name'];
    $desc = $_POST['description'];
    $rate = $_POST['rate_per_hour'];
    $stmt = $conn->prepare("INSERT INTO services(provider_id,service_name,description,rate_per_hour) VALUES(?,?,?,?)");
    $stmt->bind_param("issi",$provider_id,$name,$desc,$rate);
    $stmt->execute();
    $success = "Service added successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Service - CamJobConnect</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<style>
       /* Full-page background */
        body {
            background: url('../assets/images/services.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        /* Back button at top-left */
        

        /* Form card styling */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 50px rgba(0,0,0,0.25);
        }

        .form-card h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-weight: 600;
        }

        form label {
            font-weight: 500;
            margin-top: 15px;
            display: block;
        }

        form .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            width: 100%; /* Ensure all fields stretch equally */
            box-sizing: border-box;
        }

        .btn-add {
            width: 100%;
            background: #28a745;
            color: #fff;
            font-weight: 600;
            border-radius: 25px;
            padding: 12px 0;
            font-size: 1.1rem;
            border: none;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: #218838;
        }

        .alert-success {
            text-align: center;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .btn-back{
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;

        }
    </style>
</style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Add New Service</h2>

        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <form method="POST">
            <label>Service Name</label>
            <input type="text" class="form-control" name="service_name" placeholder="Enter service name" required>
<br>
            <label>Description</label>
            <textarea class="form-control" name="description" placeholder="Describe your service" rows="4" required></textarea>
<br>
            <label>Rate per Hour (XAF)</label>
            <input type="number" class="form-control" name="rate_per_hour" placeholder="Enter rate per hour" step="0.1" required>

            <button class="btn-add" name="add">Add Service</button>
        </form>
<br>
        <div><a href="profile.php" class="btn-back">Back to Profile</a></div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
