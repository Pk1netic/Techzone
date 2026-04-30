-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 06:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

-- Team Members:
-- 1. Glory Iloba 23160144
-- 2. Yusuf Jawad 23145441
-- 3. Mohammed Soma 23163517
-- 4. Ubayd Alam 22226102

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s23160144_s23163517_s22226102_s23145441`
--
CREATE DATABASE IF NOT EXISTS `s23160144_s23163517_s22226102_s23145441` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `s23160144_s23163517_s22226102_s23145441`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SessionID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`, `SessionID`) VALUES
(2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `CartID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cartsaveditem`
--

CREATE TABLE `cartsaveditem` (
  `CartID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactform`
--

CREATE TABLE `contactform` (
  `ContactID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `Email_Address` varchar(320) DEFAULT NULL,
  `Reasoning` enum('Return Order','About Order','Other','') NOT NULL,
  `Message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `PriceAtOrder` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `TrackingNumber` varchar(30) DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalPrice` double NOT NULL,
  `ShippingAddressID` int(11) NOT NULL,
  `PaymentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `Card_Number` varchar(25) NOT NULL,
  `Card_Expiring_Date` varchar(5) NOT NULL,
  `Card_Holder_Name` text NOT NULL,
  `CVC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Rating` double NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Price` double NOT NULL,
  `Category` enum('Headphones','Laptops','Drones','Speakers','PC','Printers','TV','Watches') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `Rating`, `Image`, `Price`, `Category`) VALUES
(1, 'Sony WH-CH720N', 0, 'images/SonyHeadphones.png', 69.99, 'Headphones'),
(2, 'DJI Mini 3', 0, 'images/DJI.png', 450, 'Drones'),
(3, 'NZXT Player two', 0, 'images/NzxtPC.png', 960, 'PC'),
(4, 'Surface laptop 5', 0, 'images/MicrosoftLaptop.png', 645, 'Laptops'),
(5, 'JBL Xtreme 3 Speaker', 0, 'images/JblSpeaker.png', 59.99, 'Speakers'),
(6, 'Apple Watch: Jet Black', 0, 'images/AppleWatch.png', 495.99, 'Watches'),
(7, 'Samsung 43-inch TV', 0, 'images/SamsungSmartTV.png', 789.99, 'TV'),
(8, 'Canon Printer', 0, 'images/CanonPrinter.png', 130, 'Printers');

-- --------------------------------------------------------

--
-- Table structure for table `shippingaddress`
--

CREATE TABLE `shippingaddress` (
  `ShippingAddressID` int(11) NOT NULL,
  `House_Number` int(11) NOT NULL,
  `Street/Road` varchar(85) NOT NULL,
  `Town/City` varchar(100) NOT NULL,
  `County` varchar(100) DEFAULT NULL,
  `Postcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `Email_Address` varchar(320) NOT NULL,
  `Phone_Number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ShippingAddressID` int(11) DEFAULT NULL,
  `PaymentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `First_Name`, `Last_Name`, `Email_Address`, `Phone_Number`, `password`, `ShippingAddressID`, `PaymentID`) VALUES
(1, 'Account', 'One', 'Account1@gmail.com', '03824827', '$2y$10$qw38cpoWds3KjWph.i0EReWMDkVlfYd3rs87q0KY0bbjVIynk/VdG', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD UNIQUE KEY `SessionID` (`SessionID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`CartID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `cartsaveditem`
--
ALTER TABLE `cartsaveditem`
  ADD PRIMARY KEY (`CartID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `contactform`
--
ALTER TABLE `contactform`
  ADD PRIMARY KEY (`ContactID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ShippingAddressID` (`ShippingAddressID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `shippingaddress`
--
ALTER TABLE `shippingaddress`
  ADD PRIMARY KEY (`ShippingAddressID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email_Address` (`Email_Address`),
  ADD KEY `ShippingAddressID` (`ShippingAddressID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contactform`
--
ALTER TABLE `contactform`
  MODIFY `ContactID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shippingaddress`
--
ALTER TABLE `shippingaddress`
  MODIFY `ShippingAddressID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`),
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `cartsaveditem`
--
ALTER TABLE `cartsaveditem`
  ADD CONSTRAINT `cartsaveditem_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`),
  ADD CONSTRAINT `cartsaveditem_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `contactform`
--
ALTER TABLE `contactform`
  ADD CONSTRAINT `contactform_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ShippingAddressID`) REFERENCES `shippingaddress` (`ShippingAddressID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`ShippingAddressID`) REFERENCES `shippingaddress` (`ShippingAddressID`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
