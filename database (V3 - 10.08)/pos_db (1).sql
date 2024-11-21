-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 09:50 PM
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
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(200) DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 1234567890, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2020-06-25 07:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblbrand`
--

CREATE TABLE `tblbrand` (
  `ID` int(10) NOT NULL,
  `BrandName` varchar(200) DEFAULT NULL,
  `Status` int(2) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbrand`
--

INSERT INTO `tblbrand` (`ID`, `BrandName`, `Status`, `CreationDate`) VALUES
(1, 'Neutrogena', 1, '2024-07-12 11:00:00'),
(2, 'Olay', 1, '2024-07-12 11:10:00'),
(3, 'Cetaphil', 1, '2024-07-12 11:20:00'),
(4, 'Eucerin', 1, '2024-07-12 11:30:00'),
(5, 'Aveeno', 1, '2024-07-12 11:40:00'),
(6, 'Nivea', 1, '2024-07-12 11:50:00'),
(7, 'La Roche-Posay', 1, '2024-07-12 12:00:00'),
(8, 'Vaseline', 1, '2024-07-12 12:10:00'),
(9, 'Bioderma', 1, '2024-07-12 12:20:00'),
(10, 'The Body Shop', 1, '2024-07-12 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `ID` int(10) NOT NULL,
  `ProductId` int(5) DEFAULT NULL,
  `BillingId` int(11) DEFAULT NULL,
  `ProductQty` int(11) DEFAULT NULL,
  `IsCheckOut` int(5) DEFAULT NULL,
  `CartDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `Status` int(2) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `Status`, `CreationDate`) VALUES
(1, 'Moisturizers', 1, '2024-07-12 11:00:00'),
(2, 'Cleansers', 1, '2024-07-12 11:10:00'),
(3, 'Sunscreen', 1, '2024-07-12 11:20:00'),
(4, 'Acne Treatment', 1, '2024-07-12 11:30:00'),
(5, 'Anti-Aging', 1, '2024-07-12 11:40:00'),
(6, 'Body Lotion', 1, '2024-07-12 11:50:00'),
(7, 'Lip Care', 1, '2024-07-12 12:00:00'),
(8, 'Hand Cream', 1, '2024-07-12 12:10:00'),
(9, 'Foot Care', 1, '2024-07-12 12:20:00'),
(10, 'Eye Cream', 1, '2024-07-12 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer`
--

CREATE TABLE `tblcustomer` (
  `ID` int(10) NOT NULL,
  `BillingNumber` varchar(120) DEFAULT NULL,
  `CustomerName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `ModeofPayment` varchar(50) DEFAULT NULL,
  `BillingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CustomerAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`ID`, `BillingNumber`, `CustomerName`, `MobileNumber`, `ModeofPayment`, `BillingDate`, `CustomerAddress`) VALUES
(21, '983521018', 'Test CX', 8888, 'Cash', '2024-08-10 19:48:16', 'dasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `ID` int(10) NOT NULL,
  `ProductName` varchar(200) DEFAULT NULL,
  `CatID` int(5) DEFAULT NULL,
  `SubcatID` int(5) DEFAULT NULL,
  `BrandName` varchar(200) DEFAULT NULL,
  `ModelNumber` varchar(200) DEFAULT NULL,
  `Barcode` varchar(100) DEFAULT NULL,
  `Price` decimal(10,0) DEFAULT NULL,
  `Stock` int(10) DEFAULT NULL,
  `CostPrice` decimal(10,2) DEFAULT NULL,
  `Margin` decimal(5,2) DEFAULT NULL,
  `Discount` decimal(5,2) DEFAULT NULL,
  `DiscountedPrice` decimal(10,2) GENERATED ALWAYS AS (`Price` - `Price` * `Discount` / 100) STORED,
  `Status` int(2) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `LastUpdatedDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `IsFeatured` tinyint(1) DEFAULT 0,
  `Weight` decimal(10,2) DEFAULT NULL,
  `Dimensions` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `SupplierID` int(5) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`ID`, `ProductName`, `CatID`, `SubcatID`, `BrandName`, `ModelNumber`, `Barcode`, `Price`, `Stock`, `CostPrice`, `Margin`, `Discount`, `Status`, `CreationDate`, `LastUpdatedDate`, `IsFeatured`, `Weight`, `Dimensions`, `Color`, `Size`, `SupplierID`, `ImageURL`) VALUES
(56, 'Acne Cream', NULL, NULL, NULL, 'FPC001', NULL, 585, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 19:50:14', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'After sun Cream', NULL, NULL, NULL, 'FPC002', NULL, 410, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Aloevera Gel', NULL, NULL, NULL, 'FPC003', NULL, 380, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'Be Bright', NULL, NULL, NULL, 'FPC004', NULL, 650, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Calamine Cream', NULL, NULL, NULL, 'FPC005', NULL, 275, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Calamine Lotion', NULL, NULL, NULL, 'FPP001', NULL, 210, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Calamine Powder', NULL, NULL, NULL, 'FPC006', NULL, 200, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Diapper Rash- No rash', NULL, NULL, NULL, 'FPC007', NULL, 275, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Face Wash', NULL, NULL, NULL, 'FPC008', NULL, 468, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Foot Cream - crack out', NULL, NULL, NULL, 'FPC009', NULL, 279, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Foot Cream- Diabetic', NULL, NULL, NULL, 'FPC010', NULL, 560, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Methyl Salycilate Cream- Relaxx', NULL, NULL, NULL, 'FPm002', NULL, 200, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Moisturizing Cream- Dry nil', NULL, NULL, NULL, 'FPC011', NULL, 285, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Moisturizing cream-Dry nil kids', NULL, NULL, NULL, 'FPC012', NULL, 350, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Mosquito Lotion', NULL, NULL, NULL, 'FPC013', NULL, 500, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Mosquito Spray', NULL, NULL, NULL, 'FPC014', NULL, 450, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Salicylic acid Coaltar Cream- Sallycol', NULL, NULL, NULL, 'FPM003', NULL, 825, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Skin Glow cream', NULL, NULL, NULL, 'FPC015', NULL, 950, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Sun juniour', NULL, NULL, NULL, 'FPC016', NULL, 430, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Sun Lotion 50Plus', NULL, NULL, NULL, 'FPC017', NULL, 580, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Sunscreen  30Plus', NULL, NULL, NULL, 'FPC018', NULL, 430, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Sunscreen 50Plus', NULL, NULL, NULL, 'FPC019', NULL, 485, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Surf Guard - ZnO Cream', NULL, NULL, NULL, 'FPC020', NULL, 475, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'UV Care gel', NULL, NULL, NULL, 'FPC021', NULL, 700, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'Vaginal Wash- Be relax', NULL, NULL, NULL, 'FPC022', NULL, 380, 0, NULL, 0.00, 0.00, 1, '2024-08-10 14:46:47', '2024-08-10 14:46:47', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'TETS 101', NULL, NULL, NULL, '423423', NULL, 100, 100, NULL, NULL, NULL, 0, '2024-08-10 14:47:56', '2024-08-10 14:47:56', 0, 4234234.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `ID` int(10) NOT NULL,
  `CatID` int(5) DEFAULT NULL,
  `SubCategoryname` varchar(200) DEFAULT NULL,
  `Status` int(2) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`ID`, `CatID`, `SubCategoryname`, `Status`, `CreationDate`) VALUES
(1, 1, 'Air Condition', 1, '2020-06-26 04:49:43'),
(2, 1, 'Bulb', 1, '2020-06-26 04:50:16'),
(3, 1, 'TV', 1, '2020-06-26 04:50:29'),
(4, 1, 'Freeze', 1, '2020-06-26 04:50:44'),
(5, 1, 'Aqua Filter', 1, '2020-06-26 04:51:04'),
(6, 2, 'Weight Machine', 1, '2020-06-26 04:51:41'),
(7, 2, 'BP Machine', 1, '2020-06-26 04:51:59'),
(8, 2, 'Glucometer', 1, '2020-06-26 04:52:28'),
(9, 2, 'Glucometer Strip', 1, '2020-06-26 04:52:45'),
(10, 2, 'Thero Band', 1, '2020-06-26 04:53:13'),
(11, 3, 'Music Toys', 1, '2020-06-26 04:53:32'),
(12, 3, 'Battery Toys', 1, '2020-06-26 04:57:35'),
(13, 4, 'Baby Swaddle', 1, '2020-06-26 04:59:00'),
(14, 4, 'Baby Bottle', 1, '2020-06-26 04:59:25'),
(15, 4, 'Baby Shampoo', 1, '2020-06-26 04:59:40'),
(16, 4, 'Baby Powder', 1, '2020-06-26 04:59:59'),
(17, 7, 'Burret', 1, '2020-06-26 05:00:15'),
(18, 7, 'Puppet', 1, '2020-06-26 05:00:27'),
(19, 7, 'Jar', 1, '2020-06-26 05:00:36'),
(20, 6, 'Mustard Oil', 1, '2020-06-26 05:00:57'),
(21, 6, 'Almond', 1, '2020-06-26 05:01:11'),
(22, 9, 'Fuccet', 1, '2020-06-26 05:01:25'),
(23, 12, 'Glass', 1, '2020-06-26 05:01:50'),
(24, 12, 'Plates', 1, '2020-06-26 05:02:02'),
(25, 12, 'Juicer', 1, '2020-06-26 05:02:14'),
(26, 5, 'Grooming', 1, '2020-08-27 07:12:39'),
(27, 16, 'Test  subCat', 1, '2020-10-03 14:13:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblbrand`
--
ALTER TABLE `tblbrand`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `BillingNumber` (`BillingNumber`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbrand`
--
ALTER TABLE `tblbrand`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
