<?php
session_start();
require_once 'includes/db.php';

if (isset($_GET['token'])) {
    $validation_token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE confirmation_code = ?");
    $stmt->bind_param("s", $validation_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // Token found
        // Update email_validated to 1 (true) and clear the validation_token
        $stmt2 = $conn->prepare("UPDATE users SET is_email_validated = 1, confirmation_code = NULL WHERE confirmation_code = ?");
        $stmt2->bind_param("s", $validation_token);
        $stmt2->execute();
        $stmt2->close();

        echo "Your email has been validated successfully!";
    } else {
        echo "Invalid validation token.";
    }

    $stmt->close();
} else {
    echo "No token provided.";
}
?>