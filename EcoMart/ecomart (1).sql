-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 04:20 PM
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
-- Database: `ecomart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `created_at`) VALUES
(2, 'Electronics', 'Discover the latest in electronic devices, gadgets, and accessories. Our Electronics category features everything from smartphones and laptops to smart home devices and wearable tech. Shop top brands and cutting-edge technology that fits your lifestyle and budget.', '2024-08-21 18:45:11'),
(3, 'Fashion', 'Stay stylish and trendy with our Fashion category, offering a wide range of clothing, footwear, and accessories for men, women, and children. Whether you’re looking for casual wear, formal attire, or the latest fashion trends, we have something to suit every style and occasion.', '2024-08-21 18:45:35'),
(4, 'Home & Kitchen', 'Upgrade your living space with our Home & Kitchen category. From essential kitchen appliances and cookware to stylish furniture and home décor, find everything you need to create a comfortable and functional home environment. Shop quality products that combine practicality with aesthetic appeal.', '2024-08-21 18:45:35'),
(5, 'Books', 'Dive into the world of literature with our Books category, offering a diverse selection of genres and titles. Whether you’re a fan of fiction, non-fiction, self-help, or academic texts, our collection has something for every reader. Discover bestsellers, classics, and new releases.', '2024-08-21 18:45:35'),
(6, 'Sports', ': Explore a wide range of sports products tailored for enthusiasts and professionals alike. From fitness gear, athletic apparel, and footwear to specialized equipment for various sports like soccer, basketball, tennis, and more, this category offers everything you need to enhance your performance and enjoy your favorite activities. Whether you’re training, competing, or just staying active, our collection ensures quality, comfort, and durability, catering to all ages and skill levels. Dive into the world of sports with top brands and cutting-edge gear designed to help you achieve your athletic goals.', '2024-08-28 14:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text DEFAULT NULL,
  `payment_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `status`, `shipping_address`, `payment_id`) VALUES
(150, 3, 24999.00, '2024-08-28 13:08:12', 'pending', 'cairo', 143),
(151, 3, 4999.00, '2024-08-28 13:09:00', 'pending', 'cairo', 144);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(238, 150, 6, 1, 24999.00),
(239, 151, 7, 1, 4999.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `payment_method` enum('credit_card','bank_transfer','cash_on_delivery') NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_date`, `amount`, `status`) VALUES
(143, 150, 'credit_card', '2024-08-28 13:08:12', 0.00, 'pending'),
(144, 151, 'bank_transfer', '2024-08-28 13:09:00', 0.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` varchar(191) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `image_url` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `category_id`, `image_url`, `created_at`) VALUES
(6, 'Smartphone', 'Latest model smartphone with cutting-edge features and high-resolution display.', '24999.00', 30, 2, 'https://m.media-amazon.com/images/I/61Wp5qhgwzL.__AC_SY300_SX300_QL70_ML2_.jpg', '2024-08-21 18:58:31'),
(7, 'Wireless Headphones', 'Noise-cancelling wireless headphones with superior sound quality.', '4999.00', 70, 2, 'https://www.borofone.com/wp-content/uploads/2022/04/borofone-bo12-power-bt-headset-headphones.jpg', '2024-08-21 18:58:31'),
(8, 'Laptop', 'High-performance laptop with powerful processor and long battery life.', '54999.00', 25, 2, 'https://dlcdnwebimgs.asus.com/gain/c80fd317-868e-4bc8-a27b-24c5242e7d83/w800', '2024-08-21 18:58:31'),
(9, 'Smart Watch', 'Stylish smart watch with fitness tracking and notification features.', '7999.00', 60, 2, 'https://m.media-amazon.com/images/I/61ZjlBOp+rL._AC_SX522_.jpg', '2024-08-21 18:58:31'),
(10, 'Leather Jacket', 'Premium leather jacket with a classic design and durable finish.', '8999.00', 20, 3, 'https://i.ebayimg.com/images/g/Fb8AAOSwllZhggWi/s-l1600.webp', '2024-08-21 19:01:08'),
(11, 'Jeans', 'Comfortable jeans with a modern slim-fit design.', '2499.00', 100, 3, 'https://m.media-amazon.com/images/I/51tIAuoOovL._AC_SY741_.jpg', '2024-08-21 19:01:08'),
(12, 'Sneakers', 'Trendy sneakers with cushioned soles for all-day comfort.', '3499.00', 60, 3, 'https://m.media-amazon.com/images/I/51to8+jHwIL._AC_SY695_.jpg', '2024-08-21 19:01:08'),
(13, 'Wristwatch', 'Elegant wristwatch with a minimalist design and genuine leather strap.', '5999.00', 45, 3, 'https://m.media-amazon.com/images/I/81XQ9rIHeUL._AC_SX679_.jpg', '2024-08-21 19:01:08'),
(14, 'Microwave Oven', 'Compact microwave oven with multiple cooking functions and quick heating.', '6999.00', 30, 4, 'https://m.media-amazon.com/images/I/71QGtqt7OXL.__AC_SY445_SX342_QL70_ML2_.jpg', '2024-08-21 19:03:48'),
(15, 'Blender', 'Powerful blender with variable speed settings and durable glass jar.', '3499.00', 50, 4, 'https://m.media-amazon.com/images/I/61dWwDRrIML.__AC_SX300_SY300_QL70_ML2_.jpg', '2024-08-21 19:03:48'),
(16, 'Sofa Set', 'Luxurious sofa set with plush cushions and sturdy frame.', '24999.00', 10, 4, 'https://m.media-amazon.com/images/I/51f1hp0k1YL.__AC_SX300_SY300_QL70_ML2_.jpg', '2024-08-21 19:03:48'),
(17, 'Cookware Set', 'Non-stick cookware set with durable construction and even heat distribution.', '4999.00', 70, 4, 'https://m.media-amazon.com/images/I/81yzz2N6CyL.__AC_SX300_SY300_QL70_ML2_.jpg', '2024-08-21 19:03:48'),
(18, 'It Ends with Us', 'Lily hasn’t always had it easy, but that’s never stopped her from working hard for the life she wants. She’s come a long way from the small town where she grew up—she graduated from college, moved to Boston, and started her own business. And when she feels a spark with a gorgeous neurosurgeon named Ryle Kincaid, everything in Lily’s life seems too good to be true.', '499.00', 100, 5, 'https://m.media-amazon.com/images/I/51X4eBEqyqL._SY445_SX342_.jpg', '2024-08-21 19:09:08'),
(19, 'It Starts with Us', 'Lily and her ex-husband, Ryle, have just settled into a civil coparenting rhythm when she suddenly bumps into her first love, Atlas, again. After nearly two years separated, she is elated that for once, time is on their side, and she immediately says yes when Atlas asks her on a date.', '399.00', 80, 5, 'https://m.media-amazon.com/images/I/71PNGYHykrL._SY466_.jpg', '2024-08-21 19:09:08'),
(20, 'The Anxious Generation: How the Great Rewiring of Childhood Is Causing an Epidemic of Mental Illness', 'Harper Lee\'s timeless novel on race and morality in the American South.', '599.00', 90, 5, 'https://m.media-amazon.com/images/I/81XP4hEXDXL._SY466_.jpg', '2024-08-21 19:09:08'),
(21, 'A Court of Thorns and Roses (A Court of Thorns and Roses, 1)', 'When nineteen-year-old huntress Feyre kills a wolf in the woods, a terrifying creature arrives to demand retribution. Dragged to a treacherous magical land she knows about only from legends, Feyre discovers that her captor is not truly a beast, but one of the lethal, immortal faeries who once ruled her world.', '450.00', 110, 5, 'https://m.media-amazon.com/images/I/81RrEEMiOCL._SY466_.jpg', '2024-08-21 19:09:08'),
(26, 'DRAGON SLAY Folding Desktop Stand Holder', 'DRAGON SLAY Folding Desktop Stand Holder for Mobile Phones and Tablets up to 11”, Adjustable Height and Angle for Video Calls, Study, Gaming (Blue Black)', '200', 30, 2, 'uploads/51orddem2KL._AC_SY450_.jpg', '2024-08-24 22:31:28'),
(28, 'Multi-Angle Cell Phone Stand', 'Multi-Angle Cell Phone Stand, Tablet Stand for Tablet - Plastic Mobile Stand - Multi Color (Green) (White)', '105', 30, 2, 'uploads/41kz8sVx1UL._AC_SX450_.jpg', '2024-08-25 08:20:44'),
(29, 'Oraimo FreePods Lite True Wireless Earbuds', 'Oraimo FreePods Lite True Wireless Earbuds Bluetooth TWS Earphone with APP Control,40h Play Time, Anifast Fast Charging,in-Ear Earbuds with Stereo Bass,Black', '539', 80, 2, 'uploads/61zbcOwRoPL.__AC_SX300_SY300_QL70_ML2_.jpg', '2024-08-25 08:32:23'),
(32, 'DeFacto Girls Parachute Cargo B9822A8 Trousers', 'DeFacto\r\nCotton 100%\r\nParachute Cargo', '1093', 50, 3, 'uploads/81aMFadgqeL._AC_SY741_.jpg', '2024-08-25 08:40:36'),
(33, 'Penti Girl T.Heart Caftan-', 'KAFTAN\r\nGirl\r\nKAFTAN', '949', 200, 3, 'uploads/81GZWb1kbAL._AC_SY741_.jpg', '2024-08-25 08:45:56'),
(34, 'Girls Fall Outerwear', 'Girls Fall Outerwear & Workout Set – Top 100% Cotton Legion Interlock Loaded Comfortable and Unique Design', '795', 100, 3, 'uploads/p_3.jpg', '2024-08-25 09:00:26'),
(35, 'Xiaomi Mi Electric Scooter 4 Lite 2nd Gen EU BHR8052GL Black', 'Stylish look, stable performance:Take your ride to a new level! The streamlined horseback design paired with a high-strength carbon-steel frame supports a max. load of 100kg, ensuring a fashionable and reliable travel experience\r\nThe 10″ large tires enhance shock absorption:The 10″ pneumatic tires ensure a smooth and comfortable ride, even on rough or uneven terrains\r\nWith a max. travel range of 25km, it can easily meet your daily commuting needs :The long-lasting battery life allows you to go anywhere within a 5km radius\r\nSmart BMS protects your battery :Six battery protection mechanisms can extend service life and ensure the reliability of your scooter. Over-charge protection. Over-discharge protection. Overvoltage protection. Over temperature protection. Short circuit protection.\r\nOvercurrent protection', '17500', 30, 2, 'uploads/51EglimPm3L._AC_SX569_.jpg', '2024-08-25 14:22:52'),
(36, 'Basics Neoprene Dumbbell Hand Weights', '3 pound dumbbell (set of 2) for exercise and strength training\r\nNeoprene coating in Purple offers long lasting durability\r\nHexagon shaped ends prevent dumbbells from rolling away and offer stay-in-place storage\r\nNonslip grip promotes a comfortable, secure hold\r\nAvailable in multiple sizes to mix and match for specific workout needs and to expand on over time\r\nPrinted weight number on each end cap and color coded for quick identification', '10', 107, 6, 'uploads/71fLcTLuUdL._AC_SX679_.jpg', '2024-08-28 14:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `image_url` varchar(191) DEFAULT NULL,
  `alt_text` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `alt_text`, `created_at`) VALUES
(1, 6, 'https://m.media-amazon.com/images/I/51S4Nfgdh0L._AC_SX679_.jpg', NULL, '2024-08-22 12:44:05'),
(2, 6, 'https://m.media-amazon.com/images/I/71Lv32ogyOL._AC_SX679_.jpg', NULL, '2024-08-22 12:44:05'),
(3, 6, 'https://m.media-amazon.com/images/I/61Sd85nQE2L._AC_SX679_.jpg', NULL, '2024-08-22 12:46:48'),
(4, 6, 'https://m.media-amazon.com/images/I/71ZwoWAImlL._AC_SX679_.jpg', NULL, '2024-08-22 12:46:48'),
(5, 6, 'https://m.media-amazon.com/images/I/714CRqV-SaL._AC_SX679_.jpg', NULL, '2024-08-22 12:46:48'),
(6, 6, 'https://m.media-amazon.com/images/I/61fyrJoHkGL._AC_SX679_.jpg', NULL, '2024-08-22 12:46:48'),
(9, 26, 'uploads/51orddem2KL._AC_SY450_.jpg', NULL, '2024-08-24 22:38:17'),
(10, 28, 'uploads/41kz8sVx1UL._AC_SX450_.jpg', NULL, '2024-08-25 08:20:44'),
(11, 32, 'uploads/71npJnnM1XL._AC_SY879_.jpg', NULL, '2024-08-25 08:40:36'),
(12, 32, 'uploads/71sKQgfl8CL._AC_SY741_.jpg', NULL, '2024-08-25 08:40:36'),
(13, 33, 'uploads/61gVvApKn0L._AC_SY879_.jpg', NULL, '2024-08-25 08:45:57'),
(14, 33, 'uploads/71BfAAxdfKL._AC_SY741_.jpg', NULL, '2024-08-25 08:45:57'),
(15, 34, 'uploads/p_2.jpg', NULL, '2024-08-25 09:00:26'),
(16, 34, 'uploads/p_1.jpg', NULL, '2024-08-25 09:00:26'),
(17, 35, 'uploads/61v-gJWV9DL._AC_SX569_.jpg', NULL, '2024-08-25 14:22:52'),
(18, 35, 'uploads/511wFXoR5ZL.__AC_SX300_SY300_QL70_ML2_.jpg', NULL, '2024-08-25 14:22:52'),
(19, 36, 'uploads/716Ckt14y4L._AC_SX679_.jpg', NULL, '2024-08-28 14:19:48'),
(20, 36, 'uploads/611XTsQKAIL._AC_SX679_.jpg', NULL, '2024-08-28 14:19:48'),
(21, 36, 'uploads/51N9NE7XTXL._AC_SX679_.jpg', NULL, '2024-08-28 14:19:48'),
(22, 36, 'uploads/dumbel.jpg', NULL, '2024-08-28 14:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `shipping_method` varchar(191) DEFAULT NULL,
  `shipping_cost` decimal(10,2) DEFAULT NULL,
  `shipping_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `order_id`, `shipping_method`, `shipping_cost`, `shipping_date`, `delivery_date`) VALUES
(143, 150, 'standard', 10.00, '2024-08-28 13:08:12', '2024-09-02 13:08:12'),
(144, 151, 'express', 20.00, '2024-08-28 13:09:00', '2024-09-02 13:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone_number`, `user_type`, `created_at`) VALUES
(1, 'hadeer', 'hadeer@gmail.com', '1234', '011325235', 'admin', '2024-08-21 17:21:01'),
(2, 'osama', 'osama@gmail.com', '12345', '0102232432', 'customer', '2024-08-21 17:21:48'),
(3, 'mohamed', 'mohamed@gmail.com', '111', '012313345346', 'customer', '2024-08-25 14:08:08'),
(4, 'ahmed', 'ahmed@gmail.com', '1111', '011313345346', 'customer', '2024-08-25 14:10:53'),
(5, 'hadeeribraheem', 'hadeeribraheem166@gmail.com', '123', '01012124515', 'customer', '2024-08-25 14:18:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_ibfk_2` (`payment_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_ibfk_1` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
