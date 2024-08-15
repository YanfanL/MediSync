-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 08:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `superuser` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(64) NOT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `superuser`, `email`, `phone`) VALUES
(1, 'nipun', '$2y$10$.Zix06SWQpae6oEMsAqkVOY1f2SAV.fyVmnQGAOpjsBmQOGAB5ZHa', 0, 'nipungoyal3112@gmail.com', NULL),
(2, 'ok', '$2y$10$4yATWQYGzvAJF2JHL0PWfuCVOCTR84rKWETNxLs8zCp5RAon1MhVm', 0, 'ok@gmail.com', NULL),
(3, 'admin', '$2y$10$8xWMGQ6Th/Ruo9U4DeT5HOhBb9xRMgdnmq0BFS3m3mefwKeEJeyPu', 1, 'admin@gmail.com', NULL),
(4, 'foad', '$2y$10$7InQX/wlurODqWzHQXGp1upameP0a4YiY0S4VKi34wqPatsktmRW2', 0, 'foad@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `aptNumber` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Time` time NOT NULL,
  `Day` text NOT NULL,
  `medicalLicence` int(11) DEFAULT NULL,
  `healthNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`aptNumber`, `Status`, `Time`, `Day`, `medicalLicence`, `healthNo`) VALUES
(3, 'Unavailable', '11:00:00', 'Saturday', 8769870, 0),
(11, 'Unavailable', '17:30:00', 'Thursday', 123, 0),
(16, 'Unavailable', '17:30:00', 'Sunday', 3, 0),
(18, 'Reserved', '17:00:00', 'Sunday', 123, 10),
(20, 'Available', '11:30:00', 'Saturday', 8769870, 0),
(21, 'Available', '15:00:00', 'Monday', 8769870, 0),
(22, 'Reserved', '14:30:00', 'Tuesday', 123, 120),
(23, 'Available', '14:30:00', 'Wednesday', 15, 0),
(24, 'Available', '11:30:00', 'Friday', 123, 0),
(25, 'Available', '10:00:00', 'Thursday', 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `medicalLicence` int(11) NOT NULL,
  `doctorName` text NOT NULL,
  `email` text NOT NULL,
  `phoneNo` int(11) NOT NULL,
  `address` text NOT NULL,
  `specialization` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`medicalLicence`, `doctorName`, `email`, `phoneNo`, `address`, `specialization`) VALUES
(3, 'Nipun', 'nipun@gmail.com', 2, '2', 'General'),
(15, 'Foad', 'Foad@gmail.com', 123467786, '1222', 'Heart'),
(20, 'Kaeden', 'kaeden@gmail.com', 1236787934, 'testing testing', 'psychiatrist'),
(123, 'Baljit', 'baljit@gmail.com', 604, '789 ', 'Eye'),
(8769870, 'Yanfan', 'yanfan@gmail.com', 1234567658, '7896 street', 'Cancer');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `healthNo` int(7) NOT NULL,
  `email` text NOT NULL,
  `phoneNo` int(10) NOT NULL,
  `address` text NOT NULL,
  `gender` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`fname`, `lname`, `healthNo`, `email`, `phoneNo`, `address`, `gender`) VALUES
('Baljit', 'Singh', 0, 'nipun@gmail.com', 2147483647, '12666 72 ave', 'Male'),
('Nukhet', 'Tuncbilek', 10, 'rajandeep@gmail.com', 2147483647, '778 street , Surrey,bc', 'Female'),
('nipun', 'goyal', 120, 'Nipun@gmail.com', 604, '4', 'Male'),
('John', 'Wallace', 1010, 'John@test.ca', 236, '00', 'Male'),
('aba', 'daba', 1024, '1@gmail.com', 7, '7', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `documentId` int(11) NOT NULL,
  `pdf_file` text NOT NULL,
  `healthNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`aptNumber`),
  ADD KEY `medicalLicence` (`medicalLicence`),
  ADD KEY `healthNo` (`healthNo`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`medicalLicence`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`healthNo`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`documentId`),
  ADD KEY `healthNo` (`healthNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `aptNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `documentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`medicalLicence`) REFERENCES `doctors` (`medicalLicence`),
  ADD CONSTRAINT `availability_ibfk_2` FOREIGN KEY (`healthNo`) REFERENCES `registration` (`healthNo`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`healthNo`) REFERENCES `registration` (`healthNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
