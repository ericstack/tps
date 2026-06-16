-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2020 at 12:41 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tps`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `access` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `username`, `password`, `access`, `active`) VALUES
(1, 'test', 'test', '$2y$10$l8uOvabOOz9aik1hjI8qguOh54b/M/ColYg40h2WBv6zSr8QUQ3aO', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Transportation', 'Oil Refining/Marketing'),
(2, 'Technology', 'Computer peripheral equipment'),
(3, 'A.I', 'EDP Services'),
(4, 'Finance', 'Major Banks'),
(5, 'Health Care', 'Major Pharmaceuticals'),
(6, 'Consumer Services', 'Hotels/Resorts'),
(7, 'Finance', 'Major Banks'),
(8, 'Lorem', 'n/a'),
(9, 'Health Care', 'Major Pharmaceuticals'),
(10, 'Ipsum', 'n/a'),
(11, 'Health Care', 'Biotechnology: Commercial Physical & Biological Resarch'),
(12, 'Finance', 'Major Banks'),
(13, 'Health Care', 'Biotechnology: Biological Products (No Diagnostic Substances)'),
(14, 'Technology', 'Diversified Commercial Services'),
(15, 'Health Care', 'Major Pharmaceuticals'),
(16, 'Consumer Services', 'RETAIL: Building Materials'),
(17, 'Ippim', 'n/a'),
(18, 'Health Care', 'Major Pharmaceuticals'),
(19, 'Something', 'n/a'),
(20, 'Capital Goods', 'Industrial Machinery/Components');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `serial_no`, `name`, `description`, `quantity`, `category_id`, `created`, `modified`) VALUES
(1, '54-297-0662', 'Lid - 16 Oz And 32 Oz', 'Small Pussytoes', 0, 1, '2020-11-10 02:52:06', '2020-11-10 02:52:06'),
(2, '20-688-3861', 'Wine - Red, Pinot Noir, Chateau', 'Hepp\'s Cracked Lichen', 52, 2, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(3, '12-194-8502', 'Pants Custom Dry Clean', 'Tufted Frasera', 94, 3, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(4, '37-468-6147', 'Lamb - Leg, Boneless', 'Longstalk Springparsley', 89, 4, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(5, '75-069-7783', 'Yogurt - Cherry, 175 Gr', 'Tundra Wildrye', 40, 5, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(6, '54-465-0717', 'Seedlings - Mix, Organic', 'Sonoran Indigo', 4, 6, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(7, '92-439-4301', 'Apple - Fuji', 'Needleleaf Navarretia', 93, 7, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(8, '37-934-6066', 'Cleaner - Bleach', 'Perezia', 97, 8, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(9, '76-514-1363', 'Mint - Fresh', 'Caulerpa', 83, 9, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(10, '12-171-4439', 'Coffee Guatemala Dark', 'Lamp Rush', 14, 10, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(11, '67-694-2745', 'Flower - Leather Leaf Fern', 'Largebract Spiderling', 45, 11, '2020-11-10 02:52:07', '2020-11-10 02:52:07'),
(12, '93-187-2945', 'Wine - Shiraz Wolf Blass Premium', 'Festulolium', 5, 12, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(13, '78-845-5368', 'Mushroom - Morel Frozen', 'Alpine Milkvetch', 56, 13, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(14, '54-945-7163', 'Sprouts Dikon', 'Western Meadow-rue', 49, 14, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(15, '01-386-2938', 'Pea - Snow', 'Arctic Catchfly', 45, 15, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(16, '22-753-4363', 'Veal - Insides Provini', 'Lopleaf', 97, 16, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(17, '98-034-6599', 'Longos - Grilled Salmon With Bbq', 'Peck\'s Beardtongue', 2, 17, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(18, '31-987-6681', 'Easy Off Oven Cleaner', 'Woollyleaf Manzanita', 58, 18, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(19, '16-443-8584', 'Alize Gold Passion', 'Yellowshow', 4, 19, '2020-11-10 02:52:08', '2020-11-10 02:52:08'),
(20, '82-678-2876', 'Cheese - Brie Roitelet', 'Tapertip Spleenwort', 36, 20, '2020-11-10 02:52:08', '2020-11-10 02:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `datetime`, `type`, `msg`) VALUES
(1, '2020-08-09 16:08:39', 'Login', 'Username doesn\'t exist'),
(2, '2020-08-09 16:18:11', 'Login', 'Invalid Password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
