-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 03:43 AM
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
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_ratings`
--

CREATE TABLE `evaluation_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `evaluation_id` int(10) UNSIGNED NOT NULL,
  `overall_rating` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_ratings`
--

INSERT INTO `evaluation_ratings` (`id`, `evaluation_id`, `overall_rating`, `created_at`, `updated_at`) VALUES
(1, 6799, 88.00, '2025-05-17 02:39:53', '2025-05-17 02:39:53'),
(2, 6792, 76.00, '2025-05-15 03:59:20', '2025-05-15 03:59:20'),
(3, 6793, 96.00, '2025-05-16 05:27:41', '2025-05-16 05:27:41'),
(4, 6794, 92.00, '2025-05-16 05:28:33', '2025-05-16 05:28:33'),
(5, 6795, 96.00, '2025-05-16 05:30:22', '2025-05-16 05:30:22'),
(6, 6796, 68.00, '2025-05-16 05:40:18', '2025-05-16 05:40:18'),
(7, 6797, 72.00, '2025-05-16 05:42:32', '2025-05-16 05:42:32'),
(8, 6798, 80.00, '2025-05-16 06:17:56', '2025-05-16 06:17:56'),
(9, 6800, 72.00, '2025-05-17 12:12:09', '2025-05-17 12:12:09'),
(10, 6801, 72.00, '2025-05-17 12:12:57', '2025-05-17 12:12:57'),
(11, 6802, 92.00, '2025-05-17 12:13:51', '2025-05-17 12:13:51'),
(12, 6803, 92.00, '2025-05-20 04:04:36', '2025-05-20 04:04:36'),
(13, 6804, 100.00, '2025-05-21 06:03:01', '2025-05-21 06:03:01'),
(14, 6805, 92.00, '2025-05-21 06:58:03', '2025-05-21 06:58:03'),
(15, 6806, 100.00, '2025-05-28 16:08:49', '2025-05-28 16:08:49');

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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_request`
--

