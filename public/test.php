<?php
require_once 'includes/db.php';

$username = "admin";
$password = "admin";
$subscription_level_id = 1;

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password, subscription_level_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $username, $hashed_password, $subscription_level_id);
$stmt->execute();
$stmt->close();

echo "User inserted successfully";
?>