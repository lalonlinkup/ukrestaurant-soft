-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2024 at 04:55 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `justtscc_tsc_db`
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
(1, 'Welcome To TSC', 'Welcome To UK Restaurent', '<p>Jashore University of Science and Technology (JUST) has started a steady journey of reaching a new height of excellence in research and to achieve a unique milestone in promoting new ideas and innovation, and in serving the nation and the global community by creating enlightened and skilled professionals who can meet the challenges of the 21st century fostering the motto of ‘being the employer, not the employee’. In keeping with this purpose, JUST has already been declared a research university that aims at generating and advancing knowledge by cutting-edge research in its state-of-the-art laboratories and in the congenial academic ambience. Apart from these, JUST has international and local collaboration with a wide range of reputed academia and industry. Our focus is also on promoting intellectual leadership through innovation and outcome-based education, and fostering social commitment through community affiliation. It gives me immense pleasure that the concerted efforts of the faculty members and students both from home and abroad have added feathers in our cap. In order to achieve the rest of the noble goals and turn our country into the golden Bengal envisioned by the Father of the Nation Bangabandhu Sheikh Mujibur Rahman, we all have to work together relentlessly and wholeheartedly.</p>', 'uploads/about/Welcome To TSC_66a601f36bba0.jpg', 'a', 1, '2024-07-28 08:26:55', '2024-10-31 09:45:38', '127.0.0.1');

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

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `code`, `name`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'A00001', 'Mobile Bill', NULL, 'a', 1, NULL, '2024-08-29 05:11:35', '2024-08-29 05:11:35', NULL, NULL, '119.40.87.9');

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

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `code`, `brand_id`, `unit_id`, `origin`, `price`, `is_active`, `is_serial`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'HP 22inc monitor', 'A001', 1, 1, 'Japan', '25000.00', 1, 0, NULL, 'a', 1, NULL, '2024-07-28 06:42:57', '2024-07-28 06:42:57', NULL, NULL, '127.0.0.1'),
(2, 'Click light', 'A002', 3, 1, 'Bangladesh', '150.00', 1, 0, NULL, 'a', 1, NULL, '2024-07-28 06:44:12', '2024-07-28 06:44:12', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `room_id`, `checkin_date`, `checkout_date`, `days`, `unit_price`, `total`, `checkout_status`, `booking_status`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, '2024-07-28 12:00:00', '2024-07-29 11:59:00', 1, '3000.00', '3000.00', 'false', 'booked', 'a', 1, NULL, '2024-07-28 09:44:56', '2024-07-28 09:44:56', NULL, NULL, '127.0.0.1'),
(2, 2, 2, '2024-07-29 12:00:00', '2024-07-30 11:59:00', 1, '1800.00', '1800.00', 'false', 'checkin', 'a', 1, NULL, '2024-07-28 10:46:51', '2024-07-28 10:46:51', NULL, NULL, '127.0.0.1'),
(3, 3, 2, '2024-07-28 12:00:00', '2024-07-29 11:59:00', 1, '1800.00', '1800.00', 'false', 'checkin', 'a', 1, NULL, '2024-07-28 10:51:50', '2024-07-28 10:51:50', NULL, NULL, '127.0.0.1'),
(5, 4, 2, '2024-07-30 12:00:00', '2024-07-31 11:59:00', 1, '1800.00', '1800.00', 'false', 'checkin', 'a', 1, 1, '2024-07-30 11:32:44', '2024-07-30 11:32:44', NULL, NULL, '103.159.73.224'),
(6, 5, 1, '2024-07-30 12:00:00', '2024-07-31 11:59:00', 1, '3000.00', '3000.00', 'false', 'booked', 'a', 1, NULL, '2024-07-30 11:49:57', '2024-07-30 11:49:57', NULL, NULL, '103.159.73.224'),
(7, 6, 9, '2024-07-30 12:00:00', '2024-07-31 11:59:00', 1, '2000.00', '2000.00', 'false', 'booked', 'a', 1, NULL, '2024-07-30 11:50:21', '2024-07-30 11:50:21', NULL, NULL, '103.159.73.224'),
(8, 6, 11, '2024-07-30 12:00:00', '2024-07-31 11:59:00', 1, '2000.00', '2000.00', 'false', 'booked', 'a', 1, NULL, '2024-07-30 11:50:21', '2024-07-30 11:50:21', NULL, NULL, '103.159.73.224'),
(9, 6, 16, '2024-07-30 12:00:00', '2024-07-31 11:59:00', 1, '1300.00', '1300.00', 'false', 'booked', 'a', 1, NULL, '2024-07-30 11:50:21', '2024-07-30 11:50:21', NULL, NULL, '103.159.73.224'),
(10, 7, 1, '2024-08-01 12:00:00', '2024-08-05 11:59:00', 4, '3000.00', '12000.00', 'false', 'booked', 'a', 1, NULL, '2024-07-31 07:55:49', '2024-07-31 07:55:49', NULL, NULL, '103.159.73.224'),
(12, 9, 4, '2024-07-31 12:00:00', '2024-08-02 11:59:00', 2, '1500.00', '3000.00', 'false', 'checkin', 'a', 1, NULL, '2024-07-31 09:27:06', '2024-07-31 09:27:06', NULL, NULL, '103.159.73.224'),
(13, 10, 4, '2024-08-02 12:00:00', '2024-08-03 11:59:00', 1, '1500.00', '1500.00', 'false', 'booked', 'a', 1, NULL, '2024-07-31 09:34:12', '2024-07-31 09:34:12', NULL, NULL, '103.159.73.224'),
(14, 8, 3, '2024-07-31 12:00:00', '2024-08-07 11:59:00', 7, '1500.00', '10500.00', 'false', 'checkin', 'a', 1, 1, '2024-07-31 09:34:46', '2024-07-31 09:34:46', NULL, NULL, '103.159.73.224'),
(15, 11, 3, '2024-09-20 12:00:00', '2024-09-21 11:59:00', 1, '1500.00', '1500.00', 'false', 'booked', 'a', 1, NULL, '2024-09-19 18:29:09', '2024-09-19 18:29:09', NULL, NULL, '45.114.91.96'),
(16, 12, 10, '2024-09-20 12:00:00', '2024-09-23 11:59:00', 3, '1300.00', '3900.00', 'false', 'checkin', 'a', 1, NULL, '2024-09-19 18:29:41', '2024-09-19 18:29:41', NULL, NULL, '45.114.91.96'),
(17, 13, 4, '2024-09-20 12:00:00', '2024-09-23 11:59:00', 3, '1500.00', '4500.00', 'false', 'booked', 'a', 1, NULL, '2024-09-19 18:41:22', '2024-09-19 18:41:22', NULL, NULL, '45.114.91.96'),
(18, 14, 3, '2024-10-06 12:00:00', '2024-10-24 11:59:00', 18, '1500.00', '27000.00', 'false', 'booked', 'a', 1, NULL, '2024-10-06 08:58:23', '2024-10-06 08:58:23', NULL, NULL, '103.159.73.93'),
(19, 14, 15, '2024-10-06 12:00:00', '2024-11-01 11:59:00', 26, '1700.00', '44200.00', 'false', 'booked', 'a', 1, NULL, '2024-10-06 08:58:23', '2024-10-06 08:58:23', NULL, NULL, '103.159.73.93'),
(20, 15, 14, '2024-10-06 12:00:00', '2024-10-31 11:59:00', 25, '1800.00', '45000.00', 'false', 'checkin', 'a', 1, NULL, '2024-10-06 08:58:55', '2024-10-06 08:58:55', NULL, NULL, '103.159.73.93'),
(21, 16, 6, '2024-10-19 12:00:00', '2024-10-20 11:59:00', 1, '3000.00', '3000.00', 'true', 'checkout', 'a', 1, 1, '2024-10-19 11:46:03', '2024-10-19 11:49:28', NULL, NULL, '103.159.73.88'),
(22, 16, 7, '2024-10-19 12:00:00', '2024-10-21 11:59:00', 1, '2700.00', '2700.00', 'true', 'checkout', 'a', 1, 1, '2024-10-19 11:46:03', '2024-10-19 11:47:17', NULL, NULL, '103.159.73.88'),
(23, 17, 26, '2024-10-19 12:00:00', '2024-10-20 11:59:00', 1, '1700.00', '1700.00', 'false', 'booked', 'a', 1, NULL, '2024-10-19 11:50:54', '2024-10-19 11:50:54', NULL, NULL, '103.159.73.88'),
(24, 17, 25, '2024-10-19 12:00:00', '2024-10-20 11:59:00', 1, '1800.00', '1800.00', 'false', 'booked', 'a', 1, NULL, '2024-10-19 11:50:54', '2024-10-19 11:50:54', NULL, NULL, '103.159.73.88');

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

