-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 07:27 AM
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
-- Database: `compliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisers_tbl`
--

CREATE TABLE `advisers_tbl` (
  `idusers` int(11) NOT NULL,
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
  `advOngoingCommissionPer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `advisers_tbl`
--

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
(98, 'Thakur', 'Prafull', '', 'praful@eliteinsure.co.nz', '69113', '3G/39 Mackelvie Street, Grey Lynn, Auckland, 1021, New Zealand', 'Eliteinsure Ltd.', '0221006007', NULL, '', '', '', 0, '', ''),
(110, 'Adviser Test', 'Sam', ' ', 'samuel.m@onlineinsure.co.nz', '111', '222', '333', '444', NULL, '', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_provider`
--

CREATE TABLE `company_provider` (
  `idcompany_provider` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_provider`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `privilege_tbl`
--

CREATE TABLE `privilege_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privilege_tbl`
--

INSERT INTO `privilege_tbl` (`id`, `name`, `description`) VALUES
(1, 'dashboard', 'default home page'),
(2, 'users', 'module to view/add/update user profiles'),
(3, 'compliance', 'module for compliance'),
(4, 'advisers', 'module to view/add/update adviser profiles'),
(5, 'fieldmanagement', 'module to manage dropdowns'),
(6, 'pdf', 'module to manage pdf files');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `idproduct_category` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `results_tbl`
--

CREATE TABLE `results_tbl` (
  `results_id` int(11) NOT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `providers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clients` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replacement` enum('Yes','No','N/A') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `added_by` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `answers` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results_tbl`
--

INSERT INTO `results_tbl` (`results_id`, `adviser_id`, `providers`, `policy_type`, `policy_number`, `clients`, `replacement`, `filename`, `date_added`, `date_modified`, `added_by`, `score`, `answers`, `email`, `token`) VALUES
(2, 110, '17,7,2,12', '14,15,3', '12321321', 'Kevin', 'No', 'File review - Kevin by Sam Adviser Test', '2021-06-08 11:55:35', '2021-06-08 13:21:18', 7, 7, '{\"info\":{\"client\":\"Kevin\",\"adviser\":\"110\",\"policyType\":[\"14\",\"15\",\"3\"],\"providers\":[\"17\",\"7\",\"2\",\"12\"],\"policyNumber\":\"12321321\",\"replacement\":\"No\",\"filename\":\"File review - Kevin by Sam Adviser Test\"},\"step1\":[{\"value\":\"0\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations?\",\"notes\":\"test\"},{\"value\":\"2\",\"question\":\"Can you evidence that you clearly explain the extent (scope) of services and products you can provide and areas of competency including any limitations to your authorities, potential or know conflicts of interest so a client can make an informed choice whether to use your services?\",\"notes\":\"abc\"},{\"value\":\"2\",\"question\":\"If a client declines to undertake a full suitability or needs analysis, is this decision noted in writing and signed and dated by the client acknowledging the advantages of a suitability analysis and the limitations of not undertaking one?\",\"notes\":\"123\"},{\"value\":\"2\",\"question\":\"Do you note any other specific tasks requested by the client?\",\"notes\":\"321\"},{\"value\":\"1\",\"question\":\"Do you explain how information you gather is used, the security of this information and who has access? (Privacy Statement and Acknowledgment})\",\"notes\":\"etesra\"},{\"value\":\"0\",\"question\":\"Do you get client(s) sign off on the Scope of Engagement and Privacy Act explanations and other acknowledgements e.g. receipt of documents\",\"notes\":\"rearea\"}],\"step2\":[{\"value\":\"\",\"question\":\"Do you use a formal Fact Find Needs Analysis Document or Technology Platform that is designed to uncover all client circumstances having a bearing on the advice as per the agreed nature and scope of the engagement?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Throughout the process, do you formally establish and seek to understand and validate the clients attitude to and capacity for risk (risk tolerance) in accordance with the agreed Scope of Engagement? Including:<ul> <li>General attitude (willingness) to accept risk or self-insure<\\/li><li>Priorities for cover type and identified needs<\\/li><li>Self-insurance levels or time frames e.g. use of wait period \\/ excesses<\\/li><li>Availability and willingness to use own assets or borrow (capacity) including liquidity<\\/li><li>Willingness to accept risk<\\/li><li>Willingness to use family support \\/ Government support \\/ Public health services<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you discuss with the client and record their personal objectives (reasons) for implementing a risk insurance plan relevant to the agreed nature and scope of the engagement?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you discuss with client, listen and record sufficient qualitative information about the client\\u2019s personal situation relevant to the agreed nature and scope of the engagement that may impact on needs? For example: <ul><li> Personal circumstances including obligations, values beliefs, aspirations, goals etc) especially around<\\/li><li>Family<\\/li><li>Work (income sources)<\\/li><li>Housing<\\/li><li>Money\\/Investments<\\/li> <li>Lifestyle<\\/li><li>Business Circumstances<\\/li><li>Any reasonably foreseeable changes to these circumstances<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you gather and record sufficient quantitative client information relevant to the agreed nature and scope of the engagement to be able to make sound recommendations? For example: <strong>Personal details<\\/strong> such as: <ul><li>dates of birth, address, marital status, and residency status <\\/li><li> health status, pastimes and habits <\\/li><li> employment status and nature of the job <\\/li><li> Children <\\/li><li> Estate planning provisions including details use of other advisers (e.g. accountants) Financial circumstances and details such as: <\\/li><li> Assets (relevant to advice) including ownership <\\/li><li> Current and potential liabilities <\\/li><li> Level and nature of income from all sources o Existing insurances <\\/li><li>Initial quantification \\/ calculation of needs<\\/li><\\/ul>\",\"notes\":\"\"}],\"step3\":[{\"value\":\"\",\"question\":\"Do you review all client information to <strong>identify circumstances that will impact on strategy and product solutions<\\/strong> and how these may be incorporated into the advice? Consideration can include:<ul><li>Current assets<\\/li><li>Current insurances<\\/li><li>Health, family history, existing conditions, hazardous pursuits, habits, residency.<\\/li><li>Sophistication of client (skills, experience and vulnerability)<\\/li><li>Possibility of loading \\/ exclusions<\\/li><li>Time frames i.e. short-term needs versus long-term needs and affordability<\\/li><li>Risk tolerances e.g. for wait period, benefit levels and excesses<\\/li><li>Reasonably foreseeable changes to circumstances e.g. family status, inheritances, increased debt, change of employment situation, asset acquisition<\\/li><li>Client\\u2019s stated priorities \\/preferences<\\/li><li>Taxation implications<\\/li><li>Alternative strategies if insurance not possible.<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you analyse and evaluate the availability and use of alternative sources of support as part of the overall strategy and solution. For example:<ul><li>ACC<\\/li><li>WINZ<\\/li><li>Ministry of Health<\\/li><li>Primary Health Organisations<\\/li><li>Family<\\/li><li>Self-insurance<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you research, analyse and evaluate existing insurance covers to determine if still fit for purpose. This may include such things as: <ul><li>Product features and options comparisons (loss or gain)<\\/li><li>Existence of special concessions in existing cover<\\/li><li>Impact of new health conditions, occupation, pursuits and habits on any proposed cover (potential loss of benefits \\/cover)<\\/li><li>Premium projections and comparisons over the longer term<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you consider and model different solution options based on client needs, client needs, circumstances and\\/or client priorities.\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you carry out relevant research and analysis to identify products and providers which provide solutions to meet the client\\u2019s needs and circumstances. This may have included (but not limited to) such things as: <ul><li>Availability of product structures, options and benefits that match required strategies (including ownership options and premium structures)<\\/li><li>Premium comparisons over the short and longer term<\\/li><li>Provider financial standing<\\/li><li>Possible underwriting outcomes by different providers<\\/li><li>Provider reputation and adviser experiences<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you identify and evaluate any <strong>reasonably foreseeable limitations, risks and disadvantages<\\/strong> of the products or solutions recommended.\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Are notes on your rationale leading to the advice (research and analysis outcomes as above) documented and on file?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Are you satisfied any product research or analysis not conducted by you can be relied upon and can you demonstrate this?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you identify and evaluate areas where the client needs to get specialist advice such as a legal, estate planning or accounting\",\"notes\":\"\"}],\"step4\":[{\"value\":\"\",\"question\":\"Do you provide a written record or Statement of Advice to your clients?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Are recommendations in the Statements of Advice written\\/presented in a clear, concise and effective way and suitable to:<ul><li>The level of sophistication of the client?<\\/li><li>Any identified client vulnerabilities?<\\/li><li>The level and nature of the advice as agreed in the Scope of Engagement.<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you check all advice documents to ensure there are no misleading (or likely to mislead) statements or omission of relevant information?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you restate the Scope of Service and any other terms of the engagement?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you summarise key relevant facts and client circumstances on which your advice is based?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you summarise the client\\u2019s core needs and objectives (in personal and practical terms) and their priorities?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly outline any considerations in arriving at your advice? For example: <ul><li>Client\\u2019s risks tolerance\\/capacity<\\/li><li>Priorities<\\/li><li>Choice of product provider<\\/li><li>Known limitations to the advice e.g. needs identified but unable to address, insufficient information provided<\\/li><li>Reasons for cancelling or retaining existing cover<\\/li><li>Any restrictions to being able to provide best possible solution e.g. health status of client and any alternative risk management strategies<\\/li><li>Government support available and their impact<\\/li><li>Tax implications<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does your advice clearly define the underpinning strategies recommended to address client\\u2019s needs and objectives?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly state how your product recommendations will meet the needs, circumstances and objectives of the client? This may include: <ul><li>LCover types and benefit structures<\\/li><li>Sums insured<\\/li><li>Premium type(s)<\\/li><li>Optional Options recommended<\\/li><li>Ownership structures recommended etc<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Is the advice presented based on identified needs and not modified to represent the client\\u2019s final decision e.g. Accepting only part of the recommendation?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly state any identified risks, limitations or disadvantages of the recommended strategies or product solutions? For example: <ul><li>Needs identified but not addressed <\\/li><li> Replacement of policy and possible risks and consequences of non-disclosure <\\/li><li> Insufficient provision of information \\u2022 Not implementing the recommendations<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the recommendation clearly outline the premium costs (or your fees) of implementing the recommended strategies and products?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you clearly and effectively communicate any conflicts of interest that might influence your advice e.g. qualification for higher commissions or qualifications for overseas trips and other incentives?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Is the need for the client to seek other legal or specialist advice identified and noted in your advice? For example: need for Wills, EPAs etc.\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations required at this point of the process?\",\"notes\":\"\"}],\"step5\":[{\"value\":\"\",\"question\":\"Is there an appropriate place recording any client-initiated variations to the advice?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you explain the process of implementation of any strategies and insurance solutions including possible time frames and impact of other requirements such as medical examinations, use of other professionals etc?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you discuss the reasons for a review of their plans and products? Is such a review and an appropriate time frame and method recommended and agreed by the client?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the client sign an Authority to Proceed? For example: <ul><li>Proceed with full recommendations<\\/li><li>Proceed with noted variations<\\/li><li>Do not proceed with recommendations<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you carefully support the client through the application questions to ensure they fully understand the disclosure requirements and complete all necessary documentation?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you send a copy of their application(s) and reminding them of their Duty of Disclosure? This letter could include: <ul><li> Matters they may have overlooked<\\/li><li> Health\\/Occupation changes since application<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you monitor and maintain tracking records (file notes) of the application and implementation process to ensure it is keeping within agreed time frames and to keep the client informed? For example:<ul><li>Discussion with underwriters \\/ new business staff<\\/li><li>Follow up conversations and actions on outstanding requirements<\\/li><li>Discussion of variation to terms of cover and acceptance or otherwise<\\/li><\\/ul>\",\"notes\":\"\"}],\"step6\":[{\"value\":\"\",\"question\":\"Can you evidence how you communicate with clients to determine if circumstances and needs have changed (triggers) and\\/or communicated with client and arranged a review\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations required at this point of the process?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Conducted a check with the client to understand and identify changes in circumstances and \\/or needs that will necessitate strategy or insurance product changes. Changes may include (but not limited to) such things as: <ul><li>Relationship status<\\/li><li>Family status and responsibilities<\\/li><li>Employment<\\/li><li>Nature and source of income<\\/li><li>Other financial circumstances including assets and liabilities<\\/li><li>Insurances in place (acquired or ended\\/cancelled)<\\/li><li>Risk tolerances and objectives<\\/li><li>Health<\\/li><li>Pastimes and habits<\\/li><li>Goals and aspirations<\\/li><li>Beneficiaries<\\/li><\\/ul>\",\"notes\":\"\"}]}', NULL, 'f8db770a467dc62589146fa4bde369b9'),
(3, 110, '12', '15', '21321', 'New User', 'No', 'File review - New User by Sam Adviser Test', '2021-06-08 13:25:39', '2021-06-08 13:27:17', 7, 16, '{\"info\":{\"client\":\"New User\",\"adviser\":\"110\",\"policyType\":[\"15\"],\"providers\":[\"12\"],\"policyNumber\":\"21321\",\"replacement\":\"No\",\"filename\":\"File review - New User by Sam Adviser Test\"},\"step1\":[{\"value\":\"1\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations?\",\"notes\":\"\"},{\"value\":\"2\",\"question\":\"Can you evidence that you clearly explain the extent (scope) of services and products you can provide and areas of competency including any limitations to your authorities, potential or know conflicts of interest so a client can make an informed choice whether to use your services?\",\"notes\":\"\"},{\"value\":\"2\",\"question\":\"If a client declines to undertake a full suitability or needs analysis, is this decision noted in writing and signed and dated by the client acknowledging the advantages of a suitability analysis and the limitations of not undertaking one?\",\"notes\":\"\"},{\"value\":\"2\",\"question\":\"Do you note any other specific tasks requested by the client?\",\"notes\":\"\"},{\"value\":\"2\",\"question\":\"Do you explain how information you gather is used, the security of this information and who has access? (Privacy Statement and Acknowledgment})\",\"notes\":\"\"},{\"value\":\"0\",\"question\":\"Do you get client(s) sign off on the Scope of Engagement and Privacy Act explanations and other acknowledgements e.g. receipt of documents\",\"notes\":\"\"}],\"step2\":[{\"value\":\"0\",\"question\":\"Do you use a formal Fact Find Needs Analysis Document or Technology Platform that is designed to uncover all client circumstances having a bearing on the advice as per the agreed nature and scope of the engagement?\",\"notes\":\"test\"},{\"value\":\"1\",\"question\":\"Throughout the process, do you formally establish and seek to understand and validate the clients attitude to and capacity for risk (risk tolerance) in accordance with the agreed Scope of Engagement? Including:<ul> <li>General attitude (willingness) to accept risk or self-insure<\\/li><li>Priorities for cover type and identified needs<\\/li><li>Self-insurance levels or time frames e.g. use of wait period \\/ excesses<\\/li><li>Availability and willingness to use own assets or borrow (capacity) including liquidity<\\/li><li>Willingness to accept risk<\\/li><li>Willingness to use family support \\/ Government support \\/ Public health services<\\/li><\\/ul>\",\"notes\":\"test\"},{\"value\":\"1\",\"question\":\"Do you discuss with the client and record their personal objectives (reasons) for implementing a risk insurance plan relevant to the agreed nature and scope of the engagement?\",\"notes\":\"test\"},{\"value\":\"2\",\"question\":\"Do you discuss with client, listen and record sufficient qualitative information about the client\\u2019s personal situation relevant to the agreed nature and scope of the engagement that may impact on needs? For example: <ul><li> Personal circumstances including obligations, values beliefs, aspirations, goals etc) especially around<\\/li><li>Family<\\/li><li>Work (income sources)<\\/li><li>Housing<\\/li><li>Money\\/Investments<\\/li> <li>Lifestyle<\\/li><li>Business Circumstances<\\/li><li>Any reasonably foreseeable changes to these circumstances<\\/li><\\/ul>\",\"notes\":\"test\"},{\"value\":\"1\",\"question\":\"Do you gather and record sufficient quantitative client information relevant to the agreed nature and scope of the engagement to be able to make sound recommendations? For example: <strong>Personal details<\\/strong> such as: <ul><li>dates of birth, address, marital status, and residency status <\\/li><li> health status, pastimes and habits <\\/li><li> employment status and nature of the job <\\/li><li> Children <\\/li><li> Estate planning provisions including details use of other advisers (e.g. accountants) Financial circumstances and details such as: <\\/li><li> Assets (relevant to advice) including ownership <\\/li><li> Current and potential liabilities <\\/li><li> Level and nature of income from all sources o Existing insurances <\\/li><li>Initial quantification \\/ calculation of needs<\\/li><\\/ul>\",\"notes\":\"test\"}],\"step3\":[{\"value\":\"0\",\"question\":\"Do you review all client information to <strong>identify circumstances that will impact on strategy and product solutions<\\/strong> and how these may be incorporated into the advice? Consideration can include:<ul><li>Current assets<\\/li><li>Current insurances<\\/li><li>Health, family history, existing conditions, hazardous pursuits, habits, residency.<\\/li><li>Sophistication of client (skills, experience and vulnerability)<\\/li><li>Possibility of loading \\/ exclusions<\\/li><li>Time frames i.e. short-term needs versus long-term needs and affordability<\\/li><li>Risk tolerances e.g. for wait period, benefit levels and excesses<\\/li><li>Reasonably foreseeable changes to circumstances e.g. family status, inheritances, increased debt, change of employment situation, asset acquisition<\\/li><li>Client\\u2019s stated priorities \\/preferences<\\/li><li>Taxation implications<\\/li><li>Alternative strategies if insurance not possible.<\\/li><\\/ul>\",\"notes\":\"aaa\"},{\"value\":\"0\",\"question\":\"Do you analyse and evaluate the availability and use of alternative sources of support as part of the overall strategy and solution. For example:<ul><li>ACC<\\/li><li>WINZ<\\/li><li>Ministry of Health<\\/li><li>Primary Health Organisations<\\/li><li>Family<\\/li><li>Self-insurance<\\/li><\\/ul>\",\"notes\":\"test\"},{\"value\":\"1\",\"question\":\"Do you research, analyse and evaluate existing insurance covers to determine if still fit for purpose. This may include such things as: <ul><li>Product features and options comparisons (loss or gain)<\\/li><li>Existence of special concessions in existing cover<\\/li><li>Impact of new health conditions, occupation, pursuits and habits on any proposed cover (potential loss of benefits \\/cover)<\\/li><li>Premium projections and comparisons over the longer term<\\/li><\\/ul>\",\"notes\":\"testse test \"},{\"value\":\"0\",\"question\":\"Do you consider and model different solution options based on client needs, client needs, circumstances and\\/or client priorities.\",\"notes\":\"test\"},{\"value\":\"0\",\"question\":\"Do you carry out relevant research and analysis to identify products and providers which provide solutions to meet the client\\u2019s needs and circumstances. This may have included (but not limited to) such things as: <ul><li>Availability of product structures, options and benefits that match required strategies (including ownership options and premium structures)<\\/li><li>Premium comparisons over the short and longer term<\\/li><li>Provider financial standing<\\/li><li>Possible underwriting outcomes by different providers<\\/li><li>Provider reputation and adviser experiences<\\/li><\\/ul>\",\"notes\":\"test\"},{\"value\":\"0\",\"question\":\"Do you identify and evaluate any <strong>reasonably foreseeable limitations, risks and disadvantages<\\/strong> of the products or solutions recommended.\",\"notes\":\"test\"},{\"value\":\"0\",\"question\":\"Are notes on your rationale leading to the advice (research and analysis outcomes as above) documented and on file?\",\"notes\":\"test\"},{\"value\":\"1\",\"question\":\"Are you satisfied any product research or analysis not conducted by you can be relied upon and can you demonstrate this?\",\"notes\":\"test\"},{\"value\":\"0\",\"question\":\"Do you identify and evaluate areas where the client needs to get specialist advice such as a legal, estate planning or accounting\",\"notes\":\"test\"}],\"step4\":[{\"value\":\"\",\"question\":\"Do you provide a written record or Statement of Advice to your clients?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Are recommendations in the Statements of Advice written\\/presented in a clear, concise and effective way and suitable to:<ul><li>The level of sophistication of the client?<\\/li><li>Any identified client vulnerabilities?<\\/li><li>The level and nature of the advice as agreed in the Scope of Engagement.<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you check all advice documents to ensure there are no misleading (or likely to mislead) statements or omission of relevant information?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you restate the Scope of Service and any other terms of the engagement?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you summarise key relevant facts and client circumstances on which your advice is based?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you summarise the client\\u2019s core needs and objectives (in personal and practical terms) and their priorities?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly outline any considerations in arriving at your advice? For example: <ul><li>Client\\u2019s risks tolerance\\/capacity<\\/li><li>Priorities<\\/li><li>Choice of product provider<\\/li><li>Known limitations to the advice e.g. needs identified but unable to address, insufficient information provided<\\/li><li>Reasons for cancelling or retaining existing cover<\\/li><li>Any restrictions to being able to provide best possible solution e.g. health status of client and any alternative risk management strategies<\\/li><li>Government support available and their impact<\\/li><li>Tax implications<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does your advice clearly define the underpinning strategies recommended to address client\\u2019s needs and objectives?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly state how your product recommendations will meet the needs, circumstances and objectives of the client? This may include: <ul><li>LCover types and benefit structures<\\/li><li>Sums insured<\\/li><li>Premium type(s)<\\/li><li>Optional Options recommended<\\/li><li>Ownership structures recommended etc<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Is the advice presented based on identified needs and not modified to represent the client\\u2019s final decision e.g. Accepting only part of the recommendation?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the advice clearly state any identified risks, limitations or disadvantages of the recommended strategies or product solutions? For example: <ul><li>Needs identified but not addressed <\\/li><li> Replacement of policy and possible risks and consequences of non-disclosure <\\/li><li> Insufficient provision of information \\u2022 Not implementing the recommendations<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the recommendation clearly outline the premium costs (or your fees) of implementing the recommended strategies and products?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you clearly and effectively communicate any conflicts of interest that might influence your advice e.g. qualification for higher commissions or qualifications for overseas trips and other incentives?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Is the need for the client to seek other legal or specialist advice identified and noted in your advice? For example: need for Wills, EPAs etc.\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations required at this point of the process?\",\"notes\":\"\"}],\"step5\":[{\"value\":\"\",\"question\":\"Is there an appropriate place recording any client-initiated variations to the advice?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you explain the process of implementation of any strategies and insurance solutions including possible time frames and impact of other requirements such as medical examinations, use of other professionals etc?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you discuss the reasons for a review of their plans and products? Is such a review and an appropriate time frame and method recommended and agreed by the client?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Does the client sign an Authority to Proceed? For example: <ul><li>Proceed with full recommendations<\\/li><li>Proceed with noted variations<\\/li><li>Do not proceed with recommendations<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you carefully support the client through the application questions to ensure they fully understand the disclosure requirements and complete all necessary documentation?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you send a copy of their application(s) and reminding them of their Duty of Disclosure? This letter could include: <ul><li> Matters they may have overlooked<\\/li><li> Health\\/Occupation changes since application<\\/li><\\/ul>\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Do you monitor and maintain tracking records (file notes) of the application and implementation process to ensure it is keeping within agreed time frames and to keep the client informed? For example:<ul><li>Discussion with underwriters \\/ new business staff<\\/li><li>Follow up conversations and actions on outstanding requirements<\\/li><li>Discussion of variation to terms of cover and acceptance or otherwise<\\/li><\\/ul>\",\"notes\":\"\"}],\"step6\":[{\"value\":\"\",\"question\":\"Can you evidence how you communicate with clients to determine if circumstances and needs have changed (triggers) and\\/or communicated with client and arranged a review\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Can you evidence you meet all applicable Disclosure Regulations required at this point of the process?\",\"notes\":\"\"},{\"value\":\"\",\"question\":\"Conducted a check with the client to understand and identify changes in circumstances and \\/or needs that will necessitate strategy or insurance product changes. Changes may include (but not limited to) such things as: <ul><li>Relationship status<\\/li><li>Family status and responsibilities<\\/li><li>Employment<\\/li><li>Nature and source of income<\\/li><li>Other financial circumstances including assets and liabilities<\\/li><li>Insurances in place (acquired or ended\\/cancelled)<\\/li><li>Risk tolerances and objectives<\\/li><li>Health<\\/li><li>Pastimes and habits<\\/li><li>Goals and aspirations<\\/li><li>Beneficiaries<\\/li><\\/ul>\",\"notes\":\"\"}]}', NULL, '608f2c35e40568e89d468bf7cb87c770');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `img` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `privileges` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `name`, `email`, `password`, `admin`, `img`, `token`, `privileges`) VALUES
(1, 'Sumit Monga', 'sumit@eliteinsure.co.nz', 'f9598c2dd34ad2c3f75c05278b6f442f', 1, '', '', 'dashboard,users'),
(7, 'Omar Khay Margen', 'omar@eliteinsure.co.nz', '5f4dcc3b5aa765d61d8327deb882cf99', 1, '', '', 'dashboard,users,compliance,advisers,fieldmanagement,pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisers_tbl`
--
ALTER TABLE `advisers_tbl`
  ADD PRIMARY KEY (`idusers`);

--
-- Indexes for table `company_provider`
--
ALTER TABLE `company_provider`
  ADD PRIMARY KEY (`idcompany_provider`);

--
-- Indexes for table `privilege_tbl`
--
ALTER TABLE `privilege_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`idproduct_category`);

--
-- Indexes for table `results_tbl`
--
ALTER TABLE `results_tbl`
  ADD PRIMARY KEY (`results_id`),
  ADD KEY `FK_results_tbl_advisers_tbl` (`adviser_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisers_tbl`
--
ALTER TABLE `advisers_tbl`
  MODIFY `idusers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `company_provider`
--
ALTER TABLE `company_provider`
  MODIFY `idcompany_provider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `privilege_tbl`
--
ALTER TABLE `privilege_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `idproduct_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `results_tbl`
--
ALTER TABLE `results_tbl`
  MODIFY `results_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `results_tbl`
--
ALTER TABLE `results_tbl`
  ADD CONSTRAINT `FK_results_tbl_advisers_tbl` FOREIGN KEY (`adviser_id`) REFERENCES `advisers_tbl` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
