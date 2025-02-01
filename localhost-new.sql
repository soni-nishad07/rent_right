-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2025 at 01:24 PM
-- Server version: 10.6.20-MariaDB
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u741372006_rentright`
--
CREATE DATABASE IF NOT EXISTS `u741372006_rentright` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `u741372006_rentright`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_register`
--

CREATE TABLE `admin_register` (
  `id` int(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_register`
--

INSERT INTO `admin_register` (`id`, `username`, `email`, `password`) VALUES
(4, 'info@rentrightbangalore.com', 'info@rentrightbangalore.com', '$2y$10$YbP6XYQISdycg.4VHvJaEeMpXvbew5o75Pt4D7Iruoxt2NCiRUnwy');

-- --------------------------------------------------------

--
-- Table structure for table `bhk_searches`
--

CREATE TABLE `bhk_searches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bhk_searches`
--

INSERT INTO `bhk_searches` (`id`, `name`) VALUES
(2, '1 BHK Flats in Bangalore'),
(3, '2 BHK Flats in Bangalore'),
(4, '3 BHK Flats in Bangalore'),
(5, '4 BHK Flats in Bangalore ');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(225) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `booking_date` date NOT NULL,
  `submit_date` date NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `booking_status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `name`, `email`, `mobile`, `address`, `payment_mode`, `booking_date`, `submit_date`, `service_name`, `booking_status`) VALUES
(1, 'booking_66bef69b66d274.17614131', 'Aditya', 'ravi@rpinfocare.com', '6361793287', 'SOmpura gate', 'cash', '2024-08-18', '2024-08-16', '1BHK', 'Complete'),
(10, 'booking_66b0c7d05239a2.09091392', 'sumit', 'soni@gmail.com', '9632587410', 'Ruskam bihar colony nadarganj, lko', 'cash', '2024-08-06', '2024-08-05', 'Exterior', 'Complete'),
(12, 'booking_66bf96c0935d77.52761742', 'abc', 'abc@gmail.com', '9856321470', 'lko', 'cash', '2024-08-23', '2024-08-16', '3BHK', 'pending'),
(14, 'booking_6725c3eee1b056.47850255', 'Maanisha ', 'pothinimaanisha@gmail.com', '8939059999', 'GSN Residency ', 'cash', '2024-11-05', '2024-11-02', 'Cleaning services', 'pending'),
(15, 'booking_673d56ff8ee4b8.22186632', 'subbareddy', 'osreddy40@gmail.com', '9742541100', '', '', '2024-11-20', '2024-11-20', 'Electrician', 'pending'),
(16, 'booking_673d57008dccd0.01673183', 'subbareddy', 'osreddy40@gmail.com', '9742541100', '', '', '2024-11-20', '2024-11-20', 'Electrician', 'pending'),
(17, 'booking_676fbbb1c31c15.70910339', 'Anamika', 'admin@gmail.com', '6361793287', '', '', '0000-00-00', '2024-12-28', '2BHK', 'Cancel'),
(18, 'booking_676fbbbb6e4a33.51827699', 'Anamika', 'admin@gmail.com', '6361793287', '', '', '0000-00-00', '2024-12-28', '2BHK', 'pending'),
(22, 'booking_677e5e9368b4f5.36324388', 'demotest', 'demotest@gmail.com', '8596749685', '', '', '0000-00-00', '2025-01-08', 'Painting', 'pending'),
(23, 'booking_677f96784edaf7.37731890', 'hgdh', 'gg@gmail.com', '1236985740', '', '', '0000-00-00', '2025-01-09', 'Fabrication', 'pending'),
(24, 'booking_677f96b28c5493.10665657', 'fgfj', 'abc@gmail.com', '8745963210', '', '', '0000-00-00', '2025-01-09', 'Packers &amp; Movers', 'pending'),
(25, 'booking_67814152c513d7.72711782', 'Aditya', 'er.aditt@gmail.com', '6361793287', '', '', '0000-00-00', '2025-01-10', 'Painting', 'pending'),
(26, 'booking_678222aad6bea8.66823554', 'hgdh', 'abc@gmail.com', '8521479630', '', '', '0000-00-00', '2025-01-11', 'Painting', 'pending'),
(27, 'booking_67822eccada813.91600810', 'ghgh', 'aa@gmail.com', '7895412630', '', '', '0000-00-00', '2025-01-11', '3BHK', 'pending'),
(28, 'booking_6783f5f937e2b9.10505317', 'RRB RENT RIGHT LLP', 'info@rentrightbangalore.com', '9538221946', '', '', '0000-00-00', '2025-01-12', '1BHK', 'pending'),
(29, 'booking_6788140f41ae72.53621251', 'Rajesh Kumar', 'Rajeshavn@yahoo.co.in', '9986784393', '', '', '0000-00-00', '2025-01-15', '2BHK', 'pending'),
(30, 'booking_678f7bb6c919c8.05964742', 'Jaffar', 'jaffar8055@gmail.com', '8123707783', '', '', '0000-00-00', '2025-01-21', '1BHK', 'pending'),
(31, 'booking_6793026cab09d9.44932137', 'Hari', 'hari747@gmail.com', '9491783518', '', '', '0000-00-00', '2025-01-24', '2BHK', 'pending'),
(32, 'booking_67937bf2a7acf2.90156662', 'Hemanth', 'sansandy3109@gmail.com', '7204510324', '', '', '0000-00-00', '2025-01-24', '1BHK', 'pending'),
(33, 'booking_6795ab0df35626.54324222', 'hari K', 'hari747@gmail.com', '9491783518', '', '', '0000-00-00', '2025-01-26', '2BHK', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `property_choose` varchar(255) NOT NULL,
  `property_type` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bhk_type` varchar(255) DEFAULT NULL,
  `expected_rent_from` decimal(10,2) DEFAULT NULL,
  `expected_rent_to` decimal(10,2) DEFAULT NULL,
  `expected_deposit_from` decimal(10,2) DEFAULT NULL,
  `expected_deposit_to` decimal(10,2) DEFAULT NULL,
  `commercial_rent_from` decimal(10,2) NOT NULL,
  `commercial_rent_to` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `property_choose`, `property_type`, `created_at`, `bhk_type`, `expected_rent_from`, `expected_rent_to`, `expected_deposit_from`, `expected_deposit_to`, `commercial_rent_from`, `commercial_rent_to`) VALUES
(3, 'Commercial', 'Office Space', '2025-01-02 06:06:43', NULL, NULL, NULL, NULL, NULL, 50000.00, 100000.00),
(6, 'Commercial', 'Commercial', '2025-01-06 11:57:14', '', 0.00, 0.00, 0.00, 0.00, 8000.00, 90000.00),
(8, 'Commercial', 'Techpark Office Space', '2025-01-07 05:11:52', '', 0.00, 0.00, 0.00, 0.00, 50000.00, 100000.00),
(11, 'Rent', '', '2025-01-10 15:23:21', '1RK', 8000.00, 15000.00, 0.00, 0.00, 0.00, 0.00),
(12, 'Rent', '', '2025-01-10 15:23:39', '1BHK', 12000.00, 30000.00, 0.00, 0.00, 0.00, 0.00),
(13, 'Rent', '', '2025-01-10 15:24:21', '2BHK', 12000.00, 70000.00, 0.00, 0.00, 0.00, 0.00),
(14, 'Rent', '', '2025-01-10 15:24:39', '3BHK', 20000.00, 100000.00, 0.00, 0.00, 0.00, 0.00),
(15, 'Buy', 'FLAT', '2025-01-10 15:26:02', '', 0.00, 0.00, 400000.00, 30000000.00, 0.00, 0.00),
(16, 'Buy', 'STAND ALONE BUILDING', '2025-01-10 15:26:51', '', 0.00, 0.00, 10000000.00, 80000000.00, 0.00, 0.00),
(19, 'Buy', 'GATED APARTMENT', '2025-01-12 15:30:13', '', 0.00, 0.00, 5000000.00, 40000000.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `mobile`, `message`, `created_at`) VALUES
(1, 'demo', 'demo@gmail.com', '9873216540', 'ghfhghg  jhgff  jhv', '2024-12-17 10:57:30'),
(2, 'Abhijeet', 'abhijeet1997@gmail.com', '95388865407', 'Hello!', '2024-12-17 13:54:19'),
(3, 'NAEWTRER4157888NERTHRTYHR', 'davidlancaster2013@quieresmail.com', '87924219665', 'MEYJYTJY4157888MARETRYTR', '2024-12-18 04:57:27'),
(4, 'Georgewic', 'ibucezevuda439@gmail.com', '88535736315', 'Ciao, volevo sapere il tuo prezzo.', '2024-12-19 16:29:42'),
(5, 'JnSKiDHeeuN', 'qibuyibit58@gmail.com', '5856610683', '', '2024-12-19 21:51:33'),
(6, '', '', '', '', '2024-12-19 21:51:35'),
(7, 'xfOqtAHCUcp', 'qibuyibit58@gmail.com', '3478183585', '', '2024-12-19 21:51:48'),
(8, '', '', '', '', '2024-12-19 21:51:50'),
(9, 'Masonwic', 'ebojajuje04@gmail.com', '83132846691', 'Sveiki, aÅ¡ norÄ—jau suÅ¾inoti jÅ«sÅ³ kainÄ….', '2024-12-20 08:31:51'),
(10, 'Anubhuti Sharma', 'anubhuti.sharma141@gmail.com', '8058016342', '1bhk under 20k ', '2024-12-20 20:57:45'),
(11, 'DiMJEfVXuCqdxvq', 'ulocatimov50@gmail.com', '8868233512', '', '2024-12-20 20:59:22'),
(12, '', '', '', '', '2024-12-20 20:59:23'),
(13, 'uCAoyuZJVFpTQ', 'ulocatimov50@gmail.com', '9407459151', '', '2024-12-20 20:59:35'),
(14, '', '', '', '', '2024-12-20 20:59:36'),
(15, 'Robertwic', 'ixutikob077@gmail.com', '85414676625', 'ÕˆÕ²Õ»Õ¸Ö‚ÕµÕ¶, Õ¥Õ½ Õ¸Ö‚Õ¦Õ¸Ö‚Õ´ Õ§Õ« Õ«Õ´Õ¡Õ¶Õ¡Õ¬ Õ±Õ¥Ö€ Õ£Õ«Õ¶Õ¨.', '2024-12-21 21:13:13'),
(16, 'VigneshSiddharth ', 'vigneshsiddharthayyamuthu@gmail.com', '7200194094', 'I would like to move immediately. 1bhk hulimavu bannergata road', '2024-12-22 03:38:43'),
(17, 'VigneshSiddharth ', 'vigneshsiddharthayyamuthu@gmail.com', '7200194094', 'I would like to move immediately. 1bhk hulimavu bannergata road', '2024-12-22 03:38:44'),
(18, 'YvNbBmBUYWJxjp', 'zuvineru596@gmail.com', '4866017079', '', '2024-12-22 10:24:23'),
(19, '', '', '', '', '2024-12-22 10:24:25'),
(20, 'tBMSFbsbwmcU', 'zuvineru596@gmail.com', '4613336417', '', '2024-12-22 10:24:41'),
(21, '', '', '', '', '2024-12-22 10:24:43'),
(22, 'Harrywic', 'ibucezevuda439@gmail.com', '86132288939', 'Aloha, makemake wau eÊ»ike i kÄu kumukÅ«Ê»ai.', '2024-12-22 14:23:20'),
(23, 'jVXfhmKf', 'piiahdxbuuyh@yahoo.com', '4208592027', '', '2024-12-23 04:47:57'),
(24, '', '', '', '', '2024-12-23 04:47:59'),
(25, 'nZZqzsSWSzvl', 'piiahdxbuuyh@yahoo.com', '6468057781', '', '2024-12-23 04:48:09'),
(26, '', '', '', '', '2024-12-23 04:48:10'),
(27, 'Dime1968', 'dwightadair@gmail.com', '85325989222', 'The secret to business success: accurate contact data! Order now and see how it transforms your outreach. https://telegra.ph/Personalized-Contact-Data-Extraction-from-Google-Maps-10-03 (or telegram: @chamerion)', '2024-12-24 00:42:41'),
(28, 'bxqTguZiGtSYZYR', 'upemiqani837@gmail.com', '6857723364', '', '2024-12-24 05:56:12'),
(29, '', '', '', '', '2024-12-24 05:56:13'),
(30, 'JhGijJQbpEb', 'upemiqani837@gmail.com', '3044478967', '', '2024-12-24 05:56:20'),
(31, '', '', '', '', '2024-12-24 05:56:21'),
(32, 'Milind Dayal ', 'milinddayala6@gmail.com', '9546225816', '1bhk flat for bachelor under 12 to 13 k \r\nIn jaya nagar', '2024-12-25 09:54:27'),
(34, 'ZVfLdhgd', 'ucusavupis53@gmail.com', '4247537668', '', '2024-12-26 00:02:14'),
(35, '', '', '', '', '2024-12-26 00:02:16'),
(36, 'CRCVvDZRGmlaMsc', 'ucusavupis53@gmail.com', '2903390209', '', '2024-12-26 00:02:35'),
(37, '', '', '', '', '2024-12-26 00:02:37'),
(38, 'Faizan Ansari', 'kausar.sharba230@gmail.com', '9621064662', 'Kindly, send the flats near by HSR LAYOUT & BTM within the range of 15k. ', '2024-12-26 06:24:03'),
(39, 'Vivek Kumar ', 'vivek.epari@gmail.com', '8148844543', 'Interested for BTM, BENERGATHA ROAD, Hulimavu ', '2024-12-26 16:19:31'),
(40, 'UCrbScOOMxAgQ', 'zamoytaschaible@yahoo.com', '6101391572', '', '2024-12-29 16:01:37'),
(41, '', '', '', '', '2024-12-29 16:01:41'),
(42, 'cqfqrnyKEI', 'zamoytaschaible@yahoo.com', '5450827484', '', '2024-12-29 16:01:59'),
(43, '', '', '', '', '2024-12-29 16:02:00'),
(44, 'Tedwic', 'moqagides18@gmail.com', '84984843673', 'Hai, saya ingin tahu harga Anda.', '2024-12-29 17:35:31'),
(45, 'eMcUCFLWSwWKsPF', 'mqekwxpvguanx@yahoo.com', '7188813158', '', '2024-12-30 13:32:15'),
(46, '', '', '', '', '2024-12-30 13:32:16'),
(47, 'KXWHBJQHyI', 'mqekwxpvguanx@yahoo.com', '6821533870', '', '2024-12-30 13:32:29'),
(48, '', '', '', '', '2024-12-30 13:32:31'),
(49, 'HUxMDOVpaup', 'uhojajev12@gmail.com', '7677597405', '', '2025-01-01 21:06:51'),
(50, '', '', '', '', '2025-01-01 21:06:54'),
(51, 'HgPSCPybB', 'uhojajev12@gmail.com', '5939923928', '', '2025-01-01 21:07:11'),
(52, '', '', '', '', '2025-01-01 21:07:12'),
(53, 'Isha ', 'ishavishal8@gmail.com', '9585918181', 'I want to visit property ', '2025-01-02 09:41:05'),
(54, 'Priyanka', 'priyankapaneri@gmail.com', '9462192089', 'Looking for rent 1bhk for family in Jayanagar, Jp nagar ', '2025-01-02 16:13:27'),
(55, 'WwWLkcPSjvn', 'jojinazojeze25@gmail.com', '6051386990', '', '2025-01-03 11:52:24'),
(56, '', '', '', '', '2025-01-03 11:52:26'),
(57, 'hFJXkmNpH', 'jojinazojeze25@gmail.com', '6365471722', '', '2025-01-03 11:52:41'),
(58, '', '', '', '', '2025-01-03 11:52:42'),
(59, 'nDAFRuajRJMoB', 'ucasasoku917@gmail.com', '3967221727', '', '2025-01-04 11:33:52'),
(60, '', '', '', '', '2025-01-04 11:33:53'),
(61, 'FAEmyirGXXp', 'ucasasoku917@gmail.com', '2271424657', '', '2025-01-04 11:34:11'),
(62, '', '', '', '', '2025-01-04 11:34:12'),
(63, 'BYOfCuVEhlmPt', 'cstdt8wdohlif@yahoo.com', '9466838160', '', '2025-01-06 19:06:13'),
(64, '', '', '', '', '2025-01-06 19:06:15'),
(65, 'VtaFJshhDybT', 'cstdt8wdohlif@yahoo.com', '6752044483', '', '2025-01-06 19:06:24'),
(67, 'Anamika', 'admin@gmail.com', '6361793287', 'hello', '2025-01-07 05:18:51'),
(68, 'Aditya', 'adityasrinivas4@gmail.com', '8099991600', 'Looking for a 1BHK in HSR ', '2025-01-07 11:30:45'),
(69, 'gewuGXXas', 'migereviguma12@gmail.com', '4259806457', '', '2025-01-07 21:40:30'),
(70, '', '', '', '', '2025-01-07 21:40:30'),
(71, 'yyZjKNszxbBc', 'migereviguma12@gmail.com', '6965823895', '', '2025-01-07 21:40:42'),
(72, '', '', '', '', '2025-01-07 21:40:43'),
(73, 'Shaoni Ghosh', 'shaonighosh1990@gmail.com', '9871393302', 'Interested in the property ', '2025-01-08 13:34:28'),
(74, 'kyvVektTGWGNlzB', 'dyfleffxhppx0o@yahoo.com', '9934626526', '', '2025-01-09 02:43:51'),
(75, '', '', '', '', '2025-01-09 02:43:52'),
(76, 'hAtzTYCNjX', 'dyfleffxhppx0o@yahoo.com', '2873539486', '', '2025-01-09 02:44:06'),
(77, '', '', '', '', '2025-01-09 02:44:07'),
(78, 'Ashwita', 'askonnur16@gmail.com', '7829632436', 'Want to visit the property today ', '2025-01-09 07:49:56'),
(79, 'btCtteuyHx', 'fiodwwdwo@yahoo.com', '8625850915', '', '2025-01-10 02:22:25'),
(80, '', '', '', '', '2025-01-10 02:22:26'),
(81, 'yaadaCznsNgilHD', 'fiodwwdwo@yahoo.com', '8209740528', '', '2025-01-10 02:22:38'),
(82, '', '', '', '', '2025-01-10 02:22:39'),
(83, 'Mezan Shariff', 'mezan.shariff786@gmail.com', '9964112146', 'I would like to deposit upto 10 lakhs and i want the rent to be less per month ', '2025-01-10 05:57:14'),
(84, 'Ruchi Vishwakarma', 'ruchivish0208@gmail.com', '8269252036', 'Please share all the available 2BHK properties for family', '2025-01-10 16:42:08'),
(85, 'Kevin Sequeira', 'kevinanthony98@gmail.com', '9900867033', 'Looking for flat within 15k', '2025-01-10 18:43:12'),
(86, 'hfLpBUuEAbBrCNW', 'dxnsjajvoh6t6b7@yahoo.com', '6684168601', '', '2025-01-11 00:26:38'),
(87, '', '', '', '', '2025-01-11 00:26:40'),
(88, 'aocaRdLQZGEYD', 'dxnsjajvoh6t6b7@yahoo.com', '6408823335', '', '2025-01-11 00:26:53'),
(89, '', '', '', '', '2025-01-11 00:26:55'),
(90, '', '', '', '', '2025-01-11 22:35:20'),
(91, 'Madhurima Dutta', 'madhurimad09@gmail.com', '8787375549', 'Would like to know if the rent is negotiable and if there is a power backup. Also, is it in a standalone building or gated society?', '2025-01-12 12:01:17'),
(92, 'Robertwic', 'ixutikob077@gmail.com', '81414984137', 'HÃ¦, Ã©g vildi vita verÃ° Ã¾itt.', '2025-01-12 20:00:39'),
(93, '', '', '', '', '2025-01-13 00:19:40'),
(94, 'nJYOzPQWTVHc', 'hodoxeyobi47@gmail.com', '5644086516', '', '2025-01-13 00:19:53'),
(95, '', '', '', '', '2025-01-13 00:19:55'),
(96, 'Akarsha Punnakkal', 'akarsha.punnakkal@gmail.com', '8075784719', 'Please let me know on availability ', '2025-01-13 09:31:36'),
(97, 'UnjumnSem', '31nc4a8s@gmail.com', '87478572224', 'Your account has been inactive for 364 days. To prevent removal and claim your balance, please log in and initiate a payout within 24 hours. For assistance, visit our Telegram group: https://tinyurl.com/233dmcxn', '2025-01-13 16:23:40'),
(98, 'zJicdJyLfahMbAO', 'timariusipov@yahoo.com', '6658833025', '', '2025-01-14 09:26:06'),
(99, '', '', '', '', '2025-01-14 09:26:07'),
(100, 'aaetUsPhYqonhg', 'timariusipov@yahoo.com', '2616934605', '', '2025-01-14 09:26:14'),
(101, '', '', '', '', '2025-01-14 09:26:14'),
(102, 'UnjumnSem', 'a75u86j1@icloud.com', '84564934214', 'Your account has been inactive for 364 days. To stop deletion and claim your balance, please access your account and initiate a withdrawal within 24 hours. For assistance, join our Telegram group: https://tinyurl.com/2yseqb2a', '2025-01-15 16:44:15'),
(103, 'LHnMmiNHRNUor', 'gossameroemirage18@gmail.com', '9195565677', '', '2025-01-16 03:47:28'),
(104, 'xKCcaMAYgEEC', 'gossameroemirage18@gmail.com', '8277276057', '', '2025-01-16 03:47:45'),
(105, 'Robertwic', 'ixutikob077@gmail.com', '89477418765', 'Dia duit, theastaigh uaim do phraghas a fhÃ¡il.', '2025-01-16 05:26:06'),
(106, 'Priyanka Kumari', 'priyanka15sai@gmail.com', '7978504039', 'Kindly help me finding 2 bhk in BTM layout 2nd stage', '2025-01-17 03:38:33'),
(107, 'MthSzwbhUOJVZOH', 'aiduskea71brink@gmail.com', '9305023481', '', '2025-01-17 08:19:15'),
(108, '', '', '', '', '2025-01-17 08:19:17'),
(109, 'iOEQZdqFRnNLB', 'aiduskea71brink@gmail.com', '6189044321', '', '2025-01-17 08:19:35'),
(110, '', '', '', '', '2025-01-17 08:19:37'),
(111, 'Nikita', 'nikita.kharb2003@gmail.com', '8168330983', '2bhk fully furnished budget:28k , location jayanagar jo nagar kormangala', '2025-01-17 20:12:33'),
(112, 'gigGSQpNqnM', 'ebikidayolo42@gmail.com', '4986696451', '', '2025-01-18 11:45:19'),
(113, '', '', '', '', '2025-01-18 11:45:20'),
(114, 'vgewsDPrs', 'ebikidayolo42@gmail.com', '6373712987', '', '2025-01-18 11:45:27'),
(115, '', '', '', '', '2025-01-18 11:45:28'),
(116, 'Kaushik', 'kaushikj914@gmail.com', '7022276794', 'Need 2BHK, Budget - Max 30k, Fully or semi-furnished, Locality - Kormangala ', '2025-01-18 15:24:15'),
(117, 'Vishali', 'vishaliramesh1509@gmail.com', '9840809639', 'Looking for a 2bhk flat with 1 private room rent budget 15k in hsr layout/koramangala.', '2025-01-19 06:23:03'),
(118, 'PjJDjKFe', 'drafbyhqbra@yahoo.com', '6118103737', '', '2025-01-20 05:56:29'),
(119, '', '', '', '', '2025-01-20 05:56:29'),
(120, 'MYKAylTr', 'drafbyhqbra@yahoo.com', '2340473050', '', '2025-01-20 05:56:38'),
(121, '', '', '', '', '2025-01-20 05:56:38'),
(122, 'Gabriel Charles ', 'gonepogugabriel@gmail.com', '8897958808', 'My requirements \r\n1. Single\r\n2. Rent\r\n3. 1/2bhk\r\n4. Semi/Full \r\n5. Koramangala, HSR layout, Hebbal, and surrounding \r\n6. Bachelor \r\n7. 15-25k\r\n8. Shifting at End of Jan/1st week Feb', '2025-01-21 08:40:59'),
(123, 'UnjumnSem', '8o540iwv@yahoo.com', '86614496714', 'Your account has been dormant for 364 days. To stop deletion and retrieve your funds, please access your account and initiate a payout within 24 hours. For assistance, visit our Telegram group: https://tinyurl.com/2y2549ng', '2025-01-21 08:58:05'),
(124, 'Shrutji', 'shruthi.smg@gmail.com', '9844195774', 'Pent house', '2025-01-21 10:16:19'),
(125, 'ztRzdDaxW', 'Josie1Holland1346@gmail.com', '6211835329', '', '2025-01-23 04:20:33'),
(126, '', '', '', '', '2025-01-23 04:20:35'),
(127, 'NgjPBNSlmp', 'Josie1Holland1346@gmail.com', '8577111671', '', '2025-01-23 04:20:53'),
(128, '', '', '', '', '2025-01-23 04:20:55'),
(129, 'Georgewic', 'ibucezevuda439@gmail.com', '81692335134', 'Hai, saya ingin tahu harga Anda.', '2025-01-23 12:45:45'),
(130, 'Arya', 'arya.aishwarya09@gmail.com', '7033481011', 'Please contact me back . I am interested ', '2025-01-23 18:35:08'),
(131, 'Mahfuz', 'mshark048@gmail.com', '9916043004', 'I want a 1bhk within 12k max budget\r\nNear hulimavu', '2025-01-24 02:43:04'),
(132, 'Akshay ', 'prinakshay@gmail.com', '8105190335', 'Looking for 2bhk rent ', '2025-01-24 06:38:53'),
(133, 'VZmzIqQMILLXMea', 'pekvxldyjb8grqpw@yahoo.com', '3824945647', '', '2025-01-26 05:21:00'),
(134, '', '', '', '', '2025-01-26 05:21:02'),
(135, 'ZTGpaqPcfLes', 'pekvxldyjb8grqpw@yahoo.com', '9313971602', '', '2025-01-26 05:21:17'),
(136, '', '', '', '', '2025-01-26 05:21:18'),
(137, 'ZAbFoAGJIqidW', 'q4pgapcsjl@yahoo.com', '2518419101', '', '2025-01-28 01:35:26'),
(138, '', '', '', '', '2025-01-28 01:35:28'),
(139, 'AOoUuhFbHlO', 'q4pgapcsjl@yahoo.com', '9945337790', '', '2025-01-28 01:35:48'),
(140, '', '', '', '', '2025-01-28 01:35:50'),
(141, 'jaffar', 'jaffar8055@gmail.com', '8123707783', 'new ', '2025-01-28 14:33:06'),
(142, 'Sachin H', 'sachinhunashyal8836@gmail.com', '8105645552', '10k budget \r\nFamily \r\nBtm', '2025-01-29 04:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `contacted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(50) DEFAULT NULL,
  `country_code` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `country_code`, `city`) VALUES
(0, 'India', 'IN', 'New Delhi'),
(1, 'Philippines', 'PH', 'San Nicolas'),
(2, 'China', 'CN', 'Lainqu'),
(3, 'Ireland', 'IE', 'Raheny'),
(4, 'Colombia', 'CO', 'Paicol'),
(5, 'Jamaica', 'JM', 'Lluidas Vale'),
(6, 'Tanzania', 'TZ', 'Mtwango'),
(7, 'France', 'FR', 'Arles'),
(8, 'Indonesia', 'ID', 'Sawangan'),
(9, 'Spain', 'ES', 'Murcia'),
(10, 'Brazil', 'BR', 'Ribeira do Pombal'),
(11, 'Moldova', 'MD', 'Ciorescu'),
(12, 'France', 'FR', 'Le Mans'),
(13, 'Russia', 'RU', 'Novyy Nekouz'),
(14, 'Indonesia', 'ID', 'Sarimukti Kaler'),
(15, 'Indonesia', 'ID', 'Suwalan'),
(16, 'Cuba', 'CU', 'Maisí'),
(17, 'Indonesia', 'ID', 'Pulosari'),
(18, 'Indonesia', 'ID', 'Banjarejo'),
(19, 'Japan', 'JP', 'Obama'),
(20, 'Indonesia', 'ID', 'Tekikbanyuurip'),
(21, 'Czech Republic', 'CZ', 'Veselí nad Lužnicí'),
(22, 'China', 'CN', 'Kanbula'),
(23, 'Portugal', 'PT', 'Paços de Ferreira'),
(24, 'Japan', 'JP', 'Kukichūō'),
(25, 'Egypt', 'EG', 'Qalyūb'),
(26, 'Netherlands', 'NL', 'Almelo'),
(27, 'Portugal', 'PT', 'Venda do Alcaide'),
(28, 'Iran', 'IR', 'Bastak'),
(29, 'Peru', 'PE', 'Aquia'),
(30, 'Brazil', 'BR', 'Ribeirão Preto'),
(31, 'China', 'CN', 'Taihu'),
(32, 'Armenia', 'AM', 'Spitak'),
(33, 'Nigeria', 'NG', 'Gakem'),
(34, 'Ecuador', 'EC', 'Piñas'),
(35, 'China', 'CN', 'Macun'),
(36, 'Philippines', 'PH', 'Parabcan'),
(37, 'Japan', 'JP', 'Naka'),
(38, 'China', 'CN', 'Huarong Chengguanzhen'),
(39, 'United States', 'US', 'Rockford'),
(40, 'China', 'CN', 'Jiaozuo'),
(41, 'Vietnam', 'VN', 'Thị Trấn Phú Mỹ'),
(42, 'China', 'CN', 'Haizhouwobao'),
(43, 'China', 'CN', 'Dongchuan'),
(44, 'China', 'CN', 'Xiayunling'),
(45, 'South Korea', 'KR', 'Heung-hai'),
(46, 'Sweden', 'SE', 'Åmål'),
(47, 'Albania', 'AL', 'Mamurras'),
(48, 'Ecuador', 'EC', 'Loja'),
(49, 'Czech Republic', 'CZ', 'Raškovice'),
(50, 'Brazil', 'BR', 'São Leopoldo'),
(51, 'Indonesia', 'ID', 'Kliwon Cibingbin'),
(52, 'Uzbekistan', 'UZ', 'To’rtko’l Shahri'),
(53, 'Indonesia', 'ID', 'Kotabaru'),
(54, 'Jordan', 'JO', 'Aţ Ţafīlah'),
(55, 'Thailand', 'TH', 'Lom Sak'),
(56, 'Bolivia', 'BO', 'Azurduy'),
(57, 'North Korea', 'KP', 'Hyesan-dong'),
(58, 'Mongolia', 'MN', 'Bayanhoshuu'),
(59, 'Indonesia', 'ID', 'Kalisabuk'),
(60, 'New Zealand', 'NZ', 'Whakatane'),
(61, 'Netherlands', 'NL', 'Eindhoven'),
(62, 'Sweden', 'SE', 'Borås'),
(63, 'China', 'CN', 'Guantouzui'),
(64, 'Poland', 'PL', 'Tarnowskie Góry'),
(65, 'Brazil', 'BR', 'Boituva'),
(66, 'Dominica', 'DM', 'Calibishie'),
(67, 'Albania', 'AL', 'Lis'),
(68, 'Bulgaria', 'BG', 'Boychinovtsi'),
(69, 'China', 'CN', 'Haishan'),
(70, 'Slovenia', 'SI', 'Razvanje'),
(71, 'Uzbekistan', 'UZ', 'Qo‘qon'),
(72, 'Greece', 'GR', 'Álimos'),
(73, 'Indonesia', 'ID', 'Kaca'),
(74, 'Indonesia', 'ID', 'Dodu Dua'),
(75, 'Portugal', 'PT', 'Quintela'),
(76, 'China', 'CN', 'Tianyu'),
(77, 'Sweden', 'SE', 'Kristianstad'),
(78, 'Philippines', 'PH', 'Maayong Tubig'),
(79, 'China', 'CN', 'Shanjie'),
(80, 'Philippines', 'PH', 'Montaneza'),
(81, 'Yemen', 'YE', 'Al Madīd'),
(82, 'Philippines', 'PH', 'Calauag'),
(83, 'Colombia', 'CO', 'Heliconia'),
(84, 'Indonesia', 'ID', 'Pandanwangi'),
(85, 'China', 'CN', 'Shuangpu'),
(86, 'Russia', 'RU', 'Vinsady'),
(87, 'France', 'FR', 'Montpellier'),
(88, 'Russia', 'RU', 'Kashin'),
(89, 'Russia', 'RU', 'Yukhnov'),
(90, 'China', 'CN', 'Jiaobei'),
(91, 'China', 'CN', 'Xiaohe'),
(92, 'Canada', 'CA', 'Taber'),
(93, 'Argentina', 'AR', 'Aristóbulo del Valle'),
(94, 'China', 'CN', 'Hengqu'),
(95, 'Burkina Faso', 'BF', 'Dédougou'),
(96, 'Mayotte', 'YT', 'Dembeni'),
(97, 'China', 'CN', 'Dengfeng'),
(98, 'Canada', 'CA', 'Whitehorse'),
(99, 'Reunion', 'RE', 'Saint-Denis'),
(100, 'Brazil', 'BR', 'Tubarão'),
(101, 'China', 'CN', 'Daping'),
(102, 'China', 'CN', 'Wangcun'),
(103, 'Russia', 'RU', 'Isheyevka'),
(104, 'China', 'CN', 'Mashizhai'),
(105, 'Philippines', 'PH', 'Ramon Magsaysay'),
(106, 'Nigeria', 'NG', 'Katagum'),
(107, 'China', 'CN', 'Maying'),
(108, 'Philippines', 'PH', 'Burgos'),
(109, 'Philippines', 'PH', 'Marsada'),
(110, 'Indonesia', 'ID', 'Blawi'),
(111, 'China', 'CN', 'Songyuan'),
(112, 'China', 'CN', 'Qiaotou'),
(113, 'United States', 'US', 'Pasadena'),
(114, 'Ecuador', 'EC', 'Celica'),
(115, 'China', 'CN', 'Jiangqiao'),
(116, 'Brazil', 'BR', 'Três Lagoas'),
(117, 'Panama', 'PA', 'El Coco'),
(118, 'Finland', 'FI', 'Hankasalmi'),
(119, 'United States', 'US', 'Nashville'),
(120, 'Russia', 'RU', 'Yalkhoy-Mokhk'),
(121, 'China', 'CN', 'Nanjing'),
(122, 'Sweden', 'SE', 'Trosa'),
(123, 'Germany', 'DE', 'Cottbus'),
(124, 'Brazil', 'BR', 'Cândido Mota'),
(125, 'China', 'CN', 'Heping'),
(126, 'Thailand', 'TH', 'Kosamphi Nakhon'),
(127, 'Russia', 'RU', 'Blagoveshchenka'),
(128, 'Nepal', 'NP', 'Nawal'),
(129, 'Philippines', 'PH', 'Caramay'),
(130, 'Indonesia', 'ID', 'Cikole'),
(131, 'Canada', 'CA', 'Nanton'),
(132, 'Indonesia', 'ID', 'Panyuran'),
(133, 'Indonesia', 'ID', 'Ceper'),
(134, 'Philippines', 'PH', 'Doong'),
(135, 'China', 'CN', 'Dalai'),
(136, 'China', 'CN', 'Daduchuan'),
(137, 'Chad', 'TD', 'Bitkine'),
(138, 'Indonesia', 'ID', 'Kampungbajo'),
(139, 'Philippines', 'PH', 'Biga'),
(140, 'Indonesia', 'ID', 'Paloh'),
(141, 'Indonesia', 'ID', 'Harjamukti'),
(142, 'Serbia', 'RS', 'Tršić'),
(143, 'Russia', 'RU', 'Volgodonsk'),
(144, 'Czech Republic', 'CZ', 'Horní Stropnice'),
(145, 'Poland', 'PL', 'Szczawno-Zdrój'),
(146, 'United States', 'US', 'San Diego'),
(147, 'Portugal', 'PT', 'Ribaldeira'),
(148, 'South Korea', 'KR', 'Icheon-si'),
(149, 'Czech Republic', 'CZ', 'Stochov'),
(150, 'Azerbaijan', 'AZ', 'Barda'),
(151, 'Philippines', 'PH', 'Latung'),
(152, 'United States', 'US', 'Lansing'),
(153, 'Iran', 'IR', 'Nūr'),
(154, 'Russia', 'RU', 'Gusev'),
(155, 'Bosnia and Herzegovina', 'BA', 'Ilići'),
(156, 'China', 'CN', 'Longmenfan'),
(157, 'Bosnia and Herzegovina', 'BA', 'Obudovac'),
(158, 'China', 'CN', 'Xinqiao'),
(159, 'China', 'CN', 'Yong’an'),
(160, 'China', 'CN', 'Songjiang'),
(161, 'Indonesia', 'ID', 'Cibangban Girang'),
(162, 'Brazil', 'BR', 'Pedra Branca'),
(163, 'Philippines', 'PH', 'Balingasag'),
(164, 'Thailand', 'TH', 'Nong Yai'),
(165, 'Philippines', 'PH', 'Sultan Kudarat'),
(166, 'Russia', 'RU', 'Vol’nyy Aul'),
(167, 'China', 'CN', 'Yangdenghu'),
(168, 'Brazil', 'BR', 'Boquira'),
(169, 'China', 'CN', 'Wuguishan'),
(170, 'Maldives', 'MV', 'Viligili'),
(171, 'China', 'CN', 'Lianjiangkou'),
(172, 'Botswana', 'BW', 'Mahalapye'),
(173, 'Brazil', 'BR', 'Piquete'),
(174, 'Portugal', 'PT', 'Pedreira'),
(175, 'Bosnia and Herzegovina', 'BA', 'Potoci'),
(176, 'Spain', 'ES', 'Pamplona/Iruña'),
(177, 'Syria', 'SY', '‘Afrīn'),
(178, 'Philippines', 'PH', 'Balingasag'),
(179, 'Mexico', 'MX', 'La Guadalupe'),
(180, 'Greece', 'GR', 'Examília'),
(181, 'China', 'CN', 'Taihu'),
(182, 'Brazil', 'BR', 'Iporã'),
(183, 'Norway', 'NO', 'Bergen'),
(184, 'Ukraine', 'UA', 'Tsibulev'),
(185, 'China', 'CN', 'Huanghuai'),
(186, 'China', 'CN', 'Pinghu'),
(187, 'Mexico', 'MX', 'Magisterial'),
(188, 'Brazil', 'BR', 'Jatobá'),
(189, 'Portugal', 'PT', 'Figueiras'),
(190, 'China', 'CN', 'Qingduizi'),
(191, 'Greece', 'GR', 'Néa Karyá'),
(192, 'Russia', 'RU', 'Novogornyy'),
(193, 'Greece', 'GR', 'Mégara'),
(194, 'Brazil', 'BR', 'Propriá'),
(195, 'Israel', 'IL', 'Giv\'on HaHadasha'),
(196, 'Afghanistan', 'AF', 'Farah'),
(197, 'Serbia', 'RS', 'Adorjan'),
(198, 'Netherlands', 'NL', 'Amsterdam Nieuw West'),
(199, 'Croatia', 'HR', 'Garešnica'),
(200, 'Colombia', 'CO', 'Túquerres'),
(201, 'China', 'CN', 'Luci'),
(202, 'China', 'CN', 'Taohua'),
(203, 'Poland', 'PL', 'Suwałki'),
(204, 'Brazil', 'BR', 'Limoeiro'),
(205, 'China', 'CN', 'Nu’erbage'),
(206, 'Greece', 'GR', 'Vlycháda'),
(207, 'Afghanistan', 'AF', 'Qarchī Gak'),
(208, 'Japan', 'JP', 'Izumi'),
(209, 'France', 'FR', 'Paris 15'),
(210, 'Portugal', 'PT', 'São Bartolomeu'),
(211, 'Azerbaijan', 'AZ', 'Shamkhor'),
(212, 'Ukraine', 'UA', 'Truskavets'),
(213, 'France', 'FR', 'Alençon'),
(214, 'Palestinian Territory', 'PS', 'Ḩuwwārah'),
(215, 'Tunisia', 'TN', 'Al ‘Āliyah'),
(216, 'France', 'FR', 'Suresnes'),
(217, 'Honduras', 'HN', 'San Luis'),
(218, 'Ukraine', 'UA', 'Lazeshchyna'),
(219, 'Zimbabwe', 'ZW', 'Mazowe'),
(220, 'Sweden', 'SE', 'Jönköping'),
(221, 'Russia', 'RU', 'Vinsady'),
(222, 'Portugal', 'PT', 'Gondifelos'),
(223, 'China', 'CN', 'Zhujiaqiao'),
(224, 'Nigeria', 'NG', 'Abakaliki'),
(225, 'Japan', 'JP', 'Nakatsugawa'),
(226, 'Brazil', 'BR', 'Crato'),
(227, 'Russia', 'RU', 'Dugulubgey'),
(228, 'China', 'CN', 'Yangjiaqiao'),
(229, 'Colombia', 'CO', 'Nariño'),
(230, 'China', 'CN', 'Jiudu'),
(231, 'Portugal', 'PT', 'Souto de Cima'),
(232, 'China', 'CN', 'Taihe'),
(233, 'United States', 'US', 'Pasadena'),
(234, 'Russia', 'RU', 'Kabakovo'),
(235, 'China', 'CN', 'Quchi'),
(236, 'Sweden', 'SE', 'Åkersberga'),
(237, 'Colombia', 'CO', 'Campo de la Cruz'),
(238, 'Netherlands', 'NL', 'Maastricht'),
(239, 'Greece', 'GR', 'Rízoma'),
(240, 'Peru', 'PE', 'Mollebamba'),
(241, 'Mexico', 'MX', 'San Lorenzo'),
(242, 'Peru', 'PE', 'Andahuaylas'),
(243, 'Canada', 'CA', 'Crossfield'),
(244, 'United States', 'US', 'Louisville'),
(245, 'France', 'FR', 'Le Mans'),
(246, 'France', 'FR', 'Saint-Maur-des-Fossés'),
(247, 'Uzbekistan', 'UZ', 'Toshbuloq'),
(248, 'United States', 'US', 'Denver'),
(249, 'China', 'CN', 'Jiekeng'),
(250, 'Cameroon', 'CM', 'Somié'),
(251, 'Norway', 'NO', 'Oslo'),
(252, 'Indonesia', 'ID', 'Suwaduk'),
(253, 'Philippines', 'PH', 'Sitangkai'),
(254, 'Brazil', 'BR', 'Ibaté'),
(255, 'Poland', 'PL', 'Przystajń'),
(256, 'Japan', 'JP', 'Ikedachō'),
(257, 'Portugal', 'PT', 'Várzea da Serra'),
(258, 'Indonesia', 'ID', 'Kombapari'),
(259, 'Philippines', 'PH', 'Santa Paz'),
(260, 'China', 'CN', 'Haicheng'),
(261, 'Philippines', 'PH', 'Sambuluan'),
(262, 'Indonesia', 'ID', 'Kadukandel'),
(263, 'Sweden', 'SE', 'Kalix'),
(264, 'Uzbekistan', 'UZ', 'Bektemir'),
(265, 'Russia', 'RU', 'Tomsk'),
(266, 'China', 'CN', 'Qiaozhuang'),
(267, 'Russia', 'RU', 'Verkhniy Baskunchak'),
(268, 'China', 'CN', 'Guangping'),
(269, 'Greece', 'GR', 'Évlalo'),
(270, 'Malaysia', 'MY', 'Putrajaya'),
(271, 'Germany', 'DE', 'Bielefeld'),
(272, 'Russia', 'RU', 'Nezlobnaya'),
(273, 'China', 'CN', 'Xin Bulag'),
(274, 'China', 'CN', 'Shifan'),
(275, 'Sweden', 'SE', 'Kalmar'),
(276, 'Portugal', 'PT', 'Cabeças Verdes'),
(277, 'China', 'CN', 'Gaohe'),
(278, 'Russia', 'RU', 'Egvekinot'),
(279, 'Maldives', 'MV', 'Fonadhoo'),
(280, 'Mexico', 'MX', 'El Refugio'),
(281, 'China', 'CN', 'Lianhe'),
(282, 'Philippines', 'PH', 'Salvacion'),
(283, 'Palestinian Territory', 'PS', 'Jifnā'),
(284, 'Ethiopia', 'ET', 'Turmi'),
(285, 'Indonesia', 'ID', 'Poli'),
(286, 'French Polynesia', 'PF', 'Otutara'),
(287, 'Kazakhstan', 'KZ', 'Ekibastuz'),
(288, 'Indonesia', 'ID', 'Banjar Dauhmargi'),
(289, 'China', 'CN', 'Zhangpu'),
(290, 'Portugal', 'PT', 'Vila Chã'),
(291, 'Poland', 'PL', 'Bardo'),
(292, 'China', 'CN', 'Dajin'),
(293, 'Indonesia', 'ID', 'Wuluhan'),
(294, 'Peru', 'PE', 'Tantamayo'),
(295, 'Belarus', 'BY', 'Lyozna'),
(296, 'China', 'CN', 'Jiamachi'),
(297, 'Bolivia', 'BO', 'Eucaliptus'),
(298, 'Japan', 'JP', 'Kitaibaraki'),
(299, 'Mexico', 'MX', 'Luis Donaldo Colosio'),
(300, 'Tunisia', 'TN', 'La Mohammedia'),
(301, 'Brazil', 'BR', 'Cordeirópolis'),
(302, 'Brazil', 'BR', 'Sarzedo'),
(303, 'China', 'CN', 'Jianggezhuang'),
(304, 'Uruguay', 'UY', 'Florencio Sánchez'),
(305, 'Japan', 'JP', 'Shimabara'),
(306, 'Suriname', 'SR', 'Albina'),
(307, 'Japan', 'JP', 'Hashimoto'),
(308, 'China', 'CN', 'Weiting'),
(309, 'China', 'CN', 'Jincheng'),
(310, 'China', 'CN', 'Shangyuan'),
(311, 'Brazil', 'BR', 'Águas Formosas'),
(312, 'Indonesia', 'ID', 'Jawa'),
(313, 'China', 'CN', 'Yeshan'),
(314, 'China', 'CN', 'Dengfang'),
(315, 'United States', 'US', 'Sioux Falls'),
(316, 'Afghanistan', 'AF', 'Qarqīn'),
(317, 'Thailand', 'TH', 'Pa Mok'),
(318, 'France', 'FR', 'Chaumont'),
(319, 'Brazil', 'BR', 'Pirassununga'),
(320, 'Czech Republic', 'CZ', 'Stráž nad Nisou'),
(321, 'Poland', 'PL', 'Stanisław Dolny'),
(322, 'Ireland', 'IE', 'Blarney'),
(323, 'China', 'CN', 'Taoyuan'),
(324, 'China', 'CN', 'Daliuhao'),
(325, 'Indonesia', 'ID', 'Jagabaya Dua'),
(326, 'Brazil', 'BR', 'Paraíso'),
(327, 'France', 'FR', 'Niort'),
(328, 'Portugal', 'PT', 'Lameira'),
(329, 'Peru', 'PE', 'Mendoza'),
(330, 'Japan', 'JP', 'Kokubunji'),
(331, 'China', 'CN', 'Xiangba'),
(332, 'United States', 'US', 'Marietta'),
(333, 'Albania', 'AL', 'Bulqizë'),
(334, 'Philippines', 'PH', 'Tranca'),
(335, 'Czech Republic', 'CZ', 'Luhačovice'),
(336, 'South Korea', 'KR', 'Seongnam-si'),
(337, 'China', 'CN', 'Zhongshan'),
(338, 'Sweden', 'SE', 'Alingsås'),
(339, 'China', 'CN', 'Jiazhuang'),
(340, 'Cambodia', 'KH', 'Lumphăt'),
(341, 'Indonesia', 'ID', 'Soko'),
(342, 'Portugal', 'PT', 'Choca do Mar'),
(343, 'Portugal', 'PT', 'Vila Velha de Ródão'),
(344, 'Russia', 'RU', 'Uvarovo'),
(345, 'Serbia', 'RS', 'Debeljača'),
(346, 'Dominican Republic', 'DO', 'Oviedo'),
(347, 'Thailand', 'TH', 'Rasi Salai'),
(348, 'Colombia', 'CO', 'La Unión'),
(349, 'Indonesia', 'ID', 'Glondong'),
(350, 'Bangladesh', 'BD', 'Mehendiganj'),
(351, 'Slovenia', 'SI', 'Vrtojba'),
(352, 'Iran', 'IR', 'Arāk'),
(353, 'Philippines', 'PH', 'Naili'),
(354, 'China', 'CN', 'Machikou'),
(355, 'Cameroon', 'CM', 'Ngou'),
(356, 'Albania', 'AL', 'Vlorë'),
(357, 'Poland', 'PL', 'Pępowo'),
(358, 'China', 'CN', 'Jincheng'),
(359, 'Portugal', 'PT', 'Cruzeiro'),
(360, 'Russia', 'RU', 'Znamenskoye'),
(361, 'Indonesia', 'ID', 'Sitularang Landeuh'),
(362, 'Thailand', 'TH', 'Nong Bua Daeng'),
(363, 'Canada', 'CA', 'Armstrong'),
(364, 'Japan', 'JP', 'Shimonoseki'),
(365, 'United States', 'US', 'Shawnee Mission'),
(366, 'Russia', 'RU', 'Nizhniy Kurkuzhin'),
(367, 'France', 'FR', 'Locminé'),
(368, 'Iran', 'IR', 'Gālīkesh'),
(369, 'Philippines', 'PH', 'Pulong Sampalok'),
(370, 'Uzbekistan', 'UZ', 'Bulung’ur'),
(371, 'Croatia', 'HR', 'Hodošan'),
(372, 'Indonesia', 'ID', 'Matumadua'),
(373, 'Brazil', 'BR', 'Conselheiro Lafaiete'),
(374, 'Argentina', 'AR', 'Caseros'),
(375, 'Portugal', 'PT', 'Mosteiros'),
(376, 'China', 'CN', 'Jianping'),
(377, 'Indonesia', 'ID', 'Krajan Satu'),
(378, 'China', 'CN', 'Dalubian'),
(379, 'China', 'CN', 'Hualong'),
(380, 'Czech Republic', 'CZ', 'Žihle'),
(381, 'Indonesia', 'ID', 'Sinabang'),
(382, 'Moldova', 'MD', 'Chişinău'),
(383, 'Japan', 'JP', 'Toyota'),
(384, 'China', 'CN', 'Checun'),
(385, 'Brazil', 'BR', 'Tatuí'),
(386, 'Brazil', 'BR', 'Barra do Bugres'),
(387, 'Canada', 'CA', 'Lamont'),
(388, 'Sweden', 'SE', 'Umeå'),
(389, 'Portugal', 'PT', 'Pereiro'),
(390, 'Poland', 'PL', 'Piła'),
(391, 'Palestinian Territory', 'PS', 'Far‘ūn'),
(392, 'Philippines', 'PH', 'Mabayo'),
(393, 'Venezuela', 'VE', 'El Dividive'),
(394, 'United States', 'US', 'Greensboro'),
(395, 'Albania', 'AL', 'Lunik'),
(396, 'China', 'CN', 'Bajiazi'),
(397, 'Japan', 'JP', 'Oyabe'),
(398, 'China', 'CN', 'Shanxiahu'),
(399, 'Poland', 'PL', 'Sosnowiec'),
(400, 'Portugal', 'PT', 'Santa Maria do Souto'),
(401, 'Indonesia', 'ID', 'Palumbungan'),
(402, 'Philippines', 'PH', 'President Roxas'),
(403, 'China', 'CN', 'Bor Ondor'),
(404, 'Greece', 'GR', 'Vágia'),
(405, 'Serbia', 'RS', 'Pančevo'),
(406, 'Indonesia', 'ID', 'Tasikona'),
(407, 'Nigeria', 'NG', 'Kwatarkwashi'),
(408, 'Mexico', 'MX', 'Adolfo Ruiz Cortines'),
(409, 'Russia', 'RU', 'Sysert’'),
(410, 'Canada', 'CA', 'St. Thomas'),
(411, 'Ukraine', 'UA', 'Polonne'),
(412, 'Mexico', 'MX', 'San Isidro'),
(413, 'Finland', 'FI', 'Orivesi'),
(414, 'Japan', 'JP', 'Ginowan'),
(415, 'Yemen', 'YE', 'Al Khawkhah'),
(416, 'Burkina Faso', 'BF', 'Réo'),
(417, 'China', 'CN', 'Changting'),
(418, 'Poland', 'PL', 'Stalowa Wola'),
(419, 'Colombia', 'CO', 'Funes'),
(420, 'Venezuela', 'VE', 'Umuquena'),
(421, 'Poland', 'PL', 'Obsza'),
(422, 'Cambodia', 'KH', 'Kampong Chhnang'),
(423, 'France', 'FR', 'Golbey'),
(424, 'China', 'CN', 'Xuancheng'),
(425, 'Philippines', 'PH', 'Concepcion'),
(426, 'Israel', 'IL', 'Kefar Tavor'),
(427, 'Indonesia', 'ID', 'Buket Teukuh'),
(428, 'China', 'CN', 'Huixian Chengguanzhen'),
(429, 'China', 'CN', 'Qingshui'),
(430, 'Philippines', 'PH', 'San Agustin'),
(431, 'United States', 'US', 'Fairbanks'),
(432, 'Panama', 'PA', 'Potrero Grande'),
(433, 'China', 'CN', 'Huixing'),
(434, 'Greece', 'GR', 'Filótion'),
(435, 'China', 'CN', 'Shanhe'),
(436, 'Thailand', 'TH', 'Pho Thong'),
(437, 'Indonesia', 'ID', 'Growong Kidul'),
(438, 'Philippines', 'PH', 'Alcoy'),
(439, 'China', 'CN', 'Jingouhe'),
(440, 'Indonesia', 'ID', 'Mnelalete'),
(441, 'China', 'CN', 'Guankou'),
(442, 'Thailand', 'TH', 'Cho-airong'),
(443, 'China', 'CN', 'Xiangzikou'),
(444, 'Japan', 'JP', 'Kukichūō'),
(445, 'Argentina', 'AR', 'Inriville'),
(446, 'New Zealand', 'NZ', 'Pakuranga'),
(447, 'Thailand', 'TH', 'Bueng Khong Long'),
(448, 'Portugal', 'PT', 'Torreira'),
(449, 'Indonesia', 'ID', 'Cibeureum'),
(450, 'France', 'FR', 'Paris 06'),
(451, 'Armenia', 'AM', 'Spitak'),
(452, 'Argentina', 'AR', 'La Tigra'),
(453, 'Sweden', 'SE', 'Tierp'),
(454, 'Philippines', 'PH', 'Lipa City'),
(455, 'Thailand', 'TH', 'Dong Charoen'),
(456, 'Indonesia', 'ID', 'Lokorae'),
(457, 'France', 'FR', 'Tours'),
(458, 'Canada', 'CA', 'Princeton'),
(459, 'Dominican Republic', 'DO', 'Sabaneta'),
(460, 'Colombia', 'CO', 'San José del Guaviare'),
(461, 'Tanzania', 'TZ', 'Mlalo'),
(462, 'Brazil', 'BR', 'Ouricuri'),
(463, 'Japan', 'JP', 'Bungo-Takada-shi'),
(464, 'Indonesia', 'ID', 'Batanamang'),
(465, 'Sweden', 'SE', 'Pajala'),
(466, 'Mali', 'ML', 'Gao'),
(467, 'United States', 'US', 'Garland'),
(468, 'Indonesia', 'ID', 'Pakemitan Dua'),
(469, 'Greece', 'GR', 'Messíni'),
(470, 'Canada', 'CA', 'Bells Corners'),
(471, 'Albania', 'AL', 'Fushëkuqe'),
(472, 'Botswana', 'BW', 'Mathakola'),
(473, 'Czech Republic', 'CZ', 'Konice'),
(474, 'China', 'CN', 'Nanguzhuang'),
(475, 'Colombia', 'CO', 'Cáchira'),
(476, 'China', 'CN', 'Gaoyu'),
(477, 'Peru', 'PE', 'San Clemente'),
(478, 'Kazakhstan', 'KZ', 'Zyryanovsk'),
(479, 'Portugal', 'PT', 'Galamares'),
(480, 'Peru', 'PE', 'Sibayo'),
(481, 'China', 'CN', 'Guojia'),
(482, 'Indonesia', 'ID', 'Kebonagung'),
(483, 'France', 'FR', 'Paris 15'),
(484, 'Russia', 'RU', 'Krasnotur’insk'),
(485, 'Haiti', 'HT', 'Torbeck'),
(486, 'United States', 'US', 'Minneapolis'),
(487, 'Thailand', 'TH', 'Samut Songkhram'),
(488, 'Venezuela', 'VE', 'Tacarigua'),
(489, 'Brazil', 'BR', 'Itapipoca'),
(490, 'Syria', 'SY', 'Aş Şūrah aş Şaghīrah'),
(491, 'Portugal', 'PT', 'Lourido'),
(492, 'Russia', 'RU', 'Starokucherganovka'),
(493, 'Indonesia', 'ID', 'Jambean'),
(494, 'Peru', 'PE', 'Urpay'),
(495, 'Philippines', 'PH', 'San Martin'),
(496, 'China', 'CN', 'Huazhaizi'),
(497, 'Greece', 'GR', 'Galatás'),
(498, 'Russia', 'RU', 'Belgorod'),
(499, 'China', 'CN', 'Xiguantun Muguzu Manzuxiang'),
(500, 'China', 'CN', 'Jiangna');

-- --------------------------------------------------------

--
-- Table structure for table `customer_register`
--

CREATE TABLE `customer_register` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `date` varchar(60) NOT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `user_unique_id` varchar(50) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_register`
--

INSERT INTO `customer_register` (`id`, `name`, `emailaddress`, `phonenumber`, `password`, `date`, `status`, `user_unique_id`, `session_id`) VALUES
(10, 'Aditya', 'aditya.k@designerstreet.in', '6361793287', '$2y$10$bPP0CQb1fITDc30AfvwrROFp9qNZE8J/cvnqhTr6TWXHwHGq567Ji', '2024-08-16 06:45:24', 'active', 'user_66bef584958351.77677943', NULL),
(11, 'mahek', 'mahek@gmail.com', '8965231470', '$2y$10$ft1Q3MzQ5ECj2DazpxcoEOYFMcxLDZlvPgdA9OxVHSp0nOfqzv.3e', '2024-09-10 11:02:15', 'active', 'user_66e02737eec609.38794746', NULL),
(13, 'MAHEBOOB RAHEMAN', 'maheboobraheman47@gmail.com', '8147444010', '$2y$10$eEprsv/buOet1bRW6AFSQuvMWZs9M0Wkmjz4fGTKGaubTpAjo3jvi', '2024-09-23 12:55:15', 'active', 'user_66f16533c8f5f0.15495519', NULL),
(14, 'Aman', 'aman091320cse@gmail.com', '9110134778', '$2y$10$3eRdzSz8f8XfyawnLFDDquJvt0G3B2oiZnTPoDhyMp3nV59puELTq', '2024-09-26 03:33:36', 'active', 'user_66f4d6104c4dc6.76200169', NULL),
(15, 'Megha vijay ', 'meghavijay01999@gmail.com', '9074738161', '$2y$10$jk3zqTsqJqNy/6re0ng4a.CeCz63P9H.0N3zWnDKJ35WLlHtKxEhe', '2024-09-26 11:31:20', 'active', 'user_66f5460879b469.55397974', NULL),
(16, 'Suraj J P', 'surajjp2508@gmail.com', '7829795717', '$2y$10$t9Hgywh6RMxAgd/ep3I1Lu.Vrz9QiUFbDxr91mD3B/mBgk96i8ywK', '2024-09-28 20:30:36', 'active', 'user_66f8676ccec6d2.88309355', NULL),
(17, 'Demo', 'demo@gmail.com', '8956234170', '$2y$10$Doli1ZqePi0ff0wOmIxX/.1yqJTZlVe396BTPve49KqkJmbxMJIgi', '2024-10-01 09:54:30', 'active', 'user_66fbc6d6a26002.40566536', NULL),
(18, 'Pritika', 'Vrspritika@gmail.com', '9500647034', '$2y$10$nI1hH5oP6RvZ62lXRbCNn.eggyUKJOQoZerIclkQYLc69iFweTZFC', '2024-10-02 06:04:47', 'active', 'user_66fce27f505c17.55938546', NULL),
(19, 'Madhav pandya', 'madhav.pandya999@gmail.com', '8128611554', '$2y$10$ifF0b3qUoAr9/l.rDAV1KOgtZHkJKFO4pYQXI0V0foUErped/zRiu', '2024-10-02 12:52:02', 'active', 'user_66fd41f208ead6.92512812', NULL),
(20, 'Monica M S', 'monicamadhu0709@gmail.com', '9952266244', '$2y$10$M3BOQZppD13S3Mf50eL6IuCuJdazbQK7q1t8GrncS9Afmj63HcKC2', '2024-10-02 22:15:47', 'active', 'user_66fdc61307bc13.03718843', NULL),
(21, 'Sheen Sabu', 'sheensabu111@gmail.com', '9562584239', '$2y$10$1hScitUjHyFstC3RHtkWs.FS0UuO8sFmO6xWwXee6PKi/.EDpnRuG', '2024-10-03 06:44:22', 'active', 'user_66fe3d46caa615.43834888', NULL),
(22, 'varun bn', 'varunappu721@gmail.com', '7795790079', '$2y$10$MXIPLiTfzetu1tq91hmZkurXqn0XOZ3AIAPzuxYQFV0.InRLIEWoa', '2024-10-03 09:39:24', 'active', 'user_66fe664c9e11d6.09577160', NULL),
(23, 'Rachana', 'nayakrachana28@gmail.com', '8088465191', '$2y$10$mfGVS3PzjRl8VtnSGYjTwO4Nu0KsVGCZaWHUSXTA6se90O4OBuxzO', '2024-10-03 15:43:42', 'active', 'user_66febbae1f5918.31172876', NULL),
(24, 'Tamilarasi ', 'chidambaram172000@gmail.com', '6381800157', '$2y$10$Zqvc37RiCM.O3.b0Sdu9CeI6iZGpCHHtxpb96w93gvkk7O8a0QT8a', '2024-10-06 21:41:06', 'active', 'user_670303f2309d91.41242903', NULL),
(25, 'Surya ', 'suryaananth188@gmail.com', '9080570485', '$2y$10$3VGG70mPvWIApPNFrNsnQu.WlDZ3bmo9.7oED.UozHi0yqjT9OTnq', '2024-10-09 15:29:12', 'active', 'user_6706a14802de71.13823061', NULL),
(26, 'Jaffar', 'jaffar8055@gmail.com', '8123707783', '$2y$10$gTIBaQwVf5Y4Qx2WnW3vau/bnD1TN/lQdascWbjNGTeOezCqmpAZS', '2024-10-15 07:39:01', 'active', 'user_670e1c15a1d478.68549657', NULL),
(27, 'K', 'Kevinant1811@gmail.com', '9843823305', '$2y$10$pvD.hw9jGW/FV/rVE/6vauk2AKF5INPqXFarpqwk16QpshqW/0o46', '2024-10-15 09:22:16', 'active', 'user_670e3448505bb7.42355541', NULL),
(28, 'sunaina ', 'Sunainarongpipi65@gmail.com', '8787687036', '$2y$10$IGWhZ26oBISfTwxI3q.2qOKISZUU.d0oYFR8gIPD6J5dWroiXpmnK', '2024-10-15 18:30:21', 'active', 'user_670eb4bd82c7a9.69600018', NULL),
(29, 'Diwakar Babu', 'nmdbabu@gmail.com', '9845685685', '$2y$10$MJBco6QwHjS.bNJYg3L36ejNm2ZlYVihMkKYMQ6FiIC1pfSqXR06K', '2024-10-17 12:14:43', 'active', 'user_6710ffb3540a81.48381549', NULL),
(30, 'Kushal Deb', 'deb.kushal96@gmail.com', '7575965172', '$2y$10$Ra2EQXa0M1.DQnc4gzbCpumAFZqWedHi4rQ3Mg6Lio5Gt9eWIM4V6', '2024-10-17 17:02:51', 'active', 'user_6711433b7b5898.53987857', NULL),
(31, 'Suchismita', 'suchismitadeblaskar@gmail.com', '8761894815', '$2y$10$DzrCTy7lZ9ppwTRMySErR.1QDSS3.MrcIhI.zadcE8gMo1wOXQhO2', '2024-10-18 20:39:07', 'active', 'user_6712c76b2ffa14.75213308', NULL),
(32, 'Ankit kumar Singh', 'ankit4mgospel@gmail.com', '07596823913', '$2y$10$AJolqyskoziiXa4rOtbYfOzuhcFGNahZulENCSbPCmdF3ly7j1Yzy', '2024-10-19 10:03:00', 'active', 'user_671383d4766b76.40375256', NULL),
(33, 'nihal pawar', 'nihalpawar673@gmail.com', '7259760252', '$2y$10$v1h/8clazQfCTiNPoiAPw.oT/3UYk.MFKchraeRClB3QX57jxE3f.', '2024-10-19 18:24:26', 'active', 'user_6713f95a688ad0.83103141', NULL),
(34, 'Nischitha U', 'nischithau73@gmail.com', '9606124397', '$2y$10$AS38/wsxmRs7krElZhk3pu0lLM/onKy6CrqklnrVqLh5fjWA2OpsS', '2024-10-21 10:36:07', 'active', 'user_67162e97e98589.19526221', NULL),
(35, 'Megha A', 'meghaa878909@gmail.com', '9080974535', '$2y$10$HVkPQo0TxatzrqDbpFZHCOP2.4GqbG18I2QEmSzvrVDi1qNEmyzV6', '2024-10-21 12:56:26', 'active', 'user_67164f7a167412.63357293', NULL),
(36, 'sriyutha', 'sriyuthaprabha7@gmail.com', '9494439009', '$2y$10$O0nJWaoDUMUDNnwEljVQq.k1n0jlmqDcGz72HEDC/L5/8VK04MHaq', '2024-10-21 14:37:44', 'active', 'user_67166738860c29.99035311', NULL),
(37, 'Anushree Nataraja', 'natarajanushree@gmail.com', '8762024463', '$2y$10$Hruc9.RJELWT72rQh0A58.q9Q.LZrjV68d2omBwFGLiFboYB7Tlvu', '2024-10-22 16:31:48', 'active', 'user_6717d3744719d0.06749685', NULL),
(38, 'rutuja', 'rutujabammannavar4@gmail.com', '8197736408', '$2y$10$w7RI9Wu6R3gEhEFLFbkOv.lV48G1kDoS8r/LMjFjFlFXIwmyDGsGW', '2024-10-23 14:31:04', 'active', 'user_671908a8a24c33.14367883', NULL),
(39, 'Suraj singh', 'Srjofficiall@gmail.com', '9798496800', '$2y$10$cuJemzwJIfNO.WJaMPNfi.0KQnN7cjXnF66Isvo0fm3UNrdCK48Ma', '2024-10-24 04:32:30', 'active', 'user_6719cdde878568.36577441', NULL),
(40, 'Ayushi Panda', 'ayushipanda1308@gmail.com', '8618993947', '$2y$10$bLekVVC8VqYgvM6s3SF4V.rC9.sh.qNNpMLGrsv8hMv9tgQBgPq/.', '2024-10-24 05:02:55', 'active', 'user_6719d4ff64d915.47145616', NULL),
(41, 'Ajith', 'sanjvenky98@gmal.com', '7358424665', '$2y$10$IM/XqTfwq/6TmCBDM5uYBOMPFuEvxVjHAn81WOPpq/1qZZ9jUpS.O', '2024-10-26 12:22:07', 'active', 'user_671cdeeff39306.41177449', NULL),
(42, 'tenzin', 'woesert759@gmail.com', '6366122196', '$2y$10$ENTDjfEaPRv4W59v0.UVq.dzJO6Rp7.m8kdtSqLzRuQzEzwZu06VG', '2024-10-26 16:27:07', 'active', 'user_671d185b554114.70203918', NULL),
(43, 'Neha Elsa Biju', 'elsabiju7@gmail.com', '9567081178', '$2y$10$Ne2XSOKnrjtZBdwo.GQO5ujQZLGd6SAO3UkeYPwVYVu6LbhgDMBkS', '2024-10-27 17:09:33', 'active', 'user_671e73cdc96f59.44714047', NULL),
(44, 'Ann', 'anamikaprakash67@gmail.com', '7034421007', '$2y$10$URmEZ0fCQL9ftG7uytFGA.BgSiK.sMtRvRgwi5jDYDuVWe87O6OVW', '2024-11-01 06:40:51', 'active', 'user_672477f3e6cbc5.10155288', NULL),
(45, 'Divya Vankudre', 'divyavankudre14@gmail.com', '9482708554', '$2y$10$fXMbkBdeJ4oXcp7eYrm6nOTQ30DvpnuYIkuVI5jZ1iSkqgdJLWpuK', '2024-11-02 14:27:12', 'active', 'user_672636c0238437.03573391', NULL),
(46, 'rahul ellur', 'rahulellur4@gmail.com', '8088789999', '$2y$10$q8d7VZs8ECUMI6gwM6ZbJOTRVwFaSvKC3vhxsIL3K2lnAZZUvmyza', '2024-11-04 17:04:05', 'active', 'user_6728fe853cb1b0.20500187', NULL),
(47, 'Samson', 'samsonisaac1172@gmail.com', '8951225980', '$2y$10$MIyvtVbShOv4KyQx/Co9VOw7CaDkhX6lKsaASLP47vFjI8je9ixCK', '2024-11-05 08:46:51', 'active', 'user_6729db7b004cf4.90973819', NULL),
(48, 'Amith Raj', 'amithrajsn9148@gmail.com', '9148969531', '$2y$10$4xKjMhPufibx32tIzXbakOZHlzdLN64K2HSy7Z4vT1.gciXS8o/ma', '2024-11-08 05:29:30', 'active', 'user_672da1badd1cc1.00501303', NULL),
(49, 'Abhishek ', 'zoheb477@gmail.com', '9663666083', '$2y$10$I2j85T1scHa06/cLtBULFeiaXeTIqXILIwxRj3/lDrlhnrEm/KBc.', '2024-12-15 14:56:47', 'active', 'user_675eee2f3a9ac2.11806265', NULL),
(50, 'tesing', 'test@gmail.com', '8529637410', '$2y$10$CSWnqqz5C.DehbKO3uiQlumBY489u/XjQGKd9sGiaFA6H7NzZIjZy', '2025-01-09 09:32:24', 'active', 'user_677f97a8396d87.63180490', NULL),
(51, 'abc', 'abc@gmail.com', '8965741230', '$2y$10$qV9mka62BRwlLAwTjB7FwuXrcVapFXT6.aBncaMekrBKmSXvxR4/C', '2025-01-09 10:28:39', 'active', 'user_677fa4d7ad8674.35820436', NULL),
(52, 'Medha Jaganmohan', 'medhajaganmohan93@gmail.com', '7259596636', '$2y$10$l2d7kIe8NmqrdhCS37mRPeBuvw.jApSvDvGRD.hRcBbrmqZWVWzGy', '2025-01-13 15:45:38', 'active', 'user_678535226f3252.29786740', NULL),
(53, 'Hari', 'hari747@gmail.com', '9491783518', '$2y$10$JRXxiA/mFOVngg5bLPZDrukp22WtL2U96lKsXFnO9I82etEd4i7ji', '2025-01-24 02:53:00', 'active', 'user_6793008c4f7b64.55071479', NULL),
(54, 'Ponarazhauyt urodov\r\n >>> https://is.gd/bhdwfs\r\n <<<9200557', 'press@tsikhanouskaya.org\r\n', 'Kurwa Bober!!!!!\r\n >', '$2y$10$uQMUEY9jNYjEUGQJGAXfHerlMG2eEGycngmCcNGUjVjvu0XBRN0s6', '2025-01-24 16:46:20', 'active', 'user_6793c3dcd43a44.36064417', NULL),
(55, 'Rajashree', 'rajashreer24@gmail.com', '9901006912', '$2y$10$M7eeErjfQERdm49MiJD2duB/c0iotY647UQOBANCkgL.ULvifmUba', '2025-01-27 13:36:30', 'active', 'user_67978bde5c5ec6.23767184', NULL),
(56, 'helena', 'helenaksh6@gmail.com', '7642035376', '$2y$10$0LUScqX/cnyC8.bcaT0/uOY5YMKQ4XRdS1wFeeZq4kKmodHoyhsxG', '2025-01-29 16:42:21', 'active', 'user_679a5a6dc5d804.76089514', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dropdown_values`
--

CREATE TABLE `dropdown_values` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dropdown_values`
--

INSERT INTO `dropdown_values` (`id`, `value`) VALUES
(1, 'Rent'),
(2, 'Sale'),
(3, 'Commercial'),
(4, 'Movers & Packers'),
(5, 'Electrician'),
(6, 'Plumbing'),
(7, 'Cleaning services'),
(8, 'Interiors'),
(9, 'Exteriors');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `user_id`, `property_id`, `message`, `created_at`) VALUES
(1, 4, 1, 'jkhkjhkjhkjh kjhkjhkhkj kjh jkhkjhk', '2024-08-07 14:15:22'),
(2, 4, 2, 'test test hjhjhhhj hhggjhjhkjbvn', '2024-08-07 18:18:10'),
(3, 2, 1, 'hyyy soumya hyy soumya ', '2024-08-07 18:19:40'),
(4, 1, 16, 'hyy new userrrr', '2024-08-07 18:23:24'),
(5, 1, 2, 'hyyy test test hhyyy hhyy tset tset', '2024-08-07 18:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`id`, `user_id`, `property_id`, `message`, `created_at`) VALUES
(1, 3, 3, 'User ID: 3 has sent an enquiry for Property ID: 3.', '2024-08-01 06:06:42'),
(2, 3, 3, 'User ID: 3 has sent an enquiry for Property ID: 3.', '2024-08-01 06:32:12'),
(3, 3, 3, 'User ID: 3 has sent an enquiry for Property ID: 3.', '2024-08-01 06:59:54'),
(4, 3, 1, 'User ID: 3 has sent an enquiry for Property ID: 1.', '2024-08-01 07:06:46'),
(5, 3, 1, 'User ID: 3 has sent an enquiry for Property ID: 1.', '2024-08-01 08:11:23'),
(8, 4, 9, 'User ID: 4 has sent an enquiry for Property ID: 9.', '2024-08-01 10:33:14'),
(9, 4, 1, 'User ID: 4 has sent an enquiry for Property ID: 1.', '2024-08-01 11:58:13'),
(11, 0, 0, 'hyyy', '2024-08-01 17:44:40'),
(16, 4, 1, 'mhbjhbjhb kbkb', '2024-08-03 11:35:26'),
(20, 1, 8, 'hghgghgfchg fhftcyy vhg', '2024-08-03 12:38:18'),
(21, 4, 2, 'User ID: 4 has sent an enquiry for Property ID: 2.', '2024-08-07 11:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bill_no` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Active','Paid','Overdue') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_name`, `address`, `bill_no`, `amount`, `tax`, `total_amount`, `invoice_date`, `due_date`, `status`, `created_at`) VALUES
(0, 'NIKITA ROY', 'HSR LAYOUT', 5, 20000.00, 18.00, 20018.00, '2024-12-16', '2024-12-18', 'Overdue', '2024-12-15 15:24:35'),
(3, 'soni', 'soni@gmail.com', 1, 5000.00, 20.00, 5020.00, '2024-08-16', '2024-08-15', 'Paid', '2024-08-05 03:39:39'),
(4, 'soni', 'soni@gmail.com', 2, 5000.00, 20.00, 5020.00, '2024-08-16', '2024-08-15', 'Overdue', '2024-08-05 03:41:44'),
(5, 'soni', 'soni@gmail.com', 3, 5000.00, 20.00, 5020.00, '2024-08-16', '2024-08-15', 'Overdue', '2024-08-05 04:12:55'),
(6, 'soni', 'soni@gmail.com', 4, 5000.00, 20.00, 5020.00, '2024-08-16', '2024-08-15', 'Overdue', '2024-08-05 04:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `owner_messages`
--

CREATE TABLE `owner_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner_messages`
--

INSERT INTO `owner_messages` (`id`, `user_id`, `property_id`, `message`, `created_at`) VALUES
(3, 4, 8, 'hyyy me soni', '2024-08-04 09:49:04'),
(8, 4, 8, 'bbhg', '2024-08-07 11:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_updated` enum('pending','updated') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `bhk_type` varchar(50) DEFAULT NULL,
  `property_type` varchar(50) DEFAULT NULL,
  `build_up_area` float DEFAULT NULL,
  `property_age` varchar(50) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `total_floor` int(11) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `available_for` varchar(100) DEFAULT NULL,
  `expected_rent` varchar(255) DEFAULT NULL,
  `expected_deposit` varchar(255) DEFAULT NULL,
  `maintenance` varchar(50) DEFAULT NULL,
  `available_from` date DEFAULT NULL,
  `preferred_tenants` varchar(100) DEFAULT NULL,
  `furnishing` varchar(50) DEFAULT NULL,
  `parking` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `balcony` int(11) DEFAULT NULL,
  `water_supply` varchar(50) DEFAULT NULL,
  `amenities` varchar(255) DEFAULT NULL,
  `file_upload` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `available_all` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `property_status` varchar(50) DEFAULT 'Pending',
  `date` date DEFAULT curdate(),
  `approval_status` varchar(250) NOT NULL,
  `owner_agent_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `bhk_type`, `property_type`, `build_up_area`, `property_age`, `floor`, `total_floor`, `area`, `city`, `state`, `available_for`, `expected_rent`, `expected_deposit`, `maintenance`, `available_from`, `preferred_tenants`, `furnishing`, `parking`, `description`, `bathrooms`, `balcony`, `water_supply`, `amenities`, `file_upload`, `availability`, `start_time`, `end_time`, `available_all`, `created_at`, `user_id`, `property_status`, `date`, `approval_status`, `owner_agent_type`) VALUES
(1, '1BHK', 'STAND ALONE BUILDING', 600, '1', 5, 5, 'Akshayanagar, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Rent', '26000', '120000', 'Maintenance Included', '2025-01-15', 'Family', 'Semi-Furnished', 'Two-Wheeler', 'Brand New Property! Ready to Move-in!', 1, 1, 'Both (Municipal + Borewell)', 'Study Table,Lift,Power Backup,Bike Parking,Wardrobes', '../uploads/6783f04867f3a_6e57f798-46e1-4682-930a-0b1936ea987f.jpeg,\n../uploads/6783f04868ba8_54626ae1-1e64-483e-9618-114c6e1085fe.jpeg,\n../uploads/6783f04869730_a2260518-b23b-4755-b9f8-00b0cd5bba10.jpeg', 'Everyday (Mon-Sun)', '00:00:00', '00:00:00', 1, '2025-01-12 16:39:36', 49, 'Pending', '2025-01-12', 'Approved', 'Owner'),
(3, '1BHK', 'STAND ALONE BUILDING', 450, '1', 4, 3, 'HSR Layout, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Rent', '29000', '120000', 'Maintenance Included', '2025-01-15', 'Anyone', 'Semi-Furnished', 'Two-Wheeler', 'BRAND NEW PROPERTY', 1, 0, 'Both (Municipal + Borewell)', 'utility,Lift,Power Backup,Security,Geyser,Cupboards,CCTV,Wardrobes', '../uploads/pro_0f1.jpeg,../uploads/pro_452.jpeg,../uploads/pro_333.jpeg,../uploads/pro_1ac.jpeg,../uploads/pro_f57.jpeg,../uploads/pro_d68.jpeg,../uploads/pro_adb.jpeg,../uploads/pro_942.jpeg,../uploads/pro_53e.jpeg', 'Everyday (Mon-Sun)', '00:00:00', '00:00:00', 1, '2025-01-14 04:25:45', 49, 'Pending', '2025-01-14', 'Approved', 'Owner'),
(4, '2BHK', 'FLAT', 1000, '3', 4, 5, 'BTM Layout, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Rent', '35000', '190000', 'Maintenance Included', '2025-01-15', 'Family', 'Semi-Furnished', 'Four-Wheeler', 'Stunning 2BHK', 2, 1, 'Both (Municipal + Borewell)', 'Car Parking,utility,Lift,Visitor Parking,Power Backup,Security,Geyser,Cupboards,Shoe Rack,Wardrobes', '../uploads/pro_62d.jpeg,../uploads/pro_bbd.jpeg,../uploads/pro_b26.jpeg,../uploads/pro_d4c.jpeg,../uploads/pro_ff9.jpeg,../uploads/pro_1a8.jpeg,../uploads/pro_0bd.jpeg,../uploads/pro_181.jpeg,../uploads/pro_1ca.jpeg', 'Everyday (Mon-Sun)', '00:00:00', '00:00:00', 1, '2025-01-14 04:38:47', 49, 'Pending', '2025-01-14', 'Approved', 'Owner'),
(5, '1BHK', 'STAND ALONE BUILDING', 1200, '1', 4, 5, 'BTM Layout, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Rent', '35000', '100000', 'Maintenance Included', '2025-02-20', 'Anyone', 'Semi-Furnished', 'Four-Wheeler', 'It\'s new property', 1, 1, 'Both (Municipal + Borewell)', 'Car Parking,utility,Lift,Security,Bike Parking,Geyser,Cupboards,CCTV,Wardrobes', '../uploads/pro_daf.jpg,../uploads/pro_3f6.jpg,../uploads/pro_593.jpg,../uploads/pro_67d.jpg,../uploads/pro_79d.jpg,../uploads/pro_895.jpg,../uploads/pro_9d9.jpg,../uploads/pro_ae3.jpg,../uploads/pro_bce.jpg,../uploads/pro_cba.jpg', '', '11:45:00', '21:45:00', 0, '2025-01-26 16:16:12', 26, 'Pending', '2025-01-26', '', 'Owner'),
(12, '3BHK', 'Commercial', 500, '1', 2, 2, 'Mumanvas, Gujarat, India', 'Mumanvas', 'Gujarat', 'Rent', '6000', '200', 'Maintenance Extra', '2025-02-07', 'Bachelor Female', 'Semi-Furnished', 'Four-Wheeler', 'kjjb jhgvjh jhvbj', 1, 1, 'Borewell', 'Air Conditioner', '../uploads/pro_c1f.png,../uploads/pro_e26.jpeg', 'Weekend (Sat-Sun)', '13:54:00', '17:49:00', 0, '2025-01-28 08:20:04', 51, 'Pending', '2025-01-28', 'Approved', 'Owner'),
(13, '3BHK', 'Office Space', 1200, '1', 4, 6, 'BTM Layout, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Sale', '22000000', '', 'Maintenance Included', '2025-01-30', 'Anyone', 'Semi-Furnished', 'Four-Wheeler', 'this is new property', 1, 1, 'Both (Municipal + Borewell)', 'Car Parking', '../uploads/pro_2ed.png', 'Everyday (Mon-Sun)', '09:09:00', '05:05:00', 1, '2025-01-28 14:32:32', 26, 'Pending', '2025-01-28', '', 'Owner'),
(14, '2BHK', 'Commercial', 85, '1', 1, 1, 'Uumri Majbata, Uttar Pradesh, India', 'Delhi', 'Uttar Pradesh', 'Rent', '757', '85', 'Maintenance Extra', '2025-01-25', 'Company', 'Fully-Furnished', 'Four-Wheeler', 'yhfht  hfhc  hgchf', 1, 1, 'Municipal', 'Air Conditioner,Kitchen Appliances', '../uploads/pro_38a.jpeg,../uploads/pro_679.jpeg,../uploads/pro_5d4.jpeg,../uploads/pro_5ae.jpeg,../uploads/pro_4b4.jpeg,../uploads/pro_470.jpeg,../uploads/pro_200.jpeg,../uploads/pro_d68.png,../uploads/pro_e3c.jpeg,../uploads/pro_ecc.jpg,../uploads/pro_fe', 'Weekend (Sat-Sun)', '15:28:00', '15:23:00', 0, '2025-01-29 09:53:32', 51, 'Pending', '2025-01-29', '', 'Owner'),
(15, '2BHK', 'GATED APARTMENT', 500, '2', 1, 4, 'V. V. Mohalla, Mysuru, Karnataka, India', 'Vadambacheri', 'Tamil Nadu', 'Rent', '55', '1', 'Maintenance Extra', '2025-02-07', 'Family', 'Semi-Furnished', 'Two-Wheeler', 'hijh jjjjjjjjjjjjj jjjjjjjjj', 1, 1, 'Both (Municipal + Borewell)', 'Air Conditioner', '../uploads/pro_89d.jpeg,../uploads/pro_ab0.jpeg,../uploads/pro_956.jpeg,../uploads/pro_733.jpeg,../uploads/pro_561.jpeg,../uploads/pro_2d6.jpeg,../uploads/pro_4a3.jpeg,../uploads/pro_0f1.jpeg,../uploads/pro_bd6.png,../uploads/pro_cc0.jpeg,../uploads/pro_d', 'Weekend (Sat-Sun)', '16:19:00', '21:14:00', 0, '2025-01-29 10:46:42', 51, 'Pending', '2025-01-29', '', 'Owner'),
(16, '3BHK', 'FLAT', 1200, '2', 5, 6, 'BTM Layout, Bengaluru, Karnataka, India', 'Bengaluru', 'Karnataka', 'Only Lease', '', '', 'Maintenance Extra', '2025-01-29', 'Anyone', 'Semi-Furnished', 'Two-Wheeler', 'Kesicgjhkxnvn', 1, 1, 'Both (Municipal + Borewell)', 'Mattresses', '../uploads/pro_265.jpg,../uploads/pro_098.jpg,../uploads/pro_bb9.jpg,../uploads/pro_72d.jpg,../uploads/pro_33f.jpg,../uploads/pro_f4c.jpg,../uploads/pro_c11.jpg,../uploads/pro_6e9.jpg,../uploads/pro_18c.jpg,../uploads/pro_dc0.jpg', '', '08:30:00', '12:34:00', 1, '2025-01-29 15:06:51', 26, 'Pending', '2025-01-29', '', 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `saved_properties`
--

CREATE TABLE `saved_properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_properties`
--

INSERT INTO `saved_properties` (`id`, `user_id`, `property_id`, `created_at`) VALUES
(0, 2, 1, '2024-09-03 11:58:42'),
(75, 3, 1, '2024-08-01 07:38:19'),
(76, 3, 3, '2024-08-01 07:44:37'),
(77, 4, 1, '2024-08-01 09:06:41'),
(78, 1, 9, '2024-08-01 17:23:41'),
(80, 4, 8, '2024-08-03 12:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `save_items`
--

CREATE TABLE `save_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `save_items`
--

INSERT INTO `save_items` (`id`, `user_id`, `property_id`, `saved_at`) VALUES
(1, 1, 22, '2024-12-24 09:43:09'),
(3, 3, 22, '2024-12-24 09:44:13'),
(4, 53, 4, '2025-01-24 02:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `save_items2`
--

CREATE TABLE `save_items2` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `save_items2`
--

INSERT INTO `save_items2` (`id`, `user_id`, `property_id`) VALUES
(0, 2, 1),
(11, 4, 8),
(13, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_visits`
--

CREATE TABLE `scheduled_visits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `visit_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheduled_visits`
--

INSERT INTO `scheduled_visits` (`id`, `user_id`, `property_id`, `visit_date`, `created_at`) VALUES
(1, 2, 1, '2024-09-13 18:33:00', '2024-09-03 11:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_img` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_img`, `service_name`, `service_description`) VALUES
(4, '66d190bb11c07.png', 'Painting', 'Paint'),
(5, '66d1910b34131.png', 'Packers & Movers', ''),
(7, '66d2c96d61caa.png', 'Electrician', ''),
(8, '66d2c99bc8234.png', 'Plumbing', ''),
(9, '66d2c9b34cbee.png', 'Fabrication', ''),
(10, '66d2c9cf97717.png', 'Carpenter', ''),
(11, '66d2c9ede0c9a.png', 'Lift Service', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_register`
--
ALTER TABLE `admin_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bhk_searches`
--
ALTER TABLE `bhk_searches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_register`
--
ALTER TABLE `customer_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropdown_values`
--
ALTER TABLE `dropdown_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_no` (`bill_no`);

--
-- Indexes for table `owner_messages`
--
ALTER TABLE `owner_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save_items`
--
ALTER TABLE `save_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_property` (`user_id`,`property_id`);

--
-- Indexes for table `save_items2`
--
ALTER TABLE `save_items2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `scheduled_visits`
--
ALTER TABLE `scheduled_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_register`
--
ALTER TABLE `admin_register`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `customer_register`
--
ALTER TABLE `customer_register`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `dropdown_values`
--
ALTER TABLE `dropdown_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `save_items`
--
ALTER TABLE `save_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scheduled_visits`
--
ALTER TABLE `scheduled_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
