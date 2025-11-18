-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 04:27 PM
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
-- Database: `shoe_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'password'),
('admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `attendance_date`, `status`) VALUES
(1, 0, '2024-09-29', 'Absent'),
(2, 0, '2024-09-30', 'Present'),
(3, 0, '2024-10-03', 'Present'),
(4, 0, '2024-10-06', 'Present'),
(5, 0, '2024-10-08', 'Absent'),
(6, 1, '2024-10-10', 'Present'),
(7, 2, '2024-10-10', 'Absent'),
(8, 1, '2024-10-21', 'Present'),
(9, 1, '2024-10-23', 'Present'),
(10, 1, '2024-11-01', 'Present'),
(11, 1, '2024-11-02', 'Present'),
(12, 1, '2024-11-05', 'Present'),
(13, 5, '2024-11-05', 'Present'),
(14, 1, '2024-11-06', 'Present'),
(15, 2, '2024-11-06', 'Present'),
(16, 5, '2024-11-06', 'Present'),
(17, 3, '2024-11-07', 'Present'),
(18, 1, '2024-11-08', 'Present'),
(19, 6, '2024-11-09', 'Present'),
(20, 9, '2024-11-09', 'Present'),
(21, 9, '2024-11-11', 'Present'),
(22, 2, '2024-11-15', 'Present'),
(23, 6, '2024-11-15', 'Present'),
(24, 1, '2024-11-27', 'Present'),
(25, 6, '2024-11-27', 'Present'),
(26, 9, '2024-11-29', 'Present'),
(27, 2, '2024-11-29', 'Present'),
(28, 1, '2025-01-04', 'Present'),
(29, 6, '2025-01-06', 'Present'),
(30, 11, '2025-01-06', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `service_type` varchar(100) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` time NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_status` varchar(50) DEFAULT 'Pending',
  `cust_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `number_of_shoes` int(11) NOT NULL,
  `shoe_type` varchar(255) NOT NULL,
  `material_type` varchar(255) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `addon_services` text DEFAULT NULL,
  `courier_status` enum('Assigned','Delivered','Complete') DEFAULT NULL,
  `pickup_status` enum('Not Picked','Picked','In Transit','Delivered') DEFAULT 'Not Picked',
  `house_name` varchar(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `bk_user_status` enum('Active','Cancelled') DEFAULT 'Active',
  `delivery_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `username`, `customer_email`, `service_type`, `delivery_date`, `delivery_time`, `booking_date`, `booking_status`, `cust_id`, `employee_id`, `phone`, `number_of_shoes`, `shoe_type`, `material_type`, `special_requests`, `addon_services`, `courier_status`, `pickup_status`, `house_name`, `street_name`, `district`, `pincode`, `bk_user_status`, `delivery_status`) VALUES
(8, 'reenu@gmail.com', 'reenu@gmail.com', 'Deep Cleaning', '2024-10-25', '02:28:00', '2024-10-02 15:55:21', 'Completed', 0, 2, NULL, 0, '', '', NULL, NULL, NULL, 'Not Picked', '', '', '', '', 'Active', 'Pending'),
(9, 'navya@gmail.com', 'navya@gmail.com', 'Deep Cleaning', '2024-10-13', '10:35:00', '2024-10-03 05:02:30', 'Completed', 0, 6, NULL, 0, '', '', NULL, NULL, 'Delivered', 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(10, 'navya@gmail.com', 'navya@gmail.com', 'Basic Cleaning', '2024-10-11', '10:52:00', '2024-10-03 05:21:51', 'Completed', 120, 9, '2345889', 0, '', '', NULL, NULL, 'Delivered', 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(11, 'rosemary@gmail.com', 'rosemary@gmail.com', 'Repair Service', '2024-10-06', '14:17:00', '2024-10-03 05:47:49', 'Completed', 120, 1, '738282', 0, '', '', NULL, NULL, NULL, 'Not Picked', 'ers', 'erwu', 'Ernakulam', '682316', 'Active', 'Pending'),
(12, 'rosemary@gmail.com', 'rosemary@gmail.com', 'Basic Cleaning', '2024-10-26', '15:21:00', '2024-10-03 05:51:54', 'Completed', 120, 2, '2067209', 0, '', '', NULL, NULL, NULL, 'Not Picked', 'ers', 'erwu', 'Ernakulam', '682316', 'Active', 'Pending'),
(13, 'navya@gmail.com', 'navya@gmail.com', 'Basic Cleaning', '2024-10-05', '17:45:00', '2024-10-05 06:15:39', 'Completed', 121, 2, '738282', 1, 'Boot', 'Suede', 'ljkk', 'Insole Replacement', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(14, 'navya@gmail.com', 'navya@gmail.com', 'Water Proofing', '2024-10-30', '14:50:00', '2024-10-05 06:33:34', 'Completed', 121, 3, '8605434', 2, 'Sneaker', 'Suede', 'eef', 'Scratch Repair', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(15, 'navya@gmail.com', 'navya@gmail.com', 'Deodorizing', '2024-11-07', '15:12:00', '2024-10-05 06:44:59', 'Completed', 121, 2, '7859', 1, 'Sandals', 'Other', ',mffg', '', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(16, 'rosemary@gmail.com', 'rosemary@gmail.com', 'Deep Cleaning', '2024-10-29', '16:20:00', '2024-10-05 06:46:50', 'Completed', 121, 1, '457013', 1, 'Formal Shoes', 'Canvas', 'asd', 'Color Restoration, Scratch Repair', NULL, 'Not Picked', 'ers', 'erwu', 'Ernakulam', '682316', 'Active', 'Pending'),
(17, 'shreya@gmail.com', 'shreya@gmail.com', 'Sole Cleaning', '2024-10-28', '18:23:00', '2024-10-05 07:48:23', 'Completed', 121, 1, '73562341', 1, 'Sneaker', 'Leather', 'wet', 'Heel Replacement', NULL, 'Not Picked', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Pending'),
(18, 'shreya@gmail.com', 'shreya@gmail.com', 'Polishing', '2024-10-20', '15:49:00', '2024-10-05 16:20:04', 'Completed', 121, 1, '37454390', 1, 'Sandals', 'Suede', '', 'Odor Removal', NULL, 'Not Picked', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Pending'),
(23, 'shreya@gmail.com', 'shreya@gmail.com', '5', '2024-10-08', '09:57:00', '2024-10-07 04:18:15', 'Completed', 123, 6, '8605434', 1, 'Boot', 'Canvas', '', '16, 18', 'Delivered', 'Not Picked', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Pending'),
(24, 'navya@gmail.com', 'navya@gmail.com', '9', '2024-10-26', '09:00:00', '2024-10-07 04:28:05', 'Completed', 123, 5, '2345889', 1, 'Sneaker', 'Suede', '', '17', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(25, 'navya@gmail.com', 'navya@gmail.com', '2', '2024-10-17', '10:48:00', '2024-10-08 05:15:49', 'Completed', 120, 3, '8605434', 1, 'Sneaker', 'Synthetic', 'bmm', '12', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Cancelled', 'Pending'),
(26, 'navya@gmail.com', 'navya@gmail.com', '8', '2024-10-26', '07:40:00', '2024-10-08 06:24:53', 'Completed', 120, 5, '2147483647', 1, 'Sneaker', 'Canvas', '', '12', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(27, 'anna@gmail.com', 'anna@gmail.com', '4', '2024-10-18', '01:08:00', '2024-10-13 13:32:40', 'Completed', 124, 2, '738282', 2, 'Boot', 'Canvas', 'no', '17', NULL, 'Not Picked', 'djh', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(28, 'anna@gmail.com', 'anna@gmail.com', '4', '2024-10-18', '01:08:00', '2024-10-13 13:32:40', 'Completed', 124, 2, '738282', 2, 'Sneaker', 'Suede', 'no', NULL, NULL, 'Not Picked', 'djh', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(29, 'sreya@gmail.com', 'sreya@gmail.com', '4', '2024-10-17', '12:51:00', '2024-10-14 04:18:34', 'Completed', 122, 1, '2147483647', 1, 'Boot', 'Canvas', 'qhj', '15', NULL, 'Not Picked', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(30, 'sreya@gmail.com', 'sreya@gmail.com', '6', '2024-10-31', '15:03:00', '2024-10-14 04:30:58', 'Completed', 122, 1, '2147483647', 1, 'Sandals', 'Canvas', 'jj', '21', NULL, 'Not Picked', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(31, 'sreya@gmail.com', 'sreya@gmail.com', '8', '2024-10-24', '14:20:00', '2024-10-14 04:46:50', 'Completed', 122, 1, '7565345', 1, 'Boot', 'Suede', '', '13', NULL, 'Not Picked', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(32, 'sreya@gmail.com', 'sreya@gmail.com', '10', '2024-10-05', '14:11:00', '2024-10-14 05:41:20', 'Completed', 122, 2, '7565345', 1, 'Boot', 'Canvas', 'nnn', '20', NULL, 'Not Picked', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(33, 'sreya@gmail.com', 'sreya@gmail.com', '7', '2024-10-18', '11:39:00', '2024-10-14 06:04:19', 'Completed', 122, 6, '2345889', 1, 'Formal Shoes', 'Synthetic', 'qq', '21', 'Delivered', 'Delivered', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(34, 'shreya@gmail.com', 'shreya@gmail.com', '2', '2024-10-16', '13:00:00', '2024-10-14 06:30:07', 'Completed', 123, 6, '2147483647', 1, 'Sneaker', 'Leather', 'gyyhyujikol;p\'', '11, 12', 'Delivered', 'Delivered', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Pending'),
(35, 'alwin@gmail.com', 'alwin@gmail.com', '1', '2024-10-16', '12:00:00', '2024-10-15 07:28:39', 'Completed', 125, 2, '2147483647', 2, 'Boot', 'Leather', 'rtyytyu', '16', NULL, 'Not Picked', 'jgh', 'jowd', 'Ernakulam', '682316', 'Active', 'Pending'),
(36, 'alwin@gmail.com', 'alwin@gmail.com', '1', '2024-10-16', '12:00:00', '2024-10-15 07:28:39', 'Completed', 125, 5, '2147483647', 2, 'Sandals', 'Leather', 'rtyytyu', '15, 16, 18', '', 'Delivered', 'jgh', 'jowd', 'Ernakulam', '682316', 'Active', 'Pending'),
(37, 'sandra@gmail.com', 'sandra@gmail.com', '8', '2024-10-19', '12:30:00', '2024-10-16 06:58:23', 'Completed', 126, 2, '2147483647', 1, 'Sneaker', 'Leather', 'eefefef', '12', '', 'Delivered', 'jkg', 'kjkf', 'Ernakulam', '682314', 'Active', 'Pending'),
(38, 'alwin@gmail.com', 'alwin@gmail.com', '5', '2024-10-13', '13:30:00', '2024-10-17 05:01:08', 'Completed', 125, 10, '2147483647', 1, 'Sandals', 'Suede', 'qq', '20', 'Delivered', 'Delivered', 'jgh', 'jowd', 'Ernakulam', '682316', 'Active', 'Pending'),
(39, 'shreya@gmail.com', 'shreya@gmail.com', '7', '2024-10-18', '13:59:00', '2024-10-17 05:29:45', 'Completed', 125, 6, '2147483647', 1, 'Boot', 'Canvas', 'qq', '16', 'Delivered', 'Delivered', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Out for Delivery'),
(40, 'navya@gmail.com', 'navya@gmail.com', '10', '2024-10-25', '19:12:00', '2024-10-21 13:40:27', 'Completed', 120, 1, '7565345', 1, 'Boot', 'Leather', '', '17', NULL, 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(41, 'sreya@gmail.com', 'sreya@gmail.com', '10', '2024-10-22', '20:47:00', '2024-10-21 15:15:47', 'Completed', 122, 9, '1234567898', 1, 'Sneaker', 'Leather', '', '12', 'Delivered', 'Not Picked', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(42, 'liya@gmail.com', 'liya@gmail.com', '8', '2024-10-24', '02:00:00', '2024-10-22 14:49:06', 'Completed', 127, 6, '1234567898', 1, 'Sneaker', 'Canvas', 'nothing', '12', 'Delivered', 'Delivered', 'wee', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(44, 'annag@gmail.com', 'annag@gmail.com', '9', '2024-10-24', '02:15:00', '2024-10-23 15:46:26', 'Completed', 128, 6, '123977642', 1, 'Sandals', 'Canvas', '', NULL, 'Delivered', 'Delivered', 'djh', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(45, 'liya@gmail.com', 'liya@gmail.com', '10', '2024-11-14', '13:20:00', '2024-11-01 04:48:11', 'Completed', 127, 6, '1234728759', 1, 'Formal Shoes', 'Synthetic', 'no', '19', 'Delivered', 'Delivered', 'wee', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(46, 'arya@gmail.com', 'arya@gmail.com', '6', '2024-11-13', '10:25:00', '2024-11-01 04:55:01', 'Completed', 129, 9, '2147483647', 1, 'Boot', 'Canvas', '', '16', 'Delivered', 'Delivered', 'leh', 'eff', 'Ernakulam', '682316', 'Active', 'Pending'),
(47, 'sandrab@gmail.com', 'sandrab@gmail.com', '6', '2024-11-07', '14:05:00', '2024-11-02 05:34:47', 'Completed', 130, 9, '2147483647', 1, 'Sneaker', 'Canvas', '', NULL, 'Delivered', 'Delivered', '32eq', 'kyu', 'Ernakulam', '682318', 'Active', 'Pending'),
(48, 'shreya@gmail.com', 'shreya@gmail.com', '10', '2024-11-04', '17:30:00', '2024-11-03 12:01:15', 'Completed', 120, 3, '2147483647', 1, 'Formal Shoes', 'Leather', '', NULL, '', 'Picked', 'hje', 'ghk', 'Ernakulam', '682307', 'Active', 'Pending'),
(49, 'liya@gmail.com', 'liya@gmail.com', '3', '2024-11-06', '20:18:00', '2024-11-04 14:45:38', 'Completed', 122, 10, '2147483647', 1, 'Boot', 'Canvas', '', NULL, 'Delivered', 'Delivered', 'wee', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(50, 'sandrab@gmail.com', 'sandrab@gmail.com', '2', '2024-11-07', '15:50:00', '2024-11-05 06:17:00', 'Completed', 130, 6, '2147483647', 1, 'Boot', 'Leather', '', '19', 'Delivered', 'Delivered', '32eq', 'kyu', 'Ernakulam', '682318', 'Active', 'Pending'),
(51, 'annag@gmail.com', 'annag@gmail.com', '3', '2024-11-13', '20:49:00', '2024-11-05 13:19:26', 'Completed', 128, 10, '123456789', 1, 'Sandals', 'Suede', '', '17', 'Delivered', 'Delivered', 'djh', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(52, 'liya@gmail.com', 'liya@gmail.com', '9', '2024-11-13', '19:06:00', '2024-11-05 13:33:39', 'Completed', 128, 9, '123456789', 1, 'Sneaker', 'Synthetic', '', '19', 'Delivered', 'Not Picked', 'wee', 'qwq', 'Ernakulam', '682316', 'Active', 'Pending'),
(53, 'angel@gmail.com', 'angel@gmail.com', '9', '2024-11-12', '04:00:00', '2024-11-05 16:09:25', 'Completed', 128, 9, '2147483647', 1, 'Formal Shoes', 'Suede', '', '14', 'Delivered', 'Delivered', 'utk', 'sdfq', 'Ernakulam', '682311', 'Active', 'Pending'),
(54, 'angel@gmail.com', 'angel@gmail.com', '6', '2024-11-12', '04:00:00', '2024-11-05 16:15:27', 'Completed', 128, 9, '2147483647', 1, 'Boot', 'Suede', '', '11', 'Delivered', 'Delivered', 'utk', 'sdfq', 'Ernakulam', '682311', 'Active', 'Pending'),
(55, 'sreya@gmail.com', 'sreya@gmail.com', '2', '2024-11-14', '06:00:00', '2024-11-06 04:58:17', 'Completed', 122, 9, '2147483647', 1, 'Boot', 'Suede', 'no', '17, 18', 'Delivered', 'Delivered', 'qwf', 'jds', 'Ernakulam', '682313', 'Active', 'Pending'),
(56, 'navya@gmail.com', 'navya@gmail.com', '9', '2024-11-09', '04:00:00', '2024-11-08 10:24:17', 'Completed', 120, 9, '1234567898', 1, 'Boot', 'Suede', '', '14', 'Delivered', 'Not Picked', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(57, 'navya@gmail.com', 'navya@gmail.com', '10', '2024-11-09', '04:00:00', '2024-11-08 10:30:54', 'Completed', 120, 10, '1234567898', 1, 'Sneaker', 'Suede', '', '14', 'Delivered', 'Delivered', 'dd', 'hhs', 'Ernakulam', '682315', 'Active', 'Pending'),
(59, 'savio@gmail.com', 'savio@gmail.com', '8', '2024-11-11', '06:00:00', '2024-11-10 07:32:09', 'Completed', 133, 3, '2147483647', 1, 'Sandals', 'Synthetic', '', '17', '', 'Picked', 'kna', 'qwk', 'Ernakulam', '682302', 'Active', 'Pending'),
(61, 'angel@gmail.com', 'angel@gmail.com', '3', '2024-11-12', '06:00:00', '2024-11-11 14:30:55', 'Completed', 131, 11, '1234567891', 1, 'Formal Shoes', 'Suede', '', '13', 'Delivered', 'Delivered', 'utk', 'sdfq', 'Ernakulam', '682311', 'Active', 'Pending'),
(62, 'ananya@gmail.com', 'ananya@gmail.com', '3', '2024-11-15', '06:00:00', '2024-11-11 14:49:51', 'Completed', 134, 6, '2147483647', 1, 'Heels', 'Synthetic', '', NULL, 'Delivered', 'Delivered', 'lkads', 'skn', 'Ernakulam', '682316', 'Active', 'Pending'),
(63, 'ananya@gmail.com', 'ananya@gmail.com', '2', '2024-11-12', '06:00:00', '2024-11-11 15:55:41', 'Completed', 134, 9, '1234567891', 1, 'Sneaker', 'Suede', '', '13', 'Delivered', 'Delivered', 'lkads', 'skn', 'Ernakulam', '682316', 'Active', 'Pending'),
(64, 'ananya@gmail.com', 'ananya@gmail.com', '2', '2024-11-12', '01:00:00', '2024-11-11 16:41:35', 'Completed', 134, 9, '1234567891', 1, '3', '16', '', '13', 'Delivered', 'Delivered', 'lkads', 'skn', 'Ernakulam', '682316', 'Active', 'Pending'),
(65, 'kevin@gmail.com', 'kevin@gmail.com', '23', '2024-11-15', '06:00:00', '2024-11-11 16:50:56', 'Completed', 132, 10, '1234567891', 1, '6', '15', '', '17', '', 'Not Picked', 'awk', 'fqt', 'Ernakulam', '682318', 'Active', 'Pending'),
(66, 'liya@gmail.com', 'liya@gmail.com', '24', '2024-11-14', '06:00:00', '2024-11-13 16:08:18', 'Completed', 127, 10, '1234567891', 1, '4', '4', '', '17', 'Delivered', 'Delivered', 'house', 'ert', 'Ernakulam', '682314', 'Active', 'Pending'),
(67, 'arya@gmail.com', 'arya@gmail.com', '23', '2024-11-16', '04:00:00', '2024-11-14 16:22:35', 'Completed', 129, 10, '2147483647', 1, '2', '14', '', '11', 'Delivered', 'Delivered', 'ayann', 'bb', 'Ernakulam', '682317', 'Active', 'Pending'),
(68, 'angel', 'angel@gmail.com', '24', '2024-11-30', '04:00:00', '2024-11-29 03:12:16', 'Completed', 135, 10, '2147483647', 2, '1', '6', '', '11, 17', 'Delivered', 'Delivered', '', '', '', '', 'Active', 'Pending'),
(69, 'angel', 'angel@gmail.com', '24', '2024-11-30', '04:00:00', '2024-11-29 03:12:16', 'Completed', 135, 9, '2147483647', 2, '6', '15', '', '20, 31', 'Delivered', 'Delivered', 'jhtyah', 'kjuug', 'Ernakulam', '682310', 'Active', 'Pending'),
(70, 'savio@gmail.com', 'savio@gmail.com', '23', '2024-11-30', '05:00:00', '2024-11-29 05:18:49', 'Completed', 133, 10, '2147483647', 2, '3', '7', '', '17', 'Delivered', 'Delivered', '', '', '', '', 'Cancelled', 'Pending'),
(71, 'savio@gmail.com', 'savio@gmail.com', '23', '2024-11-30', '05:00:00', '2024-11-29 05:18:49', 'Completed', 133, 11, '2147483647', 2, '5', '8', '', '20', 'Delivered', 'Delivered', 'kjwhh', 'tgg', 'Ernakulam', '682310', 'Active', 'Pending'),
(72, 'reega@gmail.com', 'reega@gmail.com', '1', '2024-11-30', '04:00:00', '2024-11-29 06:57:44', 'Completed', 136, 10, '2147483647', 1, '1', '15', '', '14, 16', 'Delivered', 'Delivered', 'dfghj', 'fghj', 'Ernakulam', '876540', 'Active', 'Pending'),
(73, 'reega@gmail.com', 'reega@gmail.com', '2', '2024-12-02', '00:00:04', '2024-11-29 07:02:07', 'Completed', 136, 11, '2147483647', 1, '2', '5', '', '13, 31', 'Delivered', 'Delivered', 'jhdgdsews', 'nvdgfx', 'Ernakulam', '683101', 'Active', 'Pending'),
(74, 'ananya@gmail.com', 'ananya@gmail.com', '6', '2024-12-04', '04:00:00', '2024-12-02 03:42:17', 'Completed', 134, 9, '2147483647', 1, '2', '5', '', '20', 'Delivered', 'Delivered', 'j4r2kl', 'nrne', 'Ernakulam', '682316', 'Active', 'Pending'),
(75, 'ananya@gmail.com', 'ananya@gmail.com', '6', '2024-12-21', '04:00:00', '2024-12-02 04:10:11', 'Completed', 134, 11, '2147483647', 1, '4', '12', '', '14', 'Delivered', 'Delivered', 'e3ww', 'q', 'Ernakulam', '682315', 'Active', 'Pending'),
(76, 'sreya@gmail.com', 'sreya@gmail.com', '2', '2024-12-10', '00:00:04', '2024-12-03 05:53:35', 'Cancelled', 122, NULL, '2147483647', 1, '3', '12', '', '30', NULL, 'Not Picked', 'gfffsghj', 'ghfgssh', 'Ernakulam', '254317', 'Active', 'Pending'),
(77, 'sreya@gmail.com', 'sreya@gmail.com', '2', '2024-12-26', '03:00:00', '2024-12-24 06:57:16', 'Completed', 122, 10, '2147483647', 1, '1', '14', '', '20', 'Delivered', 'Delivered', 'S R Nivas', 'Nadilath', 'Ernakulam', '682317', 'Active', 'Pending'),
(78, 'sreya@gmail.com', 'sreya@gmail.com', '23', '2024-12-25', '09:00:00', '2024-12-24 13:43:42', 'Completed', 122, 6, '1234567898', 1, '2', '12', '', '30', 'Delivered', 'Delivered', 'BF!', 'J Apartments', 'Ernakulam', '682317', 'Active', 'Pending'),
(79, 'sreya@gmail.com', 'sreya@gmail.com', '1', '2024-12-25', '05:00:00', '2024-12-24 13:45:38', 'Completed', 122, 11, '1234567898', 1, '1', '1', '', '13', 'Delivered', 'Delivered', 'BF!', 'J Apartments', 'Ernakulam', '682317', 'Active', 'Pending'),
(80, 'sreya@gmail.com', 'sreya@gmail.com', '2', '2024-12-25', '10:00:00', '2024-12-24 13:59:17', 'Completed', 122, 6, '2147483647', 1, '3', '3', '', '11', 'Delivered', 'Delivered', 'avbgdfhs ndj', 'ghjbkn', 'Ernakulam', '454656', 'Cancelled', 'Pending'),
(81, 'ria@gmail.com', 'ria@gmail.com', '6', '2025-01-01', '12:00:00', '2024-12-29 16:35:06', 'Completed', 137, 11, '2147483647', 1, '3', '5', '', '20', 'Delivered', 'Delivered', 'kkwtiih', 'kjjkkjw', 'Ernakulam', '682315', 'Active', 'Pending'),
(82, 'shria@gmail.com', 'shria@gmail.com', '2', '2025-01-03', '10:00:00', '2025-01-02 04:49:36', 'Completed', 138, 10, '2147483647', 2, '1', '1', 'Be on time', '11, 13, 16, 17', 'Delivered', 'Delivered', '', '', '', '', 'Cancelled', 'Pending'),
(83, 'shria@gmail.com', 'shria@gmail.com', '2', '2025-01-03', '10:00:00', '2025-01-02 04:49:36', 'Completed', 138, 10, '2147483647', 2, '2', '2', 'Be on time', '13, 17', 'Delivered', 'Delivered', 'House No 17', 'Jay Apartments', 'Ernakulam', '682315', 'Active', 'Pending'),
(84, 'Til@gmail.com', 'til@gmail.com', '1', '2025-01-03', '03:00:00', '2025-01-02 06:46:12', 'Completed', 139, 6, '7907785323', 1, '1', '1', '', '13', 'Delivered', 'Delivered', 'House Two', 'Grey Apartments', 'Ernakulam', '682315', 'Active', 'Pending'),
(85, 'cm3@gmail.com', 'cm3@gmail.com', '25', '2025-01-09', '01:00:00', '2025-01-02 07:02:36', 'Completed', 139, 9, '7937892989', 1, '6', '14', '', NULL, 'Delivered', 'Delivered', 'House Two', 'Grey Apartments', 'Ernakulam', '682315', 'Active', 'Pending'),
(87, 'Nidhin@gmail.com', 'Nidhin@gmail.com', '6', '2025-01-07', '04:00:00', '2025-01-05 06:16:42', 'Completed', 142, 10, '8965006431', 1, '6', '3', '', '17', 'Delivered', 'Delivered', 'House Eleven', 'New Apartments', 'Ernakulam', '682315', 'Active', 'Pending'),
(88, 'alwin@gmail.com', 'alwin@gmail.com', '23', '2025-01-09', '09:00:00', '2025-01-05 06:25:43', 'Completed', 125, 9, '8712007784', 1, '7', '5', '', '20', 'Delivered', 'Delivered', 'House no 12', 'Brand  Apartment', 'Ernakulam', '682312', 'Active', 'Pending'),
(89, 'liya@gmail.com', 'liya@gmail.com', '6', '2025-01-16', '04:00:00', '2025-01-05 06:59:13', 'Completed', 127, 10, '9964423577', 1, '9', '7', '', NULL, '', 'Not Picked', 'House no 18', 'Brand  Apartment', 'Ernakulam', '682312', 'Active', 'Pending'),
(90, 'Til@gmail.com', 'Til@gmail.com', '1', '2025-01-08', '04:00:00', '2025-01-06 09:25:46', 'Completed', 139, 9, '6559012890', 1, '3', '3', '', '13', 'Delivered', 'Delivered', 'House no 22', 'Street 17', 'Ernakulam', '682319', 'Active', NULL),
(91, 'msd@gmail.com', 'msd@gmail.com', '25', '2025-01-14', '06:00:00', '2025-01-06 10:54:54', 'Completed', 143, 9, '7789642489', 1, '8', '7', '', '11, 17', 'Delivered', 'Delivered', 'House 21', 'Street 13', 'Ernakulam', '682315', 'Active', NULL),
(92, 'blessy@gmail.com', 'blessy@gmail.com', '6', '2025-01-10', '07:00:00', '2025-01-06 14:34:04', 'Completed', 144, 9, '8780958987', 1, '5', '14', 'Handle with care', '14, 16', 'Delivered', 'Delivered', 'House 08', 'Street 12', 'Ernakulam', '682318', 'Active', NULL),
(93, 'navya@gmail.com', 'navya@gmail.com', '2', '2025-01-26', '02:00:00', '2025-01-06 15:20:00', 'Completed', 120, 9, '8988887967', 1, '1', '2', '', '31', 'Delivered', 'Delivered', 'House no 22', 'Street 6', 'Ernakulam', '682312', 'Active', NULL),
(94, 'alwin@gmail.com', 'alwin@gmail.com', '25', '2025-01-09', '03:00:00', '2025-01-06 15:21:28', 'Completed', 125, 6, '8989986372', 2, '3', '2', '', NULL, 'Delivered', 'Delivered', '', '', '', '', 'Active', NULL),
(95, 'alwin@gmail.com', 'alwin@gmail.com', '25', '2025-01-09', '03:00:00', '2025-01-06 15:21:28', 'Completed', 125, 6, '8989986372', 2, '7', '5', '', '14', 'Delivered', 'Delivered', 'House 34', 'Street 11', 'Ernakulam', '682317', 'Active', NULL),
(96, 'shreya@gmail.com', 'shreya@gmail.com', '25', '2025-01-08', '03:00:00', '2025-01-07 05:43:18', 'Completed', 123, 6, '5676879045', 1, '2', '13', '', '20, 31', 'Delivered', 'Delivered', 'House no 12', 'Street 14', 'Ernakulam', '682312', 'Active', NULL),
(97, 'navya@gmail.com', 'navya@gmail.com', '2', '2025-01-08', '04:00:00', '2025-01-07 06:09:19', 'Pending', 120, NULL, '4343356578', 1, '1', '2', '', '30, 31', NULL, 'Not Picked', 'House no 22', 'Street 6', 'Ernakulam', '682312', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cust_fname` varchar(100) NOT NULL,
  `cust_lname` varchar(20) NOT NULL,
  `cust_address` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cust_status` tinyint(1) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `house_name` varchar(255) NOT NULL,
  `district` varchar(100) NOT NULL,
  `pincode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `customer_email`, `username`, `password`, `cust_fname`, `cust_lname`, `cust_address`, `phone`, `gender`, `created_at`, `cust_status`, `street_name`, `house_name`, `district`, `pincode`) VALUES
(111, 'athira@gmail.com', 'athira@gmail.com\r\n\r\n', 'athira', 'athira\r\n', 'binu', 'xxxxxxxxxxxxxx', '1234567891', 'Female', '2025-01-05 12:57:56', 1, 'Street 1', 'House no 11', 'Ernakulam', '682311'),
(112, 'afwana@gmail.com', 'afwana@gmail.com', 'afwana', 'afwana', 'nazer', 'yyyyyyyyyyyyy', '56789753', 'Female', '2025-01-05 12:57:56', 1, 'Street 7', 'House no 4', 'Ernakulam', '682310'),
(113, 'ekaparna@gmail.com', 'ekaparna@gmail.com', 'ekaparna', 'ekaparna', 's', 'zzzzzzzzzzzzz', '34790780', 'Female', '2025-01-05 12:57:56', 0, 'Street 19', 'House no 09', 'Ernakulam', '682316'),
(117, 'snehajoshy@gmail.com', 'snehajoshy@gmail.com', '$2y$10$Rl6RDuy2iEbZv', 'sneha', 'joshy', '', '7565345', 'Female', '2025-01-05 13:00:17', 0, 'Street 6', 'House no 18', 'Ernakulam', '682319'),
(119, 'reenu@gmail.com', 'reenu@gmail.com', '$2y$10$9nImz6s84API428olrEnPO4rQAaCOUKGn6MIhzgU4v3EIktJo8y/6', 'reenu', 'antony', '', '37454390', 'Female', '2025-01-05 13:03:06', 0, 'Street 15', 'House no 18', 'Ernakulam', '682311'),
(120, 'navya@gmail.com', 'navya@gmail.com', '$2y$10$rK0F0di4REYp3cDxJnPoVeA39360xESCuo/FGqwkJjNWIrhxjuQZ6', 'navya', 'varghese', 'abc jjj', '8753897678', 'Female', '2025-01-05 13:00:17', 0, 'Street 6', 'House no 22', 'Ernakulam', '682312'),
(121, 'rosemary@gmail.com', 'rosemary@gmail.com', '$2y$10$ifu7XHyTh5.Ym4EwGkPAyuhN7Wca6dCoHeAXc.M.im.y8oeoL.Mgu', 'rose', 'mary', '', '8605434', 'Female', '2025-01-05 13:00:17', 0, 'Street 8', 'House no 10', 'Ernakulam', '682319'),
(122, 'sreya@gmail.com', 'sreya@gmail.com', '$2y$10$qDU3islrROesK88wRbPzNOcPnrBdxgqn6KM2W5n0w9ugnQXrlw59m', 'sreya', 'rose', 'avbgdfhs ndj', '383347699', '', '2025-01-05 13:00:17', 0, 'Street 4', 'House no 15', 'Ernakulam', '682317'),
(123, 'shreya@gmail.com', 'shreya@gmail.com', '$2y$10$UYCcRdITDjIe1T2qRA4dcesAZ2FTDGJA0gRl09QdEWmR2v9onnyUu', 'shreya', 'rajeesh', 'bvcd joi', '9891235432', 'Female', '2025-01-05 13:03:06', 0, 'Street 14', 'House no 12', 'Ernakulam', '682312'),
(124, 'anna@gmail.com', 'anna@gmail.com', '$2y$10$NTFCLEIPrxsIU31hoFoSee6CKRoZvAp//k9gNE33/t7xV9oc8NO1W', 'anna', 'j', 'aj2u', '2653678', 'Female', '2025-01-05 12:56:21', 0, 'Street 1', 'House no 12', 'Ernakulam', '682315'),
(125, 'alwin@gmail.com', 'alwin@gmail.com', '$2y$10$rKpEuSQon8i/qzDF31k0T.HI1.r9tWM/4nwmUGxpl0WIBYS3R2XtO', 'alwin', 'antony', 'iugufy', '1234567891', 'Male', '2025-01-05 13:11:33', 0, 'Street 11', 'House 34', 'Ernakulam', '682317'),
(126, 'sandra@gmail.com', 'sandra@gmail.com', '$2y$10$y4.El8PL8WTZP3vI68PPSOk5VKicDo2U1poSwnG.LPLhXHEiLGIFm', 'alwin', 'antony', 'iugufy', '1234567891', 'Male', '2025-01-05 13:03:06', 0, 'Street 3', 'House no 18', 'Ernakulam', '682315'),
(127, 'liya@gmail.com', 'liya@gmail.com', '$2y$10$h2h./5hk8XpbJivKR18p/.ntWxvLdSwYuLOUkpohwHKGjaVpO9Gm2', 'liya', 'mariya', 'qwert', '1209856328', 'Female', '2025-01-05 13:06:08', 0, 'Street 11', 'House no 15', 'Ernakulam', '682314'),
(128, 'annag@gmail.com', 'annag@gmail.com', '$2y$10$hXuMaAww0CyfRiuOKE5qlOGmuZBd7zwruPlNrP2BArqIeJ0kTPO22', 'anna', 'george', 'axdhlllq', '2147483647', 'Female', '2025-01-05 13:03:06', 0, 'Street 10', 'House no 18', 'Ernakulam', '682319'),
(129, 'arya@gmail.com', 'arya@gmail.com', '$2y$10$l26Lohq/N1igQG9G0zDXu.19aXxfgEE13SZoOnLJYqI4x1ZFj1wbG', 'arya', 'nanda', 'aryanandaa house', '2147483647', 'Female', '2025-01-05 13:03:06', 0, 'Street 7', 'House no 3', 'Ernakulam', '682315'),
(130, 'sandrab@gmail.com\r\n', 'sandrab@gmail.com', '$2y$10$8OC7.IQCGnbl.hl/jxis3uFGnLsS13Prh5vpYnQ8epJIL4P9nAhH2', 'sandra', 'b', 'jdggbbdn', '2147483647', 'Male', '2025-01-05 13:12:33', 0, 'Street 3\r\n\r\n', 'House 22', 'Ernakulam', '682314'),
(131, 'angel@gmail.com', 'angel@gmail.com', '$2y$10$1LFJpUjTNum7M.27sgKz6OSoEhNJRSPJnqaJEF0favnN69kjdi4/O', 'Angel', 'sara', 'abcd allkj', '2147483647', 'Female', '2025-01-05 13:09:43', 0, 'Street 13', 'House no 13', 'Ernakulam', '682316'),
(132, 'kevin@gmail.com', 'kevin@gmail.com', '$2y$10$1Z68kROZCYNWQPxDWN3Gd.ujVOLw.b0CixFufNc5pHh8AHBpP8tGm', 'Kevin', 'Sony', 'kkk sss', '8997654768', 'Male', '2025-01-05 13:06:08', 0, 'Street 19', 'House no 10', 'Ernakulam', '682311'),
(133, 'savio@gmail.com\r\n', 'savio@gmail.com', '$2y$10$YTGTKrfNNNc7jOIxax2pLuoIppIGv.eJpWFIsrj.8ll9El3OD68za', 'Savio', 'John', 'mmmm bbb', '7676659040', 'Male', '2025-01-05 13:10:41', 0, 'Street 1', 'House no 12', 'Ernakulam', '682315'),
(134, 'ananya@gmail.com', 'ananya@gmail.com', '$2y$10$cmEi5l0/KPAtykx3kyiEF.UgCbvkL0JF.ogD6nm9noREli2EWDuhu', 'Ananya', 'Arun', 'hh aa', '8783340941', 'Female', '2025-01-05 13:03:07', 0, 'Street 26', 'House no 32', 'Ernakulam', '682319'),
(135, 'angelrose@gmail.com', 'angelrose@gmail.com', '$2y$10$gVmDf1899MHjaLnLP8r17OU3ak/W7qOx5kVvz9ZgLvQkVqGIIKVnC', 'angelrose', 'saju', 'gshks', '7856997031', 'Female', '2025-01-05 13:09:43', 0, 'Street 21', 'House no 25', 'Ernakulam', '682305'),
(136, 'reega@gmail.com', 'reega@gmail.com', '$2y$10$nF8lGL8rvkeFdlWu2ZTyL.7kzXSzdlHgzbbUH/EmTuQEOrxhtvXXi', 'reega', 'cheriyan', 'ghjk', '9876543210', 'Female', '2025-01-05 13:08:14', 0, 'Street 14', 'House no 34', 'Ernakulam', '682315'),
(137, 'ria@gmail.com', 'ria@gmail.com', '$2y$10$aDPYPEYg8QVN2cE9CU7x0.Hn4w0aJXfI3G4f3/ZvxxAuD8PkoPyI6', 'ria', 't', 'jjkkjjewfkj', '7907392989', 'Female', '2025-01-05 13:00:17', 0, 'Street 21', 'House no 32', 'Ernakulam', '682315'),
(138, 'shria@gmail.com', 'shria@gmail.com', '$2y$10$jOdNva/HtdopYVzzB0DUcOAQqq72gCp864JAqVf/3m7KVUEW00lEK', 'shrria', 'm', 'sasqwf', '7937892989', 'Female', '2025-01-05 13:06:09', 0, 'Street 20', 'House no 18', 'Ernakulam', '682312'),
(139, 'Til@gmail.com', 'Til@gmail.com', '$2y$10$RHEQxTnGWDf.cDA1DkuayOQWlzoQN1lQLxlm0Jqz5OFhbV4BJY95q', 'Til', 'Mattews', 'ghdjfkl', '8789996532', 'Male', '2025-01-05 13:06:08', 0, 'Street 17', 'House no 22', 'Ernakulam', '682319'),
(140, 'Mithun@gmail.com', 'Mithun@gmail.com', 'mithun', 'Mithun', 'Manuel', '', '9902785423', 'Male', '2025-01-05 05:59:42', 0, 'West Streetside', 'House No 07', 'Ernakulam', '682315'),
(141, 'sanaya@gmail.com', 'sanaya@gmail.com', 'sanaya', 'sanaya', 'p', '', '6567887560', 'Female', '2025-01-05 06:03:09', 0, 'ytiuopk', 'ghjkjl', 'Ernakulam', '682315'),
(142, 'Nidhin@gmail.com', 'Nidhin@gmail.com', '$2y$10$ItjUVGh2Ku26Aw/Y/jZZ3uwH0.HRs9rpJ9uXEQRNiTx0AvRVE8Lde', 'Nidhin', 'N', '', '8745008751', 'Male', '2025-01-05 06:14:54', 0, 'New Apartments', 'House Eleven', 'Ernakulam', '682315'),
(143, 'msd@gmail.com', 'msd@gmail.com', '$2y$10$Lvq3onPOa1pTiurQDwwdq.7.UgtgPcWlmML4kb8BfvlOOx5OltWUq', 'MS', 'Devadathan', '', '9987640901', 'Male', '2025-01-06 10:54:07', 0, 'Street 13', 'House 21', 'Ernakulam', '682315'),
(144, 'blessy@gmail.com', 'blessy@gmail.com', '$2y$10$B/ri73WhWxew8oTSrPN88uaaiL3bd/CWPHLZ40lXKmiWacSF6nYni', 'Blessy', 'Shibu', '', '7870510289', 'Female', '2025-01-06 14:32:47', 0, 'Street 12', 'House 08', 'Ernakulam', '682318');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `department` varchar(50) DEFAULT NULL,
  `attendance` int(11) DEFAULT 0,
  `performance_score` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `username`, `password`, `fname`, `lname`, `phone`, `status`, `department`, `attendance`, `performance_score`, `created_at`, `updated_at`, `is_available`) VALUES
(1, 'em1@gmail.com', 'em1', 'employee1', 'w', '55598788', 'active', 'washing', 86, 4.00, '2024-10-02 05:46:27', '2024-11-08 07:58:58', 1),
(2, 'em2@gmail.com', 'em2', 'employee2', 'w', '37890', 'active', 'cleaning', 65, 2.00, '2024-10-02 05:47:25', '2024-11-09 12:44:40', 1),
(3, 'em3@gmail.com', 'em3', 'employee3', 'w', '989654345', 'active', 'washing', 0, 0.00, '2024-10-05 04:54:07', '2024-11-05 14:20:02', 1),
(5, 'em4@gmail.com', 'em4', 'employee4', 'w', '2147483647', 'active', 'cleaning', 0, 0.00, '2024-11-04 04:47:12', '2024-11-11 07:15:38', 1),
(6, 'cm1@gmail.com', 'cm1', 'cemployee1', 'c', '8789764590', 'active', 'Courier', 0, 0.00, '2024-11-09 07:21:51', '2024-11-11 07:15:43', 1),
(9, 'cm2@gmail.com', 'cm2', 'cemployee2', 'c', '9987060442', 'active', 'Courier', 0, 0.00, '2024-11-09 07:26:14', '2024-11-29 03:20:02', 1),
(10, 'cm3@gmail.com', 'cm3', 'cemployee3', 'c', '890598997 ', 'active', 'Courier', 0, 0.00, '2024-11-09 07:54:52', '2024-11-14 15:47:31', 1),
(11, 'cm4@gmail.com', 'cm4', 'cemployee4', 'c', '7865356687', 'active', 'Courier', 0, 0.00, '2024-12-26 13:45:41', '2025-01-06 10:38:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `last_restock_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `item_description`, `price`, `stock`, `reorder_level`, `supplier_name`, `last_restock_date`, `created_at`, `updated_at`, `employee_id`) VALUES
(1, 'Brush', '0', 399.01, 25, 20, 'SHOEGR', '2024-09-01', '2024-12-26 13:22:37', '2024-09-03 10:25:52', 0),
(2, 'Cleaning cloth', '0', 329.03, 23, 10, 'Aura', '2024-09-01', '2025-01-06 10:37:09', '2024-09-03 10:30:44', 0),
(3, 'Cleanser\r\n', '0', 499.02, 41, 35, 'SNEAKARE', '2024-08-08', '2025-01-06 10:29:34', '2024-09-04 10:34:08', 0),
(4, 'Petroleum jelly', '0', 229.00, 43, 30, 'AYORE', '2024-09-02', '2024-12-26 13:52:20', '2024-08-02 10:38:48', 0),
(5, 'Laundry Detergent', '0', 527.00, 40, 10, 'Shoe', '2024-12-27', '2024-12-26 13:25:20', '2024-11-05 15:00:01', 0),
(6, 'Removing stains', '0', 350.00, 25, 20, 'AYORE', '2024-12-26', '2024-12-26 13:23:55', '2024-11-05 15:22:41', 0),
(7, 'Bleach', '', 150.00, 19, 0, '', '0000-00-00', '2025-01-06 10:34:57', '2024-11-05 15:42:55', 0),
(8, 'Bleach pen', '0', 1500.00, 29, 1, ' Pink Miracle', '2025-01-06', '2025-01-06 14:21:52', '2024-11-08 09:41:02', 0),
(9, 'Leather Conditioner', 'Conditioner used on leather mostly to keep leather from drying out and deteriorating\r\n', 579.00, 35, 0, '', '0000-00-00', '2024-11-08 09:44:03', '2024-11-08 09:44:03', 0),
(17, 'Waterproofing sprays ', '', 88.00, 79, 0, '', '0000-00-00', '2025-01-06 10:29:41', '2024-11-08 09:49:55', 0),
(22, 'Bottle Fabric Cleaner', 'Bottle Fabric Cleaner For Leather, Whites, and Nubuck Sneakers', 1800.00, 15, 10, '0', '0000-00-00', '2024-12-26 14:14:12', '2024-12-26 14:14:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_usage`
--

CREATE TABLE `inventory_usage` (
  `usage_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `used_quantity` int(11) NOT NULL,
  `usage_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_usage`
--

INSERT INTO `inventory_usage` (`usage_id`, `item_id`, `employee_id`, `used_quantity`, `usage_date`) VALUES
(1, 4, 1, 1, '2024-11-02 04:33:25'),
(2, 3, 1, 1, '2024-11-02 04:33:32'),
(3, 1, 1, 1, '2024-11-05 06:02:14'),
(4, 3, 1, 1, '2024-11-05 06:13:04'),
(5, 2, 1, 1, '2024-11-06 10:28:58'),
(6, 3, 1, 1, '2024-11-06 14:09:25'),
(7, 1, 6, 1, '2024-11-14 16:37:31'),
(8, 3, 1, 2, '2024-11-27 15:39:23'),
(9, 17, 9, 3, '2024-11-29 03:21:30'),
(10, 3, 1, 4, '2025-01-06 10:29:34'),
(11, 17, 1, 6, '2025-01-06 10:29:41'),
(12, 7, 2, 1, '2025-01-06 10:34:57'),
(13, 2, 3, 3, '2025-01-06 10:37:09'),
(14, 8, 3, 2, '2025-01-06 10:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`) VALUES
(1, 'Leather'),
(2, 'Suede'),
(3, 'Canvas'),
(4, 'Synthetic'),
(5, 'Rubber'),
(6, 'Mesh'),
(7, 'Fleece'),
(8, 'Fabric'),
(9, 'Wood'),
(10, 'Cork'),
(11, 'Plastic'),
(12, 'Denim'),
(13, 'Silk'),
(14, 'Velvet'),
(15, 'Linen');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recipient` enum('individual','all') NOT NULL DEFAULT 'individual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `employee_id`, `message`, `status`, `date_sent`, `recipient`) VALUES
(1, 1, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(2, 2, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(3, 3, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(4, 5, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(5, 6, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(6, 9, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(7, 10, 'Happy holidays', 0, '2024-11-14 15:08:14', 'individual'),
(8, 6, 'good', 0, '2024-11-14 15:13:00', 'individual'),
(10, 1, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(11, 2, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(12, 3, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(13, 5, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(14, 6, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(15, 9, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(16, 10, 'good work', 1, '2024-11-14 15:16:24', 'individual'),
(17, 1, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(18, 2, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(19, 3, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(20, 5, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(21, 6, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(22, 9, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(23, 10, 'Well done', 1, '2024-11-14 15:20:47', 'individual'),
(26, 3, 'hi', 1, '2024-11-14 15:21:29', 'individual'),
(27, 5, 'hi', 1, '2024-11-14 15:21:29', 'individual'),
(28, 6, 'hi', 1, '2024-11-14 15:21:29', 'individual'),
(29, 9, 'hi', 1, '2024-11-14 15:21:29', 'individual'),
(30, 10, 'hi', 1, '2024-11-14 15:21:29', 'individual');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_sent` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `employee_id`, `customer_email`, `message`, `sent_at`, `date_sent`) VALUES
(1, 0, 'afwana@gmail.com', 'order received', '2024-09-30 12:37:08', '2024-09-11'),
(2, 0, 'afwana@gmail.com', 'order received', '2024-09-30 12:37:21', '2024-09-03'),
(3, 0, 'afwana@gmail.com', 'order received', '2024-09-30 12:37:32', '2024-09-17'),
(4, 0, 'afwana@gmail.com', 'order received', '2024-09-30 12:37:39', '2024-09-30'),
(5, 3, 'navya@gmail.com', 'In progress', '2024-11-07 14:50:47', '2024-11-07'),
(6, 3, 'navya@gmail.com', 'In progress', '2024-11-07 14:50:52', '2024-11-07'),
(7, 0, 'reenu', 'Your order #8 status has been updated to \'In Progress\'.', '2024-11-08 08:35:50', '2024-11-08'),
(8, 0, 'navya@gmail.com', 'Your order #13 status has been updated to \'In Progress\'.', '2024-11-08 08:36:34', '2024-11-08'),
(9, 0, 'navya@gmail.com', 'Your order #13 status has been updated to \'Completed\'.', '2024-11-08 08:37:22', '2024-11-08'),
(10, 0, 'navya@gmail.com', 'Your order #24 status has been updated to \'In Progress\'.', '2024-11-08 08:52:52', '2024-11-08'),
(11, 0, 'navya@gmail.com', 'Your order #24 status has been updated to \'Completed\'.', '2024-11-08 09:00:10', '2024-11-08'),
(12, 0, 'navya@gmail.com', 'Your order #26 status has been updated to \'In Progress\'.', '2024-11-08 09:07:32', '2024-11-08'),
(13, 5, 'afwana@gmail.com', 'assigned', '2024-11-08 09:07:54', '2024-11-08'),
(14, 5, 'afwana@gmail.com', 'assigned', '2024-11-08 09:08:28', '2024-11-08'),
(15, 0, 'sreya@gmail.com', 'Your order #33 has been picked up by the courier.', '2024-11-09 13:23:44', '2024-11-09'),
(16, 0, 'sreya@gmail.com', 'Your order #33 has been picked up by the courier.', '2024-11-09 13:23:50', '2024-11-09'),
(17, 0, 'savio@gmail.com', 'Your order #59 has been picked up by the courier.', '2024-11-10 08:51:31', '2024-11-10'),
(18, 0, 'savio@gmail.com', 'Your order #59 has been picked up by the courier.', '2024-11-10 08:55:08', '2024-11-10'),
(19, 0, '', 'Your order #59 has been updated to \'In Transit\'.', '2024-11-11 05:54:53', '2024-11-11'),
(20, 0, '', 'Your order #59 has been updated to \'In Transit\'.', '2024-11-11 05:55:09', '2024-11-11'),
(21, 0, '', 'Your order #36 has been updated to \'In Transit\'.', '2024-11-11 05:58:03', '2024-11-11'),
(22, 0, '', 'Your order #37 has been updated to \'Picked\'.', '2024-11-11 05:58:18', '2024-11-11'),
(23, 0, '', 'Your order #59 has been updated to \'In Transit\'.', '2024-11-11 05:58:26', '2024-11-11'),
(24, 0, '', 'Your order #59 has been updated to \'In Transit\'.', '2024-11-11 06:00:49', '2024-11-11'),
(25, 0, 'alwin@gmail.com', 'Your order #38 status has been updated to \'Picked\'.', '2024-11-11 08:26:24', '0000-00-00'),
(26, 0, 'alwin@gmail.com', 'Your order #38 status has been updated to \'In Transit\'.', '2024-11-11 08:27:25', '0000-00-00'),
(27, 0, 'alwin@gmail.com', 'Your order #38 status has been updated to \'Delivered\'.', '2024-11-11 08:27:56', '0000-00-00'),
(28, 0, 'alwin@gmail.com', 'Your order #36 status has been updated to \'In Progress\'.', '2024-11-11 08:30:15', '2024-11-11'),
(29, 0, 'alwin@gmail.com', 'Your order #36 status has been updated to \'Completed\'.', '2024-11-11 08:31:06', '2024-11-11'),
(30, 0, 'alwin@gmail.com', 'Your order #36 status has been updated to \'Completed\'.', '2024-11-11 08:31:18', '2024-11-11'),
(31, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'Delivered\'.', '2024-11-11 08:33:56', '0000-00-00'),
(32, 0, 'shreya@gmail.com', 'Your order #34 status has been updated to \'Picked\'.', '2024-11-11 17:39:11', '0000-00-00'),
(33, 0, 'shreya@gmail.com', 'Your order #34 status has been updated to \'In Transit\'.', '2024-11-12 03:43:19', '0000-00-00'),
(34, 0, 'shreya@gmail.com', 'Your order #34 status has been updated to \'Delivered\'.', '2024-11-12 03:44:23', '0000-00-00'),
(35, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:35:41', '2024-11-13'),
(36, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:37:02', '2024-11-13'),
(37, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:37:15', '2024-11-13'),
(38, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:37:28', '2024-11-13'),
(39, 0, 'liya@gmail.com', 'Your order #52 has been delivered to you.', '2024-11-13 08:37:33', '2024-11-13'),
(40, 0, 'liya@gmail.com', 'Your order #52 has been delivered to you.', '2024-11-13 08:38:02', '2024-11-13'),
(41, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:38:08', '2024-11-13'),
(42, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2024-11-13 08:38:42', '2024-11-13'),
(43, 0, 'arya@gmail.com', 'Your order #46 status has been updated to \'Picked\'.', '2024-11-13 08:47:06', '0000-00-00'),
(44, 0, 'arya@gmail.com', 'Your order #46 status has been updated to \'In Transit\'.', '2024-11-13 08:47:12', '0000-00-00'),
(45, 0, 'arya@gmail.com', 'Your order #46 status has been updated to \'Delivered\'.', '2024-11-13 08:47:20', '0000-00-00'),
(46, 0, 'angel@gmail.com', 'Your order #54 status has been updated to \'Delivered\'.', '2024-11-13 08:49:59', '0000-00-00'),
(47, 0, 'alwin@gmail.com', 'Your order #38 status has been updated to \'Completed\'.', '2024-11-13 08:53:45', '2024-11-13'),
(48, 0, 'alwin@gmail.com', 'Your order #38 status has been updated to \'Completed\'.', '2024-11-13 08:53:52', '2024-11-13'),
(49, 0, 'sreya@gmail.com', 'Your order #41 status has been updated to \'In Progress\'.', '2024-11-13 09:03:17', '2024-11-13'),
(50, 0, 'sreya@gmail.com', 'Your order #41 status has been updated to \'Completed\'.', '2024-11-13 09:03:23', '2024-11-13'),
(51, 0, 'sreya@gmail.com', 'Your order #41 status has been updated to \'Completed\'.', '2024-11-13 09:03:27', '2024-11-13'),
(52, 0, 'alwin@gmail.com', 'Your order #38 has been delivered to you.', '2024-11-13 09:04:45', '2024-11-13'),
(53, 0, 'alwin@gmail.com', 'Your order #38 has been delivered to you.', '2024-11-13 09:04:50', '2024-11-13'),
(54, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'Picked\'.', '2024-11-13 16:12:14', '0000-00-00'),
(55, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'In Transit\'.', '2024-11-13 16:12:22', '0000-00-00'),
(56, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'Delivered\'.', '2024-11-13 16:12:26', '0000-00-00'),
(57, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'In Progress\'.', '2024-11-13 16:13:27', '2024-11-13'),
(58, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'In Progress\'.', '2024-11-13 16:13:32', '2024-11-13'),
(59, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'Completed\'.', '2024-11-13 16:13:38', '2024-11-13'),
(60, 0, 'liya@gmail.com', 'Your order #66 status has been updated to \'Completed\'.', '2024-11-13 16:13:42', '2024-11-13'),
(61, 0, 'liya@gmail.com', 'Your order #66 has been delivered to you.', '2024-11-13 16:14:54', '2024-11-13'),
(62, 0, 'liya@gmail.com', 'Your order #66 has been delivered to you.', '2024-11-13 16:14:58', '2024-11-13'),
(63, 0, 'liya@gmail.com', 'Your order #45 status has been updated to \'Delivered\'.', '2024-11-14 16:40:59', '0000-00-00'),
(64, 0, 'sandrab@gmail.com', 'Your order #47 status has been updated to \'Delivered\'.', '2024-11-14 16:41:03', '0000-00-00'),
(65, 0, 'sandrab@gmail.com', 'Your order #50 status has been updated to \'Delivered\'.', '2024-11-14 16:41:07', '0000-00-00'),
(66, 0, 'sreya@gmail.com', 'Your order #55 status has been updated to \'Delivered\'.', '2024-11-14 16:41:10', '0000-00-00'),
(67, 0, 'navya@gmail.com', 'Your order #26 status has been updated to \'Completed\'.', '2024-11-14 16:41:59', '2024-11-14'),
(68, 0, 'shreya@gmail.com', 'Your order #34 status has been updated to \'Completed\'.', '2024-11-14 16:42:03', '2024-11-14'),
(69, 0, 'arya@gmail.com', 'Your order #46 status has been updated to \'Completed\'.', '2024-11-14 16:42:06', '2024-11-14'),
(70, 0, 'arya@gmail.com', 'Your order #46 status has been updated to \'Completed\'.', '2024-11-14 16:42:09', '2024-11-14'),
(71, 0, 'liya@gmail.com', 'Your order #42 status has been updated to \'Completed\'.', '2024-11-14 16:42:13', '2024-11-14'),
(72, 0, 'sandrab@gmail.com', 'Your order #47 status has been updated to \'Completed\'.', '2024-11-14 16:42:16', '2024-11-14'),
(73, 2, 'anna@gmail.com', 'Order received', '2024-11-15 09:02:32', '2024-11-15'),
(74, 2, 'anna@gmail.com', 'Received', '2024-11-15 09:02:51', '2024-11-15'),
(75, 0, 'rosemary@gmail.com', 'Your order #12 status has been updated to \'Pending\'.', '2024-11-15 09:19:24', '2024-11-15'),
(76, 0, 'angel@gmail.com', 'Your order #61 status has been updated to \'Pending\'.', '2024-11-15 09:32:23', '2024-11-15'),
(77, 0, 'kevin@gmail.com', 'Your order #65 status has been updated to \'Completed\'.', '2024-11-15 09:32:32', '2024-11-15'),
(78, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'In Progress\'.', '2024-11-15 09:32:46', '2024-11-15'),
(79, 6, 'navya@gmail.com', 'Order picked', '2024-11-15 12:46:56', '2024-11-15'),
(80, 6, 'navya@gmail.com', 'Order picked', '2024-11-15 12:47:01', '2024-11-15'),
(81, 0, 'navya@gmail.com', 'Your order #9 has been delivered to you.', '2024-11-15 13:09:07', '2024-11-15'),
(82, 0, 'navya@gmail.com', 'Your order #9 has been delivered to you.', '2024-11-15 13:09:11', '2024-11-15'),
(83, 0, 'rosemary@gmail.com', 'Your order #16 status has been updated to \'Pending\'.', '2024-11-15 13:41:49', '2024-11-15'),
(84, 0, 'sreya@gmail.com', 'Your order #30 status has been updated to \'In Progress\'.', '2024-11-15 13:41:53', '2024-11-15'),
(85, 0, 'rosemary@gmail.com', 'Your order #16 status has been updated to \'In Progress\'.', '2024-11-27 15:39:32', '2024-11-27'),
(86, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'Picked\'.', '2024-11-27 15:40:26', '0000-00-00'),
(87, 0, 'shreya@gmail.com', 'Your order #23 has been delivered to you.', '2024-11-27 15:40:34', '2024-11-27'),
(88, 0, 'shreya@gmail.com', 'Your order #23 has been delivered to you.', '2024-11-27 15:40:40', '2024-11-27'),
(89, 9, 'angelrose@gmail.com', 'Courier collected', '2024-11-29 03:20:49', '2024-11-29'),
(90, 9, 'angelrose@gmail.com', 'Courier collected', '2024-11-29 03:20:55', '2024-11-29'),
(91, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'Picked\'.', '2024-11-29 03:23:53', '0000-00-00'),
(92, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'In Transit\'.', '2024-11-29 03:24:23', '0000-00-00'),
(93, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'Delivered\'.', '2024-11-29 03:24:27', '0000-00-00'),
(94, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'Pending\'.', '2024-11-29 03:31:02', '2024-11-29'),
(95, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'In Progress\'.', '2024-11-29 03:31:08', '2024-11-29'),
(96, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'Completed\'.', '2024-11-29 03:31:20', '2024-11-29'),
(97, 0, 'annag@gmail.com', 'Your order #51 status has been updated to \'Completed\'.', '2024-11-29 03:31:25', '2024-11-29'),
(98, 0, 'annag@gmail.com', 'Your order #44 status has been updated to \'Picked\'.', '2024-11-29 03:33:43', '0000-00-00'),
(99, 0, 'annag@gmail.com', 'Your order #44 status has been updated to \'In Transit\'.', '2024-11-29 03:33:48', '0000-00-00'),
(100, 0, 'annag@gmail.com', 'Your order #44 status has been updated to \'Delivered\'.', '2024-11-29 03:33:52', '0000-00-00'),
(101, 0, 'annag@gmail.com', 'Your order #51 has been delivered to you.', '2024-11-29 03:34:17', '2024-11-29'),
(102, 0, 'annag@gmail.com', 'Your order #51 has been delivered to you.', '2024-11-29 03:34:21', '2024-11-29'),
(103, 0, 'shreya@gmail.com', 'Your order #34 has been delivered to you.', '2024-11-29 08:33:35', '2024-11-29'),
(104, 0, 'shreya@gmail.com', 'Your order #34 has been delivered to you.', '2024-11-29 08:33:38', '2024-11-29'),
(105, 0, 'sreya@gmail.com', 'Your order #41 has been delivered to you.', '2024-12-26 14:32:02', '2024-12-26'),
(106, 0, 'arya@gmail.com', 'Your order #46 has been delivered to you.', '2024-12-26 14:32:05', '2024-12-26'),
(107, 0, 'sandrab@gmail.com', 'Your order #47 has been delivered to you.', '2024-12-26 14:32:09', '2024-12-26'),
(108, 0, 'sandrab@gmail.com', 'Your order #47 has been delivered to you.', '2024-12-26 14:32:13', '2024-12-26'),
(109, 0, 'navya@gmail.com', 'Your order #15 status has been updated to \'Completed\'.', '2024-12-26 14:33:48', '2024-12-26'),
(110, 0, 'rosemary@gmail.com', 'Your order #12 status has been updated to \'Completed\'.', '2024-12-26 14:33:52', '2024-12-26'),
(111, 0, 'rosemary@gmail.com', 'Your order #12 status has been updated to \'Completed\'.', '2024-12-26 14:34:16', '2024-12-26'),
(112, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'Picked\'.', '2024-12-26 14:36:54', '0000-00-00'),
(113, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'In Transit\'.', '2024-12-26 14:36:58', '0000-00-00'),
(114, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'Delivered\'.', '2024-12-26 14:37:01', '0000-00-00'),
(115, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'In Progress\'.', '2024-12-26 14:38:26', '2024-12-26'),
(116, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'Completed\'.', '2024-12-26 14:38:32', '2024-12-26'),
(117, 0, 'liya@gmail.com', 'Your order #49 status has been updated to \'Completed\'.', '2024-12-26 14:38:37', '2024-12-26'),
(118, 0, 'sandra@gmail.com', 'Your order #37 status has been updated to \'Completed\'.', '2024-12-26 14:41:38', '2024-12-26'),
(119, 0, 'anna@gmail.com', 'Your order #27 status has been updated to \'Completed\'.', '2024-12-26 14:41:41', '2024-12-26'),
(120, 0, 'sreya@gmail.com', 'Your order #32 status has been updated to \'Completed\'.', '2024-12-26 14:41:46', '2024-12-26'),
(121, 0, 'sreya@gmail.com', 'Your order #32 status has been updated to \'Completed\'.', '2024-12-26 14:41:50', '2024-12-26'),
(122, 0, 'sreya@gmail.com', 'Your order #32 status has been updated to \'Completed\'.', '2024-12-26 14:43:06', '2024-12-26'),
(123, 0, 'reenu@gmail.com', 'Your order #8 status has been updated to \'Completed\'.', '2024-12-26 14:43:10', '2024-12-26'),
(124, 0, 'anna@gmail.com', 'Your order #28 status has been updated to \'In Progress\'.', '2024-12-26 14:43:14', '2024-12-26'),
(125, 0, 'angel', 'Your order #69 status has been updated to \'In Progress\'.', '2024-12-26 14:43:19', '2024-12-26'),
(126, 0, 'alwin@gmail.com', 'Your order #35 status has been updated to \'In Progress\'.', '2024-12-26 14:43:22', '2024-12-26'),
(127, 0, 'annag@gmail.com', 'Your order #44 status has been updated to \'Completed\'.', '2024-12-26 14:43:26', '2024-12-26'),
(128, 0, 'annag@gmail.com', 'Your order #44 status has been updated to \'Completed\'.', '2024-12-26 14:43:30', '2024-12-26'),
(129, 0, 'anna@gmail.com', 'Your order #28 status has been updated to \'Completed\'.', '2024-12-26 14:43:41', '2024-12-26'),
(130, 0, 'anna@gmail.com', 'Your order #28 status has been updated to \'Completed\'.', '2024-12-26 14:43:45', '2024-12-26'),
(131, 0, 'alwin@gmail.com', 'Your order #35 status has been updated to \'Completed\'.', '2024-12-26 14:54:14', '2024-12-26'),
(132, 0, 'angel', 'Your order #69 status has been updated to \'Completed\'.', '2024-12-26 14:54:18', '2024-12-26'),
(133, 0, 'angel', 'Your order #69 status has been updated to \'Completed\'.', '2024-12-26 14:54:20', '2024-12-26'),
(134, 0, 'til@gmail.com', 'Your order #84 status has been updated to \'Picked\'.', '2025-01-02 07:09:44', '0000-00-00'),
(135, 0, 'til@gmail.com', 'Your order #84 status has been updated to \'In Transit\'.', '2025-01-02 07:11:27', '0000-00-00'),
(136, 0, 'til@gmail.com', 'Your order #84 status has been updated to \'Delivered\'.', '2025-01-02 07:11:48', '0000-00-00'),
(137, 0, 'til@gmail.com', 'Your order #84 status has been updated to \'Delivered\'.', '2025-01-02 07:11:52', '0000-00-00'),
(138, 0, 'Til@gmail.com', 'Your order #84 status has been updated to \'In Progress\'.', '2025-01-02 07:14:59', '2025-01-02'),
(139, 0, 'Til@gmail.com', 'Your order #84 status has been updated to \'In Progress\'.', '2025-01-02 07:15:07', '2025-01-02'),
(140, 0, 'Til@gmail.com', 'Your order #84 status has been updated to \'Completed\'.', '2025-01-02 07:17:07', '2025-01-02'),
(141, 0, 'Til@gmail.com', 'Your order #84 has been delivered to you.', '2025-01-02 07:19:13', '2025-01-02'),
(142, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'Delivered\'.', '2025-01-06 07:44:17', '0000-00-00'),
(143, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'Delivered\'.', '2025-01-06 07:46:22', '0000-00-00'),
(144, 0, 'angel@gmail.com', 'Your order #53 status has been updated to \'In Transit\'.', '2025-01-06 07:46:30', '0000-00-00'),
(145, 0, 'navya@gmail.com', 'Your order #57 status has been updated to \'Delivered\'.', '2025-01-06 07:46:40', '0000-00-00'),
(146, 0, 'angel@gmail.com', 'Your order #53 status has been updated to \'Delivered\'.', '2025-01-06 07:46:48', '0000-00-00'),
(147, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'In Progress\'.', '2025-01-06 07:49:54', '2025-01-06'),
(148, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'In Progress\'.', '2025-01-06 07:49:59', '2025-01-06'),
(149, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'Completed\'.', '2025-01-06 07:50:05', '2025-01-06'),
(150, 0, 'shreya@gmail.com', 'Your order #39 status has been updated to \'Completed\'.', '2025-01-06 07:50:09', '2025-01-06'),
(151, 0, 'shreya@gmail.com', 'Your order #39 has been successfully delivered.', '2025-01-06 07:51:45', '2025-01-06'),
(152, 0, 'shreya@gmail.com', 'Your order #39 has been successfully delivered.', '2025-01-06 07:51:49', '2025-01-06'),
(153, 0, 'liya@gmail.com', 'Your order #89 status has been updated to \'In Progress\'.', '2025-01-06 07:57:30', '2025-01-06'),
(154, 0, 'liya@gmail.com', 'Your order #89 status has been updated to \'In Progress\'.', '2025-01-06 07:57:37', '2025-01-06'),
(155, 0, 'liya@gmail.com', 'Your order #89 status has been updated to \'Completed\'.', '2025-01-06 07:57:43', '2025-01-06'),
(156, 0, 'liya@gmail.com', 'Your order #89 status has been updated to \'Completed\'.', '2025-01-06 07:57:47', '2025-01-06'),
(157, 0, 'navya@gmail.com', 'Your order #56 status has been updated to \'Completed\'.', '2025-01-06 08:08:50', '2025-01-06'),
(158, 0, 'Nidhin@gmail.com', 'Your order #87 status has been updated to \'Picked\'.', '2025-01-06 08:14:06', '0000-00-00'),
(159, 0, 'Nidhin@gmail.com', 'Your order #87 status has been updated to \'In Transit\'.', '2025-01-06 08:14:50', '0000-00-00'),
(160, 0, 'Nidhin@gmail.com', 'Your order #87 status has been updated to \'Delivered\'.', '2025-01-06 08:14:54', '0000-00-00'),
(161, 0, 'Nidhin@gmail.com', 'Your order #87 status has been updated to \'Completed\'.', '2025-01-06 08:16:07', '2025-01-06'),
(162, 0, 'Nidhin@gmail.com', 'Your order #87 status has been updated to \'Completed\'.', '2025-01-06 08:16:10', '2025-01-06'),
(163, 0, 'alwin@gmail.com', 'Your order #88 status has been updated to \'Picked\'.', '2025-01-06 08:51:30', '0000-00-00'),
(164, 0, 'alwin@gmail.com', 'Your order #88 status has been updated to \'In Transit\'.', '2025-01-06 08:51:35', '0000-00-00'),
(165, 0, 'alwin@gmail.com', 'Your order #88 status has been updated to \'Delivered\'.', '2025-01-06 08:51:39', '0000-00-00'),
(166, 0, 'alwin@gmail.com', 'Your order #88 status has been updated to \'In Progress\'.', '2025-01-06 08:52:32', '2025-01-06'),
(167, 0, 'alwin@gmail.com', 'Your order #88 status has been updated to \'Completed\'.', '2025-01-06 08:52:43', '2025-01-06'),
(168, 0, 'ananya@gmail.com', 'Your order #62 status has been updated to \'Completed\'.', '2025-01-06 09:06:16', '2025-01-06'),
(169, 0, 'ananya@gmail.com', 'Your order #62 has been delivered to you.', '2025-01-06 09:09:38', '2025-01-06'),
(170, 0, 'ananya@gmail.com', 'Your order #62 has been delivered to you.', '2025-01-06 09:09:44', '2025-01-06'),
(171, 0, 'Til@gmail.com', 'Your order #84 has been delivered to you.', '2025-01-06 09:10:31', '2025-01-06'),
(172, 0, 'cm3@gmail.com', 'Your order #85 status has been updated to \'Delivered\'.', '2025-01-06 09:13:35', '0000-00-00'),
(173, 0, 'cm3@gmail.com', 'Your order #85 status has been updated to \'In Progress\'.', '2025-01-06 09:15:03', '2025-01-06'),
(174, 0, 'cm3@gmail.com', 'Your order #85 status has been updated to \'In Progress\'.', '2025-01-06 09:15:07', '2025-01-06'),
(175, 0, 'cm3@gmail.com', 'Your order #85 status has been updated to \'Completed\'.', '2025-01-06 09:15:12', '2025-01-06'),
(176, 0, 'cm3@gmail.com', 'Your order #85 status has been updated to \'Completed\'.', '2025-01-06 09:15:15', '2025-01-06'),
(177, 0, 'cm3@gmail.com', 'Your order #85 has been delivered to you.', '2025-01-06 09:19:26', '2025-01-06'),
(178, 0, 'cm3@gmail.com', 'Your order #85 has been delivered to you.', '2025-01-06 09:19:31', '2025-01-06'),
(179, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'Picked\'.', '2025-01-06 09:29:03', '0000-00-00'),
(180, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'In Transit\'.', '2025-01-06 09:30:15', '0000-00-00'),
(181, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'Delivered\'.', '2025-01-06 09:30:19', '0000-00-00'),
(182, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'In Progress\'.', '2025-01-06 09:32:27', '2025-01-06'),
(183, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'In Progress\'.', '2025-01-06 09:32:35', '2025-01-06'),
(184, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'Completed\'.', '2025-01-06 09:32:40', '2025-01-06'),
(185, 0, 'Til@gmail.com', 'Your order #90 status has been updated to \'Completed\'.', '2025-01-06 09:32:46', '2025-01-06'),
(186, 0, 'Til@gmail.com', 'Your order #90 has been delivered to you.', '2025-01-06 09:34:41', '2025-01-06'),
(187, 0, 'Til@gmail.com', 'Your order #90 has been delivered to you.', '2025-01-06 09:34:46', '2025-01-06'),
(188, 0, 'angel@gmail.com', 'Your order #61 status has been updated to \'Delivered\'.', '2025-01-06 10:23:07', '0000-00-00'),
(189, 0, 'ananya@gmail.com', 'Your order #63 status has been updated to \'Picked\'.', '2025-01-06 10:23:12', '0000-00-00'),
(190, 0, 'ananya@gmail.com', 'Your order #63 status has been updated to \'In Transit\'.', '2025-01-06 10:23:16', '0000-00-00'),
(191, 0, 'ananya@gmail.com', 'Your order #63 status has been updated to \'Delivered\'.', '2025-01-06 10:23:20', '0000-00-00'),
(192, 0, 'savio@gmail.com', 'Your order #71 status has been updated to \'Picked\'.', '2025-01-06 10:23:24', '0000-00-00'),
(193, 0, 'reega@gmail.com', 'Your order #72 status has been updated to \'Picked\'.', '2025-01-06 10:23:27', '0000-00-00'),
(194, 0, 'sreya@gmail.com', 'Your order #77 status has been updated to \'Picked\'.', '2025-01-06 10:23:31', '0000-00-00'),
(195, 0, 'savio@gmail.com', 'Your order #71 status has been updated to \'In Transit\'.', '2025-01-06 10:23:38', '0000-00-00'),
(196, 0, 'reega@gmail.com', 'Your order #72 status has been updated to \'In Transit\'.', '2025-01-06 10:23:42', '0000-00-00'),
(197, 0, 'savio@gmail.com', 'Your order #71 status has been updated to \'Delivered\'.', '2025-01-06 10:23:46', '0000-00-00'),
(198, 0, 'reega@gmail.com', 'Your order #72 status has been updated to \'Delivered\'.', '2025-01-06 10:23:50', '0000-00-00'),
(199, 0, 'sreya@gmail.com', 'Your order #77 status has been updated to \'Delivered\'.', '2025-01-06 10:23:53', '0000-00-00'),
(200, 0, 'ria@gmail.com', 'Your order #81 status has been updated to \'In Transit\'.', '2025-01-06 10:24:00', '0000-00-00'),
(201, 0, 'ria@gmail.com', 'Your order #81 status has been updated to \'Delivered\'.', '2025-01-06 10:24:04', '0000-00-00'),
(202, 0, 'shreya@gmail.com', 'Your order #34 has been delivered to you.', '2025-01-06 10:27:09', '2025-01-06'),
(203, 0, 'shreya@gmail.com', 'Your order #39 has been delivered to you.', '2025-01-06 10:27:13', '2025-01-06'),
(204, 0, 'liya@gmail.com', 'Your order #42 has been delivered to you.', '2025-01-06 10:27:16', '2025-01-06'),
(205, 0, 'annag@gmail.com', 'Your order #44 has been delivered to you.', '2025-01-06 10:27:20', '2025-01-06'),
(206, 0, 'annag@gmail.com', 'Your order #44 has been delivered to you.', '2025-01-06 10:27:24', '2025-01-06'),
(207, 0, 'ananya@gmail.com', 'Your order #62 has been delivered to you.', '2025-01-06 10:27:30', '2025-01-06'),
(208, 0, 'ananya@gmail.com', 'Your order #62 has been delivered to you.', '2025-01-06 10:27:34', '2025-01-06'),
(209, 0, 'rosemary@gmail.com', 'Your order #16 status has been updated to \'Completed\'.', '2025-01-06 10:28:33', '2025-01-06'),
(210, 0, 'shreya@gmail.com', 'Your order #17 status has been updated to \'In Progress\'.', '2025-01-06 10:28:38', '2025-01-06'),
(211, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'In Progress\'.', '2025-01-06 10:28:41', '2025-01-06'),
(212, 0, 'navya@gmail.com', 'Your order #40 status has been updated to \'In Progress\'.', '2025-01-06 10:28:45', '2025-01-06'),
(213, 0, 'sreya@gmail.com', 'Your order #55 status has been updated to \'In Progress\'.', '2025-01-06 10:28:49', '2025-01-06'),
(214, 0, 'sreya@gmail.com', 'Your order #55 status has been updated to \'In Progress\'.', '2025-01-06 10:28:54', '2025-01-06'),
(215, 0, 'shreya@gmail.com', 'Your order #17 status has been updated to \'Completed\'.', '2025-01-06 10:28:59', '2025-01-06'),
(216, 0, 'sreya@gmail.com', 'Your order #55 status has been updated to \'Completed\'.', '2025-01-06 10:29:05', '2025-01-06'),
(217, 0, 'navya@gmail.com', 'Your order #40 status has been updated to \'Completed\'.', '2025-01-06 10:29:09', '2025-01-06'),
(218, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'Completed\'.', '2025-01-06 10:29:13', '2025-01-06'),
(219, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'Completed\'.', '2025-01-06 10:29:19', '2025-01-06'),
(220, 0, 'sreya@gmail.com', 'Your order #30 status has been updated to \'Completed\'.', '2025-01-06 10:29:23', '2025-01-06'),
(221, 0, 'sreya@gmail.com', 'Your order #30 status has been updated to \'Completed\'.', '2025-01-06 10:29:26', '2025-01-06'),
(222, 0, 'ananya@gmail.com', 'Your order #64 status has been updated to \'Delivered\'.', '2025-01-06 10:33:17', '0000-00-00'),
(223, 0, 'reega@gmail.com', 'Your order #73 status has been updated to \'Delivered\'.', '2025-01-06 10:33:20', '0000-00-00'),
(224, 0, 'sreya@gmail.com', 'Your order #78 status has been updated to \'Delivered\'.', '2025-01-06 10:33:23', '0000-00-00'),
(225, 0, 'shria@gmail.com', 'Your order #82 status has been updated to \'Delivered\'.', '2025-01-06 10:33:27', '0000-00-00'),
(226, 0, 'arya@gmail.com', 'Your order #46 has been delivered to you.', '2025-01-06 10:33:55', '2025-01-06'),
(227, 0, 'sandrab@gmail.com', 'Your order #47 has been delivered to you.', '2025-01-06 10:34:00', '2025-01-06'),
(228, 0, 'cm3@gmail.com', 'Your order #85 has been delivered to you.', '2025-01-06 10:34:05', '2025-01-06'),
(229, 0, 'angel', 'Your order #69 has been delivered to you.', '2025-01-06 10:34:09', '2025-01-06'),
(230, 0, 'alwin@gmail.com', 'Your order #88 has been delivered to you.', '2025-01-06 10:34:13', '2025-01-06'),
(231, 0, 'alwin@gmail.com', 'Your order #88 has been delivered to you.', '2025-01-06 10:34:17', '2025-01-06'),
(232, 0, 'liya@gmail.com', 'Your order #45 status has been updated to \'Completed\'.', '2025-01-06 10:34:44', '2025-01-06'),
(233, 0, 'navya@gmail.com', 'Your order #57 status has been updated to \'Completed\'.', '2025-01-06 10:34:48', '2025-01-06'),
(234, 0, 'navya@gmail.com', 'Your order #57 status has been updated to \'Completed\'.', '2025-01-06 10:34:51', '2025-01-06'),
(235, 0, 'arya@gmail.com', 'Your order #67 status has been updated to \'Delivered\'.', '2025-01-06 10:35:34', '0000-00-00'),
(236, 0, 'angel@gmail.com', 'Your order #68 status has been updated to \'Delivered\'.', '2025-01-06 10:35:37', '0000-00-00'),
(237, 0, 'ananya@gmail.com', 'Your order #74 status has been updated to \'Delivered\'.', '2025-01-06 10:35:41', '0000-00-00'),
(238, 0, 'sreya@gmail.com', 'Your order #79 status has been updated to \'Delivered\'.', '2025-01-06 10:35:46', '0000-00-00'),
(239, 0, 'shria@gmail.com', 'Your order #83 status has been updated to \'Delivered\'.', '2025-01-06 10:35:49', '0000-00-00'),
(240, 0, 'liya@gmail.com', 'Your order #49 has been delivered to you.', '2025-01-06 10:35:57', '2025-01-06'),
(241, 0, 'alwin@gmail.com', 'Your order #38 has been delivered to you.', '2025-01-06 10:36:01', '2025-01-06'),
(242, 0, 'liya@gmail.com', 'Your order #66 has been delivered to you.', '2025-01-06 10:36:05', '2025-01-06'),
(243, 0, 'annag@gmail.com', 'Your order #51 has been delivered to you.', '2025-01-06 10:36:08', '2025-01-06'),
(244, 0, 'Nidhin@gmail.com', 'Your order #87 has been delivered to you.', '2025-01-06 10:36:12', '2025-01-06'),
(245, 0, 'Nidhin@gmail.com', 'Your order #87 has been delivered to you.', '2025-01-06 10:36:15', '2025-01-06'),
(246, 0, 'navya@gmail.com', 'Your order #14 status has been updated to \'Completed\'.', '2025-01-06 10:36:38', '2025-01-06'),
(247, 0, 'navya@gmail.com', 'Your order #25 status has been updated to \'Completed\'.', '2025-01-06 10:36:41', '2025-01-06'),
(248, 0, 'sandrab@gmail.com', 'Your order #50 status has been updated to \'Completed\'.', '2025-01-06 10:36:44', '2025-01-06'),
(249, 0, 'sandrab@gmail.com', 'Your order #50 status has been updated to \'Completed\'.', '2025-01-06 10:36:48', '2025-01-06'),
(250, 0, 'angel@gmail.com', 'Your order #54 status has been updated to \'Completed\'.', '2025-01-06 10:36:52', '2025-01-06'),
(251, 0, 'shreya@gmail.com', 'Your order #48 status has been updated to \'Completed\'.', '2025-01-06 10:36:56', '2025-01-06'),
(252, 0, 'shreya@gmail.com', 'Your order #48 status has been updated to \'Completed\'.', '2025-01-06 10:36:59', '2025-01-06'),
(253, 0, 'savio@gmail.com', 'Your order #59 status has been updated to \'Completed\'.', '2025-01-06 10:37:03', '2025-01-06'),
(254, 0, 'savio@gmail.com', 'Your order #70 status has been updated to \'Picked\'.', '2025-01-06 10:38:15', '0000-00-00'),
(255, 0, 'ananya@gmail.com', 'Your order #75 status has been updated to \'Delivered\'.', '2025-01-06 10:38:19', '0000-00-00'),
(256, 0, 'sreya@gmail.com', 'Your order #80 status has been updated to \'Delivered\'.', '2025-01-06 10:38:23', '0000-00-00'),
(257, 0, 'savio@gmail.com', 'Your order #70 status has been updated to \'Delivered\'.', '2025-01-06 10:38:27', '0000-00-00'),
(258, 0, 'angel@gmail.com', 'Your order #53 status has been updated to \'Completed\'.', '2025-01-06 10:38:53', '2025-01-06'),
(259, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'Completed\'.', '2025-01-06 10:41:01', '2025-01-06'),
(260, 0, 'sreya@gmail.com', 'Your order #33 status has been updated to \'Completed\'.', '2025-01-06 10:41:05', '2025-01-06'),
(261, 0, 'angel@gmail.com', 'Your order #54 status has been updated to \'Completed\'.', '2025-01-06 10:41:08', '2025-01-06'),
(262, 0, 'ananya@gmail.com', 'Your order #63 status has been updated to \'Completed\'.', '2025-01-06 10:41:11', '2025-01-06'),
(263, 0, 'ananya@gmail.com', 'Your order #63 status has been updated to \'Completed\'.', '2025-01-06 10:41:16', '2025-01-06'),
(264, 0, 'ananya@gmail.com', 'Your order #74 status has been updated to \'Completed\'.', '2025-01-06 10:41:20', '2025-01-06'),
(265, 0, 'sreya@gmail.com', 'Your order #79 status has been updated to \'Completed\'.', '2025-01-06 10:41:23', '2025-01-06'),
(266, 0, 'savio@gmail.com', 'Your order #70 status has been updated to \'Completed\'.', '2025-01-06 10:41:27', '2025-01-06'),
(267, 0, 'shria@gmail.com', 'Your order #83 status has been updated to \'Completed\'.', '2025-01-06 10:41:31', '2025-01-06'),
(268, 0, 'shria@gmail.com', 'Your order #83 status has been updated to \'Completed\'.', '2025-01-06 10:41:35', '2025-01-06'),
(269, 0, 'liya@gmail.com', 'Your order #45 status has been updated to \'Completed\'.', '2025-01-06 10:41:54', '2025-01-06'),
(270, 0, 'liya@gmail.com', 'Your order #45 status has been updated to \'Completed\'.', '2025-01-06 10:41:58', '2025-01-06'),
(271, 0, 'sreya@gmail.com', 'Your order #55 status has been updated to \'Completed\'.', '2025-01-06 10:42:01', '2025-01-06'),
(272, 0, 'savio@gmail.com', 'Your order #71 status has been updated to \'Completed\'.', '2025-01-06 10:42:05', '2025-01-06'),
(273, 0, 'ananya@gmail.com', 'Your order #75 status has been updated to \'Completed\'.', '2025-01-06 10:42:08', '2025-01-06'),
(274, 0, 'ananya@gmail.com', 'Your order #75 status has been updated to \'Completed\'.', '2025-01-06 10:42:11', '2025-01-06'),
(275, 0, 'ananya@gmail.com', 'Your order #75 status has been updated to \'Completed\'.', '2025-01-06 10:42:17', '2025-01-06'),
(276, 0, 'ananya@gmail.com', 'Your order #64 status has been updated to \'Completed\'.', '2025-01-06 10:42:21', '2025-01-06'),
(277, 0, 'sreya@gmail.com', 'Your order #80 status has been updated to \'Completed\'.', '2025-01-06 10:42:24', '2025-01-06'),
(278, 0, 'sreya@gmail.com', 'Your order #80 status has been updated to \'Completed\'.', '2025-01-06 10:42:27', '2025-01-06'),
(279, 0, 'ria@gmail.com', 'Your order #81 status has been updated to \'Completed\'.', '2025-01-06 10:42:48', '2025-01-06'),
(280, 0, 'reega@gmail.com', 'Your order #72 status has been updated to \'Completed\'.', '2025-01-06 10:42:51', '2025-01-06'),
(281, 0, 'arya@gmail.com', 'Your order #67 status has been updated to \'Completed\'.', '2025-01-06 10:42:54', '2025-01-06'),
(282, 0, 'navya@gmail.com', 'Your order #57 status has been updated to \'Completed\'.', '2025-01-06 10:42:57', '2025-01-06'),
(283, 0, 'sandrab@gmail.com', 'Your order #50 status has been updated to \'Completed\'.', '2025-01-06 10:43:00', '2025-01-06'),
(284, 0, 'sandrab@gmail.com', 'Your order #50 status has been updated to \'Completed\'.', '2025-01-06 10:43:03', '2025-01-06'),
(285, 0, 'sreya@gmail.com', 'Your order #77 status has been updated to \'Completed\'.', '2025-01-06 10:43:28', '2025-01-06'),
(286, 0, 'sreya@gmail.com', 'Your order #77 status has been updated to \'Completed\'.', '2025-01-06 10:43:31', '2025-01-06'),
(287, 0, 'shria@gmail.com', 'Your order #82 status has been updated to \'Completed\'.', '2025-01-06 10:43:58', '2025-01-06'),
(288, 0, 'angel', 'Your order #68 status has been updated to \'Completed\'.', '2025-01-06 10:44:01', '2025-01-06'),
(289, 0, 'reega@gmail.com', 'Your order #73 status has been updated to \'Completed\'.', '2025-01-06 10:44:04', '2025-01-06'),
(290, 0, 'angel@gmail.com', 'Your order #53 status has been updated to \'Completed\'.', '2025-01-06 10:44:07', '2025-01-06'),
(291, 0, 'angel@gmail.com', 'Your order #53 status has been updated to \'Completed\'.', '2025-01-06 10:44:10', '2025-01-06'),
(292, 0, 'angel@gmail.com', 'Your order #61 status has been updated to \'Completed\'.', '2025-01-06 10:44:15', '2025-01-06'),
(293, 0, 'sreya@gmail.com', 'Your order #78 status has been updated to \'Completed\'.', '2025-01-06 10:44:19', '2025-01-06'),
(294, 0, 'sreya@gmail.com', 'Your order #78 status has been updated to \'Completed\'.', '2025-01-06 10:44:20', '2025-01-06'),
(295, 0, 'liya@gmail.com', 'Your order #45 has been delivered to you.', '2025-01-06 10:49:00', '2025-01-06'),
(296, 0, 'sreya@gmail.com', 'Your order #33 has been delivered to you.', '2025-01-06 10:49:03', '2025-01-06'),
(297, 0, 'sreya@gmail.com', 'Your order #33 has been delivered to you.', '2025-01-06 10:49:05', '2025-01-06'),
(298, 0, 'sandrab@gmail.com', 'Your order #50 has been delivered to you.', '2025-01-06 10:49:09', '2025-01-06'),
(299, 0, 'sreya@gmail.com', 'Your order #78 has been delivered to you.', '2025-01-06 10:49:14', '2025-01-06'),
(300, 0, 'sreya@gmail.com', 'Your order #78 has been delivered to you.', '2025-01-06 10:49:17', '2025-01-06'),
(301, 0, 'sreya@gmail.com', 'Your order #80 has been delivered to you.', '2025-01-06 10:49:23', '2025-01-06'),
(302, 0, 'sreya@gmail.com', 'Your order #80 has been delivered to you.', '2025-01-06 10:49:25', '2025-01-06'),
(303, 0, 'angel@gmail.com', 'Your order #53 has been delivered to you.', '2025-01-06 10:50:00', '2025-01-06'),
(304, 0, 'ananya@gmail.com', 'Your order #74 has been delivered to you.', '2025-01-06 10:50:05', '2025-01-06'),
(305, 0, 'sreya@gmail.com', 'Your order #55 has been delivered to you.', '2025-01-06 10:50:08', '2025-01-06'),
(306, 0, 'sreya@gmail.com', 'Your order #55 has been delivered to you.', '2025-01-06 10:50:10', '2025-01-06'),
(307, 0, 'ananya@gmail.com', 'Your order #64 has been delivered to you.', '2025-01-06 10:50:14', '2025-01-06'),
(308, 0, 'angel@gmail.com', 'Your order #54 has been delivered to you.', '2025-01-06 10:50:17', '2025-01-06'),
(309, 0, 'angel@gmail.com', 'Your order #54 has been delivered to you.', '2025-01-06 10:50:18', '2025-01-06'),
(310, 0, 'ananya@gmail.com', 'Your order #63 has been delivered to you.', '2025-01-06 10:50:22', '2025-01-06'),
(311, 0, 'ananya@gmail.com', 'Your order #63 has been delivered to you.', '2025-01-06 10:50:24', '2025-01-06'),
(312, 0, 'reega@gmail.com', 'Your order #72 has been delivered to you.', '2025-01-06 10:50:50', '2025-01-06'),
(313, 0, 'navya@gmail.com', 'Your order #57 has been delivered to you.', '2025-01-06 10:50:53', '2025-01-06'),
(314, 0, 'arya@gmail.com', 'Your order #67 has been delivered to you.', '2025-01-06 10:50:56', '2025-01-06'),
(315, 0, 'arya@gmail.com', 'Your order #67 has been delivered to you.', '2025-01-06 10:50:57', '2025-01-06'),
(316, 0, 'sreya@gmail.com', 'Your order #77 has been delivered to you.', '2025-01-06 10:51:04', '2025-01-06'),
(317, 0, 'angel', 'Your order #68 has been delivered to you.', '2025-01-06 10:51:07', '2025-01-06'),
(318, 0, 'shria@gmail.com', 'Your order #82 has been delivered to you.', '2025-01-06 10:51:12', '2025-01-06'),
(319, 0, 'shria@gmail.com', 'Your order #82 has been delivered to you.', '2025-01-06 10:51:13', '2025-01-06'),
(320, 0, 'shria@gmail.com', 'Your order #83 has been delivered to you.', '2025-01-06 10:51:17', '2025-01-06'),
(321, 0, 'savio@gmail.com', 'Your order #70 has been delivered to you.', '2025-01-06 10:51:21', '2025-01-06'),
(322, 0, 'savio@gmail.com', 'Your order #70 has been delivered to you.', '2025-01-06 10:51:23', '2025-01-06'),
(323, 0, 'angel@gmail.com', 'Your order #61 has been delivered to you.', '2025-01-06 10:51:56', '2025-01-06'),
(324, 0, 'angel@gmail.com', 'Your order #61 has been delivered to you.', '2025-01-06 10:52:02', '2025-01-06'),
(325, 0, 'savio@gmail.com', 'Your order #71 has been delivered to you.', '2025-01-06 10:52:06', '2025-01-06'),
(326, 0, 'reega@gmail.com', 'Your order #73 has been delivered to you.', '2025-01-06 10:52:08', '2025-01-06'),
(327, 0, 'ananya@gmail.com', 'Your order #75 has been delivered to you.', '2025-01-06 10:52:11', '2025-01-06'),
(328, 0, 'sreya@gmail.com', 'Your order #79 has been delivered to you.', '2025-01-06 10:52:16', '2025-01-06'),
(329, 0, 'ria@gmail.com', 'Your order #81 has been delivered to you.', '2025-01-06 10:52:20', '2025-01-06'),
(330, 0, 'ria@gmail.com', 'Your order #81 has been delivered to you.', '2025-01-06 10:52:23', '2025-01-06'),
(331, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'Picked\'.', '2025-01-06 10:56:29', '0000-00-00'),
(332, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'Picked\'.', '2025-01-06 10:56:35', '0000-00-00'),
(333, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'In Transit\'.', '2025-01-06 10:56:40', '0000-00-00'),
(334, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'Delivered\'.', '2025-01-06 10:56:43', '0000-00-00'),
(335, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'In Progress\'.', '2025-01-06 10:58:07', '2025-01-06'),
(336, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'In Progress\'.', '2025-01-06 10:58:12', '2025-01-06'),
(337, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'Completed\'.', '2025-01-06 10:58:16', '2025-01-06'),
(338, 0, 'msd@gmail.com', 'Your order #91 status has been updated to \'Completed\'.', '2025-01-06 10:58:20', '2025-01-06'),
(339, 0, 'msd@gmail.com', 'Your order #91 has been delivered to you.', '2025-01-06 10:59:52', '2025-01-06'),
(340, 0, 'msd@gmail.com', 'Your order #91 has been delivered to you.', '2025-01-06 10:59:56', '2025-01-06'),
(341, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'Picked\'.', '2025-01-06 14:39:19', '0000-00-00'),
(342, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'In Transit\'.', '2025-01-06 14:42:55', '0000-00-00'),
(343, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'Delivered\'.', '2025-01-06 14:43:05', '0000-00-00'),
(344, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'Delivered\'.', '2025-01-06 14:43:08', '0000-00-00'),
(345, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'In Progress\'.', '2025-01-06 14:51:16', '2025-01-06'),
(346, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'In Progress\'.', '2025-01-06 14:51:20', '2025-01-06'),
(347, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'In Progress\'.', '2025-01-06 14:53:44', '2025-01-06'),
(348, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'Completed\'.', '2025-01-06 15:02:51', '2025-01-06'),
(349, 0, 'blessy@gmail.com', 'Your order #92 status has been updated to \'Completed\'.', '2025-01-06 15:02:54', '2025-01-06'),
(350, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2025-01-06 15:15:53', '2025-01-06'),
(351, 0, 'navya@gmail.com', 'Your order #10 has been delivered to you.', '2025-01-06 15:15:55', '2025-01-06'),
(352, 0, 'sreya@gmail.com', 'Your order #41 has been delivered to you.', '2025-01-06 15:16:15', '2025-01-06'),
(353, 0, 'liya@gmail.com', 'Your order #52 has been delivered to you.', '2025-01-06 15:16:19', '2025-01-06'),
(354, 0, 'navya@gmail.com', 'Your order #56 has been delivered to you.', '2025-01-06 15:16:24', '2025-01-06'),
(355, 0, 'navya@gmail.com', 'Your order #56 has been delivered to you.', '2025-01-06 15:16:27', '2025-01-06'),
(356, 0, 'blessy@gmail.com', 'Your order #92 has been delivered to you.', '2025-01-06 15:17:40', '2025-01-06'),
(357, 0, 'blessy@gmail.com', 'Your order #92 has been delivered to you.', '2025-01-06 15:17:42', '2025-01-06'),
(358, 0, 'navya@gmail.com', 'Your order #93 status has been updated to \'Picked\'.', '2025-01-06 15:25:24', '0000-00-00'),
(359, 0, 'navya@gmail.com', 'Your order #93 status has been updated to \'Delivered\'.', '2025-01-06 15:27:27', '0000-00-00'),
(360, 0, 'navya@gmail.com', 'Your order #93 status has been updated to \'In Progress\'.', '2025-01-06 15:29:14', '2025-01-06'),
(361, 0, 'navya@gmail.com', 'Your order #93 status has been updated to \'Completed\'.', '2025-01-06 15:29:24', '2025-01-06'),
(362, 0, 'navya@gmail.com', 'Your order #93 status has been updated to \'Completed\'.', '2025-01-06 15:29:36', '2025-01-06'),
(363, 0, 'navya@gmail.com', 'Your order #93 has been delivered to you.', '2025-01-06 15:30:22', '2025-01-06'),
(364, 0, 'navya@gmail.com', 'Your order #93 has been delivered to you.', '2025-01-06 15:30:24', '2025-01-06'),
(365, 0, 'alwin@gmail.com', 'Your order #94 status has been updated to \'Picked\'.', '2025-01-06 15:36:37', '0000-00-00'),
(366, 0, 'alwin@gmail.com', 'Your order #94 status has been updated to \'Delivered\'.', '2025-01-06 15:36:44', '0000-00-00'),
(367, 0, 'alwin@gmail.com', 'Your order #94 status has been updated to \'Completed\'.', '2025-01-06 15:38:22', '2025-01-06'),
(368, 0, 'alwin@gmail.com', 'Your order #94 status has been updated to \'Completed\'.', '2025-01-06 15:39:21', '2025-01-06'),
(369, 0, 'alwin@gmail.com', 'Your order #94 has been delivered to you.', '2025-01-06 15:41:37', '2025-01-06'),
(370, 0, 'alwin@gmail.com', 'Your order #94 has been delivered to you.', '2025-01-06 15:41:38', '2025-01-06'),
(371, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Picked\'.', '2025-01-06 15:44:56', '0000-00-00'),
(372, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Picked\'.', '2025-01-06 15:45:33', '0000-00-00'),
(373, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Delivered\'.', '2025-01-06 15:45:38', '0000-00-00'),
(374, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Delivered\'.', '2025-01-06 15:45:40', '0000-00-00'),
(375, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'In Progress\'.', '2025-01-06 15:47:00', '2025-01-06'),
(376, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Completed\'.', '2025-01-06 15:47:04', '2025-01-06'),
(377, 0, 'alwin@gmail.com', 'Your order #95 status has been updated to \'Completed\'.', '2025-01-06 15:47:05', '2025-01-06'),
(378, 0, 'shreya@gmail.com', 'Your order #23 has been delivered to you.', '2025-01-06 15:48:34', '2025-01-06'),
(379, 0, 'navya@gmail.com', 'Your order #9 has been delivered to you.', '2025-01-06 15:48:37', '2025-01-06'),
(380, 0, 'navya@gmail.com', 'Your order #9 has been delivered to you.', '2025-01-06 15:48:38', '2025-01-06'),
(381, 0, 'alwin@gmail.com', 'Your order #95 has been delivered to you.', '2025-01-06 15:48:42', '2025-01-06'),
(382, 0, 'alwin@gmail.com', 'Your order #95 has been delivered to you.', '2025-01-06 15:48:44', '2025-01-06'),
(383, 0, 'shreya@gmail.com', 'Your order #96 status has been updated to \'Delivered\'.', '2025-01-07 05:45:23', '0000-00-00'),
(384, 0, 'shreya@gmail.com', 'Your order #96 status has been updated to \'Completed\'.', '2025-01-07 05:46:04', '2025-01-07'),
(385, 0, 'shreya@gmail.com', 'Your order #96 status has been updated to \'Completed\'.', '2025-01-07 05:46:08', '2025-01-07'),
(386, 0, 'alwin@gmail.com', 'Your order #95 has been delivered to you.', '2025-01-07 05:46:50', '2025-01-07'),
(387, 0, 'shreya@gmail.com', 'Your order #96 has been delivered to you.', '2025-01-07 05:46:53', '2025-01-07'),
(388, 0, 'shreya@gmail.com', 'Your order #96 has been delivered to you.', '2025-01-07 05:46:55', '2025-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `employee_id` int(11) NOT NULL,
  `cleaning_status` varchar(100) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cust_id`, `service_type`, `order_status`, `total_price`, `order_date`, `employee_id`, `cleaning_status`, `assigned_to`, `booking_id`) VALUES
(1, 0, '', 'Assigned', 0.00, '2024-11-01 06:17:36', 0, '', 1, 29),
(11, 111, 'Shoe care', 'Completed', 1200.00, '2024-10-06 07:38:10', 0, 'pending', 0, 0),
(12, 112, 'Shoe repair', 'completed', 1580.00, '2024-09-30 11:20:03', 2, 'completed', 0, 0),
(13, 113, 'Shoe polish', 'Assigned', 1300.00, '2024-11-02 06:19:34', 0, 'pending', 1, 0),
(14, 0, '', 'Assigned', 0.00, '2024-11-05 06:19:46', 0, '', 2, 30),
(15, 0, '', 'Assigned', 0.00, '2024-11-01 06:18:07', 0, '', 1, 31),
(16, 0, '', 'Pending', 0.00, '2024-10-21 05:48:36', 0, '', 2, 28),
(17, 0, '', 'Pending', 0.00, '2024-10-21 06:02:30', 0, '', 2, 32),
(18, 0, '', 'Pending', 0.00, '2024-10-21 06:02:34', 0, '', 2, 27),
(19, 0, '', 'Assigned', 0.00, '2024-11-01 06:21:37', 0, '', 2, 35),
(20, 0, '', 'Assigned', 0.00, '2024-11-01 06:20:44', 0, '', 3, 40),
(21, 0, '', 'Pending', 0.00, '2024-10-23 15:49:13', 0, '', 1, 43);

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `employee_id` int(11) NOT NULL,
  `cleaning_status` varchar(100) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `Order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_reference` varchar(100) NOT NULL,
  `cust_fname` varchar(50) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `exp_month` date DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `paypal_email` varchar(100) DEFAULT NULL,
  `paypal_note` text DEFAULT NULL,
  `exp_year` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `cust_id`, `order_id`, `total_price`, `payment_date`, `payment_method`, `payment_status`, `payment_reference`, `cust_fname`, `service_id`, `card_number`, `exp_month`, `cvv`, `account_number`, `bank_name`, `ifsc_code`, `paypal_email`, `paypal_note`, `exp_year`, `booking_id`) VALUES
(113, 121, 0, 0, '2024-10-05', 'Credit Card', 1, 'payment_6700e534c60f2', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(114, 121, 0, 0, '2024-10-05', 'Credit Card', 1, 'payment_6700e5416495a', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(115, 121, 17, 0, '2024-10-05', 'PayPal', 1, 'payment_6700ef4eb5a2e', 'shreya', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(116, 118, 21, 0, '2024-10-06', 'PayPal', 1, 'payment_67022fba08d84', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 118, 22, 25, '2024-10-06', 'credit_card', 1, 'payment_6702366f9f3b9', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 118, 22, 25, '2024-10-06', 'credit_card', 1, 'payment_670236bcb4aa0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 123, 23, 12, '2024-10-07', 'paypal', 1, 'payment_67036132e75e6', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23),
(120, 123, 24, 15, '2024-10-07', 'paypal', 1, 'payment_67036359b4ae9', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23),
(121, 123, 24, 15, '2024-10-07', 'paypal', 1, 'payment_670363716fce9', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23),
(122, 120, 25, 30, '2024-10-08', 'credit_card', 1, 'payment_6704c00a57ba8', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(123, 120, 26, 18, '2024-10-08', 'credit_card', 1, 'payment_6704d03d7ece1', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(124, 122, 0, 0, '2024-10-14', 'credit_card', 1, 'payment_670cac2ecae06', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29),
(125, 122, 0, 0, '2024-10-14', 'credit_card', 1, 'payment_670cad41beab5', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29),
(126, 122, 33, 50, '2024-10-14', 'paypal', 1, 'payment_670cb4673cea9', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29),
(127, 122, 33, 50, '2024-10-14', 'credit_card', 1, 'payment_670cb46fc60c0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29),
(128, 122, 33, 50, '2024-10-14', 'bank_transfer', 1, 'payment_670cb4748a6da', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29),
(129, 123, 34, 30, '2024-10-14', 'credit_card', 1, 'payment_670cba7ce49c7', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23),
(130, 123, 34, 30, '2024-10-14', 'credit_card', 1, 'payment_670cbb0311d74', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23),
(131, 125, 36, 15, '2024-10-15', 'credit_card', 1, 'payment_670e19b2b78b9', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 35),
(132, 126, 37, 18, '2024-10-16', 'credit_card', 1, 'payment_670f6440aeda6', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37),
(133, 125, 38, 12, '2024-10-17', 'paypal', 1, 'payment_67109a26832d0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 35),
(134, 125, 39, 50, '2024-10-17', 'bank_transfer', 1, '0', NULL, 0, NULL, NULL, NULL, '1234567899', 'adtdtqdts', '263663227', NULL, NULL, NULL, 35),
(135, 125, 39, 50, '2024-10-17', 'credit_card', 1, '0', NULL, 0, '1234456767892345', '0000-00-00', '123', NULL, NULL, NULL, NULL, NULL, NULL, 35),
(136, 125, 39, 50, '2024-10-17', 'bank_transfer', 1, '0', NULL, 0, NULL, NULL, NULL, '1234567899', 'adtdtqdts', '7887765655', NULL, NULL, NULL, 35),
(137, 125, 39, 50, '2024-10-17', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'abc@gmail.com', 'aa', NULL, 35),
(138, 125, 39, 50, '2024-10-17', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'abc@gmail.com', 'aa', NULL, 35),
(139, 125, 39, 50, '2024-10-17', 'credit_card', 1, '0', NULL, 0, '1234 5678 8902', '0000-00-00', '233', NULL, NULL, NULL, NULL, NULL, NULL, 35),
(140, 125, 39, 50, '2024-10-17', 'credit_card', 1, '0', NULL, 0, '1234 5678 8902', '0000-00-00', '233', NULL, NULL, NULL, NULL, NULL, NULL, 35),
(141, 125, 39, 50, '2024-10-17', 'credit_card', 1, '0', NULL, 0, '7676', '0000-00-00', '676', NULL, NULL, NULL, NULL, NULL, NULL, 35),
(142, 125, 39, 50, '2024-10-17', 'credit_card', 1, '0', NULL, 0, '8767687', '0000-00-00', '677', NULL, NULL, NULL, NULL, NULL, NULL, 35),
(143, 122, 41, 28, '2024-10-21', 'credit_card', 1, '0', NULL, 0, '1234567891234567', '0000-00-00', '123', NULL, NULL, NULL, NULL, NULL, 2031, 29),
(144, 127, 42, 18, '2024-10-22', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'liya@gmail.com', 'paying', NULL, 42),
(145, 128, 44, 15, '2024-10-23', 'bank_transfer', 1, '0', NULL, 0, NULL, NULL, NULL, '56378845123', 'SBI', 'SBIK0957432', NULL, NULL, NULL, 44),
(146, 127, 45, 28, '2024-11-01', 'credit_card', 1, '0', NULL, 0, '1276896545453321', '0000-00-00', '656', NULL, NULL, NULL, NULL, NULL, 2024, 42),
(147, 129, 46, 25, '2024-11-01', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'arya@gmail.com', 'no', NULL, 46),
(148, 130, 47, 25, '2024-11-02', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'sandrab@gmail.com', '', NULL, 47),
(149, 120, 48, 28, '2024-11-03', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'shreya@gmail.com', '', NULL, 25),
(150, 122, 49, 40, '2024-11-04', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'liya@gmail.com', 'Paying', NULL, 29),
(151, 130, 50, 30, '2024-11-05', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'sandrab@gmail.com', '', NULL, 47),
(152, 128, 51, 40, '2024-11-05', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'annag@gmail.com', 'paying', NULL, 44),
(153, 128, 52, 15, '2024-11-05', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'liya@gmail.com', '', NULL, 44),
(154, 128, 54, 250, '2024-11-05', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'angel@gmail.com', '', NULL, 44),
(155, 122, 55, 300, '2024-11-06', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'sreya@gmail.com', 'paying', NULL, 29),
(156, 120, 57, 280, '2024-11-08', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'sreya@gmail.com', '', NULL, 40),
(157, 133, 58, 300, '2024-11-09', 'credit_card', 1, '0', NULL, 0, '1878545388753210', '0000-00-00', '774', NULL, NULL, NULL, NULL, NULL, 2025, 59),
(158, 133, 59, 180, '2024-11-10', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'savio@gmail.com', '', NULL, 59),
(159, 131, 61, 240, '2024-11-11', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'angel@gmail.com', 'paying', NULL, 61),
(160, 134, 62, 240, '2024-11-11', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ananya@gmail.com', '', NULL, 62),
(161, 132, 65, 15, '2024-11-11', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'kevin@gmail.com', '', NULL, 65),
(162, 127, 66, 25, '2024-11-13', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'liya@gmail.com', '', NULL, 42),
(163, 129, 67, 15, '2024-11-14', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'arya@gmail.com', '', NULL, 46),
(164, 135, 69, 25, '2024-11-29', 'credit_card', 1, '0', NULL, 0, '1234567891234567', '0000-00-00', '986', NULL, NULL, NULL, NULL, NULL, 2034, 68),
(165, 133, 71, 250, '2024-11-29', 'paypal', 1, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'savio@gmail.com', '', NULL, 59),
(168, 134, 0, 0, '2024-12-02', '', 0, '', NULL, 0, '', '0000-00-00', '', '', '', '', 'ananya@gmail.com', '', 0, 62),
(169, 134, 0, 0, '2024-12-02', '', 0, '', NULL, 0, '', '0000-00-00', '', '', '', '', 'ananya@gmail.com', '', 0, 62),
(170, 134, 0, 0, '2024-12-02', 'paypal', 0, 'payment_674d351836592', NULL, 0, '', '0000-00-00', '', '', '', '', 'ananya@gmail.com', '', 0, 62),
(171, 134, 0, 250, '2024-12-02', 'paypal', 1, 'payment_674d35e6edc0f', NULL, 0, '', '0000-00-00', '', '', '', '', 'ananya@gmail.com', '', 0, 62),
(172, 134, 0, 250, '2024-12-02', 'credit_card', 1, 'payment_674d3893c4a3e', NULL, 0, '1234567891234567', '0000-00-00', '567', '', '', '', 'ananya@gmail.com', '', 2035, 62),
(173, 134, 0, 250, '2024-12-02', 'credit_card', 1, 'payment_674d38d529154', NULL, 0, '8765326789229078', '0000-00-00', '341', '', '', '', 'ananya@gmail.com', '', 2037, 62),
(174, 134, 0, 250, '2024-12-02', 'paypal', 1, 'payment_674d39fc13c75', NULL, 0, '', '0000-00-00', '', '', '', '', 'ananya@gmail.com', '', 0, 62),
(175, 122, 0, 300, '2024-12-24', 'paypal', 1, 'payment_676a5fdc2ee1f', NULL, 0, '', '0000-00-00', '', '', '', '', 'sreya@gmail.com', '', 0, 76),
(176, 122, 0, 0, '2024-12-24', 'bank_transfer', 1, 'payment_676a63991ac43', NULL, 0, '', '0000-00-00', '', '12345678909', 'SBI', 'SBIK0957432', '', '', 0, 76),
(177, 122, 0, 0, '2024-12-24', 'bank_transfer', 1, 'payment_676a646328698', NULL, 0, '', '0000-00-00', '', '12345678909', 'SBI', 'SBIK0957432', 'sreya@gmail.com', '', 0, 76),
(178, 122, 0, 0, '2024-12-24', 'bank_transfer', 1, 'payment_676a663c6b85e', NULL, 0, '', '0000-00-00', '', '12345678909', 'SBI', 'SBIK0957432', '', '', 0, 76),
(179, 122, 0, 300, '2024-12-24', 'paypal', 1, 'payment_676a667d775e8', NULL, 0, '', '0000-00-00', '', '', '', '', 'sreya@gmail.com', '', 0, 76),
(180, 122, 0, 150, '2024-12-24', 'paypal', 1, 'payment_676abbc9c3b08', NULL, 0, '', '0000-00-00', '', '', '', '', 'sreya@gmail.com', '', 0, 76),
(181, 122, 0, 400, '2024-12-24', 'paypal', 1, 'payment_676ac096873e9', NULL, 0, '', '0000-00-00', '', '', '', '', 'sreya@gmail.com', '', 0, 76),
(182, 137, 0, 370, '2024-12-29', 'paypal', 1, 'payment_67717a83a665e', NULL, 0, '', '0000-00-00', '', '', '', '', 'ria@gmail.com', '', 0, 81),
(183, 138, 0, 600, '2025-01-02', 'paypal', 1, 'payment_67761b29ce90b', NULL, 0, '', '0000-00-00', '', '', '', '', 'shria@gmail.com', '', 0, 82),
(184, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_67761caff1f7e', NULL, 0, '124563748590089', '0000-00-00', '678', '', '', '', 'shria@gmail.com', '', 2637, 82),
(185, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_67761e4f149c2', NULL, 0, '123456789', '0000-00-00', '454', '', '', '', 'shria@gmail.com', '', 1234, 82),
(186, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_677620c6bd63c', NULL, 0, '1234567891234567', '0000-00-00', '123', '', '', '', 'shria@gmail.com', '', 2011, 82),
(187, 138, 0, 600, '2025-01-02', 'bank_transfer', 1, 'payment_6776212aea8f2', NULL, 0, '', '0000-00-00', '', '12344567878', 'SBI', 'SBIK0957432', 'shria@gmail.com', '', 0, 82),
(188, 138, 0, 600, '2025-01-02', 'paypal', 1, 'payment_67762135dda75', NULL, 0, '', '0000-00-00', '', '', '', '', 'shria@gmail.com', '', 0, 82),
(189, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_677622f03310b', NULL, 0, '1234567891234560', '0000-00-00', '124', '', '', '', 'shria@gmail.com', '', 2026, 82),
(190, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_67762437f27fd', NULL, 0, '1234567890123456', '0000-00-00', '123', '12345678911', 'FEDERAL BANK', 'SBIK0957432', 'shria@gmail.com', '', 2041, 82),
(191, 138, 0, 600, '2025-01-02', 'bank_transfer', 1, 'payment_6776246de6b73', NULL, 0, '', '0000-00-00', '', '12345678911', 'FEDERAL BANK', 'SBIK0957432', 'shria@gmail.com', '', 0, 82),
(192, 138, 0, 600, '2025-01-02', 'credit_card', 1, 'payment_67762532e660a', NULL, 0, '9876543211234567', '0000-00-00', '433', '', '', '', 'shria@gmail.com', '', 2026, 82),
(193, 139, 0, 300, '2025-01-02', 'credit_card', 1, 'payment_6776367d98992', NULL, 0, '1234567890999345', '0000-00-00', '456', '', '', '', '', '', 2024, 84),
(194, 139, 0, 300, '2025-01-02', 'bank_transfer', 1, 'payment_67763729e021c', NULL, 0, '1234567890999345', '0000-00-00', '456', '12345678909', 'FEDERAL BANK', 'SBIK0957432', '', '', 2024, 84),
(195, 139, 0, 300, '2025-01-02', 'paypal', 1, 'payment_6776373f9b775', NULL, 0, '1234567890999345', '0000-00-00', '456', '12345678909', 'FEDERAL BANK', 'SBIK0957432', 'til@gmail.com', '', 2024, 84),
(196, 139, 0, 180, '2025-01-02', 'credit_card', 1, 'payment_67763a2c0e3a9', NULL, 0, '1234567890999345', '0000-00-00', '456', '', '', '', '', '', 2024, 84),
(197, 127, 0, 250, '2025-01-03', 'credit_card', 1, 'payment_6777bb42df3e5', NULL, 0, '1234567898976543', '0000-00-00', '654', '', '', '', 'liya@gmail.com', 'paying', 2026, 42),
(269, 142, 0, 400, '2025-01-05', 'credit_card', 1, 'payment_677a23e947077', NULL, 0, '4567898667353561', '0000-00-00', '562', '', '', '', '', '', 2023, NULL),
(270, 125, 0, 370, '2025-01-05', 'credit_card', 1, 'payment_677a2646c1535', NULL, 0, '3267287917099313', '0000-00-00', '444', '', '', '', '', '', 0, NULL),
(271, 125, 0, 370, '2025-01-05', 'credit_card', 1, 'payment_677a2cfc467e6', NULL, 0, '3456221873879271', '0000-00-00', '122', '', '', '', '', '', 2025, NULL),
(272, 125, 0, 370, '2025-01-05', 'bank_transfer', 1, 'payment_677a2d2e22343', NULL, 0, '', '0000-00-00', '', '52773288231', 'FEDERAL BANK', 'SBIK0957432', '', '', 0, NULL),
(273, 125, 0, 370, '2025-01-05', 'paypal', 1, 'payment_677a2d3c5c88b', NULL, 0, '', '0000-00-00', '', '', '', '', 'abc@gmail.com', '', 0, NULL),
(274, 139, 0, 300, '2025-01-06', 'credit_card', 1, 'payment_677ba1b67fd99', NULL, 0, '1234567890999345', '0000-00-00', '456', '', '', '', '', '', 2025, NULL),
(275, 143, 0, 430, '2025-01-06', 'bank_transfer', 1, 'payment_677bb699a62e2', NULL, 0, '', '0000-00-00', '', '65656712781', 'AXIS BANK', 'SBIK0957432', '', '', 0, NULL),
(276, 144, 0, 730, '2025-01-06', 'paypal', 1, 'payment_677be9ece1a42', NULL, 0, '', '0000-00-00', '', '', '', '', 'blessy@gmail.com', '', 0, NULL),
(277, 120, 0, 650, '2025-01-06', 'credit_card', 1, 'payment_677bf4b755747', NULL, 0, '9849389891665144', '0000-00-00', '652', '', '', '', '', '', 2025, NULL),
(278, 125, 0, 430, '2025-01-06', 'bank_transfer', 1, 'payment_677bf52232654', NULL, 0, '', '0000-00-00', '', '34987467541', 'FEDERAL BANK', 'FEDB0123456', '', '', 0, NULL),
(279, 123, 0, 650, '2025-01-07', 'paypal', 1, 'payment_677cbf06b7d58', NULL, 0, '', '0000-00-00', '', '', '', '', 'shreya@gmail.com', '', 0, NULL),
(280, 120, 0, 930, '2025-01-07', 'credit_card', 1, 'payment_677cc53d71a3a', NULL, 0, '5445675677999878', '0000-00-00', '567', '', '', '', '', '', 2025, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_category` enum('Main','Add-on') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_category`, `price`, `description`, `photo`) VALUES
(1, 'Basic Cleaning', 'Main', 150.00, 'Our Basic Cleaning service is perfect for refreshing your shoes with a thorough cleaning. We remove dirt, stains, and surface debris, leaving your shoes looking fresh and revitalized. Ideal for everyday shoes that need a quick refresh.', 'images/bc.jpeg\r\n'),
(2, 'Deep Cleaning', 'Main', 300.00, ' Our Deep Cleaning service provides a comprehensive cleaning solution for heavily soiled shoes. We clean the interior and exterior, removing embedded dirt, grime, and bacteria, restoring the shoes to a like-new condition. ', 'images/dp.jpg'),
(3, 'Repair Service', 'Main', 240.00, ' We offer expert repair services to fix worn-out or damaged shoes. From sole replacement to stitching repairs, we ensure that your shoes are restored to their original condition, giving them a longer life. Ideal for shoes with structural damage or heavy wear.', 'images/p8.jpg'),
(6, 'Stain Removal', 'Main', 250.00, ' Our Stain Removal service targets tough stains on all types of materials, including suede, leather, and fabric. Using specialized techniques, we carefully remove stubborn stains, ensuring your shoes look clean and pristine without any damage to the fabric.', 'images/st.jpeg'),
(7, 'Custom Service', 'Main', 500.00, ' For shoes that require unique or personalized care, our Custom Service is the perfect choice. Whether it’s a special repair, cleaning, or a combination of services, we tailor our approach to meet the specific needs of your shoes, ensuring they get the best treatment possible.', 'images/cs.jpeg'),
(9, 'Polishing', 'Main', 150.00, 'Our Polishing service is perfect for restoring the shine and gloss of your leather shoes. Using premium polishes, we bring back the luster and protect your shoes from further wear and tear, ensuring they stay looking sharp.', 'images/sp.jpeg'),
(10, 'Leather Treatment', 'Main', 280.00, 'Keep your leather shoes looking luxurious with our Leather Treatment service. We use high-quality conditioners and treatments to nourish and protect the leather, preventing cracks, restoring softness, and maintaining the shine.', 'images/p5.jpeg'),
(11, 'Lace Replacement', 'Add-on', 100.00, ' Replace your old, frayed laces with our Lace Replacement service. Choose from a variety of colors and materials to match your shoes and add a fresh, stylish touch. Perfect for worn-out or missing laces.', 'images/lr.jpeg'),
(13, 'Insole Replacement', 'Add-on', 150.00, ' Replace your worn-out insoles with our Insole Replacement service. We offer comfortable and durable insoles that will improve the fit of your shoes, providing better support and cushioning for all-day comfort.', 'images/in.jpg'),
(14, 'Color Restoration', 'Add-on', 250.00, ' Restore the original color of your shoes with our Color Restoration service. Whether it’s faded leather or scuffed fabric, we bring back the rich hues of your shoes, ensuring they look vibrant and well-maintained.', 'images/cl.jpeg'),
(16, 'Heel Replacement', 'Add-on', 230.00, ' Our Heel Replacement service restores worn-out heels on your shoes, ensuring comfort and stability. Whether you need a complete heel replacement or just a refresh, we will ensure your shoes are as good as new.', 'images/h.jpeg'),
(17, 'Scratch Repair', 'Add-on', 150.00, ' Our Scratch Repair service effectively removes scratches and scuffs from your shoes, restoring their smooth appearance. We use specialized products and techniques to smooth out imperfections, leaving your shoes looking flawless.', 'images/sc.jpg'),
(20, 'Stain Guard Application', 'Add-on', 120.00, 'Protect your shoes from future stains with our Stain Guard Application. We apply a protective coating that prevents dirt and stains from penetrating the fabric, helping to keep your shoes clean for longer.', 'images/sg.jpg'),
(23, 'Shoe Cleaning', 'Main', 250.00, 'We provide expert cleaning for all types of shoes, ensuring they look fresh and new. Our cleaning process includes removing dirt, stains, and odors while preserving the material.', 'images/t4.jpg'),
(24, 'Shoe Restoration', 'Main', 250.00, 'Bring your old shoes back to life with our restoration service. We repair scuffs, replace laces, and fix soles to ensure your shoes are as good as new.', 'images/t5.jpg'),
(25, 'Waterproofing', 'Main', 180.00, 'Protect your shoes from water damage with our Waterproofing service. We apply a high-quality waterproofing treatment that creates a barrier against moisture, keeping your shoes dry and safe in any weather.', 'images/t6.jpg'),
(26, 'Shoe Deodorizing', 'Main', 100.00, 'Say goodbye to smelly shoes! Our deodorizing service removes odors and leaves your shoes smelling fresh and clean.', 'images/p2.jpeg'),
(29, 'Stain Removal', 'Add-on', 220.00, ' Our Stain Removal service targets tough stains on all types of materials, including suede, leather, and fabric. Using specialized techniques, we carefully remove stubborn stains, ensuring your shoes look clean and pristine without any damage to the fabric.', 'images/t3.jpg'),
(30, 'Sole Repair', 'Add-on', 280.00, 'Extend the life of your shoes with our sole repair service. We expertly repair worn-out or damaged soles, ensuring your shoes are both comfortable and durable for continued wear.', 'images/sl.jpg'),
(31, 'Leather Conditioning', 'Add-on', 350.00, 'Keep your leather shoes looking luxurious with our conditioning service. We use high-quality products to nourish and protect leather, restoring shine and softness while preventing cracks and wear.', 'images/t11.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `shoe_materials`
--

CREATE TABLE `shoe_materials` (
  `shoe_type_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoe_types`
--

CREATE TABLE `shoe_types` (
  `shoe_type_id` int(11) NOT NULL,
  `shoe_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoe_types`
--

INSERT INTO `shoe_types` (`shoe_type_id`, `shoe_type_name`) VALUES
(1, 'Sneakers'),
(2, 'Boot'),
(3, 'Formal Shoes'),
(4, 'Sandals'),
(5, 'Heels'),
(6, 'Running Shoes'),
(7, 'Slippers'),
(8, 'Loafers'),
(9, 'Wedges'),
(10, 'Flip Flops');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `testimonial` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `cust_id`, `testimonial`, `date_posted`) VALUES
(1, 120, 'Good shoe cleaning', '2024-12-25 13:55:27'),
(2, 133, 'Best services', '2024-10-31 13:56:36'),
(3, 128, 'Customized cleaning services', '2025-01-03 10:08:28'),
(4, 129, 'Good cleaning', '2024-11-15 10:10:02'),
(5, 127, 'Affordable rates', '2024-01-18 10:11:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `assigned_employee_id` (`employee_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `employee_id_id` (`employee_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`order_id`,`service_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_booking_id` (`booking_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `shoe_materials`
--
ALTER TABLE `shoe_materials`
  ADD PRIMARY KEY (`shoe_type_id`,`material_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `shoe_types`
--
ALTER TABLE `shoe_types`
  ADD PRIMARY KEY (`shoe_type_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=389;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `shoe_types`
--
ALTER TABLE `shoe_types`
  MODIFY `shoe_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  ADD CONSTRAINT `inventory_usage_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`),
  ADD CONSTRAINT `inventory_usage_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `orderss`
--
ALTER TABLE `orderss`
  ADD CONSTRAINT `orderss_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `orderss_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `orderss_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `order_services`
--
ALTER TABLE `order_services`
  ADD CONSTRAINT `order_services_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`Order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE SET NULL;

--
-- Constraints for table `shoe_materials`
--
ALTER TABLE `shoe_materials`
  ADD CONSTRAINT `shoe_materials_ibfk_1` FOREIGN KEY (`shoe_type_id`) REFERENCES `shoe_types` (`shoe_type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shoe_materials_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
