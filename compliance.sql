-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.19-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for compliance
CREATE DATABASE IF NOT EXISTS `compliance` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `compliance`;

-- Dumping structure for table compliance.advisers_tbl
CREATE TABLE IF NOT EXISTS `advisers_tbl` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fspr_number` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `trading_name` varchar(255) NOT NULL,
  `telephone_no` varchar(23) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `role` varchar(25) NOT NULL,
  `experience` longtext NOT NULL,
  `provider` varchar(255) NOT NULL,
  `providerKiwi` int(11) NOT NULL,
  `advCommissionPer` varchar(255) NOT NULL,
  `advOngoingCommissionPer` varchar(255) NOT NULL,
  PRIMARY KEY (`idusers`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- Dumping data for table compliance.advisers_tbl: ~71 rows (approximately)
/*!40000 ALTER TABLE `advisers_tbl` DISABLE KEYS */;
INSERT INTO `advisers_tbl` (`idusers`, `last_name`, `first_name`, `middle_name`, `email`, `fspr_number`, `address`, `trading_name`, `telephone_no`, `photo`, `role`, `experience`, `provider`, `providerKiwi`, `advCommissionPer`, `advOngoingCommissionPer`) VALUES
	(1, 'Bandiola', 'Kieth Mark', 'Sevilla', 'scalaberch69@gmail.com', '', '', '', '', NULL, 'Adviser', '', '', 0, '', ''),
	(3, 'Monga', 'Sumit', 'Y', 'sumit@eliteinsure.co.nz', '484106', '1C/39 Mackelvie Street, Grey Lynn, 1021', 'Eliteinsure Limited', '0211174612', NULL, 'Managing Director', 'I entered the Insurance industry as a QFE in 2007. After working as an Insurance agent, I opened my company and started working for myself on the1st of March 2016. I manage a team with a strict focus on training and development of Insurance advisers under my organization as well as provide advice to clients. ', '2,3,6,19', 0, '20.5', '50.64'),
	(4, 'Ghost', 'Dave', 'Ghost', 'dxerxessunio@gmail.com', '', '', '', '', NULL, 'Adviser', '', '', 0, '', ''),
	(15, 'Garg', 'Monica', '', 'monica@monica.com', '4328100', '234 greenlane east', 'monica limited', '02209090909', NULL, 'Adviser', '', '', 0, '', ''),
	(16, 'Singh', 'Jaswant ', '', 'jaswant @ gmail.com', '34343434', 'bla bla bla', 'jazzzz', '021999992', NULL, 'Adviser', '', '', 0, '', ''),
	(17, 'Whitaker', 'Samantha', '', '', '12345', '', 'eliteinsure', '02102870531', NULL, 'Adviser', '', '', 0, '', ''),
	(18, 'Elkhidir', 'Amin', '', 'amin@eliteinsure.co.nz', '540986', '240 kilkenny Drive, East Tamaki Heights.Auckland', 'Elite Insure Ltd', '0210345407', NULL, 'Adviser', '', '', 0, '', ''),
	(21, 'Satigrama', 'Gurudutt', '', 'gurudutt@eliteinsure.co.nz', '488947', '1C/39 Mackelvie street', 'Eliteinsure limited', '021686463', NULL, 'Adviser', '', '', 0, '', ''),
	(23, 'Mahajan', 'Shivani', '', 'shivani@eliteinsure.co.nz', '551366', '47 Opaheke Road, Papakura, Auckland', 'Eliteinsure Limited', '0223400441', NULL, 'Adviser', '', '', 0, '', ''),
	(24, 'Ji', 'Peng(jackie)', '', 'jackie@eliteinsure.co.nz', '559806', '24C Sarabande Avenue, Redwood, Christchurch 8051', '', '021965066', NULL, 'Adviser', '', '', 0, '', ''),
	(26, 'Duggal', 'Shashwat', '', 'shashwat@eliteinsure.co.nz', '244445', '195 Mangatapu road, Tauranga', 'Eliteinsure Limited', '021988093', NULL, 'Adviser', '', '', 0, '', ''),
	(27, 'Behl', 'Rahul ', '', 'rahul@eliteinsure.co.nz', '541166', '602/96 symonds street, Auckland cbd, Auckland ', 'Behl Limited', '02102518709', NULL, 'Adviser', '', '', 0, '', ''),
	(29, 'Boparai', 'Navpreet', 'Singh', 'navpreet@eliteinsure.co.nz', 'FSP579127', 'Flat 14j, 18 Ronwood Avenue, Manukau, 2104, New Zealand', 'Eliteinsure Limited', '0211923302', NULL, 'Adviser', '', '', 0, '', ''),
	(33, 'Gulia', 'Aman', '', 'aman@eliteinsure.co.nz', 'FSP579287', '6 Zita Maria Drive, Massey', 'Amari Limited', '02108286266', NULL, 'Adviser', '', '', 0, '', ''),
	(35, 'Ohari', 'Mittan', '', 'mittan@eliteinsure.co.nz', '583868', '4/4 Beatty Ave, Manurewa, Auckland, 2102', 'Mittan Ohari', '0274648826', NULL, 'Adviser', '', '', 0, '', ''),
	(36, 'Nicholson', 'Kate', 'M', 'kate@eliteinsure.co.nz', '527647', '6/135 Manuka Road, Bayview', 'Elteinsure Limited', '021889807', NULL, 'Adviser', '', '', 0, '', ''),
	(37, 'Saharan', 'Vikas', '', 'vikas@eliteinsure.co.nz', '585728', '44 Taraoirie Ave, Takanini, 2112 Auckland ', 'Eliteinsure Limited', '+64212890001', NULL, 'Adviser', '', '', 0, '', ''),
	(38, 'Tan', 'Xin', '', 'sheen@eliteinsure.co.nz', '585868', '1C/39 Mackelvie street, Grey lynn, Auckland 1021', 'Eliteinsure Ltd', '0211348398', NULL, 'Adviser', '', '', 0, '', ''),
	(39, 'Aggarwal', 'Anshul', '', 'anshul@eliteinsure.co.nz', ' FSP593829', '45B russel road, Manurewa, 2102, Auckland', 'Eliteinsure Limited', '0279562929', NULL, 'Adviser', '', '', 0, '', ''),
	(40, 'Kashap', 'Varinder', '', 'varinder@eliteinsure.co.nz', '481646', '1C/39 Mackelvie Street', 'Eliteinsure Limited/Sky Financial Services', '0273527427', NULL, 'Adviser', '', '', 0, '', ''),
	(41, 'Pandya', 'Mohit', '', 'mohit@eliteinsure.co.nz', '603929', '1C/39 Mackelvie street, Grey Lynn 1021, Auckland', 'Eliteinsure Limited', '0211454319', NULL, 'Adviser', '', '', 0, '', ''),
	(43, 'Islam', 'Ariful', '', 'ariful@eliteinsure.co.nz', '609149', '', 'EliteInsure Ltd.', '0224705004', NULL, 'Adviser', '', '', 0, '', ''),
	(44, 'Ramneet', 'Jaggi', '', 'navi@eliteinsure.co.nz', '608689', '', 'EliteInsure Ltd.', '022 128 1823', NULL, 'Adviser', '', '', 0, '', ''),
	(47, 'Spasov', 'Plamen', 'Boyanov', 'paul@eliteinsure.co.nz', '612309', '1/c 39 Mackelvie, Grey Lynn, Auckland, 1021, New Zealand', 'EliteInsure Ltd.', '+64 21 038 9910‬', NULL, 'Adviser', '', '', 0, '', ''),
	(48, 'Alam', 'Hasan ', 'Md Rabiul', 'rabi@eliteinsure.co.nz', '620929', '', 'EliteInsure Ltd.', '02040921174', NULL, 'Adviser', '', '', 0, '', ''),
	(50, 'Guitguit', 'Donde', '', 'donde@eliteinsure.co.nz', '621549', '', 'EliteInsure Ltd.', '021 02466017', NULL, 'Adviser', '', '', 0, '', ''),
	(51, 'Kaur', 'Jaspreet', '', 'jazz@eliteinsure.co.nz', '628509', '', 'EliteInsure Ltd. ', '0212974425', NULL, 'Adviser', '', '', 0, '', ''),
	(52, 'Arora', 'Pratik', '', 'pratik@eliteinsure.co.nz', '629609', '', 'EliteInsure Ltd.', '021 555254', NULL, 'Adviser', '', '', 0, '', ''),
	(53, 'Ahmad', 'Jaseem', '', 'jaseem@eliteinsure.co.nz', '631049', '', 'EliteInsure Ltd.', '0275780786', NULL, 'Adviser', '', '', 0, '', ''),
	(54, 'Palu', 'Kanavale', 'Kaupulu ', 'kana@eliteinsure.co.nz', '568187', '', 'EliteInsure Ltd.', '0220423935', NULL, 'Adviser', '', '', 0, '', ''),
	(55, 'Burney', 'Te Hau Okiwa Taupua Brett', '', 'okiwa@eliteinsure.co.nz', '540568', '', 'EliteInsure Ltd.', '0225323846', NULL, 'Adviser', '', '', 0, '', ''),
	(56, 'Toutai', 'Francisco Tukunga ', 'Manatu ', 'franc@eliteinsure.co.nz', '622849', '', 'EliteInsure Ltd.', '', NULL, 'Adviser', '', '', 0, '', ''),
	(57, 'McDougall', 'Alicia', 'Marie', 'alicia@eliteinsure.co.nz', '600249', '11b St Peters Street', 'AMCD ENTERPRISES LIMITED/Eliteinsure Limited', '0220434670', NULL, 'Adviser', '', '', 0, '', ''),
	(58, 'Kumar', 'Sanah', '', 'sanah@eliteinsure.co.nz', '571407', '34 Summer Street, Ponsonby', 'SANAH SETH LIMITED/Eliteinsure Limited', '02041520954', NULL, 'Adviser', '', '', 0, '', ''),
	(60, 'McDougal', 'Alicia Marie', '', 'alicia@eliteinsure.co.nz', '600249', '', 'EliteInsure Ltd.', '0220434670', NULL, 'Adviser', '', '', 0, '', ''),
	(64, 'Lafiguera', 'Addie Ace', '', 'ace@eliteinsure.co.nz', '', '', '', '', NULL, 'Adviser', '', '', 0, '', ''),
	(65, 'Jabines', 'Hannah Jea', '', 'hannah@eliteinsure.co.nz', '', '', '', '', NULL, 'Adviser', '', '', 0, '', ''),
	(67, 'Taneja', 'Vishal', '', 'tanbyte@gmail.com', '', '', '', '', NULL, 'Adviser', '', '', 0, '', ''),
	(69, 'Hernandez', 'Jesse Dwight', 'Bautista', 'jesse@eliteinsure.co.nz', '00000', '1c/39 mackelvie street , grey  lynn, 1021', '0000', '', 'Passport_Pic_-_Copy5.png', 'Adviser', '', '', 0, '', ''),
	(72, 'Lamanilao', 'Kennith', '', 'kennith@eliteinsure.co.nz', '123456', 'Auckland', 'Ken', '123456', NULL, 'Adviser', '', '', 0, '', ''),
	(74, 'Guitguit', 'Mildred', '', 'mildred@eliteinsure.co.nz', '712511', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'EliteInsure Ltd.', '02102466017', NULL, 'Adviser', '', '', 0, '', ''),
	(75, 'Ocdao', 'Erlina', '', 'erlina@eliteinsure.co.nz', '714351', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0273883352', NULL, '', '', '', 0, '', ''),
	(76, 'Lagrimas', 'Leif Leewin', '', 'executive.admin@eliteinsure.co.nz', '12346', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '123456', NULL, '', '', '', 0, '', ''),
	(77, 'Tomar', 'Rohan', '', 'rohan@eliteinsure.co.nz', '486408', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0212616878', NULL, '', '', '', 0, '', ''),
	(78, 'Sun', 'Jay', '', 'jay@eliteinsure.co.nz', '537306', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '021823598', NULL, '', '', '', 0, '', ''),
	(79, 'Bruijn', 'Johan Josef Hubertus', '', 'johan@eliteinsure.co.nz', '654511', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0273625114', NULL, '', '', '', 0, '', ''),
	(80, 'Narayan', 'Bhawishna', '', 'bhawishna@eliteinsure.co.nz', '370106', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0211122401', NULL, '', '', '', 0, '', ''),
	(81, 'Devoy', 'Warren', '', 'warren@eliteinsure.co.nz', '617869', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '021808071', NULL, '', '', '', 0, '', ''),
	(82, 'Chaudhary', 'Yatin', '', 'yatin@eliteinsure.co.nz', '733392', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0210600133', NULL, '', '', '', 0, '', ''),
	(83, 'Kundan', 'Tariq', '', 'tariq@eliteinsure.co.nz', '732571', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0274401908', NULL, '', '', '', 0, '', ''),
	(84, 'Li', 'Ang', '', 'angie@eliteinsure.co.nz', '711711', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '02108098281', NULL, '', '', '', 0, '', ''),
	(85, 'Shi ', 'Yingjie ', '', 'jerry@eliteinsure.co.nz', '727532', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0221902981', NULL, '', '', '', 0, '', ''),
	(86, 'Thithimada', 'Anil ', '', 'anil@eliteinsure.co.nz', '636709', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0210610600', NULL, '', '', '', 0, '', ''),
	(87, 'Duggal', 'Sudhir', '', 'sudhir@eliteinsure.co.nz', '244405', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '021988092', NULL, '', '', '', 0, '', ''),
	(88, 'Rebosura', 'Ninez Barafon', '', 'ninez@eliteinsure.co.nz', '748151', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'EliteInsure Ltd.', '0224296623', NULL, '', '', '', 0, '', ''),
	(89, 'Vaughan', 'Zyra Jane Balaba', '', 'zyra@eliteinsure.co.nz', '671771', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'EliteInsure Ltd.', '0221201464', NULL, '', '', '', 0, '', ''),
	(90, 'Cosejo', 'Xerxel', 'Reyes', 'xerxel@eliteinsure.co.nz', '749511', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0212624239', NULL, '', '', '', 0, '', ''),
	(91, 'Gonzales', 'Glen', '', 'glen@eliteinsure.co.nz', '756031', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0211419250', NULL, '', '', '', 0, '', ''),
	(93, 'Panes', 'Enrino', '', 'enrino@eliteinsure.co.nz', '752311', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '02040849063', NULL, '', '', '', 0, '', ''),
	(94, 'Kaur', 'Gurjeet', '', 'gurjeet@eliteinsure.co.nz', '764231', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0221947015', NULL, '', '', '', 0, '', ''),
	(95, 'Burgess', 'Steve ', '', 'Steve@compliancerefinery.co.nz', '000000', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Compliance Refinery', '0275220477', NULL, '', '', '', 0, '', ''),
	(96, 'Legaspi', 'Sergio', '', 'gio@onlineinsure.co.nz', '123456', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '09088107651', NULL, '', '', '', 0, '', ''),
	(97, 'Demavivas', 'Andre', '', 'andredemavivas@gmail.com', '12345', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '09166187723', '', '', '', '', 0, '', ''),
	(98, 'Thakur', 'Prafull', '', 'praful@eliteinsure.co.nz', '69113', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0221006007', NULL, '', '', '', 0, '', '');
/*!40000 ALTER TABLE `advisers_tbl` ENABLE KEYS */;

-- Dumping structure for table compliance.company_provider
CREATE TABLE IF NOT EXISTS `company_provider` (
  `idcompany_provider` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Inactive',
  PRIMARY KEY (`idcompany_provider`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table compliance.company_provider: ~20 rows (approximately)
/*!40000 ALTER TABLE `company_provider` DISABLE KEYS */;
INSERT INTO `company_provider` (`idcompany_provider`, `company_name`, `status`) VALUES
	(1, 'Sovereign', 'Inactive'),
	(2, 'Asteron Life Ltd.', 'Active'),
	(3, 'NIB', 'Active'),
	(4, 'Fidelity', 'Active'),
	(5, 'OnePath', 'Inactive'),
	(6, 'Partners Life', 'Active'),
	(7, 'AIA', 'Active'),
	(8, 'AMP', 'Inactive'),
	(9, 'ANZ Life', 'Inactive'),
	(10, 'AXA', 'Inactive'),
	(11, 'BNZ Life', 'Inactive'),
	(12, 'Cigna', 'Active'),
	(13, 'National Bank Life', 'Inactive'),
	(14, 'Pinnacle Life', 'Inactive'),
	(15, 'Tower', 'Inactive'),
	(16, 'Westpac23', 'Inactive'),
	(17, 'Accuro', 'Active'),
	(19, 'NZFunds', 'Active');
/*!40000 ALTER TABLE `company_provider` ENABLE KEYS */;

-- Dumping structure for table compliance.privilege_tbl
CREATE TABLE IF NOT EXISTS `privilege_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table compliance.privilege_tbl: ~5 rows (approximately)
/*!40000 ALTER TABLE `privilege_tbl` DISABLE KEYS */;
INSERT INTO `privilege_tbl` (`id`, `name`, `description`) VALUES
	(1, 'dashboard', 'default home page'),
	(2, 'users', 'module to view/add/update user profiles'),
	(3, 'compliance', 'module for compliance'),
	(4, 'advisers', 'module to view/add/update adviser profiles'),
	(5, 'fieldmanagement', 'module to manage dropdowns');
