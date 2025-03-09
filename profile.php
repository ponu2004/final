<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = preg_replace("/[^0-9]/", "", $_POST['phone']);
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO cust (name, email, phone, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    
    if ($stmt->execute()) {
        $message = "Profile saved successfully!";
    } else {
        $message = "Error saving profile: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="fedpro.css"> <!-- Link to your CSS file -->
</head>
<body>

<div class="content">
    <h2>Customer Profile</h2>
    <div class="form-container">
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Address:</label>
            <textarea name="address" required></textarea>

            <button type="submit">Save Profile</button>
        </form>

        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
    </div>
</div>

</body>
</html>
