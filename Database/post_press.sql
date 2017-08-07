-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2016 at 04:10 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `post_press`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `bdate` date NOT NULL,
  `trader` int(11) DEFAULT NULL,
  `amount` float(6,2) DEFAULT '0.00',
  `commision` float(6,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_voucher`
--

CREATE TABLE `bill_voucher` (
  `bv_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `books` int(11) NOT NULL,
  `amount` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `binding_process`
--

CREATE TABLE `binding_process` (
  `bp_id` int(11) NOT NULL,
  `bp_name` varchar(255) DEFAULT NULL,
  `p_type` varchar(10) DEFAULT NULL,
  `p_time` varchar(15) DEFAULT NULL,
  `count_mode` varchar(20) DEFAULT NULL,
  `rate_section` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_code` int(11) DEFAULT NULL,
  `book_name` varchar(60) DEFAULT NULL,
  `book_lang` varchar(60) DEFAULT NULL,
  `book_size` int(11) DEFAULT NULL,
  `book_bind` varchar(5) DEFAULT NULL,
  `paper_used` varchar(15) DEFAULT NULL,
  `isbn` int(11) DEFAULT NULL,
  `latest_edition` int(11) NOT NULL DEFAULT '0',
  `total_printed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_production`
--

CREATE TABLE `book_production` (
  `bp_id` int(11) NOT NULL,
  `book_code` int(11) DEFAULT NULL,
  `edition` int(11) DEFAULT NULL,
  `section` float(5,2) DEFAULT NULL,
  `firma` float(5,2) DEFAULT NULL,
  `csection` float(5,2) DEFAULT NULL,
  `processes` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `production_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_size`
--

CREATE TABLE `book_size` (
  `bs_id` int(3) NOT NULL,
  `bs_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `book_size`
--

TRUNCATE TABLE `book_size`;
--
-- Dumping data for table `book_size`
--

INSERT INTO `book_size` (`bs_id`, `bs_name`) VALUES
(1, 'Vrihadakar'),
(2, 'Granthakar'),
(3, 'Pustakakar'),
(4, 'Pocket'),
(5, 'Laghu Aakar'),
(6, 'Maachis Aakar'),
(7, 'Patrika'),
(8, 'Patrika(top open)'),
(9, 'Patrika(Vrihadakar)'),
(10, 'Mahatmya'),
(11, '608*844'),
(12, 'Poster Small 18*23'),
(13, 'Poster Large 23*36');

-- --------------------------------------------------------

--
-- Table structure for table `bp_machine`
--

CREATE TABLE `bp_machine` (
  `id` int(11) NOT NULL,
  `bp_id` int(11) DEFAULT NULL,
  `machine_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bp_so`
--

CREATE TABLE `bp_so` (
  `id` int(11) NOT NULL,
  `bp_id` int(11) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `functions`
--

CREATE TABLE `functions` (
  `function_id` int(11) NOT NULL,
  `function_name` varchar(255) DEFAULT NULL,
  `function_link` varchar(255) NOT NULL,
  `func_category` int(11) DEFAULT NULL,
  `show_in_menu` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `functions`
--

TRUNCATE TABLE `functions`;
--
-- Dumping data for table `functions`
--

INSERT INTO `functions` (`function_id`, `function_name`, `function_link`, `func_category`, `show_in_menu`) VALUES
(3, 'Verify Users', 'verifyusers.php', 1, 1),
(4, 'Add Books', 'addbook.php', 2, 1),
(5, 'Remove User', 'removeuser.php', 1, 1),
(6, 'Edit User', 'edituser.php', 1, 1),
(8, 'Add Trader', 'addtrader.php', 4, 1),
(9, 'Add Machine', 'addmachine.php', 4, 1),
(10, 'Add Special Options', 'addspecialoptions.php', 4, 1),
(11, 'Add Binding Process', 'addbindingprocess.php', 4, 1),
(12, 'Add/Edit Rate', 'addrate.php', 4, 1),
(13, 'Edit Book', 'editbook.php', 2, 1),
(14, 'Add/Edit Production Details', 'addproduction.php', 4, 1),
(15, 'Add/Edit Print Job', 'addprintjob.php', 2, 1),
(16, 'Add Voucher', 'addvoucher.php', 2, 1),
(17, 'Edit Voucher', 'editvoucher.php', 2, 1),
(18, 'Reprint History', 'reprinthistory.php', 6, 1),
(19, 'Generate Bill', 'generatebill.php', 5, 1),
(20, 'Print Bill', 'printbill.php', 5, 1),
(21, 'Edit Trader', 'edittrader.php', 4, 1),
(22, 'Pending Books', 'pendingbooks.php', 6, 1),
(23, 'Completed Books', 'completedbooks.php', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `func_category`
--

CREATE TABLE `func_category` (
  `fc_id` int(11) NOT NULL,
  `fc_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `func_category`
--

TRUNCATE TABLE `func_category`;
--
-- Dumping data for table `func_category`
--

INSERT INTO `func_category` (`fc_id`, `fc_name`) VALUES
(1, 'Users'),
(2, 'Books'),
(4, 'Operations'),
(5, 'Billing'),
(6, 'Reports');

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `machine`
--

TRUNCATE TABLE `machine`;
--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`machine_id`, `machine_name`) VALUES
(1, 'Default'),
(2, 'Perfect-mini'),
(3, 'Perfect-appu'),
(4, 'Folding With Machine'),
(5, 'Screen Printing'),
(6, 'Hand Printing'),
(7, 'Binding Cloth'),
(8, 'Book Sewing Channel'),
(9, 'Book Sewing Standard'),
(10, 'Embossing Printing'),
(11, 'HMT Printing'),
(15, 'Folding With Hand');

-- --------------------------------------------------------

--
-- Table structure for table `print_voucher`
--

CREATE TABLE `print_voucher` (
  `pvoucher_id` int(11) NOT NULL,
  `bp_id` int(11) DEFAULT NULL,
  `copies_printed` int(11) DEFAULT NULL,
  `vdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_steps`
--

CREATE TABLE `production_steps` (
  `ps_id` int(11) NOT NULL,
  `bproduction_id` int(11) DEFAULT NULL,
  `machine_id` int(11) NOT NULL,
  `bp_id` int(11) DEFAULT NULL,
  `so_id` int(11) DEFAULT NULL,
  `max_books` int(11) DEFAULT '0',
  `book_processed` int(11) DEFAULT '0',
  `unprocessed_books` int(11) NOT NULL DEFAULT '0',
  `unreported_books` int(11) NOT NULL DEFAULT '0',
  `step_final` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `binding_process` int(11) NOT NULL,
  `machine` int(11) NOT NULL,
  `special_options` int(11) DEFAULT NULL,
  `book_size` int(11) DEFAULT NULL,
  `paper_type` varchar(10) DEFAULT NULL,
  `rate` float(10,2) DEFAULT NULL,
  `bind` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `special_options`
--

CREATE TABLE `special_options` (
  `so_id` int(11) NOT NULL,
  `so_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trader`
--

CREATE TABLE `trader` (
  `trader_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `pan` varchar(15) DEFAULT NULL,
  `license` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `joined_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `joined_on`, `last_login`, `verified`) VALUES
(2, 'Upendra', 'Patwari', 'upendrasingh370@gmail.com', '7d8f4b4b4613dc7e15333e6449692ad4af502d1d', '2016-06-08 05:22:28', '2016-07-01 12:09:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_power`
--

CREATE TABLE `user_power` (
  `upow_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `function_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `user_power`
--

TRUNCATE TABLE `user_power`;
--
-- Dumping data for table `user_power`
--

INSERT INTO `user_power` (`upow_id`, `user_id`, `function_id`) VALUES
(3, 2, 3),
(9, 2, 5),
(10, 2, 6),
(19, 2, 4),
(20, 2, 8),
(21, 2, 9),
(22, 2, 10),
(23, 2, 11),
(24, 2, 12),
(25, 2, 13),
(26, 2, 14),
(27, 2, 15),
(28, 2, 16),
(29, 2, 17),
(30, 2, 18),
(31, 2, 19),
(32, 2, 20),
(33, 2, 21),
(34, 2, 22),
(35, 2, 23);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucher_id` int(11) NOT NULL,
  `vdate` date DEFAULT NULL,
  `ps_id` int(11) DEFAULT NULL,
  `trader` int(11) DEFAULT NULL,
  `processed_books` int(11) DEFAULT NULL,
  `unreported_books` int(11) DEFAULT NULL,
  `final` int(1) DEFAULT NULL,
  `rate` float(5,2) DEFAULT NULL,
  `billed_books` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `trader` (`trader`);

--
-- Indexes for table `bill_voucher`
--
ALTER TABLE `bill_voucher`
  ADD PRIMARY KEY (`bv_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Indexes for table `binding_process`
--
ALTER TABLE `binding_process`
  ADD PRIMARY KEY (`bp_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_code` (`book_code`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `book_size` (`book_size`);

--
-- Indexes for table `book_production`
--
ALTER TABLE `book_production`
  ADD PRIMARY KEY (`bp_id`),
  ADD KEY `book_code` (`book_code`);

--
-- Indexes for table `book_size`
--
ALTER TABLE `book_size`
  ADD PRIMARY KEY (`bs_id`);

--
-- Indexes for table `bp_machine`
--
ALTER TABLE `bp_machine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bp_id` (`bp_id`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `bp_so`
--
ALTER TABLE `bp_so`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bp_id` (`bp_id`),
  ADD KEY `so_id` (`so_id`);

--
-- Indexes for table `functions`
--
ALTER TABLE `functions`
  ADD PRIMARY KEY (`function_id`),
  ADD KEY `func_category` (`func_category`);

--
-- Indexes for table `func_category`
--
ALTER TABLE `func_category`
  ADD PRIMARY KEY (`fc_id`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`machine_id`);

--
-- Indexes for table `print_voucher`
--
ALTER TABLE `print_voucher`
  ADD PRIMARY KEY (`pvoucher_id`),
  ADD KEY `bp_id` (`bp_id`);

--
-- Indexes for table `production_steps`
--
ALTER TABLE `production_steps`
  ADD PRIMARY KEY (`ps_id`),
  ADD KEY `bproduction_id` (`bproduction_id`),
  ADD KEY `bp_id` (`bp_id`),
  ADD KEY `so_id` (`so_id`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `special_options` (`special_options`),
  ADD KEY `book_size` (`book_size`),
  ADD KEY `binding_process` (`binding_process`),
  ADD KEY `machine` (`machine`);

--
-- Indexes for table `special_options`
--
ALTER TABLE `special_options`
  ADD PRIMARY KEY (`so_id`);

--
-- Indexes for table `trader`
--
ALTER TABLE `trader`
  ADD PRIMARY KEY (`trader_id`),
  ADD UNIQUE KEY `pan` (`pan`),
  ADD UNIQUE KEY `license` (`license`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_power`
--
ALTER TABLE `user_power`
  ADD PRIMARY KEY (`upow_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `function_id` (`function_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucher_id`),
  ADD KEY `ps_id` (`ps_id`),
  ADD KEY `trader` (`trader`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bill_voucher`
--
ALTER TABLE `bill_voucher`
  MODIFY `bv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `binding_process`
--
ALTER TABLE `binding_process`
  MODIFY `bp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `book_production`
--
ALTER TABLE `book_production`
  MODIFY `bp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `book_size`
--
ALTER TABLE `book_size`
  MODIFY `bs_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `bp_machine`
--
ALTER TABLE `bp_machine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bp_so`
--
ALTER TABLE `bp_so`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `functions`
--
ALTER TABLE `functions`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `func_category`
--
ALTER TABLE `func_category`
  MODIFY `fc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `machine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `print_voucher`
--
ALTER TABLE `print_voucher`
  MODIFY `pvoucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `production_steps`
--
ALTER TABLE `production_steps`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `special_options`
--
ALTER TABLE `special_options`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `trader`
--
ALTER TABLE `trader`
  MODIFY `trader_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_power`
--
ALTER TABLE `user_power`
  MODIFY `upow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`trader`) REFERENCES `trader` (`trader_id`);

--
-- Constraints for table `bill_voucher`
--
ALTER TABLE `bill_voucher`
  ADD CONSTRAINT `bill_voucher_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`),
  ADD CONSTRAINT `bill_voucher_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`voucher_id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`book_size`) REFERENCES `book_size` (`bs_id`);

--
-- Constraints for table `book_production`
--
ALTER TABLE `book_production`
  ADD CONSTRAINT `book_production_ibfk_1` FOREIGN KEY (`book_code`) REFERENCES `books` (`book_code`);

--
-- Constraints for table `bp_machine`
--
ALTER TABLE `bp_machine`
  ADD CONSTRAINT `bp_machine_ibfk_1` FOREIGN KEY (`bp_id`) REFERENCES `binding_process` (`bp_id`),
  ADD CONSTRAINT `bp_machine_ibfk_2` FOREIGN KEY (`machine_id`) REFERENCES `machine` (`machine_id`);

--
-- Constraints for table `bp_so`
--
ALTER TABLE `bp_so`
  ADD CONSTRAINT `bp_so_ibfk_1` FOREIGN KEY (`bp_id`) REFERENCES `binding_process` (`bp_id`),
  ADD CONSTRAINT `bp_so_ibfk_2` FOREIGN KEY (`so_id`) REFERENCES `special_options` (`so_id`);

--
-- Constraints for table `functions`
--
ALTER TABLE `functions`
  ADD CONSTRAINT `functions_ibfk_1` FOREIGN KEY (`func_category`) REFERENCES `func_category` (`fc_id`);

--
-- Constraints for table `print_voucher`
--
ALTER TABLE `print_voucher`
  ADD CONSTRAINT `print_voucher_ibfk_2` FOREIGN KEY (`bp_id`) REFERENCES `book_production` (`bp_id`);

--
-- Constraints for table `production_steps`
--
ALTER TABLE `production_steps`
  ADD CONSTRAINT `production_steps_ibfk_1` FOREIGN KEY (`bproduction_id`) REFERENCES `book_production` (`bp_id`),
  ADD CONSTRAINT `production_steps_ibfk_2` FOREIGN KEY (`bp_id`) REFERENCES `binding_process` (`bp_id`),
  ADD CONSTRAINT `production_steps_ibfk_3` FOREIGN KEY (`so_id`) REFERENCES `special_options` (`so_id`),
  ADD CONSTRAINT `production_steps_ibfk_4` FOREIGN KEY (`machine_id`) REFERENCES `machine` (`machine_id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`special_options`) REFERENCES `special_options` (`so_id`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`book_size`) REFERENCES `book_size` (`bs_id`),
  ADD CONSTRAINT `rate_ibfk_3` FOREIGN KEY (`binding_process`) REFERENCES `binding_process` (`bp_id`),
  ADD CONSTRAINT `rate_ibfk_4` FOREIGN KEY (`machine`) REFERENCES `machine` (`machine_id`);

--
-- Constraints for table `user_power`
--
ALTER TABLE `user_power`
  ADD CONSTRAINT `user_power_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_power_ibfk_2` FOREIGN KEY (`function_id`) REFERENCES `functions` (`function_id`);

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_ibfk_1` FOREIGN KEY (`ps_id`) REFERENCES `production_steps` (`ps_id`),
  ADD CONSTRAINT `vouchers_ibfk_2` FOREIGN KEY (`trader`) REFERENCES `trader` (`trader_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
