-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 09:16 AM
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
-- Database: `ictsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_request`
--

CREATE TABLE `evaluation_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `evaluator_emp_id` char(7) NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `outcome` int(10) UNSIGNED NOT NULL,
  `realiability_quality` int(10) UNSIGNED NOT NULL,
  `responsiveness` int(10) UNSIGNED NOT NULL,
  `assurance_integrity` int(10) DEFAULT NULL,
  `access_facility` int(10) DEFAULT NULL,
  `quality_remark` text DEFAULT NULL,
  `responsiveness_remark` text DEFAULT NULL,
  `integrity_remark` text DEFAULT NULL,
  `timeliness_remark` text DEFAULT NULL,
  `access_remark` text DEFAULT NULL,
  `evaluation_subject` text DEFAULT NULL,
  `evaluation_body` text DEFAULT NULL,
  `overall_rating` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_request`
--

INSERT INTO `evaluation_request` (`id`, `evaluator_emp_id`, `request_id`, `outcome`, `realiability_quality`, `responsiveness`, `assurance_integrity`, `access_facility`, `quality_remark`, `responsiveness_remark`, `integrity_remark`, `timeliness_remark`, `access_remark`, `evaluation_subject`, `evaluation_body`, `overall_rating`, `created_at`, `updated_at`) VALUES
(6787, '23-0920', 7381, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, NULL, '2025-05-13 06:28:32', NULL),
(6788, '23-0920', 7351, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, NULL, '2025-05-13 06:29:40', NULL),
(6789, '23-0920', 7384, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, NULL, '2025-05-13 06:30:22', NULL),
(6792, '23-0001', 48, 5, 5, 4, 3, 2, 'dasdawda', 'dasdawda', 'dsdawda', 'dasdawda', 'sdawdadwawd', 'dasdawd', 'dasdawda', 76.00, '2025-05-15 03:59:20', '2025-05-15 03:59:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluation_request`
--
ALTER TABLE `evaluation_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_request_request_id_foreign` (`request_id`),
  ADD KEY `evaluation_request_timeliness_foreign` (`outcome`),
  ADD KEY `evaluation_request_service_quality_foreign` (`realiability_quality`),
  ADD KEY `evaluation_request_service_courtesy_foreign` (`responsiveness`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation_request`
--
ALTER TABLE `evaluation_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6793;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
