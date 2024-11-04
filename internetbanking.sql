-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql308.vastserve.com
-- Generation Time: Nov 04, 2024 at 03:29 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vasts_37599366_internetbanking`
--

-- --------------------------------------------------------

--
-- Table structure for table `ib_acc_types`
--

CREATE TABLE `ib_acc_types` (
  `acctype_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `rate` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_acc_types`
--

INSERT INTO `ib_acc_types` (`acctype_id`, `name`, `description`, `rate`, `code`) VALUES
(1, 'Savings', '<p>Savings accounts&nbsp;are typically the first official bank account anybody opens. Children may open an account with a parent to begin a pattern of saving. Teenagers open accounts to stash cash earned&nbsp;from a first job&nbsp;or household chores.</p><p>Savings accounts are an excellent place to park&nbsp;emergency cash. Opening a savings account also marks the beginning of your relationship with a financial institution. For example, when joining a credit union, your &ldquo;share&rdquo; or savings account establishes your membership.</p>', '20', 'ACC-CAT-4EZFO'),
(2, ' Retirement', '<p>Retirement accounts&nbsp;offer&nbsp;tax advantages. In very general terms, you get to&nbsp;avoid paying income tax on interest&nbsp;you earn from a savings account or CD each year. But you may have to pay taxes on those earnings at a later date. Still, keeping your money sheltered from taxes may help you over the long term. Most banks offer IRAs (both&nbsp;Traditional IRAs&nbsp;and&nbsp;Roth IRAs), and they may also provide&nbsp;retirement accounts for small businesses</p>', '10', 'ACC-CAT-1QYDV'),
(4, 'Recurring deposit', '<p><strong>Recurring deposit account or RD account</strong> is opened by those who want to save certain amount of money regularly for a certain period of time and earn a higher interest rate.&nbsp;In RD&nbsp;account a&nbsp;fixed amount is deposited&nbsp;every month for a specified period and the total amount is repaid with interest at the end of the particular fixed period.&nbsp;</p><p>The period of deposit is minimum six months and maximum ten years.&nbsp;The interest rates vary&nbsp;for different plans based on the amount one saves and the period of time and also on banks. No withdrawals are allowed from the RD account. However, the bank may allow to close the account before the maturity period.</p><p>These accounts can be opened in single or joint names. Banks are also providing the Nomination facility to the RD account holders.&nbsp;</p>', '15', 'ACC-CAT-VBQLE'),
(5, 'Fixed Deposit Account', '<p>In <strong>Fixed Deposit Account</strong> (also known as <strong>FD Account</strong>), a particular sum of money is deposited in a bank for specific period of time. It’s one time deposit and one time take away (withdraw) account. The money deposited in this account can not be withdrawn before the expiry of period. </p><p>However, in case of need,  the depositor can ask for closing the fixed deposit prematurely by paying a penalty. The penalty amount varies with banks.</p><p>A high interest rate is paid on fixed deposits. The rate of interest paid for fixed deposit vary according to amount, period and also from bank to bank.</p>', '45', 'ACC-CAT-A86GO'),
(7, 'Current account', '<p><strong>Current account</strong> is mainly for business persons, firms, companies, public enterprises etc and are never used for the purpose of investment or savings.These deposits are the most liquid deposits and there are no limits for number of transactions or the amount of transactions in a day. While, there is no interest paid on amount held in the account, banks charges certain &nbsp;service charges, on such accounts. The current accounts do not have any fixed maturity as these are on continuous basis accounts.</p>', '20', 'ACC-CAT-4O8QW'),
(8, 'xytuwigo@mailinator.com', 'Ipsam illum explica', '57', 'ACC-CAT-9X2OK'),
(9, 'zibuqac@mailinator.com', 'Dolor mollit minim i', '2024', 'ACC-CAT-D6G37'),
(11, 'Belle Brown', 'Eu laborum enim cupi', '2013', 'ACC-CAT-6RG84');

-- --------------------------------------------------------

--
-- Table structure for table `ib_admin`
--

CREATE TABLE `ib_admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_admin`
--

INSERT INTO `ib_admin` (`admin_id`, `name`, `email`, `number`, `password`, `profile_pic`) VALUES
(2, 'System Admin', 'admin@mail.com', 'iBank-ADM-0516', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '1.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_bankaccounts`
--

