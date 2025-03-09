<?php
session_start();
require('fpdf/fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['order_details'])) {
    die("Error: No order details found.");
}

$order = $_SESSION['order_details'];
$username = $order['username'];
$address = $order['address'];
$product_name = $order['product_name'];
$price = $order['price'];
$quantity = $order['quantity'];

if (isset($_POST['confirm_payment'])) {
    // Insert Order into Database
    $stmt = $conn->prepare("INSERT INTO orders (username, address, payment_method, status, order_date, expected_delivery_date) VALUES (?, ?, 'Online Payment', 'Paid', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY))");
    $stmt->bind_param("ss", $username, $address);
    $stmt->execute();
    $order_id = $conn->insert_id;  // Get last inserted order ID

    // Insert Product into Order Items
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt_item->bind_param("isid", $order_id, $product_name, $quantity, $price);
    $stmt_item->execute();

    // Generate PDF Receipt
    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(190, 10, 'Order Receipt', 1, 1, 'C');
            $this->Ln(10);
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(40, 10, "Customer Name: " . htmlspecialchars($username));
    $pdf->Ln();
    $pdf->Cell(40, 10, "Address: " . htmlspecialchars($address));
    $pdf->Ln();
    $pdf->Cell(40, 10, "Product: " . htmlspecialchars($product_name));
    $pdf->Ln();
    $pdf->Cell(40, 10, "Quantity: " . intval($quantity));
    $pdf->Ln();
    $pdf->Cell(40, 10, "Price: ₹" . number_format($price, 2));
    $pdf->Ln();
    $pdf->Cell(40, 10, "Payment Method: Online Payment");
    $pdf->Ln(20);
    $pdf->Cell(0, 10, "Thank you for your order!", 0, 1, 'C');

    $pdf->Output('D', 'receipt.pdf');

    // Remove session order details after payment
    unset($_SESSION['order_details']);

    echo "<script>alert('Payment successful! Receipt downloaded.'); window.location='vieworder.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment</title>
    <link rel="stylesheet" href="onlinepayment.css">
</head>
<body>

    <h2>Complete Your Payment</h2>
    <p>Scan the QR code below or use the UPI ID to make your payment.</p>

    <div class="payment-container">
        <img src="images/qr.jpeg" alt="QR Code" width="200">
        <p><strong>UPI ID:</strong> sangleprajakta30@okaxis</p>
    </div>

    <form method="post">
        <button type="submit" name="confirm_payment">Confirm Payment</button>
    </form>

</body>
</html>
