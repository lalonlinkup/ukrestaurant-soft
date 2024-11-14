-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2024 at 02:34 PM
-- Server version: 8.0.40-cll-lve
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pintusof_ukrestaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_pages`
--

CREATE TABLE `about_pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_description` text,
  `description` longtext,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `about_pages`
--

INSERT INTO `about_pages` (`id`, `title`, `short_description`, `description`, `image`, `status`, `updated_by`, `created_at`, `updated_at`, `last_update_ip`) VALUES
(1, 'We invite you to experience the culinary delights of our restaurant.', 'Welcome to our restaurant, an exquisite dining establishment nestled in the heart of the UK. We are dedicated to delivering a remarkable culinary experience that harmoniously blends the finest elements of British cuisine with international influences.', '<p>Welcome to our restaurant, an exquisite dining establishment nestled in the heart of the UK. We are dedicated to delivering a remarkable culinary experience that harmoniously blends the finest elements of British cuisine with international influences. Our meticulously crafted menu showcases a selection of dishes prepared with the freshest, locally sourced ingredients, ensuring each plate is a celebration of flavor and artistry. Whether you are indulging in a sumptuous breakfast, enjoying a leisurely lunch, or savoring an elegant dinner, our attentive staff is committed to providing unparalleled service in a sophisticated yet inviting atmosphere. Join us at a restaurant and allow us to elevate your dining experience to new heights.<br>We look forward to welcoming you.</p>', 'uploads/about/Welcome To Uk Restaurent_67342ea51fbdb.jpg', 'a', 1, '2024-11-12 05:40:48', '2024-11-13 06:44:43', '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `origin` varchar(40) DEFAULT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint NOT NULL DEFAULT '0' COMMENT '0 = false, 1 = true',
  `is_serial` tinyint NOT NULL DEFAULT '0' COMMENT '0 = false, 1 = true',
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `type` varchar(40) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(40) NOT NULL,
  `initial_balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `bank_account_id` bigint UNSIGNED NOT NULL,
  `note` text,
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `checkin_date` datetime NOT NULL,
  `checkout_date` datetime NOT NULL,
  `days` int NOT NULL DEFAULT '0',
  `unit_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `checkout_status` char(5) NOT NULL DEFAULT 'false' COMMENT 'true, false',
  `booking_status` varchar(20) NOT NULL DEFAULT 'booked' COMMENT 'booked, checkin',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_masters`
--

