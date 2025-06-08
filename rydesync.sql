-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 05:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rydesync`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceptedrides`
--

CREATE TABLE `acceptedrides` (
  `RideID` int(11) NOT NULL,
  `Pickup` varchar(50) DEFAULT NULL,
  `DropOff` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acceptedrides`
--

INSERT INTO `acceptedrides` (`RideID`, `Pickup`, `DropOff`) VALUES
(20, 'Kolachi', 'Fast');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `UserID` varchar(30) NOT NULL,
  `Country` varchar(30) DEFAULT NULL,
  `state` varchar(30) NOT NULL,
  `Street` varchar(20) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `postalcode` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`UserID`, `Country`, `state`, `Street`, `City`, `postalcode`) VALUES
('akshay', 'Pakistan', 'Sindh', 'Forum Mall', 'Karachi', '65700'),
('hassan', 'Pakistan', 'Sindh', 'Gulshen-e-Iqbal', 'Karachi', '98700'),
('jatin', 'Pakistan', 'Sindh', 'Forum Mall', 'Karachi', '75600'),
('neeraj', 'Pakistan', 'Sindh', 'Aashiana Street', 'Karachi', '76500');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`Username`, `Password`) VALUES
('akshay', '123'),
('hassan', '123'),
('jatin', '123'),
('neeraj', '123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `UserID` varchar(30) NOT NULL,
  `Message` varchar(200) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` > 0 and `Rating` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `UserID`, `Message`, `Rating`) VALUES
(0, 'akshay', 'nice driver', 5);

-- --------------------------------------------------------

--
-- Table structure for table `offering`
--

CREATE TABLE `offering` (
  `OfferingNo` int(11) NOT NULL,
  `OfferingID` varchar(30) NOT NULL,
  `Status` varchar(30) DEFAULT NULL,
  `SeatsCount` int(11) NOT NULL,
  `Amount` decimal(6,2) DEFAULT NULL CHECK (`Amount` >= 0),
  `PathID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offering`
--

INSERT INTO `offering` (`OfferingNo`, `OfferingID`, `Status`, `SeatsCount`, `Amount`, `PathID`) VALUES
(0, 'jatin', 'completed', 2, 400.00, 15),
(1, 'hassan', 'active', 4, 700.00, 16);

-- --------------------------------------------------------

--
-- Table structure for table `path`
--

CREATE TABLE `path` (
  `PathID` int(11) NOT NULL,
  `Pickup` varchar(50) DEFAULT NULL,
  `DropOff` varchar(50) DEFAULT NULL,
  `P1` varchar(50) DEFAULT NULL,
  `P2` varchar(50) DEFAULT NULL,
  `DeptDate` date DEFAULT NULL,
  `DeptTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `path`
--

INSERT INTO `path` (`PathID`, `Pickup`, `DropOff`, `P1`, `P2`, `DeptDate`, `DeptTime`) VALUES
(15, 'Kolachi', 'Fast', 'Seaview', 'Teen Talwar', '2023-12-07', '15:47:00'),
(16, 'Gulshan-e-Iqbal', 'Hamdard', 'National Statium', 'Faisal Cantt', '2023-12-07', '17:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `QueryID` int(11) NOT NULL,
  `Full_Name` varchar(50) DEFAULT NULL CHECK (`Full_Name` not like '%[^A-Za-z]%'),
  `Email` varchar(30) DEFAULT NULL CHECK (`Email` like '%@%.%'),
  `Phone_No` varchar(11) DEFAULT NULL,
  `Message` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `S.No` int(11) NOT NULL,
  `RequestID` varchar(30) NOT NULL,
  `OfferingID` varchar(30) NOT NULL,
  `Amount` decimal(6,2) DEFAULT NULL CHECK (`Amount` >= 0),
  `Comments` varchar(100) DEFAULT NULL,
  `Status` varchar(20) NOT NULL,
  `SeatCount` int(11) DEFAULT NULL CHECK (`SeatCount` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`S.No`, `RequestID`, `OfferingID`, `Amount`, `Comments`, `Status`, `SeatCount`) VALUES
(10, 'akshay', 'jatin', 200.00, 'jaldi jana hai', 'completedf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ridedetails`
--

CREATE TABLE `ridedetails` (
  `UserID` varchar(30) NOT NULL,
  `RiderID` varchar(30) NOT NULL,
  `RideID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ridedetails`
--

INSERT INTO `ridedetails` (`UserID`, `RiderID`, `RideID`) VALUES
('akshay', 'jatin', 20);

-- --------------------------------------------------------

--
-- Table structure for table `rider`
--

CREATE TABLE `rider` (
  `RiderID` varchar(30) NOT NULL,
  `RidesCount` int(11) DEFAULT NULL CHECK (`RidesCount` >= 0),
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` >= 0 and `Rating` <= 5),
  `NumberPlate` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rider`
--

INSERT INTO `rider` (`RiderID`, `RidesCount`, `Rating`, `NumberPlate`) VALUES
('hassan', 0, 0, 'PK-7890'),
('jatin', 0, 0, 'PK-5678');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Username` varchar(30) NOT NULL,
  `Full_Name` varchar(30) DEFAULT NULL CHECK (`Full_Name` not like '%[^A-Za-z]%'),
  `Phone_No` varchar(12) DEFAULT NULL,
  `UserType` varchar(1) DEFAULT NULL CHECK (`UserType` in ('p','r','a')),
  `email` varchar(30) DEFAULT NULL CHECK (`email` like '%@%.%')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Full_Name`, `Phone_No`, `UserType`, `email`) VALUES
('akshay', 'Akshay Kumar', '03326000067', 'p', 'akshaykumar@gmail.com'),
('hassan', 'Hassan Abbas', '03345678908', 'r', 'hassanabbas@gmail.com'),
('jatin', 'Jatin Kesnani', '03326000083', 'r', 'jatinkesnani@gmail.com'),
('neeraj', 'Neeraj Kumar', '03324560000', 'p', 'neerajkumar@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `Model` varchar(30) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL CHECK (`Year` > 2000),
  `SeatingCapacity` int(11) DEFAULT NULL CHECK (`SeatingCapacity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `Model`, `Year`, `SeatingCapacity`) VALUES
(9, 'Alto', 2020, 4),
(10, 'Civic', 2021, 4);

-- --------------------------------------------------------

--
-- Table structure for table `vehiclereg`
--

CREATE TABLE `vehiclereg` (
  `RegNo` varchar(8) NOT NULL,
  `VehicleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehiclereg`
--

INSERT INTO `vehiclereg` (`RegNo`, `VehicleID`) VALUES
('PK-5678', 9),
('PK-7890', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceptedrides`
--
ALTER TABLE `acceptedrides`
  ADD PRIMARY KEY (`RideID`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `offering`
--
ALTER TABLE `offering`
  ADD PRIMARY KEY (`OfferingNo`,`OfferingID`),
  ADD KEY `fk_path_id` (`PathID`);

--
-- Indexes for table `path`
--
ALTER TABLE `path`
  ADD PRIMARY KEY (`PathID`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`QueryID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`S.No`),
  ADD KEY `REQ_RIDER` (`OfferingID`);

--
-- Indexes for table `ridedetails`
--
ALTER TABLE `ridedetails`
  ADD PRIMARY KEY (`UserID`,`RiderID`),
  ADD KEY `RiderID` (`RiderID`),
  ADD KEY `RideID` (`RideID`);

--
-- Indexes for table `rider`
--
ALTER TABLE `rider`
  ADD PRIMARY KEY (`RiderID`),
  ADD KEY `fk_numplate` (`NumberPlate`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`);

--
-- Indexes for table `vehiclereg`
--
ALTER TABLE `vehiclereg`
  ADD PRIMARY KEY (`RegNo`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acceptedrides`
--
ALTER TABLE `acceptedrides`
  MODIFY `RideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `path`
--
ALTER TABLE `path`
  MODIFY `PathID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `S.No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`Username`);

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `credentials_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`Username`),
  ADD CONSTRAINT `fk_feedback_offeringNo` FOREIGN KEY (`FeedbackID`) REFERENCES `offering` (`OfferingNo`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `REQ_RIDER` FOREIGN KEY (`OfferingID`) REFERENCES `rider` (`RiderID`);

--
-- Constraints for table `ridedetails`
--
ALTER TABLE `ridedetails`
  ADD CONSTRAINT `ridedetails_ibfk_1` FOREIGN KEY (`RideID`) REFERENCES `acceptedrides` (`RideID`),
  ADD CONSTRAINT `ridedetails_ibfk_2` FOREIGN KEY (`RiderID`) REFERENCES `rider` (`RiderID`),
  ADD CONSTRAINT `ridedetails_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `user` (`Username`),
  ADD CONSTRAINT `ridedetails_ibfk_4` FOREIGN KEY (`RideID`) REFERENCES `acceptedrides` (`RideID`);

--
-- Constraints for table `rider`
--
ALTER TABLE `rider`
  ADD CONSTRAINT `fk_numplate` FOREIGN KEY (`NumberPlate`) REFERENCES `vehiclereg` (`RegNo`),
  ADD CONSTRAINT `rider_ibfk_1` FOREIGN KEY (`RiderID`) REFERENCES `user` (`Username`);

--
-- Constraints for table `vehiclereg`
--
ALTER TABLE `vehiclereg`
  ADD CONSTRAINT `vehiclereg_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
