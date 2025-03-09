<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Collect form data
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmpassword = trim($_POST["confirmpassword"]);
    $roles = isset($_POST["role"]) ? implode(",", $_POST["role"]) : "";

    // Validation
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmpassword) || empty($roles)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please enter a valid email.');</script>";
    } elseif ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } elseif (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[\W]/', $password)) {
        echo "<script>alert('Password must be at least 6 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
    } else {
        // Check if username or email already exists
        $checkStmt = $conn->prepare("SELECT * FROM form WHERE username=? OR email=?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username or Email already exists. Please choose a different one.');</script>";
        } else {
            // Store password as plain text (NOT SECURE)
            $stmt = $conn->prepare("INSERT INTO form (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $username, $email, $password, $roles);

            if ($stmt->execute()) {
                echo "<script>alert('Successfully registered as $roles! You can now log in.'); window.location.href='login.php';</script>";
                exit;
            } else {
                echo "<script>alert('Registration failed. Please try again.');</script>";
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Register</h1>
        
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="input-container">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
        </div>
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="role-selection" style="display: flex; gap: 20px;">
            <label>
                <input type="checkbox" name="role[]" value="Admin"> Admin
            </label>
            <label>
                <input type="checkbox" name="role[]" value="Customer"> Customer
            </label>
        </div>

        <input type="submit" name="submit" id="submit" value="Register"><br>
        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </form>
</body>
</html>