INSERT INTO `evaluation_request` (`id`, `evaluator_emp_id`, `request_id`, `outcome`, `realiability_quality`, `responsiveness`, `assurance_integrity`, `access_facility`, `quality_remark`, `responsiveness_remark`, `integrity_remark`, `timeliness_remark`, `access_remark`, `evaluation_subject`, `evaluation_body`, `created_at`, `updated_at`) VALUES
(6787, '23-0920', 7381, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, '2025-05-13 06:28:32', NULL),
(6788, '23-0920', 7351, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, '2025-05-13 06:29:40', NULL),
(6789, '23-0920', 7384, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, '2025-05-13 06:30:22', NULL),
(6792, '23-0001', 48, 5, 5, 4, 3, 2, 'dasdawda', 'dasdawda', 'dsdawda', 'dasdawda', 'sdawdadwawd', 'dasdawd', 'dasdawda', '2025-05-15 03:59:20', '2025-05-15 03:59:20'),
(6793, '23-0001', 49, 5, 4, 5, 5, 5, 'dawdaa', 'dasdawdad', 'dsadwada', 'dasdawdad', 'dsadwad', 'dasdawdda', 'ddawdadasd', '2025-05-16 05:27:41', '2025-05-16 05:27:41'),
(6794, '23-0001', 50, 4, 5, 5, 5, 4, 'fefee', 'fefee', 'fefefe', 'fefefe', 'fefe', 'dwadawd', 'fefefe', '2025-05-16 05:28:33', '2025-05-16 05:28:33'),
(6795, '23-0001', 47, 5, 5, 5, 5, 4, 'trewq', 'trew', 'trewq', 'trewq', 'trewq', 'qwerty', 'qwerty', '2025-05-16 05:30:22', '2025-05-16 05:30:22'),
(6796, '23-0001', 8, 5, 4, 2, 2, 4, NULL, '123456', 'fdfefsefsf', 'qeeafsef', 'fsdfwfef', 'cctv repair', 'dawdad', '2025-05-16 05:40:18', '2025-05-16 05:40:18'),
(6797, '23-0001', 43, 3, 5, 3, 2, 5, 'yuyuyuyu', 'uyuyuyuyu', 'uyuyuyuy', 'uyuyuyuy', 'uyuyuy', 'dasdawd', 'yuyuyuy', '2025-05-16 05:42:32', '2025-05-16 05:42:32'),
(6798, '23-0001', 59, 5, 5, 4, 3, 3, 'dedaeda', 'daedaeda', 'dadawdada', 'dawdada', 'dsadawda', 'device repair', 'repair', '2025-05-16 06:17:56', '2025-05-16 06:17:56'),
(6799, '23-0001', 45, 5, 5, 3, 5, 4, 'dsadwad', 'dsawda', 'dsadwad', 'dsadwada', 'dsawdada', 'dasdaw', 'dsawdad', '2025-05-17 02:39:53', '2025-05-17 02:39:53'),
(6800, '23-0001', 1, 3, 4, 5, 3, 3, 'sdawda', 'dsdawda', 'dadadd', 'dsadawd', 'dsdawdd', 'awdawd', 'sdawdadwa', '2025-05-17 12:12:09', '2025-05-17 12:12:09'),
(6801, '23-0001', 41, 5, 5, 5, 2, 1, 'sdawd', 'sdawda', 'dsadwd', 'sdawdada', 'dsdadw', 'sdada', 'sdwadw', '2025-05-17 12:12:57', '2025-05-17 12:12:57'),
(6802, '23-0001', 42, 5, 3, 5, 5, 5, 'qwertyuiop', 'qwertyuiop', 'qwertyuiop', 'qwertyuiop', 'qwertyuiop', 'qwertyup', 'qwertyuiop', '2025-05-17 12:13:51', '2025-05-17 12:13:51'),
(6803, '23-0001', 95, 4, 5, 4, 5, 5, 'hhhh', 'hhh', 'hhhh', 'hhh', 'hhhhh', 'jnj', 'hh', '2025-05-20 04:04:36', '2025-05-20 04:04:36'),
(6804, '23-0001', 99, 5, 5, 5, 5, 5, 'as', 's', 's', 's', 'sss', 's', 's', '2025-05-21 06:03:01', '2025-05-21 06:03:01'),
(6805, '23-0001', 103, 4, 5, 4, 5, 5, 'scdad', 'sczsz', 'xczsczcc', 'cszczsc', 'xczscc', 'werty', 'qwertyu', '2025-05-21 06:58:03', '2025-05-21 06:58:03'),
(6806, '23-0001', 107, 5, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, 'Evaluated using New CSS', NULL, '2025-05-28 16:08:49', '2025-05-28 16:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_actions_taken`
--

CREATE TABLE `lib_actions_taken` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_name` varchar(191) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_abbr` varchar(191) NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_actions_taken`
--

INSERT INTO `lib_actions_taken` (`id`, `action_name`, `category_id`, `action_abbr`, `is_archived`) VALUES
(3, 'Clean the Terminals', NULL, 'CleanTerm', 1),
(5, 'Rejoin the Computer to Domain.', NULL, 'RCD', 0),
(6, 'Set-up Video Conference Equipments on the Facility and Assisted them on the Video Conference Activity', NULL, 'VCon', 0),
(7, 'Installed the driver software', NULL, 'IDS', 0),
(8, 'Performed test print', NULL, 'PTP', 0),
(9, 'Coordinated with Network Administrator for granting of access on YT and FB', NULL, 'GA', 0),
(10, 'Dismantle the system unit', NULL, 'DSU', 0),
(11, 'Removed the jammed paper', NULL, 'RJP', 0),
(12, 'Replaced the RJ Connector', NULL, 'RRC', 0),
(13, 'Installed the horizontal/backbone cable', NULL, 'IHB', 0),
(14, 'Tranferred the terminal connection/s', NULL, 'TTC', 0),
(15, 'Installed the telephone unit', NULL, 'ITU', 0),
(16, 'Restored the mechanism (gear, roller, belt, etc.) to its original position', NULL, 'RMP', 0),
(17, 'Replaced the network switch', NULL, 'RNS', 0),
(18, 'Windows System Restore', NULL, 'WinRes', 0),
(19, 'Re-Image', NULL, 'RImg', 0),
(20, 'Spring Clean', NULL, 'SprCln', 0),
(21, 'Reformat', NULL, 'RFMT', 0),
(22, 'Update Software', NULL, 'UpSfwr', 0),
(23, 'Software Driver Signing', NULL, 'SoftDrSng', 0),
(24, 'Uninstall Unncessary Software', NULL, 'UnUS', 0),
(25, 'Use System Software Repair', NULL, 'SftRpr', 0),
(26, 'Other', NULL, 'Other', 0),
(27, 'Disassemble and Assemble Replace Power Supply / RAM / HDD', NULL, 'DARPS', 0),
(28, 'Re-terminate / Re-wiring / Driver Signing', NULL, 'ReTWDS', 0),
(29, 'Disassemble and Assemble Replace Casing Fans / CPU Fan', NULL, 'RepCF', 0),
(30, 'Replace Cables', NULL, 'RepCbl', 0),
(31, 'Disassemble and Assemble Replace Video Card', NULL, 'RplceVC', 0),
(32, 'Disassemble and Assemble Remove and Clean the Dust and Dirt', NULL, 'RemC&D', 0),
(33, 'Installed Network Switch', NULL, 'INS', 0),
(34, 'Installed WiFi Access Points', NULL, 'IWAP', 0),
(35, 'Windows System Restore', NULL, '13-0214', 0),
(36, 'Re-image', NULL, '13-0214', 0),
(37, 'Spring Clean', NULL, '13-0214', 0),
(38, 'Reformat', NULL, '13-0214', 0),
(39, 'Update software', NULL, '13-0214', 0),
(40, 'Software driver signing', NULL, '13-0214', 0),
(41, 'Uninstall unncessary software', NULL, '13-0214', 0),
(42, 'Use system software repair', NULL, '13-0214', 0),
(43, 'Disassemble and Assemble replace power supply / ram / hdd', NULL, '13-0214', 0),
(44, 'Disassembled and Assembled replaced power supply / ram / hdd', NULL, '13-0214', 0),
(45, 'Disassembled and Assembled replaced ram', NULL, '13-0214', 0),
(46, 'Re-terminated / re-wiring / driver Signing', NULL, '13-0214', 0),
(47, 'Disassembled and Assembled replaced casing fans / CPU Fan', NULL, '13-0214', 0),
(48, 'Replaced the battery', NULL, 'RTB', 0),
(49, 'Disassembled and Assembled Replaced power supply fan', NULL, '13-0214', 0),
(50, 'Disassembled and Assembled replaced cpu fan', NULL, '13-0214', 0),
(51, 'Replaced Cables', NULL, '13-0214', 0),
(52, 'Disassembled and Assembled replace video card', NULL, '13-0214', 0),
(53, 'Disassembled and Assembled replace hard disk drive', NULL, '13-0214', 0),
(54, 'Disassembled and Assembled remove and clean the dust and dirt', NULL, '13-0214', 0),
(55, 'Other please specify', NULL, '13-0214', 0),
(56, 'Reinstalled driver software / Replace Usb Cable', NULL, '13-0214', 0),
(57, 'Refilled ink tank', NULL, '13-0214', 0),
(58, 'Disassembled and Assembled remove the paper jam', NULL, '13-0214', 0),
(59, 'Re-configured the printer software drivers.', NULL, '13-0214', 0),
(60, 'Cleaned the printer nozzle ink', NULL, '13-0214', 0),
(61, 'Cleaned the printer head', NULL, '13-0214', 0),
(62, 'Re flushed the printer', NULL, '13-0214', 0),
(63, 'Outsourced the printer resetter and adjust the printer firmware', NULL, '13-0214', 0),
(64, 'Downloaded the software driver, unbox the printer, remove the protective tape.', NULL, '13-0214', 0),
(65, 'Other please specify', NULL, '13-0214', 0),
(66, 'Reported to PLDT costumer service', NULL, 'RCS', 0),
(67, 'Disassembled and Assembled for data recovery use outsource recovery software', NULL, '13-0214', 0),
(68, 'Disassembled and Assembled replace enclosure', NULL, '13-0214', 0),
(69, 'Recovered data', NULL, '13-0214', 0),
(70, 'Charged the battery', NULL, 'CTB', 0),
(71, 'No Dial Tone', NULL, 'NDT', 0),
(72, 'Joined to domain account', NULL, '13-0214', 0),
(73, 'Added user account.', NULL, '13-0214', 0),
(74, 'Configured user account.', NULL, '13-0214', 0),
(75, 'Replaced the Defective Parts/component', NULL, 'RDPC', 0),
(76, 'Disassembled and assembled Check the Main board/parts', NULL, 'DCMP', 0),
(77, 'Replaced the biometric machine', NULL, 'RBM', 0),
(78, 'Inspected', NULL, 'INS', 0),
(79, 'Replaced/installed the RJ11 connector/s', NULL, 'RIC', 0),
(80, 'Disassembled and Assembled the unit. Pulled out the hard disk drive. Copied and transferred the data to external drive.', NULL, 'CT', 0),
(81, 'Replaced the network switch', NULL, 'RNS', 0),
(82, 'Installed the RJ connector/s', NULL, 'IRJ', 0),
(83, 'Update Contact Information on the Network Scanner Configuration', NULL, 'UpdNSC', 0),
(84, 'Installed the biometric machine', NULL, 'IBM', 0),
(85, 'Deployed the LAN cable/s', NULL, 'DLC', 0),
(86, 'Optimized and Checkdisk', NULL, 'OC', 0),
(87, 'Defragmented', NULL, 'DF', 0),
(88, 'Replace CMOS battery', NULL, 'RB', 0),
(89, 'Reset CMOS battery', NULL, 'RSB', 0),
(90, 'Updated the software', NULL, 'US', 0),
(91, 'Created a System Image', NULL, 'CSI', 0),
(92, 'Re-Install MS Office and Recover Licence Key for Activation', NULL, 'RMS', 0),
(93, 'Reset his/her password on his/her computer', NULL, 'RTP', 0),
(94, 'Disassembled and Assembled enclosure and remove hard disk drive.', NULL, 'ER', 0),
(95, 'Data Recovery', NULL, 'DR', 0),
(96, 'Data Backup', NULL, 'DB', 0),
(97, 'Deployed/installed the LAN cable', NULL, 'DIL', 0),
(98, 'Outsourced the adjustment software.', NULL, 'OAS', 0),
(99, 'Resetted the printer and Run test print.', NULL, 'RPR', 0),
(100, 'Setup the system unit', NULL, 'SSU', 0),
(101, 'Checked the Battery', NULL, 'CTB', 0),
(102, 'Checked the I/O Voltage', NULL, 'CIO', 0),
(103, 'Replace new harddisk drive', NULL, 'RNHDD', 0),
(104, 'Replaced new hard disk drive.', NULL, 'RNHDD', 0),
(105, 'Setup and installed license microsoft windows and office.', NULL, 'SIMWO', 0),
(106, 'Re-mounted and Re-aligned the power cord.', NULL, 'RMAP', 0),
(107, 'Service required of authorized service center', NULL, 'SC', 0),
(108, 'for condem and disposal', NULL, 'CD', 0),
(109, 'Initiated Power Cycle of Network Equipment', NULL, 'IPC', 0),
(110, 'Replaced the Main Board', NULL, 'RMB', 0),
(111, 'Provided online technical support. Advice to wait and relax during windows updating. Restart and reset the computer solved the problem.', NULL, 'TS', 0),
(112, 'Replaced Ink Cardtridge', NULL, 'RIC', 0),
(113, 'Aligned the printer head', NULL, 'APH', 0),
(114, 'Disassembled and Assembled the printer unit. Cleaned and removed the unnecessary object.', NULL, 'DACR', 0),
(115, 'Installed the network Switch', NULL, 'INS', 0),
(116, 'Cleaned the Printer Head and Re-flushed the ink.', NULL, 'CPHR', 0),
(117, 'Authorized Service Center Required', NULL, 'ASCR', 0),
(118, 'Terminate/crimped/splice the wiring connections', NULL, 'TCS', 0),
(119, 'Usb drive Windows 8 not functioning while booting.', NULL, 'USBB', 0),
(120, 'For Data Backup and System unit is for disposal.', NULL, 'DBSD', 0),
(121, 'Provide technical support. The unit is for disposal.', NULL, 'PTS', 0),
(122, 'Dismantled the printer unit. The paper pick roller is faulty.', NULL, 'DPU', 0),
(123, 'Under Warranty', NULL, 'UW', 0),
(124, 'Reformatted the hard disk drive. Setup and installed the Windows genuine software.', NULL, 'RHS', 0),
(125, 'Downloaded the driver software. Setup and installed software driver.', NULL, 'DDSI', 0),
(126, 'Re-mounted the memory (RAM)', NULL, 'RMM', 0),
(127, 'for condemn', NULL, 'FC', 0),
(128, 'Assembled/crimped LAN cable/s', NULL, 'ALC', 0),
(129, 'Under Warranty', NULL, 'UW', 0),
(130, 'Resoldered/reheat/reseat the IC\'s', NULL, 'RRR', 0),
(131, 'Organized the cables and fixtures', NULL, 'OCF', 0),
(132, 'Provided technical support thru phone. Restart the computer unit.', NULL, 'PTS', 0),
(133, 'Pulled out the hard disk drive. Used the hard drive station. The harddrive is unreadable.', NULL, 'DIY', 0),
(134, 'Download the wifi software drivers. Reinstalled the wifi drivers.', NULL, 'WIFIR', 0),
(135, 'Checked and diagnosed the power supply. For the assistance of authorized center.', NULL, 'FAC', 0),
(136, 'Setup and installed software', NULL, 'sis', 0),
(137, 'Setup and installed', NULL, 'SI', 0),
(138, 'Installed the wiring (UTP, backbone, horizontal, and power cables)', NULL, 'IUBHP', 0),
(139, 'Scan and Removed the malware', NULL, 'SR', 0),
(140, 'Re-partition the Hard disk drive', NULL, 'RPDD', 0),
(141, 'Installed the conduits (mouldings, race ways, pipes, etc.) and cable organizer', NULL, 'CCO', 0),
(142, 'Installed the network/data rack', NULL, 'NDR', 0),
(143, 'Installed the Patch Panel/s', NULL, 'IPP', 0),
(144, 'Diagnosed', NULL, '13-0506', 0),
(145, 'Replaced the defective parts', NULL, 'RDP', 0),
(146, 'Repaired', NULL, 'REP', 0),
(147, 'Configured user account, network address, clone OS, partition the hard disk, join domain server.', NULL, 'CUA', 0),
(148, 'Desktop unit without bundled of genuine microsoft office.', NULL, 'NLO', 0),
(149, 'Thermal consumable applicable in the unit.', NULL, 'THC', 0),
(150, 'Accessed the PDC server. Reset the password to default', NULL, 'RESET', 0),
(151, 'Setup and installed the CoreMIS System', NULL, 'CMIS', 0),
(152, 'Removed the malware and Fixed the disk.', NULL, 'RMF', 0),
(153, 'Transferred the port assignment', NULL, 'TPA', 0),
(154, 'Setup and installed core mis application', NULL, 'SICMIS', 0),
(155, 'Downloaded the driver software. Setup and installed the driver.', NULL, 'SITD', 0),
(156, 'Set-up LED Wall and Videowall Controller for Social Hall Activities', NULL, 'SULWVC', 0),
(157, 'Install Sophos Certificate', NULL, 'ISC', 0),
(158, 'Pro active maintenance', NULL, 'PAM', 0),
(159, 'Upgrading, configuring OS and joining, adding user account.', NULL, 'UCOS', 0),
(160, 'Downloaded the software driver. Setting up the printer. Added to pdc server. Setup network printers in clients workstation', NULL, 'DSA', 0),
(161, 'Accessed through remote desktop connection the workstation, copied software drivers, setup and installed software. Setting up FMIS and spring clean.', NULL, 'ALLREMOTE', 0),
(162, 'Restart the PABX', NULL, '13-0506', 0),
(163, 'Restart the UPS/power cycle', NULL, 'UPS', 0),
(164, 'Put account in maintenance', NULL, 'email', 0),
(165, 'Segment of Interest Archived', NULL, 'SIA', 0),
(166, 'e-Copy Provided', NULL, 'ECP', 0),
(167, 'Cancelled by the End-user', NULL, '13-0506', 0),
(168, 'Cancelled by the Requisitioner', NULL, 'CBR', 0),
(169, 'Backup data', NULL, 'BD', 0),
(170, 'Used remote desktop and setting up printers and applications', NULL, 'URD', 0),
(171, 'Accessed the PDC Server, configured and transferred  the client network address.', NULL, 'PDC', 0),
(172, 'The unit is for disposal.', NULL, 'TUD', 0),
(173, 'Activated the zoom license', NULL, '13-0506', 0),
(174, 'Provide Web Cam', NULL, 'WBC', 0),
(175, 'Re-install LAN MEssenger', NULL, 'RLM', 0),
(176, 'Setup the LED Wall and peripherals (video processor, computer, power requirement, etc.)', NULL, 'SLW', 0),
(177, 'Live Streamed to FB, YT, etc.', NULL, 'LST', 0),
(178, 'Fixed the cables and fixtures', NULL, 'FCF', 0),
(179, 'Reset the Login Password', NULL, 'RLP', 0),
(180, 'Checked the CCTV camera/s', NULL, 'CCC', 0),
(181, 'Checked the NVR', NULL, 'CTN', 0),
(182, 'Others', NULL, 'OTH', 0),
(183, 'Create Account', NULL, 'CRA', 0),
(184, 'Deploy backbone cable', NULL, 'DBC', 0),
(185, 'Register To Domain/Assign IP Address', NULL, 'RDI', 0),
(186, 'Download/Install LAN messenger app', NULL, 'DILM', 0),
(187, 'Transferred the telephone line', NULL, 'TTL', 0),
(188, 'Transferred The Telephone Line', NULL, 'TTL', 0),
(189, 'Transferred The Telephone Line/Unit', NULL, 'TTLU', 0),
(190, 'Transferred The Telephone Line/Unit', NULL, 'TTLU', 0),
(191, 'Reset Password', NULL, 'REP', 0),
(192, 'Checked queries', NULL, 'CHKQRS', 0),
(193, 'Created Account', NULL, 'CRTDACC', 0),
(194, 'Replaced QR code of room', NULL, 'REPQRR', 0),
(195, 'Created QR code of room', NULL, 'CQRCR', 0),
(196, 'Server restart', NULL, 'SRVRS', 0),
(197, 'Updated app to latest version', NULL, 'UPDAP', 0),
(198, 'NONE', NULL, 'NONE', 0),
(199, 'Installed the Biometric Machine and Accessories', NULL, 'IBMA', 0),
(200, 'Updated contact number', NULL, 'UPDCTN', 0),
(201, 'Uninstall Software', NULL, '13-0506', 0),
(202, 'SSD', NULL, 'Replaced SSD', 0),
(203, 'Installed/Setup Internet Access (WiFi Router/AP and/or LAN Connection))', NULL, 'ISIA', 0),
(204, 'Setup TV monitor/Projector', NULL, 'STVP', 0),
(205, 'Defective Battery', NULL, 'DBAT', 0),
(206, 'Reseat the Cable/Connector', NULL, 'RCC', 0),
(207, 'Dismantling and Assembling the Scanner', NULL, 'DAS', 0),
(208, 'Activated the Zoom License', NULL, 'AZL', 0),
(209, 'Created the zoom account and added to PhilRice Zoom accounts', NULL, 'CAPZA', 0),
(210, 'Created/scheduled a meeting', NULL, 'CSM', 0),
(211, 'Renamed the computer', NULL, 'RTC', 0),
(212, 'Create zoom link for the activity and send to the client', NULL, 'CAC', 0),
(213, 'Setup WiFi Router/Access Point', NULL, 'SWRAP', 0),
(214, 'Assemble, Deploy and connect the LAN cable for the network printer.', NULL, 'ADCP', 0),
(215, 'Check the printer NIC', NULL, 'CPN', 0),
(216, 'Door Lock Register Admin and User', NULL, 'DLRAU', 0),
(217, 'Unboxed and Installed the Telephone Unit/s', NULL, 'UIT', 0),
(218, 'Check the power source', NULL, 'CPS', 0),
(219, 'Perform power cycle', NULL, 'PPCY', 0),
(220, 'Extracted and installed the certificate', NULL, 'EIC', 0),
(221, 'Installed addtional HDD/SSD', NULL, 'IAHDD/SSD', 0),
(222, 'Clean of the Class for Scanner', NULL, 'COCS', 0),
(223, 'Clean the Glass of the Scanner', NULL, 'COCS', 0),
(224, 'Connect to shared Printer', NULL, 'CSP', 0),
(225, 'Installed the Operating System', NULL, 'IOS', 0),
(226, 'Installed the Productivity Software/s', NULL, 'IPSs', 0),
(227, 'Registerred the computer to the local domain', NULL, 'RCLD', 0),
(228, 'Renamed the computer/s', NULL, 'RTC', 0),
(229, 'Replaced the Power Supply Unit (PSU)', NULL, 'RPSU', 0),
(230, 'Setup the LED wall', NULL, 'STLW', 0),
(231, 'Reset Spooler', NULL, 'RSE', 0),
(232, 'Renamed the computer', NULL, 'RTC', 0),
(233, 'Added local administrator account', NULL, 'ALAA', 0),
(234, 'Downloaded and installed the driver/software', NULL, 'DIDS', 0),
(235, 'Repaired', NULL, 'REP', 0),
(236, 'Check the Video Output and Cable Needed', NULL, 'CVOC', 0),
(237, 'Installed the Additional Monitor', NULL, 'IAM', 0),
(238, 'Re-installed the messenger app', NULL, 'RMA', 0),
(239, 'Repaired the power adapter/PSU', NULL, 'RPAPSU', 0),
(240, 'Registration of fingerprint/face ID completed', NULL, 'RFIDC', 0),
(241, 'Configured the CCTV camera/assign IP address', NULL, 'CCCIP', 0),
(242, 'Sync the DTR Logs', NULL, 'SDTRL', 0),
(243, 'Initialized the waste inkpad counter', NULL, 'IWC', 0),
(244, 'Performed Head Cleaning and Power Ink Flushing', NULL, 'PCPF', 0),
(245, 'Setup the UPS', NULL, 'SUPS', 0),
(246, 'Plugged to AC Source & Initiated UPS Initial Charging', NULL, 'UPSIC', 0),
(247, 'Renumebered the Local Lines', NULL, 'RLL', 0),
(248, 'Installed the Door Access Control System (DACS)', NULL, 'DACS', 0),
(249, 'Clean the terminal and Reseat the RAM', NULL, 'CTRR', 0),
(250, 'Synched the System time to PST', NULL, 'SPST', 0),
(251, 'Installed additional RAM', NULL, 'IAR', 0),
(252, 'Installed the battery', NULL, 'ITB', 0),
(253, 'Restore Account after Maintenance Mode', NULL, 'ZMMR', 0),
(254, 'Updated the Operating System (OS) to the newest available Version', NULL, 'UOS', 0),
(255, 'Activate the Sophos VPN Connect account', NULL, 'ASVCA', 0),
(256, 'Reseat the LAN cable', NULL, 'RLC', 0),
(257, 'Setup the computer/s (Desktop/Laptop)', NULL, 'SCDL', 0),
(258, 'Get transaction to biometrics for logs', NULL, 'GTBL', 0),
(259, 'Reported the problem to the Internet Service Provider', NULL, 'RPISP', 0),
(260, 'Configured the network equipment/device (switch, router, access point).', NULL, 'CNSRAP', 0),
(261, 'Posting of rice S&T promotions, banners, posters, congratulatory messages, other non-rice monthly observances, and other announcements.', NULL, 'PSTOA', 0),
(262, 'License not available', NULL, 'LNA', 0),
(263, 'Videoconferencing equipment is/are not available and/or deployed.', NULL, 'VCNA', 0),
(264, 'Replaced the RJ11 cable', NULL, 'RRC', 0),
(265, 'Synched Biometric Data to Other Terminal(s)', NULL, 'SBDTO', 0),
(266, 'Registered the network printer/Assigned IP address', NULL, 'RPAIA', 0),
(267, 'Update Display Name', NULL, 'UDN', 0),
(268, 'Reseat/resolder the CMOS IC', NULL, 'RRCIC', 0),
(269, 'Replaced the defective part(s)', NULL, 'RDP', 0),
(270, 'Updated the OS to the lates available version', NULL, 'UPOS', 0),
(271, 'Reset Password on Zimbra Email', NULL, 'RPZ', 0),
(272, 'fix my desktop', 7, 'FixDesktop', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lib_approvers`
--

CREATE TABLE `lib_approvers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_approvers`
--

INSERT INTO `lib_approvers` (`id`, `name`, `position`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'John Vincent', NULL, NULL, 1, '2025-05-14 02:18:16', '2025-05-14 02:18:16'),
(2, 'Zeckiel Peralta', NULL, NULL, 1, '2025-05-14 02:19:10', '2025-05-14 02:19:10'),
(3, 'echo sottp', NULL, NULL, 1, '2025-05-14 02:20:04', '2025-05-14 02:20:04'),
(4, 'Qwerty Wasd', NULL, NULL, 1, '2025-05-14 02:50:45', '2025-05-14 02:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `lib_categories`
--

CREATE TABLE `lib_categories` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_abbr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lib_categories`
--

INSERT INTO `lib_categories` (`id`, `category_name`, `category_abbr`) VALUES
(1, 'Account-Related Services', 'ARS'),
(2, 'Biometric-Related Services', 'BRS'),
(3, 'Computer-Related Services', 'CRS'),
(4, 'CoreMS & Other Systems', 'CMS'),
(5, 'CCTV-Related Services', 'CCTV'),
(6, 'Printer-Related Services', 'PRS'),
(7, 'Device & Electronic Repair', 'DER'),
(8, 'Network-Related Services', 'NRS'),
(9, 'Software-Related Services', 'SRS'),
(10, 'Telephone-Related Services', 'TRS'),
(11, 'Event Related Services', 'ERS');

-- --------------------------------------------------------

--
-- Table structure for table `lib_common_problems`
--

CREATE TABLE `lib_common_problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `problem_name` varchar(191) NOT NULL,
  `problem_abbr` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_common_problems`
--

INSERT INTO `lib_common_problems` (`id`, `problem_name`, `problem_abbr`) VALUES
(10, 'Noisy/Static Line', 'NL'),
(11, 'Party Line Installation', 'PLI'),
(12, 'Busy-Line Always', 'BLA'),
(13, 'Can\'t Receive Call', 'CRC'),
(14, 'Relocation', 'Rel'),
(15, 'No Internet Connection/Access', 'NICA'),
(16, 'Limited Access', 'LA'),
(17, 'Slow Internet', 'SI'),
(18, 'Change Username', 'CU'),
(19, 'Installation of Network Printer', 'INP'),
(20, 'Internet Access (meetings, conferences, etc)', 'SPReq'),
(21, 'No Power', 'NoPow'),
(22, 'Not Functioning', 'NF'),
(23, 'Malfunction', 'MalF'),
(24, 'Review', 'REV'),
(25, 'Monitor Repair', 'MRep'),
(26, 'System Unit Repair', 'SURep'),
(27, 'Installation of New Software', 'InsNS'),
(28, 'Recover Lost/Deleted Data', 'RecLD'),
(29, 'Video Conference Assistance', 'VCAsst'),
(30, 'Boot loop', 'BL'),
(31, 'Installation of Printer Driver', 'IPD'),
(32, 'Locked-out', 'LOT'),
(34, 'Installation of Printer', 'IOP'),
(35, 'No Dial Tone', 'NDT'),
(36, 'Out of Ink', 'NoInk'),
(37, 'Paper Jam', 'PJam'),
(38, 'Dirty Print', 'DPrt'),
(39, 'Blank Screen', 'BlScrn'),
(40, 'Keyboard/Mouse Mulfunction', 'KMMal'),
(41, 'Faulty LCD Monitor Black Screen', 'FtyMtr'),
(42, 'Beep Sound', 'BpSnd'),
(43, 'Noisy Sound', 'NsySnd'),
(44, 'Overheating', 'OvHtng'),
(45, 'Other, (Please Specify)', 'Other'),
(46, 'Blue Screen of Death', 'BSDeath'),
(48, 'Malware (Malicious Software)', 'MalWare'),
(49, 'Frozen Screen', 'FrzScrn'),
(50, 'Can\'t Install Application', 'CinsApp'),
(51, 'Missing DLL Files', 'MsDLLF'),
(52, 'Unreadable', 'URd'),
(53, 'Loose Cable', 'LsCab'),
(54, 'USB Port Issues', 'PrtIs'),
(55, 'Continous Beep Sound', 'CBS'),
(56, 'UPS Repair', 'UPS'),
(58, 'Telephone Unit Repair', 'TUP'),
(59, 'Fax Machine Repair', 'FMR'),
(61, 'Power Adapter Repair', 'PAR'),
(62, 'Biometric Machine Repair', 'BMR'),
(63, 'Relocate wiring due to office rearrangement', 'ROR'),
(64, 'Relocate wiring due to office renovation', 'RDR'),
(65, 'Network Scanning', 'NC'),
(66, 'Microsoft Office Error(MS Office Needs Activation)', 'MOE'),
(68, 'Can\'t login to computer', 'cltc'),
(69, 'The user forgot his/her password', 'ufp'),
(70, 'Digital Camera Repair', 'DCR'),
(71, 'Tablet/Smart/Cell phone repair', 'TSC'),
(72, 'LAN cable installation', 'LCI'),
(73, 'FMIS-Related', 'FMIS'),
(74, 'CoreMIS - FMIS Problem', 'FMIS'),
(75, 'Computer (Desktop)', 'COMD'),
(76, 'Computer (Laptop)', 'COML'),
(77, 'UPS', 'UPS'),
(78, 'Printer', 'PRIN'),
(79, 'Mobile Phone/Cellphone', 'MPC'),
(80, 'Speaker', 'SPKR'),
(81, 'Telephone', 'TEL'),
(82, 'Tel/Fax', 'TFAX'),
(83, 'Tablet', 'TBT'),
(84, 'Scanner', 'SCNR'),
(85, 'Keyboard', 'KEB'),
(86, 'Mouse', 'MSE'),
(87, 'Monitor', 'MTR'),
(88, 'Installation of New/Additional CCTV camera/s', 'INCCTV'),
(89, 'Installation of LAN and Telephone lines', 'ILT'),
(90, 'Windows OS Not Updating', 'WNUp'),
(91, 'Pre repair', 'PRI'),
(92, 'Barcode Printer', 'BPR'),
(93, 'Can\'t login to workstation', 'CLW'),
(94, 'CoreMIS', 'CMIS'),
(95, 'Rewiring of LAN and Telephone lines', 'RLT'),
(97, 'No Call Forwarding', 'NCF'),
(98, 'Core MIS', 'CMIS'),
(99, 'Set-Up', 'SU'),
(100, 'LED Wall Set-up for Social Hall Activity', 'LWSUA'),
(101, 'LED Wall Set-up for Tollgate Activity', 'LWSTA'),
(103, 'Upgrading Operating System', 'UOS'),
(104, 'Re-Activation of telephone line', 'RAT'),
(105, 'UPS Failure', 'UPS'),
(106, 'Activation of zoom license', 'ACT'),
(107, 'LAN Messenger Problem', 'LMGR'),
(108, 'LED Wall Setup (Outdoor)', 'LWO'),
(109, 'LED Wall Setup (Indoor/Mobile)', 'LWIM'),
(110, 'Live stream to FB, YT, etc.', 'LST'),
(111, 'Creation of Intranet Account', 'CIA'),
(112, 'New Telephone Line', 'NTL'),
(113, 'HRIS Related', 'HRIS'),
(114, 'Creation of Zimbra Account', 'CZA'),
(115, 'Creation of Local Account', 'CLA'),
(116, 'Not Registered to Domain Network', 'NRD'),
(117, 'Others IT/Electronic Equipment', 'OIE'),
(118, 'Installation of LAN Messenger', 'ILM'),
(119, 'PDTS Account Creation', 'PAC'),
(120, 'Creation Of Intranet Account', 'CIA'),
(121, 'PSIS-Related', 'PSISR'),
(122, 'Contact Tracing System Related', 'CTSR'),
(124, 'Installation Of Biometric Attendance (Face ID/Fingerprint)', 'IBA'),
(126, 'Installation of Biometrci Door Lock System', 'IBDLS'),
(127, 'Request for WiFi Connection', 'RWC'),
(128, 'Request for LAN Connection', 'RLC'),
(129, 'PDTS Related', 'PDTS'),
(130, 'Request for License', 'RFL'),
(131, 'Request for Zoom Account', 'RZA'),
(132, 'Creation of email account', 'CEA'),
(133, 'CCTV Repair', 'CCTR'),
(134, 'New Computers (Desktop/Laptop)', 'NCDL'),
(135, 'Renaming of Computer/s', 'ROFC'),
(136, 'Setup of Audio/Video Equipment', 'SAVE'),
(137, 'Setup of TV Monitor/Projector', 'STMP'),
(138, 'No driver/software installed', 'NSI'),
(139, 'Installation of new telephone unit/s', 'INTU'),
(140, 'Installation of Additional Monitor', 'IAM'),
(142, 'Zimbra - Maintenance Mode', 'ZMM1'),
(143, 'VACA', 'VPN Account Creation/Activation'),
(144, 'Creation/Activation of VPN Account (Sophos Connect)', 'VACA1'),
(145, 'Printer Repair', 'PRP'),
(146, 'Scanner Repair', 'SCR'),
(147, 'Backup Files', 'BKF'),
(148, 'DATA Recovery', 'DARE');

-- --------------------------------------------------------

--
-- Table structure for table `lib_contact_types`
--

CREATE TABLE `lib_contact_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_type_name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_contact_types`
--

INSERT INTO `lib_contact_types` (`id`, `contact_type_name`) VALUES
(1, 'Official'),
(2, 'Personal'),
(3, 'Local');

-- --------------------------------------------------------

--
-- Table structure for table `lib_expertise`
--

CREATE TABLE `lib_expertise` (
  `id` int(11) NOT NULL,
  `user_idno` char(7) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'Legebds \r\n1- Active\r\n0- not active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lib_expertise`
--

INSERT INTO `lib_expertise` (`id`, `user_idno`, `category_id`, `status`, `created_at`) VALUES
(1, '23-0001', 3, 1, '2025-02-11 02:25:55'),
(2, '23-0001', 18, 0, '2025-02-11 06:33:02'),
(3, '23-0001', 10, 0, '2025-02-11 06:39:05'),
(4, '23-0001', 20, 1, '2025-02-11 06:40:10'),
(5, '23-0001', 6, 1, '2025-02-11 06:43:09'),
(6, '23-0001', 1, 0, '2025-02-11 06:44:49'),
(7, '23-0001', 2, 1, '2025-02-11 06:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `lib_findings_recommendations`
--

CREATE TABLE `lib_findings_recommendations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incident_report_id` bigint(20) UNSIGNED NOT NULL,
  `findings` text NOT NULL,
  `recommendations` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_findings_recommendations`
--

INSERT INTO `lib_findings_recommendations` (`id`, `incident_report_id`, `findings`, `recommendations`, `created_at`, `updated_at`) VALUES
(1, 7, 'dawdawd', 'sdawdawd', '2025-05-14 02:36:22', '2025-05-14 02:36:22'),
(2, 5, 'iikikik', 'okikkikiik', '2025-05-14 02:52:22', '2025-05-14 02:52:22'),
(3, 6, 'g', 'g', '2025-05-18 19:27:54', '2025-05-18 19:27:54'),
(4, 15, 'y', 'g', '2025-05-18 19:28:27', '2025-05-18 19:28:27'),
(5, 12, 'g', 'f', '2025-05-18 19:35:43', '2025-05-18 19:35:43'),
(6, 11, 't', 'g', '2025-05-18 19:41:03', '2025-05-18 19:41:03'),
(7, 14, 'd', 'c', '2025-05-19 16:12:14', '2025-05-19 16:12:14'),
(8, 16, 'f', 'c', '2025-05-19 16:44:47', '2025-05-19 16:44:47'),
(9, 17, 'öá]éß', 'ä', '2025-05-20 17:06:26', '2025-05-20 17:06:26'),
(10, 18, 'þéßßßß', 'rrrrfr', '2025-05-20 17:06:44', '2025-05-20 17:06:44'),
(11, 26, 'r', 'x', '2025-05-20 19:34:10', '2025-05-20 19:34:10'),
(12, 27, 'xx', 'd', '2025-05-20 19:34:19', '2025-05-20 19:34:19'),
(13, 29, 'resolved', 'resolved', '2025-05-21 06:06:10', '2025-05-21 06:06:10'),
(14, 31, 'zecaeaedawfda', 'dasdawdawdawda', '2025-05-21 07:03:22', '2025-05-21 07:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `lib_incident_reports`
--

CREATE TABLE `lib_incident_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incident_nature` varchar(255) NOT NULL,
  `date_reported` datetime NOT NULL,
  `incident_name` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reporter_id` bigint(20) UNSIGNED NOT NULL,
  `reporter_name` varchar(255) NOT NULL,
  `reporter_position` varchar(255) DEFAULT NULL,
  `verifier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `verifier_name` varchar(255) DEFAULT NULL,
  `approver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approver_name` varchar(255) DEFAULT NULL,
  `priority_level` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Not Resolved',
  `incident_date` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `impact` varchar(255) DEFAULT NULL,
  `affected_areas` varchar(255) DEFAULT NULL,
  `findings` text DEFAULT NULL,
  `resolution` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_incident_reports`
--

INSERT INTO `lib_incident_reports` (`id`, `incident_nature`, `date_reported`, `incident_name`, `subject`, `description`, `reporter_id`, `reporter_name`, `reporter_position`, `verifier_id`, `verifier_name`, `approver_id`, `approver_name`, `priority_level`, `status`, `incident_date`, `location`, `impact`, `affected_areas`, `findings`, `resolution`, `created_at`, `updated_at`) VALUES
(1, 'Nawalan ng internet', '2025-04-14 04:15:47', 'Internet Down', 'Internet', 'There was no internet bigla', 23, 'John Doe', NULL, NULL, NULL, NULL, NULL, 'Normal', 'Resolved', '2025-04-12 13:49:00', 'PhilRice CES', 'cant access the internet', 'all offices', NULL, NULL, '2025-04-13 20:15:47', '2025-04-14 00:45:05'),
(2, 'n', '2025-04-14 05:10:26', 'test', 'f', 'a', 23, 'John Doe', NULL, NULL, NULL, NULL, NULL, 'High', 'Resolved', '2025-04-08 15:10:00', 'PhilRice CES', 'j                            j', 'j             j', NULL, NULL, '2025-04-13 21:10:26', '2025-04-14 00:47:44'),
(3, 'k', '2025-04-14 05:11:22', 'k', NULL, NULL, 23, 'John Doe', NULL, NULL, NULL, NULL, NULL, 'Low', 'Resolved', '2025-04-14 13:14:00', 'PhilRice Negros', NULL, NULL, NULL, NULL, '2025-04-13 21:11:22', '2025-04-14 01:52:53'),
(4, 'dasdwdawd', '2025-04-14 05:16:25', 'dada', 'dadad', 'awdawdawda', 23, 'John Doe', NULL, NULL, NULL, NULL, NULL, 'Low', 'Resolved', '2025-04-14 03:16:00', 'PhilRice CES', 'sdwdawdawd', 'sdawdadadw', NULL, NULL, '2025-04-13 21:16:25', '2025-04-14 01:47:05'),
(5, 's', '2025-04-21 06:24:46', 's', 's', 's', 1, 'Anonymous', NULL, NULL, NULL, NULL, NULL, 'Normal', 'Resolved', '2025-04-09 14:27:00', 'PhilRice CES', 's', 's', NULL, NULL, '2025-04-20 22:24:46', '2025-05-14 02:52:22'),
(6, 'try try lang naman po', '2025-05-13 04:58:58', 'testing', 'subject testing', 'testing lang toh ng incident na galing kay john deer', 23, 'John Deer', NULL, NULL, NULL, NULL, NULL, 'High', 'Resolved', '2025-05-13 15:00:00', 'PhilRice CES', 'malaking impact', 'lahtat kami sa office', NULL, NULL, '2025-05-12 20:58:58', '2025-05-18 19:27:54'),
(7, 'fefefe', '2025-05-14 10:18:16', 'fefef', 'fefefe', 'fefefef', 23, 'John Deer', NULL, 1, 'John benedict', 1, 'John Vincent', 'High', 'Resolved', '2025-05-14 13:18:00', 'PhilRice CES', 'fefefe', 'fefefef', NULL, NULL, '2025-05-14 02:18:16', '2025-05-14 02:36:22'),
(10, 'qwertyui', '2025-05-14 10:31:31', 'qwertt', 'qwertt', 'qwertyu', 1, 'John Deer', NULL, NULL, 'Carlos Garcia', NULL, 'Klierte Hoson', 'Low', 'Not Resolved', '2025-05-14 15:28:00', 'PhilRice Negros', '12345678', 'qwertyujkmnffg', NULL, NULL, '2025-05-14 02:31:31', '2025-05-14 02:31:31'),
(11, '12345', '2025-05-14 10:33:21', '123456', '12345', '12345', 1, 'John Deer', NULL, NULL, 'qwerty', NULL, 'wasd', 'Normal', 'Resolved', '2025-05-14 23:33:00', 'PhilRice CES', '12345', '1234', NULL, NULL, '2025-05-14 02:33:21', '2025-05-18 19:41:03'),
(12, 'dawdawdasda', '2025-05-14 10:36:52', 'dawdawda', 'dawdawda', 'dawdadawd', 1, 'John Deer', NULL, NULL, 'sdawdawd', NULL, 'dasdawdadw', 'Low', 'Resolved', '2025-05-12 23:36:00', 'PhilRice CES', 'asdawdad', 'asdawdawda', NULL, NULL, '2025-05-14 02:36:52', '2025-05-18 19:35:43'),
(13, 'dawdasda', '2025-05-14 10:40:48', 'destroy', 'destroy', 'awdawdadw', 1, 'John Deer', NULL, NULL, 'Sarah G', NULL, 'Joselito H.', 'Low', 'Not Resolved', '2025-05-14 23:40:00', 'PhilRice CES', 'qw12dqwd', '12e1wd1de', NULL, NULL, '2025-05-14 02:40:48', '2025-05-14 02:40:48'),
(14, 'dasdawdasdawdawdwq', '2025-05-14 10:50:45', 'dasdawdawdawdas', 'dawdasdawdadaw', 'dasdawdadawdad', 1, 'John Deer', NULL, NULL, 'Turnicate Arrow', NULL, 'Qwerty Wasd', 'Normal', 'Resolved', '2025-05-15 15:50:00', 'PhilRice CES', 'werwerwerwe', 'rwfwerwerwer', NULL, NULL, '2025-05-14 02:50:45', '2025-05-19 16:12:14'),
(15, 'fwefwe', '2025-05-14 16:04:00', 'testing', NULL, 'dfefa', 1, 'John Doe', NULL, NULL, 'zeckiel peralta', NULL, 'John Vincent', 'Normal', 'Resolved', '2025-05-13 18:03:00', 'PhilRice CES', 'fwwefwef', 'ewfwefwefw', NULL, NULL, '2025-05-14 08:04:00', '2025-05-18 19:28:27'),
(16, 'dasdawd', '2025-05-14 16:04:41', 'dasdawda', 'dasawdawd', 'addawdad', 1, 'Mark Johnson', NULL, NULL, 'Vincent Macayanan', NULL, 'Zeckiel Peralta', 'Normal', 'Resolved', '2025-05-15 18:04:00', 'PhilRice CES', 'dasdawd', 'asdawdaw', NULL, NULL, '2025-05-14 08:04:41', '2025-05-19 16:44:47'),
(17, 'mobile', '2025-05-20 00:11:10', 'mobile', 'mobile', 'mobile', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Normal', 'Resolved', '2025-05-20 00:10:00', 'Computer & Peripheral Services', 'mobile', 'mobile', NULL, NULL, '2025-05-19 16:11:10', '2025-05-20 17:06:26'),
(18, 'mobile', '2025-05-20 00:16:29', 'mobile', 'mobile', 'mobile', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Normal', 'Resolved', '2025-05-20 00:16:00', 'Computer & Peripheral Services', 'mobile', 'mobile', NULL, NULL, '2025-05-19 16:16:29', '2025-05-20 17:06:44'),
(19, 'c', '2025-05-20 00:24:05', 'c', 'c', 'x', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:23:00', 'Network Services', 'c', NULL, NULL, NULL, '2025-05-19 16:24:05', '2025-05-19 16:24:05'),
(20, 'c', '2025-05-20 00:24:21', 'c', 'c', 'x', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:23:00', 'Network Services', 'c', NULL, NULL, NULL, '2025-05-19 16:24:21', '2025-05-19 16:24:21'),
(21, 'c', '2025-05-20 00:24:56', 'f', 'r', 'c', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:24:00', 'Computer & Peripheral Services', 'v', 'v', NULL, NULL, '2025-05-19 16:24:56', '2025-05-19 16:24:56'),
(22, 'c', '2025-05-20 00:25:04', 'f', 'r', 'c', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:24:00', 'Computer & Peripheral Services', 'v', 'v', NULL, NULL, '2025-05-19 16:25:04', '2025-05-19 16:25:04'),
(23, 'c', '2025-05-20 00:25:09', 'f', 'r', 'c', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:24:00', 'Computer & Peripheral Services', 'v', 'v', NULL, NULL, '2025-05-19 16:25:09', '2025-05-19 16:25:09'),
(24, 'c', '2025-05-20 00:26:21', 'f', 'r', 'c', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 00:24:00', 'Computer & Peripheral Services', 'v', 'v', NULL, NULL, '2025-05-19 16:26:21', '2025-05-19 16:26:21'),
(25, 'bg', '2025-05-20 00:26:50', 'dddd', 'cñéåååå', 'c', 1, 'John Doe', NULL, NULL, NULL, NULL, NULL, 'Low', 'Not Resolved', '2025-05-20 18:25:00', 'PhilRice Negros', 'v', 'v', NULL, NULL, '2025-05-19 16:26:50', '2025-05-20 18:31:44'),
(26, 'g', '2025-05-20 00:45:23', 'gnewwwww', 'cnewwww', 'cnewwwwww up', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'High', 'Resolved', '2025-05-20 03:28:00', 'PhilRice Negros', 'dnewww', 'snewww', NULL, NULL, '2025-05-19 16:45:23', '2025-05-20 19:34:10'),
(27, 'qq', '2025-05-21 02:57:12', 'nwetest', 'newtest', 'newtst', 1, 'John Doe', NULL, 1, ' ', 35, ' ', 'High', 'Resolved', '2025-05-20 18:56:00', 'Plant Breeding and Biotechnology', 'f', 'ff', NULL, NULL, '2025-05-20 18:57:12', '2025-05-20 19:34:19'),
(28, '333', '2025-05-21 03:03:33', '303tesy', '3033', '333', 1, 'John Doe', NULL, 22, ' ', 1, ' ', 'Low', 'Not Resolved', '2025-05-20 19:04:00', 'Plant Breeding and Biotechnology', '333', '333', NULL, NULL, '2025-05-20 19:03:33', '2025-05-20 19:04:33'),
(29, 'c', '2025-05-21 03:33:56', '3', 'zz', 'z', 1, 'John Doe', NULL, 1, ' ', 1, ' ', 'Normal', 'Resolved', '2025-05-21 03:36:00', 'Agronomy, Soils and Plant Physiology', 'x', 'z', NULL, NULL, '2025-05-20 19:33:56', '2025-05-21 06:06:10'),
(30, 'Replacement', '2025-05-21 14:04:49', 'Replacement', 'Replacement', 'Replacement', 1, 'John Doe', NULL, 22, ' ', 23, ' ', 'High', 'Not Resolved', '2025-05-21 14:04:00', 'Information Systems', 'Broken', 'Broken', NULL, NULL, '2025-05-21 06:04:49', '2025-05-21 06:05:06'),
(31, 'qwert', '2025-05-21 15:02:45', 'qwert', 'qwertyu', 'qwerty', 1, 'John Doe', NULL, NULL, 'John benedict', NULL, 'Zeckiel Peralta', 'Low', 'Resolved', '2025-05-21 17:02:00', 'PhilRice CES', 'high', 'all', NULL, NULL, '2025-05-21 07:02:45', '2025-05-21 07:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `lib_log_status`
--

CREATE TABLE `lib_log_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `logstatus_name` varchar(191) NOT NULL,
  `logstatus_abbr` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_log_status`
--

INSERT INTO `lib_log_status` (`id`, `logstatus_name`, `logstatus_abbr`) VALUES
(1, 'Submitted', 'smbt'),
(2, 'Received', 'rcvd'),
(3, 'Picked', 'pckd'),
(4, 'Service Paused', 'psd'),
(5, 'Rendering Service', 'rndr'),
(6, 'Rendered and Completed', 'rdnc'),
(7, 'Evaluated', 'evld'),
(8, 'Returned to Pending Status', 'ret'),
(9, 'Transferred to Another Technician', 'trans'),
(100, 'Request has been denied due to some reason/s.', 'Dnd'),
(101, 'Sent Message.', 'SMES'),
(102, 'Sent Evaluation Request.', 'SEvalR'),
(103, 'Generate PDF Report', 'GPDFR'),
(200, 'Cancelled', 'CNC');

-- --------------------------------------------------------

--
-- Table structure for table `lib_problems_encountered`
--

CREATE TABLE `lib_problems_encountered` (
  `id` int(10) UNSIGNED NOT NULL,
  `encountered_problem_name` varchar(191) NOT NULL,
  `encountered_problem_abbr` varchar(191) NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_problems_encountered`
--

INSERT INTO `lib_problems_encountered` (`id`, `encountered_problem_name`, `encountered_problem_abbr`, `is_archived`, `category_id`) VALUES
(7, 'Defective Phone Unit', 'DefPU', 1, NULL),
(8, 'Defective PABX Expansion Card', 'DefPEC', 1, NULL),
(10, 'Defective UTP Cable', 'DefUTP', 1, NULL),
(11, 'Defective RJ45 Connectors (plug/jack)', 'DefRJ45', 1, NULL),
(12, 'Defective Backbone / Horizontal Cable', 'DefBHC', 1, NULL),
(13, 'Defective Switch Port', 'DefSwPort', 1, NULL),
(14, 'Defective Network Access Switch', 'DefNAS', 1, NULL),
(15, 'Not Registered', 'NReg', 0, NULL),
(16, 'Additional User / Network Printer (if LAN port is available)', 'AdUNP', 0, NULL),
(17, 'Defective Power Supply/Adapter', 'DefPSupp/Ad', 0, NULL),
(18, 'Defective Battery', 'DefBatt', 0, NULL),
(19, 'Defective Motherboard', 'DefMBoard', 0, NULL),
(20, 'Defective Part/s', 'DefParts', 0, NULL),
(21, 'Sample', 'Sample', 0, NULL),
(22, 'No Problem Found.', 'NPF', 0, NULL),
(23, 'Defective HardDisk / Storage', 'DefHDD', 0, NULL),
(24, 'Unrecoverable Data', 'UrecData', 0, NULL),
(25, 'Trust Relationship issue between the server(domain) and the client.', 'TR', 0, NULL),
(26, 'Misalligned mechanism', 'MAM', 0, NULL),
(27, 'No printer driver installed', 'NPDI', 0, NULL),
(28, 'Relocate/transfer', 'REL', 0, NULL),
(29, 'Clogged or dirty print cartridge', 'CDC', 0, NULL),
(30, 'Installation of party line', 'IPL', 0, NULL),
(31, 'Relocate/transfer the telephone line', 'RTL', 0, NULL),
(32, 'Loose Connection', 'LC', 0, NULL),
(33, 'Boot Loop', 'BL', 0, NULL),
(34, 'USB Port Malfunction', 'USB', 0, NULL),
(35, 'No Problem Encountered.', 'NPE', 0, NULL),
(36, 'Blue Screen of Death', 'BSD', 0, NULL),
(37, 'Blue Screen of Death', 'BSD', 0, NULL),
(38, 'Missing DLL Files', 'MDF', 0, NULL),
(39, 'Applications Running Slowly', 'ARS', 0, NULL),
(40, 'Malware Infected', 'MI', 0, NULL),
(41, 'Internet or Network Connectivity Issues', 'INCI', 0, NULL),
(42, 'Hard Drive Failure', 'HDF', 0, NULL),
(43, 'Frozen Screen', 'FS', 0, NULL),
(44, 'Applications won’t install', 'AWI', 0, NULL),
(45, 'No Power', 'NP', 0, NULL),
(46, 'No Display', 'ND', 0, NULL),
(47, 'No network connectivity', 'NNC', 0, NULL),
(48, 'Beep Sound', 'BS', 0, NULL),
(49, 'Noisy Sound', 'NS', 0, NULL),
(50, 'Overheating', 'OH', 0, NULL),
(51, 'The computer won\'t start', 'CWS', 0, NULL),
(52, 'The screen is blank', 'SIB', 0, NULL),
(53, 'Abnormally functioning Operating System', 'AFOS', 0, NULL),
(54, 'Computer Slow', 'CS', 0, NULL),
(55, 'Keyboard / Mouse malfunction', 'KMM', 0, NULL),
(56, 'Unreadable', 'UD', 0, NULL),
(57, 'Loose Cable', 'LC', 0, NULL),
(58, 'Usb Port Issues', 'UPI', 0, NULL),
(59, 'Dial tone is ok but no incoming/outgoing call', 'NIO', 0, NULL),
(60, 'Microsoft Office Malfunction', 'MOM', 0, NULL),
(61, 'No Dial Tone', 'NDT', 0, NULL),
(62, 'I-house Wiring is Okay', 'IWO', 0, NULL),
(63, 'In-House Wiring is Okay', 'IWO', 0, NULL),
(64, 'Service Provider Issue', 'SPI', 0, NULL),
(65, 'Lock Out', 'LO', 0, NULL),
(66, 'Printer won’t print', 'PWP', 0, NULL),
(67, 'Printer claim it\'s running out of ink', 'POI', 0, NULL),
(68, 'Paper Jam or Multiple of sheet are drawn', 'PJ', 0, NULL),
(69, 'Printer is too slow', 'PTS', 0, NULL),
(70, 'Print image is being superseded over another', 'PIS', 0, NULL),
(71, 'Print quality is gone down the drain', 'PQD', 0, NULL),
(72, 'Dirty print', 'DP', 0, NULL),
(73, 'Lock Out / Blinking of LED Lights', 'LO', 0, NULL),
(74, 'New printer for installation', 'NPI', 0, NULL),
(75, 'Black lines or smudges down the printer', 'BSP', 0, NULL),
(76, 'Defective LCD Screen / Monitor', 'DLSM', 0, NULL),
(77, 'Windows System Corrupted', 'WSC', 0, NULL),
(78, 'Fingerprint recognition issue', 'FRI', 0, NULL),
(79, 'Pre-Repair Inspection', 'PRI', 0, NULL),
(80, 'Backup Data', 'BD', 0, NULL),
(81, 'Setup and installation of Software', 'SIS', 0, NULL),
(82, 'Add Contact for Network Scanner', 'ACNC', 0, NULL),
(83, 'Update contact information on Network Scanner', 'UNC', 0, NULL),
(84, 'Contact information on Network Scanner is outdated', 'CInfo', 0, NULL),
(85, 'Always Restart', 'AR', 0, NULL),
(86, 'MS Office Unactivated', 'MOU', 0, NULL),
(87, 'Defective Power Supply', 'DPS', 0, NULL),
(88, 'No Power', 'NP', 0, NULL),
(89, 'End of service life', 'ESL', 0, NULL),
(90, 'The user can\'t login on computer', 'tuc', 0, NULL),
(91, 'Faulty CPU Fan', 'FCF', 0, NULL),
(92, 'Faulty Enclosure', 'FE', 0, NULL),
(93, 'Hard drive Unreadable', 'HU', 0, NULL),
(94, 'Outdated Printer/Scanner Driver', 'OPSD', 0, NULL),
(95, 'New/additional LAN connection', 'NAL', 0, NULL),
(96, 'End of service life', 'ESL', 0, NULL),
(97, 'Printer blinking of Led Lights', 'PBL', 0, NULL),
(98, 'Windows system infected of malwares', 'WSIM', 0, NULL),
(99, 'Hard drive system full', 'HDDF', 0, NULL),
(100, 'Defective Harddisk Drive', 'DHDD', 0, NULL),
(101, 'Faulty Carrier Cleaner', 'FCC', 0, NULL),
(102, 'Paper Jam error', 'PJ', 0, NULL),
(103, 'Printer Head Malfunction', 'PHM', 0, NULL),
(104, 'Noisy Sound', 'NS', 0, NULL),
(105, 'Always Restart', 'AR', 0, NULL),
(106, 'Defective Hard disk', 'DHDD', 0, NULL),
(107, 'Drive Unallocated', 'DU', 0, NULL),
(108, 'Printer not detected', 'PND', 0, NULL),
(109, 'Recover the Data', 'RD', 0, NULL),
(110, 'Wifi not functioning', 'WIFI', 0, NULL),
(111, 'Faulty Motherboard', 'FM', 0, NULL),
(112, 'Beam Error', 'BE', 0, NULL),
(113, 'Lan Messenger', 'LM', 0, NULL),
(114, 'Installed the wiring (UTP cables, Backbone cables, Horizontal cables and power cables)', 'IUBHP', 0, NULL),
(115, 'New/Additional CCTV camera', 'NAC', 0, NULL),
(116, 'Virus Infected', 'VI', 0, NULL),
(117, 'Partition of Hard drive', 'PHDD', 0, NULL),
(118, 'New LAN and Telephone connections', 'NLT', 0, NULL),
(119, 'New computer unit', 'NCU', 0, NULL),
(120, 'Missing part/s consumable not applicable.', 'MPC', 0, NULL),
(121, 'Password loss', 'PL', 0, NULL),
(122, 'CoreMIS', 'CMIS', 0, NULL),
(123, 'Upgrade RAM', 'UR', 0, NULL),
(124, 'Rewiring/retermination of LAN and Telephone lines', 'RRL', 0, NULL),
(125, 'Rewiring/retermination of LAN and Telephone lines', 'RLT', 0, NULL),
(126, 'Rewiring/Retermination of LAN and Telephone lines', 'RRL', 0, NULL),
(127, 'Defective PABX Card Port', 'DPP', 0, NULL),
(128, 'No core mis application', 'NCMA', 0, NULL),
(129, 'Transfer workstation to new staff', 'NS', 0, NULL),
(130, 'No Audio driver', 'NAD', 0, NULL),
(131, 'Upgrading of Operating System', 'UOS', 0, NULL),
(132, 'Upgrading of Operating System', 'UOS', 0, NULL),
(133, 'No materials during the time of request', 'NMR', 0, NULL),
(134, 'New computer unit', 'NCU', 0, NULL),
(135, 'Re-activate telephone line', 'RAT', 0, NULL),
(136, 'PABX /PBX Failure', 'PBX', 0, NULL),
(137, 'Power/UPS Failure', 'UPS', 0, NULL),
(138, 'Email account in maintenance', 'email spam', 0, NULL),
(139, 'No Camera Installed in the area', 'NCI', 0, NULL),
(140, 'Recording Not Available', 'RNA', 0, NULL),
(141, 'Hard disk Error', 'HDDE', 0, NULL),
(142, 'Reboot loop', 'RBL', 0, NULL),
(143, 'Directory C:\\ system not detected', 'SND', 0, NULL),
(144, 'Hang and Freeze Applications', 'HFA', 0, NULL),
(145, 'Old unit and software environment not applicable', 'OU', 0, NULL),
(146, 'Zoom license activation', 'ZLA', 0, NULL),
(147, 'Setup video conferencing Equipment and Internet Access', 'SVE', 0, NULL),
(148, 'LAN Messenger Problem', 'LMP', 0, NULL),
(149, 'Continous Beep', 'COB', 0, NULL),
(150, 'Can\'t be Turned-OFF', 'CTO', 0, NULL),
(151, 'Equipment Failure/Error', 'EFE', 0, NULL),
(152, 'Setup of LEDWall', 'SLW', 0, NULL),
(153, 'LEDWall Setup (Outdoor)', 'LWO', 0, NULL),
(154, 'Setup of LED Wall', 'SLWO', 0, NULL),
(155, 'Live stream to FB, YT, etc.', 'LST', 0, NULL),
(156, 'Login Problem', 'LIP', 0, NULL),
(157, 'Check CCTV Camera/s', 'CCC', 0, NULL),
(158, 'Time outdated', 'CMOS', 0, NULL),
(159, 'Intranet Concern', 'INC', 0, NULL),
(160, 'New Telephone line/local', 'NLL', 0, NULL),
(161, 'Data/Recording Available', 'DRA', 0, NULL),
(162, 'Not Registered to Domain Network', 'NDN', 0, NULL),
(163, 'Additional Wi-Fi Access', 'AWA', 0, NULL),
(164, 'LAN Messenger is not installed', 'LMNI', 0, NULL),
(165, 'Defective RJ22 Connector/Cable', 'DRC', 0, NULL),
(166, 'Login/Password Problem', 'LPP', 0, NULL),
(167, 'QR scans does not reflect to the DTR', 'QRSNR', 0, NULL),
(168, 'No account', 'NOACC', 0, NULL),
(169, 'Cannot scan qr code', 'CNTQRC', 0, NULL),
(170, 'No QR code', 'NOQRC', 0, NULL),
(171, 'Test problem', 'Test problem', 0, NULL),
(172, 'User Error', 'USER_ERROR', 0, NULL),
(173, 'Static/Noisy Line', 'SNL', 0, NULL),
(174, 'Install Biometric Attendance Machine/Device', 'IBMD', 0, NULL),
(175, 'Install Biometric Door Lock System', 'IBDS', 0, NULL),
(176, 'Install Biometric Door Lock System', 'IBDLS', 0, NULL),
(177, 'No software/driver installed', 'NSDI', 0, NULL),
(178, 'Cannot receive OTP', 'CNTROTP', 0, NULL),
(179, 'Software Issue', 'ISS', 0, NULL),
(180, 'Request for Internet Access', 'RIA', 0, NULL),
(181, 'Setup TV monitor/Projector', 'STP', 0, NULL),
(182, 'Defective NIC', 'DFN', 0, NULL),
(183, 'Replace Network Switch', 'RNS', 0, NULL),
(184, 'Replace Network Switch', 'RNS', 0, NULL),
(185, 'Scanner Error', 'SE', 0, NULL),
(186, 'Scanner', 'S', 0, NULL),
(187, 'LAN Card', 'LAN', 0, NULL),
(188, 'Creation of Zoom Account', 'CZA', 0, NULL),
(189, 'Zoom License Activation', 'ZLA', 0, NULL),
(190, 'Diagnose', 'DIA', 0, NULL),
(191, 'Create zoom link for the activity and send to the client', 'CAC', 0, NULL),
(192, 'Setup WiFi Router/AP', 'SWR', 0, NULL),
(193, 'LAN connection for network printer', 'LCNP', 0, NULL),
(194, 'Printer Driver Error', 'PDE', 0, NULL),
(195, 'Door Lock Setup', 'DLS', 0, NULL),
(196, 'Installation of Telephone Unit/s', 'ITU', 0, NULL),
(197, 'CCTV Camera/s is/are not accessible', 'CCA', 0, NULL),
(198, 'No power at AC source/outlet', 'NAC', 0, NULL),
(199, 'Installation of certificate', 'IOC', 0, NULL),
(200, 'Install Additional HDD/SSD', 'IAHDD/SDD', 0, NULL),
(201, 'Dirty Scanner', 'DS', 0, NULL),
(202, 'sharing of other printer', 'SOP', 0, NULL),
(203, 'New Computer/s', 'NCs', 0, NULL),
(204, 'Renaming of computer', 'ROC', 0, NULL),
(205, 'Register to PhilRice Domain', 'RPD', 0, NULL),
(206, 'LED wall setup', 'LWS', 0, NULL),
(207, 'Spooler Error', 'SER', 0, NULL),
(208, 'Renaming of Computer', 'ROC', 0, NULL),
(209, 'Installation of Scanner Driver/software', 'ISDS', 0, NULL),
(210, 'Installation of Additional Monitor', 'IAM', 0, NULL),
(211, 'No Contacts on Messenger App', 'NCMA', 0, NULL),
(212, 'Check the biometric/door access control system', 'CBDACS', 0, NULL),
(213, 'Defective Power Adapter/PSU', 'DPAPSU', 0, NULL),
(214, 'Registration of fingerprint/face ID', 'RFID', 0, NULL),
(215, 'Installation of CCTV camera/s', 'ICC', 0, NULL),
(216, 'DTR Concern', 'DTRC', 0, NULL),
(217, 'Missing color on printed output (Black / Magenta / Cyan / Yellow))', 'MPO', 0, NULL),
(218, 'New UPS', 'NUPS', 0, NULL),
(219, 'Check the system unit', 'CSU', 0, NULL),
(220, 'Renumbering of Local Line/s', 'RLL', 0, NULL),
(221, 'Installation of Door Access Control System (DACS)', 'DACS', 0, NULL),
(222, 'Door/magnetic lock is not functioning', 'DMLOF', 0, NULL),
(223, 'Sync System Time', 'SST', 0, NULL),
(224, 'Others', 'Otrs', 0, NULL),
(225, 'Can\'t Login - Account on Maintenance Mode', 'ZMMRe', 0, NULL),
(226, 'Setup computer/s (Dekstop/laptop)', 'SCDL', 0, NULL),
(227, 'No time in/out reflected to DTR', 'NTRDTR', 0, NULL),
(228, 'ISP Problem/ISP is down', 'ISPD', 0, NULL),
(229, 'Defective hinge (laptop)', 'DEH', 0, NULL),
(230, 'Borrowing of Videoconferencing Equipment', 'BVE', 0, NULL),
(231, 'Syncing Biometric Data from Enrollment Terminal', 'SBDT', 0, NULL),
(232, 'Update Display Name', 'UDN', 0, NULL),
(233, 'General Error (Printer)', 'GEP', 0, NULL),
(234, 'Defective RAM', 'DEFR', 0, NULL),
(235, 'CMOS failure', 'CMOSF', 0, NULL),
(236, 'CMOS/BIOS Problem', 'CMBIP', 0, NULL),
(237, 'Can\'t Login Zimbra Account', 'CLZA', 0, NULL),
(238, 'no ink coming out', 'NoInk', 0, 6),
(239, 'Create new zoom account', 'CreateZoomAcc', 0, 1),
(242, 'ACCOUNT DELETION', 'AD', 1, 1),
(243, 'd', 'd', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lib_roles`
--

CREATE TABLE `lib_roles` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `role_name` varchar(191) NOT NULL,
  `role_abbr` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_roles`
--

INSERT INTO `lib_roles` (`id`, `role_name`, `role_abbr`) VALUES
(1, 'Super Administrator', 'superadmin'),
(2, 'Administrator', 'admin'),
(3, 'Technician', 'tech'),
(4, 'Station Technician', 'STech'),
(5, 'Users', 'usr');

-- --------------------------------------------------------

--
-- Table structure for table `lib_station`
--

CREATE TABLE `lib_station` (
  `id` int(11) NOT NULL,
  `station_name` varchar(500) NOT NULL,
  `station_abbr` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lib_station`
--

INSERT INTO `lib_station` (`id`, `station_name`, `station_abbr`) VALUES
(1, 'Central Experimental Station', 'CES'),
(2, 'Agusan', 'AGS'),
(3, 'Batac', 'BTC'),
(4, 'Bicol', 'BCL'),
(5, 'Isabela', 'ISB'),
(6, 'Los Baños', 'LB'),
(7, 'Midsayap', 'MSYP'),
(8, 'Negros', 'NGS');

-- --------------------------------------------------------

--
-- Table structure for table `lib_status`
--

CREATE TABLE `lib_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status_name` varchar(191) NOT NULL,
  `status_abbr` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_status`
--

INSERT INTO `lib_status` (`id`, `status_name`, `status_abbr`) VALUES
(1, 'Pending', 'PND'),
(2, 'Received', 'RCV'),
(3, 'Picked', 'PCK'),
(4, 'Assigned', 'ASG'),
(5, 'Ongoing', 'ONG'),
(6, 'Paused', 'PSD'),
(7, 'Completed', 'CPT'),
(8, 'Evaluated', 'EVL'),
(100, 'Denied', 'DND'),
(200, 'Canceled', 'CCL');

-- --------------------------------------------------------

--
-- Table structure for table `lib_sub_categories`
--

CREATE TABLE `lib_sub_categories` (
  `id` int(255) NOT NULL,
  `category_id` bigint(255) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lib_sub_categories`
--

INSERT INTO `lib_sub_categories` (`id`, `category_id`, `sub_category_name`) VALUES
(1, 1, 'Reset Password'),
(2, 1, 'Account Lockout'),
(3, 1, 'New Account'),
(4, 2, 'Equipment Repair'),
(5, 2, 'DTR Logs Issue'),
(6, 2, 'Enrollment'),
(7, 2, 'Installation of Door Access Control System'),
(8, 2, 'Installation of Biometric Attendance'),
(9, 3, 'Webcam Installation'),
(10, 3, 'Data Backup'),
(11, 3, 'Data Recovery'),
(12, 3, 'Computer Repair'),
(13, 3, 'New Computer Setup'),
(14, 4, 'Other System'),
(15, 4, 'HRIS'),
(16, 4, 'PMIS'),
(17, 4, 'FMIS'),
(18, 5, 'CCTV Review'),
(19, 5, 'Equipment Repair'),
(20, 5, 'Installation'),
(21, 6, 'Connectivity Issues'),
(22, 6, 'Equipment Repair'),
(23, 6, 'Installation'),
(24, 7, 'Power Adapter Repair'),
(25, 7, 'UPS Repair'),
(26, 7, 'Smartphone/Tablet Repair'),
(27, 8, 'LAN Installation'),
(28, 8, 'Structured Cabling'),
(29, 8, 'Rewiring'),
(30, 8, 'Equipment Repair'),
(31, 9, 'Repair'),
(32, 9, 'Installation'),
(33, 10, 'Rewiring'),
(34, 10, 'Equipment Repair'),
(35, 10, 'Installation'),
(36, 11, 'Seminar/Webinar Support'),
(37, 11, 'Videoconference Assistance'),
(38, 11, 'LED Wall Setup');

-- --------------------------------------------------------

--
-- Table structure for table `lib_technicians`
--

CREATE TABLE `lib_technicians` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_idno` char(7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_technicians`
--

INSERT INTO `lib_technicians` (`id`, `user_idno`, `created_at`, `updated_at`) VALUES
(1, '23-0001', '2025-02-14 03:20:37', '2025-02-14 03:20:37'),
(3, '23-0003', '2025-03-25 03:50:46', '2025-03-25 03:50:46'),
(4, '23-0004', '2025-04-02 03:01:48', '2025-04-02 03:01:48'),
(5, '23-0005', '2025-04-02 03:01:48', '2025-04-02 03:01:48'),
(6, 'PR-009', '2025-05-04 17:45:03', '2025-05-04 17:45:03'),
(7, '3001', '2025-05-04 17:45:51', '2025-05-04 17:45:51'),
(8, 'PR-010', '2025-05-15 06:17:28', '2025-05-15 06:17:28'),
(10, '23-0002', '2025-05-20 04:00:41', '2025-05-20 04:00:41'),
(11, 'PR-003', '2025-05-21 04:03:26', '2025-05-21 04:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `lib_verifiers`
--

CREATE TABLE `lib_verifiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_verifiers`
--

INSERT INTO `lib_verifiers` (`id`, `name`, `position`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'John benedict', NULL, NULL, 1, '2025-05-14 02:18:16', '2025-05-14 02:18:16'),
(2, 'Vincent Macayanan', NULL, NULL, 1, '2025-05-14 02:19:10', '2025-05-14 02:19:10'),
(3, 'zeckiel peralta', NULL, NULL, 1, '2025-05-14 02:20:04', '2025-05-14 02:20:04'),
(4, 'Turnicate Arrow', NULL, NULL, 1, '2025-05-14 02:50:45', '2025-05-14 02:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `message_to_clients`
--

CREATE TABLE `message_to_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_request_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_to_clients`
--

INSERT INTO `message_to_clients` (`id`, `service_request_id`, `sender_id`, `recipient_id`, `ticket_number`, `status`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(5, 79, 1, 1, 'CMS-2025-05-01', 'ongoing', 'ww', 'g', 0, '2025-05-18 08:29:29', '2025-05-18 08:29:29'),
(6, 79, 1, 1, 'CMS-2025-05-01', 'ongoing', 'ww', 'gg', 0, '2025-05-18 08:32:41', '2025-05-18 08:32:41'),
(7, 79, 1, 1, 'CMS-2025-05-01', 'ongoing', 'ww', 'r', 0, '2025-05-18 08:33:51', '2025-05-18 08:33:51'),
(8, 79, 1, 1, 'CMS-2025-05-01', 'ongoing', 'ww', 't', 0, '2025-05-18 08:38:54', '2025-05-18 08:38:54'),
(9, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'c', 0, '2025-05-18 08:46:01', '2025-05-18 08:46:01'),
(10, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'f', 0, '2025-05-18 08:47:30', '2025-05-18 08:47:30'),
(11, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'g', 0, '2025-05-18 08:47:45', '2025-05-18 08:47:45'),
(12, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'g', 0, '2025-05-18 08:48:37', '2025-05-18 08:48:37'),
(13, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'g', 0, '2025-05-18 08:49:48', '2025-05-18 08:49:48'),
(14, 80, 1, 1, 'CRS-2025-05-05', 'ongoing', 'e', 'gg', 0, '2025-05-18 08:52:58', '2025-05-18 08:52:58'),
(15, 83, 1, 1, 'ARS-2025-05-11', 'ongoing', '1', '4', 0, '2025-05-18 08:59:56', '2025-05-18 08:59:56'),
(16, 83, 1, 1, 'ARS-2025-05-11', 'ongoing', '1', 't', 0, '2025-05-18 09:03:34', '2025-05-18 09:03:34'),
(17, 98, 1, 1, 'BRS-2025-05-03', 'ongoing', 'c', 'ddgdgfg', 0, '2025-05-21 06:11:27', '2025-05-21 06:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(5, '2025_04_21_013216_add_is_archived_to_lib_problems_and_actions', 3),
(6, '2024_02_24_create_message_to_clients_table', 4),
(7, '2025_05_05_021628_update_status_from_ongoing', 5),
(8, '2025_05_08_create_lib_approvers_table', 6),
(9, '2025_05_08_create_lib_verifiers_table', 7),
(10, '2025_05_14_update_incident_reports_foreign_keys', 8),
(11, '2025_05_14_create_lib_findings_recommendations_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'mobile_token', 'faa9e811186c5c8ee0990ad18142d9b1acfe5dab398fd0295dfce4b5cd922e18', '[\"*\"]', NULL, NULL, '2025-04-22 19:53:39', '2025-04-22 19:53:39'),
(2, 'App\\Models\\User', 37, 'mobile_token', '38c9e44c54704792fc60d77f10004c0acbbd7d9c765b0cb7a8e894308f8ef4f2', '[\"*\"]', NULL, NULL, '2025-04-22 19:56:11', '2025-04-22 19:56:11'),
(3, 'App\\Models\\User', 1, 'mobile_token', 'da49c2a682034a0a274aecd69993687f159ba85503efdc5339778be772fcfa22', '[\"*\"]', NULL, NULL, '2025-04-22 19:56:21', '2025-04-22 19:56:21'),
(4, 'App\\Models\\User', 37, 'mobile_token', '0d7c9caa3722456d2d3961b01ec1c7a5f23174486db0b91247219cece443d5e9', '[\"*\"]', NULL, NULL, '2025-04-22 20:02:54', '2025-04-22 20:02:54'),
(5, 'App\\Models\\User', 37, 'mobile_token', '60d15d4328ebe07207cd15d1932a0b7d1e6067aec62d8b03e1f9c7a1ceac5ff3', '[\"*\"]', NULL, NULL, '2025-04-22 20:05:23', '2025-04-22 20:05:23'),
(6, 'App\\Models\\User', 1, 'mobile_token', 'be5338e731400732bb1ad3d439e0b0148233bac6f6667bbf6962ddcca004e356', '[\"*\"]', NULL, NULL, '2025-04-22 20:27:22', '2025-04-22 20:27:22'),
(7, 'App\\Models\\User', 1, 'mobile_token', 'ad288c33c849d9490080819db9c4032fc388c1ce9ecd97d156a23044c5270733', '[\"*\"]', NULL, NULL, '2025-04-22 21:00:23', '2025-04-22 21:00:23'),
(8, 'App\\Models\\User', 1, 'mobile_token', '880e807b8c4cf49e8d48f7757a3f0c484a8288ef35ddcd67672ea46d921507c5', '[\"*\"]', NULL, NULL, '2025-04-22 21:00:57', '2025-04-22 21:00:57'),
(9, 'App\\Models\\User', 1, 'mobile_token', 'a094be07e444cd9f9115d8d861846fab319b7df1b0f16f869af29533992c406a', '[\"*\"]', NULL, NULL, '2025-04-22 21:06:35', '2025-04-22 21:06:35'),
(10, 'App\\Models\\User', 1, 'mobile_token', 'c982fac976b3eb32a3217cb7dc06a66bfcbac2566b32deb979a076d94dfb040c', '[\"*\"]', NULL, NULL, '2025-04-29 16:45:58', '2025-04-29 16:45:58'),
(11, 'App\\Models\\User', 1, 'mobile_token', '0273f9f993fd41895a7c8fd33e5d33f51485d0aae0f8c4c2a8a2de8a31446ea2', '[\"*\"]', NULL, NULL, '2025-04-29 17:40:06', '2025-04-29 17:40:06'),
(12, 'App\\Models\\User', 1, 'mobile_token', 'adb9f53b67211f0b70c3f76a0eec0c2a4dc22bf96ecdb07ea706c802953fe6e5', '[\"*\"]', NULL, NULL, '2025-05-19 13:42:33', '2025-05-19 13:42:33'),
(13, 'App\\Models\\User', 1, 'mobile_token', '5746bc14245fe944f1773f77070b11284001c5be9a6fe7f8c29d5bacf51a43f2', '[\"*\"]', NULL, NULL, '2025-05-19 14:58:17', '2025-05-19 14:58:17'),
(14, 'App\\Models\\User', 1, 'mobile_token', 'e89af92da9f25b9e4acc9963ac9577c6ff27a24e78da90640c2decf55273a07e', '[\"*\"]', NULL, NULL, '2025-05-19 16:47:42', '2025-05-19 16:47:42'),
(15, 'App\\Models\\User', 1, 'mobile_token', '3a7d58901977858ed10f0fa08a370ff18d6226c880a4a506b2884607d62730b2', '[\"*\"]', NULL, NULL, '2025-05-20 18:10:28', '2025-05-20 18:10:28'),
(16, 'App\\Models\\User', 1, 'mobile_token', '2ba24f1abcfbc006698a212ff66a3f3641cdbf560e111bad57e9ac623f5ebf8c', '[\"*\"]', NULL, NULL, '2025-05-20 18:12:06', '2025-05-20 18:12:06'),
(17, 'App\\Models\\User', 1, 'mobile_token', 'ec60864584745a014fd4d1ae91fefab91ac05756ec16873b9b47582eac25a02c', '[\"*\"]', NULL, NULL, '2025-05-20 19:20:10', '2025-05-20 19:20:10'),
(18, 'App\\Models\\User', 23, 'mobile_token', '55d65ecc282b4b736b4eb52853747fb0f9ea983b906aae52e6835476f7271f37', '[\"*\"]', NULL, NULL, '2025-05-21 04:14:22', '2025-05-21 04:14:22'),
(19, 'App\\Models\\User', 1, 'mobile_token', '34a692138176c90628cd24fc28c76af67cce1cbbbd30c73698dec49fcad7d2fe', '[\"*\"]', NULL, NULL, '2025-05-21 04:23:33', '2025-05-21 04:23:33'),
(20, 'App\\Models\\User', 1, 'mobile_token', 'b7982c924b29cfd4fe5875add5f2e8000c5ffc0acd65924d781d67bc58c48ee3', '[\"*\"]', NULL, NULL, '2025-05-21 05:45:20', '2025-05-21 05:45:20'),
(21, 'App\\Models\\User', 22, 'mobile_token', 'fca601fbadbd122c74849aa14ece138a80f1ab758a664dad36ea2890dd904d37', '[\"*\"]', NULL, NULL, '2025-05-26 02:52:19', '2025-05-26 02:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `primarytechnician_request`
--

CREATE TABLE `primarytechnician_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `technician_emp_id` char(7) DEFAULT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `primarytechnician_request`
--

INSERT INTO `primarytechnician_request` (`id`, `technician_emp_id`, `request_id`, `created_at`, `updated_at`) VALUES
(71, '23-0001', 95, '2025-05-19 16:03:40', '2025-05-19 16:03:40'),
(72, '23-0001', 96, '2025-05-19 16:30:14', '2025-05-19 16:30:14'),
(75, '23-0001', 99, '2025-05-19 16:34:53', '2025-05-19 16:34:53'),
(76, '23-0001', 100, '2025-05-19 16:38:59', '2025-05-19 16:38:59'),
(77, '23-0001', 101, '2025-05-19 16:41:58', '2025-05-19 16:41:58'),
(78, '23-0002', 103, '2025-05-20 03:55:43', '2025-05-20 03:55:43'),
(79, '23-0002', 102, '2025-05-20 03:55:49', '2025-05-20 03:55:49'),
(80, '23-0002', 105, '2025-05-20 03:55:54', '2025-05-20 03:55:54'),
(81, '23-0001', 104, '2025-05-20 19:21:57', '2025-05-20 19:21:57'),
(82, '23-0001', 98, '2025-05-20 20:30:06', '2025-05-20 20:30:06'),
(83, 'PR-003', 107, '2025-05-21 04:05:36', '2025-05-21 04:05:36'),
(84, '23-0001', 108, '2025-05-21 06:37:20', '2025-05-21 06:37:20'),
(85, '23-0001', 110, '2025-05-21 06:43:47', '2025-05-21 06:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `request_log`
--

CREATE TABLE `request_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `log_status_id` int(10) UNSIGNED DEFAULT NULL,
  `log_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_log_station`
--

CREATE TABLE `request_log_station` (
  `id` int(10) UNSIGNED NOT NULL,
  `log_id` int(10) UNSIGNED NOT NULL,
  `station_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_problems`
--

CREATE TABLE `request_problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `problem_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_problems`
--

INSERT INTO `request_problems` (`id`, `request_id`, `problem_id`) VALUES
(3, 3, 29);

-- --------------------------------------------------------

--
-- Table structure for table `request_problem_encountered`
--

CREATE TABLE `request_problem_encountered` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `encountered_problem_id` int(10) UNSIGNED DEFAULT NULL,
  `pe_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_problem_encountered`
--

INSERT INTO `request_problem_encountered` (`id`, `request_id`, `encountered_problem_id`, `pe_description`, `created_at`, `updated_at`) VALUES
(1, 1, 25, NULL, '2019-06-06 01:06:04', '2019-06-06 01:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `request_serialnumber`
--

CREATE TABLE `request_serialnumber` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accountable` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_serialnumber`
--

INSERT INTO `request_serialnumber` (`id`, `request_id`, `serial_number`, `created_at`, `updated_at`, `accountable`, `division`) VALUES
(1, 95, 'mobile', '2025-05-19 16:01:22', '2025-05-19 16:01:22', 'mobile', NULL),
(2, 96, 'mobile', '2025-05-19 16:13:30', '2025-05-19 16:13:30', 'mobile', NULL),
(3, 97, 'c', '2025-05-19 16:27:20', '2025-05-19 16:27:20', 'c', NULL),
(4, 98, 'c', '2025-05-19 16:29:18', '2025-05-19 16:29:18', 'c', NULL),
(5, 101, 'vv', '2025-05-19 16:39:32', '2025-05-19 16:39:32', 'b', NULL),
(6, 102, 'vv', '2025-05-19 16:41:49', '2025-05-19 16:41:49', 'b', NULL),
(7, 107, '23', '2025-05-20 19:21:04', '2025-05-20 19:21:04', 'john', NULL),
(8, 108, 'n', '2025-05-20 19:21:38', '2025-05-20 19:21:38', 'j', NULL),
(9, 109, 'Test', '2025-05-21 06:03:55', '2025-05-21 06:03:55', 'John Doe', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request_status`
--

CREATE TABLE `request_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_status`
--

INSERT INTO `request_status` (`id`, `request_id`, `status_id`, `created_at`, `updated_at`) VALUES
(7621, 95, 8, '2025-05-19 16:01:22', '2025-05-20 04:04:36'),
(7622, 96, 7, '2025-05-19 16:13:30', '2025-05-20 04:08:59'),
(7623, 97, 7, '2025-05-19 16:27:20', '2025-05-20 20:03:04'),
(7624, 98, 5, '2025-05-19 16:29:18', '2025-05-20 20:39:20'),
(7625, 99, 8, '2025-05-19 16:34:48', '2025-05-21 06:03:01'),
(7626, 100, 6, '2025-05-19 16:38:54', '2025-05-20 20:00:51'),
(7627, 101, 3, '2025-05-19 16:39:32', '2025-05-19 16:41:58'),
(7628, 102, 7, '2025-05-19 16:41:49', '2025-05-20 06:55:06'),
(7629, 103, 8, '2025-05-20 03:55:09', '2025-05-21 06:58:03'),
(7630, 104, 3, '2025-05-20 03:55:11', '2025-05-20 19:21:57'),
(7631, 105, 3, '2025-05-20 03:55:12', '2025-05-20 03:55:53'),
(7632, 106, 1, '2025-05-20 08:14:38', '2025-05-20 08:14:38'),
(7633, 107, 8, '2025-05-20 19:21:04', '2025-05-28 16:08:49'),
(7634, 108, 3, '2025-05-20 19:21:38', '2025-05-21 06:37:20'),
(7635, 109, 1, '2025-05-21 06:03:55', '2025-05-21 06:03:55'),
(7636, 110, 7, '2025-05-21 06:38:31', '2025-05-21 06:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `request_status_history`
--

CREATE TABLE `request_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'ongoing, paused, denied, cancelled, completed',
  `changed_by` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `problem_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `documentation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_status_history`
--

INSERT INTO `request_status_history` (`id`, `request_id`, `status`, `changed_by`, `remarks`, `problem_id`, `action_id`, `created_at`, `updated_at`, `created_by`, `documentation`) VALUES
(49, 81, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 06:55:24', '2025-05-18 06:55:24', NULL, NULL),
(50, 80, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-18 06:55:32', '2025-05-18 06:55:32', NULL, NULL),
(51, 76, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 06:55:35', '2025-05-18 06:55:35', NULL, NULL),
(52, 77, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 06:55:39', '2025-05-18 06:55:39', NULL, NULL),
(53, 79, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-18 06:55:45', '2025-05-18 06:55:45', NULL, NULL),
(54, 80, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-18 06:55:54', '2025-05-18 06:55:54', NULL, NULL),
(55, 81, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-18 06:56:01', '2025-05-18 06:56:01', NULL, NULL),
(56, 82, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 06:57:02', '2025-05-18 06:57:02', NULL, NULL),
(57, 78, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 06:57:11', '2025-05-18 06:57:11', NULL, NULL),
(58, 81, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 06:57:15', '2025-05-18 06:57:15', NULL, NULL),
(59, 82, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-18 06:57:22', '2025-05-18 06:57:22', NULL, NULL),
(60, 82, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-18 06:58:59', '2025-05-18 06:58:59', NULL, NULL),
(61, 83, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 06:59:07', '2025-05-18 06:59:07', NULL, NULL),
(62, 84, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 06:59:15', '2025-05-18 06:59:15', NULL, NULL),
(63, 85, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 06:59:22', '2025-05-18 06:59:22', NULL, NULL),
(64, 76, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 07:02:57', '2025-05-18 07:02:57', NULL, NULL),
(65, 84, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-18 07:11:53', '2025-05-18 07:11:53', NULL, NULL),
(66, 84, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 07:12:07', '2025-05-18 07:12:07', NULL, NULL),
(67, 83, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-18 07:12:25', '2025-05-18 07:12:25', NULL, NULL),
(68, 83, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 07:12:30', '2025-05-18 07:12:30', NULL, NULL),
(69, 84, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 07:16:12', '2025-05-18 07:16:12', NULL, NULL),
(70, 85, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-18 07:25:29', '2025-05-18 07:25:29', NULL, NULL),
(71, 85, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-18 07:25:34', '2025-05-18 07:25:34', NULL, NULL),
(72, 76, 'paused', '23-0001', 'r', 44, 73, '2025-05-18 07:58:25', '2025-05-18 07:58:25', NULL, NULL),
(73, 76, 'ongoing', '23-0001', 'g', 36, 167, '2025-05-18 07:59:45', '2025-05-18 07:59:45', NULL, NULL),
(74, 76, 'Denied', '23-0001', 'f', 75, 135, '2025-05-18 08:06:14', '2025-05-18 08:06:14', NULL, NULL),
(75, 77, 'completed', '23-0001', 'r', 105, 73, '2025-05-18 08:21:48', '2025-05-18 08:21:48', NULL, NULL),
(76, 78, 'cancelled', '23-0001', '4', 112, 128, '2025-05-18 08:22:06', '2025-05-18 08:22:06', NULL, NULL),
(77, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 08:29:44', '2025-05-18 08:29:44', NULL, NULL),
(78, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis', NULL, NULL, '2025-05-18 08:33:21', '2025-05-18 08:33:21', NULL, NULL),
(79, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Emily Davis', NULL, NULL, '2025-05-18 08:34:24', '2025-05-18 08:34:24', NULL, NULL),
(80, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis, Regular User', NULL, NULL, '2025-05-18 08:34:36', '2025-05-18 08:34:36', NULL, NULL),
(81, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis', NULL, NULL, '2025-05-18 08:35:24', '2025-05-18 08:35:24', NULL, NULL),
(82, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis', NULL, NULL, '2025-05-18 08:37:31', '2025-05-18 08:37:31', NULL, NULL),
(83, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis, Regular User', NULL, NULL, '2025-05-18 08:37:53', '2025-05-18 08:37:53', NULL, NULL),
(84, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis, Regular User, James Anderson', NULL, NULL, '2025-05-18 08:38:07', '2025-05-18 08:38:07', NULL, NULL),
(85, 79, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia, Emily Davis, Regular User, James Anderson', NULL, NULL, '2025-05-18 08:38:42', '2025-05-18 08:38:42', NULL, NULL),
(86, 79, 'cancelled', '23-0001', 'cc', 85, 73, '2025-05-18 08:39:10', '2025-05-18 08:39:10', NULL, NULL),
(87, 81, 'cancelled', '23-0001', 'cc', 112, 117, '2025-05-18 08:40:07', '2025-05-18 08:40:07', NULL, NULL),
(88, 82, 'completed', '23-0001', 'r', 44, 233, '2025-05-18 08:40:29', '2025-05-18 08:40:29', NULL, NULL),
(89, 80, 'paused', '23-0001', 'rr', 80, 168, '2025-05-18 08:53:23', '2025-05-18 08:53:23', NULL, NULL),
(90, 83, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 08:56:43', '2025-05-18 08:56:43', NULL, NULL),
(91, 83, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 09:00:04', '2025-05-18 09:00:04', NULL, NULL),
(92, 83, 'Ongoing', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Laura Garcia', NULL, NULL, '2025-05-18 09:01:50', '2025-05-18 09:01:50', NULL, NULL),
(93, 83, 'paused', '23-0001', 'f', 39, 73, '2025-05-18 09:03:45', '2025-05-18 09:03:45', NULL, NULL),
(94, 84, 'completed', '23-0001', 'g', 39, 73, '2025-05-18 09:32:47', '2025-05-18 09:32:47', NULL, NULL),
(95, 80, 'completed', '23-0001', 'ff', 112, 117, '2025-05-18 09:33:05', '2025-05-18 09:33:05', NULL, NULL),
(96, 86, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 10:15:39', '2025-05-18 10:15:39', NULL, NULL),
(97, 87, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 10:15:52', '2025-05-18 10:15:52', NULL, NULL),
(98, 88, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-18 10:16:11', '2025-05-18 10:16:11', NULL, NULL),
(99, 86, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-18 10:17:16', '2025-05-18 10:17:16', NULL, NULL),
(100, 88, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-18 10:17:28', '2025-05-18 10:17:28', NULL, NULL),
(101, 88, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 10:17:56', '2025-05-18 10:17:56', NULL, NULL),
(102, 86, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 10:17:59', '2025-05-18 10:17:59', NULL, NULL),
(103, 88, 'completed', '23-0001', 'g', 105, 233, '2025-05-18 10:26:11', '2025-05-18 10:26:11', NULL, NULL),
(104, 87, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-18 19:20:44', '2025-05-18 19:20:44', NULL, NULL),
(105, 87, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-18 19:25:21', '2025-05-18 19:25:21', NULL, NULL),
(106, 86, 'paused', '23-0001', 'g', 105, 113, '2025-05-18 19:25:43', '2025-05-18 19:25:43', NULL, NULL),
(107, 86, 'completed', '23-0001', 't', 80, 128, '2025-05-18 19:25:59', '2025-05-18 19:25:59', NULL, NULL),
(108, 87, 'paused', '23-0001', 'cc', 105, 233, '2025-05-18 19:32:30', '2025-05-18 19:32:30', NULL, NULL),
(109, 89, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 13:22:38', '2025-05-19 13:22:38', NULL, NULL),
(110, 90, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 13:22:38', '2025-05-19 13:22:38', NULL, NULL),
(111, 89, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-19 13:22:43', '2025-05-19 13:22:43', NULL, NULL),
(112, 87, 'ongoing', '23-0001', 'w', 105, 171, '2025-05-19 13:23:01', '2025-05-19 13:23:01', NULL, NULL),
(113, 87, 'completed', '23-0001', 'w', 105, 171, '2025-05-19 13:23:08', '2025-05-19 13:23:08', NULL, NULL),
(114, 90, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-19 13:23:13', '2025-05-19 13:23:13', NULL, NULL),
(115, 89, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-19 13:58:12', '2025-05-19 13:58:12', 1, NULL),
(116, 90, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-19 13:58:20', '2025-05-19 13:58:20', 1, NULL),
(117, 91, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 14:40:08', '2025-05-19 14:40:08', NULL, NULL),
(118, 92, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 14:41:55', '2025-05-19 14:41:55', NULL, NULL),
(119, 93, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 14:42:53', '2025-05-19 14:42:53', NULL, NULL),
(120, 91, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-19 15:13:59', '2025-05-19 15:13:59', NULL, NULL),
(121, 94, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 15:14:52', '2025-05-19 15:14:52', NULL, NULL),
(122, 92, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-19 15:21:42', '2025-05-19 15:21:42', NULL, NULL),
(123, 95, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:01:22', '2025-05-19 16:01:22', NULL, NULL),
(124, 95, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:01:52', '2025-05-19 16:01:52', NULL, NULL),
(125, 95, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-19 16:02:04', '2025-05-19 16:02:04', NULL, NULL),
(126, 95, 'paused', '23-0001', 'e', 82, 171, '2025-05-19 16:02:44', '2025-05-19 16:02:44', NULL, NULL),
(127, 95, 'Paused', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Emily Davis', NULL, NULL, '2025-05-19 16:03:40', '2025-05-19 16:03:40', NULL, NULL),
(128, 95, 'ongoing', '23-0001', 'd', 53, 171, '2025-05-19 16:04:29', '2025-05-19 16:04:29', NULL, NULL),
(129, 95, 'completed', '23-0001', 'f', 82, 171, '2025-05-19 16:04:43', '2025-05-19 16:04:43', NULL, NULL),
(130, 96, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:13:30', '2025-05-19 16:13:30', NULL, NULL),
(131, 97, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:27:20', '2025-05-19 16:27:20', NULL, NULL),
(132, 98, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:29:18', '2025-05-19 16:29:18', NULL, NULL),
(133, 96, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:30:14', '2025-05-19 16:30:14', NULL, NULL),
(134, 97, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:32:27', '2025-05-19 16:32:27', NULL, NULL),
(135, 98, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:32:39', '2025-05-19 16:32:39', NULL, NULL),
(136, 99, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:34:48', '2025-05-19 16:34:48', NULL, NULL),
(137, 99, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:34:53', '2025-05-19 16:34:53', NULL, NULL),
(138, 96, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-19 16:37:09', '2025-05-19 16:37:09', NULL, NULL),
(139, 97, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-19 16:38:43', '2025-05-19 16:38:43', NULL, NULL),
(140, 100, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:38:54', '2025-05-19 16:38:54', NULL, NULL),
(141, 100, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:38:59', '2025-05-19 16:38:59', NULL, NULL),
(142, 101, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:39:32', '2025-05-19 16:39:32', NULL, NULL),
(143, 102, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-19 16:41:49', '2025-05-19 16:41:49', NULL, NULL),
(144, 101, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-19 16:41:58', '2025-05-19 16:41:58', NULL, NULL),
(145, 96, 'paused', '23-0001', 'd', 16, 171, '2025-05-19 16:43:21', '2025-05-19 16:43:21', NULL, NULL),
(146, 97, 'paused', '23-0001', 'c', 53, 171, '2025-05-19 16:43:39', '2025-05-19 16:43:39', NULL, NULL),
(147, 103, 'pending', '23-0002', 'Initial request submission', NULL, NULL, '2025-05-20 03:55:09', '2025-05-20 03:55:09', NULL, NULL),
(148, 104, 'pending', '23-0002', 'Initial request submission', NULL, NULL, '2025-05-20 03:55:11', '2025-05-20 03:55:11', NULL, NULL),
(149, 105, 'pending', '23-0002', 'Initial request submission', NULL, NULL, '2025-05-20 03:55:12', '2025-05-20 03:55:12', NULL, NULL),
(150, 103, 'picked', '23-0002', 'Picked by technician', NULL, NULL, '2025-05-20 03:55:43', '2025-05-20 03:55:43', NULL, NULL),
(151, 102, 'picked', '23-0002', 'Picked by technician', NULL, NULL, '2025-05-20 03:55:49', '2025-05-20 03:55:49', NULL, NULL),
(152, 105, 'picked', '23-0002', 'Picked by technician', NULL, NULL, '2025-05-20 03:55:54', '2025-05-20 03:55:54', NULL, NULL),
(153, 103, 'ongoing', '23-0002', 'Started by technician', NULL, NULL, '2025-05-20 03:56:01', '2025-05-20 03:56:01', 22, NULL),
(154, 102, 'ongoing', '23-0002', 'Started by technician', NULL, NULL, '2025-05-20 03:56:05', '2025-05-20 03:56:05', 22, NULL),
(155, 95, 'evaluated', '1', 'Service request evaluated by client', NULL, NULL, '2025-05-20 04:04:36', '2025-05-20 04:04:36', 1, NULL),
(156, 96, 'ongoing', '23-0001', 'd', 82, 171, '2025-05-20 04:08:49', '2025-05-20 04:08:49', NULL, NULL),
(157, 96, 'completed', '23-0001', 'd', 53, 150, '2025-05-20 04:08:59', '2025-05-20 04:08:59', NULL, NULL),
(158, 103, 'completed', '23-0002', 's', 82, 171, '2025-05-20 04:37:07', '2025-05-20 04:37:07', NULL, NULL),
(159, 102, 'paused', '23-0001', 'WW', 82, 171, '2025-05-20 06:24:04', '2025-05-20 06:24:04', NULL, NULL),
(160, 102, 'ongoing', '23-0001', 'TESTTTT', 16, 171, '2025-05-20 06:24:25', '2025-05-20 06:24:25', NULL, NULL),
(161, 102, 'paused', '23-0001', 'NEWWWW HISTORYYYYYYYNEWWWW HISTORYYYYYYYNEWWWW HISTORYYYYYYYNEWWWW HISTORYYYYYYY', 82, 171, '2025-05-20 06:31:56', '2025-05-20 06:31:56', NULL, NULL),
(162, 102, 'ongoing', '23-0001', ';', 53, 171, '2025-05-20 06:54:52', '2025-05-20 06:54:52', NULL, NULL),
(163, 102, 'completed', '23-0001', 'd', 16, 171, '2025-05-20 06:55:06', '2025-05-20 06:55:06', NULL, NULL),
(164, 99, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-20 07:51:21', '2025-05-20 07:51:21', 1, NULL),
(165, 106, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-20 08:14:38', '2025-05-20 08:14:38', NULL, NULL),
(166, 97, 'ongoing', '23-0001', 'c', 53, 171, '2025-05-20 13:01:13', '2025-05-20 13:01:13', NULL, NULL),
(167, 99, 'completed', '23-0001', 'v', 82, 171, '2025-05-20 13:01:43', '2025-05-20 13:01:43', NULL, NULL),
(168, 97, 'paused', '23-0001', 'r', 53, 171, '2025-05-20 13:02:02', '2025-05-20 13:02:02', NULL, NULL),
(169, 107, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-20 19:21:04', '2025-05-20 19:21:04', NULL, NULL),
(170, 108, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-20 19:21:38', '2025-05-20 19:21:38', NULL, NULL),
(171, 104, 'picked', '23-0001', 'Request picked up by technician', NULL, NULL, '2025-05-20 19:21:57', '2025-05-20 19:21:57', NULL, NULL),
(172, 98, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-20 19:22:04', '2025-05-20 19:22:04', NULL, NULL),
(173, 98, 'paused', '23-0001', 'hhhh', 53, 171, '2025-05-20 19:22:26', '2025-05-20 19:22:26', NULL, NULL),
(174, 100, 'ongoing', '23-0001', 'Request marked as ongoing by technician', NULL, NULL, '2025-05-20 20:00:33', '2025-05-20 20:00:33', NULL, NULL),
(175, 100, 'paused', '23-0001', 'cc', 53, 171, '2025-05-20 20:00:51', '2025-05-20 20:00:51', NULL, NULL),
(176, 97, 'ongoing', '23-0001', 'c', 82, 171, '2025-05-20 20:02:23', '2025-05-20 20:02:23', NULL, NULL),
(177, 97, 'completed', '23-0001', 't', 82, 171, '2025-05-20 20:03:04', '2025-05-20 20:03:04', NULL, NULL),
(178, 98, 'Paused', '23-0001', 'Updated from mobile app Technician assignment updated. Primary: John Doe Secondary: Emily Davis, Laura Garcia', NULL, NULL, '2025-05-20 20:30:06', '2025-05-20 20:30:06', NULL, NULL),
(179, 98, 'ongoing', '23-0001', 'g', 53, 171, '2025-05-20 20:30:44', '2025-05-20 20:30:44', NULL, '/storage/documentation/doc_1747773042_mJD5G2J7vl.jpg'),
(180, 98, 'paused', '23-0001', 'h', 53, 171, '2025-05-20 20:35:42', '2025-05-20 20:35:42', NULL, '/storage/documentation/doc_1747773342_3ChCT4xBw0.jpg'),
(181, 98, 'ongoing', '23-0001', 'g', 53, 171, '2025-05-20 20:39:20', '2025-05-20 20:39:20', NULL, '/storage/documentation/doc_1747773560_SG4nv9gWdP.jpg'),
(182, 107, 'picked', 'PR-003', 'Picked by technician', NULL, NULL, '2025-05-21 04:05:36', '2025-05-21 04:05:36', NULL, NULL),
(183, 107, 'ongoing', 'PR-003', 'Started by technician', NULL, NULL, '2025-05-21 04:10:24', '2025-05-21 04:10:24', 23, NULL),
(184, 107, 'paused', 'PR-003', 'ghghgh', 82, 171, '2025-05-21 04:10:57', '2025-05-21 04:10:57', NULL, NULL),
(185, 107, 'ongoing', 'PR-003', 'back to ongoing', 16, 171, '2025-05-21 04:11:40', '2025-05-21 04:11:40', NULL, NULL),
(186, 107, 'completed', 'PR-003', 'request completed', 53, 171, '2025-05-21 04:12:57', '2025-05-21 04:12:57', NULL, NULL),
(187, 99, 'evaluated', '1', 'Service request evaluated by client', NULL, NULL, '2025-05-21 06:03:01', '2025-05-21 06:03:01', 1, NULL),
(188, 109, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-21 06:03:55', '2025-05-21 06:03:55', NULL, NULL),
(189, 108, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-21 06:37:20', '2025-05-21 06:37:20', NULL, NULL),
(190, 110, 'pending', '23-0001', 'Initial request submission', NULL, NULL, '2025-05-21 06:38:31', '2025-05-21 06:38:31', NULL, NULL),
(191, 110, 'picked', '23-0001', 'Picked by technician', NULL, NULL, '2025-05-21 06:43:47', '2025-05-21 06:43:47', NULL, NULL),
(192, 110, 'ongoing', '23-0001', 'Started by technician', NULL, NULL, '2025-05-21 06:46:10', '2025-05-21 06:46:10', 1, NULL),
(193, 110, 'paused', '23-0001', 'nagbreak nag saglit', 174, 84, '2025-05-21 06:47:14', '2025-05-21 06:47:14', NULL, NULL),
(194, 110, 'ongoing', '23-0001', 'break is finish, contiue request', 174, 199, '2025-05-21 06:48:18', '2025-05-21 06:48:18', NULL, NULL),
(195, 110, 'completed', '23-0001', 'request is completed', 175, 84, '2025-05-21 06:48:46', '2025-05-21 06:48:46', NULL, NULL),
(196, 103, 'evaluated', '1', 'Service request evaluated by client', NULL, NULL, '2025-05-21 06:58:03', '2025-05-21 06:58:03', 1, NULL),
(197, 107, 'evaluated', '1', 'Service request evaluated by client', NULL, NULL, '2025-05-28 16:08:49', '2025-05-28 16:08:49', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `secondarytechnician_request`
--

CREATE TABLE `secondarytechnician_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `technician_emp_id` char(7) DEFAULT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `secondarytechnician_request`
--

INSERT INTO `secondarytechnician_request` (`id`, `technician_emp_id`, `request_id`, `created_at`, `updated_at`) VALUES
(3, 'PR-009', 76, '2025-05-18 07:02:57', '2025-05-18 07:02:57'),
(4, 'PR-009', 84, '2025-05-18 07:16:12', '2025-05-18 07:16:12'),
(23, 'PR-009', 79, '2025-05-18 08:38:42', '2025-05-18 08:38:42'),
(24, '23-0005', 79, '2025-05-18 08:38:42', '2025-05-18 08:38:42'),
(25, '3001', 79, '2025-05-18 08:38:42', '2025-05-18 08:38:42'),
(26, 'PR-010', 79, '2025-05-18 08:38:42', '2025-05-18 08:38:42'),
(29, 'PR-009', 83, '2025-05-18 09:01:50', '2025-05-18 09:01:50'),
(30, '23-0005', 95, '2025-05-19 16:03:40', '2025-05-19 16:03:40'),
(31, '23-0005', 98, '2025-05-20 20:30:06', '2025-05-20 20:30:06'),
(32, 'PR-009', 98, '2025-05-20 20:30:06', '2025-05-20 20:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `requester_id` char(191) NOT NULL,
  `end_user_emp_id` varchar(191) DEFAULT NULL,
  `request_title` varchar(191) DEFAULT NULL,
  `request_description` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `is_notified` tinyint(4) NOT NULL,
  `local_no` varchar(191) DEFAULT NULL,
  `request_doc` date NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `is_complete` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_paused` int(255) DEFAULT 0,
  `sub_category_id` int(255) DEFAULT NULL,
  `request_completion` date DEFAULT NULL,
  `actual_client` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `category_id`, `requester_id`, `end_user_emp_id`, `request_title`, `request_description`, `location`, `is_notified`, `local_no`, `request_doc`, `priority`, `is_complete`, `created_at`, `updated_at`, `is_paused`, `sub_category_id`, `request_completion`, `actual_client`) VALUES
(95, 2, '23-0001', NULL, 'mobile', 'mobile', 'Computer & Peripheral Services', 0, 'mobile', '2025-05-20', 0, 0, '2025-05-20 16:01:22', '2025-05-19 16:01:22', 0, 5, '2025-05-26', 'John Doe'),
(96, 9, '23-0001', NULL, 'w', 's', 'Computer & Peripheral Services', 0, 'mobile', '2025-05-20', 0, 0, '2025-05-19 16:13:30', '2025-05-19 16:13:30', 0, 32, '2025-05-27', NULL),
(98, 2, '23-0001', NULL, 'c', 'c', 'Computer & Peripheral Services', 0, 'hv', '2025-05-20', 0, 0, '2025-05-19 16:29:18', '2025-05-19 16:29:18', 0, 5, '2025-05-27', 'John Doe'),
(99, 1, '23-0001', NULL, 'w', 'w', 'ISD', 0, 'w', '2025-05-20', 0, 0, '2025-05-19 16:34:48', '2025-05-19 16:34:48', 0, 2, NULL, 'w'),
(100, 2, '23-0001', NULL, 'ee', 'e', 'ISD', 0, 'e', '2025-05-20', 0, 0, '2025-05-19 16:38:54', '2025-05-19 16:38:54', 0, 4, NULL, 'e'),
(101, 2, '23-0001', NULL, 'r', 'v', 'Computer & Peripheral Services', 0, 'b', '2025-05-20', 0, 0, '2025-05-19 16:39:32', '2025-05-19 16:39:32', 0, 5, '2025-05-27', 'John Doe'),
(102, 2, '23-0002', NULL, 'r', 'v', 'Computer & Peripheral Services', 0, 'b', '2025-05-20', 0, 0, '2025-05-19 16:41:49', '2025-05-19 16:41:49', 0, 5, '2025-05-27', 'John Doe'),
(103, 1, '23-0002', NULL, 'www', 'ww', 'ISD', 0, 'www', '2025-05-20', 0, 0, '2025-05-31 03:55:08', '2025-05-20 03:55:08', 0, NULL, NULL, 'ww'),
(104, 1, '23-0002', NULL, 'www', 'ww', 'ISD', 0, 'www', '2025-05-20', 0, 0, '2025-05-20 03:55:11', '2025-05-20 03:55:11', 0, NULL, NULL, 'ww'),
(105, 1, '23-0002', NULL, 'www', 'ww', 'ISD', 0, 'www', '2025-05-20', 0, 0, '2025-05-20 03:55:11', '2025-05-20 03:55:11', 0, NULL, NULL, 'ww'),
(106, 2, '23-0001', NULL, 'Q', 'Q', 'ISD', 0, 'Q', '2025-05-20', 0, 0, '2025-05-20 08:14:38', '2025-05-20 08:14:38', 0, 4, NULL, 'Q'),
(107, 1, '23-0001', NULL, 'testlang', 'testlang', 'Computer & Peripheral Services', 0, '110', '2025-05-21', 1, 0, '2025-05-20 19:21:04', '2025-05-20 19:21:04', 0, 2, '2025-05-28', 'Jane Smith'),
(108, 1, '23-0001', NULL, 'b', 'b', 'Computer & Peripheral Services', 0, 'h', '2025-05-21', 0, 0, '2025-05-20 19:21:38', '2025-05-20 19:21:38', 0, 2, '2025-05-28', 'John Doe'),
(109, 1, '23-0001', NULL, 'Account', 'Accounr', 'Software Support', 0, '303', '2025-05-21', 0, 0, '2025-05-21 06:03:55', '2025-05-21 06:03:55', 0, 2, '2025-05-28', 'John Doe'),
(110, 2, '23-0001', NULL, 'qwerty', 'qwerty', 'ISD', 0, '313', '2025-05-21', 0, 0, '2024-05-21 06:38:31', '2024-05-21 06:38:31', 0, 5, '2025-05-22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_request_station`
--

CREATE TABLE `service_request_station` (
  `id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL COMMENT 'LEGENDS  \r\n0- CES \r\nother Number based on lib_station',
  `service_request_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service_request_station`
--

INSERT INTO `service_request_station` (`id`, `station_id`, `service_request_id`, `created_at`, `updated_at`) VALUES
(32, 1, 76, '2025-05-18 06:51:02', '2025-05-18 06:51:02'),
(33, 1, 77, '2025-05-18 06:52:49', '2025-05-18 06:52:49'),
(34, 1, 78, '2025-05-18 06:52:58', '2025-05-18 06:52:58'),
(35, 1, 79, '2025-05-18 06:53:38', '2025-05-18 06:53:38'),
(36, 1, 80, '2025-05-18 06:54:04', '2025-05-18 06:54:04'),
(37, 1, 81, '2025-05-18 06:55:24', '2025-05-18 06:55:24'),
(38, 1, 82, '2025-05-18 06:57:02', '2025-05-18 06:57:02'),
(39, 1, 83, '2025-05-18 06:59:07', '2025-05-18 06:59:07'),
(40, 1, 84, '2025-05-18 06:59:15', '2025-05-18 06:59:15'),
(41, 1, 85, '2025-05-18 06:59:22', '2025-05-18 06:59:22'),
(42, 1, 86, '2025-05-18 10:15:39', '2025-05-18 10:15:39'),
(43, 1, 87, '2025-05-18 10:15:52', '2025-05-18 10:15:52'),
(44, 1, 88, '2025-05-18 10:16:11', '2025-05-18 10:16:11'),
(45, 1, 89, '2025-05-19 13:22:38', '2025-05-19 13:22:38'),
(46, 1, 90, '2025-05-19 13:22:38', '2025-05-19 13:22:38'),
(47, 1, 91, '2025-05-19 14:40:08', '2025-05-19 14:40:08'),
(48, 1, 92, '2025-05-19 14:41:55', '2025-05-19 14:41:55'),
(49, 1, 93, '2025-05-19 14:42:53', '2025-05-19 14:42:53'),
(50, 1, 94, '2025-05-19 15:14:52', '2025-05-19 15:14:52'),
(51, 1, 95, '2025-05-19 16:01:22', '2025-05-19 16:01:22'),
(52, 1, 96, '2025-05-19 16:13:30', '2025-05-19 16:13:30'),
(53, 1, 97, '2025-05-19 16:27:20', '2025-05-19 16:27:20'),
(54, 1, 98, '2025-05-19 16:29:18', '2025-05-19 16:29:18'),
(55, 1, 99, '2025-05-19 16:34:48', '2025-05-19 16:34:48'),
(56, 1, 100, '2025-05-19 16:38:54', '2025-05-19 16:38:54'),
(57, 1, 101, '2025-05-19 16:39:32', '2025-05-19 16:39:32'),
(58, 1, 102, '2025-05-19 16:41:49', '2025-05-19 16:41:49'),
(59, 1, 103, '2025-05-20 03:55:08', '2025-05-20 03:55:08'),
(60, 1, 104, '2025-05-20 03:55:11', '2025-05-20 03:55:11'),
(61, 1, 105, '2025-05-20 03:55:12', '2025-05-20 03:55:12'),
(62, 1, 106, '2025-05-20 08:14:38', '2025-05-20 08:14:38'),
(63, 1, 107, '2025-05-20 19:21:04', '2025-05-20 19:21:04'),
(64, 1, 108, '2025-05-20 19:21:38', '2025-05-20 19:21:38'),
(65, 1, 109, '2025-05-21 06:03:55', '2025-05-21 06:03:55'),
(66, 1, 110, '2025-05-21 06:38:31', '2025-05-21 06:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9reJkOpHecNcvXby1strIKXa7767UtkTj4z2pjFX', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 OPR/117.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmFIN1ZuVm1ncUZwa2hhSWxuMlNlU1VpTWd2SlZ6MmJ6azBKUEFnSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Qvc2VydmljZV90cmFja2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1742354107),
('nySGbMvfLXgIaIK3W3sscxVzZPIfMx1vjqnEQG6j', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 OPR/117.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjgzUThaT0JnV0FsQkxITHdzNGFTejZnT0Nhb3BKUTNNQ1RzVGg3SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Qvc2VydmljZV90cmFja2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1742452648),
('Yfs2hJJ4ufS4kPVZ9QoWtgHQhGsS42LCvjqyUG8g', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM01wQzVMV2s4N3AwaHhNYlpDY0JESlpZc0Z6YWdsTmJ6WklZQU1wdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Qvc2VydmljZV90cmFja2VyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742353930);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `ticket_category` varchar(191) NOT NULL,
  `ticket_year` varchar(191) NOT NULL,
  `ticket_month` varchar(191) NOT NULL,
  `ticket_series` varchar(191) NOT NULL,
  `ticket_full` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `request_id`, `ticket_category`, `ticket_year`, `ticket_month`, `ticket_series`, `ticket_full`, `created_at`, `updated_at`) VALUES
(7350, 95, 'BRS', '2025', '05', '1', 'BRS-2025-05-01', '2025-05-19 16:01:22', '2025-05-19 16:01:22'),
(7351, 96, 'SRS', '2025', '05', '1', 'SRS-2025-05-01', '2025-05-19 16:13:30', '2025-05-19 16:13:30'),
(7352, 97, 'BRS', '2025', '05', '2', 'BRS-2025-05-02', '2025-05-19 16:27:20', '2025-05-19 16:27:20'),
(7353, 98, 'BRS', '2025', '05', '3', 'BRS-2025-05-03', '2025-05-19 16:29:18', '2025-05-19 16:29:18'),
(7354, 99, 'ARS', '2025', '05', '1', 'ARS-2025-05-01', '2025-05-19 16:34:48', '2025-05-19 16:34:48'),
(7355, 100, 'BRS', '2025', '05', '4', 'BRS-2025-05-04', '2025-05-19 16:38:54', '2025-05-19 16:38:54'),
(7356, 101, 'BRS', '2025', '05', '5', 'BRS-2025-05-05', '2025-05-19 16:39:32', '2025-05-19 16:39:32'),
(7357, 102, 'BRS', '2025', '05', '6', 'BRS-2025-05-06', '2025-05-19 16:41:49', '2025-05-19 16:41:49'),
(7358, 103, 'ARS', '2025', '05', '2', 'ARS-2025-05-02', '2025-05-20 03:55:08', '2025-05-20 03:55:08'),
(7359, 104, 'ARS', '2025', '05', '3', 'ARS-2025-05-03', '2025-05-20 03:55:11', '2025-05-20 03:55:11'),
(7360, 105, 'ARS', '2025', '05', '4', 'ARS-2025-05-04', '2025-05-20 03:55:12', '2025-05-20 03:55:12'),
(7361, 106, 'BRS', '2025', '05', '7', 'BRS-2025-05-07', '2025-05-20 08:14:38', '2025-05-20 08:14:38'),
(7362, 107, 'ARS', '2025', '05', '5', 'ARS-2025-05-05', '2025-05-20 19:21:04', '2025-05-20 19:21:04'),
(7363, 108, 'ARS', '2025', '05', '6', 'ARS-2025-05-06', '2025-05-20 19:21:38', '2025-05-20 19:21:38'),
(7364, 109, 'ARS', '2025', '05', '7', 'ARS-2025-05-07', '2025-05-21 06:03:55', '2025-05-21 06:03:55'),
(7365, 110, 'BRS', '2025', '05', '8', 'BRS-2025-05-08', '2025-05-21 06:38:31', '2025-05-21 06:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `philrice_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `philrice_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `archived`) VALUES
(1, 'John Doe', 'johndoe@example.com', '23-0001', NULL, '$2y$10$oX64u6SeoKpRibU.jw/tduckdJnRnDLZjurJTSEQXgZQqd4b9GjNa', NULL, NULL, NULL, 1, 0),
(22, 'John Deer', 'johndeer@example.com', '23-0002', NULL, '$2y$10$5nsP0CFSq9302q/.KpFwiuO1jwMeG449Wj9FNz/GnuswsoDw5WN8q', NULL, NULL, '2025-05-20 04:00:41', 3, 0),
(23, 'Jane Smith', 'janesmith@example.com', 'PR-003', NULL, '$2y$10$jM9rT3uuRVU0LraexsoxzOQaswoxHhcFpAihVXOaHqpe0cJjF07ym', NULL, '2025-03-21 05:18:56', '2025-05-21 04:03:26', 3, 0),
(24, 'Mark Johnson', 'markjohnson@example.com', '23-0003', NULL, '$2y$10$LFKYQhBADm.aufPBOQhK2evour7m68pQBCAGqSzP8Sx3tY/pSZJp6', NULL, '2025-03-21 05:18:56', '2025-05-12 23:02:41', 3, 0),
(25, 'Emily Davis', 'emilydavis@example.com', '23-0005', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:18:56', '2025-03-21 05:18:56', 2, 0),
(31, 'Michael Brown', 'michaelbrown@example.com', 'PR-006', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 3, 0),
(32, 'Sarah Wilson', 'sarahwilson@example.com', 'PR-007', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 3, 0),
(33, 'Daniel Martinez', 'danielmartinez@example.com', 'PR-008', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 4, 0),
(34, 'Laura Garcia', 'lauragarcia@example.com', 'PR-009', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-05-04 17:45:03', 3, 0),
(35, 'James Anderson', 'jamesanderson@example.com', 'PR-010', NULL, '$2y$10$e3WM8wyhziWMRw2tdPuYzuuaArrjDeEd43ZvehxnV9hWOPOTS7QEq', NULL, '2025-03-21 05:23:49', '2025-05-15 06:17:28', 3, 0),
(37, 'Technician 1', 'tech1@example.com', 'PR-002', NULL, '$2y$10$Q4YK7/rMjz/TaVd8shJowOkZ9P62tcrywR.ynEpeSvkhyRskhkQ/O', NULL, '2025-03-23 21:50:00', '2025-03-23 14:11:41', 2, 0),
(38, 'Technician 2', 'tech2@example.com', '2002', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-23 21:50:00', '2025-03-23 21:50:00', 2, 0),
(39, 'Regular User', 'user@example.com', '3001', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-23 21:50:00', '2025-03-23 21:50:00', 3, 0),
(40, 'UserPoAko', 'userako@gmail.com', '23-0012', NULL, 'pass123', NULL, NULL, NULL, 5, 0),
(41, 'Test User', 'testuser@example.com', '23-0013', NULL, '$2y$10$oX64u6SeoKpRibU.jw/tduckdJnRnDLZjurJTSEQXgZQqd4b9GjNa', NULL, '2025-05-15 06:04:59', '2025-05-15 06:04:59', 5, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `evaluation_ratings`
--
ALTER TABLE `evaluation_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_ratings_evaluation_id_foreign` (`evaluation_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_actions_taken`
--
ALTER TABLE `lib_actions_taken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id_actions_taken` (`category_id`);

--
-- Indexes for table `lib_approvers`
--
ALTER TABLE `lib_approvers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_categories`
--
ALTER TABLE `lib_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_common_problems`
--
ALTER TABLE `lib_common_problems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_contact_types`
--
ALTER TABLE `lib_contact_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_expertise`
--
ALTER TABLE `lib_expertise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_idno` (`user_idno`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `lib_findings_recommendations`
--
ALTER TABLE `lib_findings_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lib_findings_recommendations_incident_report_id_foreign` (`incident_report_id`);

--
-- Indexes for table `lib_incident_reports`
--
ALTER TABLE `lib_incident_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lib_incident_reports_reporter_id_foreign` (`reporter_id`),
  ADD KEY `lib_incident_reports_verifier_id_foreign` (`verifier_id`),
  ADD KEY `lib_incident_reports_approver_id_foreign` (`approver_id`);

--
-- Indexes for table `lib_log_status`
--
ALTER TABLE `lib_log_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_problems_encountered`
--
ALTER TABLE `lib_problems_encountered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `lib_roles`
--
ALTER TABLE `lib_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_station`
--
ALTER TABLE `lib_station`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_status`
--
ALTER TABLE `lib_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_sub_categories`
--
ALTER TABLE `lib_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_technicians`
--
ALTER TABLE `lib_technicians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_verifiers`
--
ALTER TABLE `lib_verifiers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_to_clients`
--
ALTER TABLE `message_to_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `primarytechnician_request`
--
ALTER TABLE `primarytechnician_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `primarytechnician_request_request_id_foreign` (`request_id`);

--
-- Indexes for table `request_log`
--
ALTER TABLE `request_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_log_request_id_foreign` (`request_id`),
  ADD KEY `request_log_log_status_id_foreign` (`log_status_id`);

--
-- Indexes for table `request_log_station`
--
ALTER TABLE `request_log_station`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `request_problems`
--
ALTER TABLE `request_problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_problems_request_id_foreign` (`request_id`),
  ADD KEY `request_problems_problem_id_foreign` (`problem_id`);

--
-- Indexes for table `request_problem_encountered`
--
ALTER TABLE `request_problem_encountered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_problem_encountered_request_id_foreign` (`request_id`),
  ADD KEY `request_problem_encountered_encountered_problem_id_foreign` (`encountered_problem_id`);

--
-- Indexes for table `request_serialnumber`
--
ALTER TABLE `request_serialnumber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_status`
--
ALTER TABLE `request_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_status_request_id_foreign` (`request_id`),
  ADD KEY `request_status_status_id_foreign` (`status_id`);

--
-- Indexes for table `request_status_history`
--
ALTER TABLE `request_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_status_history_request_id_index` (`request_id`),
  ADD KEY `request_status_history_changed_by_index` (`changed_by`),
  ADD KEY `request_status_history_problem_id_index` (`problem_id`),
  ADD KEY `request_status_history_action_id_index` (`action_id`),
  ADD KEY `fk_request_status_history_created_by` (`created_by`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `secondarytechnician_request`
--
ALTER TABLE `secondarytechnician_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `secondarytechnician_request_request_id_foreign` (`request_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_request_station`
--
ALTER TABLE `service_request_station`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_request_id` (`service_request_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_request_id_foreign` (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `philrice_id` (`philrice_id`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation_ratings`
--
ALTER TABLE `evaluation_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `evaluation_request`
--
ALTER TABLE `evaluation_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6807;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lib_actions_taken`
--
ALTER TABLE `lib_actions_taken`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `lib_approvers`
--
ALTER TABLE `lib_approvers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lib_categories`
--
ALTER TABLE `lib_categories`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lib_common_problems`
--
ALTER TABLE `lib_common_problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `lib_contact_types`
--
ALTER TABLE `lib_contact_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lib_expertise`
--
ALTER TABLE `lib_expertise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lib_findings_recommendations`
--
ALTER TABLE `lib_findings_recommendations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lib_incident_reports`
--
ALTER TABLE `lib_incident_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lib_log_status`
--
ALTER TABLE `lib_log_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `lib_problems_encountered`
--
ALTER TABLE `lib_problems_encountered`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `lib_roles`
--
ALTER TABLE `lib_roles`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lib_station`
--
ALTER TABLE `lib_station`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lib_status`
--
ALTER TABLE `lib_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `lib_sub_categories`
--
ALTER TABLE `lib_sub_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `lib_technicians`
--
ALTER TABLE `lib_technicians`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lib_verifiers`
--
ALTER TABLE `lib_verifiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message_to_clients`
--
ALTER TABLE `message_to_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `primarytechnician_request`
--
ALTER TABLE `primarytechnician_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `request_log`
--
ALTER TABLE `request_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_log_station`
--
ALTER TABLE `request_log_station`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_problems`
--
ALTER TABLE `request_problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8265;

--
-- AUTO_INCREMENT for table `request_problem_encountered`
--
ALTER TABLE `request_problem_encountered`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5706;

--
-- AUTO_INCREMENT for table `request_serialnumber`
--
ALTER TABLE `request_serialnumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7637;

--
-- AUTO_INCREMENT for table `request_status_history`
--
ALTER TABLE `request_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `secondarytechnician_request`
--
ALTER TABLE `secondarytechnician_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `service_request_station`
--
ALTER TABLE `service_request_station`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7366;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evaluation_ratings`
--
ALTER TABLE `evaluation_ratings`
  ADD CONSTRAINT `evaluation_ratings_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation_request` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lib_actions_taken`
--
ALTER TABLE `lib_actions_taken`
  ADD CONSTRAINT `fk_category_id_actions_taken` FOREIGN KEY (`category_id`) REFERENCES `lib_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lib_findings_recommendations`
--
ALTER TABLE `lib_findings_recommendations`
  ADD CONSTRAINT `lib_findings_recommendations_incident_report_id_foreign` FOREIGN KEY (`incident_report_id`) REFERENCES `lib_incident_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lib_incident_reports`
--
ALTER TABLE `lib_incident_reports`
  ADD CONSTRAINT `lib_incident_reports_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lib_incident_reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lib_incident_reports_verifier_id_foreign` FOREIGN KEY (`verifier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lib_problems_encountered`
--
ALTER TABLE `lib_problems_encountered`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `lib_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `primarytechnician_request`
--
ALTER TABLE `primarytechnician_request`
  ADD CONSTRAINT `primarytechnician_request_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `service_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_log`
--
ALTER TABLE `request_log`
  ADD CONSTRAINT `request_log_log_status_id_foreign` FOREIGN KEY (`log_status_id`) REFERENCES `lib_log_status` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `request_log_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `service_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_log_station`
--
ALTER TABLE `request_log_station`
  ADD CONSTRAINT `request_log_station_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `request_log` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_status_history`
--
ALTER TABLE `request_status_history`
  ADD CONSTRAINT `fk_request_status_history_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `lib_roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
