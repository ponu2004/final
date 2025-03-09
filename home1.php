<?php
session_start();

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch products from the database
$products = $conn->query("SELECT * FROM products");

// Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    $cart_item = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'price' => $price,
        'quantity' => 1
    ];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $cart_item;
    
    header("Location: ?page=place_order");
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT username, email, phone, address FROM cust WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$cust = $result->fetch_assoc();
$stmt->close();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_profile'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = preg_replace("/[^0-9]/", "", $_POST['phone']); 
        $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("UPDATE cust SET email=?, phone=?, address=? WHERE username=?");
        $stmt->bind_param("ssss", $email, $phone, $address, $username);
        
        if ($stmt->execute()) {
            $message = "Profile updated successfully!";
        } else {
            $error = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    }

    if (isset($_POST['submit_feedback'])) {
        $feedback = htmlspecialchars($_POST['feedback'], ENT_QUOTES, 'UTF-8');
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $stmt = $conn->prepare("INSERT INTO feedback (username, message, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $feedback, $rating);

        if ($stmt->execute()) {
            $message = "Feedback submitted successfully!";
        } else {
            $error = "Error submitting feedback: " . $conn->error;
        }
        $stmt->close();
    }
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background:lightyellow;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background:rgb(26, 26, 26);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: #ffcc00;
            color: black;
        }
        .content {
            flex: 1;
            margin-left: 260px;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .form-container {
            background: white;
            box-shadow:yellow;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 100);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #ffcc00;
            color: black;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background: #ff9900;
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 5px;
        }

        .star-rating input {
            display: none; /* Hide the radio buttons */
        }

        .star-rating label {
            font-size: 30px;
            cursor: pointer;
            color: #ccc; /* Default gray color */
            transition: color 0.3s;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }

        .message, .error {
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="?page=home"><i class="fas fa-home"></i> Home</a>
        <a href="?page=view_orders"><i class="fas fa-box"></i> View Orders</a>
        <a href="?page=place_order"><i class="fas fa-cart-plus"></i> Place Order</a>
        <a href="?page=profile"><i class="fas fa-user"></i> Profile</a>
        <a href="?page=feedback"><i class="fas fa-comment"></i> Feedback</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div class="content">
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        
        <?php if ($page == 'place_order'): ?>
            <h2>Place Order</h2>
            <div class="form-container">
                <form method="post">
                    <div class="product-list">
                        <?php 
                        // Set a counter to limit products to 30 items
                        $counter = 0;
                        while ($row = $products->fetch_assoc() && $counter < 30): 
                            $counter++;
                        ?>
                            <div class="product-item">
                                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['product_name']; ?>" style="width: 100px; height: 100px;">
                                <h3><?php echo $row['product_name']; ?></h3>
                                <p>₹<?php echo $row['price']; ?></p>
                                <button type="submit" name="add_to_cart" value="<?php echo $row['id']; ?>">Add to Cart</button>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($page == 'profile'): ?>
            <h2>Customer Profile</h2>
            <div class="form-container">
                <form method="post">
                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $cust['username'] ?? ''; ?>" required>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo $cust['email'] ?? ''; ?>" required>
                    <label>Phone:</label>
                    <input type="text" name="phone" value="<?php echo $cust['phone'] ?? ''; ?>" required>
                    <label>Address:</label>
                    <textarea name="address" required><?php echo $cust['address'] ?? ''; ?></textarea>
                    <button type="submit" name="save_profile">Save Changes</button>
                </form>
            </div>
        <?php elseif ($page == 'feedback'): ?>
            <h2>Feedback</h2>
            <div class="form-container">
                <form method="post">
                <label>Rate Us:</label>
                <div class="star-rating">
                    <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                    <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                    <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                    <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                    <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                </div>
                    <label>Your Feedback:</label>
                    <textarea name="feedback" required></textarea>
                    <button type="submit" name="submit_feedback">Submit Feedback</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