/*!40000 ALTER TABLE `privilege_tbl` ENABLE KEYS */;

-- Dumping structure for table compliance.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `idproduct_category` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`idproduct_category`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Dumping data for table compliance.product_category: ~15 rows (approximately)
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` (`idproduct_category`, `code`, `name`, `status`) VALUES
	(1, 'LIFE', 'Life Cover', 'Active'),
	(2, 'TRAUMA', 'Trauma', 'Active'),
	(3, 'FID_TRAUMA', 'Fidelity – Trauma Multi Cover', 'Active'),
	(4, 'PROG_CARE', 'Progressive Care', 'Active'),
	(5, 'MORT_INCOM', 'Mortgage and Income Protection', 'Active'),
	(6, 'INCOME', 'Income Protection', 'Active'),
	(7, 'TPD', 'TPD', 'Active'),
	(8, 'HEALTH', 'Health Cover', 'Active'),
	(9, 'WAIV_PREM', 'Waiver of Premium', 'Active'),
	(10, 'LIFE_FAMILY', 'Ongoing Life Cover / Family Protection', 'Active'),
	(11, 'BUSINESS', 'Business Continuity Cover', 'Active'),
	(12, 'RURAL', 'Rural Continuity', 'Active'),
	(14, 'ACCIDENTAL', 'AIA living optional Accidental Injury Cover', 'Active'),
	(15, 'CIGNA', 'Cigna Specific Injury Cover', 'Active');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;

-- Dumping structure for table compliance.results_tbl
CREATE TABLE IF NOT EXISTS `results_tbl` (
  `results_id` int(11) NOT NULL AUTO_INCREMENT,
  `adviser_id` int(11) DEFAULT NULL,
  `providers` int(11) DEFAULT NULL,
  `policy_type` int(11) DEFAULT NULL,
  `clients` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `answers` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`results_id`),
  KEY `FK_results_tbl_advisers_tbl` (`adviser_id`),
  KEY `FK_results_tbl_company_provider` (`providers`),
  KEY `FK_results_tbl_product_category` (`policy_type`),
  CONSTRAINT `FK_results_tbl_advisers_tbl` FOREIGN KEY (`adviser_id`) REFERENCES `advisers_tbl` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_results_tbl_company_provider` FOREIGN KEY (`providers`) REFERENCES `company_provider` (`idcompany_provider`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_results_tbl_product_category` FOREIGN KEY (`policy_type`) REFERENCES `product_category` (`idproduct_category`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table compliance.results_tbl: ~1 rows (approximately)
/*!40000 ALTER TABLE `results_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `results_tbl` ENABLE KEYS */;

-- Dumping structure for table compliance.user_tbl
CREATE TABLE IF NOT EXISTS `user_tbl` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `img` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `privileges` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table compliance.user_tbl: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_tbl` DISABLE KEYS */;
INSERT INTO `user_tbl` (`id`, `name`, `email`, `password`, `admin`, `img`, `token`, `privileges`) VALUES
	(1, 'Sumit Monga', 'sumit@eliteinsure.co.nz', 'f9598c2dd34ad2c3f75c05278b6f442f', 1, '', '', 'dashboard,users'),
	(7, 'Omar Khay Margen', 'omar@eliteinsure.co.nz', '5f4dcc3b5aa765d61d8327deb882cf99', 1, '', '', 'dashboard,users,compliance,advisers,fieldmanagement');
/*!40000 ALTER TABLE `user_tbl` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
