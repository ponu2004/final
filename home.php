<?php

$conn = new mysqli("localhost", "root", "", "register");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = intval($_GET['delete']); 
    $tables = []; 
    switch ($_GET['section']) {
        case 'egg_management':
            $tables = ['egg_production', 'egg_sales'];
            break;
        case 'bird_management':
            $tables = ['bird_purchase', 'mortality'];
            break;
        case 'feed_management':
            $tables = ['feed_consumption', 'feed_purchase'];
            break;
        case 'customer_management':
            $tables = ['customers'];
            break;
        default:
            $tables = [];
    }

    if (!empty($tables)) {
        foreach ($tables as $table) {
            $conn->query("DELETE FROM $table WHERE id = $id");
        }
    }

    // Redirect to avoid repeated deletions on refresh
    header("Location: ?section=" . $_GET['section']);
    exit();
}



// Add new egg production record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_egg_production'])) {
    $date = $_POST['date'];
    $no_of_eggs = $_POST['no_of_eggs'];
    $conn->query("INSERT INTO egg_production (date, no_of_eggs) VALUES ('$date', '$no_of_eggs')");
}

// Add new egg sales record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_egg_sales'])) {
    $date = $_POST['sale_date'];
    $no_of_eggs = $_POST['sale_no_of_eggs'];
    $revenue = $_POST['revenue'];
    $conn->query("INSERT INTO egg_sales (sale_date, no_of_eggs, revenue) VALUES ('$date', '$no_of_eggs', '$revenue')");
}

// Add new bird purchase record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_bird_purchase'])) {
    $date = $_POST['purchase_date'];
    $no_of_birds = $_POST['no_of_birds'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO bird_purchase (purchase_date, no_of_birds, price) VALUES ('$date', '$no_of_birds', '$price')");
}

// Add new mortality record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_mortality'])) {
    $date = $_POST['mortality_date'];
    $no_of_deaths = $_POST['no_of_deaths'];
    $conn->query("INSERT INTO mortality (mortality_date, no_of_deaths) VALUES ('$date', '$no_of_deaths')");
}

// Add new feed purchase record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_feed_purchase'])) {
    $date = $_POST['feed_purchase_date'];
    $quantity = $_POST['quantity'];
    $purchase_amount = $_POST['purchase_amount'];
    $conn->query("INSERT INTO feed_purchase (feed_purchase_date, quantity, purchase_amount) VALUES ('$date', '$quantity', '$purchase_amount')");
}

// Add new feed consumption record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_feed_consumption'])) {
    $date = $_POST['feed_consumption_date'];
    $quantity_consumed = $_POST['quantity_consumed'];
    $equivalent_price = $_POST['equivalent_price'];
    $conn->query("INSERT INTO feed_consumption (feed_consumption_date, quantity_consumed, equivalent_price) VALUES ('$date', '$quantity_consumed', '$equivalent_price')");
}

// Add new customer record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_customer'])) {
    $name = $_POST['customer_name'];
    $order_amount= $_POST['order_amount'];
    $order_date = $_POST['order_date'];
    $conn->query("INSERT INTO customers (customer_name, order_amount, order_date) VALUES ('$name', '$order_amount', '$order_date')");
}

// Fetch records for different sections
$egg_production_records = $conn->query("SELECT * FROM egg_production");
$egg_sales_records = $conn->query("SELECT * FROM egg_sales");
$bird_purchase_records = $conn->query("SELECT * FROM bird_purchase");
$mortality_records = $conn->query("SELECT * FROM mortality");
$feed_purchase_records = $conn->query("SELECT * FROM feed_purchase");
$feed_consumption_records = $conn->query("SELECT * FROM feed_consumption");
$customer_records = $conn->query("SELECT * FROM customers");

