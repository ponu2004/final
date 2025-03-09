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

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Fetch orders: Customers see their own, Admin sees all
if ($role === "admin") {
    $query = "SELECT o.order_id, o.username, o.address, o.payment_method, o.status, o.order_date, o.expected_delivery_date, 
                     oi.product_name, oi.quantity, oi.price
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              ORDER BY o.order_date DESC";
} else {
    $query = "SELECT o.order_id, o.address, o.payment_method, o.status, o.order_date, o.expected_delivery_date, 
                     oi.product_name, oi.quantity, oi.price
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              WHERE o.username = ?
              ORDER BY o.order_date DESC";
}

$stmt = $conn->prepare($query);

if ($role !== "admin") {
    $stmt->bind_param("s", $username);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="vieworder.css">
</head>
<body>

    <h2><?php echo ($role === "admin") ? "All Orders (Admin View)" : "My Orders"; ?></h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <?php if ($role === "admin") echo "<th>Username</th>"; ?>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (₹)</th>
                <th>Address</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Expected Delivery</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <?php if ($role === "admin") echo "<td>" . htmlspecialchars($row['username']) . "</td>"; ?>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['expected_delivery_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

</body>
</html>
