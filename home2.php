<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        /* Navbar styles */
        .navbar {
            background-color: #F1C40F; /* Yellow */
            color: #000;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Container layout */
        .container {
            display: flex;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: lightyellow;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: #222;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0px 6px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 18px;
        }

        .sidebar a:hover {
            background: #F1C40F;
            color: #222;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        /* Content area */
        .content {
            flex: 1;
            padding: 40px;
            margin-left: 250px;
            background-color: lightyellow;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        .heading {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center; /* Centered heading */
        }

        /* Search bar */
        .search-bar {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center horizontally */
    justify-content: center; /* Center vertically */
    position: relative;
    margin-bottom: 20px;
}
        .search-bar input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-bar .cart {
            font-size: 22px;
            cursor: pointer;
        }

        /* Product grid and cards */
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 220px;
            transition: transform 0.3s;
            position: relative;
            border: 1px solid #ddd;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 16px;
            margin: 10px 0;
            color: #333;
        }

        .product-card .price {
            font-size: 16px;
            color: #F1C40F; /* Yellow */
            margin-bottom: 5px;
            font-weight: bold;
        }

        .product-card .deal {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #E67E22;
            color: white;
            padding: 5px 8px;
            font-size: 12px;
            border-radius: 5px;
        }

        .product-card button {
            background: #F1C40F; /* Yellow */
            color: #222;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            font-size: 14px;
        }

        .product-card button:hover {
            background: #F39C12;
        }

        /* Cart section */
        .cart-items {
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cart-items ul {
            list-style-type: none;
            padding-left: 0;
        }

        .cart-items ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-bar input {
                width: 100%;
                margin-bottom: 10px;
            }

            .product-grid {
                justify-content: flex-start;
            }

            .product-card {
                width: 100%;
                max-width: 250px;
            }

            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Customer Dashboard</div>
    <div class="container">
        <div class="sidebar">
            <a href="?page=home"><i class="fas fa-home"></i> Home</a>
            <a href="?page=view_orders"><i class="fas fa-box"></i> View Orders</a>
            <a href="?page=place_order"><i class="fas fa-cart-plus"></i> Place New Order</a>
            <a href="?page=profile"><i class="fas fa-user"></i> Customer Profile</a>
            <a href="?page=feedback"><i class="fas fa-comment"></i> Feedback</a>
            <a href="?page=support"><i class="fas fa-life-ring"></i> Support Help</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content">
            <div class="heading">Place New Order</div>
            <div class="search-bar">
                <input type="text" id="product-search" placeholder="Search products...">
                <span class="cart">🛒</span>
            </div>
            <div class="product-grid">
                <?php
                $products = [
                    ["Chicken Feed", "C:\\xammpp\\htdocs\\praju\\pic2.jpg", 600],
                    ["Egg Incubator", "egg_incubator.jpg", 12000],
                    ["Brooder", "brooder.jpg", 800],
                    ["Poultry Cage", "poultry_cage.jpg", 3500],
                    ["Feed Dispenser", "feed_dispenser.jpg", 1200],
                    ["Waterer", "waterer.jpg", 450],
                    ["Incubator", "incubator.jpg", 9000],
                    ["Chicken Coop", "chicken_coop.jpg", 5000],
                    ["Nest Box", "nest_box.jpg", 1500],
                    ["Vaccination Kit", "vaccination_kit.jpg", 500],
                    ["Poultry Heater", "poultry_heater.jpg", 2500],
                    ["Egg Tray", "egg_tray.jpg", 300],
                    ["Fodder Mixer", "fodder_mixer.jpg", 6500],
                    ["Chick Brooder Lamp", "chick_brooder_lamp.jpg", 800],
                    ["Poultry Lighting", "poultry_lighting.jpg", 200],
                    ["Chicken Feather Plucker", "chicken_plucker.jpg", 12000],
                    ["Bird Feeder", "bird_feeder.jpg", 600],
                    ["Chick Growth Supplement", "chick_growth_supplement.jpg", 120],
                    ["Egg Hatcher", "egg_hatcher.jpg", 4000],
                    ["Cage Feeder", "cage_feeder.jpg", 800],
                    ["Poultry Vaccine", "poultry_vaccine.jpg", 150],
                    ["Hatchery Equipment", "hatchery_equipment.jpg", 6000],
                    ["Animal Health Kit", "animal_health_kit.jpg", 800],
                    ["Automatic Feeder", "automatic_feeder.jpg", 1800],
                    ["Brooding Lamp", "brooding_lamp.jpg", 500],
                    ["Chicken Watering System", "chicken_watering_system.jpg", 1500],
                    ["Poultry Fan", "poultry_fan.jpg", 2200],
                    ["Egg Collection Basket", "egg_collection_basket.jpg", 200],
                    ["Chick Cage", "chick_cage.jpg", 2500],
                    ["Poultry Cleaner", "poultry_cleaner.jpg", 3500],
                    ["Egg Grading Machine", "egg_grading_machine.jpg", 10000]
                ];
                foreach ($products as $product) {
                    echo "<div class='product-card'>";
                    echo "<img src='images/{$product[1]}' alt='{$product[0]}'>";
                    echo "<h3>{$product[0]}</h3>";
                    echo "<p class='price'>₹{$product[2]}</p>";
                    echo "<button>Add to Cart</button>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