--
-- Dumping data for table `booking_masters`
--

INSERT INTO `booking_masters` (`id`, `invoice`, `date`, `customer_id`, `reference_id`, `is_other`, `others_member`, `subtotal`, `discount`, `discountAmount`, `vat`, `vatAmount`, `total`, `advance`, `due`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '2400001', '2024-07-28', 1, 1, 'false', 0, '3000.00', '0.00', '0.00', '0.00', '0.00', '3000.00', '0.00', '3000.00', NULL, 'a', 1, NULL, '2024-07-28 09:44:56', '2024-07-28 09:44:56', NULL, NULL, '127.0.0.1'),
(2, '2400002', '2024-07-28', 2, 1, 'false', 0, '1800.00', '0.00', '0.00', '0.00', '0.00', '1800.00', '0.00', '1800.00', NULL, 'a', 1, NULL, '2024-07-28 10:46:51', '2024-07-28 10:46:51', NULL, NULL, '127.0.0.1'),
(3, '2400003', '2024-07-28', 3, 1, 'false', 0, '1800.00', '0.00', '0.00', '0.00', '0.00', '1800.00', '0.00', '1800.00', NULL, 'a', 1, NULL, '2024-07-28 10:51:50', '2024-07-28 10:51:50', NULL, NULL, '127.0.0.1'),
(4, '2400004', '2024-07-30', 3, 1, 'true', 0, '1800.00', '0.00', '0.00', '0.00', '0.00', '1800.00', '0.00', '1800.00', NULL, 'a', 1, 1, '2024-07-30 11:32:11', '2024-07-30 11:32:44', NULL, NULL, '103.159.73.224'),
(5, '2400005', '2024-07-30', 2, NULL, 'false', 0, '3000.00', '0.00', '0.00', '0.00', '0.00', '3000.00', '0.00', '3000.00', NULL, 'a', 1, NULL, '2024-07-30 11:49:57', '2024-07-30 11:49:57', NULL, NULL, '103.159.73.224'),
(6, '2400006', '2024-07-30', 2, NULL, 'false', 0, '5300.00', '0.00', '0.00', '0.00', '0.00', '5300.00', '0.00', '5300.00', NULL, 'a', 1, NULL, '2024-07-30 11:50:21', '2024-07-30 11:50:21', NULL, NULL, '103.159.73.224'),
(7, '2400007', '2024-07-31', 4, NULL, 'true', 1, '12000.00', '10.00', '1200.00', '2.00', '0.00', '12000.00', '6000.00', '6000.00', 'gfg', 'a', 1, NULL, '2024-07-31 07:55:49', '2024-07-31 07:55:49', NULL, NULL, '103.159.73.224'),
(8, '2400008', '2024-07-31', 5, 1, 'false', 0, '10500.00', '0.00', '0.00', '0.00', '0.00', '10500.00', '2000.00', '8500.00', NULL, 'a', 1, 1, '2024-07-31 09:25:35', '2024-07-31 09:34:46', NULL, NULL, '103.159.73.224'),
(9, '2400009', '2024-07-31', 6, 1, 'false', 0, '3000.00', '0.00', '0.00', '0.00', '0.00', '3000.00', '1000.00', '2000.00', NULL, 'a', 1, NULL, '2024-07-31 09:27:06', '2024-07-31 09:27:06', NULL, NULL, '103.159.73.224'),
(10, '2400010', '2024-07-31', 1, 1, 'false', 0, '1500.00', '0.00', '0.00', '0.00', '0.00', '1500.00', '0.00', '1500.00', NULL, 'a', 1, NULL, '2024-07-31 09:34:12', '2024-07-31 09:34:12', NULL, NULL, '103.159.73.224'),
(11, '2400011', '2024-09-20', 6, 1, 'false', 0, '1500.00', '0.00', '0.00', '0.00', '0.00', '1500.00', '0.00', '1500.00', NULL, 'a', 1, NULL, '2024-09-19 18:29:09', '2024-09-19 18:29:09', NULL, NULL, '45.114.91.96'),
(12, '2400012', '2024-09-20', 1, 1, 'false', 0, '3900.00', '0.00', '0.00', '0.00', '0.00', '3900.00', '2000.00', '1900.00', NULL, 'a', 1, NULL, '2024-09-19 18:29:41', '2024-09-19 18:29:41', NULL, NULL, '45.114.91.96'),
(13, '2400013', '2024-09-20', 5, 1, 'true', 1, '4500.00', '0.00', '0.00', '0.00', '0.00', '4500.00', '1000.00', '3500.00', NULL, 'a', 1, NULL, '2024-09-19 18:41:22', '2024-09-19 18:41:22', NULL, NULL, '45.114.91.96'),
(14, '2400014', '2024-10-06', 5, 1, 'false', 0, '71200.00', '0.00', '0.00', '0.00', '0.00', '71200.00', '20000.00', '51200.00', NULL, 'a', 1, NULL, '2024-10-06 08:58:23', '2024-10-06 08:58:23', NULL, NULL, '103.159.73.93'),
(15, '2400015', '2024-10-06', 1, 1, 'false', 0, '45000.00', '0.00', '0.00', '0.00', '0.00', '45000.00', '10000.00', '35000.00', NULL, 'a', 1, NULL, '2024-10-06 08:58:55', '2024-10-06 08:58:55', NULL, NULL, '103.159.73.93'),
(16, '2400016', '2024-10-19', 7, 1, 'true', 1, '14400.00', '0.00', '0.00', '0.00', '0.00', '14400.00', '3000.00', '11400.00', NULL, 'a', 1, NULL, '2024-10-19 11:46:03', '2024-10-19 11:46:03', NULL, NULL, '103.159.73.88'),
(17, '2400017', '2024-10-19', 6, 1, 'false', 0, '3500.00', '0.00', '0.00', '0.00', '0.00', '3500.00', '1000.00', '2500.00', NULL, 'a', 1, NULL, '2024-10-19 11:50:54', '2024-10-19 11:50:54', NULL, NULL, '103.159.73.88');

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

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'HP', 'a', 1, NULL, '2024-07-28 06:34:54', '2024-07-28 06:34:54', NULL, NULL, '127.0.0.1'),
(2, 'Dell', 'a', 1, NULL, '2024-07-28 06:34:59', '2024-07-28 06:34:59', NULL, NULL, '127.0.0.1'),
(3, 'Clicks', 'a', 1, NULL, '2024-07-28 06:35:06', '2024-07-28 06:35:06', NULL, NULL, '127.0.0.1'),
(4, 'Rfl', 'a', 1, NULL, '2024-07-28 06:35:17', '2024-07-28 06:35:17', NULL, NULL, '127.0.0.1');

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
(1, 'Ac', 'ac', 'a', 1, NULL, '2024-07-28 05:18:03', NULL, NULL, NULL, '127.0.0.1'),
(2, 'Non Ac', 'non-ac', 'a', 1, NULL, '2024-07-28 05:18:03', NULL, NULL, NULL, '127.0.0.1');

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
(1, 'TSC - Jessore University', 'TSC - Jessore University', '019########', 'company@gmail.com', 'Jessore', 'https://maps.app.goo.gl/7vmsJcSW9fKMLnfH6', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://www.twitter.com/', 'https://www.youtube.com/', 'BDT', 1, 'uploads/logo/_66a5d5192531a.jpg', 'uploads/favicon/_66a5d51925a09.jpg', '127.0.0.1', '2024-07-28 05:18:03', '2024-07-30 11:46:36');

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
(1, 'C00001', 'Azharul Islam', '01738000000', NULL, NULL, NULL, '0.00', 1, 1, 'Dhaka', NULL, NULL, 'a', 1, 1, '2024-07-28 07:26:22', '2024-07-28 09:58:16', NULL, NULL, '127.0.0.1'),
(2, 'C00002', 'Atiqur rahman', '01510000000', NULL, '548755487', NULL, '0.00', NULL, NULL, 'Mirpur', NULL, NULL, 'a', 1, NULL, '2024-07-28 10:46:51', '2024-07-28 10:46:51', NULL, NULL, '127.0.0.1'),
(3, 'C00003', 'MD. Rofiq', '6019521325', NULL, '0446546', 'male', '0.00', 1, 1, '1600 Amphitheatre Parkway', NULL, NULL, 'a', 1, 1, '2024-07-28 10:51:50', '2024-07-28 10:52:47', NULL, NULL, '127.0.0.1'),
(4, 'C00004', 'Al amin', '01979556663', NULL, '9153841514', NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'a', 1, NULL, '2024-07-31 07:55:49', '2024-07-31 07:55:49', NULL, NULL, '103.159.73.224'),
(5, 'C00005', 'Al amin Islam', '01979556663', NULL, '10002111111', NULL, '0.00', NULL, 1, 'kazi Para , Dhaka', NULL, NULL, 'a', 1, NULL, '2024-07-31 09:25:35', '2024-07-31 09:25:35', NULL, NULL, '103.159.73.224'),
(6, 'C00006', 'Ashikur Rahman', '01904098049', NULL, '20011000', NULL, '0.00', NULL, 1, 'Pollobi, Dhaka', NULL, NULL, 'a', 1, NULL, '2024-07-31 09:27:06', '2024-07-31 09:27:06', NULL, NULL, '103.159.73.224'),
(7, 'C00007', 'Faruk Khan', '01717549144', NULL, '1000110001', NULL, '0.00', NULL, 1, 'Kochukhet', NULL, NULL, 'a', 1, NULL, '2024-10-19 11:46:03', '2024-10-19 11:46:03', NULL, NULL, '103.159.73.88');

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

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `invoice`, `date`, `customer_id`, `booking_id`, `type`, `method`, `bank_account_id`, `discount`, `discountAmount`, `amount`, `previous_due`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'TR00001', '2024-10-19', 7, 16, 'CR', 'cash', NULL, '0.00', '0.00', '11400.00', '0.00', NULL, 'a', 1, NULL, '2024-10-19 11:49:28', '2024-10-19 11:49:28', NULL, NULL, '103.159.73.88');

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

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Service Provider', 'a', 1, NULL, '2024-07-28 06:51:29', '2024-07-28 06:51:29', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Dhaka', 'a', 1, NULL, '2024-07-28 06:45:27', '2024-07-28 06:45:27', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `position`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '1st', 1, 'a', 1, NULL, '2024-07-28 05:22:07', '2024-07-28 05:22:07', NULL, NULL, '127.0.0.1'),
(2, '2nd', 1, 'a', 1, NULL, '2024-07-28 05:22:24', '2024-07-28 05:22:24', NULL, NULL, '127.0.0.1'),
(3, '3rd', 1, 'a', 1, NULL, '2024-07-28 05:22:30', '2024-07-28 05:22:30', NULL, NULL, '127.0.0.1'),
(4, '4th', 1, 'a', 1, NULL, '2024-07-28 05:22:37', '2024-07-28 05:22:37', NULL, NULL, '127.0.0.1'),
(5, '5th', 1, 'a', 1, NULL, '2024-07-28 05:22:42', '2024-07-28 05:22:42', NULL, NULL, '127.0.0.1');

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
(1, 'Image Title', 'big', 'uploads/gallery/Image Title_66a5ed00ab81b.jpg', 'a', 1, NULL, '2024-07-28 07:02:24', '2024-07-28 07:02:24', NULL, NULL, '127.0.0.1'),
(2, 'Image Title', 'small', 'uploads/gallery/Image Title_66a5ed102a1b0.jpg', 'a', 1, NULL, '2024-07-28 07:02:40', '2024-07-28 07:02:40', NULL, NULL, '127.0.0.1'),
(3, 'Image Title', 'small', 'uploads/gallery/Image Title_66a5ed214f886.jpg', 'a', 1, NULL, '2024-07-28 07:02:57', '2024-07-28 07:02:57', NULL, NULL, '127.0.0.1'),
(4, 'Image Title', 'big', 'uploads/gallery/Image Title_66a5ed38a5f39.jpg', 'a', 1, NULL, '2024-07-28 07:03:20', '2024-07-28 07:03:20', NULL, NULL, '127.0.0.1'),
(5, 'Image Title', 'big', 'uploads/gallery/Image Title_66a5ed6ccb055.jpg', 'a', 1, NULL, '2024-07-28 07:04:12', '2024-07-28 07:04:12', NULL, NULL, '127.0.0.1'),
(6, 'Image Title', 'small', 'uploads/gallery/Image Title_66a5ed78652f3.jpg', 'a', 1, NULL, '2024-07-28 07:04:24', '2024-07-28 07:04:24', NULL, NULL, '127.0.0.1'),
(7, 'Image Title', 'small', 'uploads/gallery/Image Title_66a5ed81c25bb.jpg', 'a', 1, NULL, '2024-07-28 07:04:33', '2024-07-28 07:04:33', NULL, NULL, '127.0.0.1'),
(8, 'Image Title', 'big', 'uploads/gallery/Image Title_66a5edace545e.jpg', 'a', 1, NULL, '2024-07-28 07:05:16', '2024-07-28 07:05:16', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `date`, `invoice`, `issue_to`, `room_id`, `subtotal`, `vat`, `vatAmount`, `discount`, `discountAmount`, `total`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '2024-07-28', 'I2400001', 'Roni', 1, '300.00', 0.00, '0.00', 0.00, '0.00', '300.00', NULL, 'a', 1, NULL, '2024-07-28 06:48:03', '2024-07-28 06:48:03', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `issue_details`
--

INSERT INTO `issue_details` (`id`, `issue_id`, `asset_id`, `quantity`, `price`, `total`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 2, 2.00, '150.00', '300.00', 'a', 1, NULL, '2024-07-28 06:48:03', '2024-07-28 06:48:03', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `issue_returns`
--

INSERT INTO `issue_returns` (`id`, `date`, `room_id`, `total`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, '2024-10-01', 1, '150.00', NULL, 'd', 1, NULL, '2024-10-01 06:57:54', '2024-10-01 06:58:17', 1, '2024-10-01 06:58:17', '103.159.73.97');

-- --------------------------------------------------------

--
-- Table structure for table `issue_return_details`
--

CREATE TABLE `issue_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_return_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `price` decimal(18,2) NOT NULL DEFAULT 0.00,
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

--
-- Dumping data for table `issue_return_details`
--

INSERT INTO `issue_return_details` (`id`, `issue_return_id`, `asset_id`, `quantity`, `price`, `total`, `disposal_status`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 2, 1.00, '150.00', '150.00', 'Regular Stock', 'd', 1, NULL, '2024-10-01 06:57:54', '2024-10-01 06:58:17', 1, '2024-10-01 06:58:17', '103.159.73.97');

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
(1, 'M00001', 'Mr Alamin', '00000000000', 'example@gmail.com', 1, 'Dhaka, Bangladesh', 'uploads/manage/M00001_66a5ebc12246d.jpg', 'a', 1, NULL, '2024-07-28 06:57:05', '2024-07-28 06:57:05', NULL, NULL, '127.0.0.1'),
(2, 'C00002', 'Mr Mehedi Hassan', '0000000000', 'example@gmail.com', 1, 'Dhaka, Bangladesh', 'uploads/manage/C00002_66a5ebe887530.webp', 'a', 1, NULL, '2024-07-28 06:57:44', '2024-07-28 06:57:44', NULL, NULL, '127.0.0.1'),
(3, 'C00003', 'Mr Atik Hasan', '0170000000', 'example@gmail.com', 1, 'Dhaka , Bangladesh', 'uploads/manage/C00003_66a5ec0feec91.png', 'a', 1, 1, '2024-07-28 06:58:15', '2024-07-28 06:58:23', NULL, NULL, '127.0.0.1'),
(4, 'C00004', 'Md Azahar Islam', '01700000000', 'azahar@gmail.com', 1, 'Dhaka , Bangladesh', 'uploads/manage/C00004_66a5ec3d38d0a.jpeg', 'a', 1, NULL, '2024-07-28 06:59:09', '2024-07-28 06:59:09', NULL, NULL, '127.0.0.1'),
(5, 'C00005', 'Alhaque shuvo', '0173501201', 'shuvo@gmail.com', 1, 'Dhaka', 'uploads/manage/C00005_66a5ec612c2d0.jpg', 'a', 1, NULL, '2024-07-28 06:59:45', '2024-07-28 06:59:45', NULL, NULL, '127.0.0.1');

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
(1, 'Burger Ban', 1, '30.00', NULL, 'a', 1, NULL, '2024-07-28 06:13:00', '2024-07-28 06:13:00', NULL, NULL, '127.0.0.1'),
(2, 'tomatoes', 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:16:29', '2024-07-28 06:16:29', NULL, NULL, '127.0.0.1'),
(3, 'steak', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:18:17', '2024-07-28 06:18:17', NULL, NULL, '127.0.0.1'),
(4, 'lettuce', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:18:44', '2024-07-28 06:18:44', NULL, NULL, '127.0.0.1'),
(5, 'onion', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:19:19', '2024-07-28 06:19:19', NULL, NULL, '127.0.0.1'),
(6, 'milk', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:23:42', '2024-07-28 06:23:42', NULL, NULL, '127.0.0.1'),
(7, 'ice cream', 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:23:52', '2024-07-28 06:23:52', NULL, NULL, '127.0.0.1'),
(8, 'Banana', 1, '10.00', NULL, 'a', 1, NULL, '2024-07-28 06:24:39', '2024-07-28 06:24:39', NULL, NULL, '127.0.0.1'),
(9, 'chocolate syrup', 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:25:32', '2024-07-28 06:25:32', NULL, NULL, '127.0.0.1'),
(10, 'sweet', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:25:38', '2024-07-28 06:25:38', NULL, NULL, '127.0.0.1'),
(11, 'coffee', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:28:22', '2024-07-28 06:28:22', NULL, NULL, '127.0.0.1'),
(12, 'sugar', 3, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:28:45', '2024-07-28 06:28:45', NULL, NULL, '127.0.0.1'),
(13, 'Chicken', 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:30:57', '2024-07-28 06:30:57', NULL, NULL, '127.0.0.1'),
(14, 'Role Ruti', 1, '15.00', NULL, 'a', 1, NULL, '2024-07-28 06:32:03', '2024-07-28 06:32:03', NULL, NULL, '127.0.0.1');

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
(1, 'M00001', 1, 'Malo Burger', 'malo-burger', 1, 0.00, '0.00', '250.00', '0.00', 0, 'uploads/menu/M00001_66a5e3b57ae5d.png', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(2, 'M00002', 2, 'Milk Shake', 'milk-shake', 1, 5.00, '0.00', '180.00', '0.00', 0, 'uploads/menu/M00002_66a5e4dcde1fe.jpg', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(3, 'M00003', 2, 'Cold Coffee', 'cold-coffee', 1, 0.00, '0.00', '120.00', '0.00', 0, 'uploads/menu/M00003_66a5e58c00cab.png', 'a', 1, NULL, '2024-07-28 06:30:36', '2024-07-28 06:30:36', NULL, NULL, '127.0.0.1'),
(4, 'M00004', 3, 'Chicken Role', 'chicken-role', 1, 0.00, '0.00', '80.00', '0.00', 0, 'uploads/menu/M00004_66a5e628e67b5.jpg', 'a', 1, NULL, '2024-07-28 06:33:12', '2024-10-31 05:58:30', NULL, NULL, '103.159.73.75');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
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

INSERT INTO `menu_categories` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Deserts', 'deserts', 'a', 1, NULL, '2024-07-28 06:10:55', '2024-07-28 06:10:55', NULL, NULL, '127.0.0.1'),
(2, 'Drinks', 'drinks', 'a', 1, NULL, '2024-07-28 06:11:07', '2024-07-28 06:11:07', NULL, NULL, '127.0.0.1'),
(3, 'Slides', 'slides', 'a', 1, NULL, '2024-07-28 06:11:14', '2024-07-28 06:11:14', NULL, NULL, '127.0.0.1');

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
(63, '2024_05_25_142744_create_booking_masters_table', 2),
(64, '2024_05_25_143009_create_booking_details_table', 2),
(71, '2024_07_29_154051_create_disposals_table', 3),
(72, '2024_07_29_155301_create_disposal_details_table', 3),
(73, '2024_10_31_155147_create_specialties_table', 4);

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
(1, 'O2400001', '2024-07-28', 1, NULL, NULL, NULL, NULL, NULL, '370.00', '0.00', '0.00', '370.00', '0.00', '0.00', NULL, '0.00', '0.00', '370.00', NULL, 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(2, 'O2400002', '2024-07-31', NULL, NULL, NULL, 'Cash Customer', '04575210', NULL, '80.00', '0.00', '0.00', '80.00', '80.00', '0.00', NULL, '0.00', '80.00', '0.00', NULL, 'a', 1, NULL, '2024-07-31 07:57:37', '2024-07-31 07:57:37', NULL, NULL, '103.159.73.224'),
(3, 'O2400003', '2024-09-02', NULL, NULL, NULL, 'Cash Customer', NULL, NULL, '380.00', '0.00', '0.00', '380.00', '380.00', '0.00', NULL, '0.00', '380.00', '0.00', NULL, 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(4, 'O2400004', '2024-10-19', 6, NULL, NULL, NULL, NULL, NULL, '1230.00', '0.00', '0.00', '1230.00', '200.00', '0.00', NULL, '0.00', '200.00', '1230.00', NULL, 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(5, 'O2400005', '2024-10-31', NULL, NULL, NULL, 'Cash Customer', NULL, NULL, '1060.00', '0.00', '0.00', '1060.00', '1060.00', '0.00', NULL, '0.00', '1060.00', '0.00', NULL, 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75');

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
(1, 1, 3, '120.00', '0.00', 1.00, '120.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(2, 1, 1, '250.00', '0.00', 1.00, '250.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(3, 2, 4, '80.00', '0.00', 1.00, '80.00', 'a', 1, NULL, '2024-07-31 07:57:37', '2024-07-31 07:57:37', NULL, NULL, '103.159.73.224'),
(4, 3, 2, '180.00', '5.00', 1.00, '180.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(5, 3, 3, '120.00', '0.00', 1.00, '120.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(6, 3, 4, '80.00', '0.00', 1.00, '80.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(7, 4, 1, '250.00', '0.00', 1.00, '250.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(8, 4, 2, '180.00', '5.00', 1.00, '180.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(9, 4, 3, '120.00', '0.00', 6.00, '720.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(10, 4, 4, '80.00', '0.00', 1.00, '80.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(11, 5, 4, '80.00', '0.00', 1.00, '80.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(12, 5, 3, '120.00', '0.00', 1.00, '120.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(13, 5, 2, '180.00', '5.00', 2.00, '360.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(14, 5, 1, '250.00', '0.00', 2.00, '500.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75');

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

--
-- Dumping data for table `other_customers`
--

INSERT INTO `other_customers` (`id`, `booking_id`, `room_id`, `name`, `nid`, `gender`, `image`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 7, 1, 'sdff', '455', 'male', NULL, 1, NULL, '2024-07-31 07:55:49', '2024-07-31 07:55:49', NULL, NULL, '103.159.73.224'),
(2, 13, 4, 'Md. Mozammel Hossain', '10001111', 'male', NULL, 1, NULL, '2024-09-19 18:41:22', '2024-09-19 18:41:22', NULL, NULL, '45.114.91.96'),
(3, 16, 6, 'Rohima Khatun', '1001100', 'female', NULL, 1, NULL, '2024-10-19 11:46:03', '2024-10-19 11:46:03', NULL, NULL, '103.159.73.88');

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
(1, 'PR240001', '2024-07-28', 1, '70.00', 'Order production invoice -O2400001', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(2, 'PR240002', '2024-07-28', 1, '160.00', 'Order production invoice -O2400001', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(3, 'PR240003', '2024-07-31', 2, '50.00', 'Order production invoice -O2400002', 'a', 1, NULL, '2024-07-31 07:57:37', '2024-07-31 07:57:37', NULL, NULL, '103.159.73.224'),
(4, 'PR240004', '2024-09-02', 3, '100.00', 'Order production invoice -O2400003', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(5, 'PR240005', '2024-09-02', 3, '70.00', 'Order production invoice -O2400003', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(6, 'PR240006', '2024-09-02', 3, '50.00', 'Order production invoice -O2400003', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(7, 'PR240007', '2024-10-19', 4, '160.00', 'Order production invoice -O2400004', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(8, 'PR240008', '2024-10-19', 4, '100.00', 'Order production invoice -O2400004', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(9, 'PR240009', '2024-10-19', 4, '70.00', 'Order production invoice -O2400004', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(10, 'PR240010', '2024-10-19', 4, '50.00', 'Order production invoice -O2400004', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(11, 'PR240011', '2024-10-31', 5, '50.00', 'Order production invoice -O2400005', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(12, 'PR240012', '2024-10-31', 5, '70.00', 'Order production invoice -O2400005', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(13, 'PR240013', '2024-10-31', 5, '100.00', 'Order production invoice -O2400005', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(14, 'PR240014', '2024-10-31', 5, '160.00', 'Order production invoice -O2400005', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75');

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
(1, 1, 6, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(2, 1, 12, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(3, 1, 11, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(4, 2, 2, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(5, 2, 3, 2.00, '50.00', '100.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(6, 2, 5, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(7, 2, 4, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(8, 2, 1, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-07-28 07:26:22', '2024-07-28 07:26:22', NULL, NULL, '127.0.0.1'),
(9, 3, 13, 1.00, '35.00', '35.00', 'a', 1, NULL, '2024-07-31 07:57:37', '2024-07-31 07:57:37', NULL, NULL, '103.159.73.224'),
(10, 3, 14, 1.00, '15.00', '15.00', 'a', 1, NULL, '2024-07-31 07:57:37', '2024-07-31 07:57:37', NULL, NULL, '103.159.73.224'),
(11, 4, 9, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(12, 4, 10, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(13, 4, 7, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(14, 4, 8, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(15, 4, 6, 1.00, '20.00', '20.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(16, 5, 6, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(17, 5, 12, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(18, 5, 11, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(19, 6, 13, 1.00, '35.00', '35.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(20, 6, 14, 1.00, '15.00', '15.00', 'a', 1, NULL, '2024-09-02 08:11:24', '2024-09-02 08:11:24', NULL, NULL, '119.40.87.9'),
(21, 7, 2, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(22, 7, 3, 2.00, '50.00', '100.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(23, 7, 5, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(24, 7, 4, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(25, 7, 1, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(26, 8, 9, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(27, 8, 10, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(28, 8, 7, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(29, 8, 8, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(30, 8, 6, 1.00, '20.00', '20.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(31, 9, 6, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(32, 9, 12, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(33, 9, 11, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(34, 10, 13, 1.00, '35.00', '35.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(35, 10, 14, 1.00, '15.00', '15.00', 'a', 1, NULL, '2024-10-19 11:52:11', '2024-10-19 11:52:11', NULL, NULL, '103.159.73.88'),
(36, 11, 13, 1.00, '35.00', '35.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(37, 11, 14, 1.00, '15.00', '15.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(38, 12, 6, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(39, 12, 12, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(40, 12, 11, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(41, 13, 9, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(42, 13, 10, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(43, 13, 7, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(44, 13, 8, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(45, 13, 6, 1.00, '20.00', '20.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(46, 14, 2, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(47, 14, 3, 2.00, '50.00', '100.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(48, 14, 5, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(49, 14, 4, 1.00, '10.00', '10.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75'),
(50, 14, 1, 1.00, '30.00', '30.00', 'a', 1, NULL, '2024-10-31 06:24:46', '2024-10-31 06:24:46', NULL, NULL, '103.159.73.75');

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

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `invoice`, `date`, `supplier_id`, `employee_id`, `sub_total`, `vat`, `vatAmount`, `discount`, `discountAmount`, `transport`, `total`, `paid`, `due`, `previous_due`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'P2400001', '2024-07-28', 1, NULL, '251500.00', 0.00, '0.00', 0.00, '0.00', '0.00', '251500.00', '251500.00', '0.00', '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:46:58', '2024-07-28 06:46:58', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `asset_id`, `quantity`, `price`, `total`, `warranty`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 1, 1, 10.00, '25000.00', '250000.00', 5.00, 'a', 1, NULL, '2024-07-28 06:46:58', '2024-07-28 06:46:58', NULL, NULL, '127.0.0.1'),
(2, 1, 2, 10.00, '150.00', '1500.00', 6.00, 'a', 1, NULL, '2024-07-28 06:46:58', '2024-07-28 06:46:58', NULL, NULL, '127.0.0.1');

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
(1, 1, 2, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(2, 1, 3, '50.00', 2.00, '100.00', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(3, 1, 5, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(4, 1, 4, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(5, 1, 1, '30.00', 1.00, '30.00', 'a', 1, NULL, '2024-07-28 06:22:45', '2024-07-28 06:22:45', NULL, NULL, '127.0.0.1'),
(6, 2, 9, '30.00', 1.00, '30.00', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(7, 2, 10, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(8, 2, 7, '30.00', 1.00, '30.00', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(9, 2, 8, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(10, 2, 6, '20.00', 1.00, '20.00', 'a', 1, NULL, '2024-07-28 06:27:40', '2024-07-28 06:27:40', NULL, NULL, '127.0.0.1'),
(11, 3, 6, '30.00', 1.00, '30.00', 'a', 1, NULL, '2024-07-28 06:30:36', '2024-07-28 06:30:36', NULL, NULL, '127.0.0.1'),
(12, 3, 12, '10.00', 1.00, '10.00', 'a', 1, NULL, '2024-07-28 06:30:36', '2024-07-28 06:30:36', NULL, NULL, '127.0.0.1'),
(13, 3, 11, '30.00', 1.00, '30.00', 'a', 1, NULL, '2024-07-28 06:30:36', '2024-07-28 06:30:36', NULL, NULL, '127.0.0.1'),
(14, 4, 13, '35.00', 1.00, '35.00', 'a', 1, NULL, '2024-07-28 06:33:12', '2024-10-31 05:58:30', NULL, NULL, '103.159.73.75'),
(15, 4, 14, '15.00', 1.00, '15.00', 'a', 1, NULL, '2024-07-28 06:33:12', '2024-10-31 05:58:30', NULL, NULL, '103.159.73.75');

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

--
-- Dumping data for table `references`
--

INSERT INTO `references` (`id`, `code`, `name`, `phone`, `email`, `address`, `note`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'R00001', 'Jhon Doe', '01733333333', 'jhon@gmail.com', 'usa', 'n/a', 'a', 1, NULL, '2024-07-28 05:21:18', '2024-07-28 05:21:18', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `code`, `floor_id`, `category_id`, `room_type_id`, `name`, `bed`, `bath`, `price`, `note`, `image`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'R00001', 1, 1, 2, '101', 2, 2, '3000.00', NULL, 'uploads/room/R00001_66a5d5d32ec65.jpg', 'a', 1, 1, '2024-07-28 05:23:31', '2024-07-28 05:24:18', NULL, NULL, '127.0.0.1'),
(2, 'R00002', 1, 1, 1, '102', 1, 1, '1800.00', NULL, 'uploads/room/R00002_66a5d5f90a590.jpg', 'a', 1, NULL, '2024-07-28 05:24:09', '2024-07-28 05:24:09', NULL, NULL, '127.0.0.1'),
(3, 'R00003', 1, 2, 1, '103', 0, 0, '1500.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:24:39', '2024-07-28 05:24:39', NULL, NULL, '127.0.0.1'),
(4, 'R00004', 1, 2, 1, '104', 0, 0, '1500.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:24:51', '2024-07-28 05:24:51', NULL, NULL, '127.0.0.1'),
(5, 'R00005', 1, 2, 2, '105', 0, 0, '2200.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:25:09', '2024-07-28 05:25:09', NULL, NULL, '127.0.0.1'),
(6, 'R00006', 1, 1, 2, '106', 2, 2, '3000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:25:40', '2024-07-28 05:25:40', NULL, NULL, '127.0.0.1'),
(7, 'R00007', 2, 1, 2, '201', 0, 0, '2700.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:25:51', '2024-07-28 05:25:51', NULL, NULL, '127.0.0.1'),
(8, 'R00008', 2, 1, 1, '202', 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:26:04', '2024-07-28 05:26:04', NULL, NULL, '127.0.0.1'),
(9, 'R00009', 2, 1, 1, '203', 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:26:17', '2024-07-28 05:26:17', NULL, NULL, '127.0.0.1'),
(10, 'R00010', 2, 2, 1, '204', 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:26:39', '2024-07-28 05:26:39', NULL, NULL, '127.0.0.1'),
(11, 'R00011', 2, 2, 2, '205', 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:26:59', '2024-07-28 05:26:59', NULL, NULL, '127.0.0.1'),
(12, 'R00012', 3, 1, 2, '301', 0, 0, '3000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:27:14', '2024-07-28 05:27:14', NULL, NULL, '127.0.0.1'),
(13, 'R00013', 3, 1, 1, '302', 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:27:30', '2024-07-28 05:27:30', NULL, NULL, '127.0.0.1'),
(14, 'R00014', 3, 1, 1, '303', 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:27:41', '2024-07-28 05:27:41', NULL, NULL, '127.0.0.1'),
(15, 'R00015', 3, 2, 2, '304', 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:27:57', '2024-07-28 05:27:57', NULL, NULL, '127.0.0.1'),
(16, 'R00016', 3, 2, 1, '305', 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:28:26', '2024-07-28 05:28:26', NULL, NULL, '127.0.0.1'),
(17, 'R00017', 4, 1, 1, '401', 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:32:07', '2024-07-28 05:32:07', NULL, NULL, '127.0.0.1'),
(18, 'R00018', 4, 1, 1, '402', 0, 0, '2000.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:32:24', '2024-07-28 05:32:24', NULL, NULL, '127.0.0.1'),
(19, 'R00019', 4, 2, 1, '403', 0, 0, '1300.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:32:43', '2024-07-28 05:32:43', NULL, NULL, '127.0.0.1'),
(20, 'R00020', 4, 1, 2, '405', 0, 0, '2800.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:33:12', '2024-07-28 05:33:12', NULL, NULL, '127.0.0.1'),
(21, 'R00021', 4, 2, 2, '405', 0, 0, '2300.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:33:28', '2024-07-28 05:33:28', NULL, NULL, '127.0.0.1'),
(22, 'R00022', 5, 1, 1, '501', 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:34:00', '2024-07-28 05:34:00', NULL, NULL, '127.0.0.1'),
(23, 'R00023', 5, 2, 1, '502', 0, 0, '1200.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:34:13', '2024-07-28 05:34:13', NULL, NULL, '127.0.0.1'),
(24, 'R00024', 5, 1, 2, '503', 0, 0, '2500.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:34:29', '2024-07-28 05:34:29', NULL, NULL, '127.0.0.1'),
(25, 'R00025', 5, 2, 2, '504', 0, 0, '1800.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:35:05', '2024-07-28 05:35:05', NULL, NULL, '127.0.0.1'),
(26, 'R00026', 5, 1, 1, '505', 0, 0, '1700.00', NULL, NULL, 'a', 1, NULL, '2024-07-28 05:35:43', '2024-07-28 05:35:43', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `slug`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'Single', 'single', 'a', 1, NULL, '2024-07-28 05:21:43', '2024-07-28 05:21:43', NULL, NULL, '127.0.0.1'),
(2, 'Deluxe', 'deluxe', 'a', 1, NULL, '2024-07-28 05:21:52', '2024-07-28 05:21:52', NULL, NULL, '127.0.0.1');

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

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `invoice`, `date`, `type`, `room_id`, `customer_id`, `booking_id`, `service_head_id`, `amount`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'S2400001', '2024-07-31', NULL, 1, NULL, NULL, 4, '1000.00', 'gfg', 'a', 1, NULL, '2024-07-31 07:57:02', '2024-07-31 07:57:02', NULL, NULL, '103.159.73.224'),
(2, 'S2400002', '2024-10-19', NULL, 26, NULL, NULL, 1, '500.00', NULL, 'a', 1, NULL, '2024-10-19 11:57:00', '2024-10-19 11:57:00', NULL, NULL, '103.159.73.88');

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

--
-- Dumping data for table `service_heads`
--

INSERT INTO `service_heads` (`id`, `code`, `name`, `amount`, `vat`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 'SH00001', 'Swiming', '500.00', '5.00', 'a', 1, NULL, '2024-07-28 05:37:34', '2024-07-28 05:37:34', NULL, NULL, '127.0.0.1'),
(2, 'SH00002', 'Car Parking', '500.00', '5.00', 'a', 1, NULL, '2024-07-28 06:06:44', '2024-07-28 06:06:44', NULL, NULL, '127.0.0.1'),
(3, 'SH00003', 'Other Service', '500.00', '0.00', 'a', 1, NULL, '2024-07-28 06:07:14', '2024-07-28 06:07:14', NULL, NULL, '127.0.0.1'),
(4, 'SH00004', 'sanks Bar', '1000.00', '0.00', 'a', 1, NULL, '2024-07-31 07:56:50', '2024-07-31 07:56:50', NULL, NULL, '103.159.73.224');

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
(1, 'Welcome to TSC JUST', 'Best place for family & friends with green & healthy food.', 'Book Now', 'https://justtsc.com/room-booking', 'uploads/slider/Welcome to TSC JUST_672342e392014.jpg', 'a', 1, 1, '2024-07-28 06:55:44', '2024-10-31 08:42:11', NULL, NULL, '127.0.0.1'),
(2, 'Welcome to our dining hall', 'Best place for family & friends with green & healthy food.', 'Order Now', 'https://justtsc.com/foods', 'uploads/slider/Welcome to our dining hall_6723428531725.jpg', 'a', 1, 1, '2024-07-28 06:56:19', '2024-10-31 08:40:37', NULL, NULL, '127.0.0.1'),
(3, 'Test', 'Test', 'Test', 'TEst', NULL, 'd', 1, NULL, '2024-10-31 08:27:57', '2024-10-31 08:41:43', 1, '2024-10-31 08:41:43', '127.0.0.1'),
(4, 'Test', 'Test', 'Test', 'Test', 'uploads/slider/Test_672342bde161b.jpg', 'a', 1, 1, '2024-10-31 08:28:44', '2024-10-31 08:41:33', NULL, NULL, '127.0.0.1');

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
(1, 'S00001', 'Chester Rhodes', 'retail', '0170000000', NULL, NULL, 'Bangladesh', 'Chester Rhodes', NULL, 1, '0.00', NULL, 'a', 1, NULL, '2024-07-28 06:45:45', '2024-07-28 06:45:45', NULL, NULL, '127.0.0.1');

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
(1, 'Pcs', 'a', 1, NULL, '2024-07-28 06:12:13', '2024-07-28 06:12:13', NULL, NULL, '127.0.0.1'),
(2, 'Kg', 'a', 1, NULL, '2024-07-28 06:12:17', '2024-07-28 06:12:17', NULL, NULL, '127.0.0.1'),
(3, 'gm', 'a', 1, NULL, '2024-07-28 06:18:08', '2024-07-28 06:18:08', NULL, NULL, '127.0.0.1');

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
(1, 'U00001', 'Admin', 'admin', 'admin@gmail.com', '$2y$10$To.RkmwVCl4bJIy9PQi5fup/pJoIRbP5AcNTjTYnttBmJilhPwfR2', '019########', 'Superadmin', NULL, 'a', NULL, '127.0.0.1', NULL, '2024-07-28 05:18:03', '2024-07-28 05:18:03', NULL),
(2, 'U00002', 'jhon doe', 'jhon', 'jhon@gmail.com', '$2y$10$I5WzCgnxJ8C7PtVEN9UW7OJ7gbCQUvqTVyGFlyfX7otBKZb7HG15S', '01517821601', 'user', NULL, 'a', 'e', '103.159.73.97', NULL, '2024-10-02 03:47:48', '2024-10-19 12:37:24', NULL);

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

--
-- Dumping data for table `user_accesses`
--

INSERT INTO `user_accesses` (`id`, `user_id`, `access`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `last_update_ip`) VALUES
(1, 2, '[\"booking\",\"checkout\",\"bookingRecord\"]', 1, NULL, '2024-10-19 12:37:24', '2024-10-19 12:37:24', NULL, NULL, '103.159.73.88');

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
(1, 1, 'Logout', NULL, '2024-07-28 11:18:15', 'a', '127.0.0.1', '2024-07-28 05:18:15', '2024-07-28 05:18:15', NULL),
(2, 1, 'http://127.0.0.1:8000/booking', '2024-07-28 11:18:23', NULL, 'a', '127.0.0.1', '2024-07-28 05:18:23', '2024-07-28 11:01:35', NULL),
(3, 1, 'https://soft.justtsc.com/booking', '2024-07-28 17:49:44', NULL, 'a', '103.159.73.224', '2024-07-28 11:49:44', '2024-07-28 11:49:49', NULL),
(4, 1, 'Logout', NULL, '2024-07-28 17:51:10', 'a', '103.159.73.224', '2024-07-28 11:51:10', '2024-07-28 11:51:10', NULL),
(5, 1, 'Dashboard', '2024-07-29 17:43:10', NULL, 'a', '103.159.73.224', '2024-07-29 11:43:10', '2024-07-29 11:43:10', NULL),
(6, 1, 'https://soft.justtsc.com/booking', '2024-07-29 22:21:21', NULL, 'a', '103.159.73.224', '2024-07-29 16:21:21', '2024-07-29 16:21:55', NULL),
(7, 1, 'Dashboard', '2024-07-30 17:28:06', NULL, 'a', '103.159.73.224', '2024-07-30 11:28:06', '2024-07-30 11:28:06', NULL),
(8, 1, 'https://soft.justtsc.com/slider', '2024-07-30 17:31:34', NULL, 'a', '103.159.73.224', '2024-07-30 11:31:34', '2024-07-30 11:34:12', NULL),
(9, 1, 'https://soft.justtsc.com/booking', '2024-07-30 17:40:43', NULL, 'a', '103.159.73.224', '2024-07-30 11:40:43', '2024-07-30 11:42:47', NULL),
(10, 1, 'https://soft.justtsc.com/booking', '2024-07-30 17:43:28', NULL, 'a', '103.159.73.224', '2024-07-30 11:43:28', '2024-07-30 11:49:58', NULL),
(11, 1, 'https://soft.justtsc.com/graph', '2024-07-31 11:19:23', NULL, 'a', '103.159.73.224', '2024-07-31 05:19:23', '2024-07-31 06:57:04', NULL),
(12, 1, 'https://soft.justtsc.com/graph', '2024-07-31 13:49:20', NULL, 'a', '103.159.73.224', '2024-07-31 07:49:20', '2024-07-31 09:10:29', NULL),
(13, 1, 'https://soft.justtsc.com/department', '2024-07-31 15:23:23', NULL, 'a', '103.159.73.224', '2024-07-31 09:23:23', '2024-07-31 10:45:08', NULL),
(14, 1, 'Logout', NULL, '2024-07-31 16:45:15', 'a', '103.159.73.224', '2024-07-31 10:45:15', '2024-07-31 10:45:15', NULL),
(15, 1, 'https://soft.justtsc.com/billing-invoice', '2024-08-01 10:14:10', NULL, 'a', '103.159.73.224', '2024-08-01 04:14:10', '2024-08-01 04:14:14', NULL),
(16, 1, 'https://soft.justtsc.com/disposal', '2024-08-01 17:06:09', NULL, 'a', '103.159.73.224', '2024-08-01 11:06:09', '2024-08-01 11:06:17', NULL),
(17, 1, 'https://soft.justtsc.com/booking', '2024-08-01 17:41:13', NULL, 'a', '51.79.160.171', '2024-08-01 11:41:13', '2024-08-01 11:41:24', NULL),
(18, 1, 'https://soft.justtsc.com/booking', '2024-08-25 15:58:25', NULL, 'a', '103.159.73.224', '2024-08-25 09:58:25', '2024-08-25 09:58:42', NULL),
(19, 1, 'Dashboard', '2024-08-27 17:42:55', NULL, 'a', '175.41.44.66', '2024-08-27 11:42:55', '2024-08-27 11:42:55', NULL),
(20, 1, 'Logout', NULL, '2024-08-27 17:43:10', 'a', '175.41.44.66', '2024-08-27 11:43:10', '2024-08-27 11:43:10', NULL),
(21, 1, 'https://soft.justtsc.com/booking', '2024-08-29 10:56:03', NULL, 'a', '37.111.212.65', '2024-08-29 04:56:03', '2024-08-29 04:59:47', NULL),
(22, 1, 'https://soft.justtsc.com/booking', '2024-08-29 10:57:33', NULL, 'a', '119.40.87.9', '2024-08-29 04:57:33', '2024-08-29 04:59:10', NULL),
(23, 1, 'https://soft.justtsc.com/employee', '2024-08-29 10:59:55', NULL, 'a', '119.40.87.9', '2024-08-29 04:59:55', '2024-08-29 05:15:17', NULL),
(24, 1, 'Logout', NULL, '2024-08-29 12:44:29', 'a', '119.40.87.9', '2024-08-29 06:44:29', '2024-08-29 06:44:29', NULL),
(25, 1, 'https://soft.justtsc.com/booking', '2024-08-29 13:37:04', NULL, 'a', '175.41.44.66', '2024-08-29 07:37:04', '2024-08-29 07:37:10', NULL),
(26, 1, 'https://soft.justtsc.com/booking', '2024-08-29 13:41:05', NULL, 'a', '103.159.72.105', '2024-08-29 07:41:05', '2024-08-29 07:41:09', NULL),
(27, 1, 'Logout', NULL, '2024-08-29 15:20:04', 'a', '175.41.44.66', '2024-08-29 09:20:04', '2024-08-29 09:20:04', NULL),
(28, 1, 'https://soft.justtsc.com/order', '2024-09-02 14:11:04', NULL, 'a', '119.40.87.9', '2024-09-02 08:11:04', '2024-09-02 08:11:27', NULL),
(29, 1, 'Dashboard', '2024-09-04 16:08:02', NULL, 'a', '103.159.72.80', '2024-09-04 10:08:02', '2024-09-04 10:08:02', NULL),
(30, 1, 'https://soft.justtsc.com/booking', '2024-09-07 13:40:54', NULL, 'a', '119.40.87.9', '2024-09-07 07:40:54', '2024-09-07 08:53:26', NULL),
(31, 1, 'https://soft.justtsc.com/company-profile', '2024-09-07 16:28:37', NULL, 'a', '103.159.73.224', '2024-09-07 10:28:37', '2024-09-07 10:41:32', NULL),
(32, 1, 'https://soft.justtsc.com/purchase', '2024-09-07 18:39:02', NULL, 'a', '119.40.87.9', '2024-09-07 12:39:02', '2024-09-07 12:39:21', NULL),
(33, 1, 'https://soft.justtsc.com/about', '2024-09-08 17:28:09', NULL, 'a', '103.159.73.224', '2024-09-08 11:28:09', '2024-09-08 11:28:16', NULL),
(34, 1, 'https://soft.justtsc.com/checkin-list', '2024-09-09 16:00:39', NULL, 'a', '103.159.73.224', '2024-09-09 10:00:39', '2024-09-09 10:01:39', NULL),
(35, 1, 'https://soft.justtsc.com/room', '2024-09-11 12:16:33', NULL, 'a', '103.159.73.224', '2024-09-11 06:16:33', '2024-09-11 06:16:52', NULL),
(36, 1, 'https://soft.justtsc.com/purchase', '2024-09-18 17:32:54', NULL, 'a', '103.159.73.224', '2024-09-18 11:32:54', '2024-09-18 11:33:00', NULL),
(37, 1, 'https://soft.justtsc.com/purchase', '2024-09-19 10:18:56', NULL, 'a', '103.159.73.224', '2024-09-19 04:18:56', '2024-09-19 04:20:10', NULL),
(38, 1, 'https://soft.justtsc.com/purchaseList', '2024-09-19 17:32:24', NULL, 'a', '103.159.73.102', '2024-09-19 11:32:24', '2024-09-19 11:39:45', NULL),
(39, 1, 'https://soft.justtsc.com/graph', '2024-09-20 00:28:16', NULL, 'a', '45.114.91.96', '2024-09-19 18:28:16', '2024-09-19 18:42:53', NULL),
(40, 1, 'https://soft.justtsc.com/order', '2024-09-23 16:05:27', NULL, 'a', '103.159.73.102', '2024-09-23 10:05:27', '2024-09-23 10:05:33', NULL),
(41, 1, 'https://soft.justtsc.com/issue', '2024-09-25 15:52:57', NULL, 'a', '103.159.73.102', '2024-09-25 09:52:57', '2024-09-25 09:53:20', NULL),
(42, 1, 'https://soft.justtsc.com/issueReturn', '2024-10-01 12:50:14', NULL, 'a', '103.159.73.97', '2024-10-01 06:50:14', '2024-10-01 07:00:00', NULL),
(43, 1, 'https://soft.justtsc.com/cash-transaction', '2024-10-01 15:21:12', NULL, 'a', '103.159.73.97', '2024-10-01 09:21:12', '2024-10-01 10:03:56', NULL),
(44, 1, 'https://soft.justtsc.com/user-access/2', '2024-10-02 09:47:05', NULL, 'a', '103.159.73.97', '2024-10-02 03:47:05', '2024-10-02 03:47:50', NULL),
(45, 1, 'https://soft.justtsc.com/bank-account', '2024-10-06 14:56:57', NULL, 'a', '103.159.73.93', '2024-10-06 08:56:57', '2024-10-06 09:13:48', NULL),
(46, 1, 'https://soft.justtsc.com/user', '2024-10-19 17:42:01', NULL, 'a', '103.159.73.88', '2024-10-19 11:42:01', '2024-10-19 12:37:25', NULL),
(47, 1, 'Dashboard', '2024-10-21 11:51:09', NULL, 'a', '103.159.73.88', '2024-10-21 05:51:09', '2024-10-21 05:51:09', NULL),
(48, 1, 'https://soft.justtsc.com/order', '2024-10-31 11:55:23', NULL, 'a', '103.159.73.75', '2024-10-31 05:55:23', '2024-10-31 05:55:27', NULL),
(49, 1, 'https://soft.justtsc.com/menu', '2024-10-31 11:55:30', NULL, 'a', '103.159.73.75', '2024-10-31 05:55:30', '2024-10-31 05:57:20', NULL),
(50, 1, 'https://soft.justtsc.com/cash-statement', '2024-10-31 12:00:20', NULL, 'a', '103.159.73.75', '2024-10-31 06:00:20', '2024-10-31 06:07:39', NULL),
(51, 1, 'https://soft.justtsc.com/order', '2024-10-31 12:13:35', NULL, 'a', '103.159.73.75', '2024-10-31 06:13:35', '2024-10-31 06:24:49', NULL),
(52, 1, 'http://127.0.0.1:8000/specialties', '2024-10-31 14:00:34', NULL, 'a', '127.0.0.1', '2024-10-31 08:00:34', '2024-10-31 10:01:19', NULL);

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
-- Indexes for table `issue_return_details`
--
ALTER TABLE `issue_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_return_details_issue_return_id_foreign` (`issue_return_id`),
  ADD KEY `issue_return_details_asset_id_foreign` (`asset_id`),
  ADD KEY `issue_return_details_added_by_foreign` (`added_by`),
  ADD KEY `issue_return_details_updated_by_foreign` (`updated_by`),
  ADD KEY `issue_return_details_deleted_by_foreign` (`deleted_by`),
  ADD KEY `issue_return_details_status_index` (`status`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `booking_masters`
--
ALTER TABLE `booking_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issue_return_details`
--
ALTER TABLE `issue_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `other_customers`
--
ALTER TABLE `other_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_heads`
--
ALTER TABLE `service_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_accesses`
--
ALTER TABLE `user_accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
-- Constraints for table `issue_return_details`
--
ALTER TABLE `issue_return_details`
  ADD CONSTRAINT `issue_return_details_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_return_details_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `issue_return_details_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `issue_return_details_issue_return_id_foreign` FOREIGN KEY (`issue_return_id`) REFERENCES `issue_returns` (`id`),
  ADD CONSTRAINT `issue_return_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
