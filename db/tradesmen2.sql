-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2022 at 01:30 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tradesmen2`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_options`
--

CREATE TABLE `add_options` (
  `id` int(6) NOT NULL,
  `sub_category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT 1,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_options`
--

INSERT INTO `add_options` (`id`, `sub_category`, `option`, `status`, `create_date`) VALUES
(2, '9', ' Extension', 1, '2022-08-11 09:13:24'),
(3, '9', ' Loft conversion', 1, '2022-08-11 09:13:51'),
(4, '9', ' Renovation', 1, '2022-08-11 09:14:03'),
(5, '9', ' New build', 1, '2022-08-11 09:14:15'),
(6, '9', ' Other', 1, '2022-08-11 09:14:28'),
(7, '10', ' Extension', 1, '2022-08-11 09:15:14'),
(8, '10', ' Loft conversion', 1, '2022-08-11 09:15:37'),
(9, '10', ' Renovation', 1, '2022-08-11 09:15:50'),
(10, '10', ' New build', 1, '2022-08-11 09:16:04'),
(11, '10', ' Other', 1, '2022-08-11 09:16:21'),
(12, '11', 'Detailing', 1, '2022-08-11 09:17:00'),
(14, '18', ' Extension', 1, '2022-08-11 09:17:56'),
(15, '18', ' Loft conversion', 1, '2022-08-11 09:18:11'),
(16, '18', ' Renovation', 1, '2022-08-11 09:18:23'),
(17, '18', ' New build', 1, '2022-08-11 09:18:43'),
(18, '18', ' Other', 1, '2022-08-11 09:18:57'),
(19, '14', '1', 1, '2022-08-11 09:20:52'),
(20, '14', '2 or more', 1, '2022-08-11 09:21:10'),
(21, '15', 'Yes', 1, '2022-08-11 09:21:54'),
(22, '15', 'No', 1, '2022-08-11 09:22:09'),
(23, '16', 'Yes', 1, '2022-08-11 09:22:50'),
(24, '16', 'No', 1, '2022-08-11 09:23:03'),
(25, '17', ' New or replacement tiles', 1, '2022-08-11 09:24:07'),
(26, '17', ' Repair / regrout tiles', 1, '2022-08-11 09:24:21'),
(27, '17', 'Other', 1, '2022-08-11 09:24:38'),
(28, '20', ' Small decorative wall', 1, '2022-08-11 09:31:18'),
(29, '20', ' Small wall', 1, '2022-08-11 09:31:33'),
(30, '20', ' Garden wall', 1, '2022-08-11 09:31:47'),
(31, '20', ' Retaining wall', 1, '2022-08-11 09:31:59'),
(32, '20', ' More than one wall', 1, '2022-08-11 09:32:18'),
(33, '21', ' Outbuilding', 1, '2022-08-11 09:33:22'),
(34, '21', ' Porch', 1, '2022-08-11 09:33:37'),
(35, '21', ' Garage', 1, '2022-08-11 09:33:51'),
(36, '21', ' Extension', 1, '2022-08-11 09:34:04'),
(37, '21', ' Other', 1, '2022-08-11 09:34:18'),
(38, '22', ' Pillar', 1, '2022-08-11 09:34:51'),
(39, '22', ' Steps', 1, '2022-08-11 09:35:04'),
(40, '22', ' Other', 1, '2022-08-11 09:35:22'),
(41, '23', ' Window or door installation / replacement', 1, '2022-08-11 09:36:00'),
(42, '23', ' Wall removal', 1, '2022-08-11 09:36:24'),
(43, '23', ' Other', 1, '2022-08-11 09:36:43'),
(44, '24', ' Brickwork', 1, '2022-08-11 09:37:21'),
(45, '24', ' Natural stone', 1, '2022-08-11 09:37:37'),
(46, '25', ' Removal', 1, '2022-08-11 09:38:03'),
(47, '25', ' Rebuilding / major alterations', 1, '2022-08-11 09:38:23'),
(48, '25', ' Repointing / repair', 1, '2022-08-11 09:38:36'),
(49, '25', ' Other', 1, '2022-08-11 09:39:08'),
(50, '26', ' Small repair', 1, '2022-08-11 09:39:35'),
(51, '26', ' Medium repair', 1, '2022-08-11 09:39:49'),
(52, '26', ' Large repair', 1, '2022-08-11 09:40:03'),
(53, '27', ' Doors', 1, '2022-08-11 09:41:00'),
(54, '27', 'Windows', 1, '2022-08-11 09:41:24'),
(55, '27', ' Floors', 1, '2022-08-11 09:41:54'),
(56, '27', ' Skirting &amp; Architraves', 1, '2022-08-11 09:42:10'),
(57, '27', ' Several of the above', 1, '2022-08-11 09:42:23'),
(58, '28', ' I need furniture made (custom / bespoke)', 1, '2022-08-11 09:42:55'),
(59, '28', ' I need furniture assembled (Ikea, etc.)', 1, '2022-08-11 09:43:10'),
(60, '28', ' I need furniture repaired', 1, '2022-08-11 09:43:29'),
(61, '29', ' Fit wooden worktop', 1, '2022-08-11 09:43:56'),
(62, '29', ' Repair wooden worktop', 1, '2022-08-11 09:44:09'),
(63, '29', ' Install kitchen units', 1, '2022-08-11 09:44:26'),
(64, '29', ' Build custom kitchen units', 1, '2022-08-11 09:44:40'),
(65, '29', ' Repair / adjust kitchen units', 1, '2022-08-11 09:45:03'),
(66, '30', ' Build a new deck', 1, '2022-08-11 09:45:48'),
(67, '30', ' Repair existing deck', 1, '2022-08-11 09:46:32'),
(68, '31', ' Boxing-in', 1, '2022-08-11 09:46:57'),
(69, '31', ' Loft hatches', 1, '2022-08-11 09:47:17'),
(70, '31', ' Outdoor structure', 1, '2022-08-11 09:47:34'),
(71, '31', ' Roof', 1, '2022-08-11 09:47:56'),
(72, '31', ' Shelving', 1, '2022-08-11 09:48:18'),
(73, '31', ' Skirting &amp; Architraves', 1, '2022-08-11 09:48:53'),
(74, '31', ' Stud walls', 1, '2022-08-11 09:49:15'),
(75, '31', ' Stairs / handrails', 1, '2022-08-11 09:49:32'),
(76, '32', ' Carpet', 1, '2022-08-11 09:51:20'),
(77, '32', ' Linoleum (vinyl roll)', 1, '2022-08-11 09:52:57'),
(78, '32', ' Laminate', 1, '2022-08-11 09:53:27'),
(79, '32', ' Luxury vinyl tile (LVT)', 1, '2022-08-11 09:53:54'),
(80, '32', ' Tiled', 1, '2022-08-11 09:54:08'),
(81, '32', 'Engineered', 1, '2022-08-11 09:54:27'),
(82, '32', ' Solid wood', 1, '2022-08-11 09:54:39'),
(83, '32', ' Parquet', 1, '2022-08-11 09:54:50'),
(84, '32', ' Other', 1, '2022-08-11 09:55:06'),
(85, '33', 'Engineered', 1, '2022-08-11 09:55:46'),
(86, '33', ' Solid wood', 1, '2022-08-11 09:55:58'),
(87, '33', ' Parquet', 1, '2022-08-11 09:56:08'),
(88, '33', ' Other', 1, '2022-08-11 09:56:24'),
(89, '34', 'Carpet', 1, '2022-08-11 09:57:06'),
(90, '34', ' Linoleum (vinyl roll)', 1, '2022-08-11 09:57:20'),
(91, '34', ' Laminate', 1, '2022-08-11 09:57:31'),
(92, '34', ' Tiled', 1, '2022-08-11 09:57:55'),
(93, '34', ' Engineered', 1, '2022-08-11 09:58:04'),
(94, '34', ' Solid wood', 1, '2022-08-11 09:58:14'),
(95, '34', ' Parquet', 1, '2022-08-11 09:58:23'),
(96, '34', 'Other', 1, '2022-08-11 09:58:40'),
(97, '36', ' Gas', 1, '2022-08-11 09:59:17'),
(98, '36', 'Oil', 1, '2022-08-11 09:59:31'),
(99, '36', ' Electric', 1, '2022-08-11 09:59:39'),
(100, '36', ' Other or I\'m not sure', 1, '2022-08-11 09:59:49'),
(101, '37', 'Gas', 1, '2022-08-11 10:00:31'),
(102, '37', 'Water', 1, '2022-08-11 10:00:41'),
(103, '37', ' Other or I\'m not sure', 1, '2022-08-11 10:00:48'),
(104, '38', ' Minor issue (e.g. leaking, bleeding, banging)', 1, '2022-08-11 10:01:23'),
(105, '38', ' Moving or replacing', 1, '2022-08-11 10:01:37'),
(106, '38', 'Other', 1, '2022-08-11 10:01:46'),
(107, '53', 'Detailing', 1, '2022-08-11 10:02:34'),
(108, '87', ' Boiler supplied (wet)', 1, '2022-08-11 10:02:57'),
(109, '87', 'Electrical (dry)', 1, '2022-08-11 10:03:11'),
(110, '88', 'Gas', 1, '2022-08-11 10:03:48'),
(111, '88', ' Electric', 1, '2022-08-11 10:03:54'),
(112, '88', 'Oil', 1, '2022-08-11 10:04:02'),
(113, '89', 'Gas', 1, '2022-08-11 10:06:52'),
(114, '89', ' Electric', 1, '2022-08-11 10:07:01'),
(115, '89', 'Oil', 1, '2022-08-11 10:07:08'),
(116, '90', ' Capping', 1, '2022-08-11 10:07:42'),
(117, '90', ' Sweeping', 1, '2022-08-11 10:07:53'),
(118, '90', 'Removal', 1, '2022-08-11 10:08:22'),
(119, '90', ' Rebuilding / major alterations', 1, '2022-08-11 10:08:28'),
(120, '90', ' Repointing / repair', 1, '2022-08-11 10:08:40'),
(121, '90', ' Other', 1, '2022-08-11 10:08:52'),
(122, '91', 'Gas', 1, '2022-08-11 10:09:18'),
(123, '91', 'Electric', 1, '2022-08-11 10:09:30'),
(124, '91', ' Solid fuel (wood, coal burning stove etc.)', 1, '2022-08-11 10:09:37'),
(125, '92', ' Installation or alteration', 1, '2022-08-11 10:10:03'),
(126, '92', 'Repair', 1, '2022-08-11 10:10:16'),
(127, '93', 'Detailing', 1, '2022-08-11 10:10:48'),
(128, '94', ' Build the conservatory and base', 1, '2022-08-11 10:11:14'),
(129, '94', ' Erect conservatory only', 1, '2022-08-11 10:11:24'),
(130, '94', ' Build base only', 1, '2022-08-11 10:11:35'),
(131, '95', ' Roof replacement', 1, '2022-08-11 10:12:16'),
(132, '95', ' Windows and doors replacement', 1, '2022-08-11 10:12:28'),
(133, '95', ' Large refurbishment of existing conservatory', 1, '2022-08-11 10:12:39'),
(134, '96', 'Leak', 1, '2022-08-11 10:13:16'),
(135, '96', 'Roof', 1, '2022-08-11 10:13:33'),
(136, '96', ' Faulty door or windows', 1, '2022-08-11 10:13:39'),
(137, '96', ' Broken glass', 1, '2022-08-11 10:13:48'),
(138, '96', 'Other', 1, '2022-08-11 10:13:58'),
(139, '97', ' Loft conversion with structural changes', 1, '2022-08-11 10:14:43'),
(140, '97', ' Loft conversion (no structural changes)', 1, '2022-08-11 10:14:56'),
(141, '97', ' Loft conversion for storage purposes', 1, '2022-08-11 10:15:08'),
(142, '97', 'Fit a skylight', 1, '2022-08-11 10:15:30'),
(143, '98', ' Single room conversion', 1, '2022-08-11 10:15:51'),
(144, '98', ' Small garage / outbuilding conversion', 1, '2022-08-11 10:16:00'),
(145, '98', ' Multiple rooms or large outbuilding', 1, '2022-08-11 10:16:11'),
(146, '98', ' Whole property conversion', 1, '2022-08-11 10:16:20'),
(147, '99', ' Window or door installation / replacement', 1, '2022-08-11 10:16:46'),
(148, '99', 'Wall removal', 1, '2022-08-11 10:17:07'),
(149, '99', 'Other', 1, '2022-08-11 10:17:15'),
(150, '100', 'Yes', 1, '2022-08-11 10:17:46'),
(151, '100', ' I will - purchase in progress', 1, '2022-08-11 10:17:53'),
(152, '100', 'No - I\'m posting on behalf of the property owner', 1, '2022-08-11 10:18:06'),
(153, '100', ' It\'s a commercial property', 1, '2022-08-11 10:18:20'),
(154, '101', 'Detailing', 1, '2022-08-11 10:18:54'),
(155, '102', ' Small isolated area', 1, '2022-08-11 10:19:26'),
(156, '102', ' Widespread', 1, '2022-08-11 10:19:35'),
(157, '102', ' I’m not sure', 1, '2022-08-11 10:19:45'),
(158, '103', ' Small van or car load', 1, '2022-08-11 10:20:39'),
(159, '103', ' Medium van load', 1, '2022-08-11 10:20:56'),
(160, '103', ' Medium van load', 1, '2022-08-11 10:21:06'),
(161, '103', ' Full site clearance or more', 1, '2022-08-11 10:21:16'),
(162, '104', 'Small', 1, '2022-08-11 10:21:47'),
(163, '104', ' Medium', 1, '2022-08-11 10:21:53'),
(164, '104', 'Large', 1, '2022-08-11 10:22:10'),
(165, '104', 'X-Large', 1, '2022-08-11 10:22:19'),
(166, '105', 'Stud wall', 1, '2022-08-11 10:22:46'),
(167, '105', ' Non-load bearing wall', 1, '2022-08-11 10:22:53'),
(168, '105', ' Load bearing wall', 1, '2022-08-11 10:23:04'),
(169, '106', ' Block paving', 1, '2022-08-11 10:23:59'),
(170, '106', ' Gravel', 1, '2022-08-11 10:24:10'),
(171, '106', ' Concrete', 1, '2022-08-11 10:24:20'),
(172, '106', ' Tarmac or Resin', 1, '2022-08-11 10:24:27'),
(173, '106', 'Other', 1, '2022-08-11 10:24:39'),
(174, '106', ' I\'m not sure - need help deciding', 1, '2022-08-11 10:24:46'),
(175, '107', 'Detailing', 1, '2022-08-11 10:25:24'),
(176, '108', ' Yes, permission granted', 1, '2022-08-11 10:25:56'),
(177, '108', 'No', 1, '2022-08-11 10:26:05'),
(178, '109', ' Block paving', 1, '2022-08-11 10:26:50'),
(179, '109', ' Gravel', 1, '2022-08-11 10:27:00'),
(180, '109', ' Concrete', 1, '2022-08-11 10:27:10'),
(181, '109', ' Tarmac or Resin', 1, '2022-08-11 10:27:23'),
(182, '109', ' Other or I\'m not sure', 1, '2022-08-11 10:27:34'),
(183, '110', ' Lay or replace a patio', 1, '2022-08-11 10:27:56'),
(184, '110', ' Lay or replace a pathway', 1, '2022-08-11 10:28:06'),
(185, '110', ' Repair paving, pathway or patio', 1, '2022-08-11 10:28:32'),
(186, '111', ' Part of my property', 1, '2022-08-11 10:30:31'),
(187, '111', ' Entire property', 1, '2022-08-11 10:30:45'),
(188, '112', ' Fusebox replacement - in the same location', 1, '2022-08-11 10:31:07'),
(189, '112', ' Fusebox replacement - in a different location', 1, '2022-08-11 10:31:20'),
(190, '112', ' Brand new fusebox installation', 1, '2022-08-11 10:31:32'),
(191, '112', 'Other', 1, '2022-08-11 10:31:42'),
(192, '113', ' Electrical fittings', 1, '2022-08-11 10:32:04'),
(193, '113', 'Appliances', 1, '2022-08-11 10:32:21'),
(194, '113', ' Security systems', 1, '2022-08-11 10:32:31'),
(195, '113', ' Boilers &amp; heating', 1, '2022-08-11 10:32:40'),
(196, '114', ' Single appliance', 1, '2022-08-11 10:33:05'),
(197, '114', ' Multiple appliances or full property', 1, '2022-08-11 10:33:16'),
(198, '114', 'Commercial property', 1, '2022-08-11 10:33:27'),
(199, '115', 'Simple', 1, '2022-08-11 10:33:58'),
(200, '115', ' Complex', 1, '2022-08-11 10:34:04'),
(201, '116', 'Detailing', 1, '2022-08-11 10:34:31'),
(202, '117', ' I am ready / almost ready for the work to start', 1, '2022-08-11 10:35:22'),
(203, '117', ' I need help with design or planning before starti', 1, '2022-08-11 10:35:31'),
(204, '117', ' I\'m not ready to build yet, I am still exploring ', 1, '2022-08-11 10:36:04'),
(205, '118', ' Loft conversion with structural changes', 1, '2022-08-11 10:36:27'),
(206, '118', ' Loft conversion (no structural changes)', 1, '2022-08-11 10:37:31'),
(207, '118', ' Loft conversion for storage purposes', 1, '2022-08-11 10:37:41'),
(208, '118', ' Fit a skylight', 1, '2022-08-11 10:38:07'),
(209, '119', ' Just a new porch', 1, '2022-08-11 10:38:44'),
(210, '119', ' I need a new porch and some additional works', 1, '2022-08-11 10:39:40'),
(211, '120', 'Yes', 1, '2022-08-11 10:40:06'),
(212, '120', ' I will - purchase in progress', 1, '2022-08-11 10:40:11'),
(213, '120', 'No', 1, '2022-08-11 10:40:23'),
(214, '121', 'Yes', 1, '2022-08-11 10:40:51'),
(215, '121', ' I will - purchase in progress', 1, '2022-08-11 10:40:57'),
(216, '121', 'No', 1, '2022-08-11 10:41:04'),
(217, '122', 'Detailing', 1, '2022-08-11 10:41:36'),
(218, '123', ' Install / replace', 1, '2022-08-12 03:26:30'),
(219, '123', ' Repair (e.g. leak)', 1, '2022-08-12 03:26:42'),
(220, '123', ' Cleaning / blockages', 1, '2022-08-12 03:26:52'),
(221, '124', ' Install / replace', 1, '2022-08-12 03:27:26'),
(222, '124', ' Repair', 1, '2022-08-12 03:27:39'),
(223, '125', ' Install/replace', 1, '2022-08-12 03:27:58'),
(224, '125', 'Repair', 1, '2022-08-12 03:28:07'),
(225, '126', ' Hire and pay securely through MyBuilder.', 1, '2022-08-12 03:28:45'),
(226, '126', ' Arrange the job and pay the tradesperson directly', 1, '2022-08-12 03:28:55'),
(227, '127', '1', 1, '2022-08-12 03:29:22'),
(228, '127', '2', 1, '2022-08-12 03:29:27'),
(229, '127', '3 or more', 1, '2022-08-12 03:29:37'),
(230, '127', ' Made to measure gate', 1, '2022-08-12 03:29:43'),
(231, '128', ' Panel fence', 1, '2022-08-12 03:30:06'),
(232, '128', ' Feather edge fence', 1, '2022-08-12 03:30:15'),
(233, '128', 'Other', 1, '2022-08-12 03:30:28'),
(234, '129', ' Minor repair', 1, '2022-08-12 03:30:53'),
(235, '129', ' Larger repair', 1, '2022-08-12 03:31:03'),
(236, '130', ' One-off small gardening job', 1, '2022-08-12 03:31:38'),
(237, '130', ' One-off large gardening job', 1, '2022-08-12 03:31:48'),
(238, '130', ' Small ongoing garden maintenance', 1, '2022-08-12 03:31:58'),
(239, '130', ' Large ongoing garden maintenance', 1, '2022-08-12 03:32:15'),
(240, '131', ' Garden repairs', 1, '2022-08-12 03:32:31'),
(241, '131', ' Add or replace elements', 1, '2022-08-12 03:32:40'),
(242, '131', ' Garden renovation / landscaping proj', 1, '2022-08-12 03:32:51'),
(243, '132', ' Trimming or topping', 1, '2022-08-12 03:33:09'),
(244, '132', ' Cutting down (felling)', 1, '2022-08-12 03:33:18'),
(245, '132', ' Stump removal only', 1, '2022-08-12 03:33:30'),
(246, '132', ' Diagnosis / Assessment', 1, '2022-08-12 03:33:37'),
(247, '132', ' Bushes, or other gardening tasks', 1, '2022-08-12 03:33:50'),
(248, '132', 'Other', 1, '2022-08-12 03:33:58'),
(249, '133', ' Boiler', 1, '2022-08-12 03:34:30'),
(250, '133', ' Single appliance', 1, '2022-08-12 03:34:38'),
(251, '133', ' Multiple appliances', 1, '2022-08-12 03:34:48'),
(252, '134', 'Boiler', 1, '2022-08-12 03:35:15'),
(253, '134', ' Single appliance', 1, '2022-08-12 03:35:22'),
(254, '134', ' Multiple appliances', 1, '2022-08-12 03:35:33'),
(255, '135', ' Gas boiler', 1, '2022-08-12 03:36:03'),
(256, '135', ' Gas hob or oven', 1, '2022-08-12 03:36:11'),
(257, '135', ' Other or several of the above', 1, '2022-08-12 03:36:20'),
(258, '136', 'Yes', 1, '2022-08-12 03:36:48'),
(259, '136', 'No', 1, '2022-08-12 03:36:55'),
(260, '137', ' Disconnect or cap pipework', 1, '2022-08-12 03:37:09'),
(261, '137', ' Install or alter pipework', 1, '2022-08-12 03:37:18'),
(262, '137', 'Other', 1, '2022-08-12 03:37:25'),
(263, '138', 'Boiler', 1, '2022-08-12 03:37:48'),
(264, '138', ' Gas hob or oven', 1, '2022-08-12 03:37:53'),
(265, '138', ' Gas fireplace', 1, '2022-08-12 03:38:01'),
(266, '138', 'Other', 1, '2022-08-12 03:38:09'),
(267, '139', ' Domestic property', 1, '2022-08-12 03:38:28'),
(268, '139', ' Commercial property', 1, '2022-08-12 03:38:36'),
(269, '140', 'New house', 1, '2022-08-12 03:39:38'),
(270, '140', ' House extension', 1, '2022-08-12 03:39:44'),
(271, '140', ' Outbuilding or garage', 1, '2022-08-12 03:39:53'),
(272, '140', 'Shed', 1, '2022-08-12 03:39:59'),
(273, '140', 'Other', 1, '2022-08-12 03:40:11'),
(274, '141', 'Detailing', 1, '2022-08-12 03:40:31'),
(275, '142', 'Detailing', 1, '2022-08-12 03:40:45'),
(276, '143', 'Detailing', 1, '2022-08-12 03:41:04'),
(277, '144', ' Fixtures / fittings', 1, '2022-08-12 03:41:30'),
(278, '144', ' Furniture assembling', 1, '2022-08-12 03:41:39'),
(279, '144', ' Shed assembling', 1, '2022-08-12 03:41:47'),
(280, '144', ' Cleaning / powerwashing', 1, '2022-08-12 03:41:56'),
(281, '144', ' Carpentry / joinery', 1, '2022-08-12 03:42:08'),
(282, '144', ' Various small tasks', 1, '2022-08-12 03:42:17'),
(283, '144', 'Repairs', 1, '2022-08-12 03:42:26'),
(284, '144', 'Other', 1, '2022-08-12 03:42:35'),
(285, '145', 'Detailing', 1, '2022-08-12 03:43:09'),
(286, '146', '1 Wall', 1, '2022-08-12 03:43:38'),
(287, '146', ' Several walls', 1, '2022-08-12 03:43:42'),
(288, '146', ' Whole house', 1, '2022-08-12 03:43:50'),
(289, '147', ' 1 - 2 rooms', 1, '2022-08-12 03:44:15'),
(290, '147', ' 3 - 4 rooms', 1, '2022-08-12 03:44:23'),
(291, '147', ' 5+ rooms', 1, '2022-08-12 03:44:42'),
(292, '148', 'Detailing', 1, '2022-08-12 03:45:01'),
(293, '149', ' Extensive kitchen refurb', 1, '2022-08-12 03:46:54'),
(294, '149', ' Standard kitchen refit', 1, '2022-08-12 03:47:02'),
(296, '149', 'Other', 1, '2022-08-12 03:48:09'),
(297, '150', ' Natural stone', 1, '2022-08-12 03:48:33'),
(298, '150', ' Composite', 1, '2022-08-12 03:48:42'),
(299, '150', ' Solid wood', 1, '2022-08-12 03:48:53'),
(300, '150', ' Laminate', 1, '2022-08-12 03:49:01'),
(301, '150', 'Other', 1, '2022-08-12 03:49:21'),
(302, '150', ' Not sure - need help deciding', 1, '2022-08-12 03:49:26'),
(303, '151', 'Detailing', 1, '2022-08-12 03:49:45'),
(304, '152', ' Gas / dual-fuel cooker / oven', 1, '2022-08-12 03:50:01'),
(305, '152', 'Electric cooker / oven', 1, '2022-08-12 03:50:13'),
(306, '152', ' Washing machine', 1, '2022-08-12 03:50:21'),
(307, '152', ' Dishwasher', 1, '2022-08-12 03:50:28'),
(308, '152', ' Sink', 1, '2022-08-12 03:50:37'),
(309, '152', 'Other', 1, '2022-08-12 03:50:44'),
(310, '153', 'Detailing', 1, '2022-08-12 03:51:06'),
(311, '154', 'Detailing', 1, '2022-08-12 03:51:25'),
(312, '155', 'Detailing', 1, '2022-08-12 03:51:45'),
(313, '155', '1 lock', 1, '2022-08-12 03:52:18'),
(314, '155', '2 locks', 1, '2022-08-12 03:52:25'),
(315, '155', ' 3 or more locks', 1, '2022-08-12 03:52:31'),
(316, '156', 'Detailing', 1, '2022-08-12 03:52:49'),
(317, '157', 'Detailing', 1, '2022-08-12 03:53:03'),
(318, '158', ' Detached', 1, '2022-08-12 03:53:39'),
(319, '158', ' Semi-detached', 1, '2022-08-12 03:53:50'),
(320, '158', ' Terraced', 1, '2022-08-12 03:54:02'),
(321, '158', ' End of Terrace', 1, '2022-08-12 03:54:10'),
(322, '158', ' Bungalow', 1, '2022-08-12 03:54:18'),
(323, '158', 'Other', 1, '2022-08-12 03:54:25'),
(324, '159', ' Detached', 1, '2022-08-12 03:54:56'),
(325, '159', ' Semi-detached', 1, '2022-08-12 03:55:04'),
(326, '159', ' Terraced', 1, '2022-08-12 03:55:13'),
(327, '159', 'End of Terraced', 1, '2022-08-12 03:55:34'),
(328, '159', 'Other', 1, '2022-08-12 03:55:45'),
(329, '159', ' Bungalow', 1, '2022-08-12 03:55:52'),
(330, '160', ' Board out loft', 1, '2022-08-12 03:56:47'),
(331, '160', ' Boarding plus additional work', 1, '2022-08-12 03:56:56'),
(332, '161', 'Detailing', 1, '2022-08-12 03:57:17'),
(333, '162', ' In progress', 1, '2022-08-12 03:57:57'),
(334, '162', ' Yes', 1, '2022-08-12 03:58:21'),
(335, '162', ' Not applied for yet', 1, '2022-08-12 03:58:27'),
(336, '163', 'Yes', 1, '2022-08-12 03:58:47'),
(337, '163', ' In progress', 1, '2022-08-12 03:59:00'),
(338, '163', ' Not applied for yet', 1, '2022-08-12 03:59:05'),
(339, '164', 'Yes', 1, '2022-08-12 03:59:25'),
(340, '164', 'In progress', 1, '2022-08-12 03:59:41'),
(341, '164', ' Not applied for yet', 1, '2022-08-12 03:59:48'),
(342, '165', ' Part of a room', 1, '2022-08-12 04:02:10'),
(343, '165', '1 room', 1, '2022-08-12 04:02:26'),
(344, '165', '2 rooms', 1, '2022-08-12 04:02:35'),
(345, '165', '3 rooms', 1, '2022-08-12 04:02:43'),
(346, '165', '4 rooms', 1, '2022-08-12 04:02:50'),
(347, '165', '5+ rooms', 1, '2022-08-12 04:03:00'),
(348, '166', ' Exterior walls', 1, '2022-08-12 04:03:26'),
(349, '166', ' Windows &amp; doors', 1, '2022-08-12 04:03:34'),
(350, '166', ' Fascias &amp; soffits', 1, '2022-08-12 04:03:45'),
(351, '166', ' Other or several of the above', 1, '2022-08-12 04:03:54'),
(352, '167', ' Part of a room', 1, '2022-08-12 04:04:12'),
(353, '167', '1 room', 1, '2022-08-12 04:04:44'),
(354, '167', '2 rooms', 1, '2022-08-12 04:04:50'),
(355, '167', '3 rooms', 1, '2022-08-12 04:04:56'),
(356, '167', '4 rooms', 1, '2022-08-12 04:05:02'),
(357, '167', '5+ rooms', 1, '2022-08-12 04:05:11'),
(358, '168', ' Skim only', 1, '2022-08-12 04:05:44'),
(359, '168', ' Plasterboard and skim', 1, '2022-08-12 04:05:54'),
(360, '168', ' Other or I don\'t know', 1, '2022-08-12 04:06:02'),
(361, '169', ' Exterior of house', 1, '2022-08-12 04:06:21'),
(362, '169', ' Garden wall(s)', 1, '2022-08-12 04:06:30'),
(363, '170', ' Minor issue (e.g. leaking, bleeding, banging)', 1, '2022-08-12 04:07:26'),
(364, '170', ' Moving or replacing', 1, '2022-08-12 04:07:35'),
(365, '170', 'Other', 1, '2022-08-12 04:07:42'),
(366, '171', 'Gas', 1, '2022-08-12 04:08:05'),
(367, '171', 'Oil', 1, '2022-08-12 04:08:13'),
(368, '171', 'Electric', 1, '2022-08-12 04:08:25'),
(369, '171', ' Other or I\'m not sure', 1, '2022-08-12 04:08:29'),
(370, '172', '1 item', 1, '2022-08-12 04:09:08'),
(371, '172', '2 or 3 items', 1, '2022-08-12 04:09:20'),
(372, '172', ' 4 or more items', 1, '2022-08-12 04:09:26'),
(373, '173', ' Install or replace', 1, '2022-08-12 04:09:54'),
(374, '173', 'Repair', 1, '2022-08-12 04:10:02'),
(375, '174', 'Yes', 1, '2022-08-12 04:10:26'),
(376, '174', 'No', 1, '2022-08-12 04:10:32'),
(377, '175', 'Yes', 1, '2022-08-12 04:11:27'),
(378, '175', 'No', 1, '2022-08-12 04:11:34'),
(379, '176', ' Pitched roof', 1, '2022-08-12 04:12:22'),
(380, '176', ' Flat roof', 1, '2022-08-12 04:12:32'),
(381, '176', ' I\'m not sure', 1, '2022-08-12 04:12:41'),
(382, '177', ' Pitched roof', 1, '2022-08-12 04:12:59'),
(383, '177', 'Flat roof', 1, '2022-08-12 04:13:14'),
(384, '177', 'Other', 1, '2022-08-12 04:13:22'),
(385, '178', ' Install or rebuild new chimney', 1, '2022-08-12 04:13:43'),
(386, '178', ' Remove an existing chimney', 1, '2022-08-12 04:13:52'),
(387, '178', ' Repair or repoint my chimney', 1, '2022-08-12 04:14:04'),
(388, '178', ' Chimney capping', 1, '2022-08-12 04:14:13'),
(389, '178', 'Other', 1, '2022-08-12 04:14:27'),
(390, '179', 'Detailing', 1, '2022-08-12 04:14:47'),
(391, '180', ' Installation', 1, '2022-08-12 04:15:09'),
(392, '180', 'Service repair', 1, '2022-08-12 04:15:18'),
(393, '180', ' Removal', 1, '2022-08-12 04:15:27'),
(394, '180', 'Other', 1, '2022-08-12 04:15:35'),
(395, '181', ' Installation', 1, '2022-08-12 04:15:54'),
(396, '181', 'Service repair', 1, '2022-08-12 04:16:01'),
(397, '181', 'Removal', 1, '2022-08-12 04:16:24'),
(398, '181', 'Other', 1, '2022-08-12 04:16:34'),
(399, '182', 'Detailing', 1, '2022-08-12 04:17:48'),
(400, '183', 'Detailing', 1, '2022-08-12 04:18:05'),
(401, '184', 'Detailing', 1, '2022-08-12 04:18:33'),
(402, '185', 'Detailing', 1, '2022-08-12 04:18:41'),
(403, '186', 'Detailing', 1, '2022-08-12 04:18:56'),
(404, '187', ' Ashlar', 1, '2022-08-12 04:19:35'),
(405, '187', ' Random rubble', 1, '2022-08-12 04:19:47'),
(406, '187', ' Dry stone', 1, '2022-08-12 04:19:56'),
(407, '187', ' Other / I\'m not sure', 1, '2022-08-12 04:20:05'),
(408, '188', ' Ashlar', 1, '2022-08-12 04:20:37'),
(409, '188', ' Random rubble', 1, '2022-08-12 04:20:46'),
(410, '188', ' Dry stone', 1, '2022-08-12 04:20:56'),
(411, '188', ' Other / I\'m not sure', 1, '2022-08-12 04:21:10'),
(412, '189', ' Ashlar', 1, '2022-08-12 04:21:39'),
(413, '189', ' Random rubble', 1, '2022-08-12 04:21:47'),
(414, '189', ' Other / I\'m not sure', 1, '2022-08-12 04:21:56'),
(415, '190', 'Detailing', 1, '2022-08-12 04:22:12'),
(416, '191', ' Less than 2m²', 1, '2022-08-12 04:23:14'),
(417, '191', ' 2 - 14m²', 1, '2022-08-12 04:23:22'),
(418, '191', ' 15 - 30m²', 1, '2022-08-12 04:23:30'),
(419, '191', ' 31 - 50m²', 1, '2022-08-12 04:23:37'),
(420, '191', ' Over 50m²', 1, '2022-08-12 04:23:45'),
(421, '191', ' Commercial or project', 1, '2022-08-12 04:23:56'),
(422, '191', ' I don\'t know', 1, '2022-08-12 04:24:04'),
(423, '192', ' Small (less than 2m²)', 1, '2022-08-12 04:24:21'),
(424, '192', ' Large (2m² or more)', 1, '2022-08-12 04:24:29'),
(425, '193', ' Extra small', 1, '2022-08-12 04:24:51'),
(426, '193', 'Small', 1, '2022-08-12 04:25:00'),
(427, '193', 'Medium', 1, '2022-08-12 04:25:17'),
(428, '193', 'Large', 1, '2022-08-12 04:25:28'),
(429, '193', 'Extra large', 1, '2022-08-12 04:25:52'),
(430, '193', ' Project or commercial', 1, '2022-08-12 04:25:57'),
(431, '194', '1', 1, '2022-08-12 04:26:27'),
(432, '194', '2', 1, '2022-08-12 04:26:32'),
(433, '194', '3', 1, '2022-08-12 04:26:37'),
(434, '194', ' 4 or more', 1, '2022-08-12 04:26:46'),
(435, '195', '1', 1, '2022-08-12 04:27:05'),
(436, '195', '2', 1, '2022-08-12 04:27:11'),
(437, '195', ' 3 or more', 1, '2022-08-12 04:27:19'),
(438, '196', ' 1-2 stumps', 1, '2022-08-12 04:27:45'),
(439, '196', '3+ stumps', 1, '2022-08-12 04:27:54'),
(440, '197', 'Detailing', 1, '2022-08-12 04:28:15'),
(441, '198', 'Detailing', 1, '2022-08-12 04:28:32'),
(442, '199', 'Detailing', 1, '2022-08-12 04:28:49'),
(443, '200', ' Wooden', 1, '2022-08-12 04:29:33'),
(444, '200', ' uPVC', 1, '2022-08-12 04:29:42'),
(445, '200', ' Aluminium', 1, '2022-08-12 04:29:50'),
(446, '200', 'Other', 1, '2022-08-12 04:30:00'),
(447, '201', ' Internal doors', 1, '2022-08-12 04:30:28'),
(448, '201', ' External doors', 1, '2022-08-12 04:30:40'),
(449, '202', ' Wooden', 1, '2022-08-12 04:31:12'),
(450, '202', 'uPVC', 1, '2022-08-12 04:31:30'),
(451, '202', ' Aluminium', 1, '2022-08-12 04:31:38'),
(452, '202', 'Other', 1, '2022-08-12 04:31:46'),
(453, '203', '1', 1, '2022-08-12 04:32:02'),
(454, '203', '2 - 3', 1, '2022-08-12 04:32:11'),
(455, '203', ' 4 or more', 1, '2022-08-12 04:32:17'),
(456, '204', 'Wooden', 1, '2022-08-12 04:32:55'),
(457, '204', ' uPVC or metal', 1, '2022-08-12 04:33:00'),
(458, '205', 'Detailing', 1, '2022-08-12 04:33:18'),
(459, '206', ' I understand', 1, '2022-08-12 04:33:45'),
(460, '207', ' I understand', 1, '2022-08-12 04:34:23'),
(461, '208', ' Loft conversion', 1, '2022-08-12 04:34:44'),
(462, '208', ' Converting an existing space', 1, '2022-08-12 04:34:53'),
(463, '208', ' Wall alteration', 1, '2022-08-12 04:35:07'),
(464, '208', ' Restoring or improving existing space', 1, '2022-08-12 04:35:17'),
(465, '209', 'Detailing', 1, '2022-08-12 04:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `apply_job`
--

CREATE TABLE `apply_job` (
  `id` int(5) NOT NULL,
  `job_id` int(4) NOT NULL,
  `job_location` varchar(150) DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT 0,
  `worker_status` int(5) NOT NULL DEFAULT 0,
  `employer_status` int(5) NOT NULL DEFAULT 0,
  `rating` int(11) NOT NULL DEFAULT 0,
  `apply_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `send_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `file_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_gallery`
--

CREATE TABLE `jobs_gallery` (
  `id` int(10) NOT NULL,
  `job_id` int(10) NOT NULL,
  `file_type` varchar(30) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE `main_category` (
  `id` int(6) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`id`, `category_name`, `status`, `create_date`) VALUES
(6, 'Architectural Services', 1, '2022-06-27 05:30:09'),
(7, 'Bathroom Fitting', 1, '2022-06-27 05:30:38'),
(8, 'Bricklaying &amp; Repointing', 1, '2022-06-27 05:31:17'),
(9, 'Carpentry &amp; Joinery', 1, '2022-06-27 05:33:13'),
(10, 'Carpets, Lino &amp; Flooring', 1, '2022-06-27 05:33:28'),
(11, 'Central Heating', 1, '2022-06-27 05:33:39'),
(12, 'Chimney &amp; Fireplace', 1, '2022-06-27 05:33:49'),
(13, 'Conservatories', 1, '2022-06-27 05:33:55'),
(14, 'Conversions', 1, '2022-06-27 05:34:05'),
(15, 'Damp Proofing', 1, '2022-06-27 05:34:13'),
(16, 'Demolition &amp; Clearance', 1, '2022-06-27 05:34:20'),
(17, 'Driveways &amp; Paving', 1, '2022-06-27 05:34:26'),
(18, 'Electrical', 1, '2022-06-27 05:34:32'),
(19, 'Extensions', 1, '2022-06-27 05:34:37'),
(20, 'Fascias, Soffits &amp; Guttering', 1, '2022-06-27 05:34:43'),
(21, 'Fencing', 1, '2022-06-27 05:34:48'),
(22, 'Gardening &amp; Landscaping', 1, '2022-06-27 05:34:54'),
(23, 'Gas Work', 1, '2022-06-27 05:34:59'),
(24, 'Groundwork &amp; Foundations', 1, '2022-06-27 05:35:05'),
(25, 'Handyman', 1, '2022-06-27 05:36:10'),
(26, 'Insulation', 1, '2022-06-27 05:36:17'),
(27, 'Kitchen Fitting', 1, '2022-06-27 05:36:44'),
(28, 'Locksmith', 1, '2022-06-27 05:37:00'),
(29, 'Loft Conversions', 1, '2022-06-27 05:37:06'),
(30, 'New Build', 1, '2022-06-27 05:37:11'),
(31, 'Painting &amp; Decorating', 1, '2022-06-27 05:37:17'),
(32, 'Plastering &amp; Rendering', 1, '2022-06-27 05:37:23'),
(33, 'Plumbing', 1, '2022-06-27 05:37:30'),
(34, 'Restoration &amp; Refurbishment', 1, '2022-06-27 05:37:36'),
(35, 'Roofing', 1, '2022-06-27 05:37:40'),
(36, 'Security Systems', 1, '2022-06-27 05:37:45'),
(37, 'Stonemasonry', 1, '2022-06-27 05:37:53'),
(38, 'Tiling', 1, '2022-06-27 05:37:59'),
(39, 'Tree Surgery', 1, '2022-06-27 05:38:04'),
(40, 'Windows &amp; Door Fitting', 1, '2022-06-27 05:38:25'),
(41, 'I\'m not sure which to pick', 1, '2022-06-27 05:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `post_job`
--

CREATE TABLE `post_job` (
  `id` int(6) NOT NULL,
  `user_id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `location` mediumtext DEFAULT NULL,
  `main_type` int(5) DEFAULT NULL,
  `sub_type` int(5) DEFAULT NULL,
  `options` int(5) NOT NULL,
  `file_type` varchar(30) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `looking_to` varchar(50) DEFAULT NULL,
  `how_learge` varchar(55) DEFAULT NULL,
  `job_discription` longtext DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(5) NOT NULL,
  `main_category_id` int(5) NOT NULL,
  `sub_category_id` int(5) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `right_ans` varchar(100) NOT NULL,
  `creat_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `main_category_id`, `sub_category_id`, `question`, `option1`, `option2`, `option3`, `option4`, `right_ans`, `creat_date`) VALUES
(4, 6, 9, 'What are the possible reasons for using this type of bracket?', 'To support sagging gutters', 'FalseNo fascias on the building', 'Using shorter gutters', 'Unusually large eaves', 'To support sagging gutters', '2022-06-27 08:30:02'),
(5, 6, 9, 'You are installing a uPVC guttering system on a house. The design of the eaves requires an offset pipe at an irregular angle. Which of these are viable options for ensuring the system complies with building regulations?', 'Generic connectors are available that can connect the downpipe to the outlet', 'Check whether the guttering system supplier makes adjustable connectors', 'Make custom connectors using generic offset pipes and a fine-toothed saw', 'Run the downpipe further away from the wall using spacers to mount the brackets', 'Generic connectors are available that can connect the downpipe to the outlet', '2022-06-27 08:31:05'),
(6, 6, 9, 'Pick a situation in which you could use an offset.', 'To turn a corner at the bottom of a valley', 'To divert a downpipe away from the wall', 'To run out of a hopper head', 'To run from eaves to the wall', 'To turn a corner at the bottom of a valley', '2022-06-27 08:33:12'),
(7, 6, 9, 'Which of these statements are true about cast aluminium and uPVC guttering systems?', 'Both require putty to seal the joints between sections', 'Both can be supported by brackets', 'Both need regular painting', 'Both are lightweight guttering solutions', 'Both require putty to seal the joints between sections', '2022-06-27 08:34:01'),
(8, 6, 9, 'Which of the following guttering system types can be linked using adapters?', 'Cast-iron and rolled aluminium', 'Plastic and rolled aluminium', 'Two profiles of UPVC', 'None of the above', 'Cast-iron and rolled aluminium', '2022-06-27 08:35:12'),
(9, 6, 9, 'Which of these material requires the LEAST maintenance?', 'Cast iron', 'Cast aluminium', 'Rolled-sheet aluminium', 'uPVC', 'Cast iron', '2022-06-27 08:36:16'),
(10, 25, 144, 'When fitting the sprigs, how do you avoid possible breakage?', 'Hold the hammer in contact with the glazing', 'Use a rubber mallet', 'Use screw-in sprigs', 'Apply protective tape on the glazing', 'Hold the hammer in contact with the glazing', '2022-06-27 08:40:06'),
(11, 25, 144, 'What should you use to apply the back putty to the frame?', 'A trowel', 'A brush', 'Your hands', 'A knife', 'A trowel', '2022-06-27 08:45:22'),
(12, 25, 144, 'When would be the best time to paint over the putty?', 'Immediately after applying it', 'A few hours after applying it', 'A few days after applying it', 'Putty should not be painted over', 'Immediately after applying it', '2022-06-27 08:46:06'),
(13, 25, 144, 'How many panels should be fitted with toughened glass?Select the correct number', '4', '5', '6', '8', '4', '2022-06-27 08:47:02'),
(14, 25, 144, 'How would you fill old hinges recesses?', 'With one layer of filler', 'By plastering over it', 'With expanding foam', 'By scarfing it', 'With one layer of filler', '2022-06-27 08:47:40'),
(15, 25, 144, 'Secondary glazing is Select ALL that apply', 'Cheaper than double glazing', 'More expensive than double glazing', 'Less energy efficient than double glazing', 'More energy efficient than double glazing', 'Cheaper than double glazing', '2022-06-27 08:49:34'),
(16, 25, 144, 'On a fire door, which elements need to offer 30 minutes of fire protection?', 'The frame', 'The lock and latch set', 'Both', 'Neither', 'The frame', '2022-06-27 08:50:31'),
(17, 25, 144, 'Which type of glass is the biggest hazard, when broken?', 'Float glass', 'Toughened glass', 'Safety glass', 'Laminate glass', 'Float glass', '2022-06-27 08:56:09'),
(18, 25, 144, 'A customer is complaining about an old door that is becoming hard to close.  What option are you LEAST likely to recommend?', 'Pack the hinges', 'Trim the door', 'Fit new hinges', 'Replace the door', 'Pack the hinges', '2022-06-27 08:56:51'),
(19, 25, 144, 'When fixing broken sash cords, you should first remove the…', 'Parting bead', 'Pulleys', 'Staff bead', 'Pocket pieces', 'Parting bead', '2022-06-27 08:57:50'),
(21, 7, 0, 'When fitting underfloor heating, where should you fit insulation?', 'Under the heating system', 'Over the heating system', 'Both under and over the heating system', 'Neither under nor over the heating system', 'Neither under nor over the heating system', '2022-08-12 07:52:59'),
(22, 7, 0, 'Which of these statements about tanking is true?', 'Good tiles and grout are all you need to tank a bathroom properly', 'Tanking replaces the need for wall insulation', 'Concrete and plasterboard can both be tanked', 'You can only use a tanking membrane to tank a bathroom', 'You can only use a tanking membrane to tank a bathroom', '2022-08-12 07:54:17'),
(23, 7, 0, 'When applying silicone to seal a bath, which of the following is best practice?', 'Apply the silicone after installing the bath', 'Apply the silicone before the bath is installed', 'Install and clamp bath down, then apply the silicone', 'Install and fill the bath with water, then apply the silicone', 'Install and fill the bath with water, then apply the silicone', '2022-08-12 08:08:07'),
(24, 7, 0, 'A loyal customer wants a tiled shower floor in their bathroom.  You advise fitting a tray instead because the floor timbers are bouncing, but they insist on the tiles. Two months after completion, it starts leaking because of the movement.  What would you', 'Ignore the customer, they didn’t listen to you', 'Acknowledge the customer but don’t rectify the work', 'Fit a tray and cover the material and labour costs', 'Charge them for materials and labour, you told them this could happen', 'Charge them for materials and labour, you told them this could happen', '2022-08-12 08:09:41'),
(25, 8, 0, 'A wall has 20 courses on one end and 19 on the other. What can this be a sign of?', 'There is a nudge in it', 'There is a lift in it', 'There is a boar in it', 'There is a pig in it', 'There is a pig in it', '2022-08-12 08:16:42'),
(26, 8, 0, 'When building a wall, what is the minimum mortar depth for each course?', '4mm', '7mm', '10mm', '12mm', '12mm', '2022-08-12 08:18:06'),
(27, 8, 0, 'Which type of sand would you typically use to make mortar?', 'Kiln dried sand', 'Sharp sand', 'Soft sand', 'Gypsum sand', 'Gypsum sand', '2022-08-12 08:19:35'),
(28, 8, 0, 'After finishing a stepped garden wall job, a customer wants to pay you £200 less because they notice there are roughly 10% bricks left over and you’re not responsible for removing waste.  Which of the following responses would be the most appropriate?', 'It’s an unreasonable demand, they have to pay in full', 'It\'s frustrating but you knock a small token sum off their bill as a good will gesture', 'You empathise with the customer, so you remove the bricks from site as compensation', 'Offer to remove the leftover bricks, and refund the value from the invoic', 'Offer to remove the leftover bricks, and refund the value from the invoic', '2022-08-12 08:21:12'),
(29, 9, 0, 'What step of the build marks the difference between first and second fix?', 'Plastering', 'Window fitting', 'Erecting partition walls', 'Laying the DPC', 'Laying the DPC', '2022-08-12 08:25:40'),
(30, 9, 0, 'Which of these would you NOT use a router for?', 'Cutting grooves', 'Decorative flutings', 'Profile edges', 'Cutting along beveled edges', 'Cutting along beveled edges', '2022-08-12 08:26:54'),
(31, 9, 0, 'You can use softwood for the skirting board.', 'Yes you can', 'Yes, but it will need to be reinforced', 'Yes, but you will need to use preservative', 'No you can’t', 'No you can’t', '2022-08-12 08:28:11'),
(32, 9, 0, 'Which type of wood expands the least?', 'Engineered timber', 'Natural oak', 'Redwood', 'Treated cedar', 'Treated cedar', '2022-08-12 08:29:44'),
(34, 10, 0, '‘Check for flatness and hammer all nails flush’.  This is part of a description of fitting lino. Which part?', 'Preparing the lino for fitting', 'Lapping lino over a step', 'Finishing the lino over a flat floor', 'Preparing the floor surface', 'Preparing the floor surface', '2022-08-12 09:20:26'),
(35, 10, 0, 'Which type of pile is most appropriate for hiding carpet seams?', 'High pile', 'Low pile', 'Both', 'Non of the above', 'Low pile', '2022-08-12 09:22:00'),
(36, 11, 0, 'On an S plan system, the programmer and room stat are off but the boiler is still firing up. What could be the issue?v', 'Room thermostat faulty', 'Zone valve stuck', 'TRVs open', 'Programmer faulty', 'Programmer faulty', '2022-08-12 09:23:53'),
(37, 11, 0, 'If a house is equipped with a hot water cylinder, what type of boiler are you unlikely to find?', 'Combi boiler', 'Heat only boiler', 'System boiler', 'Oil boiler', 'Oil boiler', '2022-08-12 09:24:42'),
(38, 11, 0, 'What option would you recommend to a homeowner who is looking for a cheap and simple electric boiler?', 'Direct acting electric boiler', 'Storage electric boiler', 'Electric CPSU', 'Dry core storage boiler', 'Dry core storage boiler', '2022-08-12 09:25:38'),
(39, 11, 0, 'Which of these is usually not found on a sealed system?', 'Hot water cylinder', 'Pump', 'Motorised valve', 'F &amp; E tank', 'F &amp; E tank', '2022-08-12 09:28:10'),
(40, 11, 0, 'Which of these is usually not found on a sealed system?', 'Hot water cylinder', 'Pump', 'Motorised valve', 'F &amp; E tank', 'F &amp; E tank', '2022-08-12 09:28:10'),
(41, 11, 0, 'Which of these is usually not found on a sealed system?', 'Hot water cylinder', 'Pump', 'Motorised valve', 'F &amp; E tank', 'F &amp; E tank', '2022-08-12 09:28:10'),
(42, 11, 0, 'Why must the top bend of the vent pipe be 40cm above the water level of the F&amp;E tank?', 'To help prevent noise', 'To allow more air to leave the system', 'To help prevent pumping over', 'To ensure air is not drawn in', 'To ensure air is not drawn in', '2022-08-12 09:29:16'),
(43, 11, 0, 'The pressure relief valve is leaking. What could this be a sign of?', 'The expansion vessel is not functioning properly', 'The system needs a power flush', 'The boiler’s pressure is too weak', 'There is too much air in the system', 'There is too much air in the system', '2022-08-12 09:30:22'),
(44, 13, 0, 'How do you guarantee that your glazing installation is up to the British standards?', 'I self-certify (FENSA registered)', 'Building control sign off my works', 'My many years of experience are a guarantee that the installation will comply with the standards', 'I always ask the customer if they are happy with the work', 'I always ask the customer if they are happy with the work', '2022-08-12 09:33:27'),
(45, 13, 0, 'Before laying a solid floor base, how deep do you need to dig?', '150mm', '200mm', '250mm', '300mm', '300mm', '2022-08-12 09:38:01'),
(46, 13, 0, 'Which of these are you most likely to recommend to a homeowner whose main desire is to improve energy performance?', 'Tiled roof conservatory', 'Polycarbonate roofing', '60mm external bead frames', 'Opening fanlights', 'Opening fanlights', '2022-08-12 09:39:06'),
(47, 14, 0, 'Which of these policies covers poor workmanship?', 'Site insurance policy', 'All-risk insurance policy', 'Structural warranty', 'Builder\'s professional indemnity', 'Builder\'s professional indemnity', '2022-08-12 09:42:23'),
(48, 14, 0, 'You\'ve hired a sub contractor in to help with your conversion and the client spots a serious problem with the sub contractor\'s work. Who is ultimately responsible to rectify it?', 'The sub contractor', 'You (the main contractor)', 'The sub contractor and you (the contractor)', 'You (the contractor) and the client', 'You (the contractor) and the client', '2022-08-12 09:43:49'),
(49, 14, 0, 'Which of the following are you MOST likely to use when packing around the steel after knocking through a load-bearing wall?', 'Thermalite', 'Brick', 'Slate', 'Timber', 'Timber', '2022-08-12 09:44:54'),
(50, 14, 0, 'Your carpenter needs an extra day to finish his work on a conversion. However, your decorator can only do today as he is booked up for the next three weeks.  The homeowner wants you to keep to the schedule. Which of the following would be the most appropr', 'Recommend a delay to the homeowner', 'Find an alternative decorator', 'Involve the homeowner to work out a schedule and find a compromise', 'Handle the work themselves', 'Handle the work themselves', '2022-08-12 09:45:52'),
(51, 14, 0, 'When quoting, VAT...  (Assume you are VAT registered)', 'Should be added to materials only', 'Should be added to labour only', 'Should be added to the whole quote', 'Is optional', 'Is optional', '2022-08-12 09:46:50'),
(52, 15, 0, 'Rising damp can rise up to…', '0.5m', '1m', '1.5m', '2m', '2m', '2022-08-12 09:49:08'),
(53, 15, 0, 'Which of these is NOT a cause of rising damp?', 'Damp proof course bridging', 'Slate course bridging', 'Condensation', 'Untreated foundations', 'Untreated foundations', '2022-08-12 09:50:02'),
(54, 15, 0, 'Rising damp…', 'Has a different smell to penetrating damp', 'Can occur even if the DPC is functioning well', 'Can be fought with damp proof paint', 'Can be caused by a damaged DPM', 'Can be caused by a damaged DPM', '2022-08-12 09:51:03'),
(55, 15, 0, 'A customer has a rising damp issue on their ground floor. Upon inspection you notice that no DPC was fitted. What solution are you LEAST likely to propose?', 'Install a DPC', 'Fit dryrods', 'Use dryzone cream', 'Inject a chemical DPC', 'Inject a chemical DPC', '2022-08-12 09:52:06'),
(56, 16, 0, 'For a partial demolition, what is the minimum notice you need to give building control?', '2 weeks', '6 weeks', '10 weeks', '12 weeks', '12 weeks', '2022-08-12 09:55:04'),
(57, 16, 0, 'Which of these buildings do NOT require notification to the Local Authority for demolition?', 'A freestanding barn', 'A greenhouse attached to a house', 'A large detached house', 'Other', 'Other', '2022-08-12 09:56:15'),
(58, 16, 0, 'Which of the following tools would you use to remove the felt roof from a large shed?', 'Mechanical grapple', 'Pry bar', 'Sledgehammer', 'Circular saw', 'Circular saw', '2022-08-12 09:57:40'),
(59, 16, 0, 'To reduce the risk posed by uncontrolled collapse, which of the following should the structural survey consider most important?', 'Exclusion zones', 'Falling from height', 'Age and type of construction', 'Other', 'Age and type of construction', '2022-08-12 09:58:54'),
(60, 17, 0, 'What is the minimum depth required for the sub base (MOT) on a domestic driveway carrying one vehicle?', '100mm', '150mm', '200mm', '250mm', '250mm', '2022-08-12 10:01:25'),
(61, 17, 0, 'Which of these general statements is NOT true?', 'A tarmac driveway requires an anti-slip solution', 'A block driveway often requires additional drainage', 'A concrete driveway requires sealing to preserve the finish', 'A gravel driveway requires frequent maintenance', 'A gravel driveway requires frequent maintenance', '2022-08-12 10:02:49'),
(62, 17, 0, 'During the excavation for a driveway you come across a steel pipe that was not marked on any plans. Until you know for sure, what do you assume the pipe is supplying?', 'Water', 'Electricity', 'Gas', 'Nothing', 'Nothing', '2022-08-12 10:03:42'),
(63, 17, 0, 'You\'re on a tight deadline and you need to continue working, what should you do?', 'Stop work until the homeowner returns', 'Keep excavating around the pipe by hand', 'Inform the neighbours / residents', 'Call the responsible authority', 'Call the responsible authority', '2022-08-12 10:04:35'),
(64, 17, 0, 'You dig up a driveway and have approx. 2 cubic metres of concrete rubble. Which of the following would be most environmentally friendly and cost effective?', 'Use as hardcore on another driveway', 'Take to the council recycling centre', 'Dispose in council landfill', 'Recommend the homeowner deals with it', 'Recommend the homeowner deals with it', '2022-08-12 10:05:23'),
(65, 17, 0, 'Which of these is an ideal fall for a driveway?', '1:30', '1:50', '1:70', '1:90', '1:90', '2022-08-12 10:06:21'),
(66, 19, 0, 'At what stage of the job would you normally expect the first visit from building control?', 'Before digging the foundations', 'Before filling the foundations', 'After filling the foundations', 'After laying the DPC', 'After laying the DPC', '2022-08-12 10:10:42'),
(67, 19, 0, 'How much of a budget would you recommend a homeowner sets aside as a contingency fund for a typical extension project?', '5 - 10%', '11 - 15%', '16 - 20%', '21 - 25%', '21 - 25%', '2022-08-12 10:11:57'),
(68, 20, 0, 'Which is more likely to be used when rot has been discovered at the eves?', 'Standard / “mammoth” / “jumbo” PVC board', 'Cover / cap-it board', 'Both', 'Non of the above', 'Cover / cap-it board', '2022-08-12 10:15:31'),
(69, 20, 0, 'Which of the following is the most common causes of felt damage?', 'Nesting birds', 'Sunlight', 'Heavy snow', 'Wind', 'Wind', '2022-08-12 10:16:38'),
(70, 21, 0, 'In concrete posts, a groove is for...', 'Better fixings', 'A fence panel', 'Feather edge boards', 'Additional support', 'Additional support', '2022-08-12 10:20:22'),
(71, 21, 0, 'What type of fence would you recommend to a customer whose main preoccupations are privacy and low maintenance?', 'Chain-link fence', 'Picket fence', 'Ranch style fence', 'Cast-concrete fence', 'Cast-concrete fence', '2022-08-12 10:22:19'),
(72, 21, 0, ' What can you use to ensure that the fence posts are aligned?', 'A string', 'Measuring tape', 'A plumb line', 'A hole digger', 'A hole digger', '2022-08-12 10:25:07'),
(73, 21, 0, 'A client has a tight budget, what style of fencing would you recommend to keep costs down?', 'Palisade', 'Feather edge', 'Closeboard panel', 'Lap panel', 'Lap panel', '2022-08-12 10:25:52'),
(74, 21, 0, 'Which of the following are problems that can be caused by leaving old concrete bases for a boundary fence in the ground?', 'Structural damage to nearby buildings', 'Danger to wildlife from pollution of the soil', 'Fence line deviates from property boundaries', 'Breach of building regulations', 'Breach of building regulations', '2022-08-12 10:27:07'),
(75, 22, 0, 'In what situation is it preferable to pull the weeds out by hand?', 'Weeds in flower bed', 'Weeds in driveways', 'Weeds in gravel', 'Weeds in the lawn', 'Weeds in the lawn', '2022-08-12 10:31:18'),
(76, 22, 0, 'You have been asked to trim a hedge, but notice a robin’s nest in it. Which of these is CORRECT?', 'Robins are not an endangered species, you can destroy the nest', 'If there are no eggs in the nest, it can be destroyed', 'Even if there are eggs in the nest, you are allowed to relocate it', 'None of the above', 'None of the above', '2022-08-12 10:32:19'),
(77, 22, 0, 'Which of these pests is the LEAST harmful to a lawn?', 'Ants', 'Miner bees', 'Chafer grubs', 'Leatherjackets', 'Leatherjackets', '2022-08-12 10:33:15'),
(78, 22, 0, 'What time is best to water the garden?', 'Morning', 'Evening', 'Morning or Evening', 'Anytime', 'Anytime', '2022-08-12 10:34:16'),
(79, 22, 0, 'In order to keep the grass healthy, how low should you mow the lawn?', 'Reduce the height by half', 'Reduce the height by a third', 'Reduce the height by two inches at a time', 'Never cut grass that is shorter than 6 inches', 'Never cut grass that is shorter than 6 inches', '2022-08-12 10:35:12'),
(80, 22, 0, 'First impressions matter. At which point of contact with your customer should you tell them a bit about yourself and your business?', 'Face to face', 'You expect the customer to find this information out themselves', 'Once they give you a call', 'Non of the above', 'Once they give you a call', '2022-08-12 10:36:40'),
(81, 24, 0, 'When building on potentially unstable ground, which type of foundation would you lay?', 'Padstone', 'Raft', 'Strip', 'Trench', 'Trench', '2022-08-12 10:40:00'),
(82, 24, 0, 'You are asked to dig out 1m³ of clay. Accounting for the bulking factor, roughly how much clay will you have to take away from the property?', '1m³', '1.3m³', '1.7m³', '2m³', '2m³', '2022-08-12 10:41:50'),
(83, 26, 0, 'Which of these statements about external wall insulation (EWI) is WRONG?', 'EWI helps you conserve floor space', 'EWI is a good opportunity to improve the look of a property', 'EWI is cheaper than internal insulation', 'EWI prevents penetrating damp', 'EWI prevents penetrating damp', '2022-08-12 10:44:06'),
(84, 26, 0, 'Solid walls can be insulated…', 'On the inside of the building', 'On the outside of the building', 'Both', 'Solid walls do not warrant the need for insulation', 'Solid walls do not warrant the need for insulation', '2022-08-12 10:45:04'),
(85, 26, 0, 'When installing floor insulation before boarding a loft, which of the following statements is WRONG?', 'You will need to raise the floor level for the insulation to reach adequate thickness', 'You should try to squash the mineral wool when fitting the boards on top', 'Insulating between the joists is a cheaper option than between the rafters', 'You should leave an air gap between the insulation and the boards', 'You should leave an air gap between the insulation and the boards', '2022-08-12 10:45:57'),
(86, 26, 0, 'Which of following can NOT be used to retrofit cavity wall insulation?', 'Polystyrene boards', 'Polystyrene beads', 'Acrylic render', 'Polyurethane foam', 'Polyurethane foam', '2022-08-12 10:47:21'),
(87, 26, 0, 'What is the minimum recommended thickness for loft insulation?', '170mm', '270mm', '370mm', '470mm', '470mm', '2022-08-12 10:50:53'),
(88, 26, 0, 'A customer’s loft is insulated to a thickness inferior to the current recommendations. What is the simplest and cheapest solution you would recommend?', 'Rigid-foam decking', 'Cross-laying', 'Rafter insulation', 'Dry-lining', 'Dry-lining', '2022-08-12 10:51:48'),
(89, 27, 0, 'The working triangle refers to the space between…', 'The hob, the sink and the fridge', 'The oven, the fridge and the sink', 'The sink, the oven and the hob', 'The hob, the oven and the fridge', 'The hob, the oven and the fridge', '2022-08-12 10:56:57'),
(90, 27, 0, 'Fitting a kitchen appliance in a corner is something you would...', 'Strongly advise against', 'Neither advise against nor recommend', 'Strongly recommend', 'Other', 'Strongly recommend', '2022-08-12 10:57:52'),
(91, 27, 0, 'Select a way of avoiding driving the screws too deep in the cabinet panels.', 'Countersinking them', 'Driving the screws half by half', 'Driving the screws by hand', 'Coating the screws in sealant', 'Coating the screws in sealant', '2022-08-12 10:59:30'),
(92, 27, 0, 'The supplied kitchen is missing a couple of fill strips and the manufacturer can\'t supply replacements in time to meet the client\'s deadline. What would be your course of action?', 'Make your own from off cuts', 'Source from somewhere else', 'Delay the fitting until they arrive', 'Discuss with the client and see what they would like to do', 'Discuss with the client and see what they would like to dov', '2022-08-12 11:01:32'),
(93, 28, 0, 'Which of these lock designs provides the LEAST amount of security on their own?', 'Night latches', 'Mortise locks', 'Deadlocking cylinder rim locks', 'Pin tumbler locks', 'Pin tumbler locks', '2022-08-12 11:04:16'),
(94, 28, 0, 'Which part of a deadlocking cylinder rim lock should be fitted on the doorframe?', 'The cylinder', 'The lock body', 'The faceplate', 'The staple', 'The staple', '2022-08-12 11:05:11'),
(95, 28, 0, 'You can check for an inscription on a mortise lock to ensure it conforms to British Standards. What is it?', 'BS 3126', 'BS 3216', 'BS 3261', 'BS 3621', 'BS 3621', '2022-08-12 11:06:22'),
(96, 28, 0, 'Which of these types of locks would you NOT recommend for a fanlight window?', 'Casement lock', 'Swing-bar lock', 'Lockable stay pins', 'Dual screws', 'Dual screws', '2022-08-12 11:08:53'),
(97, 29, 0, 'On a fire door, which elements need to offer 30 minutes of fire protection?', 'The frame', 'The lock and latch set', 'Both', 'Neither', 'Neither', '2022-08-12 11:14:18'),
(98, 29, 0, 'Typically, what is the size of the ventilation gap you should leave between the roofing membrane and the roof insulation?', '25mm or less', '50mm', '75mm', '100mm or more', '100mm or more', '2022-08-12 11:16:15'),
(99, 29, 0, 'When quoting, VAT…', 'Applies to materials only', 'Applies to labour only', 'Applies to the whole quote', 'Is optional', 'Is optional', '2022-08-12 11:18:20'),
(100, 31, 0, 'What product would you use to get oil-based paint off brushes?', 'Water and soap', 'Bleach', 'White spirit', 'Dihydrogen monoxide', 'Dihydrogen monoxide', '2022-08-12 11:21:19'),
(101, 31, 0, 'Where are you LEAST likely to be cutting in?', 'Around a window', 'Where the walls meet the ceiling', 'Along a skirting board', 'On a worktop', 'On a worktop', '2022-08-12 11:22:16'),
(102, 31, 0, 'Which of these statements about cutting in is WRONG?', 'Only dip the tip of the brush in the can', 'When cutting in to an uneven surface, shaking your hand slightly will help', 'Try to hold your breath, or exhale when cutting in, to avoid involuntary movements', 'Always cut in first', 'Always cut in first', '2022-08-12 11:23:15'),
(103, 31, 0, 'What type of sealing caulk should you use on a window frame before painting an external wall?', 'Butyl-rubber caulk', 'Silicone caulk', 'Latex caulk', 'Neither', 'Latex caulk', '2022-08-12 11:24:40'),
(104, 31, 0, 'How can you prevent the bristles from clumping?', 'Dipping the brush more often', 'Using a thicker brush', 'Avoiding wide brushes', 'Leaving the paint to dry for longer', 'Leaving the paint to dry for longer', '2022-08-12 11:25:58'),
(105, 31, 0, 'When do you need to seal plaster?', 'After one day', 'Between 2-4 days', 'When it\'s dry', 'After the mist coating', 'After the mist coating', '2022-08-12 11:27:06'),
(106, 32, 0, 'A client would like there walls dry-lined and the joins finished with filler, what kind of plasterboard would you install?', 'Square edge', 'Rounded edge', 'Tapered edge', 'Easy fill edge', 'Easy fill edge', '2022-08-12 11:29:57'),
(107, 32, 0, 'Which jointing tape gives the strongest joint?', 'Fibre tape', 'Paper tape', 'Sticky tape', 'Chalk tape', 'Chalk tape', '2022-08-12 11:33:12'),
(108, 32, 0, 'When installing angle beads you should always...', 'Only use the existing corners to site them', 'Use the existing corners and a level to site them', 'Both', 'Neither', 'Use the existing corners and a level to site them', '2022-08-12 11:34:19'),
(109, 33, 0, 'What must NEVER be used when soldering joints on potable water supplies?', 'Propane', 'MAPP gas', 'Self-cleaning flux', 'Lead solder', 'Lead solder', '2022-08-12 11:36:59'),
(110, 33, 0, 'Chrome pipes can be joined with push fit fittings. What do you think about this statement?', 'It is true, but you need to remove the chrome plating first', 'It is true, chrome pipes are built to be used with most push fit fittings effortlessly', 'It is false, you need to solder the pipes instead', 'It is false, chrome pipes are too thick for push fit fittings', 'It is false, chrome pipes are too thick for push fit fittings', '2022-08-12 11:37:50'),
(111, 34, 0, 'A client would like their room refurbished and this includes wallpaper stripping.  What is the best advice to give?', 'Strip the wallpaper and then paint', 'Strip the wallpaper, plaster and paint', 'Strip the wallpaper, assess if any additional works are required prior to painting', 'Strip the wallpaper, assess if any additional works are required and provide an updated quote prior ', 'Strip the wallpaper, assess if any additional works are required and provide an updated quote prior ', '2022-08-12 11:41:19'),
(112, 34, 0, 'Who does public liability insurance NOT cover?', 'The contractor', 'The employees', 'The subcontractors', 'Neither', 'The subcontractors', '2022-08-12 11:42:35'),
(113, 34, 0, 'In your experience, which of these is likely to cause the most serious delays on a typical renovation project?', 'Managing a large number of subcontractors in a single day', 'Homeowner changing their minds about materials', 'Not keeping a record of the plans given to subcontractors', 'Conducting a health and safety briefing every day', 'Conducting a health and safety briefing every day', '2022-08-12 11:44:03'),
(114, 34, 0, 'When quoting, VAT...', 'Should be added to materials only', 'Should be added to labour only', 'Should be added to the whole quote', 'Is optional', 'Is optional', '2022-08-12 11:45:24'),
(115, 35, 0, 'When re-roofing a building, what is the minimum surface area that requires a building regulations application?', '25%', '50%', '75%', '100%', '100%', '2022-08-12 11:49:25'),
(116, 35, 0, 'What statements about blisters on a flat roof is correct?', 'When blisters aren’t too big, it is generally better to leave them', 'Blisters are formed by water or air trapped in the covering material', 'When repairing a blistered asphalt roof, you will need to heat it', 'When repairing a blistering felted roof, you will need to rip the damaged area off', 'When repairing a blistering felted roof, you will need to rip the damaged area off', '2022-08-12 11:51:00'),
(117, 35, 0, 'Flashing tape…', 'Can be used as a permanent repair for lead flashing', 'Requires a blowtorch', 'Should be primed before applying', 'Does not require adhesive', 'Does not require adhesive', '2022-08-12 11:52:04'),
(118, 36, 0, 'PIR detectors can be tripped by…', 'Pets', 'Noxious gases', 'Changes in temperature', 'Loud sudden noises', 'Loud sudden noises', '2022-08-12 11:55:58'),
(119, 36, 0, 'Which one of these it the easiest to install?', 'PIR sensors', 'Microwave detectors', 'Magnetic switches', 'Photoelectric beams', 'Photoelectric beams', '2022-08-12 11:56:54'),
(120, 36, 0, 'Which part of CCTV work is notifiable work?', 'Installing CCTV joined with a Police Monitored Alarm', 'Adding an electrical circuit', 'Fitting a dummy alarm box', 'All aspects of CCTV work are notifiable work', 'All aspects of CCTV work are notifiable work', '2022-08-12 11:58:00'),
(121, 36, 0, 'When it comes to sensors it is preferable to use...', 'A couple of good ones', 'Quite a few cheaper ones', 'Other', 'Neither', 'Quite a few cheaper ones', '2022-08-12 11:59:06'),
(122, 36, 0, 'Most burglaries happen…', 'Between 3am and 9am', 'Between 9am and 3pm', 'Between 3pm and 9pm', 'Between 9pm and 3am', 'Between 9pm and 3am', '2022-08-12 12:00:24'),
(123, 36, 0, 'A customer tells you they are having a problem with their outdoor security camera: false alarms happen every time their next door neighbour’s garage door opens. What do you suggest?', 'Create masking', 'Set motion detection sensitivity', 'Fit a better camera', 'Hang the camera 5 inches higher', 'Hang the camera 5 inches higher', '2022-08-12 12:02:16'),
(124, 36, 0, 'Which of these systems is the least susceptible to hacking?', 'Unencrypted wireless', 'Encrypted wireless', 'Wired', 'Neither', 'Wired', '2022-08-12 12:04:46'),
(125, 36, 0, 'Any cable run longer than … will lead to a voltage drop which can render a security system inefficient.', '10m', '15m', '20m', '25m', '25m', '2022-08-12 12:05:33'),
(126, 37, 0, 'Which of these should you always take care to avoid when building a random rubble wall?', 'Running joints', 'Salt deposits', 'Chisel marks', 'Wall tie failure', 'Wall tie failure', '2022-08-12 12:08:10'),
(127, 37, 0, 'What mason commonly works in a workshop?', 'Fixer', 'Sawyers', 'Quarrymen', 'Banker', 'Banker', '2022-08-12 12:10:09'),
(128, 37, 0, 'Which of these statements is accurate?', 'A sawn finish is the least time-consuming', 'A flame-cut finish is ideal for external flooring', 'A bush-hammered finish is a smooth finish', 'A honed finish is a rough finish', 'A honed finish is a rough finish', '2022-08-12 12:11:19'),
(129, 37, 0, 'Which of the following would you NOT use for internal flooring?', 'Granite', 'Marble', 'Bath Stone', 'Slate', 'Slate', '2022-08-12 12:12:12'),
(130, 37, 0, 'A customer asks you for advice for the maintenance of their granite memorial. Which advice are you UNLIKELY to give them?', 'Saturate the memorial with water', 'Scrub it using a soft-bristle brush', 'Only dab the lettering', 'Use household bleach to remove lichen', 'Use household bleach to remove lichen', '2022-08-12 12:13:14'),
(131, 37, 0, 'What does a banker mason do?', 'Build walls', 'Build arches', 'Dress stone', 'Buy and sell stone', 'Buy and sell stone', '2022-08-12 12:14:14'),
(132, 37, 0, 'On a rubble wall, the stones’ longest dimension should be…', 'Vertical', 'Horizontal', 'It does not matter', 'Both', 'It does not matter', '2022-08-12 12:15:57'),
(133, 38, 0, 'What tool would you use to check if the first 500mm of floor tiles is level?', 'A spirit level', 'A laser level', 'A screeding level', 'A chalk line', 'A chalk line', '2022-08-12 12:17:52'),
(134, 38, 0, 'What is the minimum size of plywood British Standards recommend to be used for over-boarding?', '15mm', '20mm', '25mm', '30mm', '30mm', '2022-08-12 12:19:23'),
(135, 38, 0, 'What is the maximum weight recommended for tiling (per m2) on gypsum plaster?', '20kg', '30kg', '40kg', '50kg', '50kg', '2022-08-12 12:20:13'),
(136, 40, 0, 'On what type of walls would windows include a vertical DPC?', 'Solid wall', 'Cavity wall', 'Both', 'Neither', 'Neither', '2022-08-12 12:23:33'),
(137, 40, 0, 'Which of these types of glass will provide the best sound proofing?', 'Float', 'Toughened', 'Safety', 'Laminated', 'Laminated', '2022-08-12 12:27:39'),
(138, 40, 0, 'A 12mm gap around the frame on the inside of the window should be filled with:', 'Decorator’s caulk', 'Mortar', 'Expansion foam', 'Frame sealant', 'Frame sealant', '2022-08-12 12:28:55'),
(139, 40, 0, 'How do you guarantee that your installation is up to the British standards?', 'I always get the works inspected by a FENSA registered person/Building regulations certified person', 'I always ask the customer if they are happy with the work', 'My many years of experience are a guarantee that the installation will comply with the standards', 'I self-certify (FENSA registered)', 'I self-certify (FENSA registered)', '2022-08-12 12:30:35'),
(140, 40, 0, 'Bay windows are classified as…', 'Porches', 'Windows', 'Extensions', 'Conservatories', 'Conservatories', '2022-08-12 12:31:25'),
(141, 40, 0, 'If a door handle is turning without any resistance, what is the most likely cause?', 'The lock is broken', 'The spindle is not connected', 'The handle is broken', 'Neither', 'The handle is broken', '2022-08-12 12:32:34'),
(142, 40, 0, 'What should you use to apply the back putty to the frame?', 'A trowel', 'A brush', 'Your hands', 'A knife', 'A knife', '2022-08-12 12:34:28'),
(143, 40, 0, 'When would be the best time to paint over the putty?', 'Immediately after applying it', 'A few hours after applying it', 'A few days after applying it', 'Putty should not be painted over', 'Putty should not be painted over', '2022-08-12 12:35:48'),
(144, 40, 0, 'How would you fill old hinges recesses?', 'With one layer of filler', 'By plastering over it', 'With expanding foam', 'By scarfing it', 'By scarfing it', '2022-08-12 12:37:02'),
(145, 7, 0, 'What is Bathroom?', 'room', 'city', 'country', 'none', 'room', '2022-11-10 08:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `rateuser`
--

CREATE TABLE `rateuser` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `job_id` int(5) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `ratings` int(5) NOT NULL DEFAULT 0,
  `message` mediumtext DEFAULT NULL,
  `send_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(6) NOT NULL,
  `subscription` int(1) NOT NULL DEFAULT 1 COMMENT '0= free,1=paid',
  `subscription_price` float NOT NULL,
  `stripe_public_key` varchar(255) NOT NULL,
  `stripe_private_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `subscription`, `subscription_price`, `stripe_public_key`, `stripe_private_key`) VALUES
(1, 1, 20, 'pk_test_51KiyFEK7MTYjUl7bNsCrbuV4YQm9jTTjDE3RYQWrV9xQ10eFMGm30nfStZkHZ34eagH33XCRDPvwEPQJS7usRciW00d3DKOgEi', 'sk_test_51KiyFEK7MTYjUl7bVHKoi89JLIaHBQo9uDlukufe5wNJeH5HUC2LtdhOoptzAwqXluLkxxeDKmhnEVOqeRGOrnUN00R7MM6qP5');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(6) NOT NULL,
  `main_category` varchar(250) DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `main_category`, `category_name`, `status`, `create_date`) VALUES
(9, '6', 'Basic outline plans (for quotes and planning appli', 1, '2022-06-27 07:02:04'),
(10, '6', 'Full regulation plans (for builders &amp; building', 1, '2022-06-27 07:02:20'),
(11, '6', 'Structural calculations', 1, '2022-06-27 07:02:35'),
(13, '6', ' I\'m not sure', 1, '2022-06-27 07:03:10'),
(14, '7', 'Bathroom refurbishment / installation', 1, '2022-06-27 07:05:13'),
(15, '7', 'Install or replace a fixture', 1, '2022-06-27 07:05:45'),
(16, '7', ' Repair', 1, '2022-06-27 07:06:05'),
(17, '7', ' Tiling', 1, '2022-06-27 07:06:15'),
(18, '7', ' Other', 1, '2022-06-27 07:06:25'),
(20, '8', ' Building a wall', 1, '2022-06-27 07:14:40'),
(21, '8', ' Building a structure', 1, '2022-06-27 07:14:48'),
(22, '8', ' Building custom brickwork', 1, '2022-06-27 07:14:58'),
(23, '8', ' Wall alterations', 1, '2022-06-27 07:15:07'),
(24, '8', ' Repointing', 1, '2022-06-27 07:15:15'),
(25, '8', ' Chimney work', 1, '2022-06-27 07:15:24'),
(26, '8', ' Repairs', 1, '2022-06-27 07:15:33'),
(27, '9', ' Doors, windows &amp; floors', 1, '2022-06-27 07:17:04'),
(28, '9', ' Furniture making, assembly &amp; repairs', 1, '2022-06-27 07:17:13'),
(29, '9', ' Kitchen units &amp; worktops', 1, '2022-06-27 07:17:25'),
(30, '9', ' Decking', 1, '2022-06-27 07:17:33'),
(31, '9', ' Other carpentry work', 1, '2022-06-27 07:17:41'),
(32, '10', ' New or replacement flooring', 1, '2022-06-27 07:18:02'),
(33, '10', ' Sanding / Restoration', 1, '2022-06-27 07:18:19'),
(34, '10', ' Repair / Adjustment', 1, '2022-06-27 07:18:28'),
(35, '10', ' Other', 1, '2022-06-27 07:18:35'),
(36, '11', ' Boiler', 1, '2022-06-27 07:18:56'),
(37, '11', ' Pipework / supply', 1, '2022-06-27 07:19:08'),
(38, '11', ' Radiators', 1, '2022-06-27 07:19:33'),
(53, '11', ' Thermostat', 1, '2022-06-27 07:20:03'),
(87, '11', ' Underfloor heating', 1, '2022-06-27 07:26:06'),
(88, '11', ' Full system installation', 1, '2022-06-27 07:26:18'),
(89, '11', ' Other', 1, '2022-06-27 07:26:27'),
(90, '12', ' Chimney', 1, '2022-06-27 07:26:54'),
(91, '12', ' Fireplace', 1, '2022-06-27 07:27:07'),
(92, '12', ' Flue', 1, '2022-06-27 07:27:15'),
(93, '12', ' Other or several of the above', 1, '2022-06-27 07:27:24'),
(94, '13', ' A new conservatory installation', 1, '2022-06-27 07:27:47'),
(95, '13', ' Replace or improve an existing conservatory', 1, '2022-06-27 07:27:56'),
(96, '13', ' A repair', 1, '2022-06-27 07:28:05'),
(97, '14', ' Loft conversion', 1, '2022-06-27 07:30:11'),
(98, '14', ' Converting an existing space', 1, '2022-06-27 07:30:19'),
(99, '14', ' Wall alteration', 1, '2022-06-27 07:30:28'),
(100, '14', ' Restoring or improving existing space', 1, '2022-06-27 07:30:36'),
(101, '15', ' No - I need help investigating', 1, '2022-06-27 07:31:39'),
(102, '15', ' Yes - I just need help fixing the problem', 1, '2022-06-27 07:31:46'),
(103, '16', ' Waste removal only', 1, '2022-06-27 07:31:59'),
(104, '16', ' Building / structure demolition', 1, '2022-06-27 07:32:08'),
(105, '16', ' Knock down a wall', 1, '2022-06-27 07:32:16'),
(106, '17', ' Install a driveway', 1, '2022-06-27 07:32:43'),
(107, '17', ' Clean or reseal a driveway', 1, '2022-06-27 07:32:51'),
(108, '17', ' Dropped kerb (crossover)', 1, '2022-06-27 07:33:01'),
(109, '17', ' Repair a driveway', 1, '2022-06-27 07:33:09'),
(110, '17', ' Paving, patios and paths', 1, '2022-06-27 07:33:17'),
(111, '18', ' Rewiring', 1, '2022-06-27 07:33:42'),
(112, '18', ' Fuseboxes', 1, '2022-06-27 07:33:49'),
(113, '18', ' Electrical fittings &amp; appliances', 1, '2022-06-27 07:33:56'),
(114, '18', ' Safety check or certificate', 1, '2022-06-27 07:34:03'),
(115, '18', ' Electrical faults &amp; repairs', 1, '2022-06-27 07:34:10'),
(116, '18', ' Other', 1, '2022-06-27 07:34:18'),
(117, '19', ' Property extension', 1, '2022-06-27 07:34:49'),
(118, '19', ' Loft conversion', 1, '2022-06-27 07:34:58'),
(119, '19', ' A porch', 1, '2022-06-27 07:35:04'),
(120, '19', ' Outbuilding', 1, '2022-06-27 07:35:11'),
(121, '19', ' Internal alterations', 1, '2022-06-27 07:35:19'),
(122, '19', ' Other', 1, '2022-06-27 07:35:25'),
(123, '20', ' Guttering only', 1, '2022-06-27 07:36:05'),
(124, '20', ' Fascias and/or soffits only', 1, '2022-06-27 07:36:12'),
(125, '20', ' Both', 1, '2022-06-27 07:36:19'),
(126, '21', ' Fencing', 1, '2022-06-27 07:36:33'),
(127, '21', ' Gates', 1, '2022-06-27 07:36:45'),
(128, '21', ' Fencing and gates', 1, '2022-06-27 07:36:57'),
(129, '21', ' Repair a fence or gate', 1, '2022-06-27 07:37:05'),
(130, '22', ' General gardening', 1, '2022-06-27 07:37:58'),
(131, '22', ' Landscaping', 1, '2022-06-27 07:38:11'),
(132, '22', ' Tree Surgery', 1, '2022-06-27 07:38:21'),
(133, '23', ' Gas safety check', 1, '2022-06-27 07:38:52'),
(134, '23', ' Service boiler or appliance', 1, '2022-06-27 07:39:03'),
(135, '23', ' Install or replace boiler or appliance', 1, '2022-06-27 07:39:15'),
(136, '23', ' Move or remove boiler or appliance', 1, '2022-06-27 07:39:37'),
(137, '23', ' Pipework only', 1, '2022-06-27 07:39:43'),
(138, '23', ' Problem or repair', 1, '2022-06-27 07:39:51'),
(139, '23', ' Other', 1, '2022-06-27 07:39:57'),
(140, '24', ' Foundations for a structure to be built', 1, '2022-06-27 07:40:21'),
(141, '24', ' Drainage &amp; pipework', 1, '2022-06-27 07:40:28'),
(142, '24', ' General garden earthworks', 1, '2022-06-27 07:40:35'),
(143, '24', ' Other', 1, '2022-06-27 07:40:42'),
(144, '25', 'If your job requires any kind of specialist work, such as bricklaying, electrical works, or kitchen fitting, you will need to post your job in the relevant category, I understand', 1, '2022-06-27 07:41:02'),
(145, '26', ' Loft / roof insulation', 1, '2022-06-27 07:41:19'),
(146, '26', ' Wall insulation', 1, '2022-06-27 07:41:29'),
(147, '26', ' Floor insulation', 1, '2022-06-27 07:41:44'),
(148, '26', ' Other', 1, '2022-06-27 07:41:53'),
(149, '27', ' New kitchen installation', 1, '2022-06-27 07:42:32'),
(150, '27', ' Worktop installation', 1, '2022-06-27 07:42:49'),
(151, '27', ' Cabinet door refurbishment / replacement', 1, '2022-06-27 07:43:00'),
(152, '27', ' Fit appliance (sink, oven, dishwasher, etc.)', 1, '2022-06-27 07:43:11'),
(153, '27', ' Minor repair', 1, '2022-06-27 07:43:21'),
(154, '27', ' Several of the above, or other', 1, '2022-06-27 07:43:35'),
(155, '28', ' Install new locks', 1, '2022-06-27 07:48:44'),
(156, '28', ' Repair locks', 1, '2022-06-27 07:48:56'),
(157, '28', ' Other (e.g. locked out)', 1, '2022-06-27 07:49:33'),
(158, '29', ' Loft conversion with structural changes', 1, '2022-06-27 07:50:24'),
(159, '29', ' Loft conversion (no structural changes)', 1, '2022-06-27 07:50:51'),
(160, '29', ' Loft conversion for storage purposes', 1, '2022-06-27 07:51:01'),
(161, '29', ' Fit a skylight', 1, '2022-06-27 07:51:16'),
(162, '30', ' Yes', 1, '2022-06-27 07:52:04'),
(163, '30', ' I will - purchase in progress', 1, '2022-06-27 07:52:14'),
(164, '30', ' No', 1, '2022-06-27 07:52:25'),
(165, '31', ' Inside', 1, '2022-06-27 07:52:54'),
(166, '31', ' Outside', 1, '2022-06-27 07:53:07'),
(167, '31', ' Both', 1, '2022-06-27 07:53:17'),
(168, '32', ' Plastering (indoors)', 1, '2022-06-27 07:53:34'),
(169, '32', ' Rendering (outdoors)', 1, '2022-06-27 07:54:06'),
(170, '33', ' Radiators', 1, '2022-06-27 07:54:26'),
(171, '33', ' Boilers', 1, '2022-06-27 07:54:34'),
(172, '33', ' Appliances', 1, '2022-06-27 07:54:41'),
(173, '33', ' Fixtures', 1, '2022-06-27 07:55:00'),
(174, '33', ' Pipework, taps &amp; drainage', 1, '2022-06-27 07:55:10'),
(175, '34', ' I understand', 1, '2022-06-27 07:55:26'),
(176, '35', ' New or replacement roof', 1, '2022-06-27 07:55:41'),
(177, '35', ' Roof repair or assessment', 1, '2022-06-27 07:55:49'),
(178, '35', ' Chimney work', 1, '2022-06-27 07:55:58'),
(179, '35', ' Something else', 1, '2022-06-27 07:56:06'),
(180, '36', ' Security alarm system', 1, '2022-06-27 07:56:26'),
(181, '36', ' CCTV/Smart camera', 1, '2022-06-27 07:56:35'),
(182, '36', ' Entry system', 1, '2022-06-27 07:56:46'),
(183, '36', ' Smoke alarms', 1, '2022-06-27 07:56:56'),
(184, '36', ' Security lights', 1, '2022-06-27 07:57:03'),
(185, '36', ' Locks', 1, '2022-06-27 07:57:11'),
(186, '36', ' Other', 1, '2022-06-27 07:57:19'),
(187, '37', ' Building', 1, '2022-06-27 07:57:37'),
(188, '37', ' Repairing', 1, '2022-06-27 07:57:44'),
(189, '37', ' Repointing', 1, '2022-06-27 07:57:53'),
(190, '37', ' Other', 1, '2022-06-27 07:58:02'),
(191, '38', ' New or replacement tiles', 1, '2022-06-27 07:58:23'),
(192, '38', ' Repair / regrout tiles', 1, '2022-06-27 07:58:31'),
(193, '38', ' Other', 1, '2022-06-27 07:58:38'),
(194, '39', ' Trimming or topping', 1, '2022-06-27 07:58:54'),
(195, '39', ' Cutting down (felling)', 1, '2022-06-27 07:59:04'),
(196, '39', ' Stump removal only', 1, '2022-06-27 07:59:12'),
(197, '39', ' Diagnosis / Assessment', 1, '2022-06-27 07:59:21'),
(198, '39', ' Bushes, or other gardening tasks', 1, '2022-06-27 07:59:30'),
(199, '39', ' Other', 1, '2022-06-27 07:59:37'),
(200, '40', ' New windows', 1, '2022-06-27 07:59:52'),
(201, '40', ' New doors (internal or external)', 1, '2022-06-27 08:00:05'),
(202, '40', ' New windows and external doors', 1, '2022-06-27 08:00:15'),
(203, '40', ' Replace glass', 1, '2022-06-27 08:00:28'),
(204, '40', ' Repair', 1, '2022-06-27 08:00:40'),
(205, '40', ' Other', 1, '2022-06-27 08:00:48'),
(206, '41', ' Handyman', 1, '2022-06-27 08:01:04'),
(207, '41', ' Restoration &amp; refurbishment', 1, '2022-06-27 08:01:11'),
(208, '41', ' Conversions', 1, '2022-06-27 08:01:18'),
(209, '41', ' I\'m still not sure', 1, '2022-06-27 08:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tid` int(6) NOT NULL,
  `stripe_subscription_id` varchar(50) DEFAULT NULL,
  `payment_amount` float DEFAULT NULL,
  `payment_status` varchar(25) DEFAULT NULL,
  `user_id` varchar(6) DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT current_timestamp(),
  `s_type` varchar(15) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `object` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `stripe_subscription_id` varchar(255) NOT NULL,
  `status` int(4) NOT NULL DEFAULT 1,
  `user_type` int(4) NOT NULL DEFAULT 2,
  `user_role` varchar(30) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `builder1` int(2) NOT NULL DEFAULT 0,
  `builder2` int(2) NOT NULL DEFAULT 0,
  `operate` varchar(30) DEFAULT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `company_number` int(30) DEFAULT NULL,
  `trading_name` varchar(50) DEFAULT NULL,
  `search_address` mediumtext NOT NULL,
  `work_address` mediumtext NOT NULL,
  `town` varchar(50) DEFAULT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `hired_counter` int(11) DEFAULT 0,
  `distance` int(10) DEFAULT NULL,
  `reset_token` varchar(10) DEFAULT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `dbs_path` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `pub_insurance` varchar(100) DEFAULT NULL,
  `pub_insurance_date` date DEFAULT NULL,
  `pro_insurance` varchar(100) DEFAULT NULL,
  `pro_insurance_date` date DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `work_area` varchar(100) DEFAULT NULL,
  `subscription_type` varchar(20) DEFAULT NULL,
  `subscription_status` int(1) NOT NULL DEFAULT 0,
  `subscription_date` date DEFAULT NULL,
  `subscription_end` date DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `stripe_subscription_id`, `status`, `user_type`, `user_role`, `fname`, `lname`, `email`, `phone`, `password`, `builder1`, `builder2`, `operate`, `company_name`, `company_number`, `trading_name`, `search_address`, `work_address`, `town`, `post_code`, `hired_counter`, `distance`, `reset_token`, `img_path`, `dbs_path`, `qualification`, `pub_insurance`, `pub_insurance_date`, `pro_insurance`, `pro_insurance_date`, `note`, `work_area`, `subscription_type`, `subscription_status`, `subscription_date`, `subscription_end`, `create_date`) VALUES
(1, '', 1, 1, '', 'Admin', 'user', 'admin@gmail.com', '+447222555555', '827ccb0eea8a706c4c34a16891f84e7b', 0, 1, 'Self-employed', NULL, NULL, 'Testuser', '', 'Lahore__Pakistan', 'Lahore', 'M2 1BB', 0, 3, NULL, '../uploads/1668076775-l2.jpeg', '../uploads/1668076719-l1.jpeg', 'BSSE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-11-10 10:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `verify_skill`
--

CREATE TABLE `verify_skill` (
  `id` int(5) NOT NULL,
  `user_id` int(6) NOT NULL,
  `main_category` int(5) NOT NULL,
  `sub_category` int(5) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 1,
  `score` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_options`
--
ALTER TABLE `add_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apply_job`
--
ALTER TABLE `apply_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_gallery`
--
ALTER TABLE `jobs_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_job`
--
ALTER TABLE `post_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rateuser`
--
ALTER TABLE `rateuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_skill`
--
ALTER TABLE `verify_skill`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_options`
--
ALTER TABLE `add_options`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT for table `apply_job`
--
ALTER TABLE `apply_job`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs_gallery`
--
ALTER TABLE `jobs_gallery`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_category`
--
ALTER TABLE `main_category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `post_job`
--
ALTER TABLE `post_job`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `rateuser`
--
ALTER TABLE `rateuser`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tid` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `verify_skill`
--
ALTER TABLE `verify_skill`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
