-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 12:42 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `account_name`) VALUES
(1, 'Meezan'),
(4, 'HBL'),
(5, 'Faisal');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`) VALUES
(0, 'Gogrades'),
(0, 'EduResearchers');

-- --------------------------------------------------------

--
-- Table structure for table `brand_permissions`
--

CREATE TABLE `brand_permissions` (
  `id` int(11) NOT NULL,
  `brandpermission` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand_permissions`
--

INSERT INTO `brand_permissions` (`id`, `brandpermission`, `user_id`) VALUES
(3, 'Gogrades', 98);

-- --------------------------------------------------------

--
-- Table structure for table `core_leads`
--

CREATE TABLE `core_leads` (
  `id` int(11) NOT NULL,
  `campId` int(11) DEFAULT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_contact_number` varchar(20) DEFAULT NULL,
  `lead_landing_date` date DEFAULT NULL,
  `client_country` varchar(100) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_info` text DEFAULT NULL,
  `lead_source` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `whatsapp_name` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `refer_client_name` varchar(255) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `lead_type` varchar(50) DEFAULT NULL,
  `del_status` varchar(200) DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `core_leads`
--

INSERT INTO `core_leads` (`id`, `campId`, `client_name`, `client_contact_number`, `lead_landing_date`, `client_country`, `client_email`, `client_info`, `lead_source`, `user_id`, `brand_name`, `whatsapp_name`, `whatsapp_number`, `refer_client_name`, `platform`, `lead_type`, `del_status`) VALUES
(2, 2147483647, 'md', '45343', '2024-10-23', 'New Zealand', 'mdmdmmddm@gmail.com', 'New', 'Social Media Marketing', 98, 'Gogrades', 'GoGrades 324322323', NULL, NULL, 'Instagram', 'Core', 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `delete_keys`
--

CREATE TABLE `delete_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delete_keys`
--

INSERT INTO `delete_keys` (`id`, `key`) VALUES
(1, 'maazdd'),
(2, 'TE9YTHlLT1Y2eEJVdHRDdUJEd29lUT09OjqMdsetkd0wCuA/KuBKPyya'),
(3, 'ekhYZTdxTWREN1UyS0NLdXFCQkF2Zz09OjoU01ZKIv/Bem6kyWNS0VAk'),
(4, 'ZEtCK1hFY2FZZTZIQ1M4MTl3b2xGdz09OjpdVWL6MXbiqKoRyzPsNszy'),
(5, 'ZEtCK1hFY2FZZTZIQ1M4MTl3b2xGdz09OjpdVWL6MXbiqKoRyzPsNszy'),
(6, 'ZEtCK1hFY2FZZTZIQ1M4MTl3b2xGdz09OjpdVWL6MXbiqKoRyzPsNszy');

-- --------------------------------------------------------

--
-- Table structure for table `email_setting`
--

CREATE TABLE `email_setting` (
  `id` int(11) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `servername` varchar(300) NOT NULL,
  `port` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `file_name` text NOT NULL,
  `brandname` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`id`, `email`, `password`, `servername`, `port`, `description`, `file_name`, `brandname`) VALUES
(4, 'info@graderz.org', 'wfb|1C4e32s+', 'mail.graderz.org', '587', '<p><span style=\"font-weight: bolder;\">Hi Maaz:</span></p><p>Please find attached your complete file. If you feel any of your requirements were not met, please inform us and we will get back to you shortly. Thanks, and regards, Clinton Thompson Customer Support Manager gogrades.org www.gogrades.org Disclaimer: Services provided by gogrades.org and its associate companies, serve as model papers for students for a guideline to their work as a sample work, these works must not be used for any academic gain. These papers are intended to help students to understand research techniques and various issues in academic research only. If you receive this email in error, please contact the sender and destroy all copies of this email and any attachment(s). While antivirus protection tools have been deployed, you should check this email and attachments for the presence of viruses. go grades and its associate companies accept no liability for any misuse of the contents or damage caused by any virus transmitted by or contained in this email and attachment.</p><p><span style=\"font-weight: bolder;\">Thanks and regards,</span></p><p><span style=\"font-weight: bolder;\"> Clinton Thompson Customer Support Manager www.GoGrades.org</span></p>', 'Gogrades-email-template', 'Gogrades'),
(5, 'info@graderz.org', 'wfb|1C4e32s+', 'mail.graderz.org', '587', '<p>Hello Abc</p>', 'EduResearchers-email-template', 'EduResearchers');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `campId` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_contact_number` varchar(255) DEFAULT NULL,
  `lead_landing_date` date DEFAULT NULL,
  `client_country` varchar(255) DEFAULT NULL,
  `client_email` varchar(300) DEFAULT '-',
  `client_info` varchar(250) DEFAULT NULL,
  `lead_source` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand_name` varchar(500) NOT NULL,
  `whatsapp_name` varchar(500) NOT NULL,
  `whatsapp_number` varchar(250) DEFAULT NULL,
  `refer_client_name` varchar(500) DEFAULT NULL,
  `platform` varchar(500) NOT NULL,
  `lead_type` varchar(500) NOT NULL,
  `del_status` varchar(250) NOT NULL DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `campId`, `client_name`, `client_contact_number`, `lead_landing_date`, `client_country`, `client_email`, `client_info`, `lead_source`, `user_id`, `brand_name`, `whatsapp_name`, `whatsapp_number`, `refer_client_name`, `platform`, `lead_type`, `del_status`) VALUES
(16, 'dsadsa', 'dani', '32423323223', '2024-10-23', 'Pakistan', 'dani@gmail.com', 'New', 'Social Media Marketing', 97, 'Gogrades', 'GoGrades 324322323', NULL, NULL, 'Facebook', 'Live', 'Not_Deleted'),
(17, '332433', 'abc', '04350450432', '2024-10-23', 'Norway', 'abc@gmail.com', 'Referral', 'Refer', 97, 'Gogrades', 'GoGrades 324322323', NULL, 'maaz', '', 'Live', 'Not_Deleted'),
(18, '32432', 'dd', '32434324324', '2024-10-23', 'United Arab Emirates', 'dsas@gmail.com', 'New', 'Through Email', 98, 'Gogrades', 'GoGrades 324322323', NULL, NULL, '', 'Live', 'Not_Deleted'),
(19, '32642', 'alex', '124521', '2024-10-23', 'Mozambique', 'alex@gmail.com', 'Recurring', 'PPC', 98, 'Gogrades', 'GoGrades 324322323', NULL, 'alex', '', 'Core', 'Not_Deleted'),
(21, 'Camp ID', 'Client Name', 'Client Contact Number', '0000-00-00', 'Client Country', 'Client Email', 'Client Info', 'Lead Source', 97, 'Brand Name', 'Whatsapp Name', NULL, 'Refer Client Name', 'Platform', 'Lead Type', 'Not_Deleted'),
(22, 'dsadsa', 'dani', '32423323223', '2024-10-23', 'Pakistan', 'dani@gmail.com', 'New', 'Social Media Marketing', 97, 'EduResearchers', 'EduResearchers 5345324533442', NULL, '', 'Facebook', 'Live', 'Not_Deleted'),
(23, '332433', 'abc', '04350450432', '2024-10-23', 'Norway', 'abc@gmail.com', 'Referral', 'Refer', 97, 'Gogrades', 'GoGrades 324322323', NULL, 'maaz', '', 'Live', 'Not_Deleted'),
(24, '32432', 'dd', '32434324324', '2024-10-23', 'United Arab Emirates', 'dsas@gmail.com', 'New', 'Through Email', 97, 'Gogrades', 'GoGrades 324322323', NULL, '', '', 'Live', 'Not_Deleted'),
(25, '32642', 'alex', '124521', '2024-10-23', 'Mozambique', 'alex@gmail.com', 'Recurring', 'PPC', 97, 'Gogrades', 'GoGrades 324322323', NULL, 'alex', '', 'Core', 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `lead_source`
--

CREATE TABLE `lead_source` (
  `id` int(11) NOT NULL,
  `source` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lead_source`
--

INSERT INTO `lead_source` (`id`, `source`) VALUES
(1, 'Google'),
(2, 'PPC'),
(3, 'Refer'),
(4, 'Bing'),
(5, 'Social Media Marketing'),
(6, 'Through Email'),
(7, 'Organic');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderId` int(11) NOT NULL,
  `order_id_input` int(11) NOT NULL,
  `order_title` varchar(255) DEFAULT NULL,
  `order_status` enum('Follow up','Revision','File not received','Refund/Deadline','Converted','Delivered') DEFAULT NULL,
  `payment_status` varchar(250) NOT NULL DEFAULT '----',
  `word_count` varchar(350) DEFAULT NULL,
  `whatsapp_account` varchar(255) DEFAULT NULL,
  `payment_account` varchar(250) DEFAULT NULL,
  `portal_due_date` date DEFAULT NULL,
  `final_deadline_time` varchar(250) DEFAULT NULL,
  `order_confirmation_date` varchar(250) DEFAULT NULL,
  `pending_payment_Month` varchar(250) NOT NULL,
  `pending_payment_status` varchar(250) NOT NULL,
  `writers_team` varchar(255) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(500) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `years` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `client_requirements` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `order_confirmation_month` varchar(250) DEFAULT NULL,
  `del_status` varchar(250) NOT NULL DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderId`, `order_id_input`, `order_title`, `order_status`, `payment_status`, `word_count`, `whatsapp_account`, `payment_account`, `portal_due_date`, `final_deadline_time`, `order_confirmation_date`, `pending_payment_Month`, `pending_payment_status`, `writers_team`, `plan`, `assigned_to`, `year`, `years`, `comment`, `client_requirements`, `user_id`, `lead_id`, `order_confirmation_month`, `del_status`) VALUES
(47, 32, 'tit', 'Converted', '----	', '555', '453435', 'HBL', '2024-11-09', '2024-11-13 03:50:00', '2024-10-29', '', '', 'd', 'Premium', 'Maaz', 2024, 0, 'dd', 'dd dd ', 97, 22, 'October', 'Not_Deleted'),
(61, 4230, 'di', 'Revision', 'Half Payment', '333', '657546', 'Meezan', '2024-11-02', '2024-11-06 12:54:00', '2024-10-30', '', '', 'mddmddmdmddmmdm', 'Classic', 'mddddmmddmddmddmmdmddmm', 2024, 0, 'dsdsd', 'dndndnd', 97, 25, 'October', 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` int(11) NOT NULL,
  `pending_payment` varchar(500) NOT NULL,
  `receive_payment` varchar(500) NOT NULL,
  `month` varchar(500) NOT NULL,
  `currency` varchar(500) NOT NULL,
  `payment_date` varchar(500) NOT NULL,
  `order_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_payment` varchar(500) NOT NULL,
  `upscale` varchar(500) NOT NULL,
  `before_upscale` varchar(300) NOT NULL,
  `del_status` varchar(250) NOT NULL DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_payments`
--

INSERT INTO `order_payments` (`id`, `pending_payment`, `receive_payment`, `month`, `currency`, `payment_date`, `order_id`, `year`, `timestamp`, `total_payment`, `upscale`, `before_upscale`, `del_status`) VALUES
(20, '400', '1000', 'October', 'PKR', '2024-10-29', 47, 2024, '2024-10-30 11:03:30', '1400', '', '', 'Not_Deleted'),
(21, '200', '200', 'October', 'PKR', '2024-10-29', 47, 2024, '2024-10-30 11:03:27', '1400', '', '', 'Not_Deleted'),
(31, '100', '400', 'October', 'AUD', '2024-10-30', 61, 2024, '2024-10-30 11:16:20', '300', 'upsale', '200', 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permissionid` int(11) NOT NULL,
  `lead_management` enum('Allow','Deny') DEFAULT 'Deny',
  `log_management` enum('Allow','Deny') DEFAULT 'Deny',
  `view_users` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `Add_user` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `add_shift` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `view_shift` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `view_team` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `add_team` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `add_lead` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `view_lead` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `add_core_lead` enum('Allow','Deny') NOT NULL,
  `view_core_lead` enum('Allow','Deny') NOT NULL,
  `view_order` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter1` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter2` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter3` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `user_id` int(11) DEFAULT NULL,
  `del_status` varchar(250) NOT NULL DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissionid`, `lead_management`, `log_management`, `view_users`, `Add_user`, `add_shift`, `view_shift`, `view_team`, `add_team`, `add_lead`, `view_lead`, `add_core_lead`, `view_core_lead`, `view_order`, `filter1`, `filter2`, `filter3`, `user_id`, `del_status`) VALUES
(67, 'Deny', 'Deny', 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Allow', 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 97, 'Not_Deleted'),
(68, 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 46, 'Not_Deleted'),
(69, 'Deny', 'Deny', 'Allow', 'Deny', 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Allow', 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 47, 'Not_Deleted'),
(70, 'Deny', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Allow', 'Deny', 'Deny', 'Deny', 98, 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `plan` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id`, `plan`) VALUES
(1, 'Classic'),
(2, 'Premium'),
(6, 'GOld');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `shiftId` int(11) NOT NULL,
  `shift_type` enum('Morning','Evening','Night') DEFAULT NULL,
  `start_timing` varchar(255) DEFAULT NULL,
  `end_timing` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`shiftId`, `shift_type`, `start_timing`, `end_timing`) VALUES
(14, 'Evening', '18:00', '02:00'),
(15, 'Night', '02:00', '10:00'),
(25, 'Morning', '10:00', '18:00');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `teamId` int(11) NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `team_lead` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`teamId`, `team_name`, `team_lead`) VALUES
(2, 'Name', 47),
(5, 'Writer C', 95),
(7, 'developer', 58),
(8, 'Marketing', 46);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','Editor','Viewer') NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_id_address` varchar(255) DEFAULT NULL,
  `team_Id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `system_status` enum('Blocked','Active','Off') DEFAULT NULL,
  `secret_key` varchar(500) DEFAULT NULL,
  `wfh` varchar(250) NOT NULL DEFAULT 'Deny',
  `del_status` varchar(250) NOT NULL DEFAULT 'Not_Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `name`, `email`, `password`, `role`, `last_login`, `last_id_address`, `team_Id`, `shift_id`, `system_status`, `secret_key`, `wfh`, `del_status`) VALUES
(46, 'admin', 'admin@gmail.com', '$2y$10$L1vUIr.YSjVW.58zCdnjguCGGlXvNMNUm4/tLvasK7gDjfPdn4SSy', 'Admin', '2024-03-21 14:26:34', '::1', 2, 14, 'Active', '123', 'Deny', 'Not_Deleted'),
(47, 'editors', 'editors@gmail.com', '$2y$10$nD9fFaa1EOuo75WUBkSzCuBhMT0gs6z/Ae.w51jr60/HNHn6QuToK', 'Editor', '2024-02-26 16:51:44', '39.51.69.16', 8, 14, 'Active', '123', 'Deny', 'Not_Deleted'),
(95, 'Qadama Ahmed Khan', 'qadamaalam@gmail.com', '$2y$10$VOKLWpw5xDzPvdcveLG/g.hafFhJliE8Bhma4BfdlNfQQDn0BiLS6', 'Admin', '2024-02-12 18:14:55', '39.57.195.226', 7, 25, 'Active', '123', 'Deny', 'Not_Deleted'),
(96, 'Muhammad Athar Khan', 'athar@gmail.com', '$2y$10$qciD7ztOj.POra0cvMh9CuWEz9wLD3j7.M6x5s.Gx29mbLlRpcrC.', 'Admin', '2024-02-27 23:21:10', '202.47.38.106', 2, 15, 'Active', '123', 'Deny', 'Not_Deleted'),
(97, 'Maaz', 'maaza42101@gmail.com', '$2y$10$A/unfoK6SHS0KzuDvjL9zOvlN0baypL.H07.3Tjnhours8msvyYXi', 'Admin', '2024-10-29 10:54:48', '::1', 2, 14, 'Active', '123', 'Allow', 'Not_Deleted'),
(98, 'dani', 'dani@gmail.com', '$2y$10$97semRhlzhFDq/NsJtsW4OmUhCMsdja038u6wE00jymnCabxeOc/C', 'Editor', '2024-10-23 15:19:39', '::1', 2, 14, 'Active', '123', 'Allow', 'Not_Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp`
--

CREATE TABLE `whatsapp` (
  `id` int(11) NOT NULL,
  `whatsapp_name` varchar(500) NOT NULL,
  `whatsapp_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `whatsapp`
--

INSERT INTO `whatsapp` (`id`, `whatsapp_name`, `whatsapp_number`) VALUES
(1, 'GoGrades', '324322323'),
(2, 'EduResearchers', '5345324533442');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_permissions`
--
ALTER TABLE `brand_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_leads`
--
ALTER TABLE `core_leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `delete_keys`
--
ALTER TABLE `delete_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_setting`
--
ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lead_source`
--
ALTER TABLE `lead_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_payments_ibfk_1` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissionid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shiftId`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamId`),
  ADD KEY `fk_team_lead_user` (`team_lead`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `team_Id` (`team_Id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `whatsapp`
--
ALTER TABLE `whatsapp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `brand_permissions`
--
ALTER TABLE `brand_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_leads`
--
ALTER TABLE `core_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delete_keys`
--
ALTER TABLE `delete_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `lead_source`
--
ALTER TABLE `lead_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permissionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `shiftId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `whatsapp`
--
ALTER TABLE `whatsapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `core_leads`
--
ALTER TABLE `core_leads`
  ADD CONSTRAINT `core_leads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

--
-- Constraints for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `order_payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`orderId`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`team_Id`) REFERENCES `team` (`teamId`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`shiftId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