CREATE TABLE `ib_bankaccounts` (
  `account_id` int(11) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_rates` varchar(200) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `acc_amount` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL,
  `client_email` varchar(200) NOT NULL,
  `client_adr` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_bankaccounts`
--

INSERT INTO `ib_bankaccounts` (`account_id`, `acc_name`, `account_number`, `acc_type`, `acc_rates`, `acc_status`, `acc_amount`, `client_id`, `client_name`, `client_national_id`, `client_phone`, `client_number`, `client_email`, `client_adr`, `created_at`) VALUES
(13, 'Christine Moore', '421873905', 'Current account ', '20', 'Active', '0', '4', 'Christine Moore', '478545445812', '7785452210', 'iBank-CLIENT-9501', 'christine@mail.com', '445 Bleck Street', '2022-08-30 17:45:18.749496'),
(14, 'Harry M Den', '357146928', 'Savings ', '20', 'Active', '0', '5', 'Harry Den', '100014001000', '7412560000', 'iBank-CLIENT-7014', 'harryden@mail.com', '114 Allace Avenue', '2023-01-10 15:45:16.753509'),
(15, 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', '20', 'Active', '0', '8', 'Amanda Stiefel', '478000001', '7850000014', 'iBank-CLIENT-0423', 'amanda@mail.com', '92 Maple Street', '2024-10-29 08:40:21.770018'),
(16, 'Johnnie Reyes', '705239816', 'Fixed Deposit Account', '45', 'Active', '0', '6', 'Johnnie J. Reyes', '147455554', '7412545454', 'iBank-CLIENT-1698', 'reyes@mail.com', '23 Hinkle Deegan Lake Road', '2024-10-29 08:45:27.897955'),
(17, 'Liam M. Moore', '719360482', 'Savings ', '20', 'Active', '0', '9', 'Liam Moore', '170014695', '7014569696', 'iBank-CLIENT-4716', 'liamoore@mail.com', '46 Timberbrook Lane', '2023-02-16 16:28:37.437656'),
(19, 'test', '319086724', 'Recurring deposit ', '15', 'Active', '0', '3', 'John Doe', '36756481', '9897890089', 'iBank-CLIENT-8127', 'johndoe@gmail.com', '127007 Localhost', '2024-10-25 09:04:56.863403'),
(20, 'test2', '9683401527', 'Current account', '20', '', '', '9', 'Liam Moore', '170014695', '7014569696', 'iBank-CLIENT-4716', 'liamoore@mail.com', '46 Timberbrook Lane', '2024-10-29 08:32:38.306329'),
(22, 'test222', '3647810295', 'Wallace Ballard', '1998', '', '', '12', 'Ann Boone', 'Velit vel anim sed o', '+1 (581) 568-5358', 'iBank-CLIENT-6023', 'qexofilox@mailinator.com', 'Dolorum ipsum est si', '2024-10-29 07:48:22.134566'),
(24, 'test@', '947813605', 'Current account ', '20', 'Active', '0', '6', 'Johnnie J. Reyes', '147455554', '7412545454', 'iBank-CLIENT-1698', 'reyes@mail.com', '23 Hinkle Deegan Lake Road', '2024-10-29 07:59:04.266864'),
(25, 'test456', '256719340', ' Retirement', '20', 'Active', '0', '9', 'Liam Moore', '170014695', '7014569696', 'iBank-CLIENT-4716', 'liamoore@mail.com', '46 Timberbrook Lane', '2024-10-29 08:39:24.864115'),
(26, 'Opio George Michael', '640732198', 'Fixed Deposit Account ', '45', 'Active', '0', '4', 'Christine Moore', '478545445812', '7785452210', 'iBank-CLIENT-9501', 'christine@mail.com', '445 Bleck Street', '2024-10-29 08:02:37.992907'),
(27, 'Opio George Michael', '120534978', 'Savings', '', 'Active', '0', '11', 'Gillian Merrillf', 'Ratione vel optio s', '+1 (463) 108-7581', 'iBank-CLIENT-3095', 'fexugiwak@mailinator.com', 'Consequatur Qua ab', '2024-10-29 22:34:32.801597'),
(28, 'vcxvxvx', '259418036', 'Fixed Deposit Account ', '45', 'Active', '0', '8', 'Amanda Stiefel', '478000001', '7850000014', 'iBank-CLIENT-0423', 'amanda@mail.com', '92 Maple Street', '2024-10-30 14:39:12.218068');

-- --------------------------------------------------------

--
-- Table structure for table `ib_clients`
--

CREATE TABLE `ib_clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `national_id` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_clients`
--

INSERT INTO `ib_clients` (`client_id`, `name`, `national_id`, `phone`, `address`, `email`, `password`, `profile_pic`, `client_number`) VALUES
(3, 'John Doe', '36756481', '9897890089', '127007 Localhost', 'john@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '2.png', 'iBank-CLIENT-8127'),
(4, 'Christine Moore', '478545445812', '7785452210', '445 Bleck Street', 'christine@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '3.png', 'iBank-CLIENT-9501'),
(5, 'Harry Den', '100014001000', '7412560000', '114 Allace Avenue', 'harry@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '4.png', 'iBank-CLIENT-7014'),
(6, 'Johnnie J. Reyes', '147455554', '7412545454', '23 Hinkle Deegan Lake Road', 'johnnie@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '5.png', 'iBank-CLIENT-1698'),
(8, 'Amanda Stiefel', '478000001', '7850000014', '92 Maple Street', 'amanda@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '6.png', 'iBank-CLIENT-0423'),
(9, 'Liam Moore', '170014695', '7014569696', '46 Timberbrook Lane', 'liam@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '7.png', 'iBank-CLIENT-4716'),
(10, 'Marvin Kell', 'Enim commodi sit dol', '+1 (336) 382-8791', 'Sint sed sit dolores', 'marvin@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '3.png', 'iBank-CLIENT-3702'),
(11, 'Gillian Merrillf', 'Ratione vel optio s', '+1 (463) 108-7581', 'Consequatur Qua ab', 'gillian@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '4.png', 'iBank-CLIENT-3095'),
(12, 'Ann Boone', 'Velit vel anim sed o', '+1 (581) 568-5358', 'Dolorum ipsum est si', 'ann@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', '5.png', 'iBank-CLIENT-6023');

-- --------------------------------------------------------

--
-- Table structure for table `ib_loans`
--

CREATE TABLE `ib_loans` (
  `ln_id` int(11) NOT NULL,
  `ln_code` varchar(255) DEFAULT NULL,
  `account_id` varchar(225) DEFAULT NULL,
  `client_email` varchar(225) DEFAULT NULL,
  `acc_name` varchar(225) DEFAULT NULL,
  `account_number` varchar(225) DEFAULT NULL,
  `acc_type` varchar(255) DEFAULT NULL,
  `ln_amount` varchar(225) DEFAULT NULL,
  `interest_rate` varchar(225) DEFAULT NULL,
  `ln_status` varchar(225) DEFAULT '',
  `client_id` varchar(225) DEFAULT NULL,
  `client_name` varchar(225) DEFAULT NULL,
  `client_national_id` varchar(225) DEFAULT NULL,
  `client_phone` varchar(225) DEFAULT NULL,
  `ln_period` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ib_loans`
--

INSERT INTO `ib_loans` (`ln_id`, `ln_code`, `account_id`, `client_email`, `acc_name`, `account_number`, `acc_type`, `ln_amount`, `interest_rate`, `ln_status`, `client_id`, `client_name`, `client_national_id`, `client_phone`, `ln_period`, `created_at`) VALUES
(1, 'YN2DLB0Q67HGSVXRECW9', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '1000', '12', 'Approved', '4', 'Christine Moore', '478545445812', '7785452210', '11', '2024-10-31 09:01:06'),
(2, 'AYX8KT9MPVF4SUCLBHR0', '27', 'gillian@mail.com', 'Opio George Michael', '120534978', 'Select Any Account types', '1344', '12', 'Approved', '11', 'Gillian Merrillf', 'Ratione vel optio s', '+1 (463) 108-7581', '11', '2024-10-31 09:01:18'),
(3, 'DPMNACWSUTBX9Q2KO37G', '16', 'johnnie@mail.com', 'Johnnie Reyes', '705239816', 'Fixed Deposit Account', '1000', '12', 'Rejected', '6', 'Johnnie J. Reyes', '147455554', '7412545454', '11', '2024-10-31 09:01:36'),
(4, '231NHI5VGUAKPWCMFQ96', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '1000', '30', 'Approved', '4', 'Christine Moore', '478545445812', '7785452210', '7', '2024-10-31 09:01:49'),
(5, 'FCS28XTYPVKUJMOLHG69', '19', 'john@mail.com', 'test', '319086724', 'Recurring deposit ', '1344', '30', 'Approved', '3', 'John Doe', '36756481', '9897890089', '7', '2024-10-31 11:27:37'),
(6, 'MB3C8KGHF6ES02JNVT4I', '15', 'amanda@mail.com', 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', '1000', '30', 'Approved', '8', 'Amanda Stiefel', '478000001', '7850000014', '7', '2024-10-31 09:02:21'),
(7, 'C4SYL8WN7FDI9RXBM0GZ', '15', '0abc0xyz@proton.meamanda@mail.com', 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', '1344', '30', 'Rejected', '8', 'Amanda Stiefel', '478000001', '7850000014', '7', '2024-10-31 09:02:16'),
(8, 'ODPK48BRC5JYI0AV79LS', '15', 'amanda@mail.com', 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', '1346789', '30', 'Approved', '8', 'Amanda Stiefel', '478000001', '7850000014', '7686', '2024-10-31 11:31:34'),
(10, '9PG3Z0XIO7RU82SFCA1L', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '1000', '12', 'Approved', '4', 'Christine Moore', '478545445812', '7785452210', '11', '2024-10-31 09:01:54'),
(11, 'S3RDLK0IU6TVMP7N5BCG', '28', '0abc0xyz@proton.me', 'vcxvxvx', '259418036', 'Fixed Deposit Account ', '1000', '12', 'Approved', '8', 'Amanda Stiefel', '478000001', '7850000014', '11', '2024-10-31 11:32:35'),
(12, 'SWVUJQYMDTEK7XZG56LC', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '1000', '3.5', 'Approved', '4', 'Christine Moore', '478545445812', '7785452210', '6', '2024-10-31 12:57:07'),
(13, 'O96WEN8YBUZG5XLM4DT3', '15', '0abc0xyz@proton.me', 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', '10000', '5.0', 'Approved', '8', 'Amanda Stiefel', '478000001', '7850000014', '1', '2024-11-03 23:02:05'),
(14, 'CO9PGIH1JRSUW2EYZTFB', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '3000', '4.0', 'Approved', '4', 'Christine Moore', '478545445812', '7785452210', '12', '2024-10-31 17:13:56'),
(15, 'H4WL57KIM612OB3JAVNC', '13', 'christine@mail.com', 'Christine Moore', '421873905', 'Current account ', '10000', '3.5', 'Pending', '4', 'Christine Moore', '478545445812', '7785452210', '6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ib_notifications`
--

CREATE TABLE `ib_notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_details` text NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_notifications`
--

INSERT INTO `ib_notifications` (`notification_id`, `notification_details`, `created_at`) VALUES
(20, 'Amanda Stiefel Has Deposited $ 2658 To Bank Account 287359614', '2023-02-16 16:17:22.592127'),
(21, 'Liam Moore Has Deposited $ 5650 To Bank Account 719360482', '2023-02-16 16:29:14.930350'),
(22, 'Liam Moore Has Withdrawn $ 777 From Bank Account 719360482', '2023-02-16 16:29:38.233567'),
(23, 'Liam Moore Has Transfered $ 1256 From Bank Account 719360482 To Bank Account 287359614', '2023-02-16 16:30:15.575946'),
(24, 'John Doe Has Deposited $ 8550 To Bank Account 724310586', '2023-02-16 16:40:49.513943'),
(25, 'Liam Moore Has Deposited $ 600 To Bank Account 719360482', '2023-02-16 16:40:57.385035'),
(26, 'Liam Moore Has Withdrawn $ 120 From Bank Account 719360482', '2023-02-16 16:41:14.885825'),
(27, 'John Doe Has Transfered $ 100 From Bank Account 724310586 To Bank Account 719360482', '2023-02-16 16:41:38.821974'),
(28, 'Harry Den Has Deposited $ 6800 To Bank Account 357146928', '2023-02-16 16:44:09.250277'),
(29, 'Christine Moore Has Deposited $ 10 To Bank Account 421873905', '2024-10-29 09:20:40.413893'),
(30, 'Christine Moore Has Deposited $ 1000 To Bank Account 421873905', '2024-10-29 09:21:20.727472'),
(31, 'Christine Moore Has Deposited $ 120 To Bank Account 640732198', '2024-10-29 09:22:09.151456'),
(32, 'Christine Moore Has Withdrawn $25 From Bank Account 421873905', '2024-10-29 09:46:07.552263'),
(33, 'Christine Moore Has Withdrawn $12.8 From Bank Account 421873905', '2024-10-29 09:49:06.030072'),
(34, 'Christine Moore Has Transferred $ 10 From Bank Account 421873905 To Bank Account gdgdgfdfg', '2024-10-29 09:56:13.083020'),
(35, 'Christine Moore has transferred $ 10 from account 421873905 to account 287359614', '2024-10-29 11:31:50.948618'),
(36, 'Christine Moore has transferred $ 25 from account 421873905 to account 3647810295', '2024-10-29 11:32:45.353499'),
(37, 'Christine Moore has applied for a loan of $ 1000 with Account Number 421873905', '2024-10-29 16:09:35.705904'),
(38, 'Gillian Merrillf has applied for a loan of $ 1344 with Account Number 120534978', '2024-10-29 16:18:01.076640'),
(39, 'Johnnie J. Reyes has applied for a loan of $ 1000 with Account Number 705239816', '2024-10-29 21:34:08.225855'),
(40, 'Christine Moore Has Deposited $ 10 To Bank Account 421873905', '2024-10-30 09:38:55.854669'),
(41, 'Christine Moore Has Deposited $ 10 To Bank Account 421873905', '2024-10-30 09:40:50.290794'),
(42, 'Christine Moore Has Deposited $ 10 To Bank Account 421873905', '2024-10-30 09:42:30.435834'),
(43, 'Christine Moore Has Deposited $ 10 To Bank Account 421873905', '2024-10-30 09:50:23.937963'),
(44, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:55:59.741467'),
(45, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:56:10.996588'),
(46, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:56:22.158881'),
(47, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:56:33.224557'),
(48, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:56:44.400830'),
(49, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:56:55.422935'),
(50, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:57:28.843154'),
(51, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 10:57:54.259017'),
(52, 'Christine Moore has deposited $25 to bank account 421873905', '2024-10-30 11:00:56.517760'),
(53, 'Christine Moore has deposited $12.8 to bank account 421873905', '2024-10-30 11:01:18.514415'),
(54, 'Christine Moore has deposited $10 to bank account 421873905', '2024-10-30 11:02:19.906490'),
(55, 'Christine Moore Has Withdrawn $10 From Bank Account 421873905', '2024-10-30 11:09:46.300357'),
(56, 'Christine Moore Has Withdrawn $10 From Bank Account 421873905', '2024-10-30 11:12:13.619139'),
(57, 'Christine Moore has transferred $25 from account 421873905 to account 719360482', '2024-10-30 11:20:14.361642'),
(58, 'Christine Moore has transferred $10 from account 421873905 to account 719360482', '2024-10-30 11:21:43.769930'),
(59, 'Amanda Stiefel has deposited $12.8 to bank account 287359614', '2024-10-30 13:41:21.934276'),
(60, 'Christine Moore has applied for a loan of $ 1000 with Account Number 421873905', '2024-10-30 16:54:54.876831'),
(61, 'Christine Moore has deposited $1000 to bank account 640732198', '2024-10-30 20:35:19.807003'),
(62, 'Christine Moore has deposited $25 to bank account 640732198', '2024-10-30 20:35:43.244233'),
(63, 'Christine Moore has deposited $1000 to bank account 640732198', '2024-10-30 20:35:55.622082'),
(64, 'Christine Moore has deposited $12.8 to bank account 640732198', '2024-10-30 20:36:02.628516'),
(65, 'Christine Moore has deposited $12.8 to bank account 421873905', '2024-10-30 20:36:33.701730'),
(66, 'John Doe has applied for a loan of $ 1344 with Account Number 319086724', '2024-10-30 20:54:26.810483'),
(67, 'Amanda Stiefel has applied for a loan of $ 1000 with Account Number 287359614', '2024-10-30 20:55:07.172968'),
(68, 'Amanda Stiefel has applied for a loan of $ 1344 with Account Number 287359614', '2024-10-30 21:00:15.492891'),
(69, 'Amanda Stiefel has applied for a loan of $ 1346789 with Account Number 287359614', '2024-10-30 21:03:00.226274'),
(70, 'Christine Moore has applied for a loan of $ 1000 with Account Number 421873905', '2024-10-30 21:51:52.069486'),
(71, 'Christine Moore has applied for a loan of 1000 with Account Number 421873905', '2024-10-30 21:54:23.589685'),
(72, 'Christine Moore has deposited $500 to bank account 421873905', '2024-10-31 07:22:38.488646'),
(73, 'Amanda Stiefel has applied for a loan of $ 1000 with Account Number 259418036', '2024-10-31 07:38:31.111357'),
(74, 'Christine Moore has applied for a loan of 1000 with Account Number 421873905', '2024-10-31 08:12:09.886592'),
(75, 'Amanda Stiefel has applied for a loan of $ 10000 with Account Number 287359614', '2024-10-31 08:18:04.176065'),
(76, 'Christine Moore has applied for a loan of 3000 with Account Number 421873905', '2024-10-31 09:56:46.716772'),
(77, 'Christine Moore has deposited $25 to bank account 421873905', '2024-10-31 09:57:40.691433'),
(78, 'Christine Moore has applied for a loan of 10000 with Account Number 421873905', '2024-10-31 14:13:36.127611');

-- --------------------------------------------------------

--
-- Table structure for table `ib_staff`
--

CREATE TABLE `ib_staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_staff`
--

INSERT INTO `ib_staff` (`staff_id`, `name`, `staff_number`, `phone`, `email`, `password`, `sex`, `profile_pic`) VALUES
(3, 'Staff ', 'iBank-STAFF-6785', '0704975742', 'staff@mail.com', '903b21879b4a60fc9103c3334e4f6f62cf6c3a2d', 'Female', ''),
(4, 'Michael', 'iBank-STAFF-6767', '0755000000', 'michael@mail.com', 'test', 'Male', 'test'),
(5, 'Michael', 'iBank-STAFF-6767', '0755000000', 'michael@mail.com', 'test', 'Male', 'test'),
(6, 'katumumyg@mailinator.com', 'iBank-STAFF-3548', 'mugeqaly@mailinator.com', 'huqo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', 'Female', ''),
(7, 'Timothy Rowland 2', 'iBank-STAFF-9063', '+1 (315) 664-5565', 'juhoma@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', 'Male', ''),
(8, 'Brendan Saunders', 'iBank-STAFF-2184', '+1 (753) 382-1568', 'gevoci@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', 'Male', ''),
(9, 'Opio George Michael', 'iBank-STAFF-0194', '+256 786245377', 'georgemichaelopio@gmail.com', 'b102ce1d5eebac2b6d74bda8c87c47a050c80491', 'Male', 'icon.png'),
(10, 'Opio George Michael test', 'iBank-STAFF-6278', '+1 (315) 664-5565', 'login@test.com', 'df9b7ab178916cd1277b547bdacbe457eecf85a0', 'Select Gender', 'icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_systemsettings`
--

CREATE TABLE `ib_systemsettings` (
  `id` int(11) NOT NULL,
  `sys_name` longtext NOT NULL,
  `sys_tagline` longtext NOT NULL,
  `sys_logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_systemsettings`
--

INSERT INTO `ib_systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`) VALUES
(1, 'Cheapy', 'Financial success at every service we offer.', 'icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `ib_transactions`
--

CREATE TABLE `ib_transactions` (
  `tr_id` int(11) NOT NULL,
  `tr_code` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `acc_amount` varchar(200) DEFAULT NULL,
  `tr_type` varchar(200) NOT NULL,
  `tr_status` varchar(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_national_id` varchar(200) NOT NULL,
  `transaction_amt` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `receiving_acc_no` varchar(200) DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `receiving_acc_name` varchar(200) DEFAULT NULL,
  `receiving_acc_holder` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ib_transactions`
--

INSERT INTO `ib_transactions` (`tr_id`, `tr_code`, `account_id`, `acc_name`, `account_number`, `acc_type`, `acc_amount`, `tr_type`, `tr_status`, `client_id`, `client_name`, `client_national_id`, `transaction_amt`, `client_phone`, `receiving_acc_no`, `created_at`, `receiving_acc_name`, `receiving_acc_holder`) VALUES
(41, 'RGl1EohqrgS3K4MUAHaf', '14', 'Harry M Den', '357146928', 'Savings ', '', 'Deposit', 'Success ', '5', 'Harry Den', '100014001000', '2660', '7412560000', '', '2023-01-10 15:47:21.233304', '', ''),
(42, 'FfYSvxkq7T1iHs06p2Qa', '13', 'Christine Moore', '421873905', 'Current account ', '', 'Transfer', 'Success ', '4', 'Christine Moore', '478545445812', '665', '7785452210', '357146928', '2023-02-15 16:49:45.731760', 'Harry M Den', 'Harry Den'),
(43, 'wXOyVgizubsp6UnTNfL4', '15', 'Amanda Stiefel', '287359614', 'Savings ', '', 'Deposit', 'Success ', '8', 'Amanda Stiefel', '478000001', '2658', '7850000014', '', '2023-02-16 16:17:22.506549', '', ''),
(44, '1S6wRtU3zP0igpCYyTGF', '17', 'Liam M. Moore', '719360482', 'Savings ', '', 'Deposit', 'Success ', '9', 'Liam Moore', '170014695', '5650', '7014569696', '', '2023-02-16 16:29:14.851707', '', ''),
(45, 'GCNrZ7n3oJyM62SzpKWs', '17', 'Liam M. Moore', '719360482', 'Savings ', '', 'Withdrawal', 'Success ', '9', 'Liam Moore', '170014695', '777', '7014569696', '', '2023-02-16 16:29:38.175952', '', ''),
(47, 'm2OlYZgkQwTPp5VHS9WN', '18', 'Johnny M. Doen', '724310586', 'Fixed Deposit Account ', '', 'Deposit', 'Success ', '3', 'John Doe', '36756481', '8550', '9897890089', '', '2023-02-16 16:40:49.466257', '', ''),
(52, '1pd05uLiaODox7FNC2XV', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-29 09:20:40.411819', NULL, NULL),
(53, 'H0VAD8fmLONdkvGagTZK', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '1000', '7785452210', NULL, '2024-10-29 09:21:20.725207', NULL, NULL),
(54, 'DPtrEO3Lx8ITupVdFZ9f', '26', 'Opio George Michael', '640732198', 'Fixed Deposit Account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '120', '7785452210', NULL, '2024-10-29 09:22:09.148810', NULL, NULL),
(55, 'PMxTSJvIA4WQHefd7BCo', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Withdrawal', 'Success', '4', 'Christine Moore', '478545445812', '25', '7785452210', NULL, '2024-10-29 09:46:07.551495', NULL, NULL),
(56, 'yPIhfZapqUA9jJb3oKFQ', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Withdrawal', 'Success', '4', 'Christine Moore', '478545445812', '12.8', '7785452210', NULL, '2024-10-29 09:49:06.029541', NULL, NULL),
(58, 'SbLauPUZAdzyJ57FxHQC', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Transfer', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', '287359614', '2024-10-29 11:31:50.946171', 'Amanda Stiefel', NULL),
(59, 's7ulX9cSdBATptw3UCfx', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Transfer', 'Success ', '4', 'Christine Moore', '478545445812', '25', '7785452210', '3647810295', '2024-10-29 11:32:45.351079', 'test222', NULL),
(60, 'yR1BfiqdLgmwQP8WNxnr', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 09:38:55.852219', NULL, NULL),
(61, '8fyU5T4NLhdxcvBFQCpu', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 09:40:50.284595', NULL, NULL),
(62, '5bjUWQklJFfSsqTy92dI', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 09:42:30.425358', NULL, NULL),
(63, 'Jo8sl4LZEAwnqeNjRvf0', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 09:50:23.935556', NULL, NULL),
(64, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:55:59.738906', NULL, NULL),
(65, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:56:10.993816', NULL, NULL),
(66, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:56:22.156929', NULL, NULL),
(67, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:56:33.221625', NULL, NULL),
(68, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:56:44.397929', NULL, NULL),
(69, 'mZrkh6qWjTNcHVALgnft', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:56:55.419807', NULL, NULL),
(70, '1TZ7fB9v0iYgo4MRUKpO', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:57:28.840616', NULL, NULL),
(71, 'CqUMfnG1AopZaul0KXr4', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 10:57:54.256645', NULL, NULL),
(72, '95TwFqeCnUVNDaRJMycr', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '25', '7785452210', NULL, '2024-10-30 11:00:56.515324', NULL, NULL),
(73, 'pR0PtvzFUdECkQsiV1D7', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '12.8', '7785452210', NULL, '2024-10-30 11:01:18.512056', NULL, NULL),
(74, 'fJu934tnW0my7SOwFkZ1', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 11:02:19.904451', NULL, NULL),
(75, '71UVFcW6SzpaurEkiDte', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Withdrawal', 'Success', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 11:09:46.299222', NULL, NULL),
(76, 'E1Nxn4B9yM3wPHuJzS5Y', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Withdrawal', 'Success', '4', 'Christine Moore', '478545445812', '10', '7785452210', NULL, '2024-10-30 11:12:13.618114', NULL, NULL),
(77, 'NMZov0IhkuAqr4nWO3XS', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Transfer', 'Success ', '4', 'Christine Moore', '478545445812', '25', '7785452210', '719360482', '2024-10-30 11:20:14.359671', 'Liam M. Moore', NULL),
(78, 'pqZfvyjNAVa1dYQnW7Rm', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Transfer', 'Success ', '4', 'Christine Moore', '478545445812', '10', '7785452210', '719360482', '2024-10-30 11:21:43.767644', 'Liam M. Moore', NULL),
(79, 'SY9lJUaQyAxe8kRMN3dB', '15', 'Amanda Stiefel', '287359614', 'xytuwigo@mailinator.com', NULL, 'Deposit', 'Success ', '8', 'Amanda Stiefel', '478000001', '12.8', '7850000014', NULL, '2024-10-30 13:41:21.929962', NULL, NULL),
(80, 'w42LSUd8J3McfFPXuQzr', '26', 'Opio George Michael', '640732198', 'Fixed Deposit Account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '1000', '7785452210', NULL, '2024-10-30 20:35:19.804973', NULL, NULL),
(81, '9NEPLCfSeQ1pXjT5AhlZ', '26', 'Opio George Michael', '640732198', 'Fixed Deposit Account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '25', '7785452210', NULL, '2024-10-30 20:35:43.241285', NULL, NULL),
(82, 'VoFqNYn7A3aR680LHDvy', '26', 'Opio George Michael', '640732198', 'Fixed Deposit Account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '1000', '7785452210', NULL, '2024-10-30 20:35:55.603861', NULL, NULL),
(83, 'FbSmRTdPt740e5VrqL8i', '26', 'Opio George Michael', '640732198', 'Fixed Deposit Account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '12.8', '7785452210', NULL, '2024-10-30 20:36:02.626178', NULL, NULL),
(84, '72vfZ6QRkeT01tCJqSoa', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '12.8', '7785452210', NULL, '2024-10-30 20:36:33.680428', NULL, NULL),
(85, 'wXmcBDQknAPZ4xe7SKO1', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '500', '7785452210', NULL, '2024-10-31 07:22:38.485963', NULL, NULL),
(86, 'WDXr8eIig92oVZKPhC0a', '13', 'Christine Moore', '421873905', 'Current account ', NULL, 'Deposit', 'Success ', '4', 'Christine Moore', '478545445812', '25', '7785452210', NULL, '2024-10-31 09:57:40.688639', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  ADD PRIMARY KEY (`acctype_id`);

--
-- Indexes for table `ib_admin`
--
ALTER TABLE `ib_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `ib_clients`
--
ALTER TABLE `ib_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ib_loans`
--
ALTER TABLE `ib_loans`
  ADD PRIMARY KEY (`ln_id`);

--
-- Indexes for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `ib_staff`
--
ALTER TABLE `ib_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  ADD PRIMARY KEY (`tr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ib_acc_types`
--
ALTER TABLE `ib_acc_types`
  MODIFY `acctype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ib_admin`
--
ALTER TABLE `ib_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ib_bankaccounts`
--
ALTER TABLE `ib_bankaccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ib_clients`
--
ALTER TABLE `ib_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ib_loans`
--
ALTER TABLE `ib_loans`
  MODIFY `ln_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ib_notifications`
--
ALTER TABLE `ib_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `ib_staff`
--
ALTER TABLE `ib_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ib_systemsettings`
--
ALTER TABLE `ib_systemsettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ib_transactions`
--
ALTER TABLE `ib_transactions`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
