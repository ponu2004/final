<?php


// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_name])) {
        $_SESSION['cart'][$product_name]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_name] = [
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => $quantity
        ];
    }

    // Show an alert message using JavaScript
    echo "<script>
        alert('Product added to cart successfully!');
        window.location.href = 'homepage.php?page=place_order';
    </script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="placeorder.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</head>
<body>

    <div class="container">
        <div class="sidebar">
        <h1>Dashboard</h1>
            <a href="?page=home"><i class="fas fa-home"></i> Home</a>
            <a href="?page=view_orders"><i class="fas fa-box"></i> View Orders</a>
            <a href="?page=place_order"><i class="fas fa-cart-plus"></i> Place Order</a>
            <a href="?page=profile"><i class="fas fa-user"></i> Profile</a>
            <a href="?page=feedback"><i class="fas fa-comment"></i> Feedback</a>
            
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        

        <div class="content">
        <div class="heading">Place order</div>
            <div class="top-bar">
                <input type="text" id="product-search" placeholder="Search products...">
                <a href="cart.php"><span class="cart">🛒</span></a>
            </div>

            <div class="product-grid">
                <?php
                $products = [
                    
                    //["Poultry Feed Additive", "images/farm.png", 450],
                    ["Poultry Feed Additive", "images/i1.png", 450],
                    ["Poultry Feed Additive", "images/i2.png", 450],
                    ["Bird Pads", "images/i3.png", 450],
                    ["water drinker", "images/p12.png",  600],
                    ["Container", "images/p13.png", 12000],
                    ["Liquid calcium solution", "images/p1.png", 800],
                    ["Egg incubator", "images/egg.jpg", 3500],
                    ["Oyster Shell Grit (Calcium Source for Birds)", "images/i4.png", 750],
                    ["Omini solution ", "images/p4.png", 1500],
                    ["Omini solution", "images/p5.png", 500],
                    ["water Drinker", "images/p6.png", 2500],
                    ["Bird pads", "images/i3.png", 450],
                    ["Oyster Shell Grit (Calcium Source for Birds)", "images/i4.png", 900],
                    ["Organic feed", "images/i5.png", 600],
                    ["", "images/i6.png", 12000],
                    ["Farm Disinfectant Solution", "images/i7.png", 800],
                    ["Hand Feeding Mix for Birds", "images/i8.png", 3500],
                    ["Farm Disinfectant Solution", "images/i9.png", 750],
                    ["Disinfected Solution ", "images/i10.png", 1500],
                    ["Poultry Supplement (Powdered)", "images/i11.png", 500],
                    ["Poultry Supplement solution liquid", "images/i13.png", 2500],
                    ["Oganic feed", "images/org.jpg", 450],
                    ["Liquid Poultry Vitamin Supplement", "images/p1.png", 900],
                    ["Chicken Feed", "images/p4.png", 600],
                    ["Organic feed", "images/p5.png", 12000],
                    [" Automatic Dinker", "images/p6.png", 800],
                    ["Tray", "images/p7.png", 3500],
                    ["Automatic Poultry Drinker (Nipple Drinkers)", "images/p8.png", 750],
                    ["Calcium orgami solution", "images/p9.png", 1500],
                    ["Farm feed", "images/p10.png", 500],
                    ["Poultry Heater", "images/p11.png", 2500],
                    ["Hand Feeder", "images/p12.png", 450],
                    ["Livestock Feed Concentrate", "images/p13.png", 900],
                    ["Livestock Feed Concentrate", "images/i2.png", 900]
                    
                ];
                foreach ($products as $product) {
                    echo "<div class='product-card'>";
                    echo "<img src='{$product[1]}' alt='{$product[0]}' onerror=\"this.onerror=null; this.src='images/default.jpg';\">";
                    echo "<h3>{$product[0]}</h3>";
                    echo "<p class='price'>₹{$product[2]}</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='product_name' value='{$product[0]}'>";
                    echo "<input type='hidden' name='product_price' value='{$product[2]}'>";
                    echo "<input type='hidden' name='product_image' value='{$product[1]}'>";
                    echo "<input type='number' name='quantity' value='1' min='1'>";
                    echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>