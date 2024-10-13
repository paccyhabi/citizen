-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 09:29 AM
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
-- Database: `pvms`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departmentId` int(11) NOT NULL,
  `departmentName` varchar(40) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentId`, `departmentName`, `createdAt`, `createdBy`) VALUES
(1, 'ICT', '2024-09-27 16:19:14', 1),
(2, 'Civil engeneering', '2024-09-28 11:06:03', 5);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `optionId` int(11) NOT NULL,
  `optionName` varchar(40) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`optionId`, `optionName`, `departmentId`, `createdAt`, `createdBy`) VALUES
(1, 'Information Technology(IT)', 1, '2024-09-27 16:19:48', 1),
(2, 'Multimedia', 1, '2024-09-27 16:20:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `pagination` int(4) NOT NULL,
  `author` varchar(50) NOT NULL,
  `supervisorId` int(11) NOT NULL,
  `optionId` int(11) NOT NULL,
  `yearr` varchar(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectId`, `projectName`, `pagination`, `author`, `supervisorId`, `optionId`, `yearr`, `createdAt`, `createdBy`) VALUES
(1, 'Project verification management system', 70, 'Daniel cruz', 1, 1, '2024', '2024-09-27 16:21:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `supervisorId` int(11) NOT NULL,
  `supervisorName` varchar(50) NOT NULL,
  `supervisorEmail` varchar(70) NOT NULL,
  `supervisorPhone` varchar(13) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `createadAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`supervisorId`, `supervisorName`, `supervisorEmail`, `supervisorPhone`, `departmentId`, `createadAt`, `createdBy`) VALUES
(1, 'Manyange', 'manyange@gmail.com', '2345678', 1, '2024-09-27 16:20:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_link_token` varchar(64) DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `password`, `reset_link_token`, `exp_date`, `createdAt`, `role`) VALUES
(1, 'admin', 'ndayisabadaniel250@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, '0000-00-00 00:00:00', '2024-06-12 17:59:53', 'admin'),
(2, 'student1', 'student1@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, '2024-09-28 09:09:54', 'student'),
(3, 'student2', 'student2@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, '2024-09-28 10:00:25', 'student'),
(4, 'manager', 'manager@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, '2024-09-28 10:57:08', 'manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departmentId`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`optionId`),
  ADD KEY `departmentId` (`departmentId`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `optionId` (`optionId`),
  ADD KEY `supervisorId` (`supervisorId`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`supervisorId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`username`,`email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_link_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `optionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `supervisorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `departments` (`departmentId`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`optionId`) REFERENCES `options` (`optionId`),
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`supervisorId`) REFERENCES `supervisors` (`supervisorId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