// Determine which section to display
$section = isset($_GET['section']) ? $_GET['section'] : 'overview'; // Default to overview if no section is selected
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:lightblue;
            color: #333;
            
        }

        .sidebar {
            width: 250px;
            background-color: #007BFF;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            background-color: #007BFF;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #0056b3;
        }

        .sidebar a:hover {
            background-color: #003f7f;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
          
        }
        h2{
            text-align: center;
            box-sizing: 200px;
            color:white;
            background: 2px;
            background-color:green;
            margin-bottom: 20px;
        }
       

        .form-container {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container input[type="date"],
        .form-container input[type="number"],
        .form-container input[type="text"],
        .form-container button {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

         .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

       

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .overview-card {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 18%;
            text-align: center;
            margin: 10px 1%;
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 22px;
            color: #007BFF;
        }

        .card p {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .card p.negative {
            color: #dc3545; /* Red color for critical levels */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="?section=overview">Overview</a>
        <a href="?section=egg_management">Egg Management</a>
        <a href="?section=bird_management">Bird Management</a>
        <a href="?section=feed_management">Feed Management</a>
        <a href="?section=customer_management">Customer Management</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <?php if ($section === 'overview'): ?>
            <h1>Overview</h1>
            <div class="overview-card">
                <div class="card">
                    <h3>Total Birds</h3>
                    <p>150</p>
                </div>
                <div class="card">
                    <h3>Egg Stock</h3>
                    <p>3000 eggs</p>
                </div>
                <div class="card">
                    <h3>Sales Generated</h3>
                    <p>5000</p>
                </div>
                <div class="card">
                    <h3>Remaining Feed</h3>
                    <p>500 kg</p>
                </div>
                <div class="card">
                    <h3>Eggs Left</h3>
                    <p class="negative">2000 eggs</p>
                </div>
            </div>
        <?php elseif ($section === 'egg_management'): ?>
            <h1>Egg Management</h1>

            <h2>Egg Production</h2>
            <div class="form-container">
                <h3>Add New Egg Production Record</h3>
                <form method="POST">
                    <input type="date" name="date" required>
                    <input type="number" name="no_of_eggs" placeholder="Enter No. of Eggs" required>
                    <button type="submit" name="add_egg_production">Add Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>No. of Eggs</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $egg_production_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_of_eggs']); ?></td>
                        <td class="action-buttons">

                          
                            <a href="?section=egg_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- Egg Sales -->
            <h2>Egg Sales</h2>
            <div class="form-container">
                <h3>Add New Egg Sales Record</h3>
                <form method="POST">
                    <input type="date" name="sale_date" required>
                    <input type="number" name="sale_no_of_eggs" placeholder="Enter No. of Eggs Sold" required>
                    <input type="number" name="revenue" placeholder="Enter Revenue" required>
                    <button type="submit" name="add_egg_sales">Add Sales Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>No. of Eggs</th>
                    <th>Revenue</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $egg_sales_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_of_eggs']); ?></td>
                        <td><?php echo htmlspecialchars($row['revenue']); ?></td>
                        <td class="action-buttons">
                           
                            <a href="?section=egg_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
        <?php elseif ($section === 'bird_management'): ?>
            <h1>Bird Management</h1>

            <!-- Bird Purchase -->
            <h2>Bird Purchase</h2>
            <div class="form-container">
                <h3>Add New Bird Purchase Record</h3>
                <form method="POST">
                    <input type="date" name="purchase_date" required>
                    <input type="number" name="no_of_birds" placeholder="Enter No. of Birds" required>
                    <input type="number" name="price" placeholder="Enter Price" required>
                    <button type="submit" name="add_bird_purchase">Add Purchase Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>No. of Birds</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $bird_purchase_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_of_birds']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td class="action-buttons">
                           
                            <a href="?section=bird_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- Mortality -->
            <h2>Mortality</h2>
            <div class="form-container">
                <h3>Add New Mortality Record</h3>
                <form method="POST">
                    <input type="date" name="mortality_date" required>
                    <input type="number" name="no_of_deaths" placeholder="Enter No. of Deaths" required>
                    <button type="submit" name="add_mortality">Add Mortality Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>No. of Deaths</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $mortality_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['mortality_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_of_deaths']); ?></td>
                        <td class="action-buttons">
                           
                            <a href="?section=bird_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
        <?php elseif ($section === 'feed_management'): ?>
            <h1>Feed Management</h1>

            <!-- Feed Purchase -->
            <h2>Feed Purchase</h2>
            <div class="form-container">
                <h3>Add New Feed Purchase Record</h3>
                <form method="POST">
                    <input type="date" name="feed_purchase_date" required>
                    <input type="number" name="quantity" placeholder="Enter Feed Quantity" required>
                    <input type="number" name="purchase_amount" placeholder="Enter Amount Paid" required>
                    <button type="submit" name="add_feed_purchase">Add Feed Purchase Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Amount Paid</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $feed_purchase_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['feed_purchase_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['purchase_amount']); ?></td>
                        <td class="action-buttons">
                        
                            <a href="?section=feed_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- Feed Consumption -->
            <h2>Feed Consumption</h2>
            <div class="form-container">
                <h3>Add New Feed Consumption Record</h3>
                <form method="POST">
                    <input type="date" name="feed_consumption_date" required>
                    <input type="number" name="quantity_consumed" placeholder="Enter Quantity" required>
                    <input type="number" name="equivalent_price" placeholder="Enter Price" required>
                    <button type="submit" name="add_feed_consumption">Add Feed Consumption Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $feed_consumption_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['feed_consumption_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity_consumed']); ?></td>
                        <td><?php echo htmlspecialchars($row['equivalent_price']); ?></td>
                        <td class="action-buttons">
                            
                            <a href="?section=feed_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
        <?php elseif ($section === 'customer_management'): ?>
            <h1>Customer Management</h1>

            <!-- Customer Management -->
            <div class="form-container">
                <h3>Add New Customer Record</h3>
                <form method="POST">
                    <input type="text" name="customer_name" placeholder="Enter Customer Name" required>
                    <input type="text" name="order_amount" placeholder="Enter Customer Order" required>
                    <input type="date" name="order_date" required>
                    <button type="submit" name="add_customer">Add Customer Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $customer_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td class="action-buttons">
                            
                            <a href="?section=customer_management&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
        <?php endif; ?>
    </div>
</body>
</html>
