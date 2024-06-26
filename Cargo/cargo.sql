-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 01:09 PM
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
-- Database: `cargo`
--

-- --------------------------------------------------------

--
-- Table structure for table `export`
--

CREATE TABLE `export` (
  `furnitureId` int(11) NOT NULL,
  `exportDate` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `export`
--

INSERT INTO `export` (`furnitureId`, `exportDate`, `quantity`) VALUES
(2, 'coat', 20),
(1, '2024-04-05 12:04:05', 50),
(1, '2024-04-05 12:04:38', 50),
(1, '2024-04-05 12:04:03', 12),
(3, '2024-04-05 12:04:47', 2),
(3, '2024-04-05 12:04:02', 5);

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `furnitureId` int(11) NOT NULL,
  `furnitureName` varchar(50) NOT NULL,
  `furnitureOwnerName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`furnitureId`, `furnitureName`, `furnitureOwnerName`) VALUES
(1, 'shoes', 'mugenzi'),
(2, 'coat', 'mugwiza'),
(3, 'sugar', 'muhire');

-- --------------------------------------------------------

--
-- Table structure for table `import`
--

CREATE TABLE `import` (
  `furnitureId` int(11) NOT NULL,
  `importDate` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `import`
--

INSERT INTO `import` (`furnitureId`, `importDate`, `quantity`) VALUES
(1, 'shoes', 36),
(2, 'coat', 17),
(1, 'shoes', 12),
(1, '2024-04-05 11:04:17', 2),
(3, '2024-04-05 12:04:50', 14);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `managerId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`managerId`, `username`, `password`) VALUES
(1, 'hakizimana@gmail.com', 'hakiza');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `export`
--
ALTER TABLE `export`
  ADD KEY `furnitureId` (`furnitureId`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`furnitureId`);

--
-- Indexes for table `import`
--
ALTER TABLE `import`
  ADD KEY `furnitureId` (`furnitureId`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`managerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `furnitureId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `managerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `export`
--
ALTER TABLE `export`
  ADD CONSTRAINT `export_ibfk_1` FOREIGN KEY (`furnitureId`) REFERENCES `furniture` (`furnitureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `import`
--
ALTER TABLE `import`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`furnitureId`) REFERENCES `furniture` (`furnitureId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
