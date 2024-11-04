-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 06:04 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ukrestaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_pages`
--

CREATE TABLE `about_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about_pages`
--

INSERT INTO `about_pages` (`id`, `title`, `short_description`, `description`, `image`, `status`, `updated_by`, `created_at`, `updated_at`, `last_update_ip`) VALUES
(1, 'Welcome To UK Restaurent', 'Ekhane onek valo maner khabar pawa jay', '<p>khaon khaon khaon&nbsp;</p>', 'uploads/about/Welcome To UK Restaurent_67260f6f0f1ba.jpg', 'a', 1, '2024-11-02 09:45:57', '2024-11-02 11:39:27', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(40) DEFAULT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = false, 1 = true',
  `is_serial` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = false, 1 = true',
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `type` varchar(40) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(40) NOT NULL,
  `initial_balance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `checkin_date` datetime NOT NULL,
  `checkout_date` datetime NOT NULL,
  `days` int(11) NOT NULL DEFAULT 0,
  `unit_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `checkout_status` char(5) NOT NULL DEFAULT 'false' COMMENT 'true, false',
  `booking_status` varchar(20) NOT NULL DEFAULT 'booked' COMMENT 'booked, checkin',
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_masters`
--

CREATE TABLE `booking_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `date` varchar(20) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_other` varchar(5) NOT NULL DEFAULT 'false',
  `others_member` int(11) NOT NULL DEFAULT 0,
  `subtotal` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discountAmount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(8,2) NOT NULL DEFAULT 0.00,
  `vatAmount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `advance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `due` decimal(8,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `in_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `out_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Ac', 'ac', 'a', 1, NULL, '2024-11-02 09:45:56', NULL, NULL, NULL, '127.0.0.1'),
(2, 'Non Ac', 'non-ac', 'a', 1, NULL, '2024-11-02 09:45:56', NULL, NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `title` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `map_link` text DEFAULT NULL,
  `facebook` varchar(191) DEFAULT NULL,
  `instagram` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `youtube` varchar(191) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'BDT',
  `print_type` int(11) NOT NULL DEFAULT 1,
  `logo` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `name`, `title`, `phone`, `email`, `address`, `map_link`, `facebook`, `instagram`, `twitter`, `youtube`, `currency`, `print_type`, `logo`, `favicon`, `last_update_ip`, `created_at`, `updated_at`) VALUES
(1, 'UK Restaurent', 'UK Restaurent', '01619833307', 'ukrestaurent96@gmail.com', 'Mirpur 10', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29203.581321715606!2d90.3610368!3d23.802675200000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c102e2ece5bb%3A0x446e9dc895326a70!2sBangladesh%20National%20Zoo!5e0!3m2!1sen!2sbd!4v1730612747516!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, NULL, NULL, NULL, 'BDT', 1, 'uploads/logo/_67270e15d0f0f.png', 'uploads/favicon/_67270e15d14f9.png', '127.0.0.1', '2024-11-02 09:45:56', '2024-11-03 05:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `previous_due` decimal(8,2) NOT NULL DEFAULT 0.00,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` char(5) NOT NULL COMMENT 'CP = Payment, CR = Receive',
  `method` varchar(10) NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discountAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `disposals`
--

CREATE TABLE `disposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `disposal_details`
--

CREATE TABLE `disposal_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `disposal_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `disposal_status` varchar(40) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
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
  `salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `reference` varchar(60) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_payments`
--

CREATE TABLE `employee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(20) NOT NULL,
  `total_employee` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_payment_details`
--

CREATE TABLE `employee_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_payment_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `benefit` decimal(8,2) NOT NULL DEFAULT 0.00,
  `deduction` decimal(8,2) NOT NULL DEFAULT 0.00,
  `net_payable` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment` decimal(8,2) NOT NULL DEFAULT 0.00,
  `comment` varchar(150) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `type`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, NULL, NULL, 'uploads/gallery/_67261414804a8.jpg', 'a', 1, NULL, '2024-11-02 11:59:16', '2024-11-02 11:59:16', NULL, NULL, '127.0.0.1'),
(2, NULL, NULL, 'uploads/gallery/_6726141ca282e.jpg', 'a', 1, NULL, '2024-11-02 11:59:24', '2024-11-02 11:59:24', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `investment_accounts`
--

CREATE TABLE `investment_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `investment_transactions`
--

CREATE TABLE `investment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `investment_account_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `issue_to` varchar(60) NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` double(8,2) NOT NULL DEFAULT 0.00,
  `vatAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` double(8,2) NOT NULL DEFAULT 0.00,
  `discountAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue_details`
--

CREATE TABLE `issue_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue_returns`
--

CREATE TABLE `issue_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `days` int(11) NOT NULL DEFAULT 0,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_accounts`
--

CREATE TABLE `loan_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `type` varchar(40) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(60) DEFAULT NULL,
  `initial_balance` decimal(18,3) NOT NULL DEFAULT 0.000,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

CREATE TABLE `loan_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `loan_account_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(18,3) NOT NULL DEFAULT 0.000,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `unit_id`, `price`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Beef', 1, '100.00', NULL, 'a', 1, NULL, '2024-11-02 10:23:25', '2024-11-02 10:23:25', NULL, NULL, '127.0.0.1'),
(2, 'Powder Milk', 2, '395.00', NULL, 'a', 1, NULL, '2024-11-02 10:27:17', '2024-11-02 10:27:17', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `material_purchases`
--

CREATE TABLE `material_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` double(8,2) NOT NULL DEFAULT 0.00,
  `vatAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` double(8,2) NOT NULL DEFAULT 0.00,
  `discountAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `transport` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `material_purchase_details`
--

CREATE TABLE `material_purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `menu_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `vat` double(8,2) NOT NULL DEFAULT 0.00,
  `purchase_rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sale_rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `wholesale_rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `is_service` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `code`, `menu_category_id`, `name`, `slug`, `unit_id`, `vat`, `purchase_rate`, `sale_rate`, `wholesale_rate`, `is_service`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'M00001', 9, 'Grilled Beef with potatoes', 'grilled-beef-with-potatoes', 1, 0.00, '0.00', '500.00', '0.00', 0, 'uploads/menu/M00001_6725fde02961d.jpg', 'a', 1, NULL, '2024-11-02 10:24:32', '2024-11-02 10:25:02', NULL, NULL, '127.0.0.1'),
(2, 'M00002', 10, 'Strawberry Juice', 'strawberry-juice', 1, 0.00, '0.00', '80.00', '0.00', 0, NULL, 'a', 1, NULL, '2024-11-02 10:29:50', '2024-11-02 10:29:50', NULL, NULL, '127.0.0.1'),
(3, 'M00003', 9, 'test', 'test', 1, 0.00, '0.00', '0.00', '0.00', 0, 'uploads/menu/M00003_6725ffde35482.jpg', 'a', 1, NULL, '2024-11-02 10:33:02', '2024-11-02 10:33:02', NULL, NULL, '127.0.0.1'),
(4, 'M00004', 11, 'test1', 'test1', 1, 0.00, '0.00', '5.00', '0.00', 0, NULL, 'a', 1, NULL, '2024-11-02 10:34:28', '2024-11-02 10:34:28', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `image`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(9, 'Main', 'uploads/category/Main_6725fd3738302.png', 'main', 'a', 1, 1, '2024-11-02 10:17:12', '2024-11-02 10:21:43', NULL, NULL, '127.0.0.1'),
(10, 'Drinks', 'uploads/category/Drinks_6725fd18a6153.png', 'drinks', 'a', 1, NULL, '2024-11-02 10:21:12', '2024-11-02 10:21:12', NULL, NULL, '127.0.0.1'),
(11, 'Desert', 'uploads/category/Desert_6725fd301b618.png', 'desert', 'a', 1, NULL, '2024-11-02 10:21:36', '2024-11-02 10:21:36', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(7, '2024_05_14_105132_create_room_types_table', 1),
(8, '2024_05_14_105235_create_categories_table', 1),
(9, '2024_05_14_105444_create_districts_table', 1),
(10, '2024_05_14_105445_create_floors_table', 1),
(11, '2024_05_14_105723_create_rooms_table', 1),
(12, '2024_05_23_114157_create_departments_table', 1),
(13, '2024_05_23_114437_create_designations_table', 1),
(14, '2024_05_23_114453_create_employees_table', 1),
(15, '2024_05_23_122245_create_employee_payments_table', 1),
(16, '2024_05_23_122308_create_employee_payment_details_table', 1),
(17, '2024_05_23_154449_create_references_table', 1),
(18, '2024_05_23_154450_create_customers_table', 1),
(19, '2024_05_23_162607_create_suppliers_table', 1),
(20, '2024_05_25_142744_create_booking_masters_table', 1),
(21, '2024_05_25_143009_create_booking_details_table', 1),
(22, '2024_05_25_150501_create_other_customers_table', 1),
(23, '2024_05_25_154620_create_accounts_table', 1),
(24, '2024_05_25_154649_create_bank_accounts_table', 1),
(25, '2024_05_25_154748_create_cash_transactions_table', 1),
(26, '2024_05_25_154809_create_bank_transactions_table', 1),
(27, '2024_05_25_154924_create_supplier_payments_table', 1),
(28, '2024_05_30_152650_create_customer_payments_table', 1),
(29, '2024_06_03_113601_create_menu_categories_table', 1),
(30, '2024_06_03_130029_create_units_table', 1),
(31, '2024_06_03_144652_create_menus_table', 1),
(32, '2024_06_03_180722_create_orders_table', 1),
(33, '2024_06_03_180755_create_order_details_table', 1),
(34, '2024_06_10_161434_create_service_heads_table', 1),
(35, '2024_06_22_131752_create_leave_types_table', 1),
(36, '2024_06_24_120604_create_leaves_table', 1),
(37, '2024_06_25_122143_create_brands_table', 1),
(38, '2024_06_25_123617_create_assets_table', 1),
(39, '2024_06_25_164312_create_purchases_table', 1),
(40, '2024_06_25_171307_create_purchase_details_table', 1),
(41, '2024_06_26_160450_create_services_table', 1),
(42, '2024_06_30_115153_create_purchase_returns_table', 1),
(43, '2024_07_03_145016_create_issues_table', 1),
(44, '2024_07_03_145218_create_issue_details_table', 1),
(45, '2024_07_07_145152_create_investment_accounts_table', 1),
(46, '2024_07_07_145313_create_investment_transactions_table', 1),
(47, '2024_07_07_154443_create_loan_accounts_table', 1),
(48, '2024_07_07_160520_create_loan_transactions_table', 1),
(49, '2024_07_09_143312_create_galleries_table', 1),
(50, '2024_07_09_152214_create_manages_table', 1),
(51, '2024_07_09_161753_create_about_pages_table', 1),
(52, '2024_07_10_122552_create_issue_returns_table', 1),
(53, '2024_07_11_104600_create_sliders_table', 1),
(54, '2024_07_13_155600_create_offers_table', 1),
(55, '2024_07_14_161807_create_materials_table', 1),
(56, '2024_07_15_144652_create_recipes_table', 1),
(57, '2024_07_16_163239_create_productions_table', 1),
(58, '2024_07_16_164334_create_production_details_table', 1),
(59, '2024_07_25_142447_create_material_purchases_table', 1),
(60, '2024_07_25_142923_create_material_purchase_details_table', 1),
(61, '2024_07_29_154051_create_disposals_table', 1),
(62, '2024_07_29_155301_create_disposal_details_table', 1),
(63, '2024_10_31_155147_create_specialties_table', 1),
(64, '2024_11_02_140626_create_specialtie_banners_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(60) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `cashPaid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `bankPaid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `returnAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice`, `date`, `customer_id`, `booking_id`, `room_id`, `customer_name`, `customer_phone`, `customer_address`, `sub_total`, `discount`, `vat`, `total`, `cashPaid`, `bankPaid`, `bank_account_id`, `returnAmount`, `paid`, `due`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'O2400001', '2024-11-03', NULL, NULL, NULL, 'Mahi', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:14:36', '2024-11-03 05:14:36', NULL, NULL, '127.0.0.1'),
(2, 'O2400002', '2024-11-03', NULL, NULL, NULL, 'Mahi', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:14:40', '2024-11-03 05:14:40', NULL, NULL, '127.0.0.1'),
(3, 'O2400003', '2024-11-03', NULL, NULL, NULL, 'Mahi', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:15:43', '2024-11-03 05:15:43', NULL, NULL, '127.0.0.1'),
(4, 'O2400004', '2024-11-03', NULL, NULL, NULL, 'Mahi', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:16:01', '2024-11-03 05:16:01', NULL, NULL, '127.0.0.1'),
(5, 'O2400005', '2024-11-03', NULL, NULL, NULL, 'Mahi', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:22:04', '2024-11-03 05:22:04', NULL, NULL, '127.0.0.1'),
(6, 'O2400006', '2024-11-03', NULL, NULL, NULL, 'MANJURUL ALAM MAHI', '01619833307', 'Kadamtoli', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', NULL, '0.00', '0.00', '1000.00', NULL, 'p', NULL, NULL, '2024-11-03 05:22:20', '2024-11-03 05:22:20', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `menu_id`, `price`, `vat`, `quantity`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:14:37', '2024-11-03 05:14:37', NULL, NULL, '127.0.0.1'),
(2, 2, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:14:40', '2024-11-03 05:14:40', NULL, NULL, '127.0.0.1'),
(3, 3, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:15:43', '2024-11-03 05:15:43', NULL, NULL, '127.0.0.1'),
(4, 4, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:16:01', '2024-11-03 05:16:01', NULL, NULL, '127.0.0.1'),
(5, 5, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:22:04', '2024-11-03 05:22:04', NULL, NULL, '127.0.0.1'),
(6, 6, 1, '500.00', '0.00', 2.00, '1000.00', 'p', NULL, NULL, '2024-11-03 05:22:20', '2024-11-03 05:22:20', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `other_customers`
--

CREATE TABLE `other_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `productions`
--

CREATE TABLE `productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `production_details`
--

CREATE TABLE `production_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `production_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` double(8,2) NOT NULL DEFAULT 0.00,
  `vatAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` double(8,2) NOT NULL DEFAULT 0.00,
  `discountAmount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `transport` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `warranty` double(8,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `menu_id`, `material_id`, `price`, `quantity`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, '100.00', 2.00, '200.00', 'a', 1, NULL, '2024-11-02 10:24:32', '2024-11-02 10:25:02', NULL, NULL, '127.0.0.1'),
(2, 2, 2, '395.00', 0.05, '19.75', 'a', 1, NULL, '2024-11-02 10:29:50', '2024-11-02 10:29:50', NULL, NULL, '127.0.0.1'),
(3, 3, 1, '100.00', 1.00, '100.00', 'a', 1, NULL, '2024-11-02 10:33:02', '2024-11-02 10:33:02', NULL, NULL, '127.0.0.1'),
(4, 4, 2, '395.00', 0.50, '197.50', 'a', 1, NULL, '2024-11-02 10:34:28', '2024-11-02 10:34:28', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `references`
--

CREATE TABLE `references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `bed` int(11) NOT NULL,
  `bath` int(11) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `note` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_head_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `service_heads`
--

CREATE TABLE `service_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(18,2) NOT NULL DEFAULT 0.00,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `sub_title` varchar(191) DEFAULT NULL,
  `btn_text` varchar(40) DEFAULT NULL,
  `btn_url` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `sub_title`, `btn_text`, `btn_url`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Cholo Ekta Table Book Kori Amra', NULL, 'Book Kori', 'http://127.0.0.1:8000/', 'uploads/slider/Cholo Ekta Table Book Kori Amra_67260ea7d3601.jpg', 'a', 1, NULL, '2024-11-02 11:36:07', '2024-11-02 11:36:07', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `title`, `price`, `description`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Title', 100, 'Test', 'uploads/specialtie/Title_6726129ab0cec.jpg', 'a', 1, NULL, '2024-11-02 11:52:58', '2024-11-02 11:52:58', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `specialtie_banners`
--

CREATE TABLE `specialtie_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialtie_banners`
--

INSERT INTO `specialtie_banners` (`id`, `image`, `updated_by`, `created_at`, `updated_at`, `last_update_ip`) VALUES
(1, 'uploads/specialtie/banner_672610a321cac.jpg', 1, '2024-11-02 09:45:57', '2024-11-02 11:44:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `office_phone` varchar(15) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `previous_due` decimal(8,2) NOT NULL DEFAULT 0.00,
  `image` varchar(191) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `type` char(5) NOT NULL COMMENT 'CP = Payment, CR = Receive',
  `method` varchar(10) NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'PCS', 'a', 1, NULL, '2024-11-02 10:22:47', '2024-11-02 10:22:47', NULL, NULL, '127.0.0.1'),
(2, 'kg', 'a', 1, NULL, '2024-11-02 10:26:30', '2024-11-02 10:26:30', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `name`, `username`, `email`, `password`, `phone`, `role`, `image`, `status`, `action`, `last_update_ip`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'U00001', 'Admin', 'admin', 'admin@gmail.com', '$2y$10$553DdMzA87PCY1kJOxJ4X.VKb/R1Npz1XeBUmtUHF2CcUsLvACkf.', '019########', 'Superadmin', NULL, 'a', NULL, '127.0.0.1', NULL, '2024-11-02 09:45:56', '2024-11-02 09:45:56', NULL),
(2, 'U00002', 'Mahi', 'mahi', 'mahi@gmail.com', '$2y$10$D8MbcMxLK21LGzBvBJqmLeCYlqy419zckW1bStUr3mQYo6S/tcN7q', '01619833307', 'admin', 'uploads/user/U00002_672768d73fb4b.jpg', 'a', NULL, '127.0.0.1', NULL, '2024-11-03 12:13:11', '2024-11-03 12:13:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_accesses`
--

CREATE TABLE `user_accesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `access` longtext DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_update_ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `page_name` text DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `page_name`, `login_time`, `logout_time`, `status`, `ip_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'http://127.0.0.1:8000/menu', '2024-11-02 15:46:18', NULL, 'a', '127.0.0.1', '2024-11-02 09:46:18', '2024-11-02 10:32:33', NULL),
(2, 1, 'Dashboard', '2024-11-02 17:34:30', NULL, 'a', '127.0.0.1', '2024-11-02 11:34:30', '2024-11-02 11:34:30', NULL),
(3, 1, 'http://127.0.0.1:8001/slider', '2024-11-02 17:35:13', NULL, 'a', '127.0.0.1', '2024-11-02 11:35:13', '2024-11-02 11:35:21', NULL),
(4, 1, 'http://127.0.0.1:8001/about', '2024-11-02 17:38:36', NULL, 'a', '127.0.0.1', '2024-11-02 11:38:36', '2024-11-02 11:38:45', NULL),
(5, 1, 'http://127.0.0.1:8001/gallery', '2024-11-02 17:43:52', NULL, 'a', '127.0.0.1', '2024-11-02 11:43:52', '2024-11-02 11:59:08', NULL),
(6, 1, 'http://127.0.0.1:8001/update-company', '2024-11-03 10:09:01', NULL, 'a', '127.0.0.1', '2024-11-03 04:09:01', '2024-11-03 04:10:13', NULL),
(7, 1, 'Logout', NULL, '2024-11-03 10:11:09', 'a', '127.0.0.1', '2024-11-03 04:11:09', '2024-11-03 04:11:09', NULL),
(8, 1, 'http://127.0.0.1:8001/update-company', '2024-11-03 10:11:51', NULL, 'a', '127.0.0.1', '2024-11-03 04:11:51', '2024-11-03 04:25:14', NULL),
(9, 1, 'http://127.0.0.1:8001/booking', '2024-11-03 15:07:13', NULL, 'a', '127.0.0.1', '2024-11-03 09:07:13', '2024-11-03 09:07:19', NULL),
(10, 1, 'http://127.0.0.1:8001/user', '2024-11-03 18:11:25', NULL, 'a', '127.0.0.1', '2024-11-03 12:11:25', '2024-11-03 12:12:29', NULL),
(11, 1, 'Logout', NULL, '2024-11-03 18:13:27', 'a', '127.0.0.1', '2024-11-03 12:13:27', '2024-11-03 12:13:27', NULL),
(12, 2, 'Dashboard', '2024-11-03 18:13:33', NULL, 'a', '127.0.0.1', '2024-11-03 12:13:33', '2024-11-03 12:13:33', NULL),
(13, 2, 'http://127.0.0.1:8001/checkin-record', '2024-11-04 09:44:37', NULL, 'a', '127.0.0.1', '2024-11-04 03:44:37', '2024-11-04 03:50:26', NULL);

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
  ADD KEY `booking_details_room_id_index` (`room_id`),
  ADD KEY `booking_details_days_index` (`days`),
  ADD KEY `booking_details_unit_price_index` (`unit_price`),
  ADD KEY `booking_details_total_index` (`total`);

--
-- Indexes for table `booking_masters`
--
ALTER TABLE `booking_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_masters_reference_id_foreign` (`reference_id`),
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
  ADD KEY `customer_payments_booking_id_foreign` (`booking_id`),
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
  ADD KEY `disposals_room_id_foreign` (`room_id`),
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
  ADD KEY `issues_room_id_foreign` (`room_id`),
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
  ADD KEY `issue_returns_room_id_foreign` (`room_id`),
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
  ADD KEY `orders_room_id_foreign` (`room_id`),
  ADD KEY `orders_booking_id_foreign` (`booking_id`),
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
-- Indexes for table `other_customers`
--
ALTER TABLE `other_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_customers_added_by_foreign` (`added_by`),
  ADD KEY `other_customers_updated_by_foreign` (`updated_by`),
  ADD KEY `other_customers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `other_customers_booking_id_index` (`booking_id`),
  ADD KEY `other_customers_room_id_index` (`room_id`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_added_by_foreign` (`added_by`),
  ADD KEY `rooms_updated_by_foreign` (`updated_by`),
  ADD KEY `rooms_deleted_by_foreign` (`deleted_by`),
  ADD KEY `rooms_code_index` (`code`),
  ADD KEY `rooms_floor_id_index` (`floor_id`),
  ADD KEY `rooms_category_id_index` (`category_id`),
  ADD KEY `rooms_room_type_id_index` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_types_added_by_foreign` (`added_by`),
  ADD KEY `room_types_updated_by_foreign` (`updated_by`),
  ADD KEY `room_types_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_room_id_foreign` (`room_id`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_masters`
--
ALTER TABLE `booking_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposals`
--
ALTER TABLE `disposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposal_details`
--
ALTER TABLE `disposal_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_payments`
--
ALTER TABLE `employee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_payment_details`
--
ALTER TABLE `employee_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `investment_accounts`
--
ALTER TABLE `investment_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_transactions`
--
ALTER TABLE `investment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_details`
--
ALTER TABLE `issue_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_returns`
--
ALTER TABLE `issue_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manages`
--
ALTER TABLE `manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_purchases`
--
ALTER TABLE `material_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_purchase_details`
--
ALTER TABLE `material_purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `other_customers`
--
ALTER TABLE `other_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_heads`
--
ALTER TABLE `service_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `specialtie_banners`
--
ALTER TABLE `specialtie_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_accesses`
--
ALTER TABLE `user_accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  ADD CONSTRAINT `booking_details_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `booking_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_details_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `booking_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_masters`
--
ALTER TABLE `booking_masters`
  ADD CONSTRAINT `booking_masters_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_masters_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `booking_masters_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_masters_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `references` (`id`),
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
  ADD CONSTRAINT `customer_payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `customer_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
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
  ADD CONSTRAINT `disposals_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
  ADD CONSTRAINT `issues_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
  ADD CONSTRAINT `issue_returns_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
  ADD CONSTRAINT `orders_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
-- Constraints for table `other_customers`
--
ALTER TABLE `other_customers`
  ADD CONSTRAINT `other_customers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `other_customers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `other_customers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `other_customers_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rooms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `rooms_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`),
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`),
  ADD CONSTRAINT `rooms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `room_types`
--
ALTER TABLE `room_types`
  ADD CONSTRAINT `room_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `room_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `room_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_masters` (`id`),
  ADD CONSTRAINT `services_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `services_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `services_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
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
