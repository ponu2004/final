<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email session exists
if (!isset($_SESSION["reset_email"])) {
    header("Location: forget_password.php");
    exit();
}

$email = $_SESSION["reset_email"];

// Handle password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    $new_password = $conn->real_escape_string($_POST["new_password"]);
    $confirm_password = $conn->real_escape_string($_POST["confirm_password"]);

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Update password in database
        $update_query = "UPDATE form SET password='$new_password' WHERE email='$email'";
        if ($conn->query($update_query)) {
            session_destroy();
            echo "<script>alert('Password reset successfully!'); window.location='login.php';</script>";
        } else {
            $error = "Failed to reset password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forstyle.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST">
            <label>New Password:</label>
            <input type="password" name="new_password" required>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            <button type="submit" name="reset_password">Reset Password</button>
        </form>
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
</body>
</html>
