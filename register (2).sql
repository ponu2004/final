-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 06:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `register`
--

-- --------------------------------------------------------

--
-- Table structure for table `bird_purchase`
--

CREATE TABLE `bird_purchase` (
  `id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `no_of_birds` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust`
--

CREATE TABLE `cust` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cust`
--

INSERT INTO `cust` (`id`, `name`, `email`, `phone`, `address`) VALUES
(1, 'xyz', 'xyz@gmail.com', '9876539201', 'ewrge');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `order_amount`, `order_date`) VALUES
(1, 'raju', 52, '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `egg_production`
--

CREATE TABLE `egg_production` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `no_of_eggs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `egg_production`
--

INSERT INTO `egg_production` (`id`, `date`, `no_of_eggs`) VALUES
(12, '2025-01-20', 20),
(19, '2025-02-04', 23);

-- --------------------------------------------------------

--
-- Table structure for table `egg_sales`
--

CREATE TABLE `egg_sales` (
  `id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `no_of_eggs` int(11) NOT NULL,
  `revenue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `egg_sales`
--

INSERT INTO `egg_sales` (`id`, `sale_date`, `no_of_eggs`, `revenue`) VALUES
(1, '2025-01-13', 10, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `rating` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `username`, `message`, `rating`) VALUES
(1, '0', 'good', 0),
(2, '0', 'hi', 0),
(3, '0', 'cdfbfdb', 0),
(4, '0', 'cdfbfdb', 0),
(5, '0', 'gooddddd', 3),
(6, '0', 'too good', 3),
(7, 'adc', 'hi', 3);

-- --------------------------------------------------------

--
-- Table structure for table `feed_consumption`
--

CREATE TABLE `feed_consumption` (
  `id` int(11) NOT NULL,
  `feed_consumption_date` date NOT NULL,
  `quantity_consumed` int(11) NOT NULL,
  `equivalent_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_consumption`
--

INSERT INTO `feed_consumption` (`id`, `feed_consumption_date`, `quantity_consumed`, `equivalent_price`) VALUES
(4, '2025-01-01', 0, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `feed_purchase`
--

CREATE TABLE `feed_purchase` (
  `id` int(11) NOT NULL,
  `feed_purchase_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_purchase`
--

INSERT INTO `feed_purchase` (`id`, `feed_purchase_date`, `quantity`, `purchase_amount`) VALUES
(4, '2025-01-09', 4, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(22) NOT NULL,
  `name` varchar(22) NOT NULL,
  `username` varchar(22) NOT NULL,
  `password` varchar(22) NOT NULL,
  `confirmpassword` varchar(22) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `username`, `password`, `confirmpassword`, `email`, `role`, `reset_token`, `reset_expiry`) VALUES
(1, 'prajakta', 'sangle', 'Praju@2004', 'Praju@2004', 'sangleprajakta30@gmail.com', '', 'eed920be260696e12e8f651491e4b00e3de0fc62cec2c2eaf85ccc51fac1ae71e06add87379f85294e8f9c43654fa311bb4a', '2025-03-01 20:58:33'),
(2, 'kavya', 'dumble', 'kav123', 'kav123', 'kavyadumble33@gmail.co', '', NULL, NULL),
(3, 'namrata', 'nama', 'nama123', '', 'nama@gmail.com', 'Admin', NULL, NULL),
(4, 'raja', 'raju', 'raju123', '', 'raju@gmail.com', 'Admin', NULL, NULL),
(5, 'raja', 'raju', 'raju123', '', 'raju@gmail.com', 'Customer', NULL, NULL),
(6, 'namrata', 'nama', 'nama123', '', 'nama@gmail.com', 'Customer', NULL, NULL),
(7, 'sharad', 'sharad', 'sharad123', '', 'sharad7776@gmail.com', 'Admin', NULL, NULL),
(8, 'priyanka', 'priya', 'priya@123', '', 'priya@gmail.com', 'Admin,Customer', NULL, NULL),
(9, 'adc', 'adc', 'adc@123', '', 'adc@gmail.com', 'Admin,Customer', NULL, NULL),
(10, 'anisa', 'anisha', 'anisha', '', 'anisha@gmail.com', 'Admin', NULL, NULL),
(12, 'jessica', 'jessy', 'Jessy@123', '', 'jessy@gmail.com', 'Admin,Customer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mortality`
--

CREATE TABLE `mortality` (
  `id` int(11) NOT NULL,
  `mortality_date` date NOT NULL,
  `no_of_deaths` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mortality`
--

INSERT INTO `mortality` (`id`, `mortality_date`, `no_of_deaths`) VALUES
(1, '2025-01-21', 54);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Processing',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `expected_delivery_date` date DEFAULT (curdate() + interval 3 day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `username`, `address`, `payment_method`, `status`, `order_date`, `expected_delivery_date`) VALUES
(25, 'adc', 'ffhd', 'Cash on Delivery', 'Processing', '2025-02-28 11:43:01', '2025-03-03'),
(26, 'adc', 'gfhdh', 'Cash on Delivery', 'Processing', '2025-02-28 11:44:57', '2025-03-03'),
(27, 'adc', 'gfhf', 'Cash on Delivery', 'Processing', '2025-02-28 11:45:14', '2025-03-03'),
(28, 'adc', 'gfdbd', 'Cash on Delivery', 'Processing', '2025-02-28 11:45:50', '2025-03-03'),
(29, 'adc', 'h gg', 'Cash on Delivery', 'Processing', '2025-02-28 12:32:24', '2025-03-03'),
(30, 'Guest', 'Sample Address', 'Cash on Delivery', 'Processing', '2025-02-28 12:35:59', '2025-03-03'),
(31, 'Guest', 'Sample Address', 'Cash on Delivery', 'Processing', '2025-02-28 12:36:07', '2025-03-03'),
(32, 'adc', 'efvf', 'Cash on Delivery', 'Processing', '2025-02-28 12:38:31', '2025-03-03'),
(33, 'adc', ',hmjmhj', 'Cash on Delivery', 'Processing', '2025-02-28 12:39:45', '2025-03-03'),
(34, 'adc', 'fdgffbcbcvbcvbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 'Cash on Delivery', 'Processing', '2025-02-28 12:44:14', '2025-03-03'),
(35, 'adc', 'nfmnhgnnnnnnnnnnnnnnn', 'Cash on Delivery', 'Processing', '2025-02-28 12:44:33', '2025-03-03'),
(36, 'adc', 'gfdffmfmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm', 'Cash on Delivery', 'Processing', '2025-02-28 12:45:06', '2025-03-03'),
(37, 'adc', 'vvvvvvvvvvvvv', 'Cash on Delivery', 'Processing', '2025-02-28 12:47:13', '2025-03-03'),
(38, 'adc', 'Some address', 'Cash on Delivery', 'Pending', '2025-02-28 08:37:38', '2025-03-05'),
(39, 'adc', 'Some address', 'Cash on Delivery', 'Pending', '2025-02-28 08:41:59', '2025-03-05'),
(40, 'adc', 'Some address', 'Cash on Delivery', 'Pending', '2025-02-28 08:42:43', '2025-03-05'),
(41, 'adc', 'Some address', 'Cash on Delivery', 'Pending', '2025-02-28 08:42:52', '2025-03-05'),
(42, 'adc', 'Some address', 'Cash on Delivery', 'Pending', '2025-02-28 08:46:01', '2025-03-05'),
(43, 'adc', 'bvbvbbbbbbbbbbbbbb', 'Cash on Delivery', 'Processing', '2025-02-28 13:27:22', '2025-03-03'),
(44, 'adc', 'b-504', 'Online Payment', 'Processing', '2025-02-28 15:15:35', '2025-03-03'),
(45, 'adc', 'dd', 'Online Payment', 'Processing', '2025-02-28 15:18:53', '2025-03-03'),
(46, 'root', 'rr', 'Online Payment', 'Processing', '2025-02-28 15:35:20', '2025-03-03'),
(47, 'adc', 'bb-504', 'Cash on Delivery', 'Processing', '2025-02-28 15:50:16', '2025-03-03'),
(48, 'adc', 'ee', 'Cash on Delivery', 'Processing', '2025-02-28 15:56:09', '2025-03-03'),
(49, 'adc', 'fdb', 'Cash on Delivery', 'Processing', '2025-02-28 15:56:48', '2025-03-03'),
(50, 'adc', 'rrrrrrrrr', 'Cash on Delivery', 'Processing', '2025-02-28 15:57:49', '2025-03-03'),
(51, 'adc', 'uu', 'Cash on Delivery', 'Processing', '2025-02-28 16:02:12', '2025-03-03'),
(52, 'adc', 'abcd', 'Cash on Delivery', 'Processing', '2025-02-27 18:30:00', '2025-03-03'),
(53, 'adc', 'kalyan', 'Online Payment', 'Paid', '2025-02-28 11:56:54', '2025-03-03'),
(54, 'adc', 'kalyan', 'Online Payment', 'Paid', '2025-02-28 11:58:20', '2025-03-03'),
(55, '', 'mulund', 'Cash on Delivery', 'Pending', '2025-02-27 18:30:00', '2025-03-07'),
(56, 'nama', 'kj', 'Cash on Delivery', 'Pending', '2025-02-27 18:30:00', '2025-03-07'),
(57, 'adc', 'mulund', 'Cash on Delivery', 'Processing', '2025-02-28 17:52:17', '2025-03-03'),
(58, 'adc', 'kalyan', 'Online Payment', 'Processing', '2025-02-28 17:52:32', '2025-03-03'),
(59, 'adc', 'thane', 'Online Payment', 'Processing', '2025-02-28 17:57:16', '2025-03-03'),
(60, 'adc', 'goa', 'Online Payment', 'Processing', '2025-02-28 18:07:54', '2025-03-03'),
(61, 'adc', 'tt', 'Online Payment', 'Processing', '2025-02-28 18:15:14', '2025-03-03'),
(62, 'root', 'thane', 'Cash on Delivery', 'Processing', '2025-03-01 18:25:53', '2025-03-04'),
(63, 'root', 'ambernath', 'Cash on Delivery', 'Processing', '2025-03-01 19:10:01', '2025-03-05'),
(64, 'jessy', 'goa', 'Cash on Delivery', 'Processing', '2025-03-05 12:46:14', '2025-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(14, 27, 'Poultry Cage', 1, 3500.00),
(15, 28, 'Poultry Cage', 1, 3500.00),
(16, 31, 'Farm Gloves', 1, 500.00),
(17, 32, 'Brooder', 1, 800.00),
(18, 33, 'Chicken Feed', 1, 600.00),
(19, 34, 'Farm Gloves', 1, 500.00),
(20, 35, 'Chicken Feed', 1, 600.00),
(21, 36, 'Chicken Feed', 1, 600.00),
(22, 37, 'Farm Gloves', 1, 500.00),
(23, 38, '<br />\r\n<b>Warning</b>:  Undefined array key ', 2, 800.00),
(24, 38, '<br />\r\n<b>Warning</b>:  Undefined array key ', 1, 600.00),
(25, 38, '<br />\r\n<b>Warning</b>:  Undefined array key ', 1, 500.00),
(26, 39, '<br />\r\n<b>Warning</b>:  Undefined array key ', 1, 750.00),
(27, 43, 'Automatic Waterer', 1, 1500.00),
(28, 44, 'Automatic Waterer', 1, 1500.00),
(29, 45, 'Brooder', 1, 800.00),
(30, 46, 'Brooder', 1, 800.00),
(31, 47, 'Organic Feed', 1, 750.00),
(32, 48, 'Brooder', 1, 800.00),
(33, 49, 'Brooder', 1, 800.00),
(34, 50, 'Organic Feed', 1, 750.00),
(35, 51, 'Brooder', 1, 800.00),
(36, 52, 'Organic Feed', 1, 750.00),
(37, 54, 'Automatic Waterer', 1, 1500.00),
(38, 55, '', 1, 1500.00),
(39, 55, '', 1, 750.00),
(40, 55, '', 1, 3500.00),
(41, 55, '', 1, 800.00),
(42, 56, '', 1, 800.00),
(43, 57, 'Organic Feed', 1, 750.00),
(44, 58, 'Organic Feed', 1, 750.00),
(45, 59, 'Organic Feed', 1, 750.00),
(46, 60, 'Organic Feed', 1, 750.00),
(47, 61, 'Organic Feed', 1, 750.00),
(48, 62, 'Chicken Feed', 1, 600.00),
(49, 63, 'Egg Incubator', 1, 12000.00),
(50, 64, 'Hand Feeder', 1, 450.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `image`) VALUES
(1, 'Chicken Feed', 600.00, 'images/ff.jpg'),
(2, 'Egg Incubator', 12000.00, 'images/egg.jpg'),
(5, 'Organic Feed', 750.00, 'images/org.jpg'),
(6, 'Automatic Waterer', 1500.00, 'images/water.jpg'),
(9, 'mite & lice powder', 450.00, 'images/i11.png'),
(10, 'Farm Disinfectant', 900.00, 'images/farm.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bird_purchase`
--
ALTER TABLE `bird_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egg_production`
--
ALTER TABLE `egg_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egg_sales`
--
ALTER TABLE `egg_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_consumption`
--
ALTER TABLE `feed_consumption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_purchase`
--
ALTER TABLE `feed_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mortality`
--
ALTER TABLE `mortality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bird_purchase`
--
ALTER TABLE `bird_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust`
--
ALTER TABLE `cust`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `egg_production`
--
ALTER TABLE `egg_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `egg_sales`
--
ALTER TABLE `egg_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feed_consumption`
--
ALTER TABLE `feed_consumption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feed_purchase`
--
ALTER TABLE `feed_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mortality`
--
ALTER TABLE `mortality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
