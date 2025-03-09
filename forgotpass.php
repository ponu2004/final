<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Establish the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    if (!empty($email)) {
        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT * FROM form WHERE LOWER(email) = LOWER('$email')";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $reset_link = "http://yourdomain.com/reset_password.php?email=$email";
            $subject = "Reset Your Password";
            $message = "Click the following link to reset your password: $reset_link";
            $headers = "From: noreply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "<script>alert('Password reset link sent to your email.');</script>";
            } else {
                echo "<script>alert('Failed to send email.');</script>";
            }
        } else {
            echo "<script>alert('Email not found.');</script>";
        }
    } else {
        echo "<script>alert('Please enter your email.');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .forgot-password-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .message a {
            color: #007BFF;
            text-decoration: none;
        }

        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="forgot-password-container">
        <h1>Forgot Password</h1>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Submit">
        </form>
        <div class="message">
            <p>Remember your password? <a href="login.php">Login</a></p>
        </div>
    </div>

</body>
</html>