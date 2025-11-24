-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 07:54 AM
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
-- Database: `lookback_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL DEFAULT 1,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_avatar` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_name`, `user_email`, `password`, `user_avatar`, `created_at`) VALUES
(1, 'ADMIN', 'admintest@email.com', '$2a$12$rvNPFUFv9zB5XLsbEc0.U.efPrUq9usLOqqFQY/A4WZbNGDugSFEu', NULL, '2025-11-22 08:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_log`
--

INSERT INTO `admin_activity_log` (`log_id`, `admin_id`, `activity_type`, `activity_description`, `ip_address`, `created_at`) VALUES
(4, 1, 'menu_management', 'Updated menu item: Affogato', '::1', '2025-11-23 17:17:29'),
(5, 1, 'menu_management', 'Updated menu item: Affogato', '::1', '2025-11-24 02:21:03'),
(6, 1, 'menu_management', 'Updated menu item: Affogato', '::1', '2025-11-24 02:23:13'),
(7, 1, 'menu_management', 'Updated menu item: Affogato', '::1', '2025-11-24 02:29:31'),
(8, 1, 'user_management', 'Deleted user account ID: 5', '::1', '2025-11-24 06:31:52'),
(9, 1, 'menu_management', 'Updated menu item: Affogato (ID: 1)', '::1', '2025-11-24 06:49:36'),
(10, 1, 'menu_management', 'Updated menu item: Affogato (ID: 1)', '::1', '2025-11-24 06:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `business_info`
--

CREATE TABLE `business_info` (
  `info_id` int(11) NOT NULL DEFAULT 1,
  `business_name` varchar(255) DEFAULT 'Look Back Café',
  `business_email` varchar(255) DEFAULT 'lookbackcafe.25@gmail.com',
  `business_phone` varchar(50) DEFAULT '+63 939 4716 012',
  `business_address` text DEFAULT 'In front of CEU Malolos Gate 3, MacArthur Highway, Longos, Malolos, Philippines',
  `google_maps_link` varchar(500) DEFAULT 'https://maps.app.goo.gl/SVh5K9ZCcPvUCnJm7',
  `google_maps_embed` text DEFAULT NULL,
  `weekday_hours` varchar(100) DEFAULT '8:00 AM – 8:00 PM',
  `weekend_hours` varchar(100) DEFAULT '10:00 AM – 8:00 PM',
  `facebook_link` varchar(500) DEFAULT 'https://www.facebook.com/lookbackcafe/',
  `instagram_link` varchar(500) DEFAULT 'https://www.instagram.com/lookbackcafe/',
  `tiktok_link` varchar(500) DEFAULT 'https://www.tiktok.com/@lookbackcafe',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_info`
--

INSERT INTO `business_info` (`info_id`, `business_name`, `business_email`, `business_phone`, `business_address`, `google_maps_link`, `google_maps_embed`, `weekday_hours`, `weekend_hours`, `facebook_link`, `instagram_link`, `tiktok_link`, `updated_at`) VALUES
(1, 'Look Back Café', 'lookbackcafe.25@gmail.com', '+63 939 4716 012', 'In front of CEU Malolos Gate 3, MacArthur Highway, Longos, Malolos, Philippines', 'https://maps.app.goo.gl/SVh5K9ZCcPvUCnJm7', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.2099929974647!2d120.79826227574453!3d14.869531670434611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339651beb9a91c99%3A0x37ab9eef1b7b16c8!2sLook%20Back%20Caf%C3%A9!5e0!3m2!1sen!2sph!4v1763465378566!5m2!1sen!2sph\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', '8:00 AM – 8:00 PM', '10:00 AM – 8:00 PM', 'https://www.facebook.com/lookbackcafe/', 'https://www.instagram.com/lookbackcafe/', 'https://www.tiktok.com/@lookbackcafe', '2025-11-23 05:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `encrypted_data`
--

CREATE TABLE `encrypted_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `encrypted_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user',
  `ip_address` varchar(45) DEFAULT NULL,
  `success` tinyint(1) DEFAULT 0,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `identifier`, `role`, `ip_address`, `success`, `attempt_time`) VALUES
(14, 'admin@email.com', 'user', '::1', 1, '2025-11-23 16:51:47'),
(15, 'admin@email.com', 'user', '::1', 1, '2025-11-23 17:21:31'),
(16, 'admin@email.com', 'user', '::1', 1, '2025-11-24 02:15:18'),
(17, 'admin@gmail.com', 'user', '::1', 0, '2025-11-24 02:19:44'),
(18, 'admin@gmail.com', 'user', '::1', 0, '2025-11-24 02:19:55'),
(19, 'admin@gmail.com', 'user', '::1', 0, '2025-11-24 02:20:02'),
(20, 'admin@email.com', 'user', '::1', 1, '2025-11-24 02:28:03'),
(21, 'natnatsmy@gmail.com', 'user', '::1', 0, '2025-11-24 03:33:58'),
(22, 'admin@email.com', 'user', '::1', 1, '2025-11-24 03:38:43'),
(23, 'admin@gmail.com', 'user', '::1', 0, '2025-11-24 04:09:10'),
(24, 'admin@gmail.com', 'user', '::1', 0, '2025-11-24 04:09:19'),
(25, 'admin@email.com', 'user', '::1', 1, '2025-11-24 04:09:28'),
(26, 'user@gmail.com', 'user', '::1', 1, '2025-11-24 04:16:35'),
(27, 'admin@email.com', 'user', '::1', 1, '2025-11-24 04:34:27'),
(28, 'user@gmail.com', 'user', '::1', 1, '2025-11-24 04:35:10'),
(29, 'natnatsmy@gmail.com', 'user', '::1', 0, '2025-11-24 06:32:47'),
(30, 'natnatsmy@gmail.com', 'user', '::1', 0, '2025-11-24 06:32:56'),
(31, 'testusertest@gmail.com', 'user', '::1', 0, '2025-11-24 06:36:47'),
(32, 'testusertest@gmail.com', 'user', '::1', 1, '2025-11-24 06:37:01'),
(33, 'admintest@email.com', 'user', '::1', 0, '2025-11-24 06:39:00'),
(34, 'admintest@email.com', 'user', '::1', 0, '2025-11-24 06:39:16'),
(35, 'admintest@email.com', 'user', '::1', 1, '2025-11-24 06:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` enum('espresso','viet','noncoffee','rice','hs','milkshake','soda','snacks','waffles') NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `price_16oz` decimal(10,2) DEFAULT NULL,
  `price_upsize` decimal(10,2) DEFAULT NULL,
  `price_1liter` decimal(10,2) DEFAULT NULL,
  `price_hot` decimal(10,2) DEFAULT NULL,
  `price_500ml` decimal(10,2) DEFAULT NULL,
  `price_regular` decimal(10,2) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `item_name`, `category`, `image_path`, `price_16oz`, `price_upsize`, `price_1liter`, `price_hot`, `price_500ml`, `price_regular`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Affogato', 'espresso', '../resources/img/MENU/ESPRESSO/affogato.jpg', 145.00, NULL, NULL, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-24 06:49:53'),
(2, 'Spanish Latte', 'espresso', '../resources/img/MENU/ESPRESSO/spanishlatte.jpg', 130.00, 150.00, 210.00, 150.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(3, 'Breve Latte', 'espresso', '../resources/img/MENU/ESPRESSO/brevelatte.jpg', 160.00, 160.00, 270.00, 140.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(4, 'White Chocolate Mocha', 'espresso', '../resources/img/MENU/ESPRESSO/wcmocha.jpg', 160.00, 160.00, 270.00, 140.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(5, 'Signature Blend', 'espresso', '../resources/img/MENU/ESPRESSO/sigblend.jpg', 180.00, 180.00, 300.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(6, 'Dirty Matcha', 'espresso', '../resources/img/MENU/ESPRESSO/dirtymatcha.jpg', 160.00, 160.00, 270.00, 140.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(7, 'Mocha', 'espresso', '../resources/img/MENU/ESPRESSO/mocha.jpg', 150.00, 150.00, 250.00, 130.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(8, 'Caramel Latte', 'espresso', '../resources/img/MENU/ESPRESSO/caramellatte.jpg', 150.00, 150.00, 250.00, 130.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(9, 'Latte', 'espresso', '../resources/img/MENU/ESPRESSO/latte.jpg', 140.00, 140.00, 230.00, 120.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(10, 'Americano', 'espresso', '../resources/img/MENU/ESPRESSO/americano.jpg', 130.00, 130.00, 210.00, 110.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(11, 'Caramel Vietnamese', 'viet', '../resources/img/MENU/VIET/caramel.jpg', 95.00, 115.00, NULL, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(12, 'Silver Coffee', 'viet', '../resources/img/MENU/VIET/silver.jpg', 110.00, 130.00, 210.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(13, 'Egg Coffee', 'viet', '../resources/img/MENU/VIET/egg.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(14, 'Iced Coffee Milk', 'viet', '../resources/img/MENU/VIET/icedcoffee.jpg', 95.00, 115.00, 180.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(15, 'Salt Coffee', 'viet', '../resources/img/MENU/VIET/salt.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(16, 'Berry Matcha', 'noncoffee', '../resources/img/MENU/NONCOFFEE/berrymatcha.jpg', 150.00, NULL, 270.00, 140.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(17, 'Brown Sugar Milk', 'noncoffee', '../resources/img/MENU/NONCOFFEE/brownsugar.jpg', 130.00, 130.00, 230.00, 120.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(18, 'Choco Berry', 'noncoffee', '../resources/img/MENU/NONCOFFEE/chocoberry.jpg', 150.00, NULL, 270.00, 140.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(19, 'Chocolate Milk', 'noncoffee', '../resources/img/MENU/NONCOFFEE/chocolate.jpg', 130.00, 130.00, 230.00, 120.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(20, 'Matcha', 'noncoffee', '../resources/img/MENU/NONCOFFEE/matcha.jpg', 130.00, 130.00, 230.00, 120.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(21, 'Strawberry Milk', 'noncoffee', '../resources/img/MENU/NONCOFFEE/strawberry.jpg', 130.00, NULL, 230.00, 120.00, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(22, 'BBQ Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/bbq.jpg', NULL, NULL, NULL, NULL, NULL, 160.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(23, 'Chicken Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/chicken.jpg', NULL, NULL, NULL, NULL, NULL, 150.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(24, 'Garlic Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/garlic.jpg', NULL, NULL, NULL, NULL, NULL, 160.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(25, 'Ham Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/ham.jpg', NULL, NULL, NULL, NULL, NULL, 130.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(26, 'Hotdog Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/hotdog.jpg', NULL, NULL, NULL, NULL, NULL, 100.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(27, 'Maple Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/maple.jpg', NULL, NULL, NULL, NULL, NULL, 150.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(28, 'Sausilog Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/sausilog.jpg', NULL, NULL, NULL, NULL, NULL, 125.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(29, 'Sriracha Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/sriracha.jpg', NULL, NULL, NULL, NULL, NULL, 130.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(30, 'Tapa Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/tapa.jpg', NULL, NULL, NULL, NULL, NULL, 100.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(31, 'Tocino Rice Meal', 'rice', '../resources/img/MENU/RICEMEAL/tocino.jpg', NULL, NULL, NULL, NULL, NULL, 90.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(32, 'House Specials', 'hs', '../resources/img/MENU/HOUSE SPECIALS/housespecial.png', NULL, NULL, NULL, NULL, NULL, 0.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(33, 'Biscoff Caramel Milkshake', 'milkshake', '../resources/img/MENU/MILKSHAKE/biscoff.jpg', NULL, NULL, NULL, NULL, 180.00, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(34, 'Avocado Milkshake', 'milkshake', '../resources/img/MENU/MILKSHAKE/avo.jpg', NULL, NULL, NULL, NULL, 180.00, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(35, 'Dark Chocolate Milkshake', 'milkshake', '../resources/img/MENU/MILKSHAKE/dc.jpg', NULL, NULL, NULL, NULL, 180.00, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(36, 'Cookies and Cream Milkshake', 'milkshake', '../resources/img/MENU/MILKSHAKE/cnc.jpg', NULL, NULL, NULL, NULL, 180.00, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(37, 'Blueberry Soda', 'soda', '../resources/img/MENU/SODA/blueberry.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(38, 'Green Apple Soda', 'soda', '../resources/img/MENU/SODA/green.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(39, 'Lemon Soda', 'soda', '../resources/img/MENU/SODA/lemon.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(40, 'Lychee Soda', 'soda', '../resources/img/MENU/SODA/lychee.jpg', 130.00, 150.00, 250.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(41, 'Strawberry Soda', 'soda', '../resources/img/MENU/SODA/strawberry.jpg', 130.00, 150.00, 230.00, NULL, NULL, NULL, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(42, 'Four Cheese Quesadilla', 'snacks', '../resources/img/MENU/SNACK/4c.jpg', NULL, NULL, NULL, NULL, NULL, 160.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(43, 'Beef Quesadilla', 'snacks', '../resources/img/MENU/SNACK/beef.jpg', NULL, NULL, NULL, NULL, NULL, 150.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(44, 'Cheesy Bacon Fries', 'snacks', '../resources/img/MENU/SNACK/cheesy.jpg', NULL, NULL, NULL, NULL, NULL, 160.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(45, 'Plain Fries', 'snacks', '../resources/img/MENU/SNACK/fries.png', NULL, NULL, NULL, NULL, NULL, 130.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(46, 'Biscoff Caramel Waffle', 'waffles', '../resources/img/MENU/WAFFLE/biscoff.jpg', NULL, NULL, NULL, NULL, NULL, 100.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(47, 'Chicken & Waffle', 'waffles', '../resources/img/MENU/WAFFLE/chicken.jpg', NULL, NULL, NULL, NULL, NULL, 150.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(48, 'Ham & Cheese Waffle', 'waffles', '../resources/img/MENU/WAFFLE/hnc.jpg', NULL, NULL, NULL, NULL, NULL, 125.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(49, 'Ham & Egg Waffle', 'waffles', '../resources/img/MENU/WAFFLE/hne.jpg', NULL, NULL, NULL, NULL, NULL, 130.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(50, 'Nutella Almond Waffle', 'waffles', '../resources/img/MENU/WAFFLE/nutella.jpg', NULL, NULL, NULL, NULL, NULL, 100.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(51, 'Plain Waffle', 'waffles', '../resources/img/MENU/WAFFLE/plain.jpg', NULL, NULL, NULL, NULL, NULL, 45.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(52, 'Creamy Spinach Waffle', 'waffles', '../resources/img/MENU/WAFFLE/spinach.jpg', NULL, NULL, NULL, NULL, NULL, 100.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40'),
(53, 'Strawberry and Cream Waffle', 'waffles', '../resources/img/MENU/WAFFLE/strawberrry.jpg', NULL, NULL, NULL, NULL, NULL, 90.00, 1, '2025-11-23 06:12:40', '2025-11-23 06:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters_sent`
--

CREATE TABLE `newsletters_sent` (
  `newsletter_id` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `sent_by` int(11) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `recipients_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

CREATE TABLE `page_content` (
  `content_id` int(11) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `content_type` enum('text','image','html') DEFAULT 'text',
  `content_value` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`content_id`, `page_name`, `section_name`, `content_type`, `content_value`, `updated_at`) VALUES
(1, 'photowall', 'caption', 'text', 'A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We\'re so grateful for your support!', '2025-11-23 05:54:49'),
(2, 'special_offers', 'title', 'text', 'SPECIAL OFFERS', '2025-11-23 05:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otps`
--

CREATE TABLE `password_reset_otps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_otps`
--

INSERT INTO `password_reset_otps` (`id`, `user_id`, `otp_hash`, `expires_at`, `used`, `created_at`) VALUES
(1, 4, '$2y$12$qA2UCdZ0oFltr5xL8W3vVetveSvYF7/n.gcyZVGlYrxpgkL3psXZ6', '2025-11-24 03:30:39', 1, '2025-11-23 13:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `photo_wall`
--

CREATE TABLE `photo_wall` (
  `photo_id` int(11) NOT NULL,
  `photo_path` varchar(500) NOT NULL,
  `photo_order` int(11) DEFAULT 0,
  `caption` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `photo_wall`
--

INSERT INTO `photo_wall` (`photo_id`, `photo_path`, `photo_order`, `caption`, `uploaded_at`, `is_active`) VALUES
(1, '../resources/img/HOMEPAGE/photowall/photowall1.png', 1, 'A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We\'re so grateful for your support!', '2025-11-23 05:54:49', 1),
(2, '../resources/img/HOMEPAGE/photowall/photowall2.png', 2, NULL, '2025-11-23 05:54:49', 1),
(3, '../resources/img/HOMEPAGE/photowall/photowall3.png', 3, NULL, '2025-11-23 05:54:49', 1),
(4, '../resources/img/HOMEPAGE/photowall/photowall4.png', 4, NULL, '2025-11-23 05:54:49', 1),
(5, '../resources/img/HOMEPAGE/photowall/photowall5.png', 5, NULL, '2025-11-23 05:54:49', 1),
(6, '../resources/img/HOMEPAGE/photowall/photowall6.png', 6, NULL, '2025-11-23 05:54:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `security_log`
--

CREATE TABLE `security_log` (
  `id` int(11) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_log`
--

INSERT INTO `security_log` (`id`, `event_type`, `description`, `user_id`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:30:47'),
(2, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:32:01'),
(3, 'user_login_failed', 'Failed user login attempt: natnatsmy@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:33:50'),
(4, 'user_login_success', 'User logged in: natnatsmy@gmail.com', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:33:57'),
(5, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:34:21'),
(6, 'user_login_success', 'User logged in: natnatsmy@gmail.com', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:31:23'),
(7, 'password_changed', 'Password changed for user ID: 4', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:32:40'),
(8, 'password_changed', 'Password changed for user ID: 4', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:35:41'),
(9, 'user_registration', 'New user registered: asha@gmail.com', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:47:34'),
(10, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:48:31'),
(11, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 12:49:41'),
(12, 'rate_limit_exceeded', 'Too many login attempts for: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:00:52'),
(13, 'rate_limit_exceeded', 'Too many login attempts for: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:01:27'),
(14, 'rate_limit_exceeded', 'Too many login attempts for: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:01:42'),
(15, 'rate_limit_exceeded', 'Too many login attempts for: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:02:52'),
(16, 'admin_login_failed', 'Failed admin login attempt: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:11:56'),
(17, 'admin_login_failed', 'Failed admin login attempt: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:12:18'),
(18, 'admin_login_failed', 'Failed admin login attempt: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:13:47'),
(19, 'admin_login_failed', 'Failed admin login attempt: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:19:22'),
(20, 'admin_login_failed', 'Failed admin login attempt: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 13:19:29'),
(21, 'user_registration', 'New user registered: user@gmail.com', 6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 16:29:57'),
(22, 'password_change_failed', 'Failed password change attempt for user ID: 6', 6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 16:45:21'),
(23, 'password_changed', 'Password changed for user ID: 6', 6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 16:48:27'),
(24, 'rate_limit_exceeded', 'Too many login attempts for: admin@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 16:50:59'),
(25, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 16:51:47'),
(26, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 17:21:31'),
(27, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 02:15:18'),
(28, 'admin_login_failed', 'Failed admin login attempt: admin@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 02:19:44'),
(29, 'admin_login_failed', 'Failed admin login attempt: admin@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 02:19:55'),
(30, 'admin_login_failed', 'Failed admin login attempt: admin@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 02:20:02'),
(31, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 02:28:03'),
(32, 'user_login_failed', 'Failed user login attempt: natnatsmy@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 03:33:58'),
(33, 'user_registration', 'New user registered: user@gmail.com', 7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 03:34:59'),
(34, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 03:38:43'),
(35, 'admin_login_failed', 'Failed admin login attempt: admin@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:09:10'),
(36, 'admin_login_failed', 'Failed admin login attempt: admin@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:09:19'),
(37, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:09:28'),
(38, 'user_login_success', 'User logged in: user@gmail.com', 7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:16:35'),
(39, 'admin_login_success', 'Admin logged in: admin@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:34:27'),
(40, 'user_login_success', 'User logged in: user@gmail.com', 7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 04:35:10'),
(41, 'password_changed', 'Password changed for user ID: 1', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:30:31'),
(42, 'password_change_failed', 'Failed password change attempt for user ID: 1', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:30:32'),
(43, 'password_changed', 'Password changed for user ID: 1', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:31:13'),
(44, 'user_deleted', 'Admin deleted user account ID: 5', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:31:52'),
(45, 'user_login_failed', 'Failed user login attempt: natnatsmy@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:32:47'),
(46, 'user_login_failed', 'Failed user login attempt: natnatsmy@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:32:56'),
(47, 'user_registration', 'New user registered: testuser@gmail.com', 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:33:44'),
(48, 'password_change_failed', 'Failed password change attempt for user ID: 8', 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:35:14'),
(49, 'password_changed', 'Password changed for user ID: 8', 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:35:43'),
(50, 'user_login_failed', 'Failed user login attempt: testusertest@gmail.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:36:47'),
(51, 'user_login_success', 'User logged in: testusertest@gmail.com', 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:37:01'),
(52, 'admin_login_failed', 'Failed admin login attempt: admintest@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:39:00'),
(53, 'admin_login_failed', 'Failed admin login attempt: admintest@email.com', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:39:16'),
(54, 'admin_login_success', 'Admin logged in: admintest@email.com', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 06:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `site_analytics`
--

CREATE TABLE `site_analytics` (
  `analytics_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `page_views` int(11) DEFAULT 0,
  `unique_visitors` int(11) DEFAULT 0,
  `new_users` int(11) DEFAULT 0,
  `newsletter_signups` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `offer_id` int(11) NOT NULL,
  `offer_title` varchar(255) DEFAULT 'SPECIAL OFFERS',
  `image_path` varchar(500) NOT NULL,
  `offer_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_offers`
--

INSERT INTO `special_offers` (`offer_id`, `offer_title`, `image_path`, `offer_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'SPECIAL OFFERS', '../resources/img/HOMEPAGE/monthlyspecials/special1.jpg', 1, 1, '2025-11-23 05:54:49', '2025-11-23 05:54:49'),
(2, 'SPECIAL OFFERS', '../resources/img/HOMEPAGE/monthlyspecials/special2.png', 2, 1, '2025-11-23 05:54:49', '2025-11-23 05:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_avatar` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `password`, `user_avatar`, `created_at`) VALUES
(4, 'Nathaniel', 'natnatsmy@gmail.com', '$2y$12$metNI9AcLLbpp6feeD7ReOSxlfiCCdl72ca0ld17705.rZLsHB/T6', NULL, '2025-11-23 06:51:21'),
(7, 'User', 'user@gmail.com', '$2y$12$1UCcupmeSWIfXTtPMHPV/eGQTffJQ1NefANU526CVlJ3UR23nXYqG', NULL, '2025-11-24 03:34:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `idx_user_email` (`user_email`);

--
-- Indexes for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `business_info`
--
ALTER TABLE `business_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `encrypted_data`
--
ALTER TABLE `encrypted_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_data_type` (`data_type`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_identifier` (`identifier`),
  ADD KEY `idx_attempt_time` (`attempt_time`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `newsletters_sent`
--
ALTER TABLE `newsletters_sent`
  ADD PRIMARY KEY (`newsletter_id`),
  ADD KEY `sent_by` (`sent_by`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`content_id`),
  ADD UNIQUE KEY `page_section` (`page_name`,`section_name`);

--
-- Indexes for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_otp` (`user_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `photo_wall`
--
ALTER TABLE `photo_wall`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `security_log`
--
ALTER TABLE `security_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_event_type` (`event_type`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `site_analytics`
--
ALTER TABLE `site_analytics`
  ADD PRIMARY KEY (`analytics_id`),
  ADD UNIQUE KEY `visit_date` (`visit_date`);

--
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `idx_user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `encrypted_data`
--
ALTER TABLE `encrypted_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `newsletters_sent`
--
ALTER TABLE `newsletters_sent`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `page_content`
--
ALTER TABLE `page_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `photo_wall`
--
ALTER TABLE `photo_wall`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `security_log`
--
ALTER TABLE `security_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `site_analytics`
--
ALTER TABLE `site_analytics`
  MODIFY `analytics_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD CONSTRAINT `admin_activity_log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `encrypted_data`
--
ALTER TABLE `encrypted_data`
  ADD CONSTRAINT `encrypted_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `newsletters_sent`
--
ALTER TABLE `newsletters_sent`
  ADD CONSTRAINT `newsletters_sent_ibfk_1` FOREIGN KEY (`sent_by`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  ADD CONSTRAINT `password_reset_otps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `cleanup_login_attempts` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-23 15:12:34' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 7 DAY)$$

CREATE DEFINER=`root`@`localhost` EVENT `cleanup_security_logs` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-23 15:12:34' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM security_log WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY)$$

CREATE DEFINER=`root`@`localhost` EVENT `cleanup_expired_otps` ON SCHEDULE EVERY 1 HOUR STARTS '2025-11-23 15:26:18' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM password_reset_otps WHERE expires_at < NOW() OR (used = 1 AND created_at < DATE_SUB(NOW(), INTERVAL 1 DAY))$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
