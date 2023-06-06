<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'includes/db.php';
session_start();

// ob_start(); // Start output buffering

$error = '';

// print_r($_ENV['JAWSDB_MARIA_URL']);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, subscription_level_id, role_id, is_email_validated FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $subscription_level_id, $role_id, $is_email_validated);
    $stmt->fetch();
    // print_r([$user_id, $hashed_password, $subscription_level_id, $role_id]); // Print the fetched data
    $stmt->close();

    if ($user_id && password_verify($password, $hashed_password)) {
        if ($is_email_validated) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['subscription_level_id'] = $subscription_level_id;
            $_SESSION['role_id'] = $role_id;
            header("Location: index.php");
            exit;
        } else {
            $error = "Please validate your email before logging in.";
        }
    } else {
        $error = "Invalid username or password";
    }
}

// $log = ob_get_clean(); // Get the content of the output buffer
// file_put_contents("query_log.txt", $log, FILE_APPEND); // Write the log to a file
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 40px;
            text-align: center;
        }

        .error-message {
            color: red;
        }

        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .login-button {
            background-color: #b8e0c7;
            border-color: #b8e0c7;
            color: #fff;
        }

        .register-button {
            background-color: #849fb1;
            border-color: #849fb1;
            color: #fff;
            margin-left: 10px;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo-image {
            max-width: 200px;
            max-height: 200px;
            margin: 0 auto;
            display: block;
        }
    </style>
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-form">
                <div class="logo-container">
                    <img src="../img/vulcan-salute.png" alt="Logo" class="img-fluid logo-image">
                </div>
                <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
                <form name="loginForm" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="text-center">
                        <input type="submit" name="login" value="Login" class="btn btn-primary login-button">
                        <a href="register.php" class="btn btn-secondary register-button">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

</html>