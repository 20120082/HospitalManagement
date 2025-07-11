-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 07:00 PM
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
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `available_days` varchar(50) DEFAULT NULL,
  `available_hours` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `employee_id`, `specialization`, `license_number`, `department`, `consultation_fee`, `experience_years`, `education`, `available_days`, `available_hours`) VALUES
(2, 3, 'DOC002', 'Ngoại khoa', 'LIC002', 'Khoa Ngoại', 400000.00, 8, 'Thạc sĩ Y khoa - Đại học Y TP.HCM', 'Thứ 2-7', '7:00-16:00');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `success` tinyint(1) DEFAULT 0,
  `failure_reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`attempt_id`, `username`, `ip_address`, `attempt_time`, `success`, `failure_reason`) VALUES
(1, 'doctor1', '::1', '2025-07-09 06:44:47', 1, NULL),
(2, 'doctor1', '::1', '2025-07-09 06:45:15', 0, 'Invalid credentials'),
(3, 'admin', '::1', '2025-07-09 06:45:48', 0, 'Invalid credentials'),
(4, 'admin', '::1', '2025-07-09 06:53:02', 1, NULL),
(5, 'doctor1', '::1', '2025-07-09 06:56:02', 0, 'Invalid credentials'),
(6, 'doctor1', '::1', '2025-07-09 06:56:38', 0, 'Invalid credentials'),
(7, 'admin', '::1', '2025-07-09 06:56:56', 0, 'Invalid credentials'),
(8, 'admin', '::1', '2025-07-09 06:57:29', 0, 'Invalid credentials'),
(9, 'admin', '::1', '2025-07-09 06:57:34', 0, 'Invalid credentials'),
(10, 'admin', '::1', '2025-07-09 06:59:44', 0, 'Invalid credentials'),
(11, 'admin', '::1', '2025-07-09 07:00:31', 0, 'Invalid credentials'),
(12, 'admin', '::1', '2025-07-09 07:00:46', 0, 'Invalid credentials'),
(13, 'admin', '::1', '2025-07-09 07:00:58', 0, 'Invalid credentials'),
(14, 'admin', '::1', '2025-07-09 08:43:23', 0, 'Invalid credentials'),
(15, 'admin', '::1', '2025-07-09 08:49:29', 0, 'Invalid credentials'),
(16, 'admin', '::1', '2025-07-09 08:49:55', 0, 'Invalid credentials'),
(17, 'admin', '::1', '2025-07-09 08:50:04', 0, 'Invalid credentials'),
(18, 'admin', '::1', '2025-07-09 08:50:18', 0, 'Invalid credentials'),
(19, 'admin', '::1', '2025-07-09 08:50:29', 0, 'Invalid credentials'),
(20, 'doctor1', '::1', '2025-07-09 08:50:46', 0, 'Invalid credentials'),
(21, 'doctor1', '::1', '2025-07-09 08:54:01', 0, 'Invalid credentials'),
(22, 'doctor1', '::1', '2025-07-09 08:54:12', 0, 'Invalid credentials'),
(23, 'doctor1', '::1', '2025-07-09 08:54:17', 0, 'Invalid credentials'),
(24, 'admin', '::1', '2025-07-09 09:19:32', 0, 'Invalid credentials'),
(25, 'admin', '::1', '2025-07-09 09:23:18', 1, NULL),
(26, 'patient1', '::1', '2025-07-09 09:25:21', 1, NULL),
(27, 'patient1', '::1', '2025-07-09 09:25:29', 1, NULL),
(28, 'patient1', '::1', '2025-07-09 09:44:12', 1, NULL),
(29, 'patient1', '::1', '2025-07-09 09:44:15', 1, NULL),
(30, 'admin', '::1', '2025-07-09 09:44:20', 1, NULL),
(31, 'doctor1', '::1', '2025-07-09 09:44:35', 1, NULL),
(32, 'doctor1', '::1', '2025-07-09 09:46:00', 1, NULL),
(33, 'nurse1', '::1', '2025-07-09 09:46:12', 1, NULL),
(34, 'receptionist1', '::1', '2025-07-09 09:46:29', 1, NULL),
(35, 'admin', '::1', '2025-07-09 09:48:07', 0, 'Invalid credentials'),
(36, 'admin', '::1', '2025-07-09 09:48:08', 0, 'Invalid credentials'),
(37, 'receptionist1', '::1', '2025-07-09 09:48:19', 1, NULL),
(38, 'nurse1', '::1', '2025-07-09 09:48:24', 1, NULL),
(39, 'nurse1', '::1', '2025-07-09 09:50:52', 1, NULL),
(40, 'doctor1', '::1', '2025-07-09 09:50:56', 1, NULL),
(41, 'doctor1', '::1', '2025-07-09 09:52:21', 1, NULL),
(42, 'admin', '::1', '2025-07-09 09:53:22', 1, NULL),
(43, 'receptionist1', '::1', '2025-07-09 09:54:03', 1, NULL),
(44, 'receptionist1', '::1', '2025-07-09 09:55:33', 1, NULL),
(45, 'doctor1', '::1', '2025-07-09 09:55:51', 1, NULL),
(46, 'patient1', '::1', '2025-07-09 09:58:09', 1, NULL),
(47, 'nurse1', '::1', '2025-07-09 09:58:15', 1, NULL),
(48, 'admin', '::1', '2025-07-09 10:01:16', 0, 'Invalid credentials'),
(49, 'nurse1', '::1', '2025-07-09 10:01:48', 1, NULL),
(50, 'doctor1', '::1', '2025-07-09 10:01:52', 1, NULL),
(51, 'doctor1', '::1', '2025-07-09 10:03:26', 1, NULL),
(52, 'doctor1', '::1', '2025-07-09 11:03:25', 1, NULL),
(53, 'patient1', '::1', '2025-07-09 11:03:31', 0, 'Invalid credentials'),
(54, 'nurse1', '::1', '2025-07-09 11:03:37', 1, NULL),
(55, 'nurse1', '::1', '2025-07-09 11:05:04', 1, NULL),
(56, 'nurse1', '::1', '2025-07-09 15:55:30', 1, NULL),
(57, 'admin', '::1', '2025-07-09 15:55:38', 1, NULL),
(58, 'admin', '::1', '2025-07-09 16:05:05', 1, NULL),
(59, 'admin', '::1', '2025-07-09 16:09:00', 0, 'Invalid credentials'),
(60, 'admin1', '::1', '2025-07-09 16:09:04', 0, 'Invalid credentials'),
(61, 'admin1', '::1', '2025-07-09 16:09:15', 0, 'Invalid credentials'),
(62, 'admin1', '::1', '2025-07-09 16:09:27', 0, 'Invalid credentials'),
(63, 'admin', '::1', '2025-07-09 16:09:31', 0, 'Invalid credentials'),
(64, 'nurse1', '::1', '2025-07-09 16:09:35', 0, 'Invalid credentials'),
(65, 'admin', '::1', '2025-07-09 16:09:39', 0, 'Invalid credentials'),
(66, 'admin', '::1', '2025-07-09 16:10:56', 0, 'Invalid credentials'),
(67, 'admin', '::1', '2025-07-09 16:16:57', 0, 'Invalid credentials'),
(68, 'admin1', '::1', '2025-07-09 16:17:01', 0, 'Invalid credentials'),
(69, 'admin1', '::1', '2025-07-09 16:17:07', 0, 'Invalid credentials'),
(70, 'doctor1', '::1', '2025-07-09 16:17:12', 0, 'Invalid credentials'),
(71, 'doctor1', '::1', '2025-07-09 16:21:40', 1, NULL),
(72, 'admin', '::1', '2025-07-09 16:21:46', 0, 'Invalid credentials'),
(73, 'admin1', '::1', '2025-07-09 16:21:49', 1, NULL),
(74, 'admin1', '::1', '2025-07-09 16:22:26', 1, NULL),
(75, 'admin1', '::1', '2025-07-09 16:24:00', 1, NULL),
(76, 'admin1', '::1', '2025-07-09 16:25:55', 1, NULL),
(77, 'admin1', '::1', '2025-07-09 16:36:37', 1, NULL),
(78, 'admin1', '::1', '2025-07-09 16:49:44', 1, NULL),
(79, 'admin1', '::1', '2025-07-09 16:52:00', 1, NULL),
(80, 'admin', '::1', '2025-07-09 16:56:49', 0, 'Invalid credentials'),
(81, 'admin1', '::1', '2025-07-09 16:56:54', 1, NULL),
(82, 'admin1', '::1', '2025-07-09 16:58:49', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `permission_description` text DEFAULT NULL,
  `module_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `description`, `permission_description`, `module_name`, `created_at`) VALUES
(1, 'admin_dashboard', 'Truy cập dashboard quản trị viên', 'Truy cập dashboard quản trị', 'admin', '2025-07-09 06:32:56'),
(2, 'user_management', NULL, 'Quản lý người dùng', 'admin', '2025-07-09 06:32:56'),
(3, 'system_settings', NULL, 'Cài đặt hệ thống', 'admin', '2025-07-09 06:32:56'),
(4, 'view_reports', NULL, 'Xem báo cáo', 'admin', '2025-07-09 06:32:56'),
(5, 'doctor_dashboard', 'Truy cập dashboard bác sĩ', 'Truy cập dashboard bác sĩ', 'doctor', '2025-07-09 06:32:56'),
(6, 'manage_prescriptions', NULL, 'Quản lý đơn thuốc', 'prescription', '2025-07-09 06:32:56'),
(7, 'view_patients', 'Xem thông tin bệnh nhân', 'Xem thông tin bệnh nhân', 'patient', '2025-07-09 06:32:56'),
(8, 'doctor_manage_appointments', NULL, 'Quản lý lịch hẹn bác sĩ', 'appointment', '2025-07-09 06:32:56'),
(9, 'view_medicines', NULL, 'Xem danh sách thuốc', 'medicine', '2025-07-09 06:32:56'),
(11, 'view_own_appointments', NULL, 'Xem lịch hẹn của mình', 'appointment', '2025-07-09 06:32:56'),
(12, 'view_own_prescriptions', NULL, 'Xem đơn thuốc của mình', 'prescription', '2025-07-09 06:32:56'),
(13, 'book_appointment', NULL, 'Đặt lịch hẹn', 'appointment', '2025-07-09 06:32:56'),
(14, 'nurse_dashboard', 'Truy cập dashboard y tá', 'Truy cập dashboard y tá', 'nurse', '2025-07-09 06:32:56'),
(15, 'manage_medicines', NULL, 'Quản lý thuốc', 'medicine', '2025-07-09 06:32:56'),
(16, 'view_prescriptions', NULL, 'Xem đơn thuốc', 'prescription', '2025-07-09 06:32:56'),
(17, 'assist_doctor', NULL, 'Hỗ trợ bác sĩ', 'doctor', '2025-07-09 06:32:56'),
(18, 'receptionist_dashboard', 'Truy cập dashboard lễ tân', 'Truy cập dashboard lễ tân', 'receptionist', '2025-07-09 06:32:56'),
(19, 'receptionist_manage_appointments', NULL, 'Quản lý lịch hẹn lễ tân', 'appointment', '2025-07-09 06:32:56'),
(21, 'manage_notifications', NULL, 'Quản lý thông báo', 'notification', '2025-07-09 06:32:56'),
(22, 'user_index', 'Xem danh sách tài khoản', NULL, '', '2025-07-09 15:36:38'),
(23, 'user_create', 'Tạo tài khoản mới', NULL, '', '2025-07-09 15:36:38'),
(24, 'user_show', 'Xem chi tiết tài khoản', NULL, '', '2025-07-09 15:36:38'),
(25, 'user_edit', 'Chỉnh sửa tài khoản', NULL, '', '2025-07-09 15:36:38'),
(26, 'user_delete', 'Xóa tài khoản', NULL, '', '2025-07-09 15:36:38'),
(27, 'user_toggle_status', 'Thay đổi trạng thái tài khoản', NULL, '', '2025-07-09 15:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Quản trị viên hệ thống - có quyền truy cập tất cả', '2025-07-09 06:32:56', '2025-07-09 06:32:56'),
(2, 'doctor', 'Bác sĩ - quản lý bệnh nhân, đơn thuốc, lịch hẹn', '2025-07-09 06:32:56', '2025-07-09 06:32:56'),
(4, 'nurse', 'Y tá - hỗ trợ bác sĩ, quản lý thuốc', '2025-07-09 06:32:56', '2025-07-09 06:32:56'),
(5, 'receptionist', 'Lễ tân - quản lý lịch hẹn, thông tin bệnh nhân cơ bản', '2025-07-09 06:32:56', '2025-07-09 06:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `granted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`, `granted_at`) VALUES
(1, 1, '2025-07-09 06:32:56'),
(1, 2, '2025-07-09 06:32:56'),
(1, 3, '2025-07-09 06:32:56'),
(1, 4, '2025-07-09 06:32:56'),
(1, 5, '2025-07-09 06:32:56'),
(1, 6, '2025-07-09 06:32:56'),
(1, 7, '2025-07-09 06:32:56'),
(1, 8, '2025-07-09 06:32:56'),
(1, 9, '2025-07-09 06:32:56'),
(1, 11, '2025-07-09 06:32:56'),
(1, 12, '2025-07-09 06:32:56'),
(1, 13, '2025-07-09 06:32:56'),
(1, 14, '2025-07-09 06:32:56'),
(1, 15, '2025-07-09 06:32:56'),
(1, 16, '2025-07-09 06:32:56'),
(1, 17, '2025-07-09 06:32:56'),
(1, 18, '2025-07-09 06:32:56'),
(1, 19, '2025-07-09 06:32:56'),
(1, 21, '2025-07-09 06:32:56'),
(1, 22, '2025-07-09 15:36:38'),
(1, 23, '2025-07-09 15:36:38'),
(1, 24, '2025-07-09 15:36:38'),
(1, 25, '2025-07-09 15:36:38'),
(1, 26, '2025-07-09 15:36:38'),
(1, 27, '2025-07-09 15:36:38'),
(2, 4, '2025-07-09 06:32:56'),
(2, 5, '2025-07-09 06:32:56'),
(2, 6, '2025-07-09 06:32:56'),
(2, 7, '2025-07-09 06:32:56'),
(2, 8, '2025-07-09 06:32:56'),
(2, 9, '2025-07-09 06:32:56'),
(4, 9, '2025-07-09 06:32:56'),
(4, 14, '2025-07-09 06:32:56'),
(4, 15, '2025-07-09 06:32:56'),
(4, 16, '2025-07-09 06:32:56'),
(4, 17, '2025-07-09 06:32:56'),
(5, 18, '2025-07-09 06:32:56'),
(5, 19, '2025-07-09 06:32:56'),
(5, 21, '2025-07-09 06:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `address`, `role_id`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin1', 'admin1@hospital.com', '$2y$10$nsUwncVcsPQwEz5V9sq8zeOlhR.hfPwnAS2D.mIrPh5iWjaRdFgTa', 'Quản trị viên hệ thống', '0123456789', 'Hà Nội', 1, 1, '2025-07-09 16:58:49', '2025-07-09 06:32:56', '2025-07-09 16:58:49'),
(3, 'doctor2', 'doctor2@hospital.com', '$2y$10$nsUwncVcsPQwEz5V9sq8zeOlhR.hfPwnAS2D.mIrPh5iWjaRdFgTa', 'Bác sĩ Trần Thị B', '0987654322', 'TP.HCM', 2, 1, '2025-07-09 16:23:56', '2025-07-09 06:32:56', '2025-07-09 16:23:56'),
(5, 'nurse1', 'nurse1@hospital.com', '$2y$10$nsUwncVcsPQwEz5V9sq8zeOlhR.hfPwnAS2D.mIrPh5iWjaRdFgTa', 'Y tá Phạm Thị D', '0908765432', 'Hà Nội', 4, 1, '2025-07-09 16:23:56', '2025-07-09 06:32:56', '2025-07-09 16:23:56'),
(6, 'receptionist1', 'receptionist1@hospital.com', '$2y$10$nsUwncVcsPQwEz5V9sq8zeOlhR.hfPwnAS2D.mIrPh5iWjaRdFgTa', 'Lễ tân Hoàng Văn E', '0901234567', 'Hà Nội', 5, 1, '2025-07-09 16:23:56', '2025-07-09 06:32:56', '2025-07-09 16:23:56'),
(8, 'doctor1', 'doctor1@hospital.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bác sĩ Nguyễn Văn A', '0987654321', 'Địa chỉ bác sĩ 1', 2, 1, NULL, '2025-07-09 16:52:52', '2025-07-09 16:52:52');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_info`
-- (See below for the actual view)
--
CREATE TABLE `user_info` (
`user_id` int(11)
,`username` varchar(50)
,`email` varchar(100)
,`full_name` varchar(100)
,`phone` varchar(20)
,`address` text
,`role_name` varchar(50)
,`role_description` text
,`is_active` tinyint(1)
,`last_login` timestamp
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_permissions`
-- (See below for the actual view)
--
CREATE TABLE `user_permissions` (
`user_id` int(11)
,`username` varchar(50)
,`full_name` varchar(100)
,`role_name` varchar(50)
,`permission_name` varchar(100)
,`permission_description` text
,`module_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`session_id`, `user_id`, `ip_address`, `user_agent`, `login_time`, `last_activity`, `is_active`) VALUES
('m94pnfgc48e26i63iqvidbcpum', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '2025-07-09 16:58:49', '2025-07-09 16:58:49', 1);

-- --------------------------------------------------------

--
-- Structure for view `user_info`
--
DROP TABLE IF EXISTS `user_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_info`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`username` AS `username`, `u`.`email` AS `email`, `u`.`full_name` AS `full_name`, `u`.`phone` AS `phone`, `u`.`address` AS `address`, `r`.`role_name` AS `role_name`, `r`.`role_description` AS `role_description`, `u`.`is_active` AS `is_active`, `u`.`last_login` AS `last_login`, `u`.`created_at` AS `created_at` FROM (`users` `u` join `roles` `r` on(`u`.`role_id` = `r`.`role_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_permissions`
--
DROP TABLE IF EXISTS `user_permissions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_permissions`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`username` AS `username`, `u`.`full_name` AS `full_name`, `r`.`role_name` AS `role_name`, `p`.`permission_name` AS `permission_name`, `p`.`permission_description` AS `permission_description`, `p`.`module_name` AS `module_name` FROM (((`users` `u` join `roles` `r` on(`u`.`role_id` = `r`.`role_id`)) join `role_permissions` `rp` on(`r`.`role_id` = `rp`.`role_id`)) join `permissions` `p` on(`rp`.`permission_id` = `p`.`permission_id`)) WHERE `u`.`is_active` = 1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `idx_login_attempts_username` (`username`),
  ADD KEY `idx_login_attempts_ip_address` (`ip_address`),
  ADD KEY `idx_login_attempts_attempt_time` (`attempt_time`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_username` (`username`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role_id` (`role_id`),
  ADD KEY `idx_users_is_active` (`is_active`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `idx_user_sessions_user_id` (`user_id`),
  ADD KEY `idx_user_sessions_is_active` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
