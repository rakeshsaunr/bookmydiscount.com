-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 04:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eds_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_ivantory_name`
--

CREATE TABLE `add_ivantory_name` (
  `id` int(11) NOT NULL,
  `inventory_id` varchar(50) NOT NULL,
  `store_id` varchar(50) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `inventory_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Stock_use` enum('Unused','Used') NOT NULL DEFAULT 'Unused',
  `remaining` int(11) NOT NULL DEFAULT 0,
  `use_datetime` datetime DEFAULT NULL,
  `Total_stock` int(11) NOT NULL DEFAULT 1,
  `inventory_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `Net_payment` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `add_ivantory_name`
--

INSERT INTO `add_ivantory_name` (`id`, `inventory_id`, `store_id`, `store_name`, `inventory_name`, `created_at`, `Stock_use`, `remaining`, `use_datetime`, `Total_stock`, `inventory_status`, `Net_payment`) VALUES
(1, 'INV 1', 'BMD001', 'Store 1', 'INV NAME 000', '2024-12-31 07:38:05', 'Unused', 1, '2025-01-02 13:54:31', 0, 'Active', 0.00),
(2, 'INV 2', 'BMD002', 'Store 2', 'INV', '2024-12-31 07:38:58', 'Unused', 0, '2025-01-02 13:41:31', 1, 'Active', 0.00),
(3, 'INV 2', 'BMD002', 'Store 2', 'NAME', '2024-12-31 07:38:58', 'Unused', 0, '2025-01-02 13:41:34', 1, 'Active', 0.00),
(4, 'INV 2', 'BMD002', 'Store 2', '001', '2024-12-31 07:38:58', 'Unused', 0, '2025-01-02 12:50:16', 1, 'Active', 0.00),
(5, 'INV 5', 'BMD001', 'Store 1', 'WWW', '2024-12-31 11:16:05', 'Unused', 1, '2025-01-02 13:41:20', 0, 'Active', 0.00),
(6, 'INV 5', 'BMD001', 'Store 1', 'FOOD', '2024-12-31 11:16:12', 'Unused', 0, '2025-01-02 12:50:20', 1, 'Active', 0.00);

--
-- Triggers `add_ivantory_name`
--
DELIMITER $$
CREATE TRIGGER `update_use_datetime_before_update` BEFORE UPDATE ON `add_ivantory_name` FOR EACH ROW BEGIN
  IF NEW.Stock_use != OLD.Stock_use THEN
    SET NEW.use_datetime = NOW();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `add_new_stores`
--

CREATE TABLE `add_new_stores` (
  `id` int(11) NOT NULL,
  `store_id` varchar(50) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `add_new_stores`
--

INSERT INTO `add_new_stores` (`id`, `store_id`, `store_name`, `created_at`) VALUES
(1, 'BMD001', 'Store 1', '2024-12-31 06:29:04'),
(2, 'BMD002', 'Store 2', '2024-12-31 07:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `store_inventory_log`
--

CREATE TABLE `store_inventory_log` (
  `id` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `inventory_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `payable_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `display_id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `last_login` bigint(20) NOT NULL,
  `last_activity` time DEFAULT NULL,
  `status` varchar(20) DEFAULT '',
  `session_start_time` time DEFAULT NULL,
  `logout_time` time DEFAULT NULL,
  `idle_time` time DEFAULT NULL,
  `Earned_Leave` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Casual_Leave` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Medical_Leave` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Without_Pay` decimal(5,2) NOT NULL DEFAULT 0.00,
  `team_leader_name` varchar(50) DEFAULT NULL,
  `Employee_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `display_id`, `name`, `username`, `password`, `role`, `last_login`, `last_activity`, `status`, `session_start_time`, `logout_time`, `idle_time`, `Earned_Leave`, `Casual_Leave`, `Medical_Leave`, `Without_Pay`, `team_leader_name`, `Employee_code`) VALUES
(101, 'EDS101', 'Mukul kotnala', 'admin', 'admin', 'admin', 1735116556, NULL, 'Online', '13:50:33', '14:18:56', '13:50:33', 5.00, 5.00, 10.00, 10.00, 'rakesh chacha ji ', 'UKEDS/101'),
(102, 'EDS102', 'Shubham kotnala', 'user1', 'user1', 'user', 1711538292, '15:31:40', 'Online', '11:47:31', '13:03:24', '11:47:31', 0.00, 0.00, 7.00, 10.00, 'Vikash Kumar', 'UKEDS/102'),
(103, 'EDS103', 'Bhaavit Gupta', 'employee2', 'employee2', 'user', 1709634197, NULL, 'Offline', '15:53:07', '15:53:58', '15:53:07', 5.00, 5.00, 10.00, 10.00, 'Vikash Kumar', 'UKEDS/103'),
(104, 'EDS104', 'Namit Gupta', 'employee3', 'employee3', 'user', 1709634551, NULL, 'Offline', '15:59:01', '15:59:07', '15:59:01', 4.00, 5.00, 10.00, 10.00, 'Shehazad', 'UKEDS/104'),
(105, 'EDS0', 'shivani', 'a', 'a', 'manager', 1710952483, NULL, 'Offline', '22:04:33', '22:04:46', '22:04:33', 5.00, 5.00, 10.00, 10.00, 'Vikash Kumar', 'UKEDS/105'),
(106, 'EDS0', 'TL Name', 'b', 'b', 'manager', 1707285120, NULL, 'Offline', '11:21:50', '11:31:16', '11:21:50', 5.00, 5.00, 10.00, 10.00, 'Shehazad', 'UKEDS/106'),
(107, 'EDS0', 'Manager Name', 'c', 'c', 'manager', 1707979388, NULL, 'Online', '12:12:58', '10:57:45', '12:12:58', 5.00, 5.00, 10.00, 10.00, 'Ajay Saini', 'UKEDS/107'),
(108, 'EDS0', 'ajay', 'fsdhasfds', 'shubham', 'user', 1709634677, NULL, 'Online', '16:01:06', NULL, '16:01:06', 5.00, 5.00, 10.00, 10.00, 'Ajay Saini', 'UKEDS/108'),
(109, 'EDS0', 'maya', 'fsdhasfds', 'shubham', 'user', 0, NULL, '', NULL, NULL, NULL, 5.00, 5.00, 10.00, 10.00, 'Ajay Saini', 'UKEDS/109'),
(110, 'EDS0', 'jay', 'tttttt', 'tttttt', 'user', 1709634647, NULL, 'Offline', '16:00:37', '16:01:00', '16:00:37', 5.00, 5.00, 10.00, 10.00, 'Ajay Saini', 'UKEDS/110'),
(111, 'EDS0', 'tarun', 'tarun', 'tarun', 'user', 1709100680, NULL, 'Offline', '11:41:10', '11:46:34', '11:41:10', 5.00, 5.00, 10.00, 10.00, 'Shehazad', 'UKEDS/111'),
(112, 'EDS0', 'kotnala', 'kotnala', 'shubham@123', 'user', 0, NULL, '', NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Shehazad', 'UKEDS/112');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_ivantory_name`
--
ALTER TABLE `add_ivantory_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_new_stores`
--
ALTER TABLE `add_new_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_inventory_log`
--
ALTER TABLE `store_inventory_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_ivantory_name`
--
ALTER TABLE `add_ivantory_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `add_new_stores`
--
ALTER TABLE `add_new_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_inventory_log`
--
ALTER TABLE `store_inventory_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
