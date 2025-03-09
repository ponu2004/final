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
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $selected_role = $_POST['role']; // Get role selected during login

    if (empty($username) || empty($password) || empty($selected_role)) {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Secure query using prepared statements
        $sql = "SELECT * FROM form WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $roles = explode(",", $user['role']); // Convert stored roles to an array

            // Compare plain text password
            if ($password === $user['password']) { 
                if (in_array($selected_role, $roles)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $selected_role;

                    if ($selected_role == "Admin") {
                        header("Location: home.php");
                    } else {
                        header("Location: homepage.php");
                    }
                    exit;
                } else {
                    echo "<script>alert('Invalid role selection. You are not registered as $selected_role.');</script>";
                }
            } else {
                echo "<script>alert('Invalid username or password.');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="style1.css"> 
</head>
<body>
    <form method="POST" autocomplete="off">
        <h1>Login</h1>
        <div class="form-container">
            <div>
                <input type="text" name="username" id="username" placeholder="Username" required /><br><br>
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Password" required /><br><br>
            </div>

            <div class="role-selection" style="display: flex; justify-content: center; gap: 20px; margin-top: 10px;">
                <label>
                    <input type="radio" name="role" value="Admin" required> Admin
                </label>
                <label>
                    <input type="radio" name="role" value="Customer" required> Customer
                </label>
            </div>

            <br>
            <input type="submit" name="SignIn" id="SignIn" value="Sign In"><br><br>
            <p>Not a member? <a href="register.php">SignUp</a></p>
            <p><a href="forget_password.php">Forgot password?</a></p>
        </div>
    </form>
</body>
</html>
