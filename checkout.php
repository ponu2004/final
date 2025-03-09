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

// Ensure user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
   echo "<script>alert('Access denied! Please login.'); window.location.href = 'login.php';</script>";
   exit();
}

// Restrict access to customers only
if ($_SESSION['role'] == 'customer') {
    echo "<script>alert('Access denied!'); window.location.href = 'checkout.php';</script>";
    exit();
}

// Handle Buy Now request
if (isset($_POST['buy_now'])) {
    $_SESSION['checkout_product'] = [
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'quantity' => $_POST['quantity'],
        'image' => $_POST['image']
    ];
}

// Redirect if no product is selected
if (!isset($_SESSION['checkout_product'])) {
    echo "<script>alert('No product selected!'); window.location.href = 'cart.php';</script>";
    exit();
}

// Retrieve stored product details
$product = $_SESSION['checkout_product'];
$product_name = $product['product_name'];
$product_price = $product['product_price'];
$quantity = $product['quantity'];
$image = $product['image'];

// Handle Order Submission
if (isset($_POST['confirm_order'])) {
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $username = $_SESSION['username'];

    if ($payment_method === "Online Payment") {
        $_SESSION['checkout_product']['address'] = $address;
        $_SESSION['checkout_product']['payment_method'] = $payment_method;
        echo "<script>window.location.href = 'onlinepayment.php';</script>";
        exit();
    }

    // Insert order into database
    $insertOrder = $conn->prepare("INSERT INTO orders (username, address, payment_method, status, expected_delivery_date) VALUES (?, ?, ?, 'Processing', DATE_ADD(CURDATE(), INTERVAL 3 DAY))");
    $insertOrder->bind_param("sss", $username, $address, $payment_method);
    $insertOrder->execute();
    $order_id = $conn->insert_id;

    // Insert product details into order_items
    $insertItem = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
    $insertItem->bind_param("isid", $order_id, $product_name, $quantity, $product_price);
    $insertItem->execute();

    // Clear session after order is placed
    unset($_SESSION['checkout_product']);

    echo "<script>alert('Order Placed Successfully!'); window.location.href = 'homepage.php?page=view_order';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>

    <h2>Checkout</h2>

    <div class="product">
        <img src="<?php echo htmlspecialchars($image); ?>" alt="Product Image" width="100">
        <p>Product: <?php echo htmlspecialchars($product_name); ?></p>
        <p>Price: ₹<?php echo number_format($product_price, 2); ?></p>
        <p>Quantity: <?php echo $quantity; ?></p>
    </div>

    <form method="post">
        <label>Address:</label>
        <textarea name="address" required></textarea><br>

        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Online Payment">Online Payment</option>
        </select><br>

        <button type="submit" name="confirm_order">Confirm Order</button>
    </form>

</body>
</html>