CREATE TABLE `booking_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `date` varchar(20) NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `is_other` varchar(5) NOT NULL DEFAULT 'false',
  `others_member` int NOT NULL DEFAULT '0',
  `subtotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `vat` decimal(8,2) NOT NULL DEFAULT '0.00',
  `vatAmount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `advance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `due` decimal(8,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `description` text,
  `in_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `out_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Ac', 'ac', 'a', 1, NULL, '2024-11-12 05:40:48', NULL, NULL, NULL, '127.0.0.1'),
(2, 'Non Ac', 'non-ac', 'a', 1, NULL, '2024-11-12 05:40:48', NULL, NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `title` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` text,
  `map_link` text,
  `facebook` varchar(191) DEFAULT NULL,
  `instagram` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `youtube` varchar(191) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'BDT',
  `print_type` int NOT NULL DEFAULT '1',
  `logo` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `saturday` varchar(191) DEFAULT NULL,
  `sunday` varchar(191) DEFAULT NULL,
  `monday` varchar(191) DEFAULT NULL,
  `tuesday` varchar(191) DEFAULT NULL,
  `wednesday` varchar(191) DEFAULT NULL,
  `thursday` varchar(191) DEFAULT NULL,
  `friday` varchar(191) DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `name`, `title`, `phone`, `email`, `address`, `map_link`, `facebook`, `instagram`, `twitter`, `youtube`, `currency`, `print_type`, `logo`, `favicon`, `saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `last_update_ip`, `created_at`, `updated_at`) VALUES
(1, 'Uk Restaurent', 'Uk Restaurent', '02-47119444', 'Uk_Restaurent@gmail.com', 'Block C Street 6 London, United Kingdom', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39726.64471507735!2d-0.18021845839404502!3d51.51476999718395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604cdfbaa7b7d%3A0x9907775db94906db!2sTGI%20Fridays%20-%20Leicester%20Square!5e0!3m2!1sbn!2sbd!4v1731538107666!5m2!1sbn!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://ukrestaurantweb.pintusoft.com/', 'https://ukrestaurantweb.pintusoft.com/', 'https://ukrestaurantweb.pintusoft.com/', 'https://ukrestaurantweb.pintusoft.com/', 'BDT', 1, 'uploads/logo/_6732eae4b31f7.png', 'uploads/favicon/_67347e75db7f3.png', '9am - 10pm', '9am - 10pm', '9am - 10pm', '9am - 10pm', '9am - 10pm', '9am - 10pm', 'Closed', '127.0.0.1', '2024-11-12 05:40:48', '2024-11-13 10:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` int NOT NULL DEFAULT '0' COMMENT '0 = Not Read , 1 = Read',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `previous_due` decimal(8,2) NOT NULL DEFAULT '0.00',
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `code`, `name`, `phone`, `email`, `nid`, `gender`, `previous_due`, `district_id`, `reference_id`, `address`, `image`, `password`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'C00001', 'Alamin Miah', '01751515151', NULL, NULL, NULL, 0.00, NULL, NULL, 'Mirpur-2', NULL, NULL, 'a', 1, NULL, '2024-11-06 06:06:49', '2024-11-06 06:06:49', NULL, NULL, '127.0.0.1'),
(2, 'C00002', 'Lalon Hossain', '01414141414', NULL, NULL, NULL, 0.00, NULL, NULL, 'Mirpur-10, Dhaka', NULL, NULL, 'a', 1, NULL, '2024-11-06 22:46:48', '2024-11-06 22:46:48', NULL, NULL, '127.0.0.1'),
(3, 'C00003', 'Mahi Alam', '01784522156', NULL, NULL, NULL, 0.00, NULL, NULL, 'Mirpur', NULL, NULL, 'a', 1, NULL, '2024-11-12 05:52:59', '2024-11-12 05:52:59', NULL, NULL, '127.0.0.1'),
(4, 'C00004', 'Tesdyhfg', '456456', NULL, NULL, NULL, 0.00, NULL, NULL, '45645', NULL, NULL, 'a', 1, NULL, '2024-11-12 06:09:08', '2024-11-12 06:09:08', NULL, NULL, '127.0.0.1'),
(5, 'C00005', 'fghhgj', '57567', NULL, NULL, NULL, 0.00, NULL, NULL, '567567', NULL, NULL, 'a', 1, NULL, '2024-11-12 06:09:40', '2024-11-12 06:09:40', NULL, NULL, '127.0.0.1'),
(6, 'C00006', 'Pintu', '01743134075', 'pintu.srsidea@gmail.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '$2y$10$VPjWuMr1rkkhssNpZpSvmeg/VTTYhK3HwhCV824Q8QhLpiSZJaYca', 'a', 1, NULL, '2024-11-13 09:11:38', '2024-11-13 09:11:38', NULL, NULL, '103.137.229.132'),
(7, 'C00007', 'Linkup Mahi', '01619833307', 'mahi@gmail.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '$2y$10$oPOC.LOCLyJ3Jg0wuk8o2OvJd0mg2q/zSv.eXIzt2SdR4j8LE3MSK', 'a', 1, NULL, '2024-11-14 06:22:14', '2024-11-14 06:22:14', NULL, NULL, '103.159.73.82'),
(8, 'C00008', 'Lalon Hossain', '01781325634', 'lalonhossain@gmail.com', NULL, NULL, 0.00, NULL, NULL, NULL, 'uploads/user/1731566122.jpg', '$2y$10$11ub5ezl/8TPlWGhtOng6.a5HrXd8M25HondEk/Gjcb.dR9A12nBy', 'a', 1, NULL, '2024-11-14 06:34:59', '2024-11-14 06:35:22', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `type` char(5) NOT NULL COMMENT 'CP = Payment, CR = Receive',
  `method` varchar(10) NOT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `previous_due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `invoice`, `date`, `customer_id`, `order_id`, `type`, `method`, `bank_account_id`, `discount`, `discountAmount`, `amount`, `previous_due`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'TR00001', '2024-11-12', 3, 1, 'CR', 'cash', NULL, 0.00, 0.00, 1080.00, 1080.00, '1080.00', 'a', 1, NULL, '2024-11-12 05:53:36', '2024-11-12 05:53:36', NULL, NULL, '127.0.0.1'),
(2, 'TR00002', '2024-11-12', 5, 5, 'CR', 'cash', NULL, 0.00, 0.00, 500.00, 500.00, 'Tet', 'a', 1, NULL, '2024-11-12 06:27:48', '2024-11-12 06:27:48', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Admin', 'a', 1, NULL, '2024-11-06 05:17:44', '2024-11-06 05:17:44', NULL, NULL, '127.0.0.1'),
(2, 'Support', 'a', 1, NULL, '2024-11-06 05:20:33', '2024-11-06 05:20:33', NULL, NULL, '127.0.0.1'),
(3, 'Marketing', 'a', 1, NULL, '2024-11-06 05:20:38', '2024-11-06 05:20:38', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Admin', 'a', 1, NULL, '2024-11-06 05:17:38', '2024-11-06 05:17:38', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `disposals`
--

CREATE TABLE `disposals` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposal_details`
--

CREATE TABLE `disposal_details` (
  `id` bigint UNSIGNED NOT NULL,
  `disposal_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `disposal_status` varchar(40) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Mirpur-10', 'a', 1, NULL, '2024-11-12 05:43:52', '2024-11-12 05:43:52', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `bio_id` varchar(20) DEFAULT NULL,
  `joining` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `nid_no` varchar(20) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `father_name` varchar(191) NOT NULL,
  `mother_name` varchar(191) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `salary` decimal(8,2) NOT NULL DEFAULT '0.00',
  `reference` varchar(60) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `code`, `name`, `designation_id`, `department_id`, `bio_id`, `joining`, `gender`, `dob`, `nid_no`, `phone`, `email`, `marital_status`, `father_name`, `mother_name`, `present_address`, `permanent_address`, `image`, `salary`, `reference`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'E00001', 'M Lalon', 1, 1, '1001', '2022-11-06', 'Male', '1990-11-06', NULL, '019########', 'Uk_Restaurent@gmail.com', 'married', 'Test FN', 'Test MN', 'Test PA', 'Test PRA', 'uploads/employee/E00001_672b50e234f94.jpg', 100000.00, 'Test Reference', 'a', 1, NULL, '2024-11-06 05:20:02', '2024-11-06 05:20:02', NULL, NULL, '127.0.0.1'),
(2, 'E00002', 'M Mahi Alam', 1, 2, '1002', '2023-11-06', 'Male', '2000-11-06', NULL, '017########', 'Uk_Restaurent@gmail.com', 'married', 'Test FN', 'Test MN', 'Test T', 'Test T', NULL, 999999.99, 'Test Ref', 'a', 1, NULL, '2024-11-06 05:21:36', '2024-11-06 05:21:36', NULL, NULL, '127.0.0.1'),
(3, 'E00003', 'M Shamim Hawlader', 1, 2, '1003', '2020-11-25', 'Male', '1999-12-12', NULL, '016########', 'Uk_Restaurent@gmail.com', 'married', 'Test FN', 'Test MN', 'Test T', 'Test T', NULL, 215400.00, 'Test Ref', 'a', 1, NULL, '2024-11-06 05:22:26', '2024-11-06 05:22:26', NULL, NULL, '127.0.0.1'),
(4, 'E00004', 'M Shuvo Sheikh', 1, 3, '1004', '2022-02-02', 'Male', '1967-12-15', NULL, '015########', 'Uk_Restaurent@gmail.com', 'married', 'Test FN', 'Test MN', 'Test T', 'Test T', NULL, 152540.00, 'Test Ref', 'a', 1, NULL, '2024-11-06 05:24:14', '2024-11-06 05:24:14', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payments`
--

CREATE TABLE `employee_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(20) NOT NULL,
  `total_employee` int NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_payment_details`
--

CREATE TABLE `employee_payment_details` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_payment_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `salary` decimal(8,2) NOT NULL DEFAULT '0.00',
  `benefit` decimal(8,2) NOT NULL DEFAULT '0.00',
  `deduction` decimal(8,2) NOT NULL DEFAULT '0.00',
  `net_payable` decimal(8,2) NOT NULL DEFAULT '0.00',
  `payment` decimal(8,2) NOT NULL DEFAULT '0.00',
  `comment` varchar(150) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `position` int NOT NULL DEFAULT '1',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `position`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '1st Floor', 1, 'a', 1, NULL, '2024-11-12 05:44:20', '2024-11-12 05:44:20', NULL, NULL, '127.0.0.1'),
(2, '2nd Floor', 1, 'a', 1, NULL, '2024-11-12 05:44:25', '2024-11-12 05:44:25', NULL, NULL, '127.0.0.1'),
(3, '3rd Floor', 1, 'a', 1, NULL, '2024-11-12 05:44:31', '2024-11-12 05:44:31', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `type`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, NULL, NULL, 'uploads/gallery/_673430312802b.jpg', 'a', 1, NULL, '2024-11-13 04:50:57', '2024-11-13 04:50:57', NULL, NULL, '103.137.229.132'),
(2, NULL, NULL, 'uploads/gallery/_6734638b131eb.jpg', 'a', 1, NULL, '2024-11-13 08:30:03', '2024-11-13 08:30:03', NULL, NULL, '103.159.73.82'),
(3, NULL, NULL, 'uploads/gallery/_67346393172ef.jpg', 'a', 1, NULL, '2024-11-13 08:30:11', '2024-11-13 08:30:11', NULL, NULL, '103.159.73.82'),
(4, NULL, NULL, 'uploads/gallery/_6734639cb7ef7.jpg', 'a', 1, NULL, '2024-11-13 08:30:20', '2024-11-13 08:30:20', NULL, NULL, '103.159.73.82'),
(5, NULL, NULL, 'uploads/gallery/_673463ac65a7a.jpg', 'a', 1, NULL, '2024-11-13 08:30:36', '2024-11-13 08:30:36', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `investment_accounts`
--

CREATE TABLE `investment_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_transactions`
--

CREATE TABLE `investment_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `investment_account_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(18,3) NOT NULL DEFAULT '0.000',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `issue_to` varchar(60) NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` double(8,2) NOT NULL DEFAULT '0.00',
  `vatAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount` double(8,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_details`
--

CREATE TABLE `issue_details` (
  `id` bigint UNSIGNED NOT NULL,
  `issue_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_returns`
--

CREATE TABLE `issue_returns` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `leave_type_id` bigint UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `days` int NOT NULL,
  `reason` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `days` int NOT NULL DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_accounts`
--

CREATE TABLE `loan_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `type` varchar(40) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(60) DEFAULT NULL,
  `initial_balance` decimal(18,3) NOT NULL DEFAULT '0.000',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

CREATE TABLE `loan_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `loan_account_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(18,3) NOT NULL DEFAULT '0.000',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `address` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `unit_id`, `price`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Beef', 1, 100.00, 'uploads/material/_672b589ecd49f.jpg', 'a', 1, 1, '2024-11-01 22:23:25', '2024-11-06 05:53:02', NULL, NULL, '127.0.0.1'),
(2, 'Powder Milk', 2, 395.00, 'uploads/material/_672b5873e3cee.jpg', 'a', 1, 1, '2024-11-01 22:27:17', '2024-11-06 05:52:19', NULL, NULL, '127.0.0.1'),
(4, 'Rice', 2, 72.00, NULL, 'a', 1, NULL, '2024-11-13 08:52:55', '2024-11-13 08:52:55', NULL, NULL, '103.159.73.82'),
(5, 'flour', 2, 40.00, NULL, 'a', 1, NULL, '2024-11-13 08:53:06', '2024-11-13 08:53:06', NULL, NULL, '103.159.73.82'),
(6, 'tomatoes', 2, 50.00, NULL, 'a', 1, NULL, '2024-11-13 08:53:47', '2024-11-13 08:53:47', NULL, NULL, '103.159.73.82'),
(7, 'Salt', 2, 40.00, NULL, 'a', 1, NULL, '2024-11-13 08:54:25', '2024-11-13 08:54:25', NULL, NULL, '103.159.73.82'),
(8, 'onion', 2, 45.00, NULL, 'a', 1, NULL, '2024-11-13 08:54:40', '2024-11-13 08:54:40', NULL, NULL, '103.159.73.82'),
(9, 'Sugar', 2, 75.00, NULL, 'a', 1, NULL, '2024-11-13 08:55:20', '2024-11-13 08:55:20', NULL, NULL, '103.159.73.82'),
(10, 'Egg', 1, 12.00, NULL, 'a', 1, NULL, '2024-11-13 08:55:54', '2024-11-13 08:55:54', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `material_purchases`
--

CREATE TABLE `material_purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `subtotal` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` double(8,2) NOT NULL DEFAULT '0.00',
  `vatAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount` double(8,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `transport` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `previous_due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_purchase_details`
--

CREATE TABLE `material_purchase_details` (
  `id` bigint UNSIGNED NOT NULL,
  `material_purchase_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `menu_category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `vat` double(8,2) NOT NULL DEFAULT '0.00',
  `purchase_rate` decimal(18,2) NOT NULL DEFAULT '0.00',
  `sale_rate` decimal(18,2) NOT NULL DEFAULT '0.00',
  `wholesale_rate` decimal(18,2) NOT NULL DEFAULT '0.00',
  `is_service` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `code`, `menu_category_id`, `name`, `slug`, `unit_id`, `vat`, `purchase_rate`, `sale_rate`, `wholesale_rate`, `is_service`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'M00001', 9, 'Grilled Beef with potatoes', 'grilled-beef-with-potatoes', 1, 0.00, 0.00, 500.00, 0.00, 0, 'uploads/menu/M00001_6725fde02961d.jpg', 'a', 1, NULL, '2024-11-01 22:24:32', '2024-11-01 22:25:02', NULL, NULL, '127.0.0.1'),
(2, 'M00002', 10, 'Strawberry Juice', 'strawberry-juice', 1, 0.00, 0.00, 80.00, 0.00, 0, NULL, 'a', 1, NULL, '2024-11-01 22:29:50', '2024-11-01 22:29:50', NULL, NULL, '127.0.0.1'),
(3, 'M00003', 9, 'test', 'test', 1, 0.00, 0.00, 0.00, 0.00, 0, 'uploads/menu/M00003_6725ffde35482.jpg', 'd', 1, NULL, '2024-11-01 22:33:02', '2024-11-13 05:21:50', 1, '2024-11-13 05:21:50', '103.137.229.132'),
(4, 'M00004', 11, 'test1', 'test1', 1, 0.00, 0.00, 5.00, 0.00, 0, NULL, 'd', 1, NULL, '2024-11-01 22:34:28', '2024-11-13 05:22:00', 1, '2024-11-13 05:22:00', '103.137.229.132'),
(5, 'M00005', 10, 'House Wine (Red or White)', 'house-wine-(red-or-white)', 4, 0.00, 0.00, 5.50, 0.00, 0, 'uploads/menu/M00005_6734328f6376c.jpg', 'a', 1, NULL, '2024-11-13 05:01:03', '2024-11-13 05:01:03', NULL, NULL, '103.137.229.132'),
(6, 'M00006', 10, 'Craft Beer', 'craft-beer', 4, 0.00, 0.00, 4.50, 0.00, 0, 'uploads/menu/M00006_673432dc99872.jpg', 'a', 1, NULL, '2024-11-13 05:02:20', '2024-11-13 05:02:20', NULL, NULL, '103.137.229.132'),
(7, 'M00007', 11, 'Chocolate Pudding', 'chocolate-pudding', 1, 0.00, 0.00, 6.50, 0.00, 0, 'uploads/menu/M00007_673433400d27a.jpg', 'a', 1, 1, '2024-11-13 05:04:00', '2024-11-13 09:23:16', NULL, NULL, '103.159.73.82'),
(8, 'M00008', 11, 'Chocolate Fondant', 'chocolate-fondant', 1, 0.00, 0.00, 7.00, 0.00, 0, 'uploads/menu/M00008_673433910734c.jpg', 'a', 1, 1, '2024-11-13 05:05:21', '2024-11-13 09:22:36', NULL, NULL, '103.159.73.82'),
(9, 'M00009', 11, 'Cheese Board', 'cheese-board', 1, 0.00, 0.00, 9.00, 0.00, 0, 'uploads/menu/M00009_673433e252854.jpg', 'a', 1, 1, '2024-11-13 05:06:42', '2024-11-13 09:22:24', NULL, NULL, '103.159.73.82'),
(10, 'M00010', 9, 'Fish and Chips', 'fish-and-chips', 1, 0.00, 0.00, 14.95, 0.00, 0, 'uploads/menu/M00010_673434429ba48.jpg', 'a', 1, 1, '2024-11-13 05:08:18', '2024-11-13 09:22:11', NULL, NULL, '103.159.73.82'),
(11, 'M00011', 9, 'Chicken Tikka Masala', 'chicken-tikka-masala', 1, 0.00, 0.00, 12.50, 0.00, 0, 'uploads/menu/M00011_673434946c9f6.jpg', 'a', 1, 1, '2024-11-13 05:09:40', '2024-11-13 09:22:03', NULL, NULL, '103.159.73.82'),
(12, 'M00012', 9, 'Sandwich With Vegetable Cream', 'sandwich-with-vegetable-cream', 1, 0.00, 0.00, 11.00, 0.00, 0, 'uploads/menu/M00012_673434dfb7b55.jpg', 'a', 1, 1, '2024-11-13 05:10:55', '2024-11-13 09:21:53', NULL, NULL, '103.159.73.82'),
(13, 'M00013', 9, 'Beef Steak', 'beef-steak', 1, 0.00, 0.00, 22.00, 0.00, 0, 'uploads/menu/M00013_6734354f0a412.jpg', 'a', 1, 1, '2024-11-13 05:12:47', '2024-11-13 09:21:29', NULL, NULL, '103.159.73.82'),
(14, 'M00014', 12, 'Italian creamy pasta', 'italian-creamy-pasta', 1, 0.00, 0.00, 10.95, 0.00, 0, 'uploads/menu/M00014_673435c720334.jpg', 'a', 1, 1, '2024-11-13 05:14:47', '2024-11-13 09:21:14', NULL, NULL, '103.159.73.82'),
(15, 'M00015', 12, 'Creamy Pasta', 'creamy-pasta', 1, 0.00, 0.00, 11.50, 0.00, 0, 'uploads/menu/M00015_67343633647c6.jpg', 'a', 1, 1, '2024-11-13 05:16:35', '2024-11-13 09:20:59', NULL, NULL, '103.159.73.82'),
(16, 'M00016', 12, 'Chicken Pizza', 'chicken-pizza', 1, 0.00, 0.00, 8.50, 0.00, 0, 'uploads/menu/M00016_673437af67637.jpg', 'a', 1, 1, '2024-11-13 05:17:37', '2024-11-13 09:20:50', NULL, NULL, '103.159.73.82'),
(17, 'M00017', 12, 'Pizza', 'pizza', 1, 0.00, 0.00, 6.00, 0.00, 0, 'uploads/menu/M00017_673436bed8fd8.jpg', 'a', 1, 1, '2024-11-13 05:18:54', '2024-11-13 09:20:37', NULL, NULL, '103.159.73.82'),
(18, 'M00018', 12, 'Naga Burger', 'naga-burger', 1, 0.00, 0.00, 7.50, 0.00, 0, 'uploads/menu/M00018_6734370367def.jpg', 'a', 1, 1, '2024-11-13 05:20:03', '2024-11-13 09:20:31', NULL, NULL, '103.159.73.82'),
(19, 'M00019', 12, 'Burger', 'burger', 1, 0.00, 0.00, 5.50, 0.00, 0, 'uploads/menu/M00019_6734375108774.jpg', 'a', 1, 1, '2024-11-13 05:21:21', '2024-11-13 09:20:22', NULL, NULL, '103.159.73.82'),
(20, 'M00020', 10, 'Black Coffee', 'black-coffee', 1, 0.00, 0.00, 15.00, 0.00, 0, 'uploads/menu/M00020_67347043e3834.jpg', 'a', 1, NULL, '2024-11-13 09:24:19', '2024-11-13 09:24:19', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `image`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(9, 'Main', 'uploads/category/Main_6725fd3738302.png', 'main', 'a', 1, 1, '2024-11-01 22:17:12', '2024-11-01 22:21:43', NULL, NULL, '127.0.0.1'),
(10, 'Drinks', 'uploads/category/Drinks_6725fd18a6153.png', 'drinks', 'a', 1, NULL, '2024-11-01 22:21:12', '2024-11-01 22:21:12', NULL, NULL, '127.0.0.1'),
(11, 'Desert', 'uploads/category/Desert_6725fd301b618.png', 'desert', 'a', 1, NULL, '2024-11-01 22:21:36', '2024-11-01 22:21:36', NULL, NULL, '127.0.0.1'),
(12, 'Breakfast', 'uploads/category/Breakfast_67346b988f2e9.png', 'breakfast', 'a', 1, 1, '2024-11-06 06:04:08', '2024-11-13 09:04:24', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_05_11_163144_create_company_profiles_table', 1),
(5, '2024_05_11_163919_create_user_activities_table', 1),
(6, '2024_05_11_163938_create_user_accesses_table', 1),
(7, '2024_05_14_105132_create_table_types_table', 1),
(8, '2024_05_14_105235_create_categories_table', 1),
(9, '2024_05_14_105444_create_districts_table', 1),
(10, '2024_05_14_105445_create_floors_table', 1),
(11, '2024_05_23_114157_create_departments_table', 1),
(12, '2024_05_23_114437_create_designations_table', 1),
(13, '2024_05_23_114453_create_employees_table', 1),
(14, '2024_05_23_122245_create_employee_payments_table', 1),
(15, '2024_05_23_122308_create_employee_payment_details_table', 1),
(16, '2024_05_23_154449_create_references_table', 1),
(17, '2024_05_23_154450_create_customers_table', 1),
(18, '2024_05_23_162607_create_suppliers_table', 1),
(19, '2024_05_25_142744_create_booking_masters_table', 1),
(20, '2024_05_25_143009_create_booking_details_table', 1),
(21, '2024_05_25_150501_create_other_customers_table', 1),
(22, '2024_05_25_154620_create_accounts_table', 1),
(23, '2024_05_25_154649_create_bank_accounts_table', 1),
(24, '2024_05_25_154748_create_cash_transactions_table', 1),
(25, '2024_05_25_154809_create_bank_transactions_table', 1),
(26, '2024_05_25_154924_create_supplier_payments_table', 1),
(27, '2024_06_03_113601_create_menu_categories_table', 1),
(28, '2024_06_03_130029_create_units_table', 1),
(29, '2024_06_03_144652_create_menus_table', 1),
(30, '2024_06_03_180722_create_orders_table', 1),
(31, '2024_06_03_180755_create_order_details_table', 1),
(32, '2024_06_10_161434_create_service_heads_table', 1),
(33, '2024_06_22_131752_create_leave_types_table', 1),
(34, '2024_06_24_120604_create_leaves_table', 1),
(35, '2024_06_25_122143_create_brands_table', 1),
(36, '2024_06_25_123617_create_assets_table', 1),
(37, '2024_06_25_164312_create_purchases_table', 1),
(38, '2024_06_25_171307_create_purchase_details_table', 1),
(39, '2024_06_26_160450_create_services_table', 1),
(40, '2024_06_30_115153_create_purchase_returns_table', 1),
(41, '2024_07_03_145016_create_issues_table', 1),
(42, '2024_07_03_145218_create_issue_details_table', 1),
(43, '2024_07_07_145152_create_investment_accounts_table', 1),
(44, '2024_07_07_145313_create_investment_transactions_table', 1),
(45, '2024_07_07_154443_create_loan_accounts_table', 1),
(46, '2024_07_07_160520_create_loan_transactions_table', 1),
(47, '2024_07_09_143312_create_galleries_table', 1),
(48, '2024_07_09_152214_create_manages_table', 1),
(49, '2024_07_09_161753_create_about_pages_table', 1),
(50, '2024_07_10_122552_create_issue_returns_table', 1),
(51, '2024_07_11_104600_create_sliders_table', 1),
(52, '2024_07_13_155600_create_offers_table', 1),
(53, '2024_07_14_161807_create_materials_table', 1),
(54, '2024_07_15_144652_create_recipes_table', 1),
(55, '2024_07_16_163239_create_productions_table', 1),
(56, '2024_07_16_164334_create_production_details_table', 1),
(57, '2024_07_25_142447_create_material_purchases_table', 1),
(58, '2024_07_25_142923_create_material_purchase_details_table', 1),
(59, '2024_07_29_154051_create_disposals_table', 1),
(60, '2024_07_29_155301_create_disposal_details_table', 1),
(61, '2024_10_31_155147_create_specialties_table', 1),
(62, '2024_11_02_140626_create_specialtie_banners_table', 1),
(63, '2024_11_02_140644_create_tables_table', 1),
(64, '2024_11_04_163450_create_table_bookings_table', 1),
(65, '2024_11_06_123933_create_customer_payments_table', 1),
(66, '2024_11_06_123959_create_contacts_table', 1),
(67, '2024_11_06_123985_create_order_tables_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(60) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` text,
  `table_id` bigint UNSIGNED DEFAULT NULL,
  `sub_total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `charge` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `cashPaid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `bankPaid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `returnAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `order_type` varchar(55) NOT NULL DEFAULT 'PayFirst',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice`, `date`, `customer_id`, `customer_name`, `customer_phone`, `customer_address`, `table_id`, `sub_total`, `charge`, `discount`, `vat`, `total`, `cashPaid`, `bankPaid`, `bank_account_id`, `returnAmount`, `paid`, `due`, `note`, `order_type`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'O2400001', '2024-11-12', 3, NULL, NULL, NULL, 2, 1080.00, 0.00, 0.00, 0.00, 1080.00, 1080.00, 0.00, NULL, 0.00, 1080.00, 1080.00, NULL, 'Order', 'a', 1, 1, '2024-11-12 05:52:59', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(2, 'O2400002', '2024-11-12', 4, NULL, NULL, NULL, 3, 1500.00, 0.00, 0.00, 0.00, 1500.00, 2000.00, 0.00, NULL, 0.00, 0.00, 1500.00, 'dfhgghj', 'Order', 'a', 1, 1, '2024-11-12 06:09:08', '2024-11-12 06:09:16', NULL, NULL, '127.0.0.1'),
(3, 'O2400003', '2024-11-12', 5, NULL, NULL, NULL, 3, 2000.00, 0.00, 0.00, 0.00, 2000.00, 2000.00, 0.00, NULL, 0.00, 2000.00, 0.00, NULL, 'Order', 'a', 1, 1, '2024-11-12 06:09:40', '2024-11-12 06:16:19', NULL, NULL, '127.0.0.1'),
(4, 'O2400004', '2024-11-12', 3, NULL, NULL, NULL, 4, 1500.00, 0.00, 0.00, 0.00, 1500.00, 500.00, 0.00, NULL, 0.00, 500.00, 1000.00, NULL, 'Order', 'a', 1, 1, '2024-11-12 06:22:53', '2024-11-12 06:23:05', NULL, NULL, '127.0.0.1'),
(5, 'O2400005', '2024-11-12', 5, NULL, NULL, NULL, 2, 1500.00, 0.00, 0.00, 0.00, 1500.00, 1000.00, 0.00, NULL, 0.00, 1000.00, 500.00, NULL, 'Order', 'a', 1, 1, '2024-11-12 06:27:16', '2024-11-12 06:27:27', NULL, NULL, '127.0.0.1'),
(6, 'O2400006', '2024-11-13', NULL, 'Cash Customer', NULL, NULL, 2, 45.50, 0.00, 0.00, 0.00, 45.50, 45.50, 0.00, NULL, 0.00, 45.50, 0.00, NULL, 'Order', 'a', 1, 1, '2024-11-13 06:05:40', '2024-11-13 06:06:45', NULL, NULL, '103.159.73.82'),
(7, 'O2400007', '2024-11-13', NULL, 'Cash Customer', NULL, NULL, 2, 13.00, 0.00, 0.00, 0.00, 13.00, 13.00, 0.00, NULL, 0.00, 13.00, 0.00, NULL, 'Order', 'a', 1, 1, '2024-11-13 06:13:02', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(8, 'O2400008', '2024-11-13', 6, 'Pintu', '+88-01743134075', 'dhaka', NULL, 6.50, 70.00, 0.00, 0.00, 76.50, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, 'PayFirst', 'p', NULL, NULL, '2024-11-13 09:12:12', '2024-11-13 09:12:12', NULL, NULL, '103.137.229.132'),
(9, 'O2400009', '2024-11-13', 6, 'Pintu', '+88-01743134075', 'dhaka', NULL, 7.00, 70.00, 0.00, 0.00, 77.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, 'PayFirst', 'p', NULL, NULL, '2024-11-13 09:15:56', '2024-11-13 09:15:56', NULL, NULL, '103.137.229.132'),
(10, 'O2400010', '2024-11-13', NULL, 'Cash Customer', NULL, NULL, 1, 31.45, 0.00, 0.00, 0.00, 31.45, 31.45, 0.00, NULL, 0.00, 31.45, 0.00, NULL, 'Order', 'a', 1, 1, '2024-11-13 11:55:39', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` decimal(18,2) NOT NULL DEFAULT '0.00',
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `menu_id`, `price`, `vat`, `quantity`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(4, 1, 2, 80.00, 0.00, 1.00, 80.00, 'a', 1, NULL, '2024-11-12 05:53:15', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(5, 1, 1, 500.00, 0.00, 2.00, 1000.00, 'a', 1, NULL, '2024-11-12 05:53:15', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(6, 1, 3, 0.00, 0.00, 2.00, 0.00, 'a', 1, NULL, '2024-11-12 05:53:15', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(8, 2, 1, 500.00, 0.00, 3.00, 1500.00, 'a', 1, NULL, '2024-11-12 06:09:16', '2024-11-12 06:09:16', NULL, NULL, '127.0.0.1'),
(11, 3, 1, 500.00, 0.00, 4.00, 2000.00, 'a', 1, NULL, '2024-11-12 06:16:19', '2024-11-12 06:16:19', NULL, NULL, '127.0.0.1'),
(13, 4, 1, 500.00, 0.00, 3.00, 1500.00, 'a', 1, NULL, '2024-11-12 06:23:05', '2024-11-12 06:23:05', NULL, NULL, '127.0.0.1'),
(15, 5, 1, 500.00, 0.00, 3.00, 1500.00, 'a', 1, NULL, '2024-11-12 06:27:27', '2024-11-12 06:27:27', NULL, NULL, '127.0.0.1'),
(24, 6, 6, 5.00, 0.00, 1.00, 4.50, 'a', 1, NULL, '2024-11-13 06:06:45', '2024-11-13 06:06:45', NULL, NULL, '103.159.73.82'),
(25, 6, 16, 9.00, 0.00, 2.00, 17.00, 'a', 1, NULL, '2024-11-13 06:06:45', '2024-11-13 06:06:45', NULL, NULL, '103.159.73.82'),
(26, 6, 17, 6.00, 0.00, 4.00, 24.00, 'a', 1, NULL, '2024-11-13 06:06:45', '2024-11-13 06:06:45', NULL, NULL, '103.159.73.82'),
(29, 7, 18, 8.00, 0.00, 1.00, 7.50, 'a', 1, NULL, '2024-11-13 09:03:50', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(30, 7, 19, 6.00, 0.00, 1.00, 5.50, 'a', 1, NULL, '2024-11-13 09:03:50', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(31, 8, 7, 6.50, 0.00, 1.00, 6.50, 'p', NULL, NULL, '2024-11-13 09:12:12', '2024-11-13 09:12:12', NULL, NULL, '103.137.229.132'),
(33, 9, 8, 7.00, 0.00, 1.00, 7.00, 'p', NULL, NULL, '2024-11-13 09:15:56', '2024-11-13 09:15:56', NULL, NULL, '103.137.229.132'),
(37, 10, 14, 11.00, 0.00, 1.00, 10.95, 'a', 1, NULL, '2024-11-13 11:55:51', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132'),
(38, 10, 19, 6.00, 0.00, 1.00, 5.50, 'a', 1, NULL, '2024-11-13 11:55:51', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132'),
(39, 10, 20, 15.00, 0.00, 1.00, 15.00, 'a', 1, NULL, '2024-11-13 11:55:51', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132');

-- --------------------------------------------------------

--
-- Table structure for table `order_tables`
--

CREATE TABLE `order_tables` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `incharge_id` bigint UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `booking_status` varchar(20) NOT NULL DEFAULT 'booked' COMMENT 'booked, available',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_customers`
--

CREATE TABLE `other_customers` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productions`
--

CREATE TABLE `productions` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productions`
--

INSERT INTO `productions` (`id`, `invoice`, `date`, `order_id`, `total`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'PR240001', '2024-11-12', 1, 100.00, 'Order production invoice -O2400001', 'a', 1, 1, '2024-11-12 05:52:59', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(2, 'PR240002', '2024-11-12', 1, 200.00, 'Order production invoice -O2400001', 'a', 1, NULL, '2024-11-12 05:52:59', '2024-11-12 05:52:59', NULL, NULL, '127.0.0.1'),
(3, 'PR240003', '2024-11-12', 1, 100.00, 'Order production invoice -O2400001', 'a', 1, NULL, '2024-11-12 05:52:59', '2024-11-12 05:52:59', NULL, NULL, '127.0.0.1'),
(4, 'PR240004', '2024-11-12', 2, 200.00, 'Order production invoice -O2400002', 'a', 1, 1, '2024-11-12 06:09:08', '2024-11-12 06:09:16', NULL, NULL, '127.0.0.1'),
(5, 'PR240005', '2024-11-12', 3, 200.00, 'Order production invoice -O2400003', 'a', 1, 1, '2024-11-12 06:09:40', '2024-11-12 06:16:19', NULL, NULL, '127.0.0.1'),
(6, 'PR240006', '2024-11-12', 4, 200.00, 'Order production invoice -O2400004', 'a', 1, 1, '2024-11-12 06:22:53', '2024-11-12 06:23:05', NULL, NULL, '127.0.0.1'),
(7, 'PR240007', '2024-11-12', 5, 200.00, 'Order production invoice -O2400005', 'a', 1, 1, '2024-11-12 06:27:16', '2024-11-12 06:27:27', NULL, NULL, '127.0.0.1'),
(8, 'PR240008', '2024-11-13', 6, 0.00, 'Order production invoice -O2400006', 'a', 1, 1, '2024-11-13 06:05:40', '2024-11-13 06:06:45', NULL, NULL, '103.159.73.82'),
(9, 'PR240009', '2024-11-13', 6, 0.00, 'Order production invoice -O2400006', 'a', 1, NULL, '2024-11-13 06:05:40', '2024-11-13 06:05:40', NULL, NULL, '103.159.73.82'),
(10, 'PR240010', '2024-11-13', 7, 2770.00, 'Order production invoice -O2400007', 'a', 1, 1, '2024-11-13 06:13:02', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(11, 'PR240011', '2024-11-13', 7, 0.00, 'Order production invoice -O2400007', 'a', 1, NULL, '2024-11-13 06:13:02', '2024-11-13 06:13:02', NULL, NULL, '103.159.73.82'),
(12, 'PR240012', '2024-11-13', 10, 208.75, 'Order production invoice -O2400010', 'a', 1, 1, '2024-11-13 11:55:39', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132'),
(13, 'PR240013', '2024-11-13', 10, 2770.00, 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132'),
(14, 'PR240014', '2024-11-13', 10, 208.75, 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132');

-- --------------------------------------------------------

--
-- Table structure for table `production_details`
--

CREATE TABLE `production_details` (
  `id` bigint UNSIGNED NOT NULL,
  `production_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `production_details`
--

INSERT INTO `production_details` (`id`, `production_id`, `material_id`, `quantity`, `price`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(2, 2, 1, 2.00, 100.00, 200.00, 'a', 1, NULL, '2024-11-12 05:52:59', '2024-11-12 05:52:59', NULL, NULL, '127.0.0.1'),
(3, 3, 1, 1.00, 100.00, 100.00, 'a', 1, NULL, '2024-11-12 05:52:59', '2024-11-12 05:52:59', NULL, NULL, '127.0.0.1'),
(6, 1, 1, 1.00, 100.00, 100.00, 'a', 1, NULL, '2024-11-12 05:53:15', '2024-11-12 05:53:15', NULL, NULL, '127.0.0.1'),
(8, 4, 1, 2.00, 100.00, 200.00, 'a', 1, NULL, '2024-11-12 06:09:16', '2024-11-12 06:09:16', NULL, NULL, '127.0.0.1'),
(11, 5, 1, 2.00, 100.00, 200.00, 'a', 1, NULL, '2024-11-12 06:16:19', '2024-11-12 06:16:19', NULL, NULL, '127.0.0.1'),
(13, 6, 1, 2.00, 100.00, 200.00, 'a', 1, NULL, '2024-11-12 06:23:05', '2024-11-12 06:23:05', NULL, NULL, '127.0.0.1'),
(15, 7, 1, 2.00, 100.00, 200.00, 'a', 1, NULL, '2024-11-12 06:27:27', '2024-11-12 06:27:27', NULL, NULL, '127.0.0.1'),
(17, 10, 1, 4.00, 100.00, 400.00, 'a', 1, NULL, '2024-11-13 09:03:50', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(18, 10, 2, 6.00, 395.00, 2370.00, 'a', 1, NULL, '2024-11-13 09:03:50', '2024-11-13 09:03:50', NULL, NULL, '103.137.229.132'),
(20, 13, 1, 4.00, 100.00, 400.00, 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132'),
(21, 13, 2, 6.00, 395.00, 2370.00, 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132'),
(22, 14, 9, 0.15, 75.00, 11.25, 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132'),
(23, 14, 2, 0.50, 395.00, 197.50, 'a', 1, NULL, '2024-11-13 11:55:39', '2024-11-13 11:55:39', NULL, NULL, '103.137.229.132'),
(27, 12, 9, 0.15, 75.00, 11.25, 'a', 1, NULL, '2024-11-13 11:55:51', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132'),
(28, 12, 2, 0.50, 395.00, 197.50, 'a', 1, NULL, '2024-11-13 11:55:51', '2024-11-13 11:55:51', NULL, NULL, '103.137.229.132');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `sub_total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` double(8,2) NOT NULL DEFAULT '0.00',
  `vatAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount` double(8,2) NOT NULL DEFAULT '0.00',
  `discountAmount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `transport` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `previous_due` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `warranty` double(8,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `quantity` double(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `menu_id`, `material_id`, `price`, `quantity`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, 100.00, 2.00, 200.00, 'a', 1, NULL, '2024-11-01 22:24:32', '2024-11-01 22:25:02', NULL, NULL, '127.0.0.1'),
(2, 2, 2, 395.00, 0.05, 19.75, 'a', 1, NULL, '2024-11-01 22:29:50', '2024-11-01 22:29:50', NULL, NULL, '127.0.0.1'),
(3, 3, 1, 100.00, 1.00, 100.00, 'd', 1, NULL, '2024-11-01 22:33:02', '2024-11-13 05:21:50', 1, '2024-11-13 05:21:50', '103.137.229.132'),
(4, 4, 2, 395.00, 0.50, 197.50, 'd', 1, NULL, '2024-11-01 22:34:28', '2024-11-13 05:22:00', 1, '2024-11-13 05:22:00', '103.137.229.132'),
(24, 19, 1, 100.00, 4.00, 400.00, 'a', 1, NULL, '2024-11-13 09:20:22', '2024-11-13 09:20:22', NULL, NULL, '103.159.73.82'),
(25, 19, 2, 395.00, 6.00, 2370.00, 'a', 1, NULL, '2024-11-13 09:20:22', '2024-11-13 09:20:22', NULL, NULL, '103.159.73.82'),
(26, 18, 10, 12.00, 2.00, 24.00, 'a', 1, NULL, '2024-11-13 09:20:31', '2024-11-13 09:20:31', NULL, NULL, '103.159.73.82'),
(27, 17, 1, 100.00, 10.00, 1000.00, 'a', 1, NULL, '2024-11-13 09:20:37', '2024-11-13 09:20:37', NULL, NULL, '103.159.73.82'),
(28, 15, 6, 50.00, 12.00, 600.00, 'a', 1, NULL, '2024-11-13 09:20:59', '2024-11-13 09:20:59', NULL, NULL, '103.159.73.82'),
(29, 15, 7, 40.00, 12.00, 480.00, 'a', 1, NULL, '2024-11-13 09:20:59', '2024-11-13 09:20:59', NULL, NULL, '103.159.73.82'),
(30, 15, 8, 45.00, 12.00, 540.00, 'a', 1, NULL, '2024-11-13 09:20:59', '2024-11-13 09:20:59', NULL, NULL, '103.159.73.82'),
(31, 14, 1, 100.00, 100.00, 10000.00, 'a', 1, NULL, '2024-11-13 09:21:14', '2024-11-13 09:21:14', NULL, NULL, '103.159.73.82'),
(32, 9, 7, 40.00, 12.00, 480.00, 'a', 1, NULL, '2024-11-13 09:22:24', '2024-11-13 09:22:24', NULL, NULL, '103.159.73.82'),
(33, 9, 5, 40.00, 10.00, 400.00, 'a', 1, NULL, '2024-11-13 09:22:24', '2024-11-13 09:22:24', NULL, NULL, '103.159.73.82'),
(34, 9, 2, 395.00, 10.00, 3950.00, 'a', 1, NULL, '2024-11-13 09:22:24', '2024-11-13 09:22:24', NULL, NULL, '103.159.73.82'),
(35, 9, 10, 12.00, 2.00, 24.00, 'a', 1, NULL, '2024-11-13 09:22:24', '2024-11-13 09:22:24', NULL, NULL, '103.159.73.82'),
(36, 8, 2, 395.00, 10.00, 3950.00, 'a', 1, NULL, '2024-11-13 09:22:36', '2024-11-13 09:22:36', NULL, NULL, '103.159.73.82'),
(37, 8, 9, 75.00, 10.00, 750.00, 'a', 1, NULL, '2024-11-13 09:22:36', '2024-11-13 09:22:36', NULL, NULL, '103.159.73.82'),
(38, 8, 10, 12.00, 2.00, 24.00, 'a', 1, NULL, '2024-11-13 09:22:36', '2024-11-13 09:22:36', NULL, NULL, '103.159.73.82'),
(39, 7, 2, 395.00, 10.00, 3950.00, 'a', 1, NULL, '2024-11-13 09:23:16', '2024-11-13 09:23:16', NULL, NULL, '103.159.73.82'),
(40, 7, 9, 75.00, 10.00, 750.00, 'a', 1, NULL, '2024-11-13 09:23:16', '2024-11-13 09:23:16', NULL, NULL, '103.159.73.82'),
(41, 7, 10, 12.00, 2.00, 24.00, 'a', 1, NULL, '2024-11-13 09:23:16', '2024-11-13 09:23:16', NULL, NULL, '103.159.73.82'),
(42, 20, 9, 75.00, 0.15, 11.25, 'a', 1, NULL, '2024-11-13 09:24:19', '2024-11-13 09:24:19', NULL, NULL, '103.159.73.82'),
(43, 20, 2, 395.00, 0.50, 197.50, 'a', 1, NULL, '2024-11-13 09:24:19', '2024-11-13 09:24:19', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `references`
--

CREATE TABLE `references` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `service_head_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_heads`
--

CREATE TABLE `service_heads` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vat` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `sub_title` varchar(191) DEFAULT NULL,
  `btn_text` varchar(40) DEFAULT NULL,
  `btn_url` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `sub_title`, `btn_text`, `btn_url`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Get 10% Off', NULL, 'Get Off', 'https://ukrestaurantweb.pintusoft.com/menu', NULL, 'd', 1, 1, '2024-11-13 04:26:02', '2024-11-13 08:50:45', 1, '2024-11-13 08:50:45', '103.137.229.132'),
(2, 'Black Friday Offers', NULL, 'Get Offers', 'https://ukrestaurantweb.pintusoft.com/menu', NULL, 'd', 1, 1, '2024-11-13 04:29:36', '2024-11-13 08:50:47', 1, '2024-11-13 08:50:47', '103.137.229.132'),
(3, 'Book a table for yourself at a time convenient for you', NULL, 'Book Table', 'https://ukrestaurantweb.pintusoft.com/reservation', 'uploads/slider/_673468769f766.jpeg', 'a', 1, 1, '2024-11-13 08:51:02', '2024-11-13 09:12:27', NULL, NULL, '103.159.73.82'),
(4, 'Book a table for yourself at a time convenient for you', NULL, 'Book Table', 'https://ukrestaurantweb.pintusoft.com/reservation', 'uploads/slider/_67346a31d34a8.jpg', 'a', 1, 1, '2024-11-13 08:58:25', '2024-11-13 09:11:40', NULL, NULL, '103.159.73.82'),
(5, 'Book a table for yourself at a time convenient for you', NULL, 'Book Table', 'https://ukrestaurantweb.pintusoft.com/reservation', 'uploads/slider/_67346a9782bcf.jpg', 'a', 1, 1, '2024-11-13 09:00:07', '2024-11-13 09:06:11', NULL, NULL, '103.159.73.82'),
(6, 'Book a table for yourself at a time convenient for you', NULL, 'Book Table', 'https://ukrestaurantweb.pintusoft.com/reservation', 'uploads/slider/_67346c7fdd379.png', 'a', 1, 1, '2024-11-13 09:08:15', '2024-11-13 09:10:44', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `description` text,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `title`, `price`, `description`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Beef Steak', 10, 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts', 'uploads/specialtie/Beef Steak_673462cedeb42.jpg', 'a', 1, NULL, '2024-11-13 08:26:54', '2024-11-13 08:26:54', NULL, NULL, '103.159.73.82'),
(2, 'Chopsuey', 10, 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts', 'uploads/specialtie/Chopsuey_6734630d05f09.jpg', 'a', 1, NULL, '2024-11-13 08:27:57', '2024-11-13 08:27:57', NULL, NULL, '103.159.73.82'),
(3, 'Beef Ribs Steak', 10, 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts', 'uploads/specialtie/Beef Ribs Steak_6734633c9a4f0.jpg', 'a', 1, NULL, '2024-11-13 08:28:44', '2024-11-13 08:28:44', NULL, NULL, '103.159.73.82'),
(4, 'Roasted Chieken', 10, 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts', 'uploads/specialtie/Roasted Chieken_6734635658e43.jpg', 'a', 1, NULL, '2024-11-13 08:29:10', '2024-11-13 08:29:10', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `specialtie_banners`
--

CREATE TABLE `specialtie_banners` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `specialtie_banners`
--

INSERT INTO `specialtie_banners` (`id`, `image`, `updated_by`, `created_at`, `updated_at`, `last_update_ip`) VALUES
(1, 'uploads/specialtie/banner_673462ebbe803.jpg', 1, '2024-11-12 05:40:48', '2024-11-13 08:27:23', '');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `office_phone` varchar(15) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `previous_due` decimal(8,2) NOT NULL DEFAULT '0.00',
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `name`, `type`, `phone`, `email`, `office_phone`, `address`, `owner_name`, `contact_person`, `district_id`, `previous_due`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'S00001', 'Chester Rhodes', 'retail', '0170000000', NULL, NULL, 'Bangladesh', 'Chester Rhodes', NULL, 1, 0.00, NULL, 'a', 1, NULL, '2024-07-27 12:45:45', '2024-07-27 12:45:45', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `type` char(5) NOT NULL COMMENT 'CP = Payment, CR = Receive',
  `method` varchar(10) NOT NULL,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `floor_id` bigint UNSIGNED NOT NULL,
  `incharge_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `table_type_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `capacity` varchar(55) NOT NULL,
  `location` text,
  `bed` int DEFAULT NULL,
  `bath` int DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `note` text,
  `image` varchar(191) DEFAULT NULL,
  `booking_status` varchar(20) NOT NULL DEFAULT 'available' COMMENT 'booked, available',
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `code`, `floor_id`, `incharge_id`, `category_id`, `table_type_id`, `name`, `capacity`, `location`, `bed`, `bath`, `price`, `note`, `image`, `booking_status`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'T00001', 1, 1, NULL, 1, 'Table 01', '4', 'Left Corner', NULL, NULL, NULL, NULL, NULL, 'available', 'a', 1, NULL, '2024-11-06 05:24:41', '2024-11-06 05:24:41', NULL, NULL, '127.0.0.1'),
(2, 'T00002', 1, 2, NULL, 1, 'Table 02', '4', 'Left Corner', NULL, NULL, NULL, NULL, NULL, 'available', 'a', 1, NULL, '2024-11-06 05:38:30', '2024-11-06 05:38:30', NULL, NULL, '127.0.0.1'),
(3, 'T00003', 1, 1, NULL, 1, 'Table 03', '4', 'Right Corner', NULL, NULL, NULL, NULL, NULL, 'available', 'a', 1, 1, '2024-11-06 05:38:43', '2024-11-06 05:38:52', NULL, NULL, '127.0.0.1'),
(4, 'T00004', 1, 3, NULL, 1, 'Table 04', '4', 'Right Corner', NULL, NULL, NULL, NULL, NULL, 'available', 'a', 1, NULL, '2024-11-06 05:39:09', '2024-11-06 05:39:09', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `table_bookings`
--

CREATE TABLE `table_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `persons` varchar(191) DEFAULT NULL,
  `note` text,
  `status` char(1) NOT NULL DEFAULT 'p' COMMENT 'p=pending,a=approve,c=cancel,d=done',
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `table_bookings`
--

INSERT INTO `table_bookings` (`id`, `invoice`, `date`, `customer_id`, `name`, `email`, `phone`, `booking_date`, `booking_time`, `persons`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '2400001', '2024-11-14', 6, 'Pintu', NULL, '+88-01743134075', '2024-11-14', '17:17:00', '1', NULL, 'a', NULL, 1, '2024-11-13 11:24:39', '2024-11-14 06:31:06', NULL, NULL, '103.159.73.82'),
(2, '2400002', '2024-11-14', 7, 'Test', NULL, '01619833307', '2024-11-15', '12:22:00', '4', 'Test', 'a', NULL, 1, '2024-11-14 06:22:29', '2024-11-14 08:28:21', NULL, NULL, '103.159.73.82'),
(3, '2400003', '2024-11-14', 8, 'Lalon Hossain', NULL, '01781325634', '2024-11-26', '12:36:00', '3', 'Test Notes', 'c', NULL, 1, '2024-11-14 06:36:52', '2024-11-14 08:34:04', NULL, NULL, '103.159.73.82'),
(4, '2400004', '2024-11-14', 8, 'Lalon Hossain', 'lalonhossain@gmail.com', '01781325634', '2024-12-15', '14:24:00', '2', 'Testing Order', 'p', NULL, NULL, '2024-11-14 08:25:03', '2024-11-14 08:25:03', NULL, NULL, '103.159.73.82'),
(5, '2400005', '2024-11-14', 8, 'Lalon Hossain', 'lalonhossain22@gmail.com', '01781325634', '2024-11-15', '14:25:00', '3', 'Testing 2', 'p', NULL, NULL, '2024-11-14 08:25:34', '2024-11-14 08:25:34', NULL, NULL, '103.159.73.82');

-- --------------------------------------------------------

--
-- Table structure for table `table_types`
--

CREATE TABLE `table_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `table_types`
--

INSERT INTO `table_types` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Premium', 'premium', 'a', 1, NULL, '2024-11-12 05:44:00', '2024-11-12 05:44:00', NULL, NULL, '127.0.0.1'),
(2, 'Classic', 'classic', 'a', 1, 1, '2024-11-06 05:14:29', '2024-11-06 05:16:14', NULL, NULL, '127.0.0.1'),
(3, 'Outdoor', 'outdoor', 'a', 1, 1, '2024-11-06 05:14:35', '2024-11-06 05:16:27', NULL, NULL, '127.0.0.1'),
(4, 'Indoor', 'indoor', 'a', 1, 1, '2024-11-06 05:14:38', '2024-11-06 05:16:36', NULL, NULL, '127.0.0.1'),
(5, 'Table 05', 'table-05', 'd', 1, NULL, '2024-11-06 05:14:39', '2024-11-06 05:16:50', 1, '2024-11-06 05:16:50', '127.0.0.1'),
(6, 'Table 06', 'table-06', 'd', 1, NULL, '2024-11-06 05:14:41', '2024-11-06 05:16:48', 1, '2024-11-06 05:16:48', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Pcs', 'a', 1, NULL, '2024-11-06 05:46:09', '2024-11-06 05:46:09', NULL, NULL, '127.0.0.1'),
(2, 'Kg', 'a', 1, NULL, '2024-11-06 05:46:11', '2024-11-06 05:46:11', NULL, NULL, '127.0.0.1'),
(3, 'gm', 'a', 1, NULL, '2024-11-06 05:46:15', '2024-11-06 05:46:15', NULL, NULL, '127.0.0.1'),
(4, 'ml', 'a', 1, NULL, '2024-11-13 04:59:50', '2024-11-13 04:59:50', NULL, NULL, '103.137.229.132');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `action` varchar(191) DEFAULT NULL COMMENT 'e=>entry u=>update d=>delete',
  `last_update_ip` varchar(45) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `name`, `username`, `email`, `password`, `phone`, `role`, `image`, `status`, `action`, `last_update_ip`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'U00001', 'Admin', 'admin', 'admin@gmail.com', '$2y$10$M0gbdsJDoiIEBXLp3szWAObQZMAQDjsUbkFNfmAiDAlxz5r8GDD5K', '019########', 'Superadmin', NULL, 'a', NULL, '127.0.0.1', NULL, '2024-11-12 05:40:48', '2024-11-12 05:40:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_accesses`
--

CREATE TABLE `user_accesses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `access` longtext,
  `added_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `page_name` text,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `page_name`, `login_time`, `logout_time`, `status`, `ip_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'http://127.0.0.1:8000/customer-payment', '2024-11-12 11:41:42', NULL, 'a', '127.0.0.1', '2024-11-12 05:41:42', '2024-11-12 05:41:42', NULL),
(2, 1, 'Logout', NULL, '2024-11-12 11:41:47', 'a', '127.0.0.1', '2024-11-12 05:41:47', '2024-11-12 05:41:47', NULL),
(3, 1, 'http://127.0.0.1:8000/update-company', '2024-11-12 11:41:53', NULL, 'a', '127.0.0.1', '2024-11-12 05:41:53', '2024-11-12 05:43:00', NULL),
(4, 1, 'Logout', NULL, '2024-11-12 11:43:05', 'a', '127.0.0.1', '2024-11-12 05:43:05', '2024-11-12 05:43:05', NULL),
(5, 1, 'http://127.0.0.1:8000/user-profile', '2024-11-12 11:43:13', NULL, 'a', '127.0.0.1', '2024-11-12 05:43:13', '2024-11-12 06:28:26', NULL),
(6, 1, 'Logout', NULL, '2024-11-12 12:29:32', 'a', '127.0.0.1', '2024-11-12 06:29:32', '2024-11-12 06:29:32', NULL),
(7, 1, 'Dashboard', '2024-11-12 12:31:19', NULL, 'a', '127.0.0.1', '2024-11-12 06:31:19', '2024-11-12 06:31:19', NULL),
(8, 1, 'Logout', NULL, '2024-11-12 12:31:25', 'a', '127.0.0.1', '2024-11-12 06:31:25', '2024-11-12 06:31:25', NULL),
(9, 1, 'Dashboard', '2024-11-12 17:54:34', NULL, 'a', '103.159.73.81', '2024-11-12 11:54:34', '2024-11-12 11:54:34', NULL),
(10, 1, 'Logout', NULL, '2024-11-12 17:54:47', 'a', '103.159.73.81', '2024-11-12 11:54:47', '2024-11-12 11:54:47', NULL),
(11, 1, 'https://ukrestaurantsoft.pintusoft.com/specialties', '2024-11-12 18:00:31', NULL, 'a', '103.159.73.81', '2024-11-12 12:00:31', '2024-11-12 12:00:37', NULL),
(12, 1, 'Logout', NULL, '2024-11-12 18:02:25', 'a', '103.159.73.81', '2024-11-12 12:02:25', '2024-11-12 12:02:25', NULL),
(13, 1, 'Dashboard', '2024-11-12 18:14:36', NULL, 'a', '103.159.73.81', '2024-11-12 12:14:36', '2024-11-12 12:14:36', NULL),
(14, 1, 'https://ukrestaurantsoft.pintusoft.com/payFirst', '2024-11-12 18:21:18', NULL, 'a', '103.137.229.132', '2024-11-12 12:21:18', '2024-11-12 12:42:09', NULL),
(15, 1, 'Logout', NULL, '2024-11-12 19:28:01', 'a', '103.137.229.132', '2024-11-12 13:28:01', '2024-11-12 13:28:01', NULL),
(16, 1, 'https://ukrestaurantsoft.pintusoft.com/about', '2024-11-13 10:18:51', NULL, 'a', '103.137.229.132', '2024-11-13 04:18:51', '2024-11-13 05:27:46', NULL),
(17, 1, 'https://ukrestaurantsoft.pintusoft.com/about', '2024-11-13 12:04:58', NULL, 'a', '103.159.73.82', '2024-11-13 06:04:58', '2024-11-13 06:29:23', NULL),
(18, 1, 'https://ukrestaurantsoft.pintusoft.com/about', '2024-11-13 12:36:44', NULL, 'a', '103.159.73.82', '2024-11-13 06:36:44', '2024-11-13 06:44:20', NULL),
(19, 1, 'https://ukrestaurantsoft.pintusoft.com/slider', '2024-11-13 14:25:17', NULL, 'a', '103.159.73.82', '2024-11-13 08:25:17', '2024-11-13 09:04:47', NULL),
(20, 1, 'https://ukrestaurantsoft.pintusoft.com/slider', '2024-11-13 14:46:16', NULL, 'a', '103.137.229.132', '2024-11-13 08:46:16', '2024-11-13 08:46:21', NULL),
(21, 1, 'https://ukrestaurantsoft.pintusoft.com/orderList', '2024-11-13 14:50:02', NULL, 'a', '103.137.229.132', '2024-11-13 08:50:02', '2024-11-13 09:16:11', NULL),
(22, 1, 'https://ukrestaurantsoft.pintusoft.com/order', '2024-11-13 15:11:14', NULL, 'a', '103.159.73.82', '2024-11-13 09:11:14', '2024-11-13 09:11:19', NULL),
(23, 1, 'Logout', NULL, '2024-11-13 15:13:30', 'a', '103.159.73.82', '2024-11-13 09:13:30', '2024-11-13 09:13:30', NULL),
(24, 1, 'Dashboard', '2024-11-13 15:13:36', NULL, 'a', '103.159.73.82', '2024-11-13 09:13:36', '2024-11-13 09:13:36', NULL),
(25, 1, 'Logout', NULL, '2024-11-13 15:14:40', 'a', '103.159.73.82', '2024-11-13 09:14:40', '2024-11-13 09:14:40', NULL),
(26, 1, 'https://ukrestaurantsoft.pintusoft.com/menu', '2024-11-13 15:18:20', NULL, 'a', '103.159.73.82', '2024-11-13 09:18:20', '2024-11-13 09:20:02', NULL),
(27, 1, 'Logout', NULL, '2024-11-13 15:20:58', 'a', '103.159.73.82', '2024-11-13 09:20:58', '2024-11-13 09:20:58', NULL),
(28, 1, 'Logout', NULL, '2024-11-13 15:43:03', 'a', '103.137.229.132', '2024-11-13 09:43:03', '2024-11-13 09:43:03', NULL),
(29, 1, 'https://ukrestaurantsoft.pintusoft.com/customer', '2024-11-13 15:54:26', NULL, 'a', '86.180.28.85', '2024-11-13 09:54:26', '2024-11-13 10:04:23', NULL),
(30, 1, 'Logout', NULL, '2024-11-13 16:04:56', 'a', '86.180.28.85', '2024-11-13 10:04:56', '2024-11-13 10:04:56', NULL),
(31, 1, 'https://ukrestaurantsoft.pintusoft.com/update-company', '2024-11-13 16:11:00', NULL, 'a', '81.128.209.233', '2024-11-13 10:11:00', '2024-11-13 10:23:43', NULL),
(32, 1, 'https://ukrestaurantsoft.pintusoft.com/order', '2024-11-13 17:16:06', NULL, 'a', '103.137.229.132', '2024-11-13 11:16:06', '2024-11-13 11:55:54', NULL),
(33, 1, 'Dashboard', '2024-11-13 17:20:54', NULL, 'a', '103.159.73.82', '2024-11-13 11:20:54', '2024-11-13 11:20:54', NULL),
(34, 1, 'https://ukrestaurantsoft.pintusoft.com/order', '2024-11-13 17:41:51', NULL, 'a', '149.202.98.185', '2024-11-13 11:41:51', '2024-11-13 11:44:49', NULL),
(35, 1, 'Logout', NULL, '2024-11-13 19:04:05', 'a', '103.137.229.132', '2024-11-13 13:04:05', '2024-11-13 13:04:05', NULL),
(36, 1, 'https://ukrestaurantsoft.pintusoft.com/bank-transaction', '2024-11-13 19:23:54', NULL, 'a', '86.180.28.85', '2024-11-13 13:23:54', '2024-11-13 13:25:18', NULL),
(37, 1, 'https://ukrestaurantsoft.pintusoft.com/specialties', '2024-11-14 12:24:35', NULL, 'a', '103.159.73.82', '2024-11-14 06:24:35', '2024-11-14 06:24:41', NULL),
(38, 1, 'https://ukrestaurantsoft.pintusoft.com/tableBooking', '2024-11-14 12:30:37', NULL, 'a', '103.159.73.82', '2024-11-14 06:30:37', '2024-11-14 06:30:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_pages`
--
ALTER TABLE `about_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_pages_updated_by_foreign` (`updated_by`),
  ADD KEY `about_pages_status_index` (`status`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_added_by_foreign` (`added_by`),
  ADD KEY `accounts_updated_by_foreign` (`updated_by`),
  ADD KEY `accounts_deleted_by_foreign` (`deleted_by`),
  ADD KEY `accounts_code_index` (`code`),
  ADD KEY `accounts_status_index` (`status`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assets_brand_id_foreign` (`brand_id`),
  ADD KEY `assets_unit_id_foreign` (`unit_id`),
  ADD KEY `assets_added_by_foreign` (`added_by`),
  ADD KEY `assets_updated_by_foreign` (`updated_by`),
  ADD KEY `assets_deleted_by_foreign` (`deleted_by`),
  ADD KEY `assets_status_index` (`status`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_added_by_foreign` (`added_by`),
  ADD KEY `bank_accounts_updated_by_foreign` (`updated_by`),
  ADD KEY `bank_accounts_deleted_by_foreign` (`deleted_by`),
  ADD KEY `bank_accounts_number_index` (`number`),
  ADD KEY `bank_accounts_status_index` (`status`);

--
-- Indexes for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_transactions_bank_account_id_foreign` (`bank_account_id`),
  ADD KEY `bank_transactions_added_by_foreign` (`added_by`),
  ADD KEY `bank_transactions_updated_by_foreign` (`updated_by`),
  ADD KEY `bank_transactions_deleted_by_foreign` (`deleted_by`),
  ADD KEY `bank_transactions_date_index` (`date`),
  ADD KEY `bank_transactions_type_index` (`type`),
  ADD KEY `bank_transactions_status_index` (`status`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_details_added_by_foreign` (`added_by`),
  ADD KEY `booking_details_updated_by_foreign` (`updated_by`),
  ADD KEY `booking_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `booking_details_booking_id_index` (`booking_id`),
  ADD KEY `booking_details_table_id_index` (`table_id`),
  ADD KEY `booking_details_days_index` (`days`),
  ADD KEY `booking_details_unit_price_index` (`unit_price`),
  ADD KEY `booking_details_total_index` (`total`);

--
-- Indexes for table `booking_masters`
--
ALTER TABLE `booking_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_masters_added_by_foreign` (`added_by`),
  ADD KEY `booking_masters_updated_by_foreign` (`updated_by`),
  ADD KEY `booking_masters_deleted_by_foreign` (`deleted_by`),
  ADD KEY `booking_masters_invoice_index` (`invoice`),
  ADD KEY `booking_masters_customer_id_index` (`customer_id`),
  ADD KEY `booking_masters_is_other_index` (`is_other`),
  ADD KEY `booking_masters_status_index` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_added_by_foreign` (`added_by`),
  ADD KEY `brands_updated_by_foreign` (`updated_by`),
  ADD KEY `brands_deleted_by_foreign` (`deleted_by`),
  ADD KEY `brands_status_index` (`status`);

--
-- Indexes for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_transactions_account_id_foreign` (`account_id`),
  ADD KEY `cash_transactions_added_by_foreign` (`added_by`),
  ADD KEY `cash_transactions_updated_by_foreign` (`updated_by`),
  ADD KEY `cash_transactions_deleted_by_foreign` (`deleted_by`),
  ADD KEY `cash_transactions_code_index` (`code`),
  ADD KEY `cash_transactions_date_index` (`date`),
  ADD KEY `cash_transactions_type_index` (`type`),
  ADD KEY `cash_transactions_status_index` (`status`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_added_by_foreign` (`added_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`),
  ADD KEY `categories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_district_id_foreign` (`district_id`),
  ADD KEY `customers_reference_id_foreign` (`reference_id`),
  ADD KEY `customers_added_by_foreign` (`added_by`),
  ADD KEY `customers_updated_by_foreign` (`updated_by`),
  ADD KEY `customers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `customers_code_index` (`code`),
  ADD KEY `customers_name_index` (`name`),
  ADD KEY `customers_phone_index` (`phone`),
  ADD KEY `customers_status_index` (`status`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_payments_order_id_foreign` (`order_id`),
  ADD KEY `customer_payments_bank_account_id_foreign` (`bank_account_id`),
  ADD KEY `customer_payments_added_by_foreign` (`added_by`),
  ADD KEY `customer_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `customer_payments_deleted_by_foreign` (`deleted_by`),
  ADD KEY `customer_payments_invoice_index` (`invoice`),
  ADD KEY `customer_payments_date_index` (`date`),
  ADD KEY `customer_payments_customer_id_index` (`customer_id`),
  ADD KEY `customer_payments_type_index` (`type`),
  ADD KEY `customer_payments_status_index` (`status`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_added_by_foreign` (`added_by`),
  ADD KEY `departments_updated_by_foreign` (`updated_by`),
  ADD KEY `departments_deleted_by_foreign` (`deleted_by`),
  ADD KEY `departments_status_index` (`status`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_added_by_foreign` (`added_by`),
  ADD KEY `designations_updated_by_foreign` (`updated_by`),
  ADD KEY `designations_deleted_by_foreign` (`deleted_by`),
  ADD KEY `designations_status_index` (`status`);

--
-- Indexes for table `disposals`
--
ALTER TABLE `disposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposals_added_by_foreign` (`added_by`),
  ADD KEY `disposals_updated_by_foreign` (`updated_by`),
  ADD KEY `disposals_deleted_by_foreign` (`deleted_by`),
  ADD KEY `disposals_status_index` (`status`);

--
-- Indexes for table `disposal_details`
--
ALTER TABLE `disposal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposal_details_disposal_id_foreign` (`disposal_id`),
  ADD KEY `disposal_details_asset_id_foreign` (`asset_id`),
  ADD KEY `disposal_details_added_by_foreign` (`added_by`),
  ADD KEY `disposal_details_updated_by_foreign` (`updated_by`),
  ADD KEY `disposal_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `disposal_details_status_index` (`status`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_added_by_foreign` (`added_by`),
  ADD KEY `districts_updated_by_foreign` (`updated_by`),
  ADD KEY `districts_deleted_by_foreign` (`deleted_by`),
  ADD KEY `districts_status_index` (`status`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_added_by_foreign` (`added_by`),
  ADD KEY `employees_updated_by_foreign` (`updated_by`),
  ADD KEY `employees_deleted_by_foreign` (`deleted_by`),
  ADD KEY `employees_code_index` (`code`),
  ADD KEY `employees_status_index` (`status`);

--
-- Indexes for table `employee_payments`
--
ALTER TABLE `employee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_payments_added_by_foreign` (`added_by`),
  ADD KEY `employee_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `employee_payments_deleted_by_foreign` (`deleted_by`),
  ADD KEY `employee_payments_date_index` (`date`),
  ADD KEY `employee_payments_month_index` (`month`),
  ADD KEY `employee_payments_status_index` (`status`);

--
-- Indexes for table `employee_payment_details`
--
ALTER TABLE `employee_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_payment_details_employee_payment_id_foreign` (`employee_payment_id`),
  ADD KEY `employee_payment_details_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_payment_details_added_by_foreign` (`added_by`),
  ADD KEY `employee_payment_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `employee_payment_details_status_index` (`status`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floors_added_by_foreign` (`added_by`),
  ADD KEY `floors_updated_by_foreign` (`updated_by`),
  ADD KEY `floors_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_added_by_foreign` (`added_by`),
  ADD KEY `galleries_updated_by_foreign` (`updated_by`),
  ADD KEY `galleries_deleted_by_foreign` (`deleted_by`),
  ADD KEY `galleries_status_index` (`status`);

--
-- Indexes for table `investment_accounts`
--
ALTER TABLE `investment_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_accounts_added_by_foreign` (`added_by`),
  ADD KEY `investment_accounts_updated_by_foreign` (`updated_by`),
  ADD KEY `investment_accounts_deleted_by_foreign` (`deleted_by`),
  ADD KEY `investment_accounts_code_index` (`code`),
  ADD KEY `investment_accounts_status_index` (`status`);

--
-- Indexes for table `investment_transactions`
--
ALTER TABLE `investment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_transactions_investment_account_id_foreign` (`investment_account_id`),
  ADD KEY `investment_transactions_added_by_foreign` (`added_by`),
  ADD KEY `investment_transactions_updated_by_foreign` (`updated_by`),
  ADD KEY `investment_transactions_deleted_by_foreign` (`deleted_by`),
  ADD KEY `investment_transactions_invoice_index` (`invoice`),
  ADD KEY `investment_transactions_date_index` (`date`),
  ADD KEY `investment_transactions_type_index` (`type`),
  ADD KEY `investment_transactions_status_index` (`status`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issues_added_by_foreign` (`added_by`),
  ADD KEY `issues_updated_by_foreign` (`updated_by`),
  ADD KEY `issues_deleted_by_foreign` (`deleted_by`),
  ADD KEY `issues_date_index` (`date`),
  ADD KEY `issues_invoice_index` (`invoice`),
  ADD KEY `issues_status_index` (`status`);

--
-- Indexes for table `issue_details`
--
ALTER TABLE `issue_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_details_issue_id_foreign` (`issue_id`),
  ADD KEY `issue_details_asset_id_foreign` (`asset_id`),
  ADD KEY `issue_details_added_by_foreign` (`added_by`),
  ADD KEY `issue_details_updated_by_foreign` (`updated_by`),
  ADD KEY `issue_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `issue_details_status_index` (`status`);

--
-- Indexes for table `issue_returns`
--
ALTER TABLE `issue_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_returns_added_by_foreign` (`added_by`),
  ADD KEY `issue_returns_updated_by_foreign` (`updated_by`),
  ADD KEY `issue_returns_deleted_by_foreign` (`deleted_by`),
  ADD KEY `issue_returns_date_index` (`date`),
  ADD KEY `issue_returns_status_index` (`status`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_added_by_foreign` (`added_by`),
  ADD KEY `leaves_updated_by_foreign` (`updated_by`),
  ADD KEY `leaves_deleted_by_foreign` (`deleted_by`),
  ADD KEY `leaves_date_index` (`date`),
  ADD KEY `leaves_employee_id_index` (`employee_id`),
  ADD KEY `leaves_leave_type_id_index` (`leave_type_id`),
  ADD KEY `leaves_status_index` (`status`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_added_by_foreign` (`added_by`),
  ADD KEY `leave_types_updated_by_foreign` (`updated_by`),
  ADD KEY `leave_types_deleted_by_foreign` (`deleted_by`),
  ADD KEY `leave_types_status_index` (`status`);

--
-- Indexes for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_accounts_added_by_foreign` (`added_by`),
  ADD KEY `loan_accounts_updated_by_foreign` (`updated_by`),
  ADD KEY `loan_accounts_deleted_by_foreign` (`deleted_by`),
  ADD KEY `loan_accounts_status_index` (`status`);

--
-- Indexes for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_transactions_loan_account_id_foreign` (`loan_account_id`),
  ADD KEY `loan_transactions_added_by_foreign` (`added_by`),
  ADD KEY `loan_transactions_updated_by_foreign` (`updated_by`),
  ADD KEY `loan_transactions_deleted_by_foreign` (`deleted_by`),
  ADD KEY `loan_transactions_invoice_index` (`invoice`),
  ADD KEY `loan_transactions_date_index` (`date`),
  ADD KEY `loan_transactions_type_index` (`type`),
  ADD KEY `loan_transactions_status_index` (`status`);

--
-- Indexes for table `manages`
--
ALTER TABLE `manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manages_designation_id_foreign` (`designation_id`),
  ADD KEY `manages_added_by_foreign` (`added_by`),
  ADD KEY `manages_updated_by_foreign` (`updated_by`),
  ADD KEY `manages_deleted_by_foreign` (`deleted_by`),
  ADD KEY `manages_status_index` (`status`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_unit_id_foreign` (`unit_id`),
  ADD KEY `materials_added_by_foreign` (`added_by`),
  ADD KEY `materials_updated_by_foreign` (`updated_by`),
  ADD KEY `materials_deleted_by_foreign` (`deleted_by`),
  ADD KEY `materials_status_index` (`status`);

--
-- Indexes for table `material_purchases`
--
ALTER TABLE `material_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `material_purchases_employee_id_foreign` (`employee_id`),
  ADD KEY `material_purchases_added_by_foreign` (`added_by`),
  ADD KEY `material_purchases_updated_by_foreign` (`updated_by`),
  ADD KEY `material_purchases_deleted_by_foreign` (`deleted_by`),
  ADD KEY `material_purchases_invoice_index` (`invoice`),
  ADD KEY `material_purchases_date_index` (`date`),
  ADD KEY `material_purchases_status_index` (`status`);

--
-- Indexes for table `material_purchase_details`
--
ALTER TABLE `material_purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_purchase_details_material_purchase_id_foreign` (`material_purchase_id`),
  ADD KEY `material_purchase_details_material_id_foreign` (`material_id`),
  ADD KEY `material_purchase_details_added_by_foreign` (`added_by`),
  ADD KEY `material_purchase_details_updated_by_foreign` (`updated_by`),
  ADD KEY `material_purchase_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `material_purchase_details_status_index` (`status`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_menu_category_id_foreign` (`menu_category_id`),
  ADD KEY `menus_unit_id_foreign` (`unit_id`),
  ADD KEY `menus_added_by_foreign` (`added_by`),
  ADD KEY `menus_updated_by_foreign` (`updated_by`),
  ADD KEY `menus_deleted_by_foreign` (`deleted_by`),
  ADD KEY `menus_code_index` (`code`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_categories_added_by_foreign` (`added_by`),
  ADD KEY `menu_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `menu_categories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_added_by_foreign` (`added_by`),
  ADD KEY `offers_updated_by_foreign` (`updated_by`),
  ADD KEY `offers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `offers_status_index` (`status`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_unique` (`invoice`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_added_by_foreign` (`added_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`),
  ADD KEY `orders_deleted_by_foreign` (`deleted_by`),
  ADD KEY `orders_date_index` (`date`),
  ADD KEY `orders_bank_account_id_index` (`bank_account_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_added_by_foreign` (`added_by`),
  ADD KEY `order_details_updated_by_foreign` (`updated_by`),
  ADD KEY `order_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `order_details_order_id_index` (`order_id`),
  ADD KEY `order_details_menu_id_index` (`menu_id`);

--
-- Indexes for table `order_tables`
--
ALTER TABLE `order_tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_tables_added_by_foreign` (`added_by`),
  ADD KEY `order_tables_updated_by_foreign` (`updated_by`),
  ADD KEY `order_tables_deleted_by_foreign` (`deleted_by`),
  ADD KEY `order_tables_order_id_index` (`order_id`),
  ADD KEY `order_tables_table_id_index` (`table_id`),
  ADD KEY `order_tables_incharge_id_index` (`incharge_id`);

--
-- Indexes for table `other_customers`
--
ALTER TABLE `other_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_customers_added_by_foreign` (`added_by`),
  ADD KEY `other_customers_updated_by_foreign` (`updated_by`),
  ADD KEY `other_customers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `other_customers_booking_id_index` (`booking_id`),
  ADD KEY `other_customers_table_id_index` (`table_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `productions`
--
ALTER TABLE `productions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productions_order_id_foreign` (`order_id`),
  ADD KEY `productions_added_by_foreign` (`added_by`),
  ADD KEY `productions_updated_by_foreign` (`updated_by`),
  ADD KEY `productions_deleted_by_foreign` (`deleted_by`),
  ADD KEY `productions_invoice_index` (`invoice`),
  ADD KEY `productions_date_index` (`date`),
  ADD KEY `productions_status_index` (`status`);

--
-- Indexes for table `production_details`
--
ALTER TABLE `production_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_details_production_id_foreign` (`production_id`),
  ADD KEY `production_details_material_id_foreign` (`material_id`),
  ADD KEY `production_details_added_by_foreign` (`added_by`),
  ADD KEY `production_details_updated_by_foreign` (`updated_by`),
  ADD KEY `production_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `production_details_status_index` (`status`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_employee_id_foreign` (`employee_id`),
  ADD KEY `purchases_added_by_foreign` (`added_by`),
  ADD KEY `purchases_updated_by_foreign` (`updated_by`),
  ADD KEY `purchases_deleted_by_foreign` (`deleted_by`),
  ADD KEY `purchases_invoice_index` (`invoice`),
  ADD KEY `purchases_date_index` (`date`),
  ADD KEY `purchases_status_index` (`status`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_asset_id_foreign` (`asset_id`),
  ADD KEY `purchase_details_added_by_foreign` (`added_by`),
  ADD KEY `purchase_details_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `purchase_details_status_index` (`status`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipes_menu_id_foreign` (`menu_id`),
  ADD KEY `recipes_material_id_foreign` (`material_id`),
  ADD KEY `recipes_added_by_foreign` (`added_by`),
  ADD KEY `recipes_updated_by_foreign` (`updated_by`),
  ADD KEY `recipes_deleted_by_foreign` (`deleted_by`),
  ADD KEY `recipes_status_index` (`status`);

--
-- Indexes for table `references`
--
ALTER TABLE `references`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `references_code_unique` (`code`),
  ADD KEY `references_added_by_foreign` (`added_by`),
  ADD KEY `references_updated_by_foreign` (`updated_by`),
  ADD KEY `references_deleted_by_foreign` (`deleted_by`),
  ADD KEY `references_status_index` (`status`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_booking_id_foreign` (`booking_id`),
  ADD KEY `services_customer_id_foreign` (`customer_id`),
  ADD KEY `services_service_head_id_foreign` (`service_head_id`),
  ADD KEY `services_added_by_foreign` (`added_by`),
  ADD KEY `services_updated_by_foreign` (`updated_by`),
  ADD KEY `services_deleted_by_foreign` (`deleted_by`),
  ADD KEY `services_invoice_index` (`invoice`),
  ADD KEY `services_date_index` (`date`),
  ADD KEY `services_status_index` (`status`);

--
-- Indexes for table `service_heads`
--
ALTER TABLE `service_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_heads_added_by_foreign` (`added_by`),
  ADD KEY `service_heads_updated_by_foreign` (`updated_by`),
  ADD KEY `service_heads_deleted_by_foreign` (`deleted_by`),
  ADD KEY `service_heads_status_index` (`status`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_added_by_foreign` (`added_by`),
  ADD KEY `sliders_updated_by_foreign` (`updated_by`),
  ADD KEY `sliders_deleted_by_foreign` (`deleted_by`),
  ADD KEY `sliders_status_index` (`status`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialties_added_by_foreign` (`added_by`),
  ADD KEY `specialties_updated_by_foreign` (`updated_by`),
  ADD KEY `specialties_deleted_by_foreign` (`deleted_by`),
  ADD KEY `specialties_status_index` (`status`);

--
-- Indexes for table `specialtie_banners`
--
ALTER TABLE `specialtie_banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specialtie_banners_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_district_id_foreign` (`district_id`),
  ADD KEY `suppliers_added_by_foreign` (`added_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`),
  ADD KEY `suppliers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `suppliers_code_index` (`code`),
  ADD KEY `suppliers_name_index` (`name`),
  ADD KEY `suppliers_type_index` (`type`),
  ADD KEY `suppliers_phone_index` (`phone`),
  ADD KEY `suppliers_status_index` (`status`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_payments_bank_account_id_foreign` (`bank_account_id`),
  ADD KEY `supplier_payments_added_by_foreign` (`added_by`),
  ADD KEY `supplier_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `supplier_payments_deleted_by_foreign` (`deleted_by`),
  ADD KEY `supplier_payments_invoice_index` (`invoice`),
  ADD KEY `supplier_payments_date_index` (`date`),
  ADD KEY `supplier_payments_supplier_id_index` (`supplier_id`),
  ADD KEY `supplier_payments_type_index` (`type`),
  ADD KEY `supplier_payments_status_index` (`status`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tables_added_by_foreign` (`added_by`),
  ADD KEY `tables_updated_by_foreign` (`updated_by`),
  ADD KEY `tables_deleted_by_foreign` (`deleted_by`),
  ADD KEY `tables_code_index` (`code`),
  ADD KEY `tables_floor_id_index` (`floor_id`),
  ADD KEY `tables_incharge_id_index` (`incharge_id`),
  ADD KEY `tables_table_type_id_index` (`table_type_id`);

--
-- Indexes for table `table_bookings`
--
ALTER TABLE `table_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_bookings_invoice_unique` (`invoice`),
  ADD KEY `table_bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `table_bookings_added_by_foreign` (`added_by`),
  ADD KEY `table_bookings_updated_by_foreign` (`updated_by`),
  ADD KEY `table_bookings_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `table_types`
--
ALTER TABLE `table_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_types_added_by_foreign` (`added_by`),
  ADD KEY `table_types_updated_by_foreign` (`updated_by`),
  ADD KEY `table_types_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_added_by_foreign` (`added_by`),
  ADD KEY `units_updated_by_foreign` (`updated_by`),
  ADD KEY `units_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_accesses`
--
ALTER TABLE `user_accesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_accesses_user_id_foreign` (`user_id`),
  ADD KEY `user_accesses_added_by_foreign` (`added_by`),
  ADD KEY `user_accesses_updated_by_foreign` (`updated_by`),
  ADD KEY `user_accesses_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_pages`
--
ALTER TABLE `about_pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_masters`
--
ALTER TABLE `booking_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disposals`
--
ALTER TABLE `disposals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposal_details`
--
ALTER TABLE `disposal_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_payments`
--
ALTER TABLE `employee_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_payment_details`
--
ALTER TABLE `employee_payment_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `investment_accounts`
--
ALTER TABLE `investment_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_transactions`
--
ALTER TABLE `investment_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_details`
--
ALTER TABLE `issue_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_returns`
--
ALTER TABLE `issue_returns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manages`
--
ALTER TABLE `manages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `material_purchases`
--
ALTER TABLE `material_purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_purchase_details`
--
ALTER TABLE `material_purchase_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `order_tables`
--
ALTER TABLE `order_tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_customers`
--
ALTER TABLE `other_customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_heads`
--
ALTER TABLE `service_heads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `specialtie_banners`
--
ALTER TABLE `specialtie_banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_bookings`
--
ALTER TABLE `table_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_types`
--
ALTER TABLE `table_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accesses`
--
ALTER TABLE `user_accesses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_pages`
--
ALTER TABLE `about_pages`
  ADD CONSTRAINT `about_pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `accounts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assets_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `assets_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assets_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `assets_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bank_accounts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bank_accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD CONSTRAINT `bank_transactions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bank_transactions_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`),
  ADD CONSTRAINT `bank_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bank_transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_masters`
--
ALTER TABLE `booking_masters`
  ADD CONSTRAINT `booking_masters_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_masters_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_masters_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `brands_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD CONSTRAINT `cash_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `cash_transactions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cash_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cash_transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customers_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `customers_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `references` (`id`),
  ADD CONSTRAINT `customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD CONSTRAINT `customer_payments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_payments_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`),
  ADD CONSTRAINT `customer_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `customer_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `designations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `designations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `disposals`
--
ALTER TABLE `disposals`
  ADD CONSTRAINT `disposals_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `disposals_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `disposals_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `disposal_details`
--
ALTER TABLE `disposal_details`
  ADD CONSTRAINT `disposal_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `disposal_details_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `disposal_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `disposal_details_disposal_id_foreign` FOREIGN KEY (`disposal_id`) REFERENCES `disposals` (`id`),
  ADD CONSTRAINT `disposal_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `districts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `districts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employees_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`),
  ADD CONSTRAINT `employees_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `employee_payments`
--
ALTER TABLE `employee_payments`
  ADD CONSTRAINT `employee_payments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `employee_payment_details`
--
ALTER TABLE `employee_payment_details`
  ADD CONSTRAINT `employee_payment_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_payment_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_payment_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_payment_details_employee_payment_id_foreign` FOREIGN KEY (`employee_payment_id`) REFERENCES `employee_payments` (`id`);

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `floors_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `floors_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `floors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `galleries_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `galleries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `investment_accounts`
--
ALTER TABLE `investment_accounts`
  ADD CONSTRAINT `investment_accounts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investment_accounts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investment_accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `investment_transactions`
--
ALTER TABLE `investment_transactions`
  ADD CONSTRAINT `investment_transactions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investment_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investment_transactions_investment_account_id_foreign` FOREIGN KEY (`investment_account_id`) REFERENCES `investment_accounts` (`id`),
  ADD CONSTRAINT `investment_transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issues_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issues_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `issue_details`
--
ALTER TABLE `issue_details`
  ADD CONSTRAINT `issue_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_details_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `issue_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_details_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`),
  ADD CONSTRAINT `issue_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `issue_returns`
--
ALTER TABLE `issue_returns`
  ADD CONSTRAINT `issue_returns_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_returns_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leaves_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leaves_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leave_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leave_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  ADD CONSTRAINT `loan_accounts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_accounts_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD CONSTRAINT `loan_transactions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_transactions_loan_account_id_foreign` FOREIGN KEY (`loan_account_id`) REFERENCES `loan_accounts` (`id`),
  ADD CONSTRAINT `loan_transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `manages`
--
ALTER TABLE `manages`
  ADD CONSTRAINT `manages_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `manages_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `manages_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`),
  ADD CONSTRAINT `manages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `materials_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `materials_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `materials_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `material_purchases`
--
ALTER TABLE `material_purchases`
  ADD CONSTRAINT `material_purchases_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_purchases_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_purchases_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `material_purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `material_purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `material_purchase_details`
--
ALTER TABLE `material_purchase_details`
  ADD CONSTRAINT `material_purchase_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_purchase_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_purchase_details_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `material_purchase_details_material_purchase_id_foreign` FOREIGN KEY (`material_purchase_id`) REFERENCES `material_purchases` (`id`),
  ADD CONSTRAINT `material_purchase_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `menus_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `menus_menu_category_id_foreign` FOREIGN KEY (`menu_category_id`) REFERENCES `menu_categories` (`id`),
  ADD CONSTRAINT `menus_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `menus_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD CONSTRAINT `menu_categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `menu_categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `menu_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `offers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `offers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`),
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_tables`
--
ALTER TABLE `order_tables`
  ADD CONSTRAINT `order_tables_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_tables_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_tables_incharge_id_foreign` FOREIGN KEY (`incharge_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `order_tables_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_tables_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
  ADD CONSTRAINT `order_tables_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `other_customers`
--
ALTER TABLE `other_customers`
  ADD CONSTRAINT `other_customers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `other_customers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `other_customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `productions`
--
ALTER TABLE `productions`
  ADD CONSTRAINT `productions_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `productions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `productions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `productions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `production_details`
--
ALTER TABLE `production_details`
  ADD CONSTRAINT `production_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `production_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `production_details_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `production_details_production_id_foreign` FOREIGN KEY (`production_id`) REFERENCES `productions` (`id`),
  ADD CONSTRAINT `production_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_details_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `purchase_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recipes_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recipes_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `recipes_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `recipes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `references`
--
ALTER TABLE `references`
  ADD CONSTRAINT `references_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `references_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `references_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `services_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `services_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `services_service_head_id_foreign` FOREIGN KEY (`service_head_id`) REFERENCES `service_heads` (`id`),
  ADD CONSTRAINT `services_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `service_heads`
--
ALTER TABLE `service_heads`
  ADD CONSTRAINT `service_heads_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `service_heads_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `service_heads_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sliders_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sliders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `specialties`
--
ALTER TABLE `specialties`
  ADD CONSTRAINT `specialties_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `specialties_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `specialties_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `specialtie_banners`
--
ALTER TABLE `specialtie_banners`
  ADD CONSTRAINT `specialtie_banners_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `suppliers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `suppliers_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD CONSTRAINT `supplier_payments_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `supplier_payments_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`),
  ADD CONSTRAINT `supplier_payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `supplier_payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `supplier_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tables_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tables_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`),
  ADD CONSTRAINT `tables_incharge_id_foreign` FOREIGN KEY (`incharge_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `tables_table_type_id_foreign` FOREIGN KEY (`table_type_id`) REFERENCES `table_types` (`id`),
  ADD CONSTRAINT `tables_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `table_bookings`
--
ALTER TABLE `table_bookings`
  ADD CONSTRAINT `table_bookings_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `table_bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `table_bookings_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `table_bookings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `table_types`
--
ALTER TABLE `table_types`
  ADD CONSTRAINT `table_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `table_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `table_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `units_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_accesses`
--
ALTER TABLE `user_accesses`
  ADD CONSTRAINT `user_accesses_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_accesses_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_accesses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_accesses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
