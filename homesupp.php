<?php
//require_once("homepage.php"); // Ensure session and database connection

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poultry Supplies</title>
    <link rel="stylesheet" href="homesupp.css">
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <h1>Welcome to Poultry Supplies</h1>
    <p>Your trusted partner for high-quality poultry farming essentials.</p>
</section>

<!-- Horizontal Image Slider -->
<div class="slider-container">
    <div class="slider">
        <div class="slide"><img src="images/feed3.jpg" height="400px" alt="Quality Feeds"></div>
        <div class="slide"><img src="images/feed2.jpg" height="400px" alt="Poultry Equipment"></div>
        <div class="slide"><img src="images/pe.jpeg" height="400px" alt="Healthy Supplements"></div>
    </div>
</div>

<!-- Product Categories -->
<section class="categories">
    <div class="category">
        <h3>Premium Feeds</h3>
        <p>Scientifically formulated feed for maximum poultry health and growth.</p>
        <img src="images/feed.jpeg" alt="Feeds">
    </div>
    <div class="category">
        <h3>Advanced Equipment</h3>
        <p>High-quality poultry farming tools to improve efficiency and productivity.</p>
        <img src="images/eq.jpg" alt="Equipment">
    </div>
    <div class="category">
        <h3>Healthy Supplements</h3>
        <p>Essential vitamins and minerals to boost poultry immunity and yield.</p>
        <img src="images/sup.jpg" alt="Supplements">
    </div>
</section>

<!-- Featured Products -->
<section class="product-section">
    <h2>Our Best-Selling Products</h2>
    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                <p>Price: ₹<?php echo number_format($row['price'], 2); ?></p>
                <button class="buy-now">Buy Now</button>
            </div>
            
        <?php endwhile; ?>
    </div>
</section>

<!-- Call-to-Action -->
<section class="cta-section">
    <h2>Need Help?</h2>
    <p>Have questions about our products? Contact us for expert advice.</p>
    <button class="contact-btn">Contact Us</button>
</section>

<!-- JavaScript for Horizontal Slider -->
<script>
    let index = 0;
    function slide() {
        let slider = document.querySelector(".slider");
        let slides = document.querySelectorAll(".slide");
        let slideWidth = slides[0].clientWidth;
        index++;
        if (index >= slides.length) { index = 0; }
        slider.style.transform = "translateX(" + (-index * slideWidth) + "px)";
    }
    setInterval(slide, 3000);
</script>

</body>
</html>
