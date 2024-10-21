-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 09:01 AM
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
(4, 'HBL');

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
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`id`, `email`, `password`, `servername`, `port`, `description`) VALUES
(1, 'info@graderz.org', 'wfb|1C4e32s+', 'mail.graderz.org', '587', '<p><span style=\"font-weight: bolder;\">Hi Qadama:</span></p><p>Please find attached your complete file. If you feel any of your requirements were not met, please inform us and we will get back to you shortly. Thanks, and regards, Clinton Thompson Customer Support Manager gogrades.org www.gogrades.org Disclaimer: Services provided by gogrades.org and its associate companies, serve as model papers for students for a guideline to their work as a sample work, these works must not be used for any academic gain. These papers are intended to help students to understand research techniques and various issues in academic research only. If you receive this email in error, please contact the sender and destroy all copies of this email and any attachment(s). While antivirus protection tools have been deployed, you should check this email and attachments for the presence of viruses. go grades and its associate companies accept no liability for any misuse of the contents or damage caused by any virus transmitted by or contained in this email and attachment.</p><p><span style=\"font-weight: bolder;\">Thanks and regards, Clinton Thompson Customer Support Manager www.GoGrades.org</span></p>'),
(2, 'info@graderz.org', 'wfb|1C4e32s+', 'mail.graderz.org', '587', '<p><span style=\"font-weight: bolder;\">Hi Maaz:</span></p><p>Please find attached your complete file. If you feel any of your requirements were not met, please inform us and we will get back to you shortly. Thanks, and regards, Clinton Thompson Customer Support Manager gogrades.org www.gogrades.org Disclaimer: Services provided by gogrades.org and its associate companies, serve as model papers for students for a guideline to their work as a sample work, these works must not be used for any academic gain. These papers are intended to help students to understand research techniques and various issues in academic research only. If you receive this email in error, please contact the sender and destroy all copies of this email and any attachment(s). While antivirus protection tools have been deployed, you should check this email and attachments for the presence of viruses. go grades and its associate companies accept no liability for any misuse of the contents or damage caused by any virus transmitted by or contained in this email and attachment.</p><p><span style=\"font-weight: bolder;\">Thanks and regards,</span></p><p><span style=\"font-weight: bolder;\"> Clinton Thompson Customer Support Manager www.GoGrades.org</span></p>'),
(3, 'info@graderz.org', 'wfb|1C4e32s+', 'mail.graderz.org', '587', '<p><span style=\"font-weight: bolder;\">Hi Qadama:</span></p><p>Please find attached your complete file. If you feel any of your requirements were not met, please inform us and we will get back to you shortly. Thanks, and regards, Clinton Thompson Customer Support Manager gogrades.org www.gogrades.org Disclaimer: Services provided by gogrades.org and its associate companies, serve as model papers for students for a guideline to their work as a sample work, these works must not be used for any academic gain. These papers are intended to help students to understand research techniques and various issues in academic research only. If you receive this email in error, please contact the sender and destroy all copies of this email and any attachment(s). While antivirus protection tools have been deployed, you should check this email and attachments for the presence of viruses. go grades and its associate companies accept no liability for any misuse of the contents or damage caused by any virus transmitted by or contained in this email and attachment.</p><p><span style=\"font-weight: bolder;\">Thanks and regards, Clinton Thompson Customer Support Manager www.GoGrades.org</span></p>');

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
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `campId`, `client_name`, `client_contact_number`, `lead_landing_date`, `client_country`, `client_email`, `client_info`, `lead_source`, `user_id`) VALUES
(3, '1232123', '213213213', '123213213', '2024-01-13', '213213', 'CCC@gmail.com', 'New', 'mm m m m m m', 47),
(4, 'dsa', 'Maaz', '04350450432', '2024-01-18', 'Pakistan', 'hassankhann220@gmail.com', 'Recurring', 'dd dd dd ddd dd dd ', 46),
(6, 'ddma', 'ahmed', '32423323223', '2024-01-24', 'Pak', 'dmda@gmail.com', NULL, '', 46),
(7, 'md431', 'mf', '64532456', '2024-01-26', 'Barbados', 'maaza42101@gmail.com', 'Recurring', '', 46),
(9, '6154', 'Sibghat', '1234567890', '2024-02-27', 'Ukraine', 'sibghat@gmail.com', 'Referral', '', 96),
(12, '6153', 'abc', '123455', '2024-08-16', 'Pakistan', 'aa@gmail.com', 'New', '                                    ddd ddd', 47);

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
  `pending_payment` decimal(10,2) DEFAULT NULL,
  `receive_payment` decimal(10,2) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
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
  `order_confirmation_month` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderId`, `order_id_input`, `order_title`, `order_status`, `payment_status`, `word_count`, `pending_payment`, `receive_payment`, `currency`, `whatsapp_account`, `payment_account`, `portal_due_date`, `final_deadline_time`, `order_confirmation_date`, `pending_payment_Month`, `pending_payment_status`, `writers_team`, `plan`, `assigned_to`, `year`, `years`, `comment`, `client_requirements`, `user_id`, `lead_id`, `order_confirmation_month`) VALUES
(16, 4230, 'Title', 'Revision', '----', '50', '1000.00', '100.00', 'AED', '08764533', 'Bank 2', '2024-02-29', '2024-02-29T11:45', '2025-02-28', '', '', 'writers', 'Premium', 'qadamaa', 2004, 2025, '', 'Requirements', 46, 3, 'February'),
(17, 4230, 'Title', 'Revision', 'Full Payment', '50', '99.00', '100.00', 'AWG', '08764533', 'Bank 2', '2024-03-01', '2024-03-27T11:55', '2020-03-01', '', '', 'writers', 'plan', 'qadamaa', 2020, 2020, '', 'sad dsa', 46, 4, 'March'),
(18, 393434, 'assignmente33434', 'Refund/Deadline', '----', '1500', '50.00', '50.00', 'BDT', 'UK new', 'Meezan', '2024-02-29', '2024-03-01T11:24', '2024-02-27', 'January', 'UnPaid', 'ffa', 'Premium', 'Nighat', 2024, 2024, 'ddd', 'Assignment', 96, 9, 'February'),
(20, 222, 'Title', 'Converted', 'Half Payment', '1222', '1000.00', '100.00', 'BGN', 'whatsapp', 'Meezan', '2024-03-20', '2024-03-23T01:56', '2024-03-21', '', 'UnPaid', 'writers', 'Classic', 'AHmed', 2022, 2024, 'dd', 'efw ddfd d ddd dddd ddaaddadadadaddadndadadnda', 46, 3, 'March'),
(41, 222, 'Title', 'Converted', 'Half Payment', '1222', '1000.00', '100.00', 'BGN', 'whatsapp', 'Meezan', '2024-03-20', '2024-03-23T01:56', '2024-03-21', '', 'UnPaid', 'writers', 'Classic', 'AHmed', 2024, 2024, 'dd', 'efw ddfd d ddd dddd ddaaddadadadaddadndadadnda', 97, 3, 'March'),
(42, 321, '432', 'Follow up', 'Half Payment', '432', '2332.00', '333.00', 'BBD', '432342', 'Meezan', '2024-08-16', '2024-08-16 10:52:00', '2024-08-16', '', 'UnPaid', 'dsa', 'Classic', 'wqaaa', 2024, 2024, 'dd', 'dd', 47, 12, 'August');

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
  `view_order` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter1` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter2` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `filter3` enum('Allow','Deny') NOT NULL DEFAULT 'Deny',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissionid`, `lead_management`, `log_management`, `view_users`, `Add_user`, `add_shift`, `view_shift`, `view_team`, `add_team`, `add_lead`, `view_lead`, `view_order`, `filter1`, `filter2`, `filter3`, `user_id`) VALUES
