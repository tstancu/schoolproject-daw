<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'includes/db.php';
require_once '../vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// $classes = get_declared_classes();

// echo '<pre>';
// print_r($classes);
// echo '</pre>';

// print_r("we are here");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function generate_token($length = 64) {
    return bin2hex(random_bytes($length / 2));
}

if (isset($_POST['register'])) {
    print_r("we are in first if");
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $subscription_level_id = 1; // Default subscription level (free)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $confirmation_code = generate_token();

    var_dump($confirmation_code);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, subscription_level_id, confirmation_code) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $username, $email, $hashed_password, $subscription_level_id, $confirmation_code);
    echo "Before printing the stmt variable"; // Debugging code
    
    if ($stmt !== false) {
        // prepared statement is successful
        echo "stmt is not false";
      } else {
        // prepared statement failed
        echo "Prepare statement error: " . $conn->error;
      }

    

    if ($stmt->execute()) {
        // send validation email

        print_r("we are second if");
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            // PHPMailer class is loaded
            $mail = new PHPMailer(true);
            print_r("we are third if");
          } else {
            // PHPMailer class is not loaded
            print_r("we are forth if");
            error_log('PHPMailer class is not loaded');
          }
        // $mail = new PHPMailer(true);

        try {
            // configure mailer settings (SMTP, email, password, etc.)
            $mail->isSMTP();
            $mail->Host = 'your_host';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email';
            $mail->Password = 'your_password';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // set email content
            $mail->setFrom('your_email', 'Your Name');
            $mail->addAddress($email, $username);
            $mail->isHTML(true);
            $mail->Subject = 'Email validation';
            $mail->Body    = 'Please click the following link to validate your email: http://your_domain/validate_email.php?token=' . $validation_token;

            // send email
            $mail->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

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
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
    function validateForm() {
        const username = document.forms["registerForm"]["username"].value.trim();
        const password = document.forms["registerForm"]["password"].value.trim();
        const email = document.forms["registerForm"]["email"].value.trim();

        if (username === "" || password === "" || email === "") {
            alert("Username, Password and Email fields must be filled out");
            return false;
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form name="registerForm" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>