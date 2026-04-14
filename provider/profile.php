<?php
include '../config.php';
include '../functions.php';
session_start();

// Check role
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];
$profile = $conn->query("SELECT * FROM users WHERE id=$provider_id")->fetch_assoc();

// Handle profile update
if(isset($_POST['update'])){
    $fullname = $_POST['fullname'];
    $mtn = $_POST['mtn'];
    $orange = $_POST['orange'];

    $profile_pic = $profile['profile_pic'];
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != ''){
        $target = "../assets/images/".basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
        $profile_pic = $target;
    }

    $conn->query("UPDATE users SET fullname='$fullname', mtn_number='$mtn', orange_number='$orange', profile_pic='$profile_pic' WHERE id=$provider_id");
    $profile = $conn->query("SELECT * FROM users WHERE id=$provider_id")->fetch_assoc();
    $success = "Profile updated successfully!";
}

// Fetch provider services
$services = $conn->query("SELECT * FROM services WHERE provider_id=$provider_id");

// Fetch average rating
$ratingData = getProviderAverageRating($provider_id, $conn);
$avgRating = $ratingData['avg'];
$totalReviews = $ratingData['count'];

// Fetch individual reviews
$reviews = $conn->query("SELECT rating, comment FROM reviews WHERE provider_id=$provider_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Provider Profile - CamJobConnect</title>
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
    max-width: 900px;
}
.profile-card, .reviews-card, .services-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0px 5px 25px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.profile-card h2 {
    color: #007bff;
    margin-bottom: 15px;
}
.profile-info p {
    font-size: 1.1rem;
    margin-bottom: 5px;
}
.rating-stars {
    font-size: 1.3rem;
    color: #ffbf00;
}
.review-item {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}
.review-item:last-child {
    border-bottom: none;
}
.btn-edit, .btn-service {
    border-radius: 25px;
    padding: 8px 20px;
    font-weight: 500;
}
.table th {
    background: #007bff;
    color: white;
    text-align: center;
}
.table td {
    text-align: center;
    vertical-align: middle;
}
footer {
    background: #007bff;
    color: white;
    text-align: center;
    padding: 15px 0;
    border-radius: 10px;
}
</style>
</head>
<body>
    <nav>
        <ul type="none">
            <li><a href="dashboard.php">Back</a></li>
        </ul>
    </nav>
<div class="container">

    <!-- Profile Card -->
    <div class="profile-card text-center">
        <h2><?php echo $profile['fullname']; ?></h2>

        <?php if($profile['profile_pic']): ?>
            <img src="../uploads/<?php echo $profile['profile_pic']; ?>" alt="Profile Pic" width="120" class="rounded-circle mb-3">
        <?php endif; ?>

        <div class="profile-info">
            <p><strong>MTN:</strong> <?php echo $profile['mtn_number']; ?> | <strong>Orange:</strong> <?php echo $profile['orange_number']; ?></p>
            <p><strong>Average Rating:</strong> <?php echo $avgRating; ?> ★ (<?php echo $totalReviews; ?> reviews)</p>
        </div>

        <!-- Profile Update Form -->
        <form method="POST" enctype="multipart/form-data" class="mt-3 text-start">
            <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" class="form-control" name="fullname" value="<?php echo $profile['fullname']; ?>" required>
            </div>
            <div class="mb-3">
                <label>MTN Number</label>
                <input type="text" class="form-control" name="mtn" value="<?php echo $profile['mtn_number']; ?>">
            </div>
            <div class="mb-3">
                <label>Orange Number</label>
                <input type="text" class="form-control" name="orange" value="<?php echo $profile['orange_number']; ?>">
            </div>
            <div class="mb-3">
                <label>Profile Picture</label>
                <input type="file" class="form-control" name="profile_pic">
            </div>
            <button class="btn btn-primary btn-edit" name="update">Update Profile</button>
        </form>
    </div>

    <!-- Services Card -->
    <div class="services-card">
        <h3>Your Services</h3>
        <a href="add_service.php" class="btn btn-success btn-service mb-3">Add New Service</a>
        <table class="table table-striped">
            <thead>
                <tr><th>Service</th><th>Description</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php while($s = $services->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $s['service_name']; ?></td>
                    <td><?php echo $s['description']; ?></td>
                    <td>
                        <a href="edit_service.php?id=<?php echo $s['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_service.php?id=<?php echo $s['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Reviews Card -->
    <div class="reviews-card">
        <h3>Client Reviews</h3>
        <?php if($reviews->num_rows == 0): ?>
            <p>No reviews yet. Encourage your clients to leave a review!</p>
        <?php else: ?>
            <?php while($r = $reviews->fetch_assoc()): ?>
                <div class="review-item">
                    <p class="rating-stars">
                        <?php
                        $fullStars = floor($r['rating']);
                        $halfStar = ($r['rating'] - $fullStars) >= 0.5 ? true : false;

                        for($i=0; $i<$fullStars; $i++) echo '★';
                        if($halfStar) echo '⯨'; // can be replaced with actual half star icon
                        for($i=$fullStars+($halfStar?1:0); $i<5; $i++) echo '☆';
                        ?>
                    </p>
                    <p><?php echo htmlspecialchars($r['comment']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</div>

<footer>
    &copy; <?php echo date("Y"); ?> CamJobConnect. All Rights Reserved.
</footer>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