(67, 'Deny', 'Deny', 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 97),
(68, 'Allow', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Allow', 'Allow', 46),
(69, 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Deny', 'Allow', 'Deny', 'Allow', 'Deny', 'Deny', 'Deny', 47),
(70, 'Deny', 'Allow', 'Allow', 'Deny', 'Deny', 'Allow', 'Allow', 'Deny', 'Deny', 'Allow', 'Allow', 'Allow', 'Deny', 'Allow', 98);

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
(14, 'Evening', '19:38', '20:38'),
(15, 'Night', '04:31', '10:34'),
(25, 'Morning', '22:24', '16:27');

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
  `secret_key` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `name`, `email`, `password`, `role`, `last_login`, `last_id_address`, `team_Id`, `shift_id`, `system_status`, `secret_key`) VALUES
(46, 'admin', 'admin@gmail.com', '$2y$10$N.dkfXFq6jf0UqB9QLkHB.4Z2/3jLx7qdJqHjuNjwQ2lfeaI77oqm', 'Admin', '2024-08-07 16:41:14', '::1', 2, 14, 'Active', '123'),
(47, 'editors', 'editors@gmail.com', '$2y$10$EYcMQKJqUCliNJB6dFnMb.UW8sDrFZi0zJMdCdA.gPorm7J2UQhpu', 'Editor', '2024-08-16 10:54:37', '::1', 8, 14, 'Active', '123'),
(95, 'Qadama Ahmed Khan', 'qadamaalam@gmail.com', '$2y$10$VOKLWpw5xDzPvdcveLG/g.hafFhJliE8Bhma4BfdlNfQQDn0BiLS6', 'Admin', '2024-02-12 18:14:55', '39.57.195.226', 7, 25, 'Active', '123'),
(96, 'Muhammad Athar Khan', 'athar00khan00@gmail.com', '$2y$10$qciD7ztOj.POra0cvMh9CuWEz9wLD3j7.M6x5s.Gx29mbLlRpcrC.', 'Admin', '2024-02-27 23:21:10', '202.47.38.106', 2, 15, 'Active', '123'),
(97, 'Maaz', 'maaza42101@gmail.com', '$2y$10$A/unfoK6SHS0KzuDvjL9zOvlN0baypL.H07.3Tjnhours8msvyYXi', 'Admin', '2024-08-16 11:25:46', '::1', 2, 14, 'Active', '123'),
(98, 'abc', 'dd@gmail.com', '$2y$10$kIf5FiTfX7QZt0G.GO8mjeT0vqpfh8SBiRdDKlm03c717wRbztc7S', 'Viewer', '2024-08-16 10:56:48', '::1', 8, 25, 'Active', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
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
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lead_id` (`lead_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- Constraints for dumped tables
--

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`team_Id`) REFERENCES `team` (`teamId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`shiftId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
