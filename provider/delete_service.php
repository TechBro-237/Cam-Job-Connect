<?php
session_start();
include '../config.php';
if($_SESSION['role'] != 'provider') die("Access denied");

$provider_id = $_SESSION['user_id'];
$service_id = $_GET['id'];
$conn->query("DELETE FROM services WHERE id=$service_id AND provider_id=$provider_id");
header("Location: profile.php");
exit;
