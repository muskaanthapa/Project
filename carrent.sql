-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 12:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrent`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2023-05-11 15:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(30) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Reserve_date` date NOT NULL,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Drop_location` varchar(200) NOT NULL,
  `Pickup_location` varchar(200) NOT NULL,
  `Required_driver` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `Name`, `Reserve_date`, `Start_date`, `End_date`, `Drop_location`, `Pickup_location`, `Required_driver`, `date`, `status`) VALUES
(1, 'Ram khadka', '2023-10-31', '2023-10-31', '2023-11-10', 'ktm', 'self', 'no', '0000-00-00', 'Confirmed'),
(2, 'sita kc', '2023-10-31', '2023-10-31', '2023-11-11', 'ktm', 'self', 'no', '0000-00-00', 'Confirmed'),
(3, 'Hari kc', '2023-10-30', '2023-10-30', '2023-11-11', 'ktm', 'self', 'no', '0000-00-00', 'Confirmed'),
(4, 'Geeta karki', '2023-10-30', '2023-10-30', '2023-11-03', 'ktm', 'self', 'yes', '0000-00-00', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `CarsBrand` varchar(30) NOT NULL,
  `CarsOverview` varchar(30) DEFAULT NULL,
  `PricePerDay` int(11) DEFAULT NULL,
  `FuelType` varchar(40) DEFAULT NULL,
  `ModelYear` int(6) DEFAULT NULL,
  `chasis_no` varchar(30) DEFAULT NULL,
  `reg_no` varchar(120) DEFAULT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Cimage1` varchar(120) DEFAULT NULL,
  `RegDate` date NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `CarsBrand`, `CarsOverview`, `PricePerDay`, `FuelType`, `ModelYear`, `chasis_no`, `reg_no`, `SeatingCapacity`, `Cimage1`, `RegDate`, `UpdationDate`) VALUES
(45, 'BMW', 'nice', 1000, 'Petrol', 2005, '4361', 'ba-02-kha-1235', 6, 'bmw.webp', '2023-10-08', '2023-10-08'),
(48, 'Honda', 'good', 3000, 'Petrol', 2004, '68', 'ba-12-kha-9876', 6, 'honda.jpg', '2023-10-08', '2023-10-08'),
(53, 'toyata', 'nice', 3000, 'Petrol', 2001, '1239', 'ba-03-kha-4478', 6, 'toyota.jpg', '2023-10-08', '2023-10-08'),
(54, 'Honda', 'good', 2000, 'Petrol', 2000, '9876', 'ba-12-kha-3890', 4, 'toyota.jpg', '2023-10-08', '2023-10-08'),
(55, 'Honda', 'nice', 2000, 'Petrol', 2000, '234', 'ba-09-kha-2324', 4, 'maruti.webp', '2023-10-08', '2023-10-08'),
(56, 'ford', 'udjkslamz', 2500, 'Petrol', 2000, 'ADBHKTIGKHTUOJFN1', 'ba-01-kha-2424', 6, 'creata.jpg', '2023-10-09', '2023-10-09'),
(57, 'ford', 'gftrgcvbhjnm', 3000, 'Petrol', 2001, 'ADSGJKLIMHLPUIKE2', 'ba-76-kha-2345', 4, 'car22.jpg', '2023-10-09', '2023-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `tblbrands`
--

CREATE TABLE `tblbrands` (
  `id` int(11) NOT NULL,
  `BrandName` varchar(120) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbrands`
--

INSERT INTO `tblbrands` (`id`, `BrandName`, `CreationDate`, `UpdationDate`) VALUES
(6, 'BMW', '2023-06-02 09:32:39', '2023-10-08 08:04:30'),
(11, 'Hyandi', '2023-07-25 06:26:00', NULL),
(13, 'ford', '2023-10-06 10:57:39', NULL),
(19, 'Honda', '2023-10-06 15:21:46', NULL),
(23, 'toyata', '2023-10-08 15:59:23', NULL),
(24, 'creata', '2023-10-08 15:59:49', NULL),
(25, 'maruti suzuki11', '2023-10-10 12:11:20', '2023-10-10 12:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

CREATE TABLE `tblcustomers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phoneno` varchar(50) NOT NULL,
  `license` varchar(60) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcustomers`
--

INSERT INTO `tblcustomers` (`id`, `firstname`, `lastname`, `address`, `phoneno`, `license`, `password`) VALUES
(1, 'sita', 'kc', 'bkt', '9868908765', '45-08876-999', '1234'),
(2, 'Reeta ', 'kc', 'ktm', '9869032134', '78-09-23-02', '1234'),
(3, 'Geeta ', 'Khadka', 'bkt', '9845437234', '72-08-43', '2345');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'sita kc', 'sitakc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'geeta karki', 'geetakarki@gmail.com', '289dff07669d7a23de0ef88d2f7129e7'),
(4, 'reetakarki', 'reetakarki@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbrands`
--
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `BrandName` (`BrandName`);

--
-- Indexes for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tblbrands`
--
ALTER TABLE `tblbrands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
