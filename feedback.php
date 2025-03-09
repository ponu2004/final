<?php
//session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}





// Handle Feedback Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $feedback = htmlspecialchars($_POST['feedback'], ENT_QUOTES, 'UTF-8');
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    $stmt = $conn->prepare("INSERT INTO feedback (username, message, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $feedback, $rating);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Feedback submitted successfully!";
    } else {
        $_SESSION['error'] = "Error submitting feedback: " . $conn->error;
    }
    $stmt->close();

    // Redirect to avoid resubmission on refresh
    header("Location: homepage.php?page=feedback");
    exit;
}

//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="fedpro.css"> <!-- Link to your CSS file -->
</head>
<body>

<div class="content">
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

        <?php
        if (!empty($_SESSION['message'])) {
            echo "<p class='message'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']); // Clear after displaying
        }
        if (!empty($_SESSION['error'])) {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']); // Clear after displaying
        }
        ?>
    </div>
</div>

</body>
</html>
