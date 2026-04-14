<?php
session_start();
include '../config.php';
include '../functions.php';
if($_SESSION['role'] != 'client') die("Access denied");

$client_id = $_SESSION['user_id'];

// Get provider info
if(!isset($_GET['provider_id'])){
    die("Provider not specified.");
}
$provider_id = $_GET['provider_id'];
$provider = $conn->query("SELECT * FROM users WHERE id=$provider_id AND role='provider'")->fetch_assoc();

if(!$provider) die("Provider not found.");

// Handle review submission
if(isset($_POST['submit_review'])){
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);
    
    // Insert review
    $conn->query("INSERT INTO reviews(client_id, provider_id, rating, comment) VALUES($client_id, $provider_id, $rating, '$comment')");
    $success = "Review submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Provider - CamJobConnect</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
            max-width: 700px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 30px;
            background: #fff;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .provider-info {
            text-align: center;
            margin-bottom: 25px;
        }

        .provider-info h4 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .rating-stars {
            color: #ffbf00;
            font-size: 1.2rem;
        }

        form label {
            font-weight: 500;
            margin-top: 15px;
        }

        form .form-control, form select {
            border-radius: 10px;
            padding: 10px;
            width: 100%;
        }

        .btn-submit {
            background: #28a745;
            color: #fff;
            font-weight: 500;
            border-radius: 25px;
            padding: 10px 25px;
            margin-top: 20px;
            transition: 0.3s;
            border: none;
        }

        .btn-submit:hover {
            background: #218838;
        }

        .alert-success {
            text-align: center;
            font-weight: 500;
            margin-bottom: 15px;
        }

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
<div class="container">
    <div class="card">
        <h2>Leave a Review for <?php echo $provider['fullname']; ?></h2>

        <div class="provider-info">
            <p class="rating-stars">
                ★ ★ ★ ★ ★
            </p>
            <p><strong>MTN:</strong> <?php echo $provider['mtn_number']; ?> | <strong>Orange:</strong> <?php echo $provider['orange_number']; ?></p>
        </div>

        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <form method="POST">
            <label for="rating">Rating (1-5 stars)</label>
            <select name="rating" class="form-select" required>
                <option value="">Select Rating</option>
                <option value="1">1 ★</option>
                <option value="2">2 ★★</option>
                <option value="3">3 ★★★</option>
                <option value="4">4 ★★★★</option>
                <option value="5">5 ★★★★★</option>
            </select>

            <label for="comment">Comment</label>
            <textarea name="comment" class="form-control" rows="5" placeholder="Write your review here..." required></textarea>

            <div class="text-center">
                <button type="submit" name="submit_review" class="btn-submit">Submit Review</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> CamJobConnect. All Rights Reserved.
</footer>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
