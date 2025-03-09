<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the page parameter (Default: Home)
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="stylefordashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</head>
<body>

    <div class="container">
        <!-- Sidebar / Dashboard Menu -->
        <div class="sidebar">
            <h1>Dashboard</h1>
            <a href="homepage.php?page=home"><i class="fas fa-home"></i> Home</a>
            <a href="homepage.php?page=view_order"><i class="fas fa-box"></i> View Orders</a>
            <a href="homepage.php?page=place_order"><i class="fas fa-cart-plus"></i> Place Order</a>
            <a href="homepage.php?page=profile"><i class="fas fa-user"></i> Profile</a>
            <a href="homepage.php?page=feedback"><i class="fas fa-comment"></i> Feedback</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <!-- Content Area -->
        <div class="content">
            <?php
            if ($page == 'home') {
                include 'homesupp.php';
            } 
            if ($page == 'view_order') {
                include 'vieworder.php';
            } 
            if($page == 'place_order'){
                include 'place_order.php';
            }
            if($page == 'profile'){
                include 'profile.php';
            }
            if($page == 'feedback'){
                include 'feedback.php';
            }
            ?>
        </div>
    </div>

</body>
</html>
