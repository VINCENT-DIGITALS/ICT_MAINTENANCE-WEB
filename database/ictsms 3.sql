-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 07:47 AM
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
(2, 5, 'iikikik', 'okikkikiik', '2025-05-14 02:52:22', '2025-05-14 02:52:22');

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
(6, 'try try lang naman po', '2025-05-13 04:58:58', 'testing', 'subject testing', 'testing lang toh ng incident na galing kay john deer', 23, 'John Deer', NULL, NULL, NULL, NULL, NULL, 'High', 'Not Resolved', '2025-05-13 15:00:00', 'PhilRice CES', 'malaking impact', 'lahtat kami sa office', NULL, NULL, '2025-05-12 20:58:58', '2025-05-12 20:58:58'),
(7, 'fefefe', '2025-05-14 10:18:16', 'fefef', 'fefefe', 'fefefef', 23, 'John Deer', NULL, 1, 'John benedict', 1, 'John Vincent', 'High', 'Resolved', '2025-05-14 13:18:00', 'PhilRice CES', 'fefefe', 'fefefef', NULL, NULL, '2025-05-14 02:18:16', '2025-05-14 02:36:22'),
(10, 'qwertyui', '2025-05-14 10:31:31', 'qwertt', 'qwertt', 'qwertyu', 1, 'John Deer', NULL, NULL, 'Carlos Garcia', NULL, 'Klierte Hoson', 'Low', 'Not Resolved', '2025-05-14 15:28:00', 'PhilRice Negros', '12345678', 'qwertyujkmnffg', NULL, NULL, '2025-05-14 02:31:31', '2025-05-14 02:31:31'),
(11, '12345', '2025-05-14 10:33:21', '123456', '12345', '12345', 1, 'John Deer', NULL, NULL, 'qwerty', NULL, 'wasd', 'Normal', 'Not Resolved', '2025-05-14 23:33:00', 'PhilRice CES', '12345', '1234', NULL, NULL, '2025-05-14 02:33:21', '2025-05-14 02:33:21'),
(12, 'dawdawdasda', '2025-05-14 10:36:52', 'dawdawda', 'dawdawda', 'dawdadawd', 1, 'John Deer', NULL, NULL, 'sdawdawd', NULL, 'dasdawdadw', 'Low', 'Not Resolved', '2025-05-12 23:36:00', 'PhilRice CES', 'asdawdad', 'asdawdawda', NULL, NULL, '2025-05-14 02:36:52', '2025-05-14 02:36:52'),
(13, 'dawdasda', '2025-05-14 10:40:48', 'destroy', 'destroy', 'awdawdadw', 1, 'John Deer', NULL, NULL, 'Sarah G', NULL, 'Joselito H.', 'Low', 'Not Resolved', '2025-05-14 23:40:00', 'PhilRice CES', 'qw12dqwd', '12e1wd1de', NULL, NULL, '2025-05-14 02:40:48', '2025-05-14 02:40:48'),
(14, 'dasdawdasdawdawdwq', '2025-05-14 10:50:45', 'dasdawdawdawdas', 'dawdasdawdadaw', 'dasdawdadawdad', 1, 'John Deer', NULL, NULL, 'Turnicate Arrow', NULL, 'Qwerty Wasd', 'Normal', 'Not Resolved', '2025-05-15 15:50:00', 'PhilRice CES', 'werwerwerwe', 'rwfwerwerwer', NULL, NULL, '2025-05-14 02:50:45', '2025-05-14 02:50:45'),
(15, 'fwefwe', '2025-05-14 16:04:00', 'testing', NULL, 'dfefa', 1, 'John Doe', NULL, NULL, 'zeckiel peralta', NULL, 'John Vincent', 'Normal', 'Not Resolved', '2025-05-13 18:03:00', 'PhilRice CES', 'fwwefwef', 'ewfwefwefw', NULL, NULL, '2025-05-14 08:04:00', '2025-05-14 08:04:00'),
(16, 'dasdawd', '2025-05-14 16:04:41', 'dasdawda', 'dasawdawd', 'addawdad', 1, 'Mark Johnson', NULL, NULL, 'Vincent Macayanan', NULL, 'Zeckiel Peralta', 'Normal', 'Not Resolved', '2025-05-15 18:04:00', 'PhilRice CES', 'dasdawd', 'asdawdaw', NULL, NULL, '2025-05-14 08:04:41', '2025-05-14 08:04:41');

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
(7, '3001', '2025-05-04 17:45:51', '2025-05-04 17:45:51');

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
(1, 1, 1, 1, NULL, 'ongoing', 'CCTV REVIEWS', 'FF', 0, '2025-05-01 16:38:09', '2025-05-01 16:38:09'),
(2, 8, 1, 24, 'TRS-2019-06-01', 'ongoing', 'CCTV REVIEW', 'GG', 0, '2025-05-01 16:38:42', '2025-05-01 16:38:42'),
(3, 8, 1, 24, 'TRS-2019-06-01', 'ongoing', 'CCTV REVIEW', 'DDDD', 0, '2025-05-01 16:38:56', '2025-05-01 16:38:56'),
(4, 12, 1, 22, 'CTR-2019-06-04', 'completed', 'CCTV REVIEWS', 'SSS', 0, '2025-05-01 16:39:11', '2025-05-01 16:39:11');

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
(11, 'App\\Models\\User', 1, 'mobile_token', '0273f9f993fd41895a7c8fd33e5d33f51485d0aae0f8c4c2a8a2de8a31446ea2', '[\"*\"]', NULL, NULL, '2025-04-29 17:40:06', '2025-04-29 17:40:06');

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
(4, '23-0001', 8, '2025-04-13 18:35:35', '2025-04-13 18:35:35'),
(5, '23-0001', 40, '2025-04-13 18:48:48', '2025-04-13 18:48:48'),
(6, '23-0001', 16, '2025-04-25 00:01:56', '2025-04-25 00:01:56'),
(7, '23-0001', 45, '2025-04-25 00:02:13', '2025-04-25 00:02:13'),
(8, '23-0001', 46, '2025-04-25 00:02:26', '2025-04-25 00:02:26'),
(9, '23-0001', 24, '2025-04-29 23:43:01', '2025-04-29 23:43:01'),
(10, '23-0001', 32, '2025-04-29 23:43:13', '2025-04-29 23:43:13'),
(11, '23-0001', 48, '2025-05-04 17:19:56', '2025-05-04 17:19:56'),
(12, '23-0001', 47, '2025-05-06 18:19:29', '2025-05-06 18:19:29'),
(13, '23-0001', 49, '2025-05-06 20:11:40', '2025-05-06 20:11:40'),
(14, '23-0001', 50, '2025-05-07 19:01:58', '2025-05-07 19:01:58'),
(15, '23-0001', 51, '2025-05-07 19:46:55', '2025-05-07 19:46:55'),
(16, '23-0001', 52, '2025-05-07 19:48:51', '2025-05-07 19:48:51'),
(17, '23-0001', 53, '2025-05-07 22:55:14', '2025-05-07 22:55:14'),
(18, '23-0001', 54, '2025-05-12 17:08:05', '2025-05-12 17:08:05'),
(19, '23-0001', 55, '2025-05-12 17:08:13', '2025-05-12 17:08:13'),
(20, '23-0001', 56, '2025-05-12 17:14:53', '2025-05-12 17:14:53'),
(21, '23-0001', 57, '2025-05-12 22:40:41', '2025-05-12 22:40:41'),
(22, '23-0002', 59, '2025-05-14 01:10:21', '2025-05-14 01:10:21'),
(23, '23-0001', 58, '2025-05-14 05:25:47', '2025-05-14 05:25:47');

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
(7508, 1, 7, '2025-04-14 02:16:59', '2025-05-04 22:55:02'),
(7509, 2, 7, '2025-04-14 02:16:59', '2025-05-06 20:27:17'),
(7510, 3, 100, '2025-04-14 02:16:59', '2025-05-04 19:52:40'),
(7511, 4, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7512, 5, 8, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7513, 6, 100, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7514, 7, 200, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7515, 8, 7, '2025-04-14 02:16:59', '2025-05-05 00:30:42'),
(7516, 9, 200, '2025-04-14 02:16:59', '2025-05-05 00:38:24'),
(7517, 10, 7, '2025-04-14 02:16:59', '2025-05-06 20:29:14'),
(7518, 11, 200, '2025-04-14 02:16:59', '2025-05-07 19:34:57'),
(7519, 12, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7520, 13, 8, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7521, 14, 100, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7522, 15, 200, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7523, 16, 6, '2025-04-14 02:16:59', '2025-05-04 22:43:34'),
(7524, 17, 200, '2025-04-14 02:16:59', '2025-05-06 20:17:20'),
(7525, 18, 6, '2025-04-14 02:16:59', '2025-05-06 19:56:52'),
(7526, 19, 6, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7527, 20, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7528, 21, 8, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7529, 22, 100, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7530, 23, 200, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7531, 24, 5, '2025-04-14 02:16:59', '2025-05-14 05:17:55'),
(7532, 25, 7, '2025-04-14 02:16:59', '2025-05-06 20:13:59'),
(7533, 26, 6, '2025-04-14 02:16:59', '2025-05-07 18:59:35'),
(7534, 27, 6, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7535, 28, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7536, 29, 8, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7537, 30, 100, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7538, 31, 200, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7539, 32, 3, '2025-04-14 02:16:59', '2025-04-29 23:43:13'),
(7540, 33, 7, '2025-04-14 02:16:59', '2025-05-12 22:53:44'),
(7541, 34, 5, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7542, 35, 5, '2025-04-14 02:16:59', '2025-05-07 19:00:26'),
(7543, 36, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7544, 37, 8, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7545, 38, 100, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7546, 39, 200, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7547, 40, 3, '2025-04-14 02:16:59', '2025-04-13 18:48:48'),
(7548, 41, 7, '2025-04-14 02:16:59', '2025-05-06 20:23:53'),
(7549, 42, 7, '2025-04-14 02:16:59', '2025-05-04 19:53:41'),
(7550, 43, 7, '2025-04-14 02:16:59', '2025-05-04 19:53:16'),
(7551, 44, 7, '2025-04-14 02:16:59', '2025-04-14 02:16:59'),
(7571, 45, 7, '2025-04-13 18:18:32', '2025-05-06 20:09:53'),
(7572, 46, 200, '2025-04-13 18:28:31', '2025-05-05 00:31:19'),
(7573, 47, 7, '2025-05-04 17:18:59', '2025-05-06 20:08:00'),
(7574, 48, 8, '2025-05-04 17:19:26', '2025-05-05 00:31:02'),
(7575, 49, 7, '2025-05-05 20:12:08', '2025-05-06 20:12:18'),
(7576, 50, 7, '2025-05-07 19:01:47', '2025-05-07 19:04:45'),
(7577, 51, 200, '2025-05-07 19:46:48', '2025-05-07 19:47:32'),
(7578, 52, 100, '2025-05-07 19:48:46', '2025-05-07 19:49:26'),
(7579, 53, 200, '2025-05-07 22:55:03', '2025-05-12 23:59:22'),
(7580, 54, 3, '2025-05-08 18:29:00', '2025-05-12 17:08:05'),
(7581, 55, 5, '2025-05-08 18:34:32', '2025-05-12 17:18:19'),
(7582, 56, 3, '2025-05-12 17:09:45', '2025-05-12 17:14:53'),
(7583, 57, 3, '2025-05-12 22:40:15', '2025-05-12 22:40:41'),
(7584, 58, 3, '2025-05-13 16:45:37', '2025-05-14 05:25:47'),
(7585, 59, 3, '2025-05-13 16:56:40', '2025-05-14 01:10:21'),
(7586, 60, 1, '2025-05-13 17:05:17', '2025-05-13 17:05:17'),
(7587, 61, 8, '2025-05-14 05:01:39', '2025-05-14 05:01:39'),
(7588, 62, 8, '2025-05-14 05:37:38', '2025-05-14 05:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `request_status_history`
--

CREATE TABLE `request_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'ongoing, paused, denied, cancelled, completed',
  `changed_by` bigint(20) UNSIGNED NOT NULL,
  `remarks` text DEFAULT NULL,
  `problem_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_status_history`
--

INSERT INTO `request_status_history` (`id`, `request_id`, `status`, `changed_by`, `remarks`, `problem_id`, `action_id`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 2, 'paused', 1, 'dwdwdw', 53, 171, '2025-05-04 22:52:24', '2025-05-04 22:52:24', NULL),
(2, 1, 'completed', 1, 'completed na toh', 150, 161, '2025-05-04 22:55:02', '2025-05-04 22:55:02', NULL),
(3, 2, 'ongoing', 1, 'ongoing ulit', 53, 171, '2025-05-04 22:59:24', '2025-05-04 22:59:24', NULL),
(4, 8, 'completed', 1, NULL, NULL, NULL, '2025-05-05 00:30:42', '2025-05-05 00:30:42', NULL),
(5, 48, 'completed', 1, NULL, NULL, NULL, '2025-05-05 00:31:02', '2025-05-05 00:31:02', NULL),
(6, 46, 'Cancelled', 1, NULL, NULL, NULL, '2025-05-05 00:31:19', '2025-05-05 00:31:19', NULL),
(7, 9, 'Cancelled', 1, NULL, NULL, NULL, '2025-05-05 00:38:24', '2025-05-05 00:38:24', NULL),
(8, 2, 'ongoing', 1, NULL, NULL, NULL, '2025-05-05 21:09:15', '2025-05-05 21:09:15', NULL),
(9, 2, 'paused', 1, NULL, NULL, NULL, '2025-05-06 19:39:32', '2025-05-06 19:39:32', NULL),
(10, 18, 'paused', 1, NULL, NULL, NULL, '2025-05-06 19:56:52', '2025-05-06 19:56:52', NULL),
(11, 45, 'ongoing', 1, NULL, NULL, NULL, '2025-05-06 19:57:01', '2025-05-06 19:57:01', NULL),
(12, 17, 'Cancelled', 1, 'k fibe', 242, 171, '2025-05-06 20:17:20', '2025-05-06 20:17:20', NULL),
(13, 41, 'ongoing', 23, 'dedeed', 237, 73, '2025-05-06 20:23:25', '2025-05-06 20:23:25', NULL),
(14, 2, 'ongoing', 23, 'kkkk', 53, 171, '2025-05-06 20:26:48', '2025-05-06 20:26:48', NULL),
(15, 2, 'completed', 23, 'done with modifications as well', 175, 84, '2025-05-06 20:27:17', '2025-05-06 20:27:17', 23),
(16, 10, 'ongoing', 23, 'lll', 53, 171, '2025-05-06 20:29:02', '2025-05-06 20:29:02', NULL),
(17, 10, 'completed', 23, 'iii', 242, 171, '2025-05-06 20:29:14', '2025-05-06 20:29:14', 23),
(18, 26, 'paused', 23, 'paused muna ito', 242, 171, '2025-05-07 18:59:35', '2025-05-07 18:59:35', NULL),
(19, 35, 'ongoing', 23, 'balik sa ongoing?', 242, 171, '2025-05-07 19:00:26', '2025-05-07 19:00:26', NULL),
(20, 50, 'paused', 23, 'paused ito saglit', 237, 74, '2025-05-07 19:03:29', '2025-05-07 19:03:29', NULL),
(21, 50, 'ongoing', 23, 'balik on going', 237, 74, '2025-05-07 19:04:18', '2025-05-07 19:04:18', NULL),
(22, 50, 'completed', 23, 'completed na ito', 237, 74, '2025-05-07 19:04:45', '2025-05-07 19:04:45', 23),
(23, 11, 'Cancelled', 1, 'cancelled na itoh', 242, 171, '2025-05-07 19:34:57', '2025-05-07 19:34:57', NULL),
(24, 51, 'Cancelled', 1, 'biglang gumana ehhh', 118, 15, '2025-05-07 19:47:32', '2025-05-07 19:47:32', NULL),
(25, 52, 'Denied', 1, 'you shall not passsssssssssssss', 53, 171, '2025-05-07 19:49:26', '2025-05-07 19:49:26', NULL),
(26, 33, 'completed', 23, 'fhf', 10, 171, '2025-05-12 22:53:44', '2025-05-12 22:53:44', 23),
(27, 53, 'cancelled', 1, 'AYAW KO NA', 242, 171, '2025-05-12 23:59:22', '2025-05-12 23:59:22', NULL);

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
  `request_completion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `category_id`, `requester_id`, `end_user_emp_id`, `request_title`, `request_description`, `location`, `is_notified`, `local_no`, `request_doc`, `priority`, `is_complete`, `created_at`, `updated_at`, `is_paused`, `sub_category_id`, `request_completion`) VALUES
