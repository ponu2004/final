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

// Handle Forget Password Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["proceed"])) {
    $email = $conn->real_escape_string($_POST["email"]);
    $query = "SELECT * FROM form WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION["reset_email"] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forstyle.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST">
            <label>Enter Your Email Address:</label>
            <input type="email" name="email" required>
            <button type="submit" name="proceed">Proceed</button>
        </form>
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
</body>
</html>
