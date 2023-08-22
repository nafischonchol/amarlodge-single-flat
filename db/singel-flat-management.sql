-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2023 at 03:47 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `singel-flat-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_balances`
--

DROP TABLE IF EXISTS `account_balances`;
CREATE TABLE IF NOT EXISTS `account_balances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `transaction_type` int NOT NULL DEFAULT '1',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `model_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `model_id`, `model_name`, `activity_type`, `activity`, `extra_info`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 2, '2', 'User', 'Login', 'Login successfully!', NULL, '2023-08-22 15:38:17', '2023-08-22 15:38:17', NULL),
(8, 2, '2', 'User', 'Login', 'Login successfully!', NULL, '2023-08-22 15:39:38', '2023-08-22 15:39:38', NULL),
(9, 2, '2', 'User', 'Login', 'Login successfully!', NULL, '2023-08-22 15:41:22', '2023-08-22 15:41:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_setups`
--

DROP TABLE IF EXISTS `bank_setups`;
CREATE TABLE IF NOT EXISTS `bank_setups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED NOT NULL,
  `flat_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `doc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_status` int DEFAULT '0' COMMENT '0=>Created,1=>Confirm,2=Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_building_id_foreign` (`building_id`),
  KEY `bills_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
CREATE TABLE IF NOT EXISTS `buildings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int NOT NULL DEFAULT '1',
  `lift` tinyint(1) NOT NULL DEFAULT '1',
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `upozila_id` bigint UNSIGNED DEFAULT NULL,
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_country_id_foreign` (`country_id`),
  KEY `buildings_division_id_foreign` (`division_id`),
  KEY `buildings_district_id_foreign` (`district_id`),
  KEY `buildings_upozila_id_foreign` (`upozila_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `building_staff_relations`
--

DROP TABLE IF EXISTS `building_staff_relations`;
CREATE TABLE IF NOT EXISTS `building_staff_relations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_staff_relations_building_id_foreign` (`building_id`),
  KEY `building_staff_relations_staff_id_foreign` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `committes`
--

DROP TABLE IF EXISTS `committes`;
CREATE TABLE IF NOT EXISTS `committes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `joining_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `details_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committes_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `mobile`, `email`, `address`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Flat Management', '01641377742', 'flat@gmail.com', NULL, 'images/company/logo/2a3ccc41-1c64-46a6-935a-59c2e9f358f3.webp', '2023-08-22 15:44:34', '2023-08-22 15:44:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

DROP TABLE IF EXISTS `complains`;
CREATE TABLE IF NOT EXISTS `complains` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'flat_id,owner',
  `complaint_against` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'flat_id,owner,all',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2023-07-23',
  `status` int NOT NULL DEFAULT '1',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `complains_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `bn_name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Australia', NULL, '+61', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(10, 'Austria', NULL, '+43', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(11, 'Azerbaijan', NULL, '+994', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(12, 'Bahamas', NULL, '+1', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(13, 'Bahrain', NULL, '+973', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(14, 'Bangladesh', NULL, '+88', 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(15, 'Barbados', NULL, '+1', 0, '2022-12-21 22:50:52', '2022-12-21 22:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_country_id_foreign` (`country_id`),
  KEY `districts_division_id_foreign` (`division_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5387 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `country_id`, `division_id`, `name`, `bn_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 14, 1, 'Comilla', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(2, 14, 1, 'Feni', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(3, 14, 1, 'Brahmanbaria', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(4, 14, 1, 'Rangamati', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(5, 14, 1, 'Noakhali', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(6, 14, 1, 'Chandpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(7, 14, 1, 'Lakshmipur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(8, 14, 1, 'Chattogram', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(9, 14, 1, 'Coxsbazar', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(10, 14, 1, 'Khagrachhari', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(11, 14, 1, 'Bandarban', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(12, 14, 2, 'Sirajganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(13, 14, 2, 'Pabna', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(14, 14, 2, 'Bogura', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(15, 14, 2, 'Rajshahi', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(16, 14, 2, 'Natore', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(17, 14, 2, 'Joypurhat', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(18, 14, 2, 'Chapainawabganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(19, 14, 2, 'Naogaon', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(20, 14, 3, 'Jashore', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(21, 14, 3, 'Satkhira', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(22, 14, 3, 'Meherpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(23, 14, 3, 'Narail', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(24, 14, 3, 'Chuadanga', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(25, 14, 3, 'Kushtia', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(26, 14, 3, 'Magura', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(27, 14, 3, 'Khulna', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(28, 14, 3, 'Bagerhat', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(29, 14, 3, 'Jhenaidah', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(30, 14, 4, 'Jhalakathi', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(31, 14, 4, 'Patuakhali', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(32, 14, 4, 'Pirojpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(33, 14, 4, 'Barisal', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(34, 14, 4, 'Bhola', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(35, 14, 4, 'Barguna', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(36, 14, 5, 'Sylhet', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(37, 14, 5, 'Moulvibazar', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(38, 14, 5, 'Habiganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(39, 14, 5, 'Sunamganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(40, 14, 6, 'Narsingdi', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(41, 14, 6, 'Gazipur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(42, 14, 6, 'Shariatpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(43, 14, 6, 'Narayanganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(44, 14, 6, 'Tangail', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(45, 14, 6, 'Kishoreganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(46, 14, 6, 'Manikganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(47, 14, 6, 'Dhaka', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(48, 14, 6, 'Munshiganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(49, 14, 6, 'Rajbari', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(50, 14, 6, 'Madaripur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(51, 14, 6, 'Gopalganj', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(52, 14, 6, 'Faridpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(53, 14, 7, 'Panchagarh', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(54, 14, 7, 'Dinajpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(55, 14, 7, 'Lalmonirhat', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(56, 14, 7, 'Nilphamari', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(57, 14, 7, 'Gaibandha', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(58, 14, 7, 'Thakurgaon', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(59, 14, 7, 'Rangpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(60, 14, 7, 'Kurigram', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(61, 14, 8, 'Sherpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(62, 14, 8, 'Mymensingh', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(63, 14, 8, 'Jamalpur', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52'),
(64, 14, 8, 'Netrokona', NULL, 1, '2022-12-21 22:50:52', '2022-12-21 22:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `priority` int NOT NULL DEFAULT '0',
  `photo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `divisions_country_id_foreign` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `country_id`, `name`, `bn_name`, `status`, `priority`, `photo`, `created_at`, `updated_at`) VALUES
(1, 14, 'Chattagram', NULL, 1, 999, 'images/users/2023-03-0163ff1ee6b88c2.webp', '2022-12-21 22:50:52', '2023-03-01 03:48:49'),
(2, 14, 'Rajshahi', NULL, 1, 994, 'images/users/2023-03-0163ff1f0b91edb.webp', '2022-12-21 22:50:52', '2023-03-01 03:52:34'),
(3, 14, 'Khulna', NULL, 1, 997, 'images/users/2023-03-0163ff1f550ed10.webp', '2022-12-21 22:50:52', '2023-03-01 03:49:47'),
(4, 14, 'Barisal', NULL, 1, 996, 'images/users/2023-03-0163ff2016c8f33.webp', '2022-12-21 22:50:52', '2023-03-01 03:51:18'),
(5, 14, 'Sylhet', NULL, 1, 998, 'images/users/2023-03-0163ff1fd5610a4.webp', '2022-12-21 22:50:52', '2023-03-01 03:50:13'),
(6, 14, 'Dhaka', NULL, 1, 1000, 'images/users/2023-03-0163ff1fa4910a7.webp', '2022-12-21 22:50:52', '2023-03-01 03:49:24'),
(7, 14, 'Rangpur', NULL, 1, 995, 'images/users/2023-03-0163ff202cd17a9.webp', '2022-12-21 22:50:52', '2023-03-01 03:51:40'),
(8, 14, 'Mymensingh', NULL, 1, 993, 'images/users/2023-03-0163ff2044e0a93.webp', '2022-12-21 22:50:52', '2023-03-01 03:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `due_amounts`
--

DROP TABLE IF EXISTS `due_amounts`;
CREATE TABLE IF NOT EXISTS `due_amounts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `flat_id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `due_amounts_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flats`
--

DROP TABLE IF EXISTS `flats`;
CREATE TABLE IF NOT EXISTS `flats` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `floor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'What floor is this flat on?',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` double NOT NULL DEFAULT '1',
  `parking_area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` int NOT NULL COMMENT 'How many room',
  `washroom` int NOT NULL COMMENT 'How many washroom',
  `balcony` tinyint(1) NOT NULL COMMENT 'Is corridor exist',
  `utilities` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Gas,water,electricty ect.',
  `booked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'flat sold or not',
  `move_out_date` date DEFAULT NULL,
  `flat_for` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rent' COMMENT 'Sell or rent',
  `rental` double NOT NULL DEFAULT '0',
  `rented_to_bachelors` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is rent to bechelors?',
  `minimumStay` int NOT NULL DEFAULT '1' COMMENT 'Default 1 month',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `termsAndCondition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `youtube_video` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flats_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flat_costs`
--

DROP TABLE IF EXISTS `flat_costs`;
CREATE TABLE IF NOT EXISTS `flat_costs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL DEFAULT '500',
  `cause` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `recevier_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transection_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flat_costs_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `user_id`, `key`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'language', '[\n    {\n        \"id\": 1,\n        \"name\": \"Eng\",\n        \"direction\": \"ltr\",\n        \"code\": \"en\",\n        \"status\": 1,\n        \"default\": false\n    },\n    {\n        \"id\": 2,\n        \"name\": \"Bangla\",\n        \"direction\": \"ltr\",\n        \"code\": \"bd\",\n        \"status\": 1,\n        \"default\": false\n    }\n]', NULL, NULL, NULL),
(2, NULL, 'pnc_language', '[\"en\",\"bd\"]', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_costs`
--

DROP TABLE IF EXISTS `maintenance_costs`;
CREATE TABLE IF NOT EXISTS `maintenance_costs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL DEFAULT '500',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `recevier_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transection_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_payer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Owner',
  `checked_flats` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenance_costs_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_23_115048_create_countries_table', 1),
(6, '2023_05_23_115055_create_divisions_table', 1),
(7, '2023_05_23_115101_create_districts_table', 1),
(8, '2023_05_23_115107_create_upozilas_table', 1),
(9, '2023_06_08_064347_create_buildings_table', 1),
(10, '2023_06_08_064405_create_flats_table', 1),
(11, '2023_06_08_125007_create_staff_table', 1),
(12, '2023_06_10_112839_create_building_staff_relations_table', 1),
(13, '2023_06_11_121633_create_permission_tables', 1),
(14, '2023_06_14_105954_create_visitors_table', 1),
(15, '2023_06_18_062347_create_tenants_table', 1),
(16, '2023_06_19_050718_create_notices_table', 1),
(17, '2023_06_19_085916_create_complains_table', 1),
(18, '2023_06_20_043503_create_utility_setups_table', 1),
(19, '2023_06_20_055720_create_maintenance_costs_table', 1),
(20, '2023_06_20_091748_create_bank_setups_table', 1),
(21, '2023_06_21_164357_create_tenant_information_table', 1),
(22, '2023_06_21_164732_create_tenant_family_members_table', 1),
(23, '2023_06_24_143523_create_bills_table', 1),
(24, '2023_06_25_145713_create_payment_bills_table', 1),
(25, '2023_06_25_145725_create_payment_details_table', 1),
(26, '2023_06_25_164257_create_due_amounts_table', 1),
(27, '2023_07_03_134729_create_flat_costs_table', 1),
(28, '2023_07_05_125007_create_account_balances_table', 1),
(29, '2023_07_06_190025_create_rents_table', 1),
(30, '2023_07_12_152652_create_tenant_advanced_amounts_table', 1),
(31, '2023_07_15_104944_create_move_out_histories_table', 1),
(32, '2023_07_19_114259_create_general_settings_table', 1),
(33, '2023_07_19_171738_create_committes_table', 1),
(34, '2023_07_20_123724_create_meetings_table', 1),
(35, '2023_07_20_154715_create_activity_logs_table', 1),
(36, '2023_07_22_123738_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `move_out_histories`
--

DROP TABLE IF EXISTS `move_out_histories`;
CREATE TABLE IF NOT EXISTS `move_out_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `tenant_id` bigint UNSIGNED DEFAULT NULL,
  `rent_month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `move_out_date` date NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `move_out_histories_flat_id_foreign` (`flat_id`),
  KEY `move_out_histories_tenant_id_foreign` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `move_out_requests`
--

DROP TABLE IF EXISTS `move_out_requests`;
CREATE TABLE IF NOT EXISTS `move_out_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `tenant_id` bigint UNSIGNED DEFAULT NULL,
  `move_out_date` date NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flat_id` (`flat_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
CREATE TABLE IF NOT EXISTS `notices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tenant' COMMENT 'tenant,staff',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `target_id` bigint UNSIGNED NOT NULL,
  `notification_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Meeting',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_bills`
--

DROP TABLE IF EXISTS `payment_bills`;
CREATE TABLE IF NOT EXISTS `payment_bills` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED NOT NULL,
  `flat_id` bigint UNSIGNED NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `receiver_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT '0' COMMENT 'This is total amount that should paid,but user can pay less.',
  `pay_amount` double NOT NULL DEFAULT '0' COMMENT 'User paid amount',
  `use_advanced_amount` double NOT NULL DEFAULT '0',
  `discount_amount` double NOT NULL DEFAULT '0',
  `due_amount` double NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `status` int NOT NULL DEFAULT '2' COMMENT '0=>Created,1=>Confirm,2=Pending',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_bills_building_id_foreign` (`building_id`),
  KEY `payment_bills_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

DROP TABLE IF EXISTS `payment_details`;
CREATE TABLE IF NOT EXISTS `payment_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_bill_id` bigint UNSIGNED NOT NULL,
  `bill_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Bill id null when previous due bill amount store',
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_details_payment_bill_id_foreign` (`payment_bill_id`),
  KEY `payment_details_bill_id_foreign` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `module`, `description`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Dashboard', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(2, 'RBAC', 'RBAC', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(3, 'user.list', 'User List', 'RBAC', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(4, 'user.add', 'User Add', 'RBAC', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(5, 'role.list', 'Role List', 'RBAC', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(6, 'role.add', 'Role Add', 'RBAC', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(7, 'building', 'Building', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(8, 'building.list', 'Building List', 'Building', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(9, 'building.add', 'Building Add', 'Building', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(10, 'building.accounts', 'Building Account', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(11, 'building.accounts.summary', 'Summary', 'Building Account', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(12, 'building.payments.list', 'Payments List', 'Building Account', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(13, 'rent', 'Rent', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(14, 'rent.list', 'Rent List', 'Rent', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(15, 'rent.add', 'Rent Add', 'Rent', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(16, 'flat', 'Flat', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(17, 'flat.list', 'Flat List', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(18, 'flat.upcoming.available', 'Upcoming Available', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(19, 'flat.add', 'Flat Add', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(20, 'flat.cost.list', 'Cost', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(21, 'flat.accounts.index', 'Accounts', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(23, 'flats.bill.list', 'Due Bills', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(24, 'flats.bill.pay.history', 'Bill Pay History', 'Flat', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(25, 'tenant', 'Tenant', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(26, 'tenant.list', 'Tenant List', 'Tenant', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(27, 'tenant.add', 'Tenant Add', 'Tenant', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(28, 'tenant.information.list', 'Tenant Information', 'Tenant', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(29, 'tenant.move.out.list', 'Move Out List', 'Tenant', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(30, 'move.out.request', 'Move Out Request', 'Tenant', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(31, 'visitor', 'Visitor', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(32, 'visitor.list', 'Visitor List', 'Visitor', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(33, 'visitor.add', 'Visitor Add', 'Visitor', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(34, 'staff', 'Staff', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(35, 'staff.list', 'Staff List', 'Staff', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(36, 'staff.add', 'Staff Add', 'Staff', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(37, 'notice', 'Notice', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(38, 'notice.list', 'Notice List', 'Notice', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(39, 'notice.add', 'Notice Add', 'Notice', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(40, 'complain', 'Complain', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(41, 'complain.list', 'Complain List', 'Complain', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(42, 'complain.add', 'Complain Add', 'Complain', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(43, 'committe', 'Management Committe', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(44, 'committe.list', 'Member List', 'Management Committe', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(45, 'committe.add', 'Member Add', 'Management Committe', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(46, 'meeting', 'Meeting', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(47, 'meeting.list', 'Meeting List', 'Meeting', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(48, 'meeting.add', 'Meeting Add', 'Meeting', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(49, 'maintenance-cost', 'Maintenance Cost', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(50, 'maintenance.list', 'Cost List', 'Maintenance Cost', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(51, 'maintenance.add', 'Cost Add', 'Maintenance Cost', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(52, 'setting-utility', 'Utility', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(53, 'setting.utility.setup.list', 'Utility BillSetup', 'Utility', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(54, 'setting', 'Setting', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(55, 'setting.general', 'General Setting', 'Setting', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(56, 'setting.bank.setup', 'Bank Setup', 'Setting', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(57, 'activity.log.list', 'Activity Log', 'Setting', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(58, 'report', 'Report', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(59, 'report.complain.filter', 'Complain Report', 'Report', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(60, 'report.visitor.filter', 'Visitor Report', 'Report', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(61, 'report.mc.filter', 'Maintenance Report', 'Report', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(62, 'report.rental.filter', 'Rental Report', 'Report', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(63, 'language', 'Language', '', 'MODULE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28'),
(64, 'language.list', 'Language', 'Language', 'FEATURE', 'web', '2023-07-23 07:15:28', '2023-07-23 07:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'my-app-token', 'cfc140ebee326d8bbefc699865a2e523bd79b1605645a5f628f9b7777b92f9ed', '[\"*\"]', '2023-08-21 10:58:45', NULL, '2023-08-21 10:57:17', '2023-08-21 10:58:45'),
(2, 'App\\Models\\User', 2, 'my-app-token', 'a06ef76b60cad51fffe7262a707ab7ac88d41c30702281d4eee1e484bbed3c54', '[\"*\"]', '2023-08-22 15:39:38', NULL, '2023-08-22 15:38:17', '2023-08-22 15:39:38'),
(3, 'App\\Models\\User', 2, 'my-app-token', '4965d95f5acbf99ad39f40398daa1054e3ef52fd855f3ed24b0df4c2e46b7f53', '[\"*\"]', '2023-08-22 15:41:22', NULL, '2023-08-22 15:39:38', '2023-08-22 15:41:22'),
(4, 'App\\Models\\User', 2, 'my-app-token', '08686e4be512d3484c8b530ad9770ae5e9be4592af44b23b781079911cc27bea', '[\"*\"]', '2023-08-22 15:46:37', NULL, '2023-08-22 15:41:22', '2023-08-22 15:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `rents`
--

DROP TABLE IF EXISTS `rents`;
CREATE TABLE IF NOT EXISTS `rents` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `rent_amount` double NOT NULL,
  `water_bill` double NOT NULL,
  `gas_bill` double NOT NULL,
  `security_bill` double DEFAULT '0',
  `garbage_bill` double DEFAULT '0',
  `service_charge` double DEFAULT '0',
  `electric_bill` double DEFAULT '0',
  `other_bill` double DEFAULT '0',
  `status` int DEFAULT '0' COMMENT '0=>Created,1=>Confirm,2=Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rents_building_id_foreign` (`building_id`),
  KEY `rents_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', 'web', NULL, NULL),
(2, 'Tenant', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(64, 1),
(1, 2),
(16, 2),
(20, 2),
(21, 2),
(23, 2),
(24, 2),
(25, 2),
(28, 2),
(30, 2),
(37, 2),
(38, 2),
(40, 2),
(41, 2),
(42, 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE IF NOT EXISTS `tenants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` double NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member` int DEFAULT NULL COMMENT 'Total family member',
  `advanced_amount` double DEFAULT '0',
  `rent_per_month` double DEFAULT '0',
  `issue_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenants_building_id_foreign` (`building_id`),
  KEY `tenants_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenant_advanced_amounts`
--

DROP TABLE IF EXISTS `tenant_advanced_amounts`;
CREATE TABLE IF NOT EXISTS `tenant_advanced_amounts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `flat_id` bigint UNSIGNED DEFAULT NULL,
  `tenant_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `transaction_type` int NOT NULL DEFAULT '1',
  `status` int NOT NULL DEFAULT '1' COMMENT '0=>Created,1=>Confirm,2=Processing,3=>Cancel',
  `doc_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_advanced_amounts_flat_id_foreign` (`flat_id`),
  KEY `tenant_advanced_amounts_tenant_id_foreign` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenant_family_members`
--

DROP TABLE IF EXISTS `tenant_family_members`;
CREATE TABLE IF NOT EXISTS `tenant_family_members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_information_id` bigint UNSIGNED NOT NULL,
  `member_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_age` int NOT NULL,
  `member_profession` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_family_members_tenant_information_id_foreign` (`tenant_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenant_information`
--

DROP TABLE IF EXISTS `tenant_information`;
CREATE TABLE IF NOT EXISTS `tenant_information` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED NOT NULL,
  `flat_id` bigint UNSIGNED NOT NULL,
  `tenant_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `marital_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institute_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `religion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `educational_qualification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_relation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_information_building_id_foreign` (`building_id`),
  KEY `tenant_information_flat_id_foreign` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upozilas`
--

DROP TABLE IF EXISTS `upozilas`;
CREATE TABLE IF NOT EXISTS `upozilas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `district_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deactivate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upozilas_district_id_foreign` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=517 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upozilas`
--

INSERT INTO `upozilas` (`id`, `district_id`, `name`, `bn_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 47, 'Demra', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(2, 47, 'Kodomtali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(3, 47, 'Dhaka Cantonment', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(4, 47, 'Dhamrai', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(5, 47, 'Dhanmondi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(6, 47, 'Hazaribagh', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(7, 47, 'Gulshan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(8, 47, 'Banani', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(9, 47, 'Jatrabari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(10, 47, 'Shyampur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(11, 47, 'Joypara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(12, 47, 'Keraniganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(13, 47, 'Kamrangirchar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(14, 47, 'Badda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(15, 47, 'Khilgaon', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(16, 47, 'Rampura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(17, 47, 'Vatara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(18, 47, 'Khilkhet', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(19, 47, 'Bimanbandar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(20, 47, 'Shah Ali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(21, 47, 'Lalbag', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(22, 47, 'Chalkbazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(23, 47, 'Bhasahantek', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(24, 47, 'Kafrul', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(25, 47, 'Mirpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(26, 47, 'Pallabi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(27, 47, 'Rupnagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(28, 47, 'Sher-E-Bangla Nagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(29, 47, 'Darus-Salam', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(30, 47, 'Adabor', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(31, 47, 'Mohammadpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(32, 47, 'Motijheel', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(33, 47, 'Nawabganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(34, 47, 'Kalabagan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(35, 47, 'New market', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(36, 47, 'Palton', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(37, 47, 'Shahbag', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(38, 47, 'Ramna', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(39, 47, 'Shahjahanpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(40, 47, 'Sabujbag', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(41, 47, 'Mugda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(42, 47, 'Savar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(43, 47, 'Kotwali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(44, 47, 'Bangshal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(45, 47, 'Sutrapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(46, 47, 'Wari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(47, 47, 'Gendaria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(48, 47, 'Tejgaon', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(49, 47, 'Tejgaon Industrial', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(50, 47, 'Uttara East', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(51, 47, 'Uttara West', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(52, 47, 'Dakshin Khan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(53, 47, 'Uttar Khan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(54, 47, 'Turag', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(55, 45, 'Bajitpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(56, 45, 'Bhairob', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(57, 45, 'Hossenpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(58, 45, 'Itna', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(59, 45, 'Karimganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(60, 45, 'Katiadi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(61, 45, 'Kishoreganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(62, 45, 'Kuliarchar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(63, 45, 'Mithamoin', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(64, 45, 'Nikli', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(65, 45, 'Ostagram', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(66, 45, 'Pakundia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(67, 45, 'Tarial', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(68, 43, 'Araihazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(69, 43, 'Baidder Bazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(70, 43, 'Bandar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(71, 43, 'Fatullah', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(72, 43, 'Narayanganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(73, 43, 'Rupganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(74, 43, 'Siddirganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(75, 48, 'Gajaria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(76, 48, 'Lohajong', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(77, 48, 'Munshiganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(78, 48, 'Sirajdikhan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(79, 48, 'Srinagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(80, 48, 'Tangibari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(81, 40, 'Belabo', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(82, 40, 'Monohordi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(83, 40, 'Narshingdi Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(84, 40, 'Palash', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(85, 40, 'Raypura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(86, 40, 'Shibpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(87, 41, 'Gazipur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(88, 41, 'Kaliakaar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(89, 41, 'Kaliganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(90, 41, 'Kapashia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(91, 41, 'Monnunagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(92, 41, 'Sreepur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(93, 41, 'Sripur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(94, 49, 'Baliakandi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(95, 49, 'Pangsha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(96, 49, 'Rajbari Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(97, 52, 'Alfadanga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(98, 52, 'Bhanga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(99, 52, 'Boalmari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(100, 52, 'Charbhadrasan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(101, 52, 'Faridpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(102, 52, 'Madukhali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(103, 52, 'Nagarkanda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(104, 52, 'Sadarpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(105, 52, 'Shriangan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(106, 50, 'Barhamganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(107, 50, 'kalkini', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(108, 50, 'Madaripur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(109, 50, 'Rajoir', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(110, 42, 'Bhedorganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(111, 42, 'Damudhya', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(112, 42, 'Gosairhat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(113, 42, 'Jajira', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(114, 42, 'Naria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(115, 42, 'Shariatpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(116, 51, 'Gopalganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(117, 51, 'Kashiani', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(118, 51, 'Kotalipara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(119, 51, 'Maksudpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(120, 51, 'Tungipara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(121, 46, 'Doulatpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(122, 46, 'Gheor', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(123, 46, 'Lechhraganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(124, 46, 'Manikganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(125, 46, 'Saturia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(126, 46, 'Shibloya', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(127, 46, 'Singari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(128, 44, 'Basail', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(129, 44, 'Bhuapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(130, 44, 'Delduar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(131, 44, 'Ghatail', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(132, 44, 'Gopalpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(133, 44, 'Kalihati', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(134, 44, 'Kashkaolia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(135, 44, 'Madhupur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(136, 44, 'Mirzapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(137, 44, 'Nagarpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(138, 44, 'Sakhipur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(139, 44, 'Tangail Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(140, 3, 'Akhaura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(141, 3, 'Banchharampur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(142, 3, 'Brahamanbaria Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(143, 3, 'Kasba', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(144, 3, 'Nabinagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(145, 3, 'Nasirnagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(146, 3, 'Sarail', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(147, 1, 'Barura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(148, 1, 'Brahmanpara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(149, 1, 'Burichang', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(150, 1, 'Chandina', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(151, 1, 'Chouddagram', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(152, 1, 'Comilla Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(153, 1, 'Daudkandi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(154, 1, 'Davidhar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(155, 1, 'Homna', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(156, 1, 'Laksam', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(157, 1, 'Langalkot', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(158, 1, 'Muradnagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(159, 7, 'Char Alexgander', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(160, 7, 'Lakshimpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(161, 7, 'Ramganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(162, 7, 'Raypur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(163, 5, 'Basurhat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(164, 5, 'Begumganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(165, 5, 'Chatkhil', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(166, 5, 'Hatiya', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(167, 5, 'Noakhali Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(168, 5, 'Senbag', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(169, 2, 'Chhagalnaia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(170, 2, 'Dagonbhuia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(171, 2, 'Feni Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(172, 2, 'Pashurampur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(173, 2, 'Sonagazi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(174, 8, 'Anawara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(175, 8, 'Boalkhali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(176, 8, 'Chittagong Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(177, 8, 'East Joara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(178, 8, 'Fatikchhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(179, 8, 'Hathazari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(180, 8, 'Jaldi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(181, 8, 'Lohagara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(182, 8, 'Mirsharai', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(183, 8, 'Patia Head Office', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(184, 8, 'Rangunia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(185, 8, 'Rouzan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(186, 8, 'Sandwip', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(187, 8, 'Satkania', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(188, 8, 'Sitakunda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(189, 10, 'Diginala', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(190, 10, 'Khagrachari Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(191, 10, 'Laxmichhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(192, 10, 'Mahalchhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(193, 10, 'Matiranga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(194, 10, 'Panchhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(195, 10, 'Ramghar Head Office', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(196, 4, 'Barakal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(197, 4, 'Bilaichhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(198, 4, 'Jarachhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(199, 4, 'Kalampati', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(200, 4, 'kaptai', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(201, 4, 'Longachh', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(202, 4, 'Marishya', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(203, 4, 'Naniachhar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(204, 4, 'Rajsthali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(205, 4, 'Rangamati Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(206, 11, 'Alikadam', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(207, 11, 'Bandarban Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(208, 11, 'Naikhong', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(209, 11, 'Roanchhari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(210, 11, 'Ruma', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(211, 11, 'Thanchi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(212, 9, 'Chiringga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(213, 9, 'Coxs Bazar Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(214, 9, 'Gorakghat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(215, 9, 'Kutubdia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(216, 9, 'Ramu', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(217, 9, 'Teknaf', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(218, 9, 'Ukhia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(219, 6, 'Chandpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(220, 6, 'Faridganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(221, 6, 'Hajiganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(222, 6, 'Hayemchar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(223, 6, 'Kachua', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(224, 6, 'Matlobganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(225, 6, 'Shahrasti', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(226, 62, 'Bhaluka', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(227, 62, 'Fulbaria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(228, 62, 'Gaforgaon', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(229, 62, 'Gouripur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(230, 62, 'Haluaghat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(231, 62, 'Isshwargonj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(232, 62, 'Muktagachha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(233, 62, 'Mymensingh Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(234, 62, 'Nandail', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(235, 62, 'Phulpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(236, 62, 'Trishal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(237, 64, 'Susung Durgapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(238, 64, 'Atpara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(239, 64, 'Barhatta', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(240, 64, 'Dharmapasha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(241, 64, 'Dhobaura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(242, 64, 'Kalmakanda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(243, 64, 'Kendua', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(244, 64, 'Khaliajuri', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(245, 64, 'Madan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(246, 64, 'Moddhynagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(247, 64, 'Mohanganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(248, 64, 'Netrakona Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(249, 64, 'Purbadhola', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(250, 63, 'Dewangonj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(251, 63, 'Islampur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(252, 63, 'Jamalpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(253, 63, 'Malandah', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(254, 63, 'Mathargonj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(255, 63, 'Shorishabari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(256, 61, 'Bakshigonj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(257, 61, 'Jhinaigati', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(258, 61, 'Nakla', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(259, 61, 'Nalitabari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(260, 61, 'Sherpur Shadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(261, 61, 'Shribardi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(262, 25, 'Bheramara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(263, 25, 'Janipur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(264, 25, 'Kumarkhali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(265, 25, 'Kustia Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(266, 25, 'Mirpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(267, 25, 'Rafayetpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(268, 22, 'Gangni', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(269, 22, 'Meherpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(270, 24, 'Alamdanga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(271, 24, 'Chuadanga Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(272, 24, 'Damurhuda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(273, 24, 'Doulatganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(274, 29, 'Harinakundu', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(275, 29, 'Jinaidaha Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(276, 29, 'Kotchandpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(277, 29, 'Maheshpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(278, 29, 'Naldanga', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(279, 29, 'Shailakupa', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(280, 20, 'Bagharpara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(281, 20, 'Chaugachha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(282, 20, 'Jessore Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(283, 20, 'Jhikargachha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(284, 20, 'Keshabpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(285, 20, 'Monirampur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(286, 20, 'Noapara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(287, 20, 'Sarsa', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(288, 23, 'Kalia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(289, 23, 'Laxmipasha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(290, 23, 'Mohajan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(291, 23, 'Narail Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(292, 26, 'Arpara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(293, 26, 'Magura Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(294, 26, 'Mohammadpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(295, 26, 'Shripur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(296, 27, 'Alaipur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(297, 27, 'Batiaghat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(298, 27, 'Chalna Bazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(299, 27, 'Digalia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(300, 27, 'Khulna Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(301, 27, 'Madinabad', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(302, 27, 'Paikgachha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(303, 27, 'Phultala', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(304, 27, 'Sajiara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(305, 27, 'Terakhada', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(306, 28, 'Bagerhat Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(307, 28, 'Chalna Ankorage', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(308, 28, 'Chitalmari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(309, 28, 'Fakirhat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(310, 28, 'Kachua UPO', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(311, 28, 'Mollahat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(312, 28, 'Morelganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(313, 28, 'Rampal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(314, 28, 'Rayenda', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(315, 21, 'Ashashuni', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(316, 21, 'Debbhata', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(317, 21, 'kalaroa', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(318, 21, 'Kaliganj UPO', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(319, 21, 'Nakipur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(320, 21, 'Satkhira Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(321, 21, 'Taala', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(322, 39, 'Bishamsarpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(323, 39, 'Chhatak', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(324, 39, 'Dhirai Chandpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(325, 39, 'Duara bazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(326, 39, 'Ghungiar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(327, 39, 'Jagnnathpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(328, 39, 'Sachna', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(329, 39, 'Sunamganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(330, 39, 'Tahirpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(331, 36, 'Balaganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(332, 36, 'Bianibazar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(333, 36, 'Bishwanath', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(334, 36, 'Fenchuganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(335, 36, 'Goainhat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(336, 36, 'Gopalganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(337, 36, 'Jaintapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(338, 36, 'Jakiganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(339, 36, 'Kanaighat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(340, 36, 'Kompanyganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(341, 36, 'Sylhet Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(342, 37, 'Baralekha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(343, 37, 'Kamalganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(344, 37, 'Kulaura', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(345, 37, 'Moulvibazar Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(346, 37, 'Rajnagar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(347, 37, 'Srimangal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(348, 38, 'Azmireeganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(349, 38, 'Bahubal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(350, 38, 'Baniachang', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(351, 38, 'Chunarughat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(352, 38, 'Hobiganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(353, 38, 'Kalauk', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(354, 38, 'Madhabpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(355, 38, 'Nabiganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(356, 33, 'Agailzhara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(357, 33, 'Babuganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(358, 33, 'Barajalia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(359, 33, 'Barishal Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(360, 33, 'Gouranadi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(361, 33, 'Mahendiganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(362, 33, 'Muladi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(363, 33, 'Sahebganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(364, 33, 'Uzirpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(365, 34, 'Bhola Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(366, 34, 'Borhanuddin UPO', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(367, 34, 'Charfashion', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(368, 34, 'Doulatkhan', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(369, 34, 'Hajirhat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(370, 34, 'Hatshoshiganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(371, 34, 'Lalmohan UPO', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(372, 30, 'Jhalokathi Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(373, 30, 'Kathalia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(374, 30, 'Nalchhiti', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(375, 30, 'Rajapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(376, 32, 'Banaripara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(377, 32, 'Bhandaria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(378, 32, 'kaukhali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(379, 32, 'Mathbaria', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(380, 32, 'Nazirpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(381, 32, 'Pirojpur Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(382, 32, 'Swarupkathi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(383, 31, 'Bauphal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(384, 31, 'Dashmina', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(385, 31, 'Galachipa', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(386, 31, 'Khepupara', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(387, 31, 'Patuakhali Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(388, 31, 'Subidkhali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(389, 35, 'Amtali', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(390, 35, 'Bamna', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(391, 35, 'Barguna Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(392, 35, 'Betagi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(393, 35, 'Patharghata', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(394, 14, 'Alamdighi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(395, 14, 'Bogra Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(396, 14, 'Dhunat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(397, 14, 'Dupchachia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(398, 14, 'Gabtoli', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(399, 14, 'Kahalu', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(400, 14, 'Nandigram', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(401, 14, 'Sariakandi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(402, 14, 'Sherpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(403, 14, 'Shibganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(404, 14, 'Sonatola', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(405, 17, 'Akkelpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(406, 17, 'Joypurhat Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(407, 17, 'kalai', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(408, 17, 'Khetlal', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(409, 17, 'panchbibi', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(410, 15, 'Bagha', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(411, 15, 'Bhabaniganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(412, 15, 'Charghat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(413, 15, 'Durgapur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(414, 15, 'Godagari', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(415, 15, 'Khod Mohanpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(416, 15, 'Lalitganj', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(417, 15, 'Putia', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(418, 15, 'Rajshahi Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(419, 15, 'Tanor', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(420, 18, 'Bholahat', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(421, 18, 'Chapinawabganj Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(422, 18, 'Nachol', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(423, 18, 'Rohanpur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(424, 18, 'Shibganj U P O', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(425, 16, 'Gopalpur UPO', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(426, 16, 'Harua', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(427, 16, 'Hatgurudaspur', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(428, 16, 'Laxman', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(429, 16, 'Natore Sadar', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53'),
(430, 16, 'Singra', NULL, 1, '2022-12-21 22:50:53', '2022-12-21 22:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Tanent',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `image`, `tenant_id`, `address`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Nafis Chonchol', 'nafis@gmail.com', NULL, NULL, '$2y$10$lk.pC3//kD85cpMnnEfNR.B0VM8/.cfu6blvsXhEm0ZvdmxKio05u', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utility_setups`
--

DROP TABLE IF EXISTS `utility_setups`;
CREATE TABLE IF NOT EXISTS `utility_setups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `water_bill` double NOT NULL DEFAULT '500',
  `gas_bill` double NOT NULL DEFAULT '500',
  `security_bill` double NOT NULL DEFAULT '500',
  `garbage_bill` double NOT NULL DEFAULT '100',
  `service_charge` double NOT NULL DEFAULT '500',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utility_setups_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `flat_id` int DEFAULT NULL,
  `host_information` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` double NOT NULL,
  `in_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `out_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitors_building_id_foreign` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buildings_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buildings_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buildings_upozila_id_foreign` FOREIGN KEY (`upozila_id`) REFERENCES `upozilas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `building_staff_relations`
--
ALTER TABLE `building_staff_relations`
  ADD CONSTRAINT `building_staff_relations_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `building_staff_relations_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `committes`
--
ALTER TABLE `committes`
  ADD CONSTRAINT `committes_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `complains`
--
ALTER TABLE `complains`
  ADD CONSTRAINT `complains_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `districts_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `due_amounts`
--
ALTER TABLE `due_amounts`
  ADD CONSTRAINT `due_amounts_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `flats`
--
ALTER TABLE `flats`
  ADD CONSTRAINT `flats_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

--
-- Constraints for table `flat_costs`
--
ALTER TABLE `flat_costs`
  ADD CONSTRAINT `flat_costs_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

--
-- Constraints for table `maintenance_costs`
--
ALTER TABLE `maintenance_costs`
  ADD CONSTRAINT `maintenance_costs_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `move_out_histories`
--
ALTER TABLE `move_out_histories`
  ADD CONSTRAINT `move_out_histories_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`),
  ADD CONSTRAINT `move_out_histories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`);

--
-- Constraints for table `move_out_requests`
--
ALTER TABLE `move_out_requests`
  ADD CONSTRAINT `move_out_requests_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`),
  ADD CONSTRAINT `move_out_requests_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_bills`
--
ALTER TABLE `payment_bills`
  ADD CONSTRAINT `payment_bills_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_bills_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`),
  ADD CONSTRAINT `payment_details_payment_bill_id_foreign` FOREIGN KEY (`payment_bill_id`) REFERENCES `payment_bills` (`id`);

--
-- Constraints for table `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `rents_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  ADD CONSTRAINT `rents_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  ADD CONSTRAINT `tenants_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `tenant_advanced_amounts`
--
ALTER TABLE `tenant_advanced_amounts`
  ADD CONSTRAINT `tenant_advanced_amounts_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`),
  ADD CONSTRAINT `tenant_advanced_amounts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`);

--
-- Constraints for table `tenant_family_members`
--
ALTER TABLE `tenant_family_members`
  ADD CONSTRAINT `tenant_family_members_tenant_information_id_foreign` FOREIGN KEY (`tenant_information_id`) REFERENCES `tenant_information` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenant_information`
--
ALTER TABLE `tenant_information`
  ADD CONSTRAINT `tenant_information_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tenant_information_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`);

--
-- Constraints for table `upozilas`
--
ALTER TABLE `upozilas`
  ADD CONSTRAINT `upozilas_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `utility_setups`
--
ALTER TABLE `utility_setups`
  ADD CONSTRAINT `utility_setups_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