(1, 2, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-02-11 17:21:30', '2025-02-14 02:15:45', 0, 1, NULL),
(2, 2, '23-0002', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-10 09:46:03', '2025-03-13 23:17:45', 1, 1, NULL),
(3, 3, '23-0003', NULL, 'ZCCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-04-03 02:19:58', '2025-04-13 19:15:45', 0, 1, NULL),
(4, 2, '23-0004', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-06 00:33:59', '2025-03-14 03:17:45', 1, 1, NULL),
(5, 2, '23-0005', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-05 08:26:14', '2025-03-13 19:17:45', 1, 1, NULL),
(6, 2, '23-0001', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-07 18:58:07', '2025-03-14 03:17:45', 1, 1, NULL),
(7, 2, '23-0002', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-07 11:14:08', '2025-03-13 20:17:45', 1, 1, NULL),
(8, 2, '23-0003', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-12 13:45:13', '2025-03-13 20:17:45', 1, 1, NULL),
(9, 2, '23-0004', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-03-03 11:12:37', '2025-03-13 20:17:45', 1, 1, NULL),
(10, 2, '23-0005', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-01-12 03:36:20', '2025-01-13 22:17:45', 1, 1, NULL),
(11, 2, '23-0001', NULL, 'CCTV REVIEW', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 2, '2025-01-13 01:32:45', '2025-01-13 23:17:45', 1, 1, NULL),
(12, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-03 09:48:17', '2025-02-14 04:15:45', 0, 1, NULL),
(13, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-09 02:20:05', '2025-02-13 22:15:45', 0, 1, NULL),
(14, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-10 17:13:07', '2025-02-14 03:15:45', 0, 1, NULL),
(15, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-11 06:49:35', '2025-02-13 21:15:45', 0, 1, NULL),
(16, 1, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-11 06:12:48', '2025-02-14 00:15:45', 0, 1, NULL),
(17, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-07 22:19:29', '2025-02-13 21:15:45', 0, 1, NULL),
(18, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-04 01:29:58', '2025-02-14 00:15:45', 0, 1, NULL),
(19, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-05 01:48:55', '2025-02-13 19:15:45', 0, 1, NULL),
(20, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-11 20:05:38', '2025-02-14 01:15:45', 0, 1, NULL),
(21, 1, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-06 03:12:19', '2025-02-14 04:15:45', 0, 1, NULL),
(22, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-03 18:02:13', '2025-02-14 04:15:45', 0, 1, NULL),
(23, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-09 05:51:46', '2025-02-14 02:15:45', 0, 1, NULL),
(24, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-09 07:09:42', '2025-02-13 20:15:45', 0, 1, NULL),
(25, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-05 17:57:28', '2025-02-13 22:15:45', 0, 1, NULL),
(26, 1, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-09 20:35:48', '2025-02-13 23:15:45', 0, 1, NULL),
(27, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 0, '2025-02-06 07:04:12', '2025-02-13 21:15:45', 0, 1, NULL),
(28, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-11 15:51:11', '2025-02-14 03:15:45', 0, 1, NULL),
(29, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-12 19:00:53', '2025-02-13 23:15:45', 0, 1, NULL),
(30, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-04 01:28:25', '2025-02-14 02:15:45', 0, 1, NULL),
(31, 1, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-13 14:10:21', '2025-02-13 22:15:45', 0, 1, NULL),
(32, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-07 15:50:46', '2025-02-13 23:15:45', 0, 1, NULL),
(33, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-06 13:00:19', '2025-02-13 22:15:45', 0, 1, NULL),
(34, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-07 10:00:14', '2025-02-13 20:15:45', 0, 1, NULL),
(35, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-04 03:44:28', '2025-02-14 03:15:45', 0, 1, NULL),
(36, 1, '23-0001', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-06 14:59:12', '2025-02-14 02:15:45', 0, 1, NULL),
(37, 1, '23-0002', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-06 09:26:52', '2025-02-13 19:15:45', 0, 1, NULL),
(38, 1, '23-0003', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-10 17:47:38', '2025-02-13 19:15:45', 0, 1, NULL),
(39, 1, '23-0004', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 3, '2025-02-09 06:35:06', '2025-02-13 22:15:45', 0, 1, NULL),
(40, 1, '23-0005', NULL, 'CCTV REVIEWS', 'CCTV REVIEW AT DIVISION TV', 'ISD', 0, '313', '2019-08-09', 0, 1, '2025-02-11 11:03:32', '2025-02-13 23:15:45', 0, 1, NULL),
(41, 1, '23-0001', NULL, 'NEW ACCOUNT', 'NEW ACCOUNTSSSSSSSSSSSSS', 'ISD Office, 2nd Floor, Main Bldg.', 0, '099', '2025-04-08', 0, 1, '2025-04-07 09:38:05', '2025-04-07 09:38:05', 0, NULL, NULL),
(42, 11, '23-0001', NULL, 'SEMIANR', 'SEMIANRSEMIANRSEMIANRSEMIANRSEMIANR', 'ISD Office, 2nd Floor, Main Bldg.', 0, '099', '2025-04-08', 0, 0, '2025-04-07 09:40:18', '2025-04-07 09:40:18', 0, NULL, NULL),
(43, 1, '23-0001', NULL, 'NEW ACCOUNT', 'NEW ACCOUNT', 'ISD Office, 2nd Floor, Main Bldg.', 0, '099', '2025-04-08', 0, 0, '2025-04-07 10:20:11', '2025-04-07 10:20:11', 0, 1, NULL),
(44, 1, '23-0001', NULL, 'ZNEW ACCOUNT', 'ZNEW ACCOUNT', 'ISD Office, 2nd Floor, Main Bldg.', 0, '099', '2025-04-08', 0, 0, '2025-04-07 10:21:11', '2025-04-07 10:21:11', 0, 1, NULL),
(45, 10, '23-0001', NULL, 'w', 'ww', 'ISD Office, 2nd Floor, Main Bldg.', 0, 'ww', '2025-04-14', 0, 0, '2025-04-13 18:18:32', '2025-04-13 18:18:32', 0, 33, NULL),
(46, 7, '23-0001', NULL, 'w', 'w', 'ISD Office, 2nd Floor, Main Bldg.', 0, 'w', '2025-04-14', 0, 0, '2025-04-13 18:28:31', '2025-04-13 18:28:31', 0, 25, NULL),
(47, 1, '23-0001', NULL, 'dadad', 'pending muna toh', 'ISD Office, 2nd Floor, Main Bldg.', 0, '09452538387', '2025-05-05', 0, 0, '2025-05-04 17:18:59', '2025-05-04 17:18:59', 0, 2, NULL),
(48, 5, '23-0001', NULL, 'dadad', 'install baket', 'ISD Office, 2nd Floor, Main Bldg.', 0, '09452538387', '2025-05-05', 0, 0, '2025-05-04 17:19:26', '2025-05-04 17:19:26', 0, 20, NULL),
(49, 1, '23-0001', NULL, 'j', 'j', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-06', 0, 0, '2025-05-05 20:12:08', '2025-05-05 20:12:08', 0, 1, NULL),
(50, 1, '23-0001', NULL, 'Cant open my account', 'i opened it yesterday, but now, cant', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-08', 0, 0, '2025-05-07 19:01:47', '2025-05-07 19:01:47', 0, 2, NULL),
(51, 10, '23-0001', NULL, 'fix my telepon', 'sira yung telpono', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-08', 0, 0, '2025-05-07 19:46:48', '2025-05-07 19:46:48', 0, 34, NULL),
(52, 11, '23-0001', NULL, 'aaaaaaaaaaaaaaa', 'hehe', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-08', 0, 0, '2025-05-07 19:48:46', '2025-05-07 19:48:46', 0, 38, NULL),
(53, 6, '23-0001', NULL, 'install brand new printer', 'i have bought a new printer, L250, please help me install it', 'ISD Office, 2nd Floor, Main Bldg.', 0, '331', '2025-05-08', 0, 0, '2025-05-07 22:55:03', '2025-05-07 22:55:03', 0, 23, NULL),
(54, 3, '23-0001', NULL, 'backup my google drive', 'testing lang toh', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-09', 0, 0, '2025-05-08 18:29:00', '2025-05-08 18:29:00', 0, 10, NULL),
(55, 10, '23-0001', NULL, 'fix my telepon', 'fefefefe', 'ISD Office, 2nd Floor, Main Bldg.', 0, NULL, '2025-05-09', 0, 0, '2025-05-08 18:34:32', '2025-05-08 18:34:32', 0, 35, '2025-05-15'),
(56, 3, '23-0001', NULL, 'install webcam on pc please', 'mag install ng webcam para makapag vc kami ni bebe ko', 'ISD Office, 2nd Floor, Main Bldg.', 0, '313', '2025-05-13', 0, 0, '2025-05-12 17:09:45', '2025-05-12 17:09:45', 0, 9, '2025-05-14'),
(57, 1, '23-0001', NULL, 'account', 'account lagay', 'ISD Office, 2nd Floor, Main Bldg.', 0, '313', '2025-05-13', 0, 0, '2025-05-12 22:40:15', '2025-05-12 22:40:15', 0, 2, '2025-05-15'),
(58, 1, '23-0001', NULL, 'Cant open my account', 'hakdog talaga', 'ISD Office, 2nd Floor, Main Bldg.', 0, '221', '2025-05-14', 0, 0, '2025-05-13 16:45:37', '2025-05-13 16:45:37', 0, 3, '2025-05-14'),
(59, 7, '23-0001', NULL, 'broken adapter', 'mice have eaten the chord of my adapter and needed to be fixed', 'ISD Office, 2nd Floor, Main Bldg.', 0, '313', '2025-05-14', 0, 0, '2025-05-13 16:56:40', '2025-05-13 16:56:40', 0, 24, '2025-05-14'),
(60, 5, '23-0001', NULL, 'install cctv', 'install cctv here in the opis', 'ISD Office, 2nd Floor, Main Bldg.', 0, '221', '2025-05-14', 0, 0, '2025-05-13 17:05:17', '2025-05-13 17:05:17', 0, 20, '2025-05-20'),
(61, 8, '23-0002', NULL, 'dawdasdaw', 'dasdawdasdawd', 'ISD Office, 2nd Floor, Main Bldg.', 0, '222', '2025-05-14', 0, 0, '2025-05-14 05:01:39', '2025-05-14 05:01:39', 0, 30, '2025-05-19'),
(62, 5, '23-0001', NULL, 'dasdawdadawda', 'qwertyu', 'ISD', 0, '221', '2025-05-14', 0, 0, '2025-05-14 05:37:38', '2025-05-14 05:37:38', 0, 19, '2025-05-19');

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
(1, 1, 45, '2025-04-13 18:18:32', '2025-04-13 18:18:32'),
(2, 1, 46, '2025-04-13 18:28:31', '2025-04-13 18:28:31'),
(3, 1, 47, '2025-05-04 17:18:59', '2025-05-04 17:18:59'),
(4, 1, 48, '2025-05-04 17:19:26', '2025-05-04 17:19:26'),
(5, 1, 49, '2025-05-05 20:12:08', '2025-05-05 20:12:08'),
(6, 1, 50, '2025-05-07 19:01:47', '2025-05-07 19:01:47'),
(7, 1, 51, '2025-05-07 19:46:48', '2025-05-07 19:46:48'),
(8, 1, 52, '2025-05-07 19:48:46', '2025-05-07 19:48:46'),
(9, 1, 53, '2025-05-07 22:55:03', '2025-05-07 22:55:03'),
(10, 1, 54, '2025-05-08 18:29:00', '2025-05-08 18:29:00'),
(11, 1, 55, '2025-05-08 18:34:32', '2025-05-08 18:34:32'),
(12, 1, 56, '2025-05-12 17:09:45', '2025-05-12 17:09:45'),
(13, 1, 57, '2025-05-12 22:40:15', '2025-05-12 22:40:15'),
(14, 1, 58, '2025-05-13 16:45:37', '2025-05-13 16:45:37'),
(15, 1, 59, '2025-05-13 16:56:40', '2025-05-13 16:56:40'),
(16, 1, 60, '2025-05-13 17:05:17', '2025-05-13 17:05:17'),
(17, 1, 61, '2025-05-14 05:01:39', '2025-05-14 05:01:39'),
(18, 1, 62, '2025-05-14 05:37:38', '2025-05-14 05:37:38');

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
(3, 3, 'SPR', '2019', '06', '01', 'SPR-2019-06-01', '2019-06-04 05:31:41', '2019-06-04 05:31:41'),
(4, 4, 'SPR', '2019', '06', '02', 'SPR-2019-06-02', '2019-06-04 07:45:32', '2019-06-04 07:45:32'),
(5, 5, 'CTR', '2019', '06', '02', 'CTR-2019-06-02', '2019-06-06 00:14:13', '2019-06-06 00:14:13'),
(6, 6, 'CTR', '2019', '06', '03', 'CTR-2019-06-03', '2019-06-06 00:58:12', '2019-06-06 00:58:12'),
(7, 7, 'SPR', '2019', '06', '03', 'SPR-2019-06-03', '2019-06-06 01:27:56', '2019-06-06 01:27:56'),
(8, 8, 'TRS', '2019', '06', '01', 'TRS-2019-06-01', '2019-06-06 02:59:05', '2019-06-06 02:59:05'),
(9, 9, 'TRS', '2019', '06', '02', 'TRS-2019-06-02', '2019-06-06 03:02:29', '2019-06-06 03:02:29'),
(10, 10, 'PRT', '2019', '06', '01', 'PRT-2019-06-01', '2019-06-07 00:16:53', '2019-06-07 00:16:53'),
(11, 11, 'PRT', '2019', '06', '02', 'PRT-2019-06-02', '2019-06-07 00:48:35', '2019-06-07 00:48:35'),
(12, 12, 'CTR', '2019', '06', '04', 'CTR-2019-06-04', '2019-06-07 00:55:41', '2019-06-07 00:55:41'),
(7300, 45, '10', '2025', '04', '1', 'TKT-2025-04-0001', '2025-04-13 18:18:32', '2025-04-13 18:18:32'),
(7301, 46, '7', '2025', '04', '2', 'TKT-2025-04-0002', '2025-04-13 18:28:31', '2025-04-13 18:28:31'),
(7302, 47, '1', '2025', '05', '3', 'TKT-2025-05-0003', '2025-05-04 17:18:59', '2025-05-04 17:18:59'),
(7303, 48, '5', '2025', '05', '4', 'TKT-2025-05-0004', '2025-05-04 17:19:26', '2025-05-04 17:19:26'),
(7304, 49, '1', '2025', '05', '5', 'TKT-2025-05-0005', '2025-05-05 20:12:08', '2025-05-05 20:12:08'),
(7305, 50, 'ARS', '2025', '05', '1', 'ARS-2025-05-01', '2025-05-07 19:01:47', '2025-05-07 19:01:47'),
(7306, 51, 'TRS', '2025', '05', '1', 'TRS-2025-05-01', '2025-05-07 19:46:48', '2025-05-07 19:46:48'),
(7307, 52, 'ERS', '2025', '05', '1', 'ERS-2025-05-01', '2025-05-07 19:48:46', '2025-05-07 19:48:46'),
(7308, 53, 'PRS', '2025', '05', '1', 'PRS-2025-05-01', '2025-05-07 22:55:03', '2025-05-07 22:55:03'),
(7309, 54, 'CRS', '2025', '05', '1', 'CRS-2025-05-01', '2025-05-08 18:29:00', '2025-05-08 18:29:00'),
(7310, 55, 'TRS', '2025', '05', '2', 'TRS-2025-05-02', '2025-05-08 18:34:32', '2025-05-08 18:34:32'),
(7311, 56, 'CRS', '2025', '05', '2', 'CRS-2025-05-02', '2025-05-12 17:09:45', '2025-05-12 17:09:45'),
(7312, 57, 'ARS', '2025', '05', '2', 'ARS-2025-05-02', '2025-05-12 22:40:15', '2025-05-12 22:40:15'),
(7313, 58, 'ARS', '2025', '05', '3', 'ARS-2025-05-03', '2025-05-13 16:45:37', '2025-05-13 16:45:37'),
(7314, 59, 'DER', '2025', '05', '1', 'DER-2025-05-01', '2025-05-13 16:56:40', '2025-05-13 16:56:40'),
(7315, 60, 'CCTV', '2025', '05', '1', 'CCTV-2025-05-01', '2025-05-13 17:05:17', '2025-05-13 17:05:17'),
(7316, 61, 'NRS', '2025', '05', '1', 'NRS-2025-05-01', '2025-05-14 05:01:39', '2025-05-14 05:01:39'),
(7317, 62, 'CCTV', '2025', '05', '2', 'CCTV-2025-05-02', '2025-05-14 05:37:38', '2025-05-14 05:37:38');

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
(22, 'John Deer', 'johndeer@example.com', '23-0002', NULL, '$2y$10$5nsP0CFSq9302q/.KpFwiuO1jwMeG449Wj9FNz/GnuswsoDw5WN8q', NULL, NULL, '2025-05-12 20:57:30', 2, 0),
(23, 'Jane Smith', 'janesmith@example.com', 'PR-003', NULL, '$2y$10$yuKPvCMI.Yeh0KVlCnweHOlrLmZ4.sv2C1TA8HaweVy/uma8gF9OG', NULL, '2025-03-21 05:18:56', '2025-05-01 18:02:24', 2, 0),
(24, 'Mark Johnson', 'markjohnson@example.com', '23-0003', NULL, '$2y$10$LFKYQhBADm.aufPBOQhK2evour7m68pQBCAGqSzP8Sx3tY/pSZJp6', NULL, '2025-03-21 05:18:56', '2025-05-12 23:02:41', 3, 0),
(25, 'Emily Davis', 'emilydavis@example.com', '23-0005', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:18:56', '2025-03-21 05:18:56', 2, 0),
(31, 'Michael Brown', 'michaelbrown@example.com', 'PR-006', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 3, 0),
(32, 'Sarah Wilson', 'sarahwilson@example.com', 'PR-007', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 3, 0),
(33, 'Daniel Martinez', 'danielmartinez@example.com', 'PR-008', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 4, 0),
(34, 'Laura Garcia', 'lauragarcia@example.com', 'PR-009', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-05-04 17:45:03', 3, 0),
(35, 'James Anderson', 'jamesanderson@example.com', 'PR-010', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-21 05:23:49', '2025-03-21 05:23:49', 3, 0),
(37, 'Technician 1', 'tech1@example.com', 'PR-002', NULL, '$2y$10$Q4YK7/rMjz/TaVd8shJowOkZ9P62tcrywR.ynEpeSvkhyRskhkQ/O', NULL, '2025-03-23 21:50:00', '2025-03-23 14:11:41', 2, 0),
(38, 'Technician 2', 'tech2@example.com', '2002', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-23 21:50:00', '2025-03-23 21:50:00', 2, 0),
(39, 'Regular User', 'user@example.com', '3001', NULL, '$2y$10$abcdefghijklmnopqrstuv', NULL, '2025-03-23 21:50:00', '2025-03-23 21:50:00', 3, 0),
(40, 'UserPoAko', 'userako@gmail.com', '23-0012', NULL, '$2y$10$KLhaIj7kR1BJHzZoKp2YiOlL2KT03vR5zQ1GU2EYD/.xRh.NyOhCe', NULL, NULL, NULL, 5, 0);

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
-- AUTO_INCREMENT for table `evaluation_request`
--
ALTER TABLE `evaluation_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6793;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lib_incident_reports`
--
ALTER TABLE `lib_incident_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lib_verifiers`
--
ALTER TABLE `lib_verifiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message_to_clients`
--
ALTER TABLE `message_to_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `primarytechnician_request`
--
ALTER TABLE `primarytechnician_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- AUTO_INCREMENT for table `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7589;

--
-- AUTO_INCREMENT for table `request_status_history`
--
ALTER TABLE `request_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `secondarytechnician_request`
--
ALTER TABLE `secondarytechnician_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `service_request_station`
--
ALTER TABLE `service_request_station`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7318;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

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
