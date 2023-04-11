<?php
session_start();
require_once 'includes/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $subscription_level_id = 1; // Default subscription level (free)

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, subscription_level_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hashed_password, $subscription_level_id);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
    function validateForm() {
        const username = document.forms["registerForm"]["username"].value.trim();
        const password = document.forms["registerForm"]["password"].value.trim();

        if (username === "" || password === "") {
            alert("Username and Password must be filled out");
            return false;
        }
    }
    </script>
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form name="registerForm" method="post" onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>