-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th6 03, 2025 lúc 09:22 AM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `appointment_service`
--
CREATE DATABASE IF NOT EXISTS `appointment_service` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `appointment_service`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Id_Patient`  varchar(15) NOT NULL,
  `Id_Doctor` int NOT NULL,
  `Id_Room` varchar(15) NOT NULL,
  `StartTime` datetime NOT NULL,
  `Status` varchar(15) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `appointment`
--

INSERT INTO `appointment` (`Id`, `Id_Patient`, `Id_Doctor`, `Id_Room`, `StartTime`,`Status`) VALUES
(1, 'BN2025-00001', 1, 'PK00001', '2025-06-04 08:30:00','Đã khám'),
(2, 'BN2025-00002', 2, 'PK00003', '2025-06-04 09:00:00','Đã khám'),
(3, 'BN2025-00003', 1, 'PK00002', '2025-06-04 10:15:00','Chưa khám'),
(4, 'BN2025-00001', 1, 'PK00001', '2025-06-05 14:00:00','Đã khám'),
(5, 'BN2025-00003', 1, 'PK00005', '2025-06-05 15:30:00','Chưa khám');
--
-- Cơ sở dữ liệu: `doctor_service`
--
CREATE DATABASE IF NOT EXISTS `doctor_service` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `doctor_service`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Gender` enum('Nam','Nữ') NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Username` varchar(50) UNIQUE DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `doctor`
--

INSERT INTO `doctor` (`Id`, `Name`, `Gender`, `PhoneNumber`, `Position`,`Username`) VALUES
(1, 'Nguyễn Văn Hùng', 'Nam', '0912345678', 'Bác sĩ nội khoa','doctor1'),
(2, 'Trần Thị Mai', 'Nữ', '0987654321', 'Bác sĩ nhi khoa',NULL),
(3, 'Phạm Quốc Anh', 'Nam', '0901234567', 'Bác sĩ ngoại khoa',NULL),
(4, 'Lê Thị Hồng Nhung', 'Nữ', '0932143657', 'Bác sĩ da liễu',NULL),
(5, 'Hoàng Minh Tuấn', 'Nam', '0971239876', 'Bác sĩ tim mạch',NULL);
--
-- Cơ sở dữ liệu: `prescription_service`
--
CREATE DATABASE IF NOT EXISTS `prescription_service` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `prescription_service`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prescription`
--

DROP TABLE IF EXISTS `prescription`;
CREATE TABLE IF NOT EXISTS `prescription` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Id_Patient` varchar(15) NOT NULL,
  `Created_Date` date NOT NULL,
  `Status` varchar(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `prescription`
--

INSERT INTO `prescription` (`Id`, `Id_Patient`, `Created_Date`,`Status`) VALUES
(1, 'BN2025-00001', '2024-01-15','Đã lấy'),
(2, 'BN2025-00002', '2024-02-20','Đã lấy'),
(3, 'BN2025-00001', '2024-03-10','Đã lấy'),
(4, 'BN2025-00001', '2024-04-05','Đã lấy'),
(5, 'BN2025-00003', '2024-05-12','Đã lấy'),
(6, 'BN2025-00001', '2024-06-25','Đã lấy'),
(7, 'BN2025-00001', '2024-07-18','Đã lấy'),
(8, 'BN2025-00002', '2024-08-30','Đã lấy'),
(9, 'BN2025-00001', '2024-09-14','Đã lấy'),
(10, 'BN2025-00005', '2024-10-22','Đã lấy'),
(11, 'BN2025-00004', '2024-11-09','Đã lấy'),
(12, 'BN2025-00006', '2024-12-01','Đã lấy'),
(13, 'BN2025-00007', '2025-01-17','Đã lấy'),
(14, 'BN2025-00005', '2025-02-28','Đã lấy'),
(15, 'BN2025-00001', '2025-03-15','Đã lấy'),
(16, 'BN2025-00003', '2025-04-10','Chưa lấy'),
(17, 'BN2025-00004', '2025-05-05','Đã lấy'),
(18, 'BN2025-00002', '2025-05-20','Đã lấy'),
(19, 'BN2025-00004', '2025-06-01','Chưa lấy'),
(20, 'BN2025-00001', '2025-06-03','Chưa lấy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prescriptiondetail`
--

DROP TABLE IF EXISTS `prescriptiondetail`;
CREATE TABLE IF NOT EXISTS `prescriptiondetail` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Id_Prescription` int NOT NULL,
  `Id_Medicine` int NOT NULL,
  `Quantity` float NOT NULL,
  `Unit` varchar(50) NOT NULL,
  `Price` float(10,2) NOT NULL,
  PRIMARY KEY (`Id`),
  FOREIGN KEY (`Id_Prescription`) REFERENCES `prescription`(`Id`) ON DELETE CASCADE
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `prescriptiondetail`
--

INSERT INTO `prescriptiondetail` (`Id`,`Id_Prescription`, `Id_Medicine`, `Quantity`, `Unit`, `Price`) VALUES
(1,1, 1, 10, 'Tablet', 5000.00),
(2,1, 2, 5, 'Capsule', 8000.00),
(3,2, 3, 20, 'Tablet', 3000.00),
(4,3, 4, 15, 'Tablet', 3500.00),
(5,3, 5, 8, 'Tablet', 6000.00),
(6,4, 1, 12, 'Tablet', 5000.00),
(7,4, 3, 10, 'Tablet', 3000.00),
(8,5, 2, 6, 'Capsule', 8000.00),
(9,5, 4, 10, 'Tablet', 3500.00),
(10,6, 5, 5, 'Tablet', 6000.00),
(11,7, 1, 15, 'Tablet', 5000.00),
(12,7, 2, 8, 'Capsule', 8000.00),
(13,7, 3, 12, 'Tablet', 3000.00),
(14,8, 4, 20, 'Tablet', 3500.00),
(15,9, 5, 7, 'Tablet', 6000.00),
(16,9, 1, 10, 'Tablet', 5000.00),
(17,10, 2, 5, 'Capsule', 8000.00),
(18,10, 3, 15, 'Tablet', 3000.00),
(19,11, 4, 12, 'Tablet', 3500.00),
(20,11, 5, 9, 'Tablet', 6000.00),
(21,12, 1, 8, 'Tablet', 5000.00),
(22,13, 2, 7, 'Capsule', 8000.00),
(23,13, 3, 10, 'Tablet', 3000.00),
(24,14, 4, 15, 'Tablet', 3500.00),
(25,15, 5, 6, 'Tablet', 6000.00),
(26,15, 1, 12, 'Tablet', 5000.00),
(27,16, 2, 8, 'Capsule', 8000.00),
(28,16, 3, 10, 'Tablet', 3000.00),
(29,17, 4, 10, 'Tablet', 3500.00),
(30,17, 5, 5, 'Tablet', 6000.00),
(31,18, 1, 15, 'Tablet', 5000.00),
(32,18, 2, 6, 'Capsule', 8000.00),
(33,19, 3, 12, 'Tablet', 3000.00),
(34,19, 4, 8, 'Tablet', 3500.00),
(35,20, 5, 10, 'Tablet', 6000.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
