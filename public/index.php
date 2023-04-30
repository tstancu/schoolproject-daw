<?php
require_once 'includes/check-login.php';
require_once 'includes/db.php';
require_once 'includes/utils.php';
require_once 'includes/queries.php';

ob_start(); // Start output buffering

$error = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Get the user's subscription_level_id
$user_subscription_level_id = getSubscriptionLevelById($_SESSION['user_id']);

// Update the subscription_level_id in the session
$_SESSION['subscription_level_id'] = $user_subscription_level_id;

$sql = "SELECT * FROM articles WHERE subscription_level_id <= ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
print_r([$_SESSION]);
$stmt->bind_param("i", $_SESSION['subscription_level_id']);
$stmt->execute();
$result = $stmt->get_result();
$content = $result->fetch_all(MYSQLI_ASSOC);
// print_r([$content]);
$stmt->close();

$log = ob_get_clean(); // Get the content of the output buffer
file_put_contents("query_log.txt", $log, FILE_APPEND); // Write the log to a file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Online Magazine</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


    <div class="container mt-5">
        <div class="row">
            <?php
            // Replace this array with the actual data from your database
            $articles = $content;

            foreach ($articles as $article) {
                include 'includes/article-card.php';
            }
            ?>
        </div>
    </div>


    <!-- Your magazine content will go here -->

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>