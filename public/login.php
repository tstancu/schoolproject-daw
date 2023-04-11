<?php
require_once 'includes/db.php';
session_start();

ob_start(); // Start output buffering

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, subscription_level_id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $subscription_level_id);
    $stmt->fetch();
    print_r([$user_id, $hashed_password, $subscription_level_id]); // Print the fetched data
    $stmt->close();
    print_r("am ajuns aici 1");

    if ($user_id && password_verify($password, $hashed_password)) {
        print_r("am ajuns aici 2");
        $_SESSION['user_id'] = $user_id;
        $_SESSION['subscription_level_id'] = $subscription_level_id;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}

$log = ob_get_clean(); // Get the content of the output buffer
file_put_contents("query_log.txt", $log, FILE_APPEND); // Write the log to a file
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script>
    function validateForm() {
        const username = document.forms["loginForm"]["username"].value.trim();
        const password = document.forms["loginForm"]["password"].value.trim();

        if (username === "" || password === "") {
            alert("Username and Password must be filled out");
            return false;
        }
    }
    </script>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form name="loginForm" method="post" onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>