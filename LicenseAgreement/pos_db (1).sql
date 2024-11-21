-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 05:28 AM
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

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`ID`, `ProductId`, `BillingId`, `ProductQty`, `IsCheckOut`, `CartDate`) VALUES
(1, 5, 295895096, 1, 1, '2020-08-27 05:37:21'),
(2, 1, 295895096, 2, 1, '2020-08-27 05:37:21'),
(4, 5, 915520085, 1, 1, '2019-08-27 05:57:42'),
(5, 13, 255048845, 5, 1, '2020-08-26 12:14:38'),
(6, 5, 558104108, 16, 1, '2020-08-27 14:58:03'),
(25, 14, 122198457, 1, 1, '2020-09-02 05:53:15'),
(26, 14, 122198457, 1, 1, '2020-09-02 05:53:15'),
(36, 16, 262592136, 2, 1, '2020-10-03 14:17:19'),
(37, 13, 262592136, 1, 1, '2020-10-03 14:17:19'),
(38, 1, 369973102, 1, 1, '2024-07-13 15:41:28');

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
  `BillingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`ID`, `BillingNumber`, `CustomerName`, `MobileNumber`, `ModeofPayment`, `BillingDate`) VALUES
(1, '295895096', 'Sarita', 7797987987, 'cash', '2020-08-27 05:37:21'),
(2, '915520085', 'Sarita', 6465464646, 'cash', '2020-08-27 05:57:42'),
(3, '255048845', 'Harish', 7987978979, 'cash', '2020-08-27 12:14:38'),
(4, '558104108', 'Rahul', 6665464654, 'card', '2020-08-27 14:58:03'),
(5, '122198457', 'RaviKumar', 5765557576, 'cash', '2020-09-02 05:53:15'),
(6, '262592136', 'Anuj kumar', 9354778033, 'card', '2020-10-03 14:17:19'),
(7, '369973102', '212', 42342342, 'card', '2024-07-13 15:41:28');

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
(1, 'Acne Cream', 1, 1, 'Brand A', 'Model 001', '123456789012', 585, 6, 450.00, 30.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-13 16:39:47', 0, 0.50, '10x5x5', 'White', '50g', 1, 'FPC001'),
(2, 'After sun Cream', 1, 2, 'Brand B', 'Model 002', '123456789013', 410, 0, 300.00, 36.67, 10.00, 1, '2024-07-12 17:05:40', '2024-07-13 16:40:17', 0, 0.30, '8x4x4', 'White', '100ml', 2, 'FPC002'),
(3, 'Aloevera Gel', 1, 3, 'Brand C', 'Model 003', '123456789014', 380, 100, 250.00, 52.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:33:51', 0, 0.40, '10x5x5', 'Green', '150ml', 3, 'FPC002'),
(4, 'Be Bright', 2, 1, 'Brand D', 'Model 004', '123456789015', 650, 100, 500.00, 30.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:33:45', 0, 0.60, '12x6x6', 'White', '50g', 1, 'FPC003'),
(5, 'Calamine Cream', 2, 2, 'Brand E', 'Model 005', '123456789016', 275, 100, 200.00, 37.50, 5.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Pink', '100g', 2, 'http://example.com/images/calamine_cream.jpg'),
(6, 'Calamine Lotion', 2, 3, 'Brand F', 'Model 006', '123456789017', 210, 100, 150.00, 40.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Pink', '100ml', 3, 'http://example.com/images/calamine_lotion.jpg'),
(7, 'Calamine Powder', 3, 1, 'Brand G', 'Model 007', '123456789018', 200, 100, 120.00, 66.67, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:32:00', 0, 0.20, '6x3x3', 'White', '50g', 1, 'FPC001'),
(8, 'Diapper Rash- No rash', 3, 2, 'Brand H', 'Model 008', '123456789019', 275, 100, 180.00, 52.78, 5.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.20, '6x3x3', 'White', '50g', 2, 'http://example.com/images/diaper_rash_cream.jpg'),
(9, 'Face Wash', 3, 3, 'Brand I', 'Model 009', '123456789020', 468, 100, 300.00, 56.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Blue', '100ml', 3, 'http://example.com/images/face_wash.jpg'),
(10, 'Foot Cream - crack out', 4, 1, 'Brand J', 'Model 010', '123456789021', 279, 100, 200.00, 39.50, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:32:03', 0, 0.30, '8x4x4', 'White', '50g', 1, 'FPC001'),
(11, 'Foot Cream- Diabetic', 4, 2, 'Brand K', 'Model 011', '123456789022', 560, 100, 400.00, 40.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'White', '50g', 2, 'http://example.com/images/foot_cream_diabetic.jpg'),
(12, 'Methyl Salycilate Cream- Relaxx', 4, 3, 'Brand L', 'Model 012', '123456789023', 200, 100, 120.00, 66.67, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.20, '6x3x3', 'White', '50g', 3, 'http://example.com/images/methyl_salycilate_cream.jpg'),
(13, 'Moisturizing Cream- Dry nil', 5, 1, 'Brand M', 'Model 013', '123456789024', 285, 100, 200.00, 42.50, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:32:06', 0, 0.30, '8x4x4', 'White', '50g', 1, 'FPC001'),
(14, 'Moisturizing cream-Dry nil kids', 5, 2, 'Brand N', 'Model 014', '123456789025', 350, 100, 250.00, 40.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'White', '50g', 2, 'http://example.com/images/moisturizing_cream_dry_nil_kids.jpg'),
(15, 'Mosquito Lotion', 5, 3, 'Brand O', 'Model 015', '123456789026', 500, 100, 350.00, 42.86, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Green', '100ml', 3, 'http://example.com/images/mosquito_lotion.jpg'),
(16, 'Mosquito Spray', 6, 1, 'Brand P', 'Model 016', '123456789027', 450, 100, 300.00, 50.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Green', '100ml', 1, 'http://example.com/images/mosquito_spray.jpg'),
(17, 'Salicylic acid Coaltar Cream- Sallycol', 6, 2, 'Brand Q', 'Model 017', '123456789028', 825, 100, 600.00, 37.50, 10.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'White', '50g', 2, 'http://example.com/images/salicylic_acid_coaltar_cream.jpg'),
(18, 'Skin Glow cream', 6, 3, 'Brand R', 'Model 018', '123456789029', 950, 100, 700.00, 35.71, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'White', '50g', 3, 'http://example.com/images/skin_glow_cream.jpg'),
(19, 'Sun juniour', 7, 1, 'Brand S', 'Model 019', '123456789030', 430, 100, 300.00, 43.33, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:32:09', 0, 0.30, '8x4x4', 'Yellow', '100ml', 1, 'FPC001'),
(20, 'Sun Lotion 50Plus', 7, 2, 'Brand T', 'Model 020', '123456789031', 580, 100, 400.00, 45.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Yellow', '100ml', 2, 'http://example.com/images/sun_lotion_50plus.jpg'),
(21, 'Sunscreen 30Plus', 7, 3, 'Brand U', 'Model 021', '123456789032', 430, 100, 300.00, 43.33, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Yellow', '100ml', 3, 'http://example.com/images/sunscreen_30plus.jpg'),
(22, 'Sunscreen 50Plus', 8, 1, 'Brand V', 'Model 022', '123456789033', 485, 100, 350.00, 38.57, 5.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Yellow', '100ml', 1, 'http://example.com/images/sunscreen_50plus.jpg'),
(23, 'Surf Guard - ZnO Cream', 8, 2, 'Brand W', 'Model 023', '123456789034', 475, 100, 320.00, 48.44, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:32:17', 0, 0.30, '8x4x4', 'White', '50g', 2, 'FPC002'),
(24, 'UV Care gel', 8, 3, 'Brand X', 'Model 024', '123456789035', 700, 100, 500.00, 40.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'Transparent', '100ml', 3, 'http://example.com/images/uv_care_gel.jpg'),
(25, 'Vaginal Wash- Be relax', 9, 1, 'Brand Y', 'Model 025', '123456789036', 380, 100, 250.00, 52.00, 0.00, 1, '2024-07-12 17:05:40', '2024-07-12 17:05:40', 0, 0.30, '8x4x4', 'White', '100ml', 1, 'http://example.com/images/vaginal_wash.jpg'),
(26, '314', 2, 8, 'Mitsubishi', 'dasda', '312312', 31231, 423, 3213.00, 423.00, 423.00, 1, '2024-07-12 18:14:01', '2024-07-12 18:14:01', 0, 423.00, '4234', '2423', '234', 4234, 'admin/product_img/3564214b1593ccb2967326133145f68f1720808041.png'),
(27, '3123', 6, 20, 'Loreal', '312', '312', 312, 123, 123.00, 312.00, 123.00, 1, '2024-07-12 18:25:18', '2024-07-12 18:25:18', 0, 312.00, '3123', '1323', '12312', 312, 'admin/product_img/857ecbc74e4e0c00a124476a33c5dab51720808718.png');

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
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
