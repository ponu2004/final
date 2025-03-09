<?php
require('fpdf/fpdf.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order details
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Invalid Order ID");
}

// Fetch ordered items
$sql = "SELECT * FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

// Use Helvetica instead of Arial
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(40, 10, 'Order Receipt');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);
$pdf->Cell(100, 10, "Order ID: " . $order['order_id'], 0, 1);
$pdf->Cell(100, 10, "Customer Name: " . $order['username'], 0, 1);
$pdf->Cell(100, 10, "Address: " . $order['address'], 0, 1);
$pdf->Cell(100, 10, "Payment Method: " . $order['payment_method'], 0, 1);
$pdf->Cell(100, 10, "Order Date: " . $order['order_date'], 0, 1);
$pdf->Cell(100, 10, "Expected Delivery: " . $order['expected_delivery_date'], 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, "Product", 1);
$pdf->Cell(40, 10, "Quantity", 1);
$pdf->Cell(40, 10, "Price (₹)", 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$total = 0;
while ($item = $order_items->fetch_assoc()) {
    $pdf->Cell(90, 10, $item['product_name'], 1);
    $pdf->Cell(40, 10, $item['quantity'], 1);
    $pdf->Cell(40, 10, number_format($item['price'], 2), 1);
    $pdf->Ln();
    $total += $item['price'] * $item['quantity'];
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 10, "Total Amount (₹)", 1);
$pdf->Cell(40, 10, number_format($total, 2), 1);
$pdf->Ln(10);

$pdf->Cell(190, 10, "Thank you for your order!", 0, 1, 'C');

// Force Download
$pdf->Output("D", "Receipt_Order_" . $order_id . ".pdf");
?>
