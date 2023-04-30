<?php
require_once 'includes/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $username = "admin";
// $password = "admin";
// $subscription_level_id = 1;

// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// $stmt = $conn->prepare("INSERT INTO users (username, password, subscription_level_id) VALUES (?, ?, ?)");
// $stmt->bind_param("ssi", $username, $hashed_password, $subscription_level_id);
// $stmt->execute();
// $stmt->close();


// $sql = "
// CREATE TRIGGER delete_author AFTER DELETE ON articles
// FOR EACH ROW
// BEGIN
//   IF NOT EXISTS (SELECT id FROM articles WHERE author_id = OLD.author_id) THEN
//     DELETE FROM authors WHERE id = OLD.author_id;
//   END IF;
// END;
// ";

$name = 'Jane Yolau';
$bio = 'An earnest writer';
$profile_image_url = 'https://example.com/profile.jpg';

$stmt = $conn->prepare("INSERT INTO authors (name, bio, profile_image_url) VALUES (?,?,?)");
$stmt->bind_param("sss", $name, $bio, $profile_image_url);
$stmt->execute();
$stmt->close();


//$conn->query($sql);

echo "Author inserted successfully";


// phpinfo();




?>