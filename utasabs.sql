-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 01:16 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utasabs`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `AccommodationID` smallint(6) NOT NULL,
  `AccommodationName` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Price` smallint(6) DEFAULT NULL,
  `BedroomNumber` smallint(6) DEFAULT NULL,
  `BathroomNumber` smallint(6) DEFAULT NULL,
  `CheckInDate` varchar(255) DEFAULT NULL,
  `CheckOutDate` varchar(255) DEFAULT NULL,
  `Garage` bit(1) NOT NULL,
  `Smoking` bit(1) NOT NULL,
  `Pet` bit(1) NOT NULL,
  `Internet` bit(1) NOT NULL,
  `MaxAccommodate` smallint(6) DEFAULT NULL,
  `State` enum('awaiting','onholding','onliving') NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `OwnerID` smallint(6) NOT NULL,
  `StayerID` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`AccommodationID`, `AccommodationName`, `Address`, `City`, `Description`, `Price`, `BedroomNumber`, `BathroomNumber`, `CheckInDate`, `CheckOutDate`, `Garage`, `Smoking`, `Pet`, `Internet`, `MaxAccommodate`, `State`, `Photo`, `OwnerID`, `StayerID`) VALUES
(100, 'PlaceholderAccommodationName', 'PlaceholderAddress', 'PlaceholderCity', 'PlaceholderDescription', 0, 0, 0, '0000-00-00', '0000-00-00', b'0', b'0', b'0', b'0', 0, 'onholding', NULL, 100, NULL),
(101, 'Test House 1', '111 Test Street', 'TAS', 'This is test accommodation 1', 100, 2, 2, '2021-06-01', '2021-12-01', b'1', b'0', b'0', b'1', 1, 'awaiting', NULL, 1, NULL),
(102, 'Test House 2', '222 Test Street', 'TAS', 'This is test accommodation 2', 100, 2, 2, '2022-06-01', '2022-12-01', b'1', b'0', b'0', b'1', 2, 'awaiting', NULL, 1, NULL),
(103, 'Test House 3', '333 Test Street', 'TAS', 'This is test accommodation 3', 100, 2, 2, '2023-06-01', '2023-12-01', b'1', b'0', b'0', b'1', 3, 'awaiting', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingID` smallint(6) NOT NULL,
  `State` enum('readed','noread') NOT NULL,
  `Stage` enum('apply','processed','payment','cancel','review','complete') NOT NULL,
  `RefuseComment` varchar(255) DEFAULT NULL,
  `BookerInfo` varchar(255) DEFAULT NULL,
  `SenderID` smallint(6) NOT NULL,
  `AccommodationID` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingID`, `State`, `Stage`, `RefuseComment`, `BookerInfo`, `SenderID`, `AccommodationID`) VALUES
(1, 'readed', 'complete', '', 'Transform, Position, testclient@utas.abs.com, 412345679', 2, 103);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MessageID` smallint(6) NOT NULL,
  `State` enum('readed','noread') NOT NULL,
  `Content` varchar(255) DEFAULT NULL,
  `SenderID` smallint(6) NOT NULL,
  `ReceiverID` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`MessageID`, `State`, `Content`, `SenderID`, `ReceiverID`) VALUES
(1, 'readed', 'Placeholder Message', 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` smallint(6) NOT NULL,
  `ReviewRate` smallint(6) NOT NULL,
  `ReviewComment` varchar(255) DEFAULT NULL,
  `AccommodationID` smallint(6) NOT NULL,
  `ReviewerID` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewID`, `ReviewRate`, `ReviewComment`, `AccommodationID`, `ReviewerID`) VALUES
(1, 1, 'Placeholder review', 103, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` smallint(6) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `AccountName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(16) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `AccountType` enum('client','host','manager') NOT NULL,
  `ABN` varchar(16) DEFAULT NULL,
  `TotalRate` smallint(6) DEFAULT NULL,
  `RateNumber` smallint(6) DEFAULT NULL,
  `AverageRate` smallint(6) DEFAULT NULL,
  `AccountState` enum('inuse','banned') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `AccountName`, `Email`, `Password`, `Phone`, `Address`, `AccountType`, `ABN`, `TotalRate`, `RateNumber`, `AverageRate`, `AccountState`) VALUES
(1, 'Transform', 'Position', 'Instantiate', 'testhost@utas.abs.com', '$2y$10$oM0Kd/Uc2FbCKvVX5tKLauQSP6NVJ3heWyPZ2VquaBSdu0.NuHney', '0412345678', '180 Quaternion Street', 'host', '12345678901', 16, 5, 4, 'inuse'),
(2, 'Transform', 'Position', 'Instantiate', 'testclient@utas.abs.com', '$2y$10$FJ.N.YFSgY//PKKufJVizugIeZ9PDdTK4eSWjZWAew.0EBgzpKKqm', '0412345679', '180/2 Quaternion Street', 'client', '12345678901', 5, 1, 5, 'inuse'),
(100, 'Manager', 'Manager', 'SystemManager', 'manager@utas.abs.com', '$2y$10$/vMWF6Q/u3YO7VPt8/wxDOCWh4Va8pu4wYi9rOab9E0P.IoBva.oC', '0400000000', 'Address 000', 'manager', NULL, 5, 1, 5, 'inuse');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`AccommodationID`),
  ADD KEY `OwnerID` (`OwnerID`),
  ADD KEY `StayerID` (`StayerID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `AccommodationID` (`AccommodationID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `AccommodationID` (`AccommodationID`),
  ADD KEY `ReviewerID` (`ReviewerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD CONSTRAINT `accommodation_ibfk_1` FOREIGN KEY (`OwnerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `accommodation_ibfk_2` FOREIGN KEY (`StayerID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`AccommodationID`) REFERENCES `accommodation` (`AccommodationID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`AccommodationID`) REFERENCES `accommodation` (`AccommodationID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`ReviewerID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
