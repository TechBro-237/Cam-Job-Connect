<?php
include '../config.php';
session_start();
if($_SESSION['role'] != 'admin') die("Access denied");

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<h2>All Users</h2>
<table border="1px solid black" cellpadding="10" cellspacing="0">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
<?php while($u = $users->fetch_assoc()): ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo $u['fullname']; ?></td>
<td><?php echo $u['email']; ?></td>
<td><?php echo $u['role']; ?></td>
<td>
<a href="delete_user.php?id=<?php echo $u['id']; ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php">Back to Dashboard</a>
