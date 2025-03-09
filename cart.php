<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cartcss.css">
</head>
<body>

    <h2>Your Cart</h2>

    <div class="cart-items">
    <?php if (!empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $product_name => $item): ?>
            <div class="cart-item">
                <img src="<?php echo !empty($item['image']) ? htmlspecialchars($item['image']) : 'images/pic.jpg'; ?>" 
                     alt="<?php echo htmlspecialchars($product_name); ?>" 
                     width="100">
                     
                <div class="cart-item-details">
                    <p><?php echo htmlspecialchars($product_name); ?></p>
                    <p>Price: ₹<?php echo number_format($item['price'], 2); ?></p>
                    <p>Quantity: <?php echo intval($item['quantity']); ?></p>
                    
                    <!-- Buy Now Form -->
                    <form action="checkout.php" method="post">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
                        <input type="hidden" name="product_price" value="<?php echo floatval($item['price']); ?>">
                        <input type="hidden" name="quantity" value="<?php echo intval($item['quantity']); ?>">
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($item['image']); ?>">
                        <button type="submit" name="buy_now">Buy Now</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    </div>

</body>
</html>
