-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 11:44 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `table_id` bigint(20) UNSIGNED NOT NULL,
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
(1, 'UK Restaurent', 'UK Restaurent', '01619833307', 'ukrestaurent96@gmail.com', 'Mirpur 10', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29203.581321715606!2d90.3610368!3d23.802675200000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c102e2ece5bb%3A0x446e9dc895326a70!2sBangladesh%20National%20Zoo!5e0!3m2!1sen!2sbd!4v1730612747516!5m2!1sen!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, NULL, NULL, NULL, 'BDT', 1, 'uploads/logo/_672857cdf0173.png', 'uploads/favicon/_672857cdf0b94.png', '127.0.0.1', '2024-11-02 09:45:56', '2024-11-04 05:12:45');

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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `code`, `name`, `phone`, `email`, `nid`, `gender`, `previous_due`, `district_id`, `reference_id`, `address`, `image`, `password`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(2, 'C00001', 'Juwel Mahmud', '01754-525252', NULL, NULL, NULL, '0.00', NULL, NULL, 'Test Address', NULL, NULL, 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Admin', 'a', 1, NULL, '2024-11-04 11:21:00', '2024-11-04 11:21:00', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Service Provider', 'a', 1, NULL, '2024-07-28 00:51:29', '2024-07-28 00:51:29', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `disposals`
--

CREATE TABLE `disposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
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

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Dhaka', 'a', 1, NULL, '2024-07-28 00:45:27', '2024-07-28 00:45:27', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `code`, `name`, `designation_id`, `department_id`, `bio_id`, `joining`, `gender`, `dob`, `nid_no`, `phone`, `email`, `marital_status`, `father_name`, `mother_name`, `present_address`, `permanent_address`, `image`, `salary`, `reference`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'E00001', 'Mirza Masud', 1, 1, '10001', '2020-08-01', 'Male', '1999-11-04', NULL, '01619833307', 'ukrestaurent96@gmail.com', 'married', 'Test Father', 'Test Mother', 'Test P. Address', 'Test Pr. Address', 'uploads/employee/E00001_6728ae64d408a.jpg', '999999.99', 'Testing Reference', 'a', 1, NULL, '2024-11-04 11:22:12', '2024-11-04 11:22:12', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `position`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '1st', 1, 'a', 1, NULL, '2024-07-27 23:22:07', '2024-07-27 23:22:07', NULL, NULL, '127.0.0.1');

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
  `table_id` bigint(20) UNSIGNED NOT NULL,
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
  `table_id` bigint(20) UNSIGNED NOT NULL,
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

--
-- Dumping data for table `manages`
--

INSERT INTO `manages` (`id`, `code`, `name`, `phone`, `email`, `designation_id`, `address`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'M00001', 'Mr Alamin', '00000000000', 'example@gmail.com', 1, 'Dhaka, Bangladesh', 'uploads/manage/M00001_66a5ebc12246d.jpg', 'a', 1, NULL, '2024-07-28 00:57:05', '2024-07-28 00:57:05', NULL, NULL, '127.0.0.1'),
(2, 'C00002', 'Mr Mehedi Hassan', '0000000000', 'example@gmail.com', 1, 'Dhaka, Bangladesh', 'uploads/manage/C00002_66a5ebe887530.webp', 'a', 1, NULL, '2024-07-28 00:57:44', '2024-07-28 00:57:44', NULL, NULL, '127.0.0.1'),
(3, 'C00003', 'Mr Atik Hasan', '0170000000', 'example@gmail.com', 1, 'Dhaka , Bangladesh', 'uploads/manage/C00003_66a5ec0feec91.png', 'a', 1, 1, '2024-07-28 00:58:15', '2024-07-28 00:58:23', NULL, NULL, '127.0.0.1'),
(4, 'C00004', 'Md Azahar Islam', '01700000000', 'azahar@gmail.com', 1, 'Dhaka , Bangladesh', 'uploads/manage/C00004_66a5ec3d38d0a.jpeg', 'a', 1, NULL, '2024-07-28 00:59:09', '2024-07-28 00:59:09', NULL, NULL, '127.0.0.1'),
(5, 'C00005', 'Alhaque shuvo', '0173501201', 'shuvo@gmail.com', 1, 'Dhaka', 'uploads/manage/C00005_66a5ec612c2d0.jpg', 'a', 1, NULL, '2024-07-28 00:59:45', '2024-07-28 00:59:45', NULL, NULL, '127.0.0.1');

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
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `order_type` varchar(55) NOT NULL DEFAULT 'PayFirst',
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

INSERT INTO `orders` (`id`, `invoice`, `date`, `customer_id`, `booking_id`, `table_id`, `customer_name`, `customer_phone`, `customer_address`, `sub_total`, `discount`, `vat`, `total`, `cashPaid`, `bankPaid`, `bank_account_id`, `returnAmount`, `paid`, `due`, `note`, `order_type`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'O2400001', '2024-11-06', 2, NULL, NULL, NULL, NULL, NULL, '2120.00', '127.20', '84.80', '2077.60', '2200.00', '0.00', NULL, '122.40', '2200.00', '2077.60', 'Tet Order Invoice', 'PayFirst', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(2, 'O2400002', '2024-11-06', NULL, NULL, NULL, 'Cash Customer', '01582141', 'Test Invocie', '1560.00', '78.00', '265.20', '1747.20', '2000.00', '0.00', NULL, '252.80', '2000.00', '0.00', 'Test', 'Order', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1');

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
(1, 1, 1, '500.00', '0.00', 4.00, '2000.00', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(2, 1, 3, '120.00', '0.00', 1.00, '120.00', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(3, 2, 1, '500.00', '0.00', 3.00, '1500.00', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1'),
(4, 2, 3, '30.00', '0.00', 2.00, '60.00', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `order_tables`
--

CREATE TABLE `order_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
  `incharge_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `booking_status` varchar(20) NOT NULL DEFAULT 'booked' COMMENT 'booked, available',
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
-- Dumping data for table `order_tables`
--

INSERT INTO `order_tables` (`id`, `order_id`, `table_id`, `incharge_id`, `date`, `booking_status`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 27, 1, '2024-11-06', 'booked', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(2, 1, 17, 1, '2024-11-06', 'booked', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(3, 2, 1, 1, '2024-11-06', 'booked', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1'),
(4, 2, 28, 1, '2024-11-06', 'booked', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `other_customers`
--

CREATE TABLE `other_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
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

--
-- Dumping data for table `productions`
--

INSERT INTO `productions` (`id`, `invoice`, `date`, `order_id`, `total`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'PR240001', '2024-11-04', 7, '200.00', 'Order production invoice -O2400007', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(2, 'PR240002', '2024-11-04', 7, '19.75', 'Order production invoice -O2400007', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(3, 'PR240003', '2024-11-04', 7, '100.00', 'Order production invoice -O2400007', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(4, 'PR240004', '2024-11-04', 7, '197.50', 'Order production invoice -O2400007', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(5, 'PR240005', '2024-11-04', 8, '200.00', 'Order production invoice -O2400008', 'a', 1, NULL, '2024-11-04 06:30:19', '2024-11-04 06:30:19', NULL, NULL, '127.0.0.1'),
(6, 'PR240006', '2024-11-04', 8, '100.00', 'Order production invoice -O2400008', 'a', 1, NULL, '2024-11-04 06:30:19', '2024-11-04 06:30:19', NULL, NULL, '127.0.0.1'),
(7, 'PR240007', '2024-11-05', 9, '197.50', 'Order production invoice -O2400009', 'a', 1, 1, '2024-11-05 05:47:06', '2024-11-05 08:56:40', NULL, NULL, '127.0.0.1'),
(8, 'PR240008', '2024-11-05', 9, '19.75', 'Order production invoice -O2400009', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(9, 'PR240009', '2024-11-05', 9, '100.00', 'Order production invoice -O2400009', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(10, 'PR240010', '2024-11-05', 9, '197.50', 'Order production invoice -O2400009', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(11, 'PR240011', '2024-11-06', 10, '200.00', 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(12, 'PR240012', '2024-11-06', 10, '19.75', 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(13, 'PR240013', '2024-11-06', 10, '100.00', 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(14, 'PR240014', '2024-11-06', 10, '197.50', 'Order production invoice -O2400010', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(15, 'PR240015', '2024-11-06', 11, '200.00', 'Order production invoice -O2400011', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(16, 'PR240016', '2024-11-06', 11, '19.75', 'Order production invoice -O2400011', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(17, 'PR240017', '2024-11-06', 11, '197.50', 'Order production invoice -O2400011', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(26, 'PR240018', '2024-11-06', 14, '100.00', 'Order production invoice -O2400012', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(27, 'PR240019', '2024-11-06', 14, '200.00', 'Order production invoice -O2400012', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(28, 'PR240020', '2024-11-06', 14, '19.75', 'Order production invoice -O2400012', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(29, 'PR240021', '2024-11-06', 14, '197.50', 'Order production invoice -O2400012', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(30, 'PR240022', '2024-11-06', 15, '100.00', 'Order production invoice -O2400013', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(31, 'PR240023', '2024-11-06', 15, '200.00', 'Order production invoice -O2400013', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(32, 'PR240024', '2024-11-06', 15, '19.75', 'Order production invoice -O2400013', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(33, 'PR240025', '2024-11-06', 15, '197.50', 'Order production invoice -O2400013', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(34, 'PR240026', '2024-11-06', 16, '100.00', 'Order production invoice -O2400014', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(35, 'PR240027', '2024-11-06', 16, '200.00', 'Order production invoice -O2400014', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(36, 'PR240028', '2024-11-06', 16, '19.75', 'Order production invoice -O2400014', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(37, 'PR240029', '2024-11-06', 16, '197.50', 'Order production invoice -O2400014', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(38, 'PR240030', '2024-11-06', 17, '197.50', 'Order production invoice -O2400015', 'a', 1, NULL, '2024-11-06 08:36:48', '2024-11-06 08:36:48', NULL, NULL, '127.0.0.1'),
(39, 'PR240031', '2024-11-06', 17, '100.00', 'Order production invoice -O2400015', 'a', 1, NULL, '2024-11-06 08:36:48', '2024-11-06 08:36:48', NULL, NULL, '127.0.0.1'),
(40, 'PR240032', '2024-11-06', 1, '200.00', 'Order production invoice -O2400001', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(41, 'PR240033', '2024-11-06', 1, '100.00', 'Order production invoice -O2400001', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(42, 'PR240034', '2024-11-06', 2, '200.00', 'Order production invoice -O2400002', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1'),
(43, 'PR240035', '2024-11-06', 2, '100.00', 'Order production invoice -O2400002', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `production_details`
--

INSERT INTO `production_details` (`id`, `production_id`, `material_id`, `quantity`, `price`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(2, 2, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(3, 3, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(4, 4, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-04 05:24:06', '2024-11-04 05:24:06', NULL, NULL, '127.0.0.1'),
(5, 5, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-04 06:30:19', '2024-11-04 06:30:19', NULL, NULL, '127.0.0.1'),
(6, 6, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-04 06:30:19', '2024-11-04 06:30:19', NULL, NULL, '127.0.0.1'),
(8, 8, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(9, 9, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(10, 10, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-05 05:47:06', '2024-11-05 05:47:06', NULL, NULL, '127.0.0.1'),
(18, 7, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-05 08:56:40', '2024-11-05 08:56:40', NULL, NULL, '127.0.0.1'),
(19, 11, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(20, 12, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(21, 13, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(22, 14, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 05:33:39', '2024-11-06 05:33:39', NULL, NULL, '127.0.0.1'),
(23, 15, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(24, 16, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(25, 17, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 05:36:34', '2024-11-06 05:36:34', NULL, NULL, '127.0.0.1'),
(34, 26, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(35, 27, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(36, 28, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(37, 29, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 07:01:23', '2024-11-06 07:01:23', NULL, NULL, '127.0.0.1'),
(38, 30, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(39, 31, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(40, 32, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(41, 33, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 07:02:52', '2024-11-06 07:02:52', NULL, NULL, '127.0.0.1'),
(42, 34, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(43, 35, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(44, 36, 2, 0.05, '395.00', '19.75', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(45, 37, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 08:20:23', '2024-11-06 08:20:23', NULL, NULL, '127.0.0.1'),
(46, 38, 2, 0.50, '395.00', '197.50', 'a', 1, NULL, '2024-11-06 08:36:48', '2024-11-06 08:36:48', NULL, NULL, '127.0.0.1'),
(47, 39, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 08:36:48', '2024-11-06 08:36:48', NULL, NULL, '127.0.0.1'),
(48, 40, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(49, 41, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 08:42:40', '2024-11-06 08:42:40', NULL, NULL, '127.0.0.1'),
(50, 42, 1, 2.00, '100.00', '200.00', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1'),
(51, 43, 1, 1.00, '100.00', '100.00', 'a', 1, NULL, '2024-11-06 09:07:22', '2024-11-06 09:07:22', NULL, NULL, '127.0.0.1');

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
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
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

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `name`, `type`, `phone`, `email`, `office_phone`, `address`, `owner_name`, `contact_person`, `district_id`, `previous_due`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'S00001', 'Chester Rhodes', 'retail', '0170000000', NULL, NULL, 'Bangladesh', 'Chester Rhodes', NULL, 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 00:45:45', '2024-07-28 00:45:45', NULL, NULL, '127.0.0.1');

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
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `incharge_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `table_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `capacity` varchar(55) NOT NULL,
  `location` text DEFAULT NULL,
  `bed` int(11) DEFAULT NULL,
  `bath` int(11) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
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

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `code`, `floor_id`, `incharge_id`, `category_id`, `table_type_id`, `name`, `capacity`, `location`, `bed`, `bath`, `price`, `note`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'R00001', 1, 1, 1, 2, '101', '', NULL, 2, 2, '3000.00', NULL, 'uploads/room/R00001_66a5d5d32ec65.jpg', 'a', 1, 1, '2024-07-27 23:23:31', '2024-07-27 23:24:18', NULL, NULL, '127.0.0.1'),
(2, 'R00002', 1, 0, 1, 1, '102', '', NULL, 1, 1, '1800.00', NULL, 'uploads/room/R00002_66a5d5f90a590.jpg', 'a', 1, NULL, '2024-07-27 23:24:09', '2024-07-27 23:24:09', NULL, NULL, '127.0.0.1'),
(3, 'R00003', 1, 1, 2, 1, '103', '', NULL, 0, 0, '1500.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:24:39', '2024-07-27 23:24:39', NULL, NULL, '127.0.0.1'),
(4, 'R00004', 1, 0, 2, 1, '104', '', NULL, 0, 0, '1500.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:24:51', '2024-07-27 23:24:51', NULL, NULL, '127.0.0.1'),
(5, 'R00005', 1, 0, 2, 2, '105', '', NULL, 0, 0, '2200.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:25:09', '2024-07-27 23:25:09', NULL, NULL, '127.0.0.1'),
(6, 'R00006', 1, 0, 1, 2, '106', '', NULL, 2, 2, '3000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:25:40', '2024-07-27 23:25:40', NULL, NULL, '127.0.0.1'),
(7, 'R00007', 1, 1, 1, 2, '201', '', NULL, 0, 0, '2700.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:25:51', '2024-07-27 23:25:51', NULL, NULL, '127.0.0.1'),
(8, 'R00008', 1, 0, 1, 1, '202', '', NULL, 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:26:04', '2024-07-27 23:26:04', NULL, NULL, '127.0.0.1'),
(9, 'R00009', 1, 0, 1, 1, '203', '', NULL, 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:26:17', '2024-07-27 23:26:17', NULL, NULL, '127.0.0.1'),
(10, 'R00010', 1, 0, 2, 1, '204', '', NULL, 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:26:39', '2024-07-27 23:26:39', NULL, NULL, '127.0.0.1'),
(11, 'R00011', 1, 0, 2, 2, '205', '', NULL, 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:26:59', '2024-07-27 23:26:59', NULL, NULL, '127.0.0.1'),
(12, 'R00012', 1, 0, 1, 2, '301', '', NULL, 0, 0, '3000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:27:14', '2024-07-27 23:27:14', NULL, NULL, '127.0.0.1'),
(13, 'R00013', 1, 0, 1, 1, '302', '', NULL, 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:27:30', '2024-07-27 23:27:30', NULL, NULL, '127.0.0.1'),
(14, 'R00014', 1, 0, 1, 1, '303', '', NULL, 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:27:41', '2024-07-27 23:27:41', NULL, NULL, '127.0.0.1'),
(15, 'R00015', 1, 0, 2, 2, '304', '', NULL, 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:27:57', '2024-07-27 23:27:57', NULL, NULL, '127.0.0.1'),
(16, 'R00016', 1, 0, 2, 1, '305', '', NULL, 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:28:26', '2024-07-27 23:28:26', NULL, NULL, '127.0.0.1'),
(17, 'R00017', 1, 0, 1, 1, '401', '', NULL, 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:32:07', '2024-07-27 23:32:07', NULL, NULL, '127.0.0.1'),
(18, 'R00018', 1, 0, 1, 1, '402', '', NULL, 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:32:24', '2024-07-27 23:32:24', NULL, NULL, '127.0.0.1'),
(19, 'R00019', 1, 0, 2, 1, '403', '', NULL, 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:32:43', '2024-07-27 23:32:43', NULL, NULL, '127.0.0.1'),
(20, 'R00020', 1, 0, 1, 2, '405', '', NULL, 0, 0, '2800.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:33:12', '2024-07-27 23:33:12', NULL, NULL, '127.0.0.1'),
(21, 'R00021', 1, 0, 2, 2, '405', '', NULL, 0, 0, '2300.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:33:28', '2024-07-27 23:33:28', NULL, NULL, '127.0.0.1'),
(22, 'R00022', 1, 0, 1, 1, '501', '', NULL, 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:34:00', '2024-07-27 23:34:00', NULL, NULL, '127.0.0.1'),
(23, 'R00023', 1, 0, 2, 1, '502', '', NULL, 0, 0, '1200.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:34:13', '2024-07-27 23:34:13', NULL, NULL, '127.0.0.1'),
(24, 'R00024', 1, 0, 1, 2, '503', '', NULL, 0, 0, '2500.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:34:29', '2024-07-27 23:34:29', NULL, NULL, '127.0.0.1'),
(25, 'R00025', 1, 0, 2, 2, '504', '', NULL, 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:35:05', '2024-07-27 23:35:05', NULL, NULL, '127.0.0.1'),
(26, 'R00026', 1, 0, 1, 1, '505', '', NULL, 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-27 23:35:43', '2024-07-27 23:35:43', NULL, NULL, '127.0.0.1'),
(27, 'T00027', 1, 1, NULL, 2, 'Table 1', '4', 'Table 1', NULL, NULL, NULL, NULL, 'uploads/table/T00027_6729ae659fb59.jpg', 'a', 1, 1, '2024-11-05 05:28:49', '2024-11-06 05:54:59', NULL, NULL, '127.0.0.1'),
(28, 'T00028', 1, 1, NULL, 5, 'Table 2', '5', 'Table 2', NULL, NULL, NULL, NULL, 'uploads/table/T00028_6729ae56e06c4.jpg', 'a', 1, 1, '2024-11-05 05:31:39', '2024-11-06 05:54:43', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `table_types`
--

CREATE TABLE `table_types` (
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

--
-- Dumping data for table `table_types`
--

INSERT INTO `table_types` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Classic', 'classic', 'a', 1, 1, '2024-07-27 23:21:43', '2024-11-04 09:03:20', NULL, NULL, '127.0.0.1'),
(2, 'Premium', 'premium', 'a', 1, 1, '2024-07-27 23:21:52', '2024-11-04 09:03:13', NULL, NULL, '127.0.0.1'),
(3, 'Test Table Type', 'test-table-type', 'd', 1, 1, '2024-11-04 09:02:02', '2024-11-04 09:02:18', 1, '2024-11-04 09:02:18', '127.0.0.1'),
(4, 'Dining', 'dining', 'a', 1, NULL, '2024-11-04 09:14:59', '2024-11-04 09:14:59', NULL, NULL, '127.0.0.1'),
(5, 'Outdoor', 'outdoor', 'a', 1, NULL, '2024-11-04 09:15:05', '2024-11-04 09:15:05', NULL, NULL, '127.0.0.1');

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
(13, 2, 'http://127.0.0.1:8001/checkin-record', '2024-11-04 09:44:37', NULL, 'a', '127.0.0.1', '2024-11-04 03:44:37', '2024-11-04 03:50:26', NULL),
(14, 1, 'http://127.0.0.1:8000/room', '2024-11-04 11:10:44', NULL, 'a', '127.0.0.1', '2024-11-04 05:10:44', '2024-11-04 05:13:03', NULL),
(15, 1, 'Logout', NULL, '2024-11-04 11:13:09', 'a', '127.0.0.1', '2024-11-04 05:13:09', '2024-11-04 05:13:09', NULL),
(16, 1, 'http://127.0.0.1:8000/user', '2024-11-04 11:13:15', NULL, 'a', '127.0.0.1', '2024-11-04 05:13:15', '2024-11-04 06:00:17', NULL),
(17, 1, 'Logout', NULL, '2024-11-04 12:00:27', 'a', '127.0.0.1', '2024-11-04 06:00:27', '2024-11-04 06:00:27', NULL),
(18, 1, 'http://127.0.0.1:8000/payFirst', '2024-11-04 12:00:31', NULL, 'a', '127.0.0.1', '2024-11-04 06:00:31', '2024-11-04 08:53:09', NULL),
(19, 1, 'Logout', NULL, '2024-11-04 14:57:14', 'a', '127.0.0.1', '2024-11-04 08:57:14', '2024-11-04 08:57:14', NULL),
(20, 1, 'Dashboard', '2024-11-04 14:57:18', NULL, 'a', '127.0.0.1', '2024-11-04 08:57:18', '2024-11-04 08:57:18', NULL),
(21, 1, 'Logout', NULL, '2024-11-04 14:57:58', 'a', '127.0.0.1', '2024-11-04 08:57:58', '2024-11-04 08:57:58', NULL),
(22, 1, 'http://127.0.0.1:8000/table', '2024-11-04 14:58:03', NULL, 'a', '127.0.0.1', '2024-11-04 08:58:03', '2024-11-04 11:22:16', NULL),
(23, 1, 'http://127.0.0.1:8000/order', '2024-11-05 10:52:00', NULL, 'a', '127.0.0.1', '2024-11-05 04:52:00', '2024-11-05 06:16:23', NULL),
(24, 1, 'http://127.0.0.1:8000/order', '2024-11-05 14:54:33', NULL, 'a', '127.0.0.1', '2024-11-05 08:54:33', '2024-11-05 10:51:26', NULL),
(25, 1, 'Logout', NULL, '2024-11-05 17:45:12', 'a', '127.0.0.1', '2024-11-05 11:45:12', '2024-11-05 11:45:12', NULL),
(26, 1, 'http://127.0.0.1:8000/order', '2024-11-05 17:45:28', NULL, 'a', '127.0.0.1', '2024-11-05 11:45:28', '2024-11-05 11:53:15', NULL),
(27, 1, 'http://127.0.0.1:8000/order/2', '2024-11-06 09:58:23', NULL, 'a', '127.0.0.1', '2024-11-06 03:58:23', '2024-11-06 10:39:37', NULL);

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
  ADD KEY `booking_details_days_index` (`days`),
  ADD KEY `booking_details_unit_price_index` (`unit_price`),
  ADD KEY `booking_details_total_index` (`total`),
  ADD KEY `booking_details_table_id_index` (`table_id`) USING BTREE;

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
  ADD KEY `disposals_added_by_foreign` (`added_by`),
  ADD KEY `disposals_updated_by_foreign` (`updated_by`),
  ADD KEY `disposals_deleted_by_foreign` (`deleted_by`),
  ADD KEY `disposals_status_index` (`status`),
  ADD KEY `disposals_table_id_index` (`table_id`) USING BTREE;

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
  ADD KEY `issues_status_index` (`status`),
  ADD KEY `issues_table_id_foreign` (`table_id`) USING BTREE;

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
  ADD KEY `issue_returns_status_index` (`status`),
  ADD KEY `issue_returns_table_id_foreign` (`table_id`) USING BTREE;

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
  ADD KEY `order_tables_added_by_foreign` (`added_by`) USING BTREE,
  ADD KEY `order_tables_updated_by_foreign` (`updated_by`) USING BTREE,
  ADD KEY `order_tables_deleted_by_foreign` (`deleted_by`) USING BTREE,
  ADD KEY `order_tables_table_id_index` (`table_id`) USING BTREE,
  ADD KEY `order_tables_order_id_index` (`order_id`) USING BTREE,
  ADD KEY `order_tables_incharge_id_index` (`incharge_id`) USING BTREE;

--
-- Indexes for table `other_customers`
--
ALTER TABLE `other_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_customers_added_by_foreign` (`added_by`),
  ADD KEY `other_customers_updated_by_foreign` (`updated_by`),
  ADD KEY `other_customers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `other_customers_booking_id_index` (`booking_id`),
  ADD KEY `other_customers_table_id_index` (`table_id`) USING BTREE;

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
  ADD KEY `services_status_index` (`status`),
  ADD KEY `services_table_id_foreign` (`table_id`) USING BTREE;

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
  ADD KEY `tables_added_by_foreign` (`added_by`) USING BTREE,
  ADD KEY `tables_updated_by_foreign` (`updated_by`) USING BTREE,
  ADD KEY `tables_deleted_by_foreign` (`deleted_by`) USING BTREE,
  ADD KEY `tables_code_index` (`code`) USING BTREE,
  ADD KEY `tables_floor_id_index` (`floor_id`) USING BTREE,
  ADD KEY `tables_table_type_id_index` (`table_type_id`) USING BTREE,
  ADD KEY `tables_incharge_id_index` (`incharge_id`) USING BTREE;

--
-- Indexes for table `table_types`
--
ALTER TABLE `table_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_types_added_by_foreign` (`added_by`),
  ADD KEY `room_types_updated_by_foreign` (`updated_by`),
  ADD KEY `room_types_deleted_by_foreign` (`deleted_by`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_masters`
--
ALTER TABLE `booking_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issue_details`
--
ALTER TABLE `issue_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_tables`
--
ALTER TABLE `order_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `table_types`
--
ALTER TABLE `table_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  ADD CONSTRAINT `booking_details_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `disposals_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `issues_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `issue_returns_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `orders_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `other_customers_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `services_room_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
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
  ADD CONSTRAINT `rooms_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rooms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `rooms_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`),
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`table_type_id`) REFERENCES `table_types` (`id`),
  ADD CONSTRAINT `rooms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `table_types`
--
ALTER TABLE `table_types`
  ADD CONSTRAINT `room_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `room_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `room_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

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
