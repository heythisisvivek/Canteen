-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2020 at 03:34 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canteen`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  `profilepic` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `sname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `wallet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `uid`, `profilepic`, `name`, `sname`, `email`, `gender`, `city`, `country`, `password`, `wallet`) VALUES
(1, '1221105435', 'images/userProfiles/GordonRamsay_KitchenMaster-FTR.jpg', 'admin', 'user', 'admin@gmail.com', 'Male', 'Mumbai', 'India', '$2y$10$IvkQ47ZeGpkQYNaQjTzG7OyQccoNOYC.N/c0qu86dZtzOoZVc4fBe', 2368);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(250) NOT NULL,
  `iid` varchar(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `arttitle` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `foodType` varchar(250) NOT NULL,
  `artprice` varchar(250) NOT NULL,
  `item` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  `profilepic` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `sname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `street` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `wallet` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `uid`, `profilepic`, `name`, `sname`, `email`, `gender`, `street`, `city`, `country`, `password`, `wallet`) VALUES
(1, '1422963547', 'images/userProfiles/kid.jpg', 'dummy', 'client', 'dummy@gmail.com', 'Male', '256/A, Vila, Golden Nest', 'Mumbai', 'India', '$2y$10$TwOjowLLBR2XQG8jDXDf8ek.RhBXyjQ/hNM2s3vmDFQ2pFEF0KtZG', 1162);

-- --------------------------------------------------------

--
-- Table structure for table `foodorder`
--

CREATE TABLE `foodorder` (
  `id` int(250) NOT NULL,
  `fid` varchar(250) NOT NULL,
  `iid` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foodorder`
--

INSERT INTO `foodorder` (`id`, `fid`, `iid`, `email`, `image`, `title`, `price`, `status`, `date`) VALUES
(16, '976677715', '726799371', 'dummy@gmail.com', 'images/siteUploads/aloo paratha.jpg', 'Aloo Paratha', '128', 'Food Being Prepared', '02/03/20'),
(17, '1652685563', '732439310', 'dummy@gmail.com', 'images/siteUploads/f7d6b182cb0b1ee53e533c9e5e5d9ae1.jpg', 'chole kulche', '120', 'Order Cancelled', '02/03/20');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  `iid` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `userImage` varchar(250) NOT NULL,
  `imagetitle` varchar(250) NOT NULL,
  `imagedescription` varchar(250) NOT NULL,
  `imageprice` varchar(250) NOT NULL,
  `updateDate` varchar(250) NOT NULL,
  `foodType` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `uid`, `iid`, `email`, `userImage`, `imagetitle`, `imagedescription`, `imageprice`, `updateDate`, `foodType`) VALUES
(3, '1221105435', '726799371', 'admin@gmail.com', 'images/siteUploads/aloo paratha.jpg', 'Aloo Paratha', 'Fusion mornings with two aloo parathas and a double-egg omelette, savoured with butter and pickle as sides. For when you cant decide, why not have both!', '128', '02/03/2020', 'Veg'),
(5, '1221105435', '732439310', 'admin@gmail.com', 'images/siteUploads/f7d6b182cb0b1ee53e533c9e5e5d9ae1.jpg', 'chole kulche', 'Zesty chole cooked to perfection in a spiced onion gravy, served with two soft kulchas.', '120', '02/03/2020', 'Veg'),
(6, '1221105435', '547223157', 'admin@gmail.com', 'images/siteUploads/maxresdefault.jpg', 'Omelette with Masala Bread', 'Two protein-rich omelettes with masala kulcha bread &amp; butter on the side. Customize with c', '120', '02/03/2020', 'Non-Veg'),
(7, '1221105435', '961588333', 'admin@gmail.com', 'images/siteUploads/bbq-chicken-wrap.jpg', 'Barbeque Chicken Wrap', 'Tender chicken lathered in Barbeque sauce and mint mayonnaise and wrapped in a soft roti.', '115', '02/03/2020', 'Non-Veg'),
(8, '1221105435', '22300630', 'admin@gmail.com', 'images/siteUploads/veg-loaded-500x500.png', 'veg loaded pizza', 'Tomato I Jalapeno I Grilled Mushroom I Beans in a fresh Pan Crust', '400', '02/03/2020', 'Veg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foodorder`
--
ALTER TABLE `foodorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foodorder`
--
ALTER TABLE `foodorder`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
