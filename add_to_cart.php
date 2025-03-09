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

// Get the product ID from the request
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['product_id'])) {
    echo json_encode(["error" => "Product ID missing"]);
    exit;
}

$product_id = $data['product_id'];

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Prepare product details for the cart
    $cart_item = [
        "product_id"   => $product["id"],
        "product_name" => $product["name"], // Ensure the column name is correct
        "price"        => $product["price"],
        "quantity"     => 1
    ];

    // Initialize cart if not set
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Check if the product is already in the cart
    $product_found = false;
    foreach ($_SESSION["cart"] as &$item) {
        if ($item["product_id"] == $product_id) {
            $item["quantity"]++; // Increase quantity
            $product_found = true;
            break;
        }
    }

    // If not found, add as new item
    if (!$product_found) {
        $_SESSION["cart"][] = $cart_item;
    }

    echo json_encode(["success" => "Product added to cart"]);
} else {
    echo json_encode(["error" => "Product not found"]);
}

$stmt->close();
$conn->close();
?>
