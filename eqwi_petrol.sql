-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2023 at 08:26 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.29-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eqwi_petrol`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email_id` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `is_super_admin` int(1) NOT NULL DEFAULT '0',
  `creation_datetime` datetime NOT NULL,
  `updation_datetime` datetime DEFAULT NULL,
  `unread_alert` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `role_id`, `full_name`, `email_id`, `password`, `status`, `is_super_admin`, `creation_datetime`, `updation_datetime`, `unread_alert`) VALUES
(1, 0, 'Admin', 'admin@eqwipetrol.com', '25a41cec631264f04815eda23dc6edd9', 1, 1, '2022-09-19 10:48:01', NULL, 130),
(2, 2, 'dinesh', 'dinesh@test.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, '2022-10-18 17:42:50', '2023-01-30 13:10:26', 0),
(3, 2, 'Price Updateer', 'test@test1.com', '4297f44b13955235245b2497399d7a93', 1, 0, '2022-11-04 16:37:45', NULL, 0),
(4, 3, 'Felix', 'njinufelix@gmail.com', '5ed06a69afeaaa39163460fc2fc2ddf8', 1, 0, '2022-11-23 16:25:43', NULL, 0),
(8, 4, 'Venkatesh', 'venkatesh208@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, '2023-02-02 11:49:53', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_dashboard_menu`
--

CREATE TABLE `admin_dashboard_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#',
  `display_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sub_ids` text COLLATE utf8mb4_unicode_ci,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_dashboard_menu`
--

INSERT INTO `admin_dashboard_menu` (`id`, `menu_id`, `menu_name`, `menu_icon`, `menu_url`, `display_order`, `status`, `sub_ids`, `created_date`, `updated_date`) VALUES
(1, 0, 'Dashboard', 'fa fa-dashboard', 'admin/home', 1, 1, NULL, '2022-09-19 15:25:39', '2022-10-18 13:14:13'),
(2, 0, 'Products', 'fa fa-product-hunt', 'admin/product', 11, 1, NULL, '2022-10-17 16:27:36', '2022-10-20 16:57:54'),
(3, 0, 'Setting', 'fa fa-gear', '#', 14, 1, '4,6,13,15,22,25,32,33,34', '2022-10-17 20:44:21', '2022-10-20 16:58:29'),
(4, 3, 'Site Setting', 'fa fa-gear', 'admin/setting/site_setting', 1, 1, NULL, '2022-10-17 20:47:05', '2022-10-18 13:13:59'),
(5, 0, 'Boarding Sliders', 'fa fa-sliders', 'admin/boarding_slider', 15, 1, '6', '2022-10-18 11:39:46', '2022-10-20 16:57:24'),
(6, 3, 'CMS Pages', 'fa fa-gear', 'admin/setting/cms_pages', 4, 1, NULL, '2022-10-18 11:42:46', '2022-12-02 16:20:52'),
(8, 0, 'Admin', 'fa fa-user', '#', 2, 1, '9,10', '2022-10-18 13:40:30', '2022-10-18 13:41:10'),
(9, 8, 'Roles', 'fa fa-gear', 'admin/role', 1, 1, NULL, '2022-10-18 13:42:39', NULL),
(10, 8, 'Sub Admin', 'fa fa-user', 'admin/sub_admin', 2, 1, NULL, '2022-10-18 17:27:15', NULL),
(11, 0, 'Owners', 'fa fa-user', 'admin/owner', 3, 1, NULL, '2022-10-19 12:51:14', NULL),
(12, 0, 'Managers', 'fa fa-user', 'admin/manager', 5, 1, NULL, '2022-10-19 12:51:47', '2022-10-19 16:06:03'),
(13, 3, 'SMS Setting', 'fa fa-gear', 'admin/setting/sms_setting', 3, 1, NULL, '2022-10-19 15:38:23', '2022-12-02 16:20:34'),
(14, 0, 'Stations', 'fa fa-map-marker', 'admin/station', 4, 1, NULL, '2022-10-19 16:01:08', '2022-10-19 16:05:53'),
(15, 3, 'Contact Us', 'fa fa-gear', 'admin/setting/contact_us', 5, 1, NULL, '2022-10-19 18:12:37', '2022-12-02 16:21:02'),
(16, 0, 'Price List', 'fa fa-money', 'admin/product_price', 12, 1, NULL, '2022-10-20 11:40:38', '2022-10-20 16:57:35'),
(17, 0, 'Attendants', 'fa fa-user', 'admin/attendant', 6, 1, NULL, '2022-10-20 13:09:39', '2022-10-20 13:09:52'),
(18, 0, 'Transporters', 'fa fa-user', 'admin/transporter', 7, 1, NULL, '2022-10-20 13:24:02', NULL),
(19, 0, 'Vendors', 'fa fa-user', 'admin/vendor', 9, 1, NULL, '2022-10-20 16:59:05', '2022-10-20 17:57:51'),
(20, 0, 'Vehicles', 'fa fa-truck', 'admin/vehicle', 8, 1, NULL, '2022-10-20 17:58:51', NULL),
(21, 0, 'Orders', 'fa fa-money', 'admin/orders/status', 18, 1, NULL, '2022-11-04 10:12:16', '2022-11-10 13:14:21'),
(22, 3, 'Reject Reasons', 'fa fa-gear', 'admin/setting/reject_reason', 8, 1, NULL, '2022-11-11 12:33:18', '2022-12-02 16:12:21'),
(23, 0, 'Feedbacks', 'fa fa-commenting-o', 'admin/feedbacks', 13, 1, NULL, '2022-11-21 11:26:18', NULL),
(24, 0, 'Transactions', 'fa fa-money', 'admin/transactions', 20, 1, NULL, '2022-11-21 15:26:47', NULL),
(25, 3, 'Send Push Notifications', 'fa fa-gear', 'admin/setting/push_notification', 6, 1, NULL, '2022-11-23 11:44:12', '2022-12-02 16:21:12'),
(26, 0, 'Help & Supports', 'fa fa-question-circle', '#', 16, 1, '29,30', '2022-11-28 14:55:12', '2022-11-30 14:41:42'),
(27, 0, 'Order Reviews', 'fa fa-star', 'admin/order_reviews', 19, 1, NULL, '2022-11-28 18:05:14', '2022-12-05 16:29:02'),
(28, 0, 'Advertisements', 'fa fa-buysellads', 'admin/advertisement', 17, 1, NULL, '2022-11-29 12:25:20', NULL),
(29, 26, 'Raised Tickets', 'fa fa-question-circle', 'admin/help/ticket', 2, 1, NULL, '2022-11-30 14:40:19', NULL),
(30, 26, 'Help & Supports', 'fa fa-gear', 'admin/help', 1, 1, NULL, '2022-11-30 14:41:08', NULL),
(31, 0, 'Coupons', 'fa fa-file', 'admin/coupon', 19, 1, NULL, '2022-11-30 19:05:43', '2022-11-30 19:06:08'),
(32, 3, 'Payment Gateway Setting', 'fa fa-gear', 'admin/setting/payment_gateway_setting', 7, 1, NULL, '2022-12-02 16:13:42', NULL),
(33, 3, 'Email Setting', 'fa fa-gear', 'admin/setting/email_setting', 2, 1, NULL, '2022-12-02 16:21:35', NULL),
(34, 3, 'App Version', 'fa fa-gear', 'admin/setting/app_version', 9, 1, NULL, '2022-12-03 11:05:45', NULL),
(35, 0, 'Vendor Purchase', 'fa fa-money', 'admin/vendor_purchase', 10, 1, NULL, '2022-12-05 12:06:37', NULL),
(36, 0, 'Database Backup', 'fa fa-database', 'admin/backup', 30, 1, NULL, '2022-12-05 15:21:34', '2022-12-05 17:10:50'),
(37, 0, 'Reports', 'fa fa-file', 'admin/reports', 25, 1, NULL, '2022-12-06 12:53:32', NULL),
(38, 0, 'Transporters Not Available', 'fa fa-user', 'admin/transporter/availability', 7, 1, NULL, '2023-01-13 17:39:13', '2023-02-02 11:07:50'),
(39, 0, 'Transporter Notifications', 'fa fa-envelope', 'admin/notifications', 18, 1, NULL, '2023-01-27 13:54:42', '2023-01-31 12:58:01'),
(40, 0, 'Admin Send Notifications', 'fa fa-envelope', 'admin/admin_notifications', 19, 1, NULL, '2023-01-31 12:59:12', NULL),
(41, 0, 'New Orders Availability', 'fa fa-truck', 'admin/vehicle/availability', 8, 1, NULL, '2023-03-20 18:53:39', '2023-03-20 18:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_privileges`
--

CREATE TABLE `admin_user_privileges` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `menu_type` enum('M','S') NOT NULL COMMENT 'M - Main, S - Sub',
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_url` varchar(100) NOT NULL DEFAULT '#',
  `list_p` int(1) NOT NULL,
  `add_p` int(1) NOT NULL,
  `edit_p` int(1) NOT NULL,
  `delete_p` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user_privileges`
--

INSERT INTO `admin_user_privileges` (`id`, `admin_id`, `menu_type`, `menu_id`, `menu_name`, `menu_url`, `list_p`, `add_p`, `edit_p`, `delete_p`, `created_date`, `updated_date`) VALUES
(30, 4, 'M', 1, 'Dashboard', 'admin/home', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(31, 4, 'M', 8, 'Admin', '#', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(39, 4, 'M', 2, 'Products', 'admin/product', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(42, 4, 'M', 3, 'Setting', '#', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(43, 4, 'M', 5, 'Boarding Sliders', 'admin/boarding_slider', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(46, 4, 'S', 9, 'Roles', 'admin/role', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(47, 4, 'S', 10, 'Sub Admin', 'admin/sub_admin', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(48, 4, 'S', 4, 'Site Setting', 'admin/setting/site_setting', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(50, 4, 'S', 6, 'CMS Pages', 'admin/setting/cms_pages', 1, 1, 1, 1, '2022-11-23 16:25:43', NULL),
(181, 8, 'M', 1, 'Dashboard', 'admin/home', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(182, 8, 'M', 8, 'Admin', '#', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(183, 8, 'M', 11, 'Owners', 'admin/owner', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(184, 8, 'M', 14, 'Stations', 'admin/station', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(185, 8, 'M', 12, 'Managers', 'admin/manager', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(186, 8, 'M', 17, 'Attendants', 'admin/attendant', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(187, 8, 'M', 18, 'Transporters', 'admin/transporter', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(188, 8, 'M', 38, 'Transporters Not Available', 'admin/transporter/availability', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(189, 8, 'M', 20, 'Vehicles', 'admin/vehicle', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(190, 8, 'M', 19, 'Vendors', 'admin/vendor', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(191, 8, 'M', 35, 'Vendor Purchase', 'admin/vendor_purchase', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(192, 8, 'M', 2, 'Products', 'admin/product', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(193, 8, 'M', 16, 'Price List', 'admin/product_price', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(194, 8, 'M', 23, 'Feedbacks', 'admin/feedbacks', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(195, 8, 'M', 3, 'Setting', '#', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(196, 8, 'M', 5, 'Boarding Sliders', 'admin/boarding_slider', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(197, 8, 'M', 26, 'Help & Supports', '#', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(198, 8, 'M', 28, 'Advertisements', 'admin/advertisement', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(199, 8, 'M', 21, 'Orders', 'admin/orders/status', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(200, 8, 'M', 39, 'Transporter Notifications', 'admin/notifications', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(201, 8, 'M', 27, 'Order Reviews', 'admin/order_reviews', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(202, 8, 'M', 31, 'Coupons', 'admin/coupon', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(203, 8, 'M', 40, 'Admin Send Notifications', 'admin/admin_notifications', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(204, 8, 'M', 24, 'Transactions', 'admin/transactions', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(205, 8, 'M', 37, 'Reports', 'admin/reports', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(206, 8, 'M', 36, 'Database Backup', 'admin/backup', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(207, 8, 'S', 9, 'Roles', 'admin/role', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(208, 8, 'S', 10, 'Sub Admin', 'admin/sub_admin', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(209, 8, 'S', 4, 'Site Setting', 'admin/setting/site_setting', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(210, 8, 'S', 33, 'Email Setting', 'admin/setting/email_setting', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(211, 8, 'S', 13, 'SMS Setting', 'admin/setting/sms_setting', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(212, 8, 'S', 6, 'CMS Pages', 'admin/setting/cms_pages', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(213, 8, 'S', 15, 'Contact Us', 'admin/setting/contact_us', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(214, 8, 'S', 25, 'Send Push Notifications', 'admin/setting/push_notification', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(215, 8, 'S', 32, 'Payment Gateway Setting', 'admin/setting/payment_gateway_setting', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(216, 8, 'S', 22, 'Reject Reasons', 'admin/setting/reject_reason', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(217, 8, 'S', 34, 'App Version', 'admin/setting/app_version', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(218, 8, 'S', 30, 'Help & Supports', 'admin/help', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL),
(219, 8, 'S', 29, 'Raised Tickets', 'admin/help/ticket', 0, 0, 0, 0, '2023-02-02 11:49:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `advertisement_type` enum('Owner','Transporter','Both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `title`, `description`, `image`, `display_order`, `advertisement_type`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Test Advertisement', 'Test Advertisement Description', 'ads_2411669963770.png', 2, 'Transporter', 0, '2022-11-29 12:32:27', '2023-01-18 12:14:25'),
(2, 'Test Advertisement', 'Our Trucks', 'ads_4691670827705.png', 1, 'Both', 1, '2022-12-12 12:18:25', '2023-02-01 15:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `assign_orders`
--

CREATE TABLE `assign_orders` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `transporter_id` bigint(20) NOT NULL,
  `station_id` bigint(20) NOT NULL,
  `pickup_data` text COLLATE utf8mb4_unicode_ci,
  `station_data` text COLLATE utf8mb4_unicode_ci,
  `assign_status` enum('New','Pending','Accept','Reject','Delivered') COLLATE utf8mb4_unicode_ci DEFAULT 'New',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `assign_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_orders`
--

INSERT INTO `assign_orders` (`id`, `order_id`, `transporter_id`, `station_id`, `pickup_data`, `station_data`, `assign_status`, `status`, `assign_datetime`) VALUES
(919, 1215, 19, 150, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"150\",\"owner_id\":\"68\",\"station_name\":\"testpro\",\"contact_person\":\"testpromax\",\"contact_number\":\"990123456\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Muranga County\",\"city\":\"gonego\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Unnamed Road,Unnamed Road,\",\"latitude\":\"-0.9437974988948927\",\"longitude\":\"37.06382766366005\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-03-03 12:55:54\",\"updated_date\":null}', 'Delivered', 0, '2023-03-27 17:48:27'),
(921, 1217, 19, 88, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"88\",\"owner_id\":\"107\",\"station_name\":\"swathi station\",\"contact_person\":\"swathi\",\"contact_number\":\"9632580741\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Vizianagaram\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"5CFV+66H,5CFV+66H,\",\"latitude\":\"18.172729180245955\",\"longitude\":\"83.44373267143965\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2022-12-05 14:18:45\",\"updated_date\":\"2023-03-21 16:58:44\"}', 'Delivered', 0, '2023-03-28 14:20:56'),
(922, 1243, 0, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Pending', 0, '2023-04-20 14:35:10'),
(923, 1245, 0, 176, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"176\",\"owner_id\":\"243\",\"station_name\":\"dinesh station\",\"contact_person\":\"dinesh\",\"contact_number\":\"1234567890\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Nairobi County\",\"city\":\"Nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kenya,Nairobi Central TEMPLE MUMBI HSE Starehe,\",\"latitude\":\"-1.2467308241721295\",\"longitude\":\"36.824423745274544\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-27 11:27:55\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 12:13:56'),
(924, 1248, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 12:28:08'),
(925, 1249, 0, 176, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"176\",\"owner_id\":\"243\",\"station_name\":\"dinesh station\",\"contact_person\":\"dinesh\",\"contact_number\":\"1234567890\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Nairobi County\",\"city\":\"Nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kenya,Nairobi Central TEMPLE MUMBI HSE Starehe,\",\"latitude\":\"-1.2467308241721295\",\"longitude\":\"36.824423745274544\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-27 11:27:55\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 12:31:53'),
(926, 1244, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 12:43:58'),
(927, 1250, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 13:53:54'),
(928, 1251, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'New', 0, '2023-04-27 14:01:09'),
(929, 1252, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 14:01:10'),
(930, 1251, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 14:01:10'),
(931, 1253, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'New', 0, '2023-04-27 14:02:09'),
(932, 1253, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 14:02:11'),
(933, 1254, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 14:02:24'),
(934, 1256, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-04-27 15:12:16'),
(935, 1257, 0, 156, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"156\",\"owner_id\":\"205\",\"station_name\":\"Lake oil\",\"contact_person\":\"jenny\",\"contact_number\":\"0719585416\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Machakos County\",\"city\":\"nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kangundo Road,Kangundo Rd,\",\"latitude\":\"-1.2802605\",\"longitude\":\"37.109272\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-03-31 15:48:52\",\"updated_date\":null}', 'New', 0, '2023-04-28 14:50:02'),
(936, 1257, 0, 156, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"156\",\"owner_id\":\"205\",\"station_name\":\"Lake oil\",\"contact_person\":\"jenny\",\"contact_number\":\"0719585416\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Machakos County\",\"city\":\"nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kangundo Road,Kangundo Rd,\",\"latitude\":\"-1.2802605\",\"longitude\":\"37.109272\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-03-31 15:48:52\",\"updated_date\":null}', 'Pending', 0, '2023-04-28 14:50:02'),
(937, 1259, 0, 156, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"156\",\"owner_id\":\"205\",\"station_name\":\"Lake oil\",\"contact_person\":\"jenny\",\"contact_number\":\"0719585416\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Machakos County\",\"city\":\"nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kangundo Road,Kangundo Rd,\",\"latitude\":\"-1.2802605\",\"longitude\":\"37.109272\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-03-31 15:48:52\",\"updated_date\":null}', 'Pending', 0, '2023-05-03 15:16:26'),
(938, 1262, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-04 14:59:37'),
(939, 1263, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-04 15:01:26'),
(940, 1264, 245, 177, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"177\",\"owner_id\":\"246\",\"station_name\":\"nayak station\",\"contact_person\":\"nayak\",\"contact_number\":\"9652148874\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"49-46-4\\/6,49-46-4\\/6,\",\"latitude\":\"17.73399742500416\",\"longitude\":\"83.30088526010513\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-05-09 17:14:21\",\"updated_date\":null}', 'Delivered', 0, '2023-05-09 17:20:17'),
(941, 1265, 245, 177, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"177\",\"owner_id\":\"246\",\"station_name\":\"nayak station\",\"contact_person\":\"nayak\",\"contact_number\":\"9652148874\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"49-46-4\\/6,49-46-4\\/6,\",\"latitude\":\"17.73399742500416\",\"longitude\":\"83.30088526010513\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-05-09 17:14:21\",\"updated_date\":null}', 'Delivered', 0, '2023-05-09 17:23:03'),
(942, 1266, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-10 11:01:18'),
(943, 1267, 19, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Accept', 0, '2023-05-10 11:05:52'),
(944, 1268, 6, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Delivered', 0, '2023-05-10 11:12:07'),
(945, 1269, 0, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Pending', 0, '2023-05-10 11:28:53'),
(946, 1271, 0, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Pending', 0, '2023-05-10 11:33:14'),
(947, 1272, 0, 159, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"159\",\"owner_id\":\"107\",\"station_name\":\"satvik station\",\"contact_person\":\"saik\",\"contact_number\":\"9632580774\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"106,106,106\",\"latitude\":\"17.7285366\",\"longitude\":\"83.3055443\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 17:06:39\",\"updated_date\":null}', 'Pending', 0, '2023-05-10 11:34:39'),
(948, 1273, 245, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-10 11:37:42'),
(949, 1274, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-10 11:40:23'),
(950, 1275, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-11 10:09:27'),
(951, 1277, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 10:12:44'),
(952, 1279, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 10:18:25'),
(953, 1280, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-11 10:22:20'),
(954, 1281, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 10:23:23'),
(955, 1283, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-11 10:41:51'),
(956, 1284, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 10:43:21'),
(957, 1286, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-11 10:48:23'),
(958, 1287, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-11 10:57:34'),
(959, 1291, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 11:03:01'),
(960, 1293, 0, 158, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"158\",\"owner_id\":\"209\",\"station_name\":\"dwaraka\",\"contact_person\":\"divya\",\"contact_number\":\"9861977974\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"5th Lane,Dwarka 5th Line,\",\"latitude\":\"17.7284721\",\"longitude\":\"83.3055308\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-03 15:23:42\",\"updated_date\":null}', 'Pending', 0, '2023-05-11 11:03:38'),
(961, 1294, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 11:12:41'),
(962, 1295, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 11:58:57'),
(963, 1296, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-11 12:40:08'),
(964, 1297, 248, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-15 10:26:52'),
(965, 1298, 248, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-15 10:27:20'),
(966, 1299, 248, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-15 10:28:21'),
(967, 1300, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-19 15:20:57'),
(968, 1301, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-19 15:21:34'),
(969, 1302, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Delivered', 0, '2023-05-19 15:22:56'),
(970, 1303, 19, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Accept', 0, '2023-05-19 16:24:51'),
(971, 1304, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-19 16:54:26'),
(972, 1305, 0, 165, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"165\",\"owner_id\":\"68\",\"station_name\":\"chaitu station\",\"contact_person\":\"chaitu\",\"contact_number\":\"9966002347\",\"alternate_number\":\"\",\"country\":\"India\",\"state\":\"Andhra Pradesh\",\"city\":\"Visakhapatnam\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"46-5-42,46-5-42,\",\"latitude\":\"17.728853994939612\",\"longitude\":\"83.30004405230284\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-04-06 17:17:25\",\"updated_date\":null}', 'Pending', 0, '2023-05-19 16:54:49'),
(973, 1306, 0, 156, '{\"address\":\"Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya\",\"contact_no\":\"9876543210\",\"latitude\":\"-1.291020\",\"longitude\":\"36.821390\"}', '{\"station_id\":\"156\",\"owner_id\":\"205\",\"station_name\":\"Lake oil\",\"contact_person\":\"jenny\",\"contact_number\":\"0719585416\",\"alternate_number\":\"\",\"country\":\"Kenya\",\"state\":\"Machakos County\",\"city\":\"nairobi\",\"pincode\":\"\",\"landmark\":\"\",\"address\":\"Kangundo Road,Kangundo Rd,\",\"latitude\":\"-1.2802605\",\"longitude\":\"37.109272\",\"geo_fencing_address\":null,\"status\":\"1\",\"created_date\":\"2023-03-31 15:48:52\",\"updated_date\":null}', 'Pending', 0, '2023-05-19 19:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `assign_order_details`
--

CREATE TABLE `assign_order_details` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `assign_order_id` bigint(20) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `reason_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_description` text COLLATE utf8mb4_unicode_ci,
  `order_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `reject_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_order_details`
--

INSERT INTO `assign_order_details` (`id`, `order_id`, `assign_order_id`, `reason_id`, `reason_title`, `reason_description`, `order_status`, `date_time`, `reject_user_id`) VALUES
(2368, 1215, 919, 0, NULL, NULL, 'New', '2023-03-27 17:48:27', 0),
(2369, 1215, 919, 0, NULL, NULL, 'Accept', '2023-03-27 17:51:35', 0),
(2370, 1215, 919, 0, NULL, NULL, 'Reach', '2023-03-27 17:53:46', 0),
(2371, 1215, 919, 0, NULL, NULL, 'Loaded', '2023-03-27 17:53:56', 0),
(2372, 1215, 919, 0, NULL, NULL, 'Delivered', '2023-03-27 17:55:52', 0),
(2381, 1217, 921, 0, NULL, NULL, 'New', '2023-03-28 14:20:56', 0),
(2382, 1217, 921, 0, NULL, NULL, 'Accept', '2023-03-28 14:22:49', 0),
(2383, 1217, 921, 0, NULL, NULL, 'Reach', '2023-03-28 14:23:38', 0),
(2384, 1217, 921, 0, NULL, NULL, 'Loaded', '2023-03-28 14:23:48', 0),
(2385, 1217, 921, 0, NULL, NULL, 'Delivered', '2023-03-28 14:23:59', 0),
(2386, 1243, 922, 0, NULL, NULL, 'New', '2023-04-20 14:35:10', 0),
(2387, 1245, 923, 0, NULL, NULL, 'New', '2023-04-27 12:13:56', 0),
(2388, 1248, 924, 0, NULL, NULL, 'New', '2023-04-27 12:28:08', 0),
(2389, 1249, 925, 0, NULL, NULL, 'New', '2023-04-27 12:31:53', 0),
(2390, 1244, 926, 0, NULL, NULL, 'New', '2023-04-27 12:43:58', 0),
(2391, 1250, 927, 0, NULL, NULL, 'New', '2023-04-27 13:53:54', 0),
(2392, 1251, 928, 0, NULL, NULL, 'New', '2023-04-27 14:01:09', 0),
(2393, 1252, 929, 0, NULL, NULL, 'New', '2023-04-27 14:01:10', 0),
(2394, 1251, 930, 0, NULL, NULL, 'New', '2023-04-27 14:01:10', 0),
(2395, 1253, 931, 0, NULL, NULL, 'New', '2023-04-27 14:02:09', 0),
(2396, 1253, 932, 0, NULL, NULL, 'New', '2023-04-27 14:02:11', 0),
(2397, 1254, 933, 0, NULL, NULL, 'New', '2023-04-27 14:02:24', 0),
(2398, 1256, 934, 0, NULL, NULL, 'New', '2023-04-27 15:12:16', 0),
(2399, 1257, 935, 0, NULL, NULL, 'New', '2023-04-28 14:50:02', 0),
(2400, 1257, 936, 0, NULL, NULL, 'New', '2023-04-28 14:50:02', 0),
(2401, 1259, 937, 0, NULL, NULL, 'New', '2023-05-03 15:16:26', 0),
(2402, 1262, 938, 0, NULL, NULL, 'New', '2023-05-04 14:59:37', 0),
(2403, 1263, 939, 0, NULL, NULL, 'New', '2023-05-04 15:01:26', 0),
(2404, 1264, 940, 0, NULL, NULL, 'New', '2023-05-09 17:20:17', 0),
(2405, 1264, 940, 0, NULL, NULL, 'Accept', '2023-05-09 17:20:43', 0),
(2406, 1265, 941, 0, NULL, NULL, 'New', '2023-05-09 17:23:03', 0),
(2407, 1265, 941, 0, NULL, NULL, 'Accept', '2023-05-09 17:23:30', 0),
(2408, 1265, 941, 0, NULL, NULL, 'Reach', '2023-05-09 17:24:03', 0),
(2409, 1264, 940, 0, NULL, NULL, 'Reach', '2023-05-09 17:24:41', 0),
(2410, 1264, 940, 0, NULL, NULL, 'Loaded', '2023-05-09 17:24:44', 0),
(2411, 1264, 940, 0, NULL, NULL, 'Delivered', '2023-05-09 17:25:01', 0),
(2412, 1265, 941, 0, NULL, NULL, 'Loaded', '2023-05-09 17:25:12', 0),
(2413, 1265, 941, 0, NULL, NULL, 'Delivered', '2023-05-09 17:25:39', 0),
(2414, 1266, 942, 0, NULL, NULL, 'New', '2023-05-10 11:01:18', 0),
(2415, 1267, 943, 0, NULL, NULL, 'New', '2023-05-10 11:05:52', 0),
(2416, 1266, 942, 0, NULL, NULL, 'Accept', '2023-05-10 11:07:31', 0),
(2417, 1268, 944, 0, NULL, NULL, 'New', '2023-05-10 11:12:07', 0),
(2418, 1268, 944, 0, NULL, NULL, 'Accept', '2023-05-10 11:12:35', 0),
(2419, 1267, 943, 0, NULL, NULL, 'Accept', '2023-05-10 11:13:10', 0),
(2420, 1268, 944, 0, NULL, NULL, 'Reach', '2023-05-10 11:13:17', 0),
(2421, 1268, 944, 0, NULL, NULL, 'Loaded', '2023-05-10 11:13:32', 0),
(2422, 1268, 944, 0, NULL, NULL, 'Delivered', '2023-05-10 11:14:12', 0),
(2423, 1267, 943, 0, NULL, NULL, 'Reach', '2023-05-10 11:16:17', 0),
(2424, 1267, 943, 0, NULL, NULL, 'Loaded', '2023-05-10 11:18:20', 0),
(2425, 1269, 945, 0, NULL, NULL, 'New', '2023-05-10 11:28:53', 0),
(2426, 1271, 946, 0, NULL, NULL, 'New', '2023-05-10 11:33:14', 0),
(2427, 1272, 947, 0, NULL, NULL, 'New', '2023-05-10 11:34:39', 0),
(2428, 1273, 948, 0, NULL, NULL, 'New', '2023-05-10 11:37:42', 0),
(2429, 1273, 948, 0, NULL, NULL, 'Accept', '2023-05-10 11:38:14', 0),
(2430, 1274, 949, 0, NULL, NULL, 'New', '2023-05-10 11:40:23', 0),
(2431, 1274, 949, 0, NULL, NULL, 'Accept', '2023-05-10 11:40:50', 0),
(2432, 1275, 950, 0, NULL, NULL, 'New', '2023-05-11 10:09:27', 0),
(2433, 1277, 951, 0, NULL, NULL, 'New', '2023-05-11 10:12:44', 0),
(2434, 1277, 951, 0, NULL, NULL, 'Accept', '2023-05-11 10:13:47', 0),
(2435, 1277, 951, 0, NULL, NULL, 'Reach', '2023-05-11 10:14:00', 0),
(2436, 1277, 951, 0, NULL, NULL, 'Loaded', '2023-05-11 10:14:07', 0),
(2437, 1277, 951, 0, NULL, NULL, 'Delivered', '2023-05-11 10:15:23', 0),
(2438, 1279, 952, 0, NULL, NULL, 'New', '2023-05-11 10:18:25', 0),
(2439, 1279, 952, 0, NULL, NULL, 'Accept', '2023-05-11 10:18:36', 0),
(2440, 1275, 950, 0, NULL, NULL, 'Accept', '2023-05-11 10:20:00', 0),
(2441, 1279, 952, 0, NULL, NULL, 'Reach', '2023-05-11 10:20:16', 0),
(2442, 1279, 952, 0, NULL, NULL, 'Loaded', '2023-05-11 10:20:19', 0),
(2443, 1279, 952, 0, NULL, NULL, 'Delivered', '2023-05-11 10:21:25', 0),
(2444, 1280, 953, 0, NULL, NULL, 'New', '2023-05-11 10:22:20', 0),
(2445, 1281, 954, 0, NULL, NULL, 'New', '2023-05-11 10:23:23', 0),
(2446, 1281, 954, 0, NULL, NULL, 'Accept', '2023-05-11 10:23:54', 0),
(2447, 1281, 954, 0, NULL, NULL, 'Reach', '2023-05-11 10:24:01', 0),
(2448, 1281, 954, 0, NULL, NULL, 'Loaded', '2023-05-11 10:24:14', 0),
(2449, 1281, 954, 0, NULL, NULL, 'Delivered', '2023-05-11 10:24:30', 0),
(2450, 1283, 955, 0, NULL, NULL, 'New', '2023-05-11 10:41:51', 0),
(2451, 1284, 956, 0, NULL, NULL, 'New', '2023-05-11 10:43:21', 0),
(2452, 1284, 956, 0, NULL, NULL, 'Accept', '2023-05-11 10:45:06', 0),
(2453, 1284, 956, 0, NULL, NULL, 'Reach', '2023-05-11 10:45:20', 0),
(2454, 1273, 948, 0, NULL, NULL, 'Reach', '2023-05-11 10:45:47', 0),
(2455, 1286, 957, 0, NULL, NULL, 'New', '2023-05-11 10:48:23', 0),
(2456, 1287, 958, 0, NULL, NULL, 'New', '2023-05-11 10:57:34', 0),
(2457, 1291, 959, 0, NULL, NULL, 'New', '2023-05-11 11:03:01', 0),
(2458, 1293, 960, 0, NULL, NULL, 'New', '2023-05-11 11:03:38', 0),
(2459, 1291, 959, 0, NULL, NULL, 'Accept', '2023-05-11 11:04:40', 0),
(2460, 1291, 959, 0, NULL, NULL, 'Reach', '2023-05-11 11:05:52', 0),
(2461, 1291, 959, 0, NULL, NULL, 'Loaded', '2023-05-11 11:05:56', 0),
(2462, 1291, 959, 0, NULL, NULL, 'Delivered', '2023-05-11 11:06:18', 0),
(2463, 1294, 961, 0, NULL, NULL, 'New', '2023-05-11 11:12:41', 0),
(2464, 1294, 961, 0, NULL, NULL, 'Accept', '2023-05-11 11:12:48', 0),
(2465, 1294, 961, 0, NULL, NULL, 'Reach', '2023-05-11 11:13:41', 0),
(2466, 1294, 961, 0, NULL, NULL, 'Loaded', '2023-05-11 11:13:45', 0),
(2467, 1294, 961, 0, NULL, NULL, 'Delivered', '2023-05-11 11:14:31', 0),
(2468, 1284, 956, 0, NULL, NULL, 'Loaded', '2023-05-11 11:19:13', 0),
(2469, 1284, 956, 0, NULL, NULL, 'Delivered', '2023-05-11 11:19:41', 0),
(2470, 1295, 962, 0, NULL, NULL, 'New', '2023-05-11 11:58:57', 0),
(2471, 1295, 962, 0, NULL, NULL, 'Accept', '2023-05-11 12:00:05', 0),
(2472, 1295, 962, 0, NULL, NULL, 'Reach', '2023-05-11 12:01:43', 0),
(2473, 1295, 962, 0, NULL, NULL, 'Loaded', '2023-05-11 12:02:01', 0),
(2474, 1295, 962, 0, NULL, NULL, 'Delivered', '2023-05-11 12:05:16', 0),
(2475, 1296, 963, 0, NULL, NULL, 'New', '2023-05-11 12:40:08', 0),
(2476, 1296, 963, 0, NULL, NULL, 'Accept', '2023-05-11 12:40:41', 0),
(2477, 1296, 963, 0, NULL, NULL, 'Reach', '2023-05-11 12:41:42', 0),
(2478, 1296, 963, 0, NULL, NULL, 'Loaded', '2023-05-11 12:42:06', 0),
(2479, 1296, 963, 0, NULL, NULL, 'Delivered', '2023-05-11 12:43:23', 0),
(2480, 1297, 964, 0, NULL, NULL, 'New', '2023-05-15 10:26:52', 0),
(2481, 1298, 965, 0, NULL, NULL, 'New', '2023-05-15 10:27:20', 0),
(2482, 1299, 966, 0, NULL, NULL, 'New', '2023-05-15 10:28:21', 0),
(2483, 1299, 966, 0, NULL, NULL, 'Accept', '2023-05-15 10:43:37', 0),
(2484, 1298, 965, 0, NULL, NULL, 'Accept', '2023-05-15 10:43:41', 0),
(2485, 1297, 964, 0, NULL, NULL, 'Accept', '2023-05-15 10:43:44', 0),
(2486, 1299, 966, 0, NULL, NULL, 'Reach', '2023-05-19 14:21:44', 0),
(2487, 1300, 967, 0, NULL, NULL, 'New', '2023-05-19 15:20:57', 0),
(2488, 1300, 967, 0, NULL, NULL, 'Accept', '2023-05-19 15:21:06', 0),
(2489, 1301, 968, 0, NULL, NULL, 'New', '2023-05-19 15:21:34', 0),
(2490, 1302, 969, 0, NULL, NULL, 'New', '2023-05-19 15:22:56', 0),
(2491, 1302, 969, 0, NULL, NULL, 'Accept', '2023-05-19 15:30:23', 0),
(2492, 1302, 969, 0, NULL, NULL, 'Reach', '2023-05-19 16:07:53', 0),
(2493, 1302, 969, 0, NULL, NULL, 'Loaded', '2023-05-19 16:08:02', 0),
(2494, 1299, 966, 0, NULL, NULL, 'Loaded', '2023-05-19 16:09:17', 0),
(2495, 1300, 967, 0, NULL, NULL, 'Reach', '2023-05-19 16:16:48', 0),
(2496, 1300, 967, 0, NULL, NULL, 'Loaded', '2023-05-19 16:17:18', 0),
(2497, 1298, 965, 0, NULL, NULL, 'Reach', '2023-05-19 16:17:55', 0),
(2498, 1299, 966, 0, NULL, NULL, 'Delivered', '2023-05-19 16:19:57', 0),
(2499, 1298, 965, 0, NULL, NULL, 'Loaded', '2023-05-19 16:20:25', 0),
(2500, 1302, 969, 0, NULL, NULL, 'Delivered', '2023-05-19 16:21:56', 0),
(2501, 1300, 967, 0, NULL, NULL, 'Delivered', '2023-05-19 16:24:21', 0),
(2502, 1303, 970, 0, NULL, NULL, 'New', '2023-05-19 16:24:51', 0),
(2503, 1275, 950, 0, NULL, NULL, 'Reach', '2023-05-19 16:25:29', 0),
(2504, 1275, 950, 0, NULL, NULL, 'Loaded', '2023-05-19 16:25:33', 0),
(2505, 1303, 970, 0, NULL, NULL, 'Accept', '2023-05-19 16:28:12', 0),
(2506, 1304, 971, 0, NULL, NULL, 'New', '2023-05-19 16:54:26', 0),
(2507, 1305, 972, 0, NULL, NULL, 'New', '2023-05-19 16:54:49', 0),
(2508, 1306, 973, 0, NULL, NULL, 'New', '2023-05-19 19:27:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `boarding_sliders`
--

CREATE TABLE `boarding_sliders` (
  `slider_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boarding_sliders`
--

INSERT INTO `boarding_sliders` (`slider_id`, `title`, `description`, `image`, `display_order`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Slider 1', 'we are happily saying we are awesome', 'slider_4581666787122.png', 1, 1, '2022-10-18 20:28:49', '2023-01-12 16:29:30'),
(2, 'Slider2', 'We provide you good standard feul', 'slider_1771666787158.png', 2, 1, '2022-10-26 17:55:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measurement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(11,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `category_id`, `name`, `type`, `image`, `measurement`, `qty`, `price`, `currency`, `total_price`, `status`, `created_date`, `updated_date`) VALUES
(628, 173, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 150, '180.00', 'KES', '27000.00', 0, '2023-01-25 14:34:31', NULL),
(638, 157, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '180.00', 'KES', '900000.00', 0, '2023-01-25 17:34:11', NULL),
(640, 70, 5, 'Kerosene', 'JET', 'product_4351669204816.jfif', 'Litr', 2000, '150.00', 'KES', '300000.00', 0, '2023-01-25 18:19:16', NULL),
(662, 122, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 214, '180.00', 'KES', '38520.00', 0, '2023-01-28 13:50:12', NULL),
(716, 191, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 122, '180.00', 'KES', '21960.00', 0, '2023-02-02 17:40:18', '2023-02-02 17:42:58'),
(717, 191, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 124, '2000.00', 'KES', '248000.00', 0, '2023-02-02 17:40:32', NULL),
(818, 3, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 150, '180.00', 'KES', '27000.00', 0, '2023-03-21 11:46:23', NULL),
(822, 206, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 1000, '2000.00', 'KES', '2000000.00', 0, '2023-03-31 17:44:03', NULL),
(823, 206, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 1080, '167.00', 'KES', '180360.00', 0, '2023-03-31 17:44:43', NULL),
(826, 206, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 3000, '180.00', 'KES', '540000.00', 0, '2023-04-02 11:56:46', '2023-04-04 17:38:45'),
(827, 208, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 10000, '180.00', 'KES', '1800000.00', 0, '2023-04-02 11:57:21', NULL),
(837, 202, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 200, '180.00', 'KES', '36000.00', 0, '2023-04-03 23:16:45', NULL),
(838, 213, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 1000, '167.00', 'KES', '167000.00', 0, '2023-04-04 03:06:09', NULL),
(839, 211, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '180.00', 'KES', '18000.00', 0, '2023-04-05 17:44:45', NULL),
(840, 215, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 188, '180.00', 'KES', '33840.00', 0, '2023-04-05 18:24:22', NULL),
(845, 219, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 1088, '180.00', 'KES', '195840.00', 0, '2023-04-10 16:40:08', NULL),
(846, 221, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 10000, '180.00', 'KES', '1800000.00', 0, '2023-04-10 16:51:07', NULL),
(847, 221, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 500, '167.00', 'KES', '83500.00', 0, '2023-04-10 16:51:38', NULL),
(848, 226, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 605, '180.00', 'KES', '108900.00', 0, '2023-04-10 17:47:19', NULL),
(849, 226, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 888, '167.00', 'KES', '148296.00', 0, '2023-04-10 17:47:31', NULL),
(853, 227, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 147, '2000.00', 'KES', '294000.00', 0, '2023-04-17 18:00:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_orders`
--

CREATE TABLE `cart_orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL,
  `shipping_charge` decimal(11,2) NOT NULL,
  `tax` decimal(11,2) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `total_amount` decimal(11,2) NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` enum('New','Pending','Assigned','Accepted','Processing','Delivered','Cancelled','Rejected','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `is_owner` tinyint(1) NOT NULL DEFAULT '0',
  `order_date` date NOT NULL,
  `is_schedule_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_date` date NOT NULL,
  `delivery_time` time DEFAULT NULL,
  `payment_type` enum('None','Upfront','50 Advance','Generate Bill') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `time_left_to_accept` datetime NOT NULL,
  `otp_code` int(11) NOT NULL,
  `quality_of_product` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_qty` int(11) DEFAULT NULL,
  `receive_status` tinyint(1) DEFAULT '0',
  `receive_datetime` datetime DEFAULT NULL,
  `delivered_datetime` datetime DEFAULT NULL,
  `signature_file` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_order` tinyint(1) NOT NULL DEFAULT '0',
  `is_approve` tinyint(1) NOT NULL DEFAULT '0',
  `rating` int(1) NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `review_date` datetime DEFAULT NULL,
  `transporter_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_orders`
--

INSERT INTO `cart_orders` (`id`, `user_id`, `owner_id`, `order_id`, `station_id`, `shipping_charge`, `tax`, `amount`, `total_amount`, `currency`, `order_status`, `is_owner`, `order_date`, `is_schedule_delivery`, `delivery_date`, `delivery_time`, `payment_type`, `time_left_to_accept`, `otp_code`, `quality_of_product`, `receive_qty`, `receive_status`, `receive_datetime`, `delivered_datetime`, `signature_file`, `coupon_code`, `coupon_id`, `discount`, `status`, `is_order`, `is_approve`, `rating`, `review`, `review_date`, `transporter_id`, `created_date`, `updated_date`) VALUES
(1215, 68, 68, 'O01215', 150, '47.00', '1800.00', '10000.00', '11847.00', 'KES', 'Completed', 1, '2023-03-27', 0, '2023-03-27', '00:00:00', 'Upfront', '2023-03-27 18:08:00', 0, NULL, NULL, 0, NULL, '2023-03-27 17:55:52', 'sign_5711679919952.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-03-27 17:48:00', '2023-03-27 17:48:00'),
(1217, 107, 107, 'O01217', 88, '5534.00', '1742.00', '9680.00', '16956.00', 'KES', 'Completed', 1, '2023-03-28', 0, '2023-03-28', '00:00:00', 'Upfront', '2023-03-28 14:40:18', 0, 'Good', 121, 1, '2023-03-28 14:24:17', '2023-03-28 14:23:59', 'sign_7451679993639.png', '', 0, '0.00', 1, 1, 1, 0, NULL, NULL, 19, '2023-03-28 14:20:18', '2023-03-28 14:20:18'),
(1218, 205, 205, 'O01218', 156, '0.00', '0.00', '400000.00', '400000.00', 'KES', 'Pending', 1, '2023-03-31', 0, '2023-03-31', '00:00:00', 'Upfront', '2023-03-31 16:11:06', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-03-31 15:51:06', '2023-03-31 15:51:06'),
(1219, 205, 205, 'O01219', 156, '0.00', '0.00', '400000.00', '400000.00', 'KES', 'Pending', 1, '2023-03-31', 0, '2023-03-31', '00:00:00', 'Upfront', '2023-03-31 16:11:27', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-03-31 15:51:27', '2023-03-31 15:51:27'),
(1220, 205, 205, 'O01220', 156, '0.00', '0.00', '400000.00', '400000.00', 'KES', 'Pending', 1, '2023-03-31', 0, '2023-03-31', '00:00:00', 'Upfront', '2023-03-31 16:17:45', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-03-31 15:57:45', '2023-03-31 15:57:45'),
(1221, 208, 206, 'O01221', 157, '11.00', '41400.00', '230000.00', '271411.00', 'KES', 'Pending', 0, '2023-04-01', 0, '2023-04-01', '00:00:00', 'None', '2023-04-01 21:33:23', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 0, 0, NULL, NULL, 0, '2023-04-01 21:13:23', '2023-04-01 21:13:23'),
(1222, 208, 206, '', 157, '11.00', '41400.00', '230000.00', '271411.00', 'KES', 'New', 0, '2023-04-01', 0, '2023-04-01', '00:00:00', 'None', '2023-04-01 21:33:49', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 0, 0, NULL, NULL, 0, '2023-04-01 21:13:49', '2023-04-01 21:13:49'),
(1223, 208, 206, 'O01223', 157, '11.00', '14400.00', '80000.00', '94411.00', 'KES', 'New', 0, '2023-04-01', 0, '2023-04-01', '00:00:00', 'Upfront', '2023-04-02 12:12:26', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-01 21:18:34', '2023-04-02 11:52:26'),
(1224, 208, 206, '', 157, '11.00', '14400.00', '80000.00', '94411.00', 'KES', 'New', 0, '2023-04-01', 0, '2023-04-01', '00:00:00', 'None', '2023-04-01 21:38:51', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 0, 0, NULL, NULL, 0, '2023-04-01 21:18:51', '2023-04-01 21:18:51'),
(1225, 208, 206, '', 157, '11.00', '14400.00', '80000.00', '94411.00', 'KES', 'New', 0, '2023-04-01', 0, '2023-04-01', '00:00:00', 'None', '2023-04-01 21:39:00', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 0, 0, NULL, NULL, 0, '2023-04-01 21:19:00', '2023-04-01 21:19:00'),
(1226, 209, 209, 'O01226', 158, '5505.00', '1454.00', '8080.00', '15039.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 15:55:18', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 15:35:18', '2023-04-03 15:35:18'),
(1227, 209, 209, 'O01227', 158, '5505.00', '1454.00', '8080.00', '15039.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 15:55:50', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 15:35:50', '2023-04-03 15:35:50'),
(1228, 209, 209, 'O01228', 158, '5505.00', '1454.00', '8080.00', '15039.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 16:29:29', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 16:09:29', '2023-04-03 16:09:29'),
(1229, 209, 209, 'O01229', 158, '5505.00', '1454.00', '8080.00', '15039.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 16:29:55', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 16:09:55', '2023-04-03 16:09:55'),
(1230, 107, 107, 'O01230', 159, '5505.00', '13430.00', '74610.00', '93545.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 17:26:55', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 17:06:55', '2023-04-03 17:06:55'),
(1231, 107, 107, 'O01231', 159, '5505.00', '6086.00', '33810.00', '45401.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 17:28:08', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 17:08:08', '2023-04-03 17:08:08'),
(1232, 205, 205, 'O01232', 156, '32.00', '72000.00', '400000.00', '472032.00', 'KES', 'Pending', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 17:45:23', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-03 17:25:23', '2023-04-03 17:25:23'),
(1233, 205, 205, 'O01233', 156, '32.00', '72000.00', '400000.00', '472032.00', 'KES', 'Pending', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 17:46:38', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-03 17:26:38', '2023-04-03 17:26:38'),
(1234, 205, 205, 'O01234', 156, '32.00', '1440.00', '8000.00', '9472.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 17:47:57', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 17:27:57', '2023-04-03 17:27:57'),
(1235, 211, 211, 'O01235', 158, '5505.00', '122182330.00', '678790720.00', '800978555.00', 'KES', 'Pending', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 18:40:59', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-03 18:20:59', '2023-04-03 18:20:59'),
(1236, 202, 202, 'O01236', 162, '11.00', '2880.00', '16000.00', '18891.00', 'KES', 'New', 1, '2023-04-03', 0, '2023-04-03', '00:00:00', 'Upfront', '2023-04-03 23:38:09', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-03 23:18:09', '2023-04-03 23:18:09'),
(1237, 211, 211, 'O01237', 158, '5505.00', '122182330.00', '678790720.00', '800978555.00', 'KES', 'Pending', 1, '2023-04-05', 0, '2023-04-05', '00:00:00', 'Upfront', '2023-04-05 18:03:26', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-05 17:43:26', '2023-04-05 17:43:26'),
(1238, 211, 211, 'O01238', 161, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'New', 1, '2023-04-05', 0, '2023-04-05', '00:00:00', 'Upfront', '2023-04-05 18:04:58', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-05 17:44:58', '2023-04-05 17:44:58'),
(1239, 68, 68, 'O01239', 165, '5505.00', '1757.00', '9760.00', '17022.00', 'KES', 'New', 1, '2023-04-06', 0, '2023-04-06', '00:00:00', 'Upfront', '2023-04-06 17:42:25', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-06 17:22:25', '2023-04-06 17:22:25'),
(1240, 226, 226, 'O01240', 173, '5483.00', '45475.00', '252640.00', '303598.00', 'KES', 'Pending', 1, '2023-04-10', 0, '2023-04-10', '00:00:00', 'Upfront', '2023-04-10 21:54:58', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-10 21:34:58', '2023-04-10 21:34:58'),
(1241, 226, 226, 'O01241', 173, '5483.00', '45475.00', '252640.00', '303598.00', 'KES', 'Pending', 1, '2023-04-10', 0, '2023-04-10', '00:00:00', 'Upfront', '2023-04-10 21:55:53', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-10 21:35:53', '2023-04-10 21:35:53'),
(1242, 68, 68, 'O01242', 174, '5510.00', '30816.00', '171200.00', '207526.00', 'KES', 'Pending', 1, '2023-04-17', 0, '2023-04-17', '00:00:00', 'Upfront', '2023-04-17 18:26:01', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-17 18:06:01', '2023-04-17 18:06:01'),
(1243, 68, 68, 'O01243', 159, '5505.00', '1728.00', '9600.00', '16833.00', 'KES', 'Pending', 1, '2023-04-20', 0, '2023-04-20', '00:00:00', 'Upfront', '2023-04-20 14:55:10', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-20 14:35:10', '2023-04-20 14:35:10'),
(1244, 68, 68, 'O01244', 165, '5505.00', '108929.00', '605160.00', '719594.00', 'KES', 'Pending', 1, '2023-04-26', 0, '2023-04-26', '00:00:00', 'Generate Bill', '2023-04-26 18:00:37', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-26 17:40:37', '2023-04-27 12:40:56'),
(1245, 243, 243, 'O01245', 176, '5.00', '17280.00', '96000.00', '113285.00', 'KES', 'Pending', 1, '2023-04-27', 1, '2023-04-29', '16:00:00', 'Generate Bill', '2023-04-27 11:52:25', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 11:32:25', '2023-04-27 11:32:25'),
(1246, 243, 243, 'O01246', 176, '5.00', '21600.00', '120000.00', '141605.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Generate Bill', '2023-04-27 12:35:54', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 12:15:54', '2023-04-27 12:15:54'),
(1247, 68, 68, 'O01247', 165, '5505.00', '17961.00', '99784.00', '123250.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Generate Bill', '2023-04-27 12:40:35', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 12:20:35', '2023-04-27 12:20:35'),
(1248, 68, 68, 'O01248', 165, '5505.00', '3715.00', '20640.00', '29860.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 12:46:58', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 12:26:58', '2023-04-27 12:26:58'),
(1249, 243, 243, 'O01249', 176, '5.00', '1440.00', '8000.00', '9445.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 12:51:30', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 12:31:30', '2023-04-27 12:31:30'),
(1250, 68, 68, 'O01250', 165, '5505.00', '5314.00', '29520.00', '40339.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 14:13:30', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 13:53:30', '2023-04-27 13:53:30'),
(1251, 68, 68, 'O01251', 165, '5505.00', '5141.00', '28560.00', '39206.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 14:20:05', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 14:00:05', '2023-04-27 14:00:05'),
(1252, 68, 68, 'O01252', 165, '5505.00', '5141.00', '28560.00', '39206.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 14:20:54', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 14:00:54', '2023-04-27 14:00:54'),
(1253, 68, 68, 'O01253', 165, '5505.00', '10516.00', '58420.00', '74441.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 14:21:42', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 14:01:42', '2023-04-27 14:01:42'),
(1254, 68, 68, 'O01254', 165, '5505.00', '10516.00', '58420.00', '74441.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 14:22:04', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 14:02:04', '2023-04-27 14:02:04'),
(1255, 68, 68, 'O01255', 165, '5505.00', '6086.00', '33810.00', '45401.00', 'KES', 'New', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 15:24:38', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-04-27 15:04:38', '2023-04-27 15:04:38'),
(1256, 68, 68, 'O01256', 165, '5505.00', '6541.00', '36340.00', '48386.00', 'KES', 'Pending', 1, '2023-04-27', 0, '2023-04-27', '00:00:00', 'Upfront', '2023-04-27 15:31:53', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-27 15:11:53', '2023-04-27 15:11:53'),
(1257, 205, 205, 'O01257', 156, '32.00', '1440.00', '8000.00', '9472.00', 'KES', 'Pending', 1, '2023-04-28', 0, '2023-04-28', '00:00:00', 'Upfront', '2023-04-28 14:56:17', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-04-28 14:36:17', '2023-04-28 14:36:17'),
(1258, 205, 205, 'O01258', 156, '32.00', '288000.00', '1600000.00', '1888032.00', 'KES', 'Pending', 1, '2023-05-01', 0, '2023-05-01', '00:00:00', 'Generate Bill', '2023-05-01 14:13:43', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-01 13:53:43', '2023-05-01 13:53:43'),
(1259, 205, 205, 'O01259', 156, '32.00', '2880.00', '16000.00', '18912.00', 'KES', 'Pending', 1, '2023-05-03', 0, '2023-05-03', '00:00:00', 'Upfront', '2023-05-03 15:36:24', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-03 15:16:24', '2023-05-03 15:16:24'),
(1260, 205, 205, '', 156, '32.00', '2880.00', '16000.00', '18912.00', 'KES', 'New', 1, '2023-05-03', 0, '2023-05-03', '00:00:00', 'Upfront', '2023-05-03 15:43:18', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-03 15:23:18', '2023-05-03 15:23:18'),
(1261, 68, 68, 'O01261', 165, '5505.00', '5879.00', '32660.00', '44044.00', 'KES', 'New', 1, '2023-05-04', 0, '2023-05-04', '00:00:00', 'Upfront', '2023-05-04 15:16:34', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-04 14:56:34', '2023-05-04 14:56:34'),
(1262, 68, 68, 'O01262', 165, '5505.00', '5879.00', '32660.00', '44044.00', 'KES', 'Pending', 1, '2023-05-04', 0, '2023-05-04', '00:00:00', 'Upfront', '2023-05-04 15:19:37', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-04 14:59:37', '2023-05-04 14:59:37'),
(1263, 68, 68, 'O01263', 165, '5505.00', '1786.00', '9920.00', '17211.00', 'KES', 'Pending', 1, '2023-05-04', 0, '2023-05-04', '00:00:00', 'Upfront', '2023-05-04 15:21:25', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-04 15:01:25', '2023-05-04 15:01:25'),
(1264, 246, 246, 'O01264', 177, '5505.00', '3715.00', '20640.00', '29860.00', 'KES', 'Completed', 1, '2023-05-09', 0, '2023-05-09', '00:00:00', 'Upfront', '2023-05-09 17:39:49', 0, NULL, NULL, 0, NULL, '2023-05-09 17:25:01', 'sign_7221683633301.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 245, '2023-05-09 17:19:49', '2023-05-09 17:19:49'),
(1265, 246, 246, 'O01265', 177, '5505.00', '12590.00', '69944.00', '88039.00', 'KES', 'Completed', 1, '2023-05-09', 0, '2023-05-09', '00:00:00', 'Upfront', '2023-05-09 17:42:27', 0, 'Bad', 364, 1, '2023-05-09 17:26:28', '2023-05-09 17:25:39', 'sign_1611683633339.png', '', 0, '0.00', 1, 1, 1, 0, NULL, NULL, 245, '2023-05-09 17:22:27', '2023-05-09 17:22:27'),
(1266, 68, 68, 'O01266', 165, '5505.00', '1786.00', '9920.00', '17211.00', 'KES', 'Accepted', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:21:18', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-10 11:01:18', '2023-05-10 11:01:18'),
(1267, 107, 107, 'O01267', 159, '5505.00', '7857.00', '43650.00', '57012.00', 'KES', 'Processing', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:24:11', 3049, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-10 11:04:11', '2023-05-10 11:04:11'),
(1268, 107, 107, 'O01268', 159, '5505.00', '3082.00', '17120.00', '25707.00', 'KES', 'Completed', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:31:44', 0, NULL, NULL, 0, NULL, '2023-05-10 11:14:12', 'sign_7701683697452.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 6, '2023-05-10 11:11:44', '2023-05-10 11:11:44'),
(1269, 107, 107, 'O01269', 159, '5505.00', '9977.00', '55430.00', '70912.00', 'KES', 'Pending', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:48:19', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-10 11:28:19', '2023-05-10 11:28:19'),
(1270, 107, 107, 'O01270', 159, '5505.00', '6003.00', '33350.00', '44858.00', 'KES', 'New', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:52:23', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-10 11:32:23', '2023-05-10 11:32:23'),
(1271, 107, 107, 'O01271', 159, '5505.00', '6003.00', '33350.00', '44858.00', 'KES', 'Pending', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:52:54', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-10 11:32:54', '2023-05-10 11:32:54'),
(1272, 107, 107, 'O01272', 159, '5505.00', '6003.00', '33350.00', '44858.00', 'KES', 'Pending', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:54:14', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-10 11:34:14', '2023-05-10 11:34:14'),
(1273, 68, 68, 'O01273', 165, '5505.00', '6583.00', '36570.00', '48658.00', 'KES', 'Processing', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:57:15', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 245, '2023-05-10 11:37:15', '2023-05-10 11:37:15'),
(1274, 68, 68, 'O01274', 165, '5505.00', '5175.00', '28750.00', '39430.00', 'KES', 'Accepted', 1, '2023-05-10', 0, '2023-05-10', '00:00:00', 'Upfront', '2023-05-10 11:59:54', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-10 11:39:54', '2023-05-10 11:39:54'),
(1275, 68, 68, 'O01275', 165, '5505.00', '2275.00', '12640.00', '20420.00', 'KES', 'Processing', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 10:29:01', 9421, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-11 10:09:01', '2023-05-11 10:09:01'),
(1276, 68, 68, 'O01276', 165, '5505.00', '10516.00', '58420.00', '74441.00', 'KES', 'New', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', '50 Advance', '2023-05-11 10:31:15', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-11 10:11:15', '2023-05-11 10:11:15'),
(1277, 68, 68, 'O01277', 165, '5505.00', '10516.00', '58420.00', '74441.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', '50 Advance', '2023-05-11 10:32:22', 0, NULL, NULL, 0, NULL, '2023-05-11 10:15:23', 'sign_5071683780323.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-11 10:12:22', '2023-05-11 10:12:22'),
(1278, 209, 209, 'O01278', 158, '5505.00', '1958728.00', '10881824.00', '12846057.00', 'KES', 'Cancelled', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Generate Bill', '2023-05-11 10:35:20', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:15:20', '2023-05-11 10:20:44'),
(1279, 68, 68, 'O01279', 165, '5505.00', '10516.00', '58420.00', '74441.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', '50 Advance', '2023-05-11 10:38:00', 0, NULL, NULL, 0, NULL, '2023-05-11 10:21:25', 'sign_5161683780685.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-11 10:18:00', '2023-05-11 10:18:00'),
(1280, 68, 68, 'O01280', 165, '5505.00', '6086.00', '33810.00', '45401.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 10:41:57', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:21:57', '2023-05-11 10:21:57'),
(1281, 68, 68, 'O01281', 165, '5505.00', '6086.00', '33810.00', '45401.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 10:42:55', 0, NULL, NULL, 0, NULL, '2023-05-11 10:24:30', 'sign_1721683780870.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-11 10:22:55', '2023-05-11 10:22:55'),
(1282, 68, 68, 'O01282', 165, '5505.00', '36677.00', '203760.00', '245942.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Generate Bill', '2023-05-11 10:44:57', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:24:57', '2023-05-11 10:24:57'),
(1283, 68, 68, 'O01283', 165, '5505.00', '1786.00', '9920.00', '17211.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:01:25', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:41:25', '2023-05-11 10:41:25'),
(1284, 68, 68, 'O01284', 165, '5505.00', '8860.00', '49220.00', '63585.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:03:00', 0, NULL, NULL, 0, NULL, '2023-05-11 11:19:41', 'sign_2281683784181.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-11 10:43:00', '2023-05-11 10:43:00'),
(1285, 209, 209, 'O01285', 158, '5505.00', '14399986.00', '79999920.00', '94405411.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Generate Bill', '2023-05-11 11:04:06', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:44:06', '2023-05-11 10:44:06'),
(1286, 68, 68, 'O01286', 165, '5505.00', '1742.00', '9680.00', '16927.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:08:04', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:48:04', '2023-05-11 10:48:04'),
(1287, 68, 68, 'O01287', 165, '5505.00', '5092.00', '28290.00', '38887.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:17:34', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 10:57:34', '2023-05-11 10:57:34'),
(1288, 68, 68, 'O01288', 165, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'New', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:21:33', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-11 11:01:33', '2023-05-11 11:01:33'),
(1289, 68, 68, 'O01289', 165, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'New', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:21:35', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-11 11:01:35', '2023-05-11 11:01:35'),
(1290, 68, 68, 'O01290', 165, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'New', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:21:37', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-11 11:01:37', '2023-05-11 11:01:37'),
(1291, 68, 68, 'O01291', 165, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:22:23', 0, 'Good', 100, 1, '2023-05-11 11:08:59', '2023-05-11 11:06:18', 'sign_4301683783378.png', '', 0, '0.00', 1, 1, 1, 0, NULL, NULL, 19, '2023-05-11 11:02:23', '2023-05-11 11:02:23'),
(1292, 68, 68, 'O01292', 165, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'New', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:22:24', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 0, 1, 0, NULL, NULL, 0, '2023-05-11 11:02:24', '2023-05-11 11:02:24'),
(1293, 209, 209, 'O01293', 158, '5505.00', '1440.00', '8000.00', '14945.00', 'KES', 'Pending', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:23:04', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-11 11:03:04', '2023-05-11 11:03:04'),
(1294, 68, 68, 'O01294', 165, '5505.00', '8955.00', '49760.00', '64210.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 11:32:40', 0, 'Bad', 340, 1, '2023-05-11 11:14:44', '2023-05-11 11:14:31', 'sign_1771683783871.png', 'C39626', 6, '10.00', 1, 1, 1, 0, NULL, NULL, 19, '2023-05-11 11:12:40', '2023-05-11 11:12:40'),
(1295, 68, 68, 'O01295', 165, '5505.00', '11939.00', '66340.00', '83774.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 12:18:33', 0, 'Good', 428, 1, '2023-05-11 12:07:15', '2023-05-11 12:05:16', 'sign_8871683786916.png', 'C39626', 6, '10.00', 1, 1, 1, 5, 'good', '2023-05-11 12:07:37', 19, '2023-05-11 11:58:33', '2023-05-11 11:58:33'),
(1296, 68, 68, 'O01296', 165, '5505.00', '12190.00', '67730.00', '85415.00', 'KES', 'Completed', 1, '2023-05-11', 0, '2023-05-11', '00:00:00', 'Upfront', '2023-05-11 12:59:43', 0, 'Good', 376, 1, '2023-05-11 12:43:44', '2023-05-11 12:43:23', 'sign_2821683789203.png', 'C39626', 6, '10.00', 1, 1, 1, 5, 'good', '2023-05-11 12:43:59', 19, '2023-05-11 12:39:43', '2023-05-11 12:39:43'),
(1297, 68, 68, 'O01297', 165, '5505.00', '3658.00', '20320.00', '29483.00', 'KES', 'Accepted', 1, '2023-05-15', 0, '2023-05-15', '00:00:00', 'Upfront', '2023-05-15 10:46:52', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 248, '2023-05-15 10:26:52', '2023-05-15 10:26:52'),
(1298, 68, 68, 'O01298', 165, '5505.00', '11515.00', '63970.00', '80990.00', 'KES', 'Processing', 1, '2023-05-15', 0, '2023-05-15', '00:00:00', 'Upfront', '2023-05-15 10:47:19', 9874, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 248, '2023-05-15 10:27:19', '2023-05-15 10:27:19'),
(1299, 68, 68, 'O01299', 165, '5505.00', '13745.00', '76362.00', '95612.00', 'KES', 'Completed', 1, '2023-05-15', 0, '2023-05-15', '00:00:00', 'Upfront', '2023-05-15 10:47:53', 0, NULL, NULL, 0, NULL, '2023-05-19 16:19:57', 'sign_3621684493397.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 248, '2023-05-15 10:27:53', '2023-05-15 10:27:53'),
(1300, 68, 68, 'O01300', 165, '5505.00', '1786.00', '9920.00', '17211.00', 'KES', 'Completed', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 15:40:57', 0, NULL, NULL, 0, NULL, '2023-05-19 16:24:21', 'sign_8741684493661.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-19 15:20:57', '2023-05-19 15:20:57'),
(1301, 68, 68, 'O01301', 165, '5505.00', '11876.00', '65976.00', '83357.00', 'KES', 'Pending', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 15:41:33', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-19 15:21:33', '2023-05-19 15:21:33'),
(1302, 68, 68, 'O01302', 165, '5505.00', '6295.00', '34974.00', '46774.00', 'KES', 'Completed', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 15:42:55', 0, NULL, NULL, 0, NULL, '2023-05-19 16:21:56', 'sign_6271684493516.png', '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-19 15:22:55', '2023-05-19 15:22:55'),
(1303, 68, 68, 'O01303', 165, '5505.00', '6820.00', '37890.00', '50215.00', 'KES', 'Accepted', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 16:44:50', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 19, '2023-05-19 16:24:50', '2023-05-19 16:24:50'),
(1304, 68, 68, 'O01304', 165, '5505.00', '7137.00', '39650.00', '52292.00', 'KES', 'Pending', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 17:14:25', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-19 16:54:25', '2023-05-19 16:54:25'),
(1305, 68, 68, 'O01305', 165, '5505.00', '8860.00', '49220.00', '63585.00', 'KES', 'Pending', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 17:14:48', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-19 16:54:48', '2023-05-19 16:54:48'),
(1306, 205, 205, 'O01306', 156, '32.00', '1440.00', '8000.00', '9472.00', 'KES', 'Pending', 1, '2023-05-19', 0, '2023-05-19', '00:00:00', 'Upfront', '2023-05-19 19:47:15', 0, NULL, NULL, 0, NULL, NULL, NULL, '', 0, '0.00', 0, 1, 1, 0, NULL, NULL, 0, '2023-05-19 19:27:15', '2023-05-19 19:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `cart_order_details`
--

CREATE TABLE `cart_order_details` (
  `id` bigint(20) NOT NULL,
  `cart_order_id` bigint(20) NOT NULL,
  `cart_user_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measurement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(11,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cart_created` datetime NOT NULL,
  `cart_updated` datetime DEFAULT NULL,
  `assign_order_id` bigint(20) DEFAULT NULL,
  `assign_order_detail_id` bigint(20) DEFAULT NULL,
  `transporter_id` bigint(20) DEFAULT NULL,
  `otp_code` int(11) DEFAULT NULL,
  `receive_qty` int(11) DEFAULT NULL,
  `quality_of_product` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_status` tinyint(1) DEFAULT '0',
  `receive_datetime` datetime DEFAULT NULL,
  `delivered_datetime` datetime DEFAULT NULL,
  `compartment_data` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_order_details`
--

INSERT INTO `cart_order_details` (`id`, `cart_order_id`, `cart_user_id`, `category_id`, `name`, `type`, `image`, `measurement`, `qty`, `price`, `currency`, `total_price`, `status`, `cart_created`, `cart_updated`, `assign_order_id`, `assign_order_detail_id`, `transporter_id`, `otp_code`, `receive_qty`, `quality_of_product`, `receive_status`, `receive_datetime`, `delivered_datetime`, `compartment_data`) VALUES
(1279, 1215, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 125, '80.00', 'KES', '10000.00', 0, '2023-03-27 17:47:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1281, 1217, 107, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 121, '80.00', 'KES', '9680.00', 0, '2023-03-28 14:20:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1282, 1218, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '80.00', 'KES', '400000.00', 0, '2023-03-31 15:50:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1283, 1219, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '80.00', 'KES', '400000.00', 0, '2023-03-31 15:50:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1284, 1220, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '80.00', 'KES', '400000.00', 0, '2023-03-31 15:50:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1285, 1221, 208, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 1000, '230.00', 'KES', '230000.00', 0, '2023-04-01 21:12:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1286, 1223, 208, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 1000, '80.00', 'KES', '80000.00', 0, '2023-04-01 21:18:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1287, 1226, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 101, '80.00', 'KES', '8080.00', 0, '2023-04-03 15:32:41', '2023-04-03 15:33:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1288, 1227, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 101, '80.00', 'KES', '8080.00', 0, '2023-04-03 15:32:41', '2023-04-03 15:33:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1289, 1228, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 101, '80.00', 'KES', '8080.00', 0, '2023-04-03 15:32:41', '2023-04-03 16:09:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1290, 1229, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 101, '80.00', 'KES', '8080.00', 0, '2023-04-03 15:32:41', '2023-04-03 16:09:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1291, 1230, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 251, '230.00', 'KES', '57730.00', 0, '2023-04-03 17:04:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1292, 1230, 107, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 211, '80.00', 'KES', '16880.00', 0, '2023-04-03 17:05:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1293, 1231, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 147, '230.00', 'KES', '33810.00', 0, '2023-04-03 17:08:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1294, 1232, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '80.00', 'KES', '400000.00', 0, '2023-03-31 15:50:19', '2023-04-03 17:24:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1295, 1233, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 5000, '80.00', 'KES', '400000.00', 0, '2023-03-31 15:50:19', '2023-04-03 17:24:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1296, 1234, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-03-31 15:50:19', '2023-04-03 17:27:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1297, 1235, 211, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 8484884, '80.00', 'KES', '678790720.00', 0, '2023-04-03 18:20:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1298, 1236, 202, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 200, '80.00', 'KES', '16000.00', 0, '2023-04-03 23:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1299, 1237, 211, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 8484884, '80.00', 'KES', '678790720.00', 0, '2023-04-03 18:20:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1300, 1238, 211, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-04-05 17:44:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1301, 1239, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 122, '80.00', 'KES', '9760.00', 0, '2023-04-06 17:22:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1302, 1240, 226, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 605, '80.00', 'KES', '48400.00', 0, '2023-04-10 17:47:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1303, 1240, 226, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 888, '230.00', 'KES', '204240.00', 0, '2023-04-10 17:47:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1304, 1241, 226, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 605, '80.00', 'KES', '48400.00', 0, '2023-04-10 17:47:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1305, 1241, 226, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 888, '230.00', 'KES', '204240.00', 0, '2023-04-10 17:47:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1306, 1242, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 2140, '80.00', 'KES', '171200.00', 0, '2023-04-17 18:04:53', '2023-04-17 18:05:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1307, 1243, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 120, '80.00', 'KES', '9600.00', 0, '2023-04-19 11:52:08', '2023-04-20 14:35:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1308, 1244, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 147, '80.00', 'KES', '11760.00', 0, '2023-04-20 14:35:31', '2023-04-26 17:40:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1309, 1244, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 2580, '230.00', 'KES', '593400.00', 0, '2023-04-26 17:40:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1310, 1245, 243, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 1200, '80.00', 'KES', '96000.00', 0, '2023-04-27 11:28:16', '2023-04-27 11:28:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1311, 1246, 243, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 1500, '80.00', 'KES', '120000.00', 0, '2023-04-27 12:15:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1312, 1247, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 258, '230.00', 'KES', '59340.00', 0, '2023-04-27 12:20:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1313, 1247, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 125, '80.00', 'KES', '10000.00', 0, '2023-04-27 12:20:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1314, 1247, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 258, '118.00', 'KES', '30444.00', 0, '2023-04-27 12:20:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1315, 1248, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 258, '80.00', 'KES', '20640.00', 0, '2023-04-27 12:26:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1316, 1249, 243, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-04-27 12:31:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1317, 1250, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 369, '80.00', 'KES', '29520.00', 0, '2023-04-27 13:53:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1318, 1251, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 357, '80.00', 'KES', '28560.00', 0, '2023-04-27 13:59:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1319, 1252, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 357, '80.00', 'KES', '28560.00', 0, '2023-04-27 13:59:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1320, 1253, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 254, '230.00', 'KES', '58420.00', 0, '2023-04-27 14:01:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1321, 1254, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 254, '230.00', 'KES', '58420.00', 0, '2023-04-27 14:01:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1322, 1255, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 147, '230.00', 'KES', '33810.00', 0, '2023-04-27 15:04:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1323, 1256, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 158, '230.00', 'KES', '36340.00', 0, '2023-04-27 15:11:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1324, 1257, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-03-31 15:50:19', '2023-04-28 14:35:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1325, 1258, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 20000, '80.00', 'KES', '1600000.00', 0, '2023-05-01 13:53:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1326, 1259, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 200, '80.00', 'KES', '16000.00', 0, '2023-05-03 15:15:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1327, 1261, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 142, '230.00', 'KES', '32660.00', 0, '2023-05-04 14:56:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1328, 1262, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 142, '230.00', 'KES', '32660.00', 0, '2023-05-04 14:56:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1329, 1263, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 124, '80.00', 'KES', '9920.00', 0, '2023-05-04 15:01:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1330, 1264, 246, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 258, '80.00', 'KES', '20640.00', 0, '2023-05-09 17:19:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1331, 1265, 246, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 241, '230.00', 'KES', '55430.00', 0, '2023-05-09 17:22:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"3000\"}]'),
(1332, 1265, 246, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 123, '118.00', 'KES', '14514.00', 0, '2023-05-09 17:22:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1333, 1266, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 124, '80.00', 'KES', '9920.00', 0, '2023-05-10 11:01:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1334, 1267, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 147, '230.00', 'KES', '33810.00', 0, '2023-04-03 17:08:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1335, 1267, 107, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 123, '80.00', 'KES', '9840.00', 0, '2023-05-10 11:03:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"4000\"}]'),
(1336, 1268, 107, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 214, '80.00', 'KES', '17120.00', 0, '2023-05-10 11:11:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"2000\"},{\"compartment_no\":\"2\",\"compartment_capacity\":\"4000\"}]'),
(1337, 1269, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 241, '230.00', 'KES', '55430.00', 0, '2023-05-10 11:28:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1338, 1270, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 145, '230.00', 'KES', '33350.00', 0, '2023-05-10 11:32:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1339, 1271, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 145, '230.00', 'KES', '33350.00', 0, '2023-05-10 11:32:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1340, 1272, 107, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 145, '230.00', 'KES', '33350.00', 0, '2023-05-10 11:34:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1341, 1273, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 159, '230.00', 'KES', '36570.00', 0, '2023-05-10 11:37:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1342, 1274, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 125, '230.00', 'KES', '28750.00', 0, '2023-05-10 11:39:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1343, 1275, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 158, '80.00', 'KES', '12640.00', 0, '2023-05-11 10:08:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"3000\"}]'),
(1344, 1276, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 254, '230.00', 'KES', '58420.00', 0, '2023-05-11 10:11:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1345, 1277, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 254, '230.00', 'KES', '58420.00', 0, '2023-05-11 10:11:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1346, 1278, 209, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 888, '230.00', 'KES', '204240.00', 0, '2023-04-03 16:38:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1347, 1278, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 885, '80.00', 'KES', '70800.00', 0, '2023-04-03 16:38:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1348, 1278, 209, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 89888, '118.00', 'KES', '10606784.00', 0, '2023-04-03 16:38:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1349, 1279, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 254, '230.00', 'KES', '58420.00', 0, '2023-05-11 10:17:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1350, 1280, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 147, '230.00', 'KES', '33810.00', 0, '2023-05-11 10:21:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1351, 1281, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 147, '230.00', 'KES', '33810.00', 0, '2023-05-11 10:22:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1352, 1282, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 2547, '80.00', 'KES', '203760.00', 0, '2023-05-11 10:24:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1353, 1283, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 124, '80.00', 'KES', '9920.00', 0, '2023-05-11 10:41:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1354, 1284, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 214, '230.00', 'KES', '49220.00', 0, '2023-05-11 10:42:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1355, 1285, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 999999, '80.00', 'KES', '79999920.00', 0, '2023-05-11 10:24:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1356, 1286, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 121, '80.00', 'KES', '9680.00', 0, '2023-05-11 10:47:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1357, 1287, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 123, '230.00', 'KES', '28290.00', 0, '2023-05-11 10:57:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1358, 1288, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:00:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1359, 1289, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:00:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1360, 1290, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:00:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1361, 1291, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:00:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1362, 1292, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:00:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1363, 1293, 209, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:01:31', '2023-05-11 11:02:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1364, 1294, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-11 11:09:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1365, 1294, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 120, '230.00', 'KES', '27600.00', 0, '2023-05-11 11:09:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"4000\"}]'),
(1366, 1294, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 120, '118.00', 'KES', '14160.00', 0, '2023-05-11 11:09:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"3\",\"compartment_capacity\":\"4000\"}]'),
(1367, 1295, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 214, '80.00', 'KES', '17120.00', 0, '2023-05-11 11:24:13', '2023-05-11 11:47:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1368, 1295, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 214, '230.00', 'KES', '49220.00', 0, '2023-05-11 11:46:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"4000\"}]'),
(1369, 1296, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 125, '80.00', 'KES', '10000.00', 0, '2023-05-11 12:37:17', '2023-05-11 12:37:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"4000\"}]'),
(1370, 1296, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 251, '230.00', 'KES', '57730.00', 0, '2023-05-11 12:37:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"4000\"}]'),
(1371, 1297, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 254, '80.00', 'KES', '20320.00', 0, '2023-05-11 12:53:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1372, 1298, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 214, '230.00', 'KES', '49220.00', 0, '2023-05-15 10:27:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"3000\"}]'),
(1373, 1298, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 125, '118.00', 'KES', '14750.00', 0, '2023-05-15 10:27:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"2\",\"compartment_capacity\":\"3000\"}]'),
(1374, 1299, 68, 5, 'Kerosene', 'JET', 'product_4351669204816.jfif', 'Litr', 123, '150.00', 'KES', '18450.00', 0, '2023-05-15 10:27:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"3000\"},{\"compartment_no\":\"2\",\"compartment_capacity\":\"3000\"}]'),
(1375, 1299, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 214, '118.00', 'KES', '25252.00', 0, '2023-05-15 10:27:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"3\",\"compartment_capacity\":\"3000\"}]'),
(1376, 1299, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 142, '230.00', 'KES', '32660.00', 0, '2023-05-15 10:27:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"4\",\"compartment_capacity\":\"3000\"}]'),
(1377, 1300, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 124, '80.00', 'KES', '9920.00', 0, '2023-05-19 15:20:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"3\",\"compartment_capacity\":\"3000\"}]'),
(1378, 1301, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 214, '230.00', 'KES', '49220.00', 0, '2023-05-19 15:21:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1379, 1301, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 142, '118.00', 'KES', '16756.00', 0, '2023-05-19 15:21:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1380, 1302, 68, 4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 213, '118.00', 'KES', '25134.00', 0, '2023-05-19 15:21:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"1\",\"compartment_capacity\":\"3000\"},{\"compartment_no\":\"2\",\"compartment_capacity\":\"3000\"}]'),
(1381, 1302, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 123, '80.00', 'KES', '9840.00', 0, '2023-05-19 15:21:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '[{\"compartment_no\":\"4\",\"compartment_capacity\":\"3000\"}]'),
(1382, 1303, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 120, '80.00', 'KES', '9600.00', 0, '2023-05-19 16:24:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1383, 1303, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 123, '230.00', 'KES', '28290.00', 0, '2023-05-19 16:24:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1384, 1304, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 123, '230.00', 'KES', '28290.00', 0, '2023-05-19 16:54:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1385, 1304, 68, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 142, '80.00', 'KES', '11360.00', 0, '2023-05-19 16:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1386, 1305, 68, 3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 214, '230.00', 'KES', '49220.00', 0, '2023-05-19 16:54:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(1387, 1306, 205, 2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, '80.00', 'KES', '8000.00', 0, '2023-05-19 19:25:10', '2023-05-19 19:26:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measurement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_order_qty` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `type`, `image`, `measurement`, `minimum_order_qty`, `status`, `display_order`, `created_date`, `updated_date`) VALUES
(2, 'Petrol', 'Pms', 'product_5051666941331.png', 'Litr', 100, 1, 1, '2022-10-17 19:25:50', '2023-02-02 14:40:50'),
(3, 'Diesel', 'Ago', 'product_6011666941346.png', 'Litr', 120, 1, 2, '2022-10-17 19:26:28', '2023-01-30 12:58:42'),
(4, 'Gas', 'Lpg Eqwipetrol', 'product_3491666941361.png', 'Litr', 120, 1, 3, '2022-10-20 11:24:04', '2023-01-30 12:59:00'),
(5, 'Kerosene', 'JET', 'product_4351669204816.jfif', 'Litr', 100, 1, 4, '2022-11-23 17:30:16', '2023-01-30 12:59:06'),
(6, 'Auto Spares', 'Spare Parts', '', 'Size', 0, 1, 5, '2023-05-19 19:51:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_price`
--

CREATE TABLE `category_price` (
  `id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `price_date` date NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_price`
--

INSERT INTO `category_price` (`id`, `category_id`, `currency`, `price`, `status`, `price_date`, `date_time`) VALUES
(1, 2, 'K', '110.00', 1, '2022-10-20', '2022-10-20 12:06:38'),
(2, 3, 'K', '100.00', 1, '2022-10-20', '2022-10-20 12:07:16'),
(3, 4, 'K', '90.00', 1, '2022-10-20', '2022-10-20 12:07:34'),
(10, 2, 'K', '100.00', 1, '2022-11-04', '2022-11-04 15:59:53'),
(11, 3, 'K', '20.00', 1, '2022-11-04', '2022-11-04 15:59:53'),
(12, 4, 'K', '200.00', 1, '2022-11-04', '2022-11-04 15:59:53'),
(13, 2, 'K', '99.00', 1, '2022-11-04', '2022-11-04 17:12:10'),
(14, 3, 'K', '92.00', 1, '2022-11-04', '2022-11-04 17:12:10'),
(15, 5, 'K', '140.00', 1, '2022-11-23', '2022-11-23 17:31:17'),
(16, 2, 'K', '111.00', 1, '2022-11-28', '2022-11-28 16:16:46'),
(17, 3, 'K', '100.00', 1, '2022-11-28', '2022-11-28 16:16:46'),
(18, 4, 'K', '150.00', 1, '2022-11-28', '2022-11-28 16:16:46'),
(19, 5, 'K', '410.00', 1, '2022-11-28', '2022-11-28 16:16:46'),
(20, 2, 'K', '145.00', 1, '2023-01-06', '2023-01-06 19:53:39'),
(21, 3, 'K', '137.00', 1, '2023-01-06', '2023-01-06 19:53:39'),
(22, 4, 'K', '3500.00', 1, '2023-01-06', '2023-01-06 19:53:39'),
(23, 5, 'K', '136.00', 1, '2023-01-06', '2023-01-06 19:53:39'),
(24, 2, 'KES', '145.00', 1, '2023-01-11', '2023-01-11 16:29:01'),
(25, 3, 'KES', '137.00', 1, '2023-01-11', '2023-01-11 16:29:01'),
(26, 4, 'KES', '3500.00', 1, '2023-01-11', '2023-01-11 16:29:01'),
(27, 5, 'KES', '136.00', 1, '2023-01-11', '2023-01-11 16:29:01'),
(28, 2, 'KES', '150.00', 1, '2023-01-12', '2023-01-12 17:00:50'),
(29, 3, 'KES', '150.00', 1, '2023-01-12', '2023-01-12 17:00:50'),
(30, 4, 'KES', '150.00', 1, '2023-01-12', '2023-01-12 17:00:50'),
(31, 5, 'KES', '150.00', 1, '2023-01-12', '2023-01-12 17:00:50'),
(32, 2, 'KES', '100.00', 1, '2023-01-12', '2023-01-12 17:01:32'),
(33, 2, 'KES', '120.00', 1, '2023-01-12', '2023-01-12 18:16:29'),
(34, 2, 'KES', '100.00', 1, '2023-01-19', '2023-01-19 18:09:08'),
(35, 2, 'KES', '150.00', 1, '2023-01-19', '2023-01-19 18:09:52'),
(36, 2, 'KES', '100.00', 1, '2023-01-19', '2023-01-19 18:11:25'),
(37, 2, 'KES', '70.00', 1, '2023-01-23', '2023-01-23 18:08:23'),
(38, 2, 'KES', '100.00', 1, '2023-01-23', '2023-01-23 18:21:44'),
(39, 2, 'KES', '80.00', 1, '2023-01-23', '2023-01-23 18:22:11'),
(40, 4, 'KES', '110.00', 1, '2023-01-31', '2023-01-31 10:54:04'),
(41, 4, 'KES', '115.00', 1, '2023-01-31', '2023-01-31 11:07:46'),
(42, 4, 'KES', '115.00', 1, '2023-01-31', '2023-01-31 11:07:57'),
(43, 4, 'KES', '118.00', 1, '2023-01-31', '2023-01-31 11:18:14'),
(44, 3, 'KES', '230.00', 1, '2023-02-02', '2023-02-02 12:05:48'),
(45, 2, 'KES', '180.00', 1, '2023-05-19', '2023-05-19 19:49:29'),
(46, 3, 'KES', '167.00', 1, '2023-05-19', '2023-05-19 19:49:29'),
(47, 4, 'KES', '2000.00', 1, '2023-05-19', '2023-05-19 19:49:29'),
(48, 5, 'KES', '150.00', 1, '2023-05-19', '2023-05-19 19:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `coupon_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `on_amount` decimal(11,2) NOT NULL,
  `discount` decimal(11,2) NOT NULL,
  `is_discount` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `product_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `product_id`, `coupon_title`, `coupon_code`, `description`, `start_date`, `end_date`, `on_amount`, `discount`, `is_discount`, `status`, `product_data`, `created_date`, `updated_date`) VALUES
(3, 3, 'Coupon 2', 'C96893', 'test description', '2023-01-12', '2023-01-31', '1200.00', '500.00', 1, 1, '{\"category_id\":\"3\",\"name\":\"Diesel\",\"type\":\"Ago\",\"image\":\"product_6011666941346.png\",\"measurement\":\"Litr\",\"status\":\"1\",\"display_order\":\"2\",\"created_date\":\"2022-10-17 19:26:28\",\"updated_date\":\"2022-10-28 12:45:45\"}', '2022-11-30 17:53:42', '2023-01-12 18:56:59'),
(4, 0, 'TESTEQWI', 'C59344', 'Eqwi petrol test coupon', '2023-01-12', '2023-01-31', '5000.00', '750.00', 1, 1, '', '2022-12-01 13:50:41', '2023-01-12 18:55:12'),
(5, 0, 'JPMS', 'C47595', 'PLEASE GET 10,000 LTS at a discounted price of KES 123 per Litre.', '2023-04-03', '2023-04-05', '230.00', '40.00', 1, 1, '', '2023-01-06 19:59:58', '2023-04-03 16:53:28'),
(6, 0, 'eqwi', 'C39626', 'eqwipetrol test coupon', '2023-05-11', '2023-05-25', '2500.00', '10.00', 1, 1, '', '2023-05-11 11:04:18', '2023-05-11 11:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `rating` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quick_feedback` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `rating`, `description`, `quick_feedback`, `status`, `created_date`, `updated_date`) VALUES
(1, 57, '5', 'test rating review', 'Awsome', 1, '2022-11-18 17:45:34', '2022-11-21 11:37:41'),
(2, 81, '3', 'ddff', 'Wow', 1, '2022-11-30 17:44:08', NULL),
(3, 19, '3', 'drink ccfbb ccfbb', 'Nice', 1, '2022-12-01 12:03:06', NULL),
(4, 19, '5', 'sfshvxdcc', 'null', 1, '2022-12-01 12:46:06', NULL),
(5, 19, '3', 'ehdggfg', 'Awsome', 1, '2022-12-01 12:46:56', NULL),
(6, 19, '5', 'hi', 'Nice', 1, '2022-12-02 15:50:25', NULL),
(7, 133, '5', 'hi', 'Awsome', 1, '2023-01-06 10:13:30', NULL),
(8, 133, '3', 'hi', 'Awsome', 1, '2023-01-06 10:13:58', NULL),
(9, 133, '5', 'hi', 'Awsome', 1, '2023-01-06 10:14:40', NULL),
(10, 133, '3', 'hi', 'Awsome', 1, '2023-01-06 10:37:52', NULL),
(11, 72, '5', 'Amazing', 'Wow', 1, '2023-01-06 17:50:25', NULL),
(12, 136, '3', 'awesome', 'Awsome', 1, '2023-01-06 18:27:54', NULL),
(13, 136, '4', 'hggvj', 'Awsome', 1, '2023-01-06 18:30:49', NULL),
(14, 135, '5', 'hi', 'Awsome', 1, '2023-01-07 12:30:16', NULL),
(15, 121, '5', 'hi', 'Wow', 1, '2023-01-08 11:52:17', NULL),
(16, 121, '5', 'hi', 'null', 1, '2023-01-08 18:17:10', NULL),
(17, 19, '5', 'very nice', 'Nice', 1, '2023-01-09 11:48:18', NULL),
(18, 19, '5', 'very good', 'Wow', 1, '2023-01-09 11:48:38', NULL),
(19, 19, '5', 'good', 'Wow', 1, '2023-01-09 12:52:48', NULL),
(20, 152, '3', 'hi', 'Awsome', 1, '2023-01-19 18:17:05', NULL),
(21, 152, '3', 'hi', 'Awsome', 1, '2023-01-19 18:17:21', NULL),
(22, 19, '4', 'hello alla', 'Awsome', 1, '2023-01-21 11:39:48', NULL),
(23, 19, '3', 'hello', 'Nice', 1, '2023-02-01 15:18:20', NULL),
(24, 209, '1', 'fccggvvgv', 'Nice', 1, '2023-04-03 16:43:26', NULL),
(25, 209, '5', 'vvvvhj', 'Nice', 1, '2023-04-03 16:43:42', NULL),
(26, 202, '4', 'Hello', 'Nice', 1, '2023-04-03 23:05:00', NULL),
(27, 68, '1', 'good', 'null', 1, '2023-04-10 16:44:10', NULL),
(28, 68, '2', 'good', 'Awesome', 1, '2023-04-10 16:44:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `help_support`
--

CREATE TABLE `help_support` (
  `id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_support`
--

INSERT INTO `help_support` (`id`, `question`, `answer`, `display_order`, `status`, `created_date`, `updated_date`) VALUES
(1, 'test', 'test answer', 1, 1, '2022-11-26 14:01:55', '2022-11-26 14:02:50'),
(3, 'i need support', 'hello i need suooprt', 2, 1, '2022-12-01 18:09:09', NULL),
(4, 'test q', 'heloooooooooooooooooooooooooooooooo helloooooooooooooooooooooo', 3, 1, '2022-12-01 18:09:31', NULL),
(5, 'testtttttttttttttttttttttttttttttttttt questionssssssssssssssssssssssssssssssssssss', 'helloooooooooooooooooo ooooooooooooooooooooooo ooooooooooooooooooooooooo ooooooooooooooooooo dhbhsdvcbsdc shavcdsbvcsabc cdvscbskc chsbvcbdscb cahc', 4, 1, '2022-12-01 18:10:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `help_ticket`
--

CREATE TABLE `help_ticket` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ticket_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query_detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_ticket`
--

INSERT INTO `help_ticket` (`id`, `user_id`, `ticket_id`, `name`, `email`, `mobile`, `query_detail`, `status`, `created_date`, `updated_date`) VALUES
(3, 3, 'TK00003', 'Dinesh', 'dinesh1@test.com', '1471471470', 'test ticket raised', 0, '2022-11-30 12:20:06', '2022-11-30 13:23:24'),
(4, 77, 'TK00004', 'john', 'john@gmail.com', '9676941819', 'kk', 0, '2022-11-30 14:32:03', NULL),
(5, 19, 'TK00005', 'krishna', 'krishna@gmail.com', '9090909090', 'dgfffdffdf', 0, '2022-11-30 16:06:03', NULL),
(6, 19, 'TK00006', 'krishna', 'krishna@gmail.com', '9090909090', 'dgfffdffdf', 0, '2022-11-30 16:16:15', NULL),
(7, 19, 'TK00007', 'krishna', 'krishna@gmail.com', '9090909090', 'sh dfff DH xv vvvvbb b', 0, '2022-11-30 16:37:54', NULL),
(8, 19, 'TK00008', 'krishna', 'krishna@gmail.com', '9090909090', 'tifuvnfubtjvg urufiguf', 0, '2022-11-30 16:40:23', NULL),
(9, 19, 'TK00009', 'krishna', 'krishna@gmail.com', '9090909090', 'dhshurr', 0, '2022-12-01 15:27:08', NULL),
(10, 86, 'TK00010', 'praveen', 'praveen@gmail.com', '9876598765', 'ttdd', 0, '2022-12-08 16:15:02', NULL),
(11, 86, 'TK00011', 'praveen', 'praveen@gmail.com', '9876598765', 'hi tes', 0, '2022-12-08 16:24:40', NULL),
(12, 109, 'TK00012', 'kiran', 'kiran@gmail.com', '9698745889', 'test', 0, '2022-12-08 16:54:06', NULL),
(13, 109, 'TK00013', 'kiran', 'kiran@gmail.com', '9698745889', 'test', 0, '2022-12-08 16:55:26', NULL),
(14, 109, 'TK00014', 'kiran', 'kiran@gmail.com', '9698745889', 'tesf', 0, '2022-12-08 17:17:26', NULL),
(15, 19, 'TK00015', 'krishna', 'krishna@gmail.com', '9090909090', 'test', 0, '2023-01-02 16:43:00', NULL),
(16, 133, 'TK00016', 'venkatesh', 'hemavenkatesh@gmail.com', '8143601999', 'hi', 0, '2023-01-06 10:15:10', NULL),
(17, 63, 'TK00017', 'Jennifer', 'jenniferkamura@gmail.com', '0719585416', 'hi', 0, '2023-01-06 17:43:10', NULL),
(18, 72, 'TK00018', 'Becky', 'joymbugua065@gmail.com', '0720736387', 'sthh rr', 0, '2023-01-06 17:49:41', NULL),
(19, 72, 'TK00019', 'Becky', 'joymbugua065@gmail.com', '0720736387', 'aargh', 0, '2023-01-06 17:52:54', NULL),
(20, 136, 'TK00020', 'jen', 'jen@gmail.com', '0723456789', 'fntnn', 0, '2023-01-06 18:24:58', NULL),
(21, 136, 'TK00021', 'jen', 'jen@gmail.com', '0723456789', 'cevtjt', 1, '2023-01-06 18:25:36', '2023-01-06 21:14:58'),
(22, 19, 'TK00022', 'krishna', 'krishna@gmail.com', '9090909090', 'dhddh', 0, '2023-01-07 12:10:39', NULL),
(23, 135, 'TK00023', 'hema', 'hema@gmail.com', '8143601888', 'hi', 0, '2023-01-07 13:45:29', NULL),
(24, 135, 'TK00024', 'hema', 'hema@gmail.com', '8143601888', 'hi', 0, '2023-01-07 13:45:48', NULL),
(25, 135, 'TK00025', 'hema', 'hema@gmail.com', '8143601888', 'hi', 0, '2023-01-08 11:01:46', NULL),
(26, 135, 'TK00026', 'hema', 'hema@gmail.com', '8143601888', 'hj', 0, '2023-01-08 11:04:08', NULL),
(27, 135, 'TK00027', 'hema', 'hema@gmail.com', '8143601888', 'hu', 0, '2023-01-08 11:05:04', NULL),
(28, 133, 'TK00028', 'venkatesh', 'hemavenkatesh@gmail.com', '8143601999', 'hi', 0, '2023-01-08 11:50:25', NULL),
(29, 133, 'TK00029', 'venkatesh', 'hemavenkatesh@gmail.com', '8143601999', 'ju', 0, '2023-01-08 19:42:26', NULL),
(30, 19, 'TK00030', 'krishna', 'krishna@gmail.com', '9090909090', 'hello team', 0, '2023-01-09 10:27:53', NULL),
(31, 19, 'TK00031', 'krishna', 'krishna@gmail.com', '9090909090', 'hello sir', 1, '2023-01-09 11:20:04', '2023-01-09 11:48:17'),
(32, 19, 'TK00032', 'krishna', 'krishna@gmail.com', '9090909090', 'hello sir', 1, '2023-01-09 11:49:01', '2023-01-09 11:49:32'),
(33, 133, 'TK00033', 'venkatesh hema venka', 'hemavenkatesh@gmail.com', '8143601999', 'hi', 0, '2023-01-09 15:57:17', NULL),
(34, 19, 'TK00034', 'krishna', 'krishna@gmail.com', '9090909090', 'gooooo', 0, '2023-01-09 17:33:32', NULL),
(35, 19, 'TK00035', 'krishna', 'krishna@gmail.com', '9090909090', 'bhfjhbhh', 0, '2023-01-09 17:38:26', NULL),
(36, 19, 'TK00036', 'krishna', 'krishna@gmail.com', '9090909090', 'hi', 0, '2023-01-13 13:01:05', NULL),
(37, 152, 'TK00037', 'Hema venkatesh', 'hemavenkatesh208@gmail.com', '8143601989', 'hi', 0, '2023-01-17 16:42:45', NULL),
(38, 152, 'TK00038', 'Hema venkatesh', 'hemavenkatesh208@gmail.com', '8143601989', 'hi', 0, '2023-01-17 16:43:36', NULL),
(39, 19, 'TK00039', 'krishna', 'krishna@gmail.com', '9090909090', 'hello', 0, '2023-01-21 11:38:44', NULL),
(40, 68, 'TK00040', 'chaitu', 'chaitanya.appdev@colourmoon.com', '9966002347', 'test', 0, '2023-01-28 12:51:50', NULL),
(41, 19, 'TK00041', 'krishna', 'krishna@gmail.com', '9090909090', 'hello', 1, '2023-02-01 15:20:18', '2023-02-01 18:34:36'),
(42, 191, 'TK00042', 'hema', 'hemavenkiyr@gmail.com', '825152851', 'hi', 0, '2023-02-02 18:04:09', NULL),
(43, 191, 'TK00043', 'hema', 'hemavenkiyr@gmail.com', '825152851', 'hi', 0, '2023-02-02 18:05:17', NULL),
(44, 191, 'TK00044', 'hema', 'hemavenkiyr@gmail.com', '825152851', 'hi', 0, '2023-02-02 18:05:19', NULL),
(45, 191, 'TK00045', 'hema', 'hemavenkiyr@gmail.com', '825152851', 'hi', 0, '2023-02-02 18:08:44', NULL),
(46, 191, 'TK00046', 'hema', 'hemavenkiyr@gmail.com', '825152851', 'nmk', 0, '2023-02-02 18:09:02', NULL),
(47, 19, 'TK00047', 'krishna', 'krishna@gmail.com', '9090909090', 'vhnxghccnhc', 0, '2023-02-08 17:31:52', NULL),
(48, 209, 'TK00048', 'aparna swain', 'aparnaawain001@gmail.com', '9861977974', 'ftdhfchhcf', 0, '2023-04-03 16:57:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `label` varchar(250) COLLATE utf8mb4_unicode_520_ci DEFAULT 'System',
  `key` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `level` int(11) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` mediumtext COLLATE utf8mb4_unicode_520_ci,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `label`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 'Default', '75xi3uer76tb7krer3mjgqei', 1, 0, 0, NULL, '2022-09-19 10:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `type` enum('Login','Logout') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `admin_id`, `type`, `date_time`) VALUES
(1, 1, 'Login', '2022-10-17 12:15:12'),
(2, 1, 'Login', '2022-10-18 10:45:00'),
(3, 1, 'Logout', '2022-10-18 10:59:07'),
(4, 1, 'Login', '2022-10-18 10:59:32'),
(5, 1, 'Login', '2022-10-18 20:15:53'),
(6, 1, 'Login', '2022-10-19 10:57:40'),
(7, 1, 'Login', '2022-10-20 10:03:05'),
(8, 1, 'Logout', '2022-10-20 17:10:06'),
(9, 1, 'Login', '2022-10-20 17:10:08'),
(10, 1, 'Logout', '2022-10-20 22:44:44'),
(11, 1, 'Login', '2022-10-21 10:02:43'),
(12, 1, 'Logout', '2022-10-21 10:03:55'),
(13, 1, 'Login', '2022-10-21 10:06:00'),
(14, 1, 'Login', '2022-10-21 10:08:19'),
(15, 1, 'Login', '2022-10-21 15:08:22'),
(16, 1, 'Logout', '2022-10-21 16:40:50'),
(17, 1, 'Login', '2022-10-21 16:41:45'),
(18, 1, 'Login', '2022-10-22 12:23:24'),
(19, 1, 'Login', '2022-10-25 12:29:20'),
(20, 1, 'Login', '2022-10-26 10:29:59'),
(21, 1, 'Login', '2022-10-26 15:02:59'),
(22, 1, 'Login', '2022-10-26 17:53:49'),
(23, 1, 'Login', '2022-10-27 17:23:24'),
(24, 1, 'Login', '2022-10-27 18:57:07'),
(25, 1, 'Login', '2022-10-27 19:00:58'),
(26, 1, 'Login', '2022-10-28 12:42:32'),
(27, 1, 'Login', '2022-10-28 17:01:26'),
(28, 1, 'Login', '2022-10-28 17:20:42'),
(29, 1, 'Login', '2022-10-28 17:31:00'),
(30, 1, 'Login', '2022-10-28 17:31:29'),
(31, 1, 'Login', '2022-10-28 18:31:57'),
(32, 1, 'Login', '2022-10-31 10:14:35'),
(33, 1, 'Login', '2022-10-31 14:55:26'),
(34, 1, 'Login', '2022-10-31 18:21:35'),
(35, 1, 'Login', '2022-11-01 10:01:08'),
(36, 1, 'Login', '2022-11-01 12:21:54'),
(37, 1, 'Login', '2022-11-01 12:23:26'),
(38, 1, 'Login', '2022-11-01 16:41:42'),
(39, 1, 'Login', '2022-11-02 14:21:45'),
(40, 1, 'Login', '2022-11-03 10:00:32'),
(41, 1, 'Login', '2022-11-03 17:19:09'),
(42, 1, 'Login', '2022-11-03 20:22:40'),
(43, 1, 'Login', '2022-11-04 09:59:42'),
(44, 1, 'Login', '2022-11-04 11:32:21'),
(45, 1, 'Login', '2022-11-04 14:47:56'),
(46, 1, 'Login', '2022-11-04 15:44:12'),
(47, 1, 'Login', '2022-11-04 15:45:23'),
(48, 1, 'Login', '2022-11-04 15:48:02'),
(49, 1, 'Login', '2022-11-04 15:49:34'),
(50, 1, 'Login', '2022-11-04 16:35:45'),
(51, 1, 'Login', '2022-11-04 17:13:34'),
(52, 1, 'Login', '2022-11-04 17:45:27'),
(53, 1, 'Login', '2022-11-07 10:04:22'),
(54, 1, 'Login', '2022-11-08 14:39:22'),
(55, 1, 'Login', '2022-11-09 15:08:18'),
(56, 1, 'Login', '2022-11-10 09:54:17'),
(57, 1, 'Login', '2022-11-11 11:02:03'),
(58, 1, 'Login', '2022-11-11 12:12:37'),
(59, 1, 'Login', '2022-11-14 09:54:56'),
(60, 1, 'Login', '2022-11-14 19:19:00'),
(61, 1, 'Login', '2022-11-15 09:50:48'),
(62, 1, 'Login', '2022-11-15 11:26:58'),
(63, 1, 'Login', '2022-11-15 14:11:35'),
(64, 1, 'Login', '2022-11-15 16:23:24'),
(65, 1, 'Login', '2022-11-15 17:10:53'),
(66, 1, 'Login', '2022-11-16 09:57:39'),
(67, 1, 'Login', '2022-11-16 11:36:24'),
(68, 1, 'Login', '2022-11-16 18:50:51'),
(69, 1, 'Login', '2022-11-17 10:13:36'),
(70, 1, 'Login', '2022-11-17 13:13:39'),
(71, 1, 'Login', '2022-11-17 17:27:32'),
(72, 1, 'Login', '2022-11-18 00:29:15'),
(73, 1, 'Logout', '2022-11-18 01:45:51'),
(74, 1, 'Login', '2022-11-18 09:47:13'),
(75, 1, 'Login', '2022-11-18 14:47:06'),
(76, 1, 'Login', '2022-11-18 16:01:39'),
(77, 1, 'Login', '2022-11-19 10:02:28'),
(78, 1, 'Login', '2022-11-19 11:06:25'),
(79, 1, 'Login', '2022-11-21 09:59:19'),
(80, 1, 'Login', '2022-11-21 11:24:55'),
(81, 1, 'Login', '2022-11-21 12:53:59'),
(82, 1, 'Login', '2022-11-21 14:10:45'),
(83, 1, 'Login', '2022-11-21 17:56:21'),
(84, 1, 'Login', '2022-11-22 09:56:52'),
(85, 1, 'Login', '2022-11-22 10:20:04'),
(86, 1, 'Login', '2022-11-22 14:44:36'),
(87, 1, 'Login', '2022-11-22 17:49:18'),
(88, 1, 'Login', '2022-11-22 18:56:57'),
(89, 1, 'Login', '2022-11-23 09:59:41'),
(90, 1, 'Login', '2022-11-23 10:23:39'),
(91, 1, 'Login', '2022-11-23 11:46:06'),
(92, 1, 'Login', '2022-11-23 11:47:10'),
(93, 1, 'Login', '2022-11-23 13:02:10'),
(94, 1, 'Login', '2022-11-23 16:06:10'),
(95, 1, 'Login', '2022-11-23 16:38:45'),
(96, 1, 'Login', '2022-11-23 17:59:02'),
(97, 1, 'Login', '2022-11-23 18:25:25'),
(98, 1, 'Login', '2022-11-24 09:57:11'),
(99, 1, 'Login', '2022-11-24 10:29:36'),
(100, 1, 'Login', '2022-11-24 10:30:14'),
(101, 1, 'Login', '2022-11-24 13:57:19'),
(102, 1, 'Login', '2022-11-24 14:05:07'),
(103, 1, 'Login', '2022-11-25 10:01:18'),
(104, 1, 'Login', '2022-11-25 10:03:17'),
(105, 1, 'Login', '2022-11-25 15:07:26'),
(106, 1, 'Login', '2022-11-25 16:16:07'),
(107, 1, 'Login', '2022-11-25 17:41:43'),
(108, 1, 'Login', '2022-11-26 09:55:55'),
(109, 1, 'Login', '2022-11-28 09:56:22'),
(110, 1, 'Login', '2022-11-28 13:23:48'),
(111, 1, 'Login', '2022-11-28 18:00:39'),
(112, 1, 'Login', '2022-11-29 08:32:56'),
(113, 1, 'Login', '2022-11-29 09:59:31'),
(114, 1, 'Login', '2022-11-29 10:27:37'),
(115, 1, 'Login', '2022-11-29 12:11:21'),
(116, 1, 'Login', '2022-11-29 12:37:57'),
(117, 1, 'Login', '2022-11-29 12:38:48'),
(118, 1, 'Login', '2022-11-29 12:59:23'),
(119, 1, 'Login', '2022-11-29 13:14:34'),
(120, 1, 'Login', '2022-11-29 13:51:41'),
(121, 1, 'Login', '2022-11-29 16:01:50'),
(122, 1, 'Login', '2022-11-30 09:58:31'),
(123, 1, 'Login', '2022-11-30 10:16:51'),
(124, 1, 'Login', '2022-11-30 16:17:30'),
(125, 1, 'Login', '2022-12-01 09:26:14'),
(126, 1, 'Login', '2022-12-01 09:38:12'),
(127, 1, 'Login', '2022-12-01 09:52:44'),
(128, 1, 'Login', '2022-12-01 13:49:59'),
(129, 1, 'Login', '2022-12-01 18:08:32'),
(130, 1, 'Login', '2022-12-01 18:08:48'),
(131, 1, 'Login', '2022-12-02 09:53:41'),
(132, 1, 'Login', '2022-12-02 09:58:41'),
(133, 1, 'Login', '2022-12-02 10:04:03'),
(134, 1, 'Login', '2022-12-02 13:27:06'),
(135, 1, 'Login', '2022-12-02 15:32:31'),
(136, 1, 'Login', '2022-12-03 10:00:36'),
(137, 1, 'Login', '2022-12-03 11:50:06'),
(138, 1, 'Login', '2022-12-05 09:58:29'),
(139, 1, 'Login', '2022-12-05 12:18:48'),
(140, 1, 'Login', '2022-12-05 15:18:08'),
(141, 1, 'Login', '2022-12-05 17:03:11'),
(142, 1, 'Login', '2022-12-06 09:55:18'),
(143, 1, 'Login', '2022-12-06 12:38:06'),
(144, 1, 'Login', '2022-12-07 09:59:25'),
(145, 1, 'Login', '2022-12-07 18:56:17'),
(146, 1, 'Login', '2022-12-08 09:58:58'),
(147, 1, 'Login', '2022-12-08 11:09:14'),
(148, 1, 'Login', '2022-12-08 14:45:04'),
(149, 1, 'Login', '2022-12-08 14:49:39'),
(150, 1, 'Login', '2022-12-09 10:29:24'),
(151, 1, 'Login', '2022-12-09 10:56:00'),
(152, 1, 'Login', '2022-12-09 11:29:28'),
(153, 1, 'Login', '2022-12-09 12:43:03'),
(154, 1, 'Login', '2022-12-09 14:46:14'),
(155, 1, 'Login', '2022-12-10 09:59:58'),
(156, 1, 'Login', '2022-12-10 20:42:44'),
(157, 1, 'Login', '2022-12-12 10:00:08'),
(158, 1, 'Login', '2022-12-12 12:17:49'),
(159, 1, 'Login', '2022-12-12 15:12:40'),
(160, 1, 'Login', '2022-12-12 16:03:28'),
(161, 1, 'Login', '2022-12-13 09:59:25'),
(162, 1, 'Login', '2022-12-13 10:56:20'),
(163, 1, 'Login', '2022-12-13 14:26:18'),
(164, 1, 'Login', '2022-12-13 18:01:18'),
(165, 1, 'Login', '2022-12-14 12:06:34'),
(166, 1, 'Login', '2022-12-14 12:21:55'),
(167, 1, 'Login', '2022-12-14 14:40:14'),
(168, 1, 'Login', '2022-12-14 14:43:07'),
(169, 1, 'Login', '2022-12-15 17:18:02'),
(170, 1, 'Logout', '2022-12-15 17:20:51'),
(171, 1, 'Login', '2022-12-16 18:30:09'),
(172, 1, 'Login', '2022-12-19 14:59:16'),
(173, 1, 'Login', '2022-12-20 09:08:15'),
(174, 1, 'Login', '2022-12-20 14:34:38'),
(175, 1, 'Login', '2022-12-21 09:31:30'),
(176, 1, 'Login', '2022-12-22 14:49:58'),
(177, 1, 'Login', '2022-12-22 14:57:18'),
(178, 1, 'Login', '2022-12-22 14:57:20'),
(179, 1, 'Login', '2022-12-23 10:05:31'),
(180, 1, 'Logout', '2022-12-23 10:11:06'),
(181, 1, 'Login', '2022-12-23 15:50:53'),
(182, 1, 'Login', '2022-12-28 17:36:18'),
(183, 1, 'Login', '2022-12-29 10:51:34'),
(184, 1, 'Login', '2022-12-30 13:00:15'),
(185, 1, 'Login', '2022-12-30 15:37:02'),
(186, 1, 'Login', '2022-12-30 16:17:10'),
(187, 1, 'Logout', '2022-12-30 17:59:44'),
(188, 1, 'Login', '2022-12-31 09:59:35'),
(189, 1, 'Login', '2023-01-02 10:00:22'),
(190, 1, 'Login', '2023-01-02 14:35:35'),
(191, 1, 'Login', '2023-01-02 16:07:59'),
(192, 1, 'Login', '2023-01-02 17:02:23'),
(193, 1, 'Login', '2023-01-03 09:59:02'),
(194, 1, 'Login', '2023-01-03 11:04:10'),
(195, 1, 'Login', '2023-01-03 11:37:39'),
(196, 1, 'Login', '2023-01-03 11:46:49'),
(197, 1, 'Login', '2023-01-03 12:11:54'),
(198, 1, 'Login', '2023-01-03 13:58:44'),
(199, 1, 'Login', '2023-01-03 17:25:45'),
(200, 1, 'Login', '2023-01-03 17:45:42'),
(201, 1, 'Login', '2023-01-04 16:29:24'),
(202, 1, 'Login', '2023-01-04 18:17:54'),
(203, 1, 'Login', '2023-01-04 18:53:47'),
(204, 1, 'Login', '2023-01-05 12:20:25'),
(205, 1, 'Login', '2023-01-05 13:53:30'),
(206, 1, 'Login', '2023-01-05 14:30:28'),
(207, 1, 'Login', '2023-01-05 14:40:33'),
(208, 1, 'Login', '2023-01-05 16:18:08'),
(209, 1, 'Login', '2023-01-05 16:33:56'),
(210, 1, 'Logout', '2023-01-05 17:04:49'),
(211, 1, 'Login', '2023-01-05 17:53:25'),
(212, 1, 'Login', '2023-01-06 11:05:24'),
(213, 1, 'Login', '2023-01-06 15:12:45'),
(214, 1, 'Logout', '2023-01-06 15:13:06'),
(215, 1, 'Login', '2023-01-06 16:08:13'),
(216, 1, 'Login', '2023-01-06 16:10:21'),
(217, 1, 'Login', '2023-01-06 17:13:28'),
(218, 1, 'Login', '2023-01-06 18:10:03'),
(219, 1, 'Login', '2023-01-06 18:10:09'),
(220, 1, 'Login', '2023-01-06 18:17:51'),
(221, 1, 'Logout', '2023-01-06 18:48:32'),
(222, 1, 'Login', '2023-01-07 10:03:35'),
(223, 1, 'Login', '2023-01-07 11:02:31'),
(224, 1, 'Login', '2023-01-08 11:14:57'),
(225, 1, 'Login', '2023-01-08 19:45:08'),
(226, 1, 'Login', '2023-01-09 10:23:07'),
(227, 1, 'Login', '2023-01-09 10:32:49'),
(228, 1, 'Login', '2023-01-09 10:51:10'),
(229, 1, 'Login', '2023-01-09 11:46:18'),
(230, 1, 'Login', '2023-01-09 11:48:23'),
(231, 1, 'Login', '2023-01-09 11:49:19'),
(232, 1, 'Login', '2023-01-09 11:50:41'),
(233, 1, 'Login', '2023-01-09 11:56:06'),
(234, 1, 'Login', '2023-01-09 12:04:53'),
(235, 1, 'Login', '2023-01-09 12:11:42'),
(236, 1, 'Login', '2023-01-09 14:01:09'),
(237, 1, 'Login', '2023-01-09 14:54:31'),
(238, 1, 'Login', '2023-01-09 14:54:33'),
(239, 1, 'Login', '2023-01-09 14:54:33'),
(240, 1, 'Login', '2023-01-09 15:30:28'),
(241, 1, 'Login', '2023-01-09 15:42:10'),
(242, 1, 'Login', '2023-01-10 09:56:55'),
(243, 1, 'Login', '2023-01-10 15:27:00'),
(244, 1, 'Login', '2023-01-11 14:32:45'),
(245, 1, 'Login', '2023-01-11 14:59:28'),
(246, 1, 'Logout', '2023-01-11 15:00:36'),
(247, 1, 'Login', '2023-01-11 15:00:41'),
(248, 1, 'Logout', '2023-01-11 15:00:49'),
(249, 1, 'Login', '2023-01-11 15:01:35'),
(250, 1, 'Login', '2023-01-11 16:27:44'),
(251, 1, 'Logout', '2023-01-11 16:29:44'),
(252, 1, 'Login', '2023-01-11 16:35:11'),
(253, 1, 'Logout', '2023-01-11 16:45:11'),
(254, 1, 'Login', '2023-01-11 17:53:53'),
(255, 1, 'Login', '2023-01-11 17:56:32'),
(256, 1, 'Logout', '2023-01-11 20:31:11'),
(257, 1, 'Login', '2023-01-12 10:01:37'),
(258, 1, 'Login', '2023-01-12 10:28:35'),
(259, 1, 'Login', '2023-01-12 11:18:00'),
(260, 1, 'Login', '2023-01-12 14:40:21'),
(261, 1, 'Login', '2023-01-13 10:05:53'),
(262, 1, 'Login', '2023-01-13 10:20:56'),
(263, 1, 'Login', '2023-01-16 11:14:02'),
(264, 1, 'Login', '2023-01-16 18:04:32'),
(265, 1, 'Login', '2023-01-17 10:00:33'),
(266, 1, 'Logout', '2023-01-17 10:13:01'),
(267, 1, 'Login', '2023-01-17 10:49:20'),
(268, 1, 'Login', '2023-01-17 11:00:18'),
(269, 1, 'Logout', '2023-01-17 12:39:14'),
(270, 1, 'Logout', '2023-01-17 14:02:17'),
(271, 5, 'Login', '2023-01-17 14:02:26'),
(272, 5, 'Logout', '2023-01-17 14:03:26'),
(273, 1, 'Login', '2023-01-17 14:03:53'),
(274, 1, 'Logout', '2023-01-17 14:06:54'),
(275, 5, 'Login', '2023-01-17 14:07:24'),
(276, 5, 'Logout', '2023-01-17 14:08:57'),
(277, 1, 'Login', '2023-01-17 14:09:16'),
(278, 1, 'Logout', '2023-01-17 14:13:44'),
(279, 5, 'Login', '2023-01-17 14:14:19'),
(280, 5, 'Logout', '2023-01-17 14:52:39'),
(281, 1, 'Login', '2023-01-17 14:52:55'),
(282, 1, 'Logout', '2023-01-17 14:58:26'),
(283, 5, 'Login', '2023-01-17 14:58:49'),
(284, 5, 'Logout', '2023-01-17 15:02:16'),
(285, 1, 'Login', '2023-01-17 15:02:37'),
(286, 1, 'Logout', '2023-01-17 15:05:37'),
(287, 5, 'Login', '2023-01-17 15:06:19'),
(288, 5, 'Logout', '2023-01-17 15:07:34'),
(289, 1, 'Login', '2023-01-17 15:07:45'),
(290, 1, 'Logout', '2023-01-17 15:08:13'),
(291, 1, 'Login', '2023-01-17 15:09:15'),
(292, 1, 'Login', '2023-01-17 15:09:15'),
(293, 1, 'Logout', '2023-01-17 15:09:48'),
(294, 1, 'Login', '2023-01-17 15:10:42'),
(295, 1, 'Logout', '2023-01-17 15:13:06'),
(296, 6, 'Login', '2023-01-17 15:13:11'),
(297, 6, 'Logout', '2023-01-17 15:14:51'),
(298, 1, 'Login', '2023-01-17 15:15:03'),
(299, 1, 'Login', '2023-01-18 10:21:49'),
(300, 1, 'Login', '2023-01-18 10:48:12'),
(301, 1, 'Login', '2023-01-18 11:05:19'),
(302, 1, 'Logout', '2023-01-18 11:29:12'),
(303, 1, 'Login', '2023-01-18 12:03:55'),
(304, 1, 'Login', '2023-01-18 12:07:59'),
(305, 1, 'Login', '2023-01-18 14:57:36'),
(306, 1, 'Login', '2023-01-19 12:50:58'),
(307, 1, 'Login', '2023-01-19 15:00:32'),
(308, 1, 'Login', '2023-01-19 15:24:47'),
(309, 1, 'Login', '2023-01-19 18:30:40'),
(310, 1, 'Login', '2023-01-20 10:17:22'),
(311, 1, 'Login', '2023-01-20 12:45:02'),
(312, 1, 'Login', '2023-01-20 15:40:28'),
(313, 1, 'Login', '2023-01-20 15:40:31'),
(314, 1, 'Login', '2023-01-20 16:05:03'),
(315, 1, 'Login', '2023-01-20 16:21:16'),
(316, 1, 'Login', '2023-01-20 16:22:59'),
(317, 1, 'Login', '2023-01-20 17:42:23'),
(318, 1, 'Login', '2023-01-23 10:29:38'),
(319, 1, 'Login', '2023-01-23 10:29:52'),
(320, 1, 'Login', '2023-01-23 10:32:26'),
(321, 1, 'Login', '2023-01-23 15:08:21'),
(322, 1, 'Login', '2023-01-23 17:49:34'),
(323, 1, 'Login', '2023-01-24 11:54:58'),
(324, 1, 'Login', '2023-01-25 13:41:14'),
(325, 1, 'Login', '2023-01-25 13:44:08'),
(326, 1, 'Login', '2023-01-25 13:49:08'),
(327, 1, 'Login', '2023-01-25 15:17:16'),
(328, 1, 'Login', '2023-01-25 15:51:34'),
(329, 1, 'Login', '2023-01-27 09:58:39'),
(330, 1, 'Login', '2023-01-27 18:32:51'),
(331, 1, 'Login', '2023-01-27 19:02:15'),
(332, 1, 'Login', '2023-01-28 10:45:22'),
(333, 1, 'Login', '2023-01-28 11:48:02'),
(334, 1, 'Login', '2023-01-30 10:08:32'),
(335, 1, 'Login', '2023-01-30 10:32:08'),
(336, 1, 'Login', '2023-01-30 10:47:18'),
(337, 1, 'Login', '2023-01-30 12:12:48'),
(338, 1, 'Login', '2023-01-30 12:12:50'),
(339, 1, 'Logout', '2023-01-30 12:51:36'),
(340, 2, 'Login', '2023-01-30 12:51:52'),
(341, 2, 'Logout', '2023-01-30 13:07:04'),
(342, 1, 'Login', '2023-01-30 13:07:17'),
(343, 1, 'Logout', '2023-01-30 13:12:28'),
(344, 2, 'Login', '2023-01-30 13:12:41'),
(345, 2, 'Logout', '2023-01-30 13:13:09'),
(346, 1, 'Login', '2023-01-30 13:14:24'),
(347, 1, 'Login', '2023-01-30 15:51:48'),
(348, 1, 'Login', '2023-01-30 18:06:54'),
(349, 1, 'Login', '2023-01-30 18:06:54'),
(350, 1, 'Login', '2023-01-31 10:09:05'),
(351, 1, 'Login', '2023-01-31 11:49:57'),
(352, 1, 'Login', '2023-01-31 12:34:11'),
(353, 1, 'Login', '2023-01-31 12:34:11'),
(354, 1, 'Logout', '2023-01-31 13:22:18'),
(355, 1, 'Login', '2023-01-31 14:45:14'),
(356, 1, 'Login', '2023-01-31 15:25:18'),
(357, 1, 'Logout', '2023-01-31 15:25:51'),
(358, 1, 'Login', '2023-01-31 15:38:30'),
(359, 1, 'Login', '2023-01-31 18:16:08'),
(360, 1, 'Login', '2023-02-01 15:09:50'),
(361, 1, 'Login', '2023-02-01 15:40:43'),
(362, 1, 'Login', '2023-02-01 18:17:30'),
(363, 1, 'Login', '2023-02-01 18:19:35'),
(364, 1, 'Login', '2023-02-01 18:44:39'),
(365, 1, 'Login', '2023-02-02 10:15:47'),
(366, 1, 'Login', '2023-02-02 10:40:16'),
(367, 1, 'Login', '2023-02-02 10:56:19'),
(368, 1, 'Logout', '2023-02-02 10:59:51'),
(369, 1, 'Login', '2023-02-02 11:00:43'),
(370, 1, 'Logout', '2023-02-02 11:02:33'),
(371, 7, 'Login', '2023-02-02 11:02:37'),
(372, 7, 'Logout', '2023-02-02 11:02:58'),
(373, 1, 'Login', '2023-02-02 11:07:04'),
(374, 1, 'Logout', '2023-02-02 11:07:51'),
(375, 1, 'Login', '2023-02-02 11:08:41'),
(376, 1, 'Logout', '2023-02-02 11:09:39'),
(377, 1, 'Login', '2023-02-02 11:12:20'),
(378, 1, 'Login', '2023-02-02 16:57:33'),
(379, 1, 'Login', '2023-02-02 16:57:35'),
(380, 1, 'Login', '2023-02-02 16:57:35'),
(381, 1, 'Login', '2023-02-03 10:01:30'),
(382, 1, 'Login', '2023-02-03 16:02:55'),
(383, 1, 'Login', '2023-02-04 10:15:16'),
(384, 1, 'Login', '2023-02-04 10:37:26'),
(385, 1, 'Login', '2023-02-06 16:27:05'),
(386, 1, 'Logout', '2023-02-06 16:35:43'),
(387, 1, 'Login', '2023-02-07 17:18:43'),
(388, 1, 'Login', '2023-02-08 16:30:43'),
(389, 1, 'Login', '2023-02-09 10:01:38'),
(390, 1, 'Login', '2023-02-09 12:59:29'),
(391, 1, 'Logout', '2023-02-09 15:59:07'),
(392, 1, 'Login', '2023-02-10 09:54:53'),
(393, 1, 'Logout', '2023-02-10 10:24:46'),
(394, 1, 'Login', '2023-02-13 17:29:35'),
(395, 1, 'Login', '2023-02-13 17:32:20'),
(396, 1, 'Login', '2023-02-14 10:03:00'),
(397, 1, 'Logout', '2023-02-14 10:51:42'),
(398, 1, 'Login', '2023-02-22 10:20:31'),
(399, 1, 'Logout', '2023-02-22 10:31:01'),
(400, 1, 'Login', '2023-02-23 10:50:28'),
(401, 1, 'Login', '2023-03-03 12:27:03'),
(402, 1, 'Logout', '2023-03-03 12:27:14'),
(403, 1, 'Login', '2023-03-03 12:27:17'),
(404, 1, 'Logout', '2023-03-03 14:53:29'),
(405, 1, 'Login', '2023-03-16 14:50:29'),
(406, 1, 'Login', '2023-03-16 16:53:22'),
(407, 1, 'Login', '2023-03-17 09:57:48'),
(408, 1, 'Login', '2023-03-17 13:44:45'),
(409, 1, 'Login', '2023-03-17 17:56:55'),
(410, 1, 'Login', '2023-03-18 10:03:10'),
(411, 1, 'Login', '2023-03-20 10:00:18'),
(412, 1, 'Login', '2023-03-20 11:07:51'),
(413, 1, 'Login', '2023-03-20 15:00:00'),
(414, 1, 'Login', '2023-03-21 11:23:17'),
(415, 1, 'Login', '2023-03-21 17:00:11'),
(416, 1, 'Login', '2023-03-23 14:55:04'),
(417, 1, 'Login', '2023-03-23 14:55:06'),
(418, 1, 'Logout', '2023-03-23 14:55:19'),
(419, 1, 'Login', '2023-03-23 15:01:42'),
(420, 1, 'Logout', '2023-03-23 15:03:32'),
(421, 1, 'Login', '2023-03-24 10:53:28'),
(422, 1, 'Login', '2023-03-24 14:36:51'),
(423, 1, 'Login', '2023-03-24 16:45:57'),
(424, 1, 'Login', '2023-03-24 18:35:02'),
(425, 1, 'Login', '2023-03-25 11:28:02'),
(426, 1, 'Login', '2023-03-27 14:06:08'),
(427, 1, 'Login', '2023-03-27 16:24:19'),
(428, 1, 'Login', '2023-03-27 17:30:45'),
(429, 1, 'Login', '2023-03-28 10:35:39'),
(430, 1, 'Login', '2023-03-28 10:45:04'),
(431, 1, 'Logout', '2023-03-28 11:31:32'),
(432, 1, 'Login', '2023-03-28 11:45:06'),
(433, 1, 'Logout', '2023-03-28 11:55:46'),
(434, 1, 'Login', '2023-03-28 14:23:53'),
(435, 1, 'Login', '2023-03-31 12:11:30'),
(436, 1, 'Login', '2023-03-31 14:00:50'),
(437, 1, 'Login', '2023-03-31 15:13:06'),
(438, 1, 'Login', '2023-03-31 16:14:34'),
(439, 1, 'Login', '2023-03-31 16:15:14'),
(440, 1, 'Login', '2023-03-31 16:15:47'),
(441, 1, 'Login', '2023-03-31 16:16:07'),
(442, 1, 'Login', '2023-03-31 16:16:51'),
(443, 1, 'Login', '2023-03-31 16:17:12'),
(444, 1, 'Login', '2023-03-31 16:18:14'),
(445, 1, 'Login', '2023-03-31 16:18:01'),
(446, 1, 'Login', '2023-03-31 16:19:23'),
(447, 1, 'Login', '2023-03-31 16:21:15'),
(448, 1, 'Login', '2023-03-31 16:44:04'),
(449, 1, 'Login', '2023-03-31 16:45:09'),
(450, 1, 'Login', '2023-03-31 16:44:42'),
(451, 1, 'Login', '2023-03-31 16:47:00'),
(452, 1, 'Login', '2023-03-31 16:48:08'),
(453, 1, 'Login', '2023-03-31 16:47:52'),
(454, 1, 'Login', '2023-03-31 16:48:24'),
(455, 1, 'Login', '2023-03-31 16:48:41'),
(456, 1, 'Login', '2023-03-31 16:48:27'),
(457, 1, 'Login', '2023-03-31 16:47:15'),
(458, 1, 'Login', '2023-03-31 16:48:22'),
(459, 1, 'Login', '2023-03-31 16:48:08'),
(460, 1, 'Login', '2023-03-31 16:50:12'),
(461, 1, 'Login', '2023-03-31 16:49:26'),
(462, 1, 'Login', '2023-03-31 16:49:42'),
(463, 1, 'Login', '2023-03-31 16:50:17'),
(464, 1, 'Login', '2023-03-31 16:50:01'),
(465, 1, 'Login', '2023-03-31 16:56:09'),
(466, 1, 'Login', '2023-03-31 16:59:48'),
(467, 1, 'Login', '2023-03-31 17:03:25'),
(468, 1, 'Login', '2023-03-31 17:05:23'),
(469, 1, 'Login', '2023-03-31 17:03:57'),
(470, 1, 'Login', '2023-03-31 17:03:58'),
(471, 1, 'Login', '2023-03-31 17:09:41'),
(472, 1, 'Login', '2023-03-31 17:09:43'),
(473, 1, 'Login', '2023-03-31 17:10:06'),
(474, 1, 'Login', '2023-03-31 17:14:09'),
(475, 1, 'Login', '2023-03-31 19:36:31'),
(476, 1, 'Login', '2023-04-01 06:46:54'),
(477, 1, 'Login', '2023-04-01 11:34:09'),
(478, 1, 'Login', '2023-04-03 13:02:55'),
(479, 1, 'Login', '2023-04-03 15:04:49'),
(480, 1, 'Login', '2023-04-03 16:18:46'),
(481, 1, 'Login', '2023-04-03 17:10:21'),
(482, 1, 'Login', '2023-04-05 18:31:54'),
(483, 1, 'Login', '2023-04-05 18:32:46'),
(484, 1, 'Login', '2023-04-05 18:32:09'),
(485, 1, 'Login', '2023-04-05 18:34:40'),
(486, 1, 'Login', '2023-04-05 18:35:04'),
(487, 1, 'Login', '2023-04-05 18:34:44'),
(488, 1, 'Login', '2023-04-05 18:35:05'),
(489, 1, 'Login', '2023-04-05 18:34:45'),
(490, 1, 'Login', '2023-04-05 18:34:46'),
(491, 1, 'Login', '2023-04-05 18:35:03'),
(492, 1, 'Login', '2023-04-06 18:47:05'),
(493, 1, 'Login', '2023-04-06 18:49:14'),
(494, 1, 'Login', '2023-04-06 18:49:25'),
(495, 1, 'Login', '2023-04-10 16:12:12'),
(496, 1, 'Login', '2023-04-14 16:11:05'),
(497, 1, 'Login', '2023-04-14 17:40:51'),
(498, 1, 'Login', '2023-04-27 10:16:35'),
(499, 1, 'Login', '2023-05-03 17:23:16'),
(500, 1, 'Login', '2023-05-09 17:10:36'),
(501, 1, 'Login', '2023-05-09 17:11:01'),
(502, 1, 'Login', '2023-05-09 18:35:28'),
(503, 1, 'Login', '2023-05-10 10:12:49'),
(504, 1, 'Login', '2023-05-10 10:22:32'),
(505, 1, 'Login', '2023-05-11 09:39:13'),
(506, 1, 'Login', '2023-05-11 10:10:34'),
(507, 1, 'Login', '2023-05-11 10:19:49'),
(508, 1, 'Login', '2023-05-11 10:21:36'),
(509, 1, 'Login', '2023-05-11 14:12:33'),
(510, 1, 'Login', '2023-05-15 09:57:50'),
(511, 1, 'Login', '2023-05-19 19:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `new_order_notifications`
--

CREATE TABLE `new_order_notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `distance_in_km` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `is_sent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_order_notifications`
--

INSERT INTO `new_order_notifications` (`id`, `user_id`, `distance_in_km`, `order_id`, `date_time`, `is_sent`) VALUES
(1, 19, '1', 1268, '2023-05-10 11:12:07', 1),
(2, 19, '1', 1269, '2023-05-10 11:28:53', 1),
(3, 19, '5505.181252420259', 1274, '2023-05-10 11:40:23', 1),
(4, 19, '5505.181252420259', 1275, '2023-05-11 10:09:27', 1),
(5, 19, '5505.181252420259', 1277, '2023-05-11 10:12:44', 1),
(6, 19, '5505.181252420259', 1279, '2023-05-11 10:18:25', 1),
(7, 19, '5505.181252420259', 1280, '2023-05-11 10:22:20', 1),
(8, 19, '5505.181252420259', 1281, '2023-05-11 10:23:23', 1),
(9, 19, '5505.181252420259', 1283, '2023-05-11 10:41:51', 1),
(10, 19, '5505.181252420259', 1284, '2023-05-11 10:43:21', 1),
(11, 19, '5505.181252420259', 1286, '2023-05-11 10:48:23', 1),
(12, 19, '5505.181252420259', 1287, '2023-05-11 10:57:34', 1),
(13, 19, '5505.181252420259', 1291, '2023-05-11 11:03:01', 1),
(14, 19, '1', 1293, '2023-05-11 11:03:38', 1),
(15, 19, '5505.181252420259', 1294, '2023-05-11 11:12:41', 1),
(16, 19, '5505.181252420259', 1295, '2023-05-11 11:58:57', 1),
(17, 19, '5505.181252420259', 1296, '2023-05-11 12:40:08', 1),
(18, 19, '5505.181252420259', 1300, '2023-05-19 15:20:57', 1),
(19, 19, '5505.181252420259', 1301, '2023-05-19 15:21:34', 1),
(20, 19, '5505.181252420259', 1302, '2023-05-19 15:22:56', 1),
(21, 19, '5505.181252420259', 1303, '2023-05-19 16:24:51', 1),
(22, 19, '5505.181252420259', 1304, '2023-05-19 16:54:26', 1),
(23, 19, '5505.181252420259', 1305, '2023-05-19 16:54:49', 1),
(24, 19, '5475', 1306, '2023-05-19 19:27:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `admin_read` tinyint(1) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `date_time`, `is_delete`, `is_read`, `is_admin`, `is_custom`, `admin_read`, `order_id`) VALUES
(2740, 1, 'New Order', 'New Order Placed : O01217', '2023-03-28 14:20:56', 0, 1, 1, 0, 0, 0),
(2741, 107, 'Accepted Order', 'Order Accepted : O01217', '2023-03-28 14:22:49', 0, 1, 0, 0, 0, 0),
(2742, 107, 'Reach Order', 'Transporter reached depot Order : O01217', '2023-03-28 14:23:38', 0, 1, 0, 0, 0, 0),
(2743, 107, 'Loaded Order', 'Transporter collected fuel Order : O01217', '2023-03-28 14:23:48', 0, 1, 0, 0, 0, 0),
(2744, 107, 'Completed Order', 'Order Completed : O01217', '2023-03-28 14:23:59', 0, 1, 0, 0, 0, 0),
(2749, 68, 'Feedback', 'Feedback Rating : 1 star null\\ngood', '2023-04-10 16:44:10', 0, 0, 0, 0, 0, 0),
(2750, 68, 'Feedback', 'Feedback Rating : 2 star Awesome\\ngood', '2023-04-10 16:44:58', 0, 0, 0, 0, 0, 0),
(2751, 1, 'New Order', 'New Order Placed : O01243', '2023-04-20 14:35:10', 0, 0, 1, 0, 0, 0),
(2752, 1, 'New Order', 'New Order Placed : O01245', '2023-04-27 12:13:56', 0, 0, 1, 0, 0, 0),
(2753, 1, 'New Order', 'New Order Placed : O01248', '2023-04-27 12:28:08', 0, 0, 1, 0, 0, 0),
(2754, 1, 'New Order', 'New Order Placed : O01249', '2023-04-27 12:31:53', 0, 0, 1, 0, 0, 0),
(2755, 68, 'Order Cancelled', 'Order Cancelled : O01244. Amount will be credited in your wallet.', '2023-04-27 12:40:56', 0, 0, 0, 0, 0, 0),
(2756, 1, 'New Order', 'New Order Placed : O01244', '2023-04-27 12:43:58', 0, 0, 1, 0, 0, 0),
(2757, 1, 'New Order', 'New Order Placed : O01250', '2023-04-27 13:53:54', 0, 0, 1, 0, 0, 0),
(2758, 1, 'New Order', 'New Order Placed : O01251', '2023-04-27 14:01:09', 0, 0, 1, 0, 0, 0),
(2759, 1, 'New Order', 'New Order Placed : O01252', '2023-04-27 14:01:10', 0, 0, 1, 0, 0, 0),
(2760, 1, 'New Order', 'New Order Placed : O01251', '2023-04-27 14:01:10', 0, 0, 1, 0, 0, 0),
(2761, 1, 'New Order', 'New Order Placed : O01253', '2023-04-27 14:02:09', 0, 0, 1, 0, 0, 0),
(2762, 1, 'New Order', 'New Order Placed : O01253', '2023-04-27 14:02:11', 0, 0, 1, 0, 0, 0),
(2763, 1, 'New Order', 'New Order Placed : O01254', '2023-04-27 14:02:24', 0, 0, 1, 0, 0, 0),
(2764, 1, 'New Order', 'New Order Placed : O01256', '2023-04-27 15:12:16', 0, 0, 1, 0, 0, 0),
(2765, 1, 'New Order', 'New Order Placed : O01257', '2023-04-28 14:50:02', 0, 0, 1, 0, 0, 0),
(2766, 1, 'New Order', 'New Order Placed : O01257', '2023-04-28 14:50:02', 0, 0, 1, 0, 0, 0),
(2767, 1, 'New Order', 'New Order Placed : O01259', '2023-05-03 15:16:26', 0, 0, 1, 0, 0, 0),
(2768, 1, 'New Order', 'New Order Placed : O01262', '2023-05-04 14:59:37', 0, 0, 1, 0, 0, 0),
(2769, 1, 'New Order', 'New Order Placed : O01263', '2023-05-04 15:01:26', 0, 0, 1, 0, 0, 0),
(2770, 1, 'New Order', 'New Order Placed : O01264', '2023-05-09 17:20:17', 0, 0, 1, 0, 0, 0),
(2771, 246, 'Accepted Order', 'Order Accepted : O01264', '2023-05-09 17:20:43', 0, 0, 0, 0, 0, 0),
(2772, 1, 'New Order', 'New Order Placed : O01265', '2023-05-09 17:23:03', 0, 0, 1, 0, 0, 0),
(2773, 246, 'Accepted Order', 'Order Accepted : O01265', '2023-05-09 17:23:30', 0, 0, 0, 0, 0, 0),
(2774, 246, 'Reach Order', 'Transporter reached depot Order : O01265', '2023-05-09 17:24:03', 0, 0, 0, 0, 0, 0),
(2775, 246, 'Reach Order', 'Transporter reached depot Order : O01264', '2023-05-09 17:24:41', 0, 0, 0, 0, 0, 0),
(2776, 246, 'Loaded Order', 'Transporter collected fuel Order : O01264', '2023-05-09 17:24:44', 0, 0, 0, 0, 0, 0),
(2777, 246, 'Completed Order', 'Order Completed : O01264', '2023-05-09 17:25:01', 0, 0, 0, 0, 0, 0),
(2778, 246, 'Loaded Order', 'Transporter collected fuel Order : O01265', '2023-05-09 17:25:12', 0, 0, 0, 0, 0, 0),
(2779, 246, 'Completed Order', 'Order Completed : O01265', '2023-05-09 17:25:39', 0, 0, 0, 0, 0, 0),
(2780, 68, 'eqwipetrol', 'test message eqwi petrol', '2023-05-10 10:19:32', 0, 0, 1, 1, 0, 0),
(2781, 68, 'eqwipetrol', 'eqwipetrol eqwipetrol eqwipetrol eqwipetrol', '2023-05-10 10:20:07', 0, 0, 1, 1, 0, 0),
(2783, 68, 'test messge', 'test message test message test message test message test message test message ', '2023-05-10 10:29:08', 0, 0, 1, 1, 0, 0),
(2784, 68, 'test', 'test eqwi test eqwi test eqwi', '2023-05-10 10:32:54', 0, 0, 1, 1, 0, 0),
(2786, 107, 'test', 'fdgdfgfh gfdgghfgh hfhfgh', '2023-05-10 10:39:44', 0, 0, 1, 1, 0, 0),
(2787, 68, 'gdrtre', 'fhfghrty tyrtytru ty ytr ', '2023-05-10 10:40:31', 0, 0, 1, 1, 0, 0),
(2788, 107, 'test', 'testtest v vtest test test test test', '2023-05-10 10:41:08', 0, 0, 1, 1, 0, 0),
(2790, 68, 'test', 'test test test test test test', '2023-05-10 10:53:01', 0, 0, 1, 1, 0, 0),
(2791, 68, 'tst', 'fgfdgf dfh h dhf  dfhgfh zh hfg', '2023-05-10 10:53:42', 0, 0, 1, 1, 0, 0),
(2792, 107, 'ret', 'erter b rete  ytryte  etyrt  tytr yrt ', '2023-05-10 10:54:59', 0, 0, 1, 1, 0, 0),
(2793, 107, 'eqwipetrol', 'eqwipetrol eqwipetrol eqwipetrol', '2023-05-10 10:56:32', 0, 0, 1, 1, 0, 0),
(2794, 107, 'test', 'test test test test test test test', '2023-05-10 10:59:43', 0, 0, 1, 1, 0, 0),
(2795, 1, 'New Order', 'New Order Placed : O01266', '2023-05-10 11:01:18', 0, 0, 1, 0, 0, 0),
(2796, 1, 'New Order', 'New Order Placed : O01267', '2023-05-10 11:05:52', 0, 0, 1, 0, 0, 0),
(2797, 107, 'eqipetrol', 'eqipetrol eqipetrol eqipetrol', '2023-05-10 11:08:24', 0, 0, 1, 1, 0, 0),
(2798, 19, 'New Order', 'New Order Placed : O01268', '2023-05-10 11:12:07', 0, 0, 0, 0, 0, 0),
(2799, 107, 'Accepted Order', 'Order Accepted : O01268', '2023-05-10 11:12:35', 0, 0, 0, 0, 0, 0),
(2800, 107, 'Accepted Order', 'Order Accepted : O01267', '2023-05-10 11:13:10', 0, 0, 0, 0, 0, 0),
(2801, 107, 'Reach Order', 'Transporter reached depot Order : O01268', '2023-05-10 11:13:17', 0, 0, 0, 0, 0, 0),
(2802, 107, 'Loaded Order', 'Transporter collected fuel Order : O01268', '2023-05-10 11:13:32', 0, 0, 0, 0, 0, 0),
(2803, 107, 'Completed Order', 'Order Completed : O01268', '2023-05-10 11:14:12', 0, 0, 0, 0, 0, 0),
(2804, 107, 'Reach Order', 'Transporter reached depot Order : O01267', '2023-05-10 11:16:17', 0, 0, 0, 0, 0, 0),
(2805, 107, 'Loaded Order', 'Transporter collected fuel Order : O01267', '2023-05-10 11:18:20', 0, 0, 0, 0, 0, 0),
(2806, 19, 'New Order', 'New Order Placed : O01269', '2023-05-10 11:28:53', 0, 0, 0, 0, 0, 0),
(2807, 1, 'New Order', 'New Order Placed : O01271', '2023-05-10 11:33:14', 0, 0, 1, 0, 0, 0),
(2808, 1, 'New Order', 'New Order Placed : O01272', '2023-05-10 11:34:39', 0, 0, 1, 0, 0, 0),
(2809, 1, 'New Order', 'New Order Placed : O01273', '2023-05-10 11:37:42', 0, 0, 1, 0, 0, 0),
(2810, 68, 'Accepted Order', 'Order Accepted : O01273', '2023-05-10 11:38:14', 0, 0, 0, 0, 0, 0),
(2811, 19, 'New Order', 'New Order Placed : O01274', '2023-05-10 11:40:23', 0, 0, 0, 0, 0, 0),
(2812, 68, 'Accepted Order', 'Order Accepted : O01274', '2023-05-10 11:40:50', 0, 0, 0, 0, 0, 0),
(2813, 19, 'New Order', 'New Order Placed : O01275', '2023-05-11 10:09:27', 0, 0, 0, 0, 0, 0),
(2814, 19, 'New Order', 'New Order Placed : O01277', '2023-05-11 10:12:44', 0, 0, 0, 0, 0, 0),
(2815, 68, 'Accepted Order', 'Order Accepted : O01277', '2023-05-11 10:13:47', 0, 0, 0, 0, 0, 0),
(2816, 68, 'Reach Order', 'Transporter reached depot Order : O01277', '2023-05-11 10:14:00', 0, 0, 0, 0, 0, 0),
(2817, 68, 'Loaded Order', 'Transporter collected fuel Order : O01277', '2023-05-11 10:14:07', 0, 0, 0, 0, 0, 0),
(2818, 68, 'Completed Order', 'Order Completed : O01277', '2023-05-11 10:15:23', 0, 0, 0, 0, 0, 0),
(2819, 19, 'New Order', 'New Order Placed : O01279', '2023-05-11 10:18:25', 0, 0, 0, 0, 0, 0),
(2820, 68, 'Accepted Order', 'Order Accepted : O01279', '2023-05-11 10:18:36', 0, 0, 0, 0, 0, 0),
(2821, 19, 'test', 'transporter transporter transporter', '2023-05-11 10:19:35', 0, 0, 1, 1, 0, 0),
(2822, 68, 'Accepted Order', 'Order Accepted : O01275', '2023-05-11 10:20:00', 0, 0, 0, 0, 0, 0),
(2823, 68, 'Reach Order', 'Transporter reached depot Order : O01279', '2023-05-11 10:20:16', 0, 0, 0, 0, 0, 0),
(2824, 68, 'Loaded Order', 'Transporter collected fuel Order : O01279', '2023-05-11 10:20:19', 0, 0, 0, 0, 0, 0),
(2826, 68, 'Completed Order', 'Order Completed : O01279', '2023-05-11 10:21:25', 0, 0, 0, 0, 0, 0),
(2827, 19, 'New Order', 'New Order Placed : O01280', '2023-05-11 10:22:20', 0, 0, 0, 0, 0, 0),
(2828, 19, 'New Order', 'New Order Placed : O01281', '2023-05-11 10:23:23', 0, 0, 0, 0, 0, 0),
(2829, 68, 'Accepted Order', 'Order Accepted : O01281', '2023-05-11 10:23:54', 0, 0, 0, 0, 0, 0),
(2830, 68, 'Reach Order', 'Transporter reached depot Order : O01281', '2023-05-11 10:24:01', 0, 0, 0, 0, 0, 0),
(2831, 68, 'Loaded Order', 'Transporter collected fuel Order : O01281', '2023-05-11 10:24:14', 0, 0, 0, 0, 0, 0),
(2832, 68, 'Completed Order', 'Order Completed : O01281', '2023-05-11 10:24:30', 0, 0, 0, 0, 0, 0),
(2833, 19, 'New Order', 'New Order Placed : O01283', '2023-05-11 10:41:51', 0, 0, 0, 0, 0, 0),
(2834, 19, 'New Order', 'New Order Placed : O01284', '2023-05-11 10:43:21', 0, 0, 0, 0, 0, 0),
(2835, 68, 'Accepted Order', 'Order Accepted : O01284', '2023-05-11 10:45:06', 0, 0, 0, 0, 0, 0),
(2836, 68, 'Reach Order', 'Transporter reached depot Order : O01284', '2023-05-11 10:45:20', 0, 0, 0, 0, 0, 0),
(2837, 68, 'Reach Order', 'Transporter reached depot Order : O01273', '2023-05-11 10:45:47', 0, 0, 0, 0, 0, 0),
(2838, 19, 'New Order', 'New Order Placed : O01286', '2023-05-11 10:48:23', 0, 0, 0, 0, 0, 0),
(2839, 19, 'New Order', 'New Order Placed : O01287', '2023-05-11 10:57:34', 0, 0, 0, 0, 0, 0),
(2840, 19, 'New Order', 'New Order Placed : O01291', '2023-05-11 11:03:01', 0, 0, 0, 0, 0, 0),
(2841, 19, 'New Order', 'New Order Placed : O01293', '2023-05-11 11:03:38', 0, 0, 0, 0, 0, 0),
(2842, 68, 'Accepted Order', 'Order Accepted : O01291', '2023-05-11 11:04:40', 0, 0, 0, 0, 0, 0),
(2843, 68, 'Reach Order', 'Transporter reached depot Order : O01291', '2023-05-11 11:05:52', 0, 0, 0, 0, 0, 0),
(2844, 68, 'Loaded Order', 'Transporter collected fuel Order : O01291', '2023-05-11 11:05:56', 0, 0, 0, 0, 0, 0),
(2845, 68, 'Completed Order', 'Order Completed : O01291', '2023-05-11 11:06:18', 0, 0, 0, 0, 0, 0),
(2846, 19, 'New Order', 'New Order Placed : O01294', '2023-05-11 11:12:41', 0, 0, 0, 0, 0, 0),
(2847, 68, 'Accepted Order', 'Order Accepted : O01294', '2023-05-11 11:12:48', 0, 0, 0, 0, 0, 0),
(2848, 68, 'Reach Order', 'Transporter reached depot Order : O01294', '2023-05-11 11:13:41', 0, 0, 0, 0, 0, 0),
(2849, 68, 'Loaded Order', 'Transporter collected fuel Order : O01294', '2023-05-11 11:13:45', 0, 0, 0, 0, 0, 0),
(2850, 68, 'Completed Order', 'Order Completed : O01294', '2023-05-11 11:14:31', 0, 0, 0, 0, 0, 0),
(2851, 68, 'Loaded Order', 'Transporter collected fuel Order : O01284', '2023-05-11 11:19:13', 0, 0, 0, 0, 0, 0),
(2852, 68, 'Completed Order', 'Order Completed : O01284', '2023-05-11 11:19:41', 0, 0, 0, 0, 0, 0),
(2853, 19, 'New Order', 'New Order Placed : O01295', '2023-05-11 11:58:57', 0, 0, 0, 0, 0, 0),
(2854, 68, 'Accepted Order', 'Order Accepted : O01295', '2023-05-11 12:00:05', 0, 0, 0, 0, 0, 0),
(2855, 68, 'Reach Order', 'Transporter reached depot Order : O01295', '2023-05-11 12:01:43', 0, 0, 0, 0, 0, 0),
(2856, 68, 'Loaded Order', 'Transporter collected fuel Order : O01295', '2023-05-11 12:02:01', 0, 0, 0, 0, 0, 0),
(2857, 68, 'Completed Order', 'Order Completed : O01295', '2023-05-11 12:05:16', 0, 0, 0, 0, 0, 0),
(2858, 19, 'New Order', 'New Order Placed : O01296', '2023-05-11 12:40:08', 0, 0, 0, 0, 0, 0),
(2859, 68, 'Accepted Order', 'Order Accepted : O01296', '2023-05-11 12:40:41', 0, 0, 0, 0, 0, 0),
(2860, 68, 'Reach Order', 'Transporter reached depot Order : O01296', '2023-05-11 12:41:42', 0, 0, 0, 0, 0, 0),
(2861, 68, 'Loaded Order', 'Transporter collected fuel Order : O01296', '2023-05-11 12:42:06', 0, 0, 0, 0, 0, 0),
(2862, 68, 'Completed Order', 'Order Completed : O01296', '2023-05-11 12:43:23', 0, 0, 0, 0, 0, 0),
(2863, 1, 'New Order', 'New Order Placed : O01297', '2023-05-15 10:26:52', 0, 0, 1, 0, 0, 0),
(2864, 1, 'New Order', 'New Order Placed : O01298', '2023-05-15 10:27:20', 0, 0, 1, 0, 0, 0),
(2865, 1, 'New Order', 'New Order Placed : O01299', '2023-05-15 10:28:21', 0, 0, 1, 0, 0, 0),
(2866, 68, 'Accepted Order', 'Order Accepted : O01299', '2023-05-15 10:43:37', 0, 0, 0, 0, 0, 0),
(2867, 68, 'Accepted Order', 'Order Accepted : O01298', '2023-05-15 10:43:41', 0, 0, 0, 0, 0, 0),
(2868, 68, 'Accepted Order', 'Order Accepted : O01297', '2023-05-15 10:43:44', 0, 0, 0, 0, 0, 0),
(2869, 68, 'Reach Order', 'Transporter reached depot Order : O01299', '2023-05-19 14:21:44', 0, 0, 0, 0, 0, 0),
(2870, 19, 'New Order', 'New Order Placed : O01300', '2023-05-19 15:20:57', 0, 0, 0, 0, 0, 0),
(2871, 68, 'Accepted Order', 'Order Accepted : O01300', '2023-05-19 15:21:06', 0, 0, 0, 0, 0, 0),
(2872, 19, 'New Order', 'New Order Placed : O01301', '2023-05-19 15:21:34', 0, 0, 0, 0, 0, 0),
(2873, 19, 'New Order', 'New Order Placed : O01302', '2023-05-19 15:22:56', 0, 0, 0, 0, 0, 0),
(2874, 68, 'Accepted Order', 'Order Accepted : O01302', '2023-05-19 15:30:23', 0, 0, 0, 0, 0, 0),
(2875, 68, 'Reach Order', 'Transporter reached depot Order : O01302', '2023-05-19 16:07:53', 0, 0, 0, 0, 0, 0),
(2876, 68, 'Loaded Order', 'Transporter collected fuel Order : O01302', '2023-05-19 16:08:02', 0, 0, 0, 0, 0, 0),
(2877, 68, 'Loaded Order', 'Transporter collected fuel Order : O01299', '2023-05-19 16:09:17', 0, 0, 0, 0, 0, 0),
(2878, 68, 'Reach Order', 'Transporter reached depot Order : O01300', '2023-05-19 16:16:48', 0, 0, 0, 0, 0, 0),
(2879, 68, 'Loaded Order', 'Transporter collected fuel Order : O01300', '2023-05-19 16:17:18', 0, 0, 0, 0, 0, 0),
(2880, 68, 'Reach Order', 'Transporter reached depot Order : O01298', '2023-05-19 16:17:55', 0, 0, 0, 0, 0, 0),
(2881, 68, 'Completed Order', 'Order Completed : O01299', '2023-05-19 16:19:57', 0, 0, 0, 0, 0, 0),
(2882, 68, 'Loaded Order', 'Transporter collected fuel Order : O01298', '2023-05-19 16:20:25', 0, 0, 0, 0, 0, 0),
(2883, 68, 'Completed Order', 'Order Completed : O01302', '2023-05-19 16:21:56', 0, 0, 0, 0, 0, 0),
(2884, 68, 'Completed Order', 'Order Completed : O01300', '2023-05-19 16:24:21', 0, 0, 0, 0, 0, 0),
(2885, 19, 'New Order', 'New Order Placed : O01303', '2023-05-19 16:24:51', 0, 0, 0, 0, 0, 0),
(2886, 68, 'Reach Order', 'Transporter reached depot Order : O01275', '2023-05-19 16:25:29', 0, 0, 0, 0, 0, 0),
(2887, 68, 'Loaded Order', 'Transporter collected fuel Order : O01275', '2023-05-19 16:25:33', 0, 0, 0, 0, 0, 0),
(2888, 68, 'Accepted Order', 'Order Accepted : O01303', '2023-05-19 16:28:12', 0, 0, 0, 0, 0, 0),
(2889, 19, 'New Order', 'New Order Placed : O01304', '2023-05-19 16:54:26', 0, 0, 0, 0, 0, 0),
(2890, 19, 'New Order', 'New Order Placed : O01305', '2023-05-19 16:54:49', 0, 0, 0, 0, 0, 0),
(2891, 19, 'New Order', 'New Order Placed : O01306', '2023-05-19 19:27:48', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `option_setting`
--

CREATE TABLE `option_setting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `option_type` varchar(100) NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_setting`
--

INSERT INTO `option_setting` (`id`, `title`, `value`, `option_type`, `updated_date`) VALUES
(1, 'site_logo', 'logo_7291666159191.png', 'site_setting', '2022-10-19 11:29:51'),
(2, 'currency_code', 'K', 'site_setting', '2023-02-14 10:30:22'),
(3, 'currency_symbol', 'KES', 'site_setting', '2023-02-14 10:30:22'),
(4, 'push_notification_key', 'AAAAZ32E99I:APA91bHIcLkaRbeHQqKy3p_CVIF88LdIsN7xja2MDHcSFVv3PF0TXXYuzRDElYk4UFQZk97cnCst3NgSQxEcw8kg29QWzdjjF-el0p0CsbpLgmLIX3YjXyhn96CpErc70t6-yHnUNHCC', 'site_setting', '2023-02-14 10:07:17'),
(5, 'about_body', '<p>hiii</p>', 'cms_pages', '2023-01-17 16:45:32'),
(6, 'terms_body', '<p>terms</p>', 'cms_pages', '2023-01-17 16:45:32'),
(7, 'privacy_policy', '<p>test privacy</p>', 'cms_pages', '2023-01-17 16:45:32'),
(8, 'contact_us_image', 'contact_us_5151666185334.png', 'contact_us', '2022-10-19 18:45:34'),
(9, 'contact_website_url', 'https://colormoon.in/eqwi_petrol/admin/setting/contact_us', 'contact_us', '2023-01-20 16:06:25'),
(10, 'contact_address', 'surat', 'contact_us', '2023-01-20 16:06:25'),
(11, 'contact_landline_no', '0261-123456', 'contact_us', '2023-01-20 16:06:25'),
(12, 'contact_email', 'connect@eqwi.com', 'contact_us', '2023-01-20 16:06:25'),
(13, 'contact_mobile_no', '9876543210', 'contact_us', '2023-01-20 16:06:25'),
(14, 'shipping_charge', '1', 'site_setting', '2023-02-14 10:30:22'),
(15, 'tax', '18', 'site_setting', '2023-02-14 10:30:22'),
(18, 'transporter_accept_time', '20', 'site_setting', '2023-02-14 10:30:22'),
(19, 'google_map_api_key', 'AIzaSyANKvvGW7sjJjBs_VR2iaV87RPXYi0auLg', 'site_setting', '2023-02-14 10:07:17'),
(20, 'site_address', 'Qwp2+3xr,00300,Nairobi City,Nairobi Country,Kenya', 'site_setting', '2023-02-14 10:30:22'),
(21, 'latitude', '-1.291020', 'site_setting', '2023-02-14 10:30:22'),
(22, 'longitude', '36.821390', 'site_setting', '2023-02-14 10:30:22'),
(23, 'nearby_delivery_radius', '50', 'site_setting', '2022-11-24 12:22:42'),
(24, 'nearby_pickup_radius', '10000', 'site_setting', '2023-02-14 10:30:22'),
(25, 'service_available_radius', '10000', 'site_setting', '2023-02-14 10:30:22'),
(26, 'site_contact_no', '9876543210', 'site_setting', '2023-02-14 10:30:22'),
(27, 'display_advertisement', 'Both', 'site_setting', '2023-02-14 10:30:22'),
(28, 'contact_description', 'test description', 'contact_us', '2023-01-20 16:06:25'),
(29, 'pg_client_key', 'ccceee1ddbd1422f84bf9f5bda4bebf93a4a26b6e40e489aa7c44e324967e24ba989f4e961884ead8a5e7c0203350c6a', 'payment_gateway_setting', '2022-12-02 16:04:55'),
(30, 'pg_checksum_key', '2ZAsrJIpUEE46GD0Td1csOmM9XVwKSNNC17iM', 'payment_gateway_setting', '2022-12-02 16:04:55'),
(31, 'test_pg_url', 'https://checkout-test.jambopay.co.ke', 'payment_gateway_setting', '2022-12-02 16:04:55'),
(32, 'live_pg_url', 'https://checkout.jambopay.com', 'payment_gateway_setting', '2022-12-02 16:04:55'),
(33, 'client_email', 'eqwipetrol@jambopay.com', 'payment_gateway_setting', '2022-12-02 16:04:55'),
(34, 'smtp_host', 'smtp-relay.sendinblue.com', 'email_setting', '2023-01-17 17:23:07'),
(35, 'smtp_user', 'annapurnavdevarakonda@gmail.com', 'email_setting', '2023-01-17 17:23:07'),
(36, 'smtp_password', 'gxBMrXWT8FZO7Ika', 'email_setting', '2023-01-17 17:23:07'),
(37, 'smtp_port', '587', 'email_setting', '2023-01-17 17:23:07'),
(38, 'android_app_version', '1', 'app_version', '2023-01-13 12:13:18'),
(39, 'ios_app_version', '1', 'app_version', '2023-01-13 12:13:18'),
(40, 'invoice_amount', '100000', 'site_setting', '2023-02-14 10:30:22'),
(41, 'sms_url', 'https://api.tililtech.com/sms/v3/sendsms', 'sms', '2023-01-17 16:45:15'),
(42, 'api_key', 'fKLO8d7uUCl1sG234W9Jp6IqoaBQjNP0vXtgkEyxznDRFwmVZSibcAYHMThe5r', 'sms', '2023-01-17 16:45:15'),
(43, 'sender_id', 'EQWIPETROL', 'sms', '2023-01-17 16:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `reject_reason`
--

CREATE TABLE `reject_reason` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reject_reason`
--

INSERT INTO `reject_reason` (`id`, `title`, `display_order`, `status`, `created_date`, `updated_date`) VALUES
(1, 'I am not available', 1, 1, '2022-11-11 13:10:27', '2022-11-11 13:10:40'),
(2, 'driver not available', 2, 1, '2023-01-17 17:29:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Admin', 1, '2022-07-20 17:44:42', '2022-07-20 17:46:42'),
(2, 'Developer', 1, '2022-07-20 17:46:54', '2022-10-18 17:28:35'),
(3, 'Software tester', 1, '2022-11-23 16:17:29', '2022-11-23 16:23:00'),
(4, 'tester', 1, '2023-01-08 20:36:46', NULL),
(5, 'Customer Care', 1, '2023-02-01 18:05:29', NULL),
(6, 'Nagendra', 0, '2023-02-02 11:01:06', '2023-05-19 19:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `station_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `station_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternate_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geo_fencing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`station_id`, `owner_id`, `station_name`, `contact_person`, `contact_number`, `alternate_number`, `country`, `state`, `city`, `pincode`, `landmark`, `address`, `latitude`, `longitude`, `geo_fencing_address`, `status`, `created_date`, `updated_date`) VALUES
(155, 204, 'PASSA Filling Station', 'David Mbucho', '0722991883', 'NA', 'Kenya', 'Nairobi', 'Nairobi', '999999', 'Kahawa West', '47 Gatundu', '-1.3451219281327378', '36.63462242187499', NULL, 1, '2023-03-31 14:24:22', NULL),
(156, 205, 'Lake oil', 'jenny', '0719585416', '', 'Kenya', 'Machakos County', 'nairobi', '', '', 'Kangundo Road,Kangundo Rd,', '-1.2802605', '37.109272', NULL, 1, '2023-03-31 15:48:52', NULL),
(157, 206, 'Dembwa', 'mwanja', '0707341617', '', 'Kenya', 'Nairobi County', 'Nairobi', '', '', 'QVMQ+MGX,QVMQ+MGX,', '-1.2155943', '36.8888624', NULL, 1, '2023-04-01 16:28:59', NULL),
(158, 209, 'dwaraka', 'divya', '9861977974', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', '5th Lane,Dwarka 5th Line,', '17.7284721', '83.3055308', NULL, 1, '2023-04-03 15:23:42', NULL),
(159, 107, 'satvik station', 'saik', '9632580774', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', '106,106,106', '17.7285366', '83.3055443', NULL, 1, '2023-04-03 17:06:39', NULL),
(160, 210, 'Gillian Energy', 'Jenniffer', '708549919', '', 'Kenya', 'Kiambu County', 'Ruiru', '', '', 'R266+3HQ,R266+3HQ,', '-1.1896973', '37.0112699', NULL, 1, '2023-04-03 17:23:19', NULL),
(161, 211, 'favav', 'cavva', '8484864949', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'P8H5+P6W,P8H5+P6W,', '17.7283584', '83.3059174', NULL, 1, '2023-04-03 18:20:14', NULL),
(162, 202, 'Kenya', 'Nelson', '0718913404', '', 'Kenya', 'Kiambu County', 'Ruaka', '', '', 'QQW9+74M,QQW9+74M,', '-1.2039592', '36.7681652', NULL, 1, '2023-04-03 23:02:47', NULL),
(163, 214, 'station', 'balu', '9014268684', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'MIG-I-82,MIG-I-82,', '17.6882981', '83.2348818', NULL, 1, '2023-04-05 17:45:29', NULL),
(164, 215, 'vsvsg', 'facagga', '5454549949', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Dwaraka Nagar,Dwarka Nagar,', '17.7285352', '83.3055062', NULL, 1, '2023-04-05 17:46:47', NULL),
(165, 68, 'chaitu station', 'chaitu', '9966002347', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', '46-5-42,46-5-42,', '17.728853994939612', '83.30004405230284', NULL, 1, '2023-04-06 17:17:25', NULL),
(166, 216, 'bByby', 'avagav', '5484848949', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Bharath Towers,405,', '17.7284093', '83.305708', NULL, 1, '2023-04-06 19:01:22', NULL),
(167, 217, 'vyyvsvvs', 'csvsvsb', '8484949496', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Bharath Towers,405,', '17.7284091', '83.3057061', NULL, 1, '2023-04-06 19:02:24', NULL),
(168, 218, 'ggg', 'ddd', '2525555858', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'P8H5+QP6,P8H5+QP6,', '17.72941733323478', '83.30926716327667', NULL, 1, '2023-04-10 16:36:56', NULL),
(169, 220, 'bynsbbsbsns', 'hsvsgsvsb', '848494949', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'P8H5+QP6,P8H5+QP6,', '17.7294167', '83.3092679', NULL, 1, '2023-04-10 16:46:02', NULL),
(170, 223, 'radhi station', 'radhi', '9635584158', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'P8Q2+FFQ,P8Q2+FFQ,', '17.738588257114532', '83.30134358257055', NULL, 1, '2023-04-10 17:16:25', NULL),
(171, 224, 'tsyun', 'tayree', '9874007748', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', '106,106,106', '17.7285305', '83.3055404', NULL, 1, '2023-04-10 17:17:49', NULL),
(172, 225, 'sat station', 'satya', '9580774125', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Unnamed Road,Unnamed Road,', '17.98383263143093', '83.33592496812344', NULL, 1, '2023-04-10 17:34:52', NULL),
(173, 226, 'tfzfzvhvh', 'gxgxgxgxfx', '8835556565', '', 'India', 'Odisha', 'Koraput', '', '', 'RP36+9W6,RP36+9W6,', '18.8035563', '82.7122888', NULL, 1, '2023-04-10 17:46:57', NULL),
(174, 227, 'chary station', 'chithra', '9852365478', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Sontyam to Bakkannapalem Road,Sontyam to Bakkannapalem Rd,', '17.809120444755667', '83.32374304533005', NULL, 1, '2023-04-17 17:49:22', NULL),
(175, 68, 'test station', 'chaitu', '9658077455', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', 'Q69J+8FJ,Q69J+8FJ,', '17.768850442082798', '83.23170136660337', NULL, 1, '2023-04-17 18:21:15', NULL),
(176, 243, 'dinesh station', 'dinesh', '1234567890', '', 'Kenya', 'Nairobi County', 'Nairobi', '', '', 'Kenya,Nairobi Central TEMPLE MUMBI HSE Starehe,', '-1.2467308241721295', '36.824423745274544', NULL, 1, '2023-04-27 11:27:55', NULL),
(177, 246, 'nayak station', 'nayak', '9652148874', '', 'India', 'Andhra Pradesh', 'Visakhapatnam', '', '', '49-46-4/6,49-46-4/6,', '17.73399742500416', '83.30088526010513', NULL, 1, '2023-05-09 17:14:21', NULL),
(178, 68, 'saikrish station', 'krish', '9658074125', '', 'India', 'Delhi', 'New Delhi', '', '', '394394394', '28.61048901351741', '77.11444057524204', NULL, 1, '2023-05-11 12:11:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `station_id` bigint(20) NOT NULL,
  `order_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `payment_ref_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_type` enum('Purchase','Wallet') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` enum('Wallet','Debit','Credit','Invoice') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_info` longtext COLLATE utf8mb4_unicode_ci,
  `is_invoice` tinyint(1) NOT NULL,
  `invoice_detail` text COLLATE utf8mb4_unicode_ci,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `user_id`, `order_id`, `station_id`, `order_no`, `currency`, `amount`, `payment_ref_id`, `payment_date`, `payment_status`, `status`, `payment_type`, `transaction_type`, `receipt_no`, `payment_info`, `is_invoice`, `invoice_detail`, `created_date`, `updated_date`) VALUES
(1330, 68, 1215, 150, 'O01215', 'KES', '11847.00', '23757495S31F', '2023-03-27 17:48:00', 'Paid', 1, 'Purchase', 'Debit', '2f5b535f-287a-48f8-a851-8d7f747557dc', '{\"TranID\":\"2f5b535f-287a-48f8-a851-8d7f747557dc\",\"OrderId\":\"1330\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":11847.0000,\"TranasctionFee\":947.7600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-03-27T15:18:09.817\",\"ClientIp\":\"49.204.227.126\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10149\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"63dfe6e41dc6476b8e78b98fc1d9d141\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-03-27 17:48:00', NULL),
(1333, 107, 1217, 88, 'O01217', 'KES', '16956.00', '23384895VQP9', '2023-03-28 14:20:18', 'Paid', 1, 'Purchase', 'Debit', 'b1e93814-62d6-48fb-a7e8-fb8394b21ecf', '{\"TranID\":\"b1e93814-62d6-48fb-a7e8-fb8394b21ecf\",\"OrderId\":\"1333\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":16956.0000,\"TranasctionFee\":1356.4800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-03-28T11:50:29.47\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10163\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"6dac0fe67f5848589f5544365ec81e93\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-03-28 14:20:18', NULL),
(1334, 202, 0, 0, 'W01334', 'KES', '10000.00', '236079707hbE', '2023-03-30 19:27:56', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-03-30 19:27:56', NULL),
(1335, 205, 1218, 156, 'O01218', 'KES', '400000.00', '239067882Dct', '2023-03-31 15:51:08', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-03-31 15:51:08', NULL),
(1336, 205, 1219, 156, 'O01219', 'KES', '400000.00', '23868647SrRH', '2023-03-31 15:51:29', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-03-31 15:51:29', NULL),
(1337, 205, 1220, 156, 'O01220', 'KES', '400000.00', '23720831rHah', '2023-03-31 15:57:46', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-03-31 15:57:46', NULL),
(1338, 208, 1221, 157, 'O01221', 'KES', '271411.00', '23696550oV3V', '2023-04-01 21:13:25', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-01 21:13:25', NULL),
(1339, 206, 1221, 157, 'O01221', 'KES', '271411.00', '23247991u6jE', '2023-04-01 21:24:31', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-01 21:24:31', NULL),
(1340, 206, 1223, 157, 'O01223', 'KES', '94411.00', '23142256qojp', '2023-04-02 11:52:27', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-02 11:52:27', NULL),
(1341, 206, 0, 0, 'W01341', 'KES', '10000.00', '23810754O0oI', '2023-04-02 11:53:09', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-02 11:53:09', NULL),
(1342, 206, 1221, 157, 'O01221', 'KES', '271411.00', '23545594JoOp', '2023-04-02 11:54:08', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-02 11:54:08', NULL),
(1343, 209, 1226, 158, 'O01226', 'KES', '15039.00', '23370188Sxli', '2023-04-03 15:35:18', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 15:35:18', NULL),
(1344, 209, 1227, 158, 'O01227', 'KES', '15039.00', '23532018fw4b', '2023-04-03 15:35:51', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 15:35:51', NULL),
(1345, 209, 1228, 158, 'O01228', 'KES', '15039.00', '239671713lYi', '2023-04-03 16:09:30', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 16:09:30', NULL),
(1346, 209, 1229, 158, 'O01229', 'KES', '15039.00', '23913863E1OB', '2023-04-03 16:09:56', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 16:09:56', NULL),
(1347, 209, 0, 0, 'W01347', 'KES', '558285.00', '23375324IhJN', '2023-04-03 16:49:58', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-03 16:49:58', NULL),
(1348, 209, 0, 0, 'W01348', 'KES', '2000.00', '23431188UGn2', '2023-04-03 16:50:12', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-03 16:50:12', NULL),
(1349, 209, 0, 0, 'W01349', 'KES', '200055.00', '23354338j0XC', '2023-04-03 16:50:30', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-03 16:50:30', NULL),
(1350, 107, 1230, 159, 'O01230', 'KES', '93545.00', '23172874I4oW', '2023-04-03 17:06:56', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 17:06:56', NULL),
(1351, 107, 1231, 159, 'O01231', 'KES', '45401.00', '23266791q7DM', '2023-04-03 17:08:08', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 17:08:08', NULL),
(1352, 205, 1232, 156, 'O01232', 'KES', '472032.00', '23614592EtMS', '2023-04-03 17:25:25', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-03 17:25:25', NULL),
(1353, 205, 1233, 156, 'O01233', 'KES', '472032.00', '23858609vikO', '2023-04-03 17:26:39', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-03 17:26:39', NULL),
(1354, 205, 1234, 156, 'O01234', 'KES', '9472.00', '23529476ktya', '2023-04-03 17:27:59', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 17:27:59', NULL),
(1355, 211, 1235, 158, 'O01235', 'KES', '800978555.00', '23504212qqK2', '2023-04-03 18:21:00', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-03 18:21:00', NULL),
(1356, 202, 0, 0, 'W01356', 'KES', '2000.00', '23364025bE7P', '2023-04-03 23:06:03', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-03 23:06:03', NULL),
(1357, 202, 1236, 162, 'O01236', 'KES', '18891.00', '23278988lNmz', '2023-04-03 23:18:10', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-03 23:18:10', NULL),
(1358, 213, 0, 0, 'W01358', 'KES', '500.00', '23305932RM8P', '2023-04-04 03:05:08', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-04 03:05:08', NULL),
(1359, 211, 1237, 158, 'O01237', 'KES', '800978555.00', '23313410w9B2', '2023-04-05 17:43:27', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-05 17:43:27', NULL),
(1360, 211, 1238, 161, 'O01238', 'KES', '14945.00', '23937200cM6J', '2023-04-05 17:44:58', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-05 17:44:58', NULL),
(1361, 68, 1239, 165, 'O01239', 'KES', '17022.00', '23885659NRWW', '2023-04-06 17:22:25', 'Pending', 1, 'Purchase', 'Debit', '', NULL, 0, NULL, '2023-04-06 17:22:25', NULL),
(1362, 226, 1240, 173, 'O01240', 'KES', '303598.00', '23577266paAi', '2023-04-10 21:34:59', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-10 21:34:59', NULL),
(1363, 226, 1241, 173, 'O01241', 'KES', '303598.00', '236620358uSt', '2023-04-10 21:35:54', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-10 21:35:54', NULL),
(1364, 68, 1242, 174, 'O01242', 'KES', '207526.00', '23545518aEth', '2023-04-17 18:06:02', 'Pending', 1, 'Purchase', 'Invoice', '', NULL, 0, NULL, '2023-04-17 18:06:02', NULL),
(1365, 68, 1243, 159, 'O01243', 'KES', '16833.00', '23568494enNR', '2023-04-20 14:35:10', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-04-20 14:35:10', NULL),
(1366, 68, 0, 0, 'W01366', 'KES', '500.00', '23401672YQrG', '2023-04-26 17:33:43', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-04-26 17:33:43', NULL),
(1367, 68, 1244, 165, 'O01244', 'KES', '719594.00', '23438239yY8N', '2023-04-26 17:40:37', 'Paid', 1, 'Purchase', 'Invoice', '', NULL, 1, '<html>\r\n<head><title>504 Gateway Time-out</title></head>\r\n<body>\r\n<center><h1>504 Gateway Time-out</h1></center>\r\n<hr><center>nginx</center>\r\n</body>\r\n</html>\r\n', '2023-04-26 17:40:37', '2023-04-27 12:43:58'),
(1381, 243, 1245, 176, 'O01245', 'KES', '113285.00', '23170692YJs2', '2023-04-27 12:12:17', 'Paid', 1, 'Purchase', 'Invoice', 'BILL644A194AAEBD8', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL644A194AAEBD8\"},\"code\":\"200\"}', '2023-04-27 12:12:17', '2023-04-27 12:13:56'),
(1382, 243, 1246, 176, 'O01246', 'KES', '141605.00', '23448945qt1o', '2023-04-27 12:15:54', 'Pending', 1, 'Purchase', 'Invoice', 'BILL644A1A2388DBC', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL644A1A2388DBC\"},\"code\":\"200\"}', '2023-04-27 12:15:54', NULL),
(1383, 68, 1247, 165, 'O01247', 'KES', '123250.00', '23251197cCDL', '2023-04-27 12:20:35', 'Pending', 1, 'Purchase', 'Invoice', 'BILL644A1B3C5A193', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL644A1B3C5A193\"},\"code\":\"200\"}', '2023-04-27 12:20:35', NULL),
(1384, 68, 1248, 165, 'O01248', 'KES', '29860.00', '23182325tXWm', '2023-04-27 12:26:58', 'Paid', 1, 'Purchase', 'Debit', 'bb032d38-e6d5-4d03-ac1f-4147d2171079', '{\"TranID\":\"bb032d38-e6d5-4d03-ac1f-4147d2171079\",\"OrderId\":\"1384\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":29860.0000,\"TranasctionFee\":2388.8000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T09:57:01.777\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10214\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"8fb4b8236f2c4edbae091059a150a5b0\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 12:26:58', NULL),
(1385, 243, 1249, 176, 'O01249', 'KES', '9445.00', '23909822FXZW', '2023-04-27 12:31:30', 'Paid', 1, 'Purchase', 'Debit', '0bb40e22-da82-422e-a591-87dfa107d8b9', '{\"TranID\":\"0bb40e22-da82-422e-a591-87dfa107d8b9\",\"OrderId\":\"1385\",\"MerchantId\":null,\"Payee\":\"dinesh.dev@colourmoon.com\",\"Amount\":9445.0000,\"TranasctionFee\":755.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T10:01:32.29\",\"ClientIp\":\"43.247.160.24\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10215\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"dinesh.dev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"0ff9d25f6f1b471e94cbd04fafc97089\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 12:31:30', NULL),
(1386, 68, 1250, 165, 'O01250', 'KES', '40339.00', '23508898eTJK', '2023-04-27 13:53:30', 'Paid', 1, 'Purchase', 'Debit', '67c63a60-7c34-4a12-827b-abe1e1e2f310', '{\"TranID\":\"67c63a60-7c34-4a12-827b-abe1e1e2f310\",\"OrderId\":\"1386\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":40339.0000,\"TranasctionFee\":3227.1200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:23:35.297\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10219\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"efbae2072b0d4b4da66f8d6960bcab8f\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 13:53:30', NULL),
(1387, 68, 0, 0, 'W01387', 'KES', '2500.00', '23466325QyLD', '2023-04-27 13:54:11', 'Paid', 1, 'Wallet', 'Credit', '879e037d-49e6-4d24-949e-7007a59a8c12', '{\"TranID\":\"879e037d-49e6-4d24-949e-7007a59a8c12\",\"OrderId\":\"1387\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":2500.0000,\"TranasctionFee\":200.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:24:11.753\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10220\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"24df6433adf6438ab1aa9e42f4db7137\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 13:54:11', NULL),
(1388, 68, 0, 0, 'W01388', 'KES', '15000.00', '23620390DUGP', '2023-04-27 13:58:28', 'Paid', 1, 'Wallet', 'Credit', 'e7153151-1541-4be2-915e-17cdf8d6557c', '{\"TranID\":\"e7153151-1541-4be2-915e-17cdf8d6557c\",\"OrderId\":\"1388\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":15000.0000,\"TranasctionFee\":1200.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:28:29.383\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10221\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"be1534ade8a54c99be6526f7d087003d\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 13:58:28', NULL),
(1389, 68, 1251, 165, 'O01251', 'KES', '39206.00', '23708880xrcZ', '2023-04-27 14:00:05', 'Paid', 1, 'Purchase', 'Debit', 'd67c5db4-3d4a-41b2-a5ae-bfffd4e89b73', '{\"TranID\":\"d67c5db4-3d4a-41b2-a5ae-bfffd4e89b73\",\"OrderId\":\"1389\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":39206.0000,\"TranasctionFee\":3136.4800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:30:07.44\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10222\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"430e3e14a7b5480a9be0a0996dc329e1\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 14:00:05', NULL),
(1390, 68, 1252, 165, 'O01252', 'KES', '39206.00', '23499929nRzx', '2023-04-27 14:00:54', 'Paid', 1, 'Purchase', 'Debit', '1493e89c-9683-4eb1-9d60-26fdc4dc6379', '{\"TranID\":\"1493e89c-9683-4eb1-9d60-26fdc4dc6379\",\"OrderId\":\"1390\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":39206.0000,\"TranasctionFee\":3136.4800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:30:55.887\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10223\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"1ee7022f03df42ebbd56a17f5166fd78\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 14:00:54', NULL),
(1391, 68, 1253, 165, 'O01253', 'KES', '74441.00', '23452164BqJM', '2023-04-27 14:01:42', 'Paid', 1, 'Purchase', 'Debit', '862944eb-d871-4dc6-a9e8-4f1937aeae4d', '{\"TranID\":\"862944eb-d871-4dc6-a9e8-4f1937aeae4d\",\"OrderId\":\"1391\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":74441.0000,\"TranasctionFee\":5955.2800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:31:44.19\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10224\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"04e6f1a396594dcc8368b235196518de\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 14:01:42', NULL),
(1392, 68, 1254, 165, 'O01254', 'KES', '74441.00', '234123280cjx', '2023-04-27 14:02:04', 'Paid', 1, 'Purchase', 'Debit', '79b37a29-8339-4e14-8dbd-ca44d6e4d5b7', '{\"TranID\":\"79b37a29-8339-4e14-8dbd-ca44d6e4d5b7\",\"OrderId\":\"1392\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":74441.0000,\"TranasctionFee\":5955.2800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T11:32:04.84\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10225\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"399ebf9914c44487bba657835ab50a95\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 14:02:04', NULL),
(1393, 68, 1255, 165, 'O01255', 'KES', '45401.00', '23248356hSI2', '2023-04-27 15:04:38', '', 1, 'Purchase', 'Debit', '', '{\"Message\":\"Authorization has been denied for this request.\"}', 0, NULL, '2023-04-27 15:04:38', NULL),
(1394, 68, 1256, 165, 'O01256', 'KES', '48386.00', '23364985YfcN', '2023-04-27 15:11:53', 'Paid', 1, 'Purchase', 'Debit', '7b21ec65-c435-4e28-aae6-a3c79019ff72', '{\"TranID\":\"7b21ec65-c435-4e28-aae6-a3c79019ff72\",\"OrderId\":\"1394\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":48386.0000,\"TranasctionFee\":3870.8800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T12:41:55.39\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10246\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"9dcb8063aa7e4c28939ac522ec779a8b\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 15:11:53', NULL),
(1395, 68, 0, 0, 'W01395', 'KES', '2500.00', '23632556PB0g', '2023-04-27 15:12:31', 'Paid', 1, 'Wallet', 'Credit', '8ced9717-935a-4559-bd7f-29eaeac78644', '{\"TranID\":\"8ced9717-935a-4559-bd7f-29eaeac78644\",\"OrderId\":\"1395\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":2500.0000,\"TranasctionFee\":200.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-27T12:42:31.707\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10247\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"310faeb03bce4c79a3e8e302aa9837e5\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-27 15:12:31', NULL),
(1396, 205, 1257, 156, 'O01257', 'KES', '9472.00', '23285544HMRC', '2023-04-28 14:36:18', 'Paid', 1, 'Purchase', 'Debit', '26ce8d69-7115-4e1e-b68e-bc2def17cea8', '{\"TranID\":\"26ce8d69-7115-4e1e-b68e-bc2def17cea8\",\"OrderId\":\"1396\",\"MerchantId\":null,\"Payee\":\"Jennifer.kamura@fanakamobile.com\",\"Amount\":9472.0000,\"TranasctionFee\":757.7600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-28T12:06:23.123\",\"ClientIp\":\"197.237.242.91\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10258\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"Jennifer.kamura@fanakamobile.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"9ffcf900aaf948fba012f169dfe77a32\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-28 14:36:18', NULL),
(1397, 205, 0, 0, 'W01397', 'KES', '500.00', '23699153UqMS', '2023-04-28 14:39:30', 'Paid', 1, 'Wallet', 'Credit', 'c84dd0ac-7e9c-4711-8deb-fec5c77e2f9f', '{\"TranID\":\"c84dd0ac-7e9c-4711-8deb-fec5c77e2f9f\",\"OrderId\":\"1397\",\"MerchantId\":null,\"Payee\":\"Jennifer.kamura@fanakamobile.com\",\"Amount\":500.0000,\"TranasctionFee\":40.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-04-28T12:09:33.517\",\"ClientIp\":\"197.237.242.91\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10259\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"Jennifer.kamura@fanakamobile.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"fbffe16757c940c18b1f6b2b3ec23f25\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-04-28 14:39:30', NULL),
(1398, 205, 1258, 156, 'O01258', 'KES', '1888032.00', '232193778g2f', '2023-05-01 13:53:45', 'Pending', 1, 'Purchase', 'Invoice', 'BILL644F77126A297', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL644F77126A297\"},\"code\":\"200\"}', '2023-05-01 13:53:45', NULL),
(1399, 205, 1259, 156, 'O01259', 'KES', '500.00', '23508939a3UX', '2023-05-03 15:16:26', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-03 15:16:26', NULL),
(1400, 205, 1259, 156, 'O01259', 'KES', '18412.00', '23603746Ub6n', '2023-05-03 15:16:26', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"a634d0e3-3273-4f6f-8a4a-aaf1a2565f95\",\"OrderId\":\"1400\",\"MerchantId\":null,\"Payee\":\"Jennifer.kamura@fanakamobile.com\",\"Amount\":18412.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-03T12:46:31.973\",\"ClientIp\":\"197.237.242.91\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10276\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"Jennifer.kamura@fanakamobile.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"d2633a3e57d14bcdb0b128018b7b3ff1\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-03 15:16:26', NULL),
(1401, 205, 0, 0, 'W01401', 'KES', '4000.00', '236453279caX', '2023-05-03 16:03:47', 'Pending', 1, 'Wallet', 'Credit', '', '{\"TranID\":\"ef46d816-944b-4067-9df5-2f75a837d44b\",\"OrderId\":\"1401\",\"MerchantId\":null,\"Payee\":\"Jennifer.kamura@fanakamobile.com\",\"Amount\":4000.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-03T13:33:58.283\",\"ClientIp\":\"197.237.242.91\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10277\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"Jennifer.kamura@fanakamobile.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"d0dcc87c3ffd4807a19bd7b5c8b98716\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-03 16:03:47', NULL),
(1402, 68, 0, 0, 'W01402', 'KES', '50000.00', '23626151kwKm', '2023-05-04 14:55:34', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-05-04 14:55:34', NULL),
(1403, 68, 0, 0, 'W01403', 'KES', '5000.00', '238587851bgi', '2023-05-04 14:56:00', 'Pending', 1, 'Wallet', 'Credit', '', '{\"TranID\":\"ccc6a324-c2a2-477e-868a-d27d8abbc6eb\",\"OrderId\":\"1403\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":5000.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-04T12:26:34.2\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10284\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"6dcc259350aa4a98a061aafb422e9af4\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 14:56:00', NULL),
(1404, 68, 1261, 165, 'O01261', 'KES', '44044.00', '23189785U2Du', '2023-05-04 14:56:35', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"a28b3c3a-4f6c-4fee-9422-76e83cfe3ee9\",\"OrderId\":\"1404\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":44044.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-04T12:26:38.283\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10286\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"767aedae699d4ef0a8e743070f74c830\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 14:56:35', NULL),
(1405, 68, 0, 0, 'W01405', 'KES', '1000.00', '23793352cO6I', '2023-05-04 14:57:13', 'Paid', 1, 'Wallet', 'Credit', '98b1b55c-b8bc-4265-b53d-8f0ecdf1fcea', '{\"TranID\":\"98b1b55c-b8bc-4265-b53d-8f0ecdf1fcea\",\"OrderId\":\"1405\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":1000.0000,\"TranasctionFee\":80.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-04T12:27:16.86\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10287\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"b16bcbb1baf940ffb82aaa789efc8270\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 14:57:13', NULL),
(1406, 68, 0, 0, 'W01406', 'KES', '50000.00', '23483566RnQ4', '2023-05-04 14:58:05', 'Pending', 1, 'Wallet', 'Credit', '', '{\"TranID\":\"5bec25f2-8bf3-4dd0-a47c-eb1723b653ed\",\"OrderId\":\"1406\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":50000.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-04T12:28:07.557\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10288\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"2ddf121b803147aa9df28b44a1b1a28e\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 14:58:05', NULL),
(1407, 68, 0, 0, 'W01407', 'KES', '50000.00', '23390701CGhF', '2023-05-04 14:58:44', 'Paid', 1, 'Wallet', 'Credit', '33d9fec9-8a7c-49ea-a377-afe7017238b9', '{\"TranID\":\"33d9fec9-8a7c-49ea-a377-afe7017238b9\",\"OrderId\":\"1407\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":50000.0000,\"TranasctionFee\":4000.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-04T12:28:46.737\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10289\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"6bfe8e93d878449681e5dcb4ac7a7e65\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 14:58:44', NULL),
(1408, 68, 1262, 165, 'O01262', 'KES', '44044.00', '23626160GuBN', '2023-05-04 14:59:37', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-04 14:59:37', NULL),
(1409, 68, 0, 0, 'W01409', 'KES', '20000.00', '2358208005aX', '2023-05-04 15:00:34', 'Paid', 1, 'Wallet', 'Credit', 'caa2668e-36a1-4b2c-a39c-eaaea22ed455', '{\"TranID\":\"caa2668e-36a1-4b2c-a39c-eaaea22ed455\",\"OrderId\":\"1409\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":20000.0000,\"TranasctionFee\":1600.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-04T12:30:37.917\",\"ClientIp\":\"223.187.23.217\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10290\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"f5643d43c42644c9b738b55a344b0e03\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-04 15:00:34', NULL),
(1410, 68, 1263, 165, 'O01263', 'KES', '17211.00', '23474809uXuW', '2023-05-04 15:01:26', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-04 15:01:26', NULL),
(1411, 246, 1264, 177, 'O01264', 'KES', '29860.00', '238543562MKT', '2023-05-09 17:19:49', 'Paid', 1, 'Purchase', 'Debit', '72bd1dcb-53c8-427c-933e-21be567c8d0b', '{\"TranID\":\"72bd1dcb-53c8-427c-933e-21be567c8d0b\",\"OrderId\":\"1411\",\"MerchantId\":null,\"Payee\":\"nayak@gmail.com\",\"Amount\":29860.0000,\"TranasctionFee\":2388.8000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-09T14:49:56.183\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10715\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"nayak@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"8b46ac58055640a38d345cf0db0e4116\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-09 17:19:49', NULL),
(1412, 246, 1265, 177, 'O01265', 'KES', '88039.00', '23208179V9yy', '2023-05-09 17:22:27', 'Paid', 1, 'Purchase', 'Debit', '323b076c-05da-49ad-8250-529f4817f325', '{\"TranID\":\"323b076c-05da-49ad-8250-529f4817f325\",\"OrderId\":\"1412\",\"MerchantId\":null,\"Payee\":\"nayak@gmail.com\",\"Amount\":88039.0000,\"TranasctionFee\":7043.1200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-09T14:52:32.63\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10716\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"nayak@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"64744ae61d1540e4bf762095dbe9c4cd\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-09 17:22:27', NULL),
(1413, 68, 1266, 165, 'O01266', 'KES', '12912.00', '23302619jvEA', '2023-05-10 11:01:18', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-10 11:01:18', NULL),
(1414, 68, 1266, 165, 'O01266', 'KES', '4299.00', '236286846DH6', '2023-05-10 11:01:18', 'Paid', 1, 'Purchase', 'Debit', 'f51199c4-8507-4681-bb9d-df1944c4b10a', '{\"TranID\":\"f51199c4-8507-4681-bb9d-df1944c4b10a\",\"OrderId\":\"1414\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":4299.0000,\"TranasctionFee\":343.9200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T08:31:28.537\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10730\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"3df646e4bd8f413ea344a5f30bc0b51c\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:01:18', NULL),
(1415, 107, 1267, 159, 'O01267', 'KES', '57012.00', '23720318RB0D', '2023-05-10 11:04:11', 'Paid', 1, 'Purchase', 'Debit', '5bc032ce-2875-4d10-a707-a7626e500937', '{\"TranID\":\"5bc032ce-2875-4d10-a707-a7626e500937\",\"OrderId\":\"1415\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":57012.0000,\"TranasctionFee\":4560.9600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T08:34:18.763\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10731\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"d26a61d0d5d1455abd64313aeb8b7139\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:04:11', NULL),
(1416, 107, 1268, 159, 'O01268', 'KES', '25707.00', '23346418AUOa', '2023-05-10 11:11:44', 'Paid', 1, 'Purchase', 'Debit', 'd78c99bf-02f4-44e6-b68d-7caa07411cc1', '{\"TranID\":\"d78c99bf-02f4-44e6-b68d-7caa07411cc1\",\"OrderId\":\"1416\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":25707.0000,\"TranasctionFee\":2056.5600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T08:41:49.8\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10733\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"2db4072284264e39b1c9cb2b41006bc7\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:11:44', NULL),
(1417, 107, 1269, 159, 'O01269', 'KES', '70912.00', '23382597TXqY', '2023-05-10 11:28:19', 'Paid', 1, 'Purchase', 'Debit', 'bd7d9235-dc96-4a32-b80e-7d13964d0d11', '{\"TranID\":\"bd7d9235-dc96-4a32-b80e-7d13964d0d11\",\"OrderId\":\"1417\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":70912.0000,\"TranasctionFee\":5672.9600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T08:58:24.78\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10735\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"60c8b83955314d8ca04dbabddf37747f\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:28:19', NULL),
(1418, 107, 1270, 159, 'O01270', 'KES', '44858.00', '23726030Nvdt', '2023-05-10 11:32:23', 'Cancelled', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"6000ca8a-150d-4119-9b26-7a2912350aae\",\"OrderId\":\"1418\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":44858.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Cancelled\",\"TranDate\":\"2023-05-10T09:02:29.287\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10736\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"5a95429371f342dfb85c94ae04d46189\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:32:23', NULL),
(1419, 107, 1271, 159, 'O01271', 'KES', '44858.00', '23479209D8x4', '2023-05-10 11:32:54', 'Paid', 1, 'Purchase', 'Debit', '61192cff-1068-4a7e-aff7-8bf2a3c779b4', '{\"TranID\":\"61192cff-1068-4a7e-aff7-8bf2a3c779b4\",\"OrderId\":\"1419\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":44858.0000,\"TranasctionFee\":3588.6400,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T09:02:59.733\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10737\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"bad01a9e174c460fb3e3e547a67ba0cc\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:32:54', NULL),
(1420, 107, 1272, 159, 'O01272', 'KES', '44858.00', '23360158caGi', '2023-05-10 11:34:14', 'Paid', 1, 'Purchase', 'Debit', 'c767958d-d159-467d-a07a-d3da02903b4f', '{\"TranID\":\"c767958d-d159-467d-a07a-d3da02903b4f\",\"OrderId\":\"1420\",\"MerchantId\":null,\"Payee\":\"swathi@gmail.com\",\"Amount\":44858.0000,\"TranasctionFee\":3588.6400,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T09:04:19.613\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10738\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"swathi@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"84a1942ae54744efb22044e3d70c3021\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:34:14', NULL),
(1421, 68, 1273, 165, 'O01273', 'KES', '48658.00', '232931781Rpy', '2023-05-10 11:37:15', 'Paid', 1, 'Purchase', 'Debit', '186dc5c5-53b3-4892-8926-8330ab4ecfbc', '{\"TranID\":\"186dc5c5-53b3-4892-8926-8330ab4ecfbc\",\"OrderId\":\"1421\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":48658.0000,\"TranasctionFee\":3892.6400,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T09:07:22.473\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10739\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"7ebc03d406d64b78b5ed124502d35364\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:37:15', NULL),
(1422, 68, 1274, 165, 'O01274', 'KES', '39430.00', '23826430Z4Hd', '2023-05-10 11:39:54', 'Paid', 1, 'Purchase', 'Debit', '6fb3af24-a195-4b70-85fb-a490fb57c395', '{\"TranID\":\"6fb3af24-a195-4b70-85fb-a490fb57c395\",\"OrderId\":\"1422\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":39430.0000,\"TranasctionFee\":3154.4000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-10T09:10:01.307\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10740\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"b8f266009da643bca2ecb5bf7d3b50e0\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-10 11:39:54', NULL),
(1423, 68, 1275, 165, 'O01275', 'KES', '20420.00', '23580644H87Q', '2023-05-11 10:09:01', 'Paid', 1, 'Purchase', 'Debit', '17702b96-463a-4d4d-a5ba-3f1d80ceab4b', '{\"TranID\":\"17702b96-463a-4d4d-a5ba-3f1d80ceab4b\",\"OrderId\":\"1423\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":20420.0000,\"TranasctionFee\":1633.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:39:10.083\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10819\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"4bf21cac510447d0aedeed114dc0f794\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:09:01', NULL),
(1424, 68, 1276, 165, 'O01276', 'KES', '37220.00', '23561594OZE0', '2023-05-11 10:11:16', 'Failed', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"487a427f-6cfa-4320-a91c-4216ab89d6db\",\"OrderId\":\"1424\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":37220.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Failed\",\"TranDate\":\"2023-05-11T07:41:23.047\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10822\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"df15cb3cc6064343893f1552b3c1106e\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:11:16', NULL),
(1425, 68, 1277, 165, 'O01277', 'KES', '37220.00', '23564037o0DZ', '2023-05-11 10:12:23', 'Paid', 1, 'Purchase', 'Debit', '406cb23b-2258-4460-a015-da6487a91301', '{\"TranID\":\"406cb23b-2258-4460-a015-da6487a91301\",\"OrderId\":\"1425\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":37220.0000,\"TranasctionFee\":2977.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:42:28.783\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10825\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"c8c86d0127654413aae740655c2d54ae\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:12:23', NULL),
(1426, 68, 1277, 165, 'O01277', 'KES', '37221.00', '23621523TePp', '2023-05-11 10:14:34', 'Paid', 1, 'Purchase', 'Debit', 'c5994768-5f65-4248-a832-904f5602942e', '{\"TranID\":\"c5994768-5f65-4248-a832-904f5602942e\",\"OrderId\":\"1426\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":37221.0000,\"TranasctionFee\":2977.6800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:44:40.647\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10826\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"94c7aefd102e4116b962400bfe4e2044\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:14:34', NULL),
(1427, 209, 1278, 158, 'O01278', 'KES', '12846057.00', '23473291DkPi', '2023-05-11 10:15:20', 'Pending', 1, 'Purchase', 'Invoice', 'BILL645C72E0EA02B', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL645C72E0EA02B\"},\"code\":\"200\"}', '2023-05-11 10:15:20', NULL),
(1428, 68, 1279, 165, 'O01279', 'KES', '37220.00', '23688276Wire', '2023-05-11 10:18:00', 'Paid', 1, 'Purchase', 'Debit', '4a26c745-b830-47c8-803d-78c5d6d04a92', '{\"TranID\":\"4a26c745-b830-47c8-803d-78c5d6d04a92\",\"OrderId\":\"1428\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":37220.0000,\"TranasctionFee\":2977.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:48:06.9\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10827\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"b5251ca4c502466db031604f60b30d63\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:18:00', NULL);
INSERT INTO `transaction` (`transaction_id`, `user_id`, `order_id`, `station_id`, `order_no`, `currency`, `amount`, `payment_ref_id`, `payment_date`, `payment_status`, `status`, `payment_type`, `transaction_type`, `receipt_no`, `payment_info`, `is_invoice`, `invoice_detail`, `created_date`, `updated_date`) VALUES
(1429, 68, 1279, 165, 'O01279', 'KES', '37221.00', '23218600cFqz', '2023-05-11 10:20:41', 'Paid', 1, 'Purchase', 'Debit', '38cf2a9d-30f7-47ef-8b1a-e8b66d1c8fd1', '{\"TranID\":\"38cf2a9d-30f7-47ef-8b1a-e8b66d1c8fd1\",\"OrderId\":\"1429\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":37221.0000,\"TranasctionFee\":2977.6800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:50:48.347\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10828\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"9111d5e1bb3a4522961f352d11b892c6\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:20:41', NULL),
(1430, 68, 1280, 165, 'O01280', 'KES', '45401.00', '23493083IXEM', '2023-05-11 10:21:58', 'Paid', 1, 'Purchase', 'Debit', 'b4faad25-439f-407f-af56-88130ba33e48', '{\"TranID\":\"b4faad25-439f-407f-af56-88130ba33e48\",\"OrderId\":\"1430\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":45401.0000,\"TranasctionFee\":3632.0800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:52:05.3\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10830\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"22da4c09dae04505908b91e5014aa0d7\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:21:58', NULL),
(1431, 68, 1281, 165, 'O01281', 'KES', '45401.00', '23324346WNqE', '2023-05-11 10:22:56', 'Paid', 1, 'Purchase', 'Debit', 'd219181d-1991-499a-8495-9cfdb405df5f', '{\"TranID\":\"d219181d-1991-499a-8495-9cfdb405df5f\",\"OrderId\":\"1431\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":45401.0000,\"TranasctionFee\":3632.0800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T07:53:03.377\",\"ClientIp\":\"115.246.192.21\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10831\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"fe3ac8301a834bcfb261f99f2cbec094\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:22:56', NULL),
(1432, 68, 1282, 165, 'O01282', 'KES', '245942.00', '23252447DV9m', '2023-05-11 10:24:57', 'Pending', 1, 'Purchase', 'Invoice', 'BILL645C7521EC5FC', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL645C7521EC5FC\"},\"code\":\"200\"}', '2023-05-11 10:24:57', NULL),
(1433, 68, 1283, 165, 'O01283', 'KES', '17211.00', '23794306OQyD', '2023-05-11 10:41:25', 'Paid', 1, 'Purchase', 'Debit', 'd58108dc-ee94-48e0-8664-b961fe78b8ec', '{\"TranID\":\"d58108dc-ee94-48e0-8664-b961fe78b8ec\",\"OrderId\":\"1433\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":17211.0000,\"TranasctionFee\":1376.8800,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:11:32.99\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10837\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"af7abdaf323d498fa4815873e4b062e4\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:41:25', NULL),
(1434, 68, 1284, 165, 'O01284', 'KES', '63585.00', '23780116B9PG', '2023-05-11 10:43:00', 'Paid', 1, 'Purchase', 'Debit', '940e6001-a68a-4317-adaa-f0b41e4914a9', '{\"TranID\":\"940e6001-a68a-4317-adaa-f0b41e4914a9\",\"OrderId\":\"1434\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":63585.0000,\"TranasctionFee\":5086.8000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:13:06.163\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10838\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"b612a124e4b3486db1ec7855f7702363\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:43:00', NULL),
(1435, 209, 1285, 158, 'O01285', 'KES', '94405411.00', '23878500qpsy', '2023-05-11 10:44:06', 'Pending', 1, 'Purchase', 'Invoice', 'BILL645C799EDE69A', NULL, 1, '{\"response\":{\"billRefNo\":\"BILL645C799EDE69A\"},\"code\":\"200\"}', '2023-05-11 10:44:06', NULL),
(1436, 68, 0, 0, 'W01436', 'KES', '99999.00', '237557848xsR', '2023-05-11 10:46:50', 'Paid', 1, 'Wallet', 'Credit', '8bcdba98-c460-45a2-b9f6-f1655c9895b2', '{\"TranID\":\"8bcdba98-c460-45a2-b9f6-f1655c9895b2\",\"OrderId\":\"1436\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":99999.0000,\"TranasctionFee\":7999.9200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:16:56.103\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10839\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"9d8ba754eb0f4d3892b595797b63def2\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:46:50', NULL),
(1437, 68, 0, 0, 'W01437', 'KES', '10000.00', '23565375Gs8u', '2023-05-11 10:47:22', 'Paid', 1, 'Wallet', 'Credit', '72416ae6-1576-4058-a01d-8a3596fe1dc0', '{\"TranID\":\"72416ae6-1576-4058-a01d-8a3596fe1dc0\",\"OrderId\":\"1437\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":10000.0000,\"TranasctionFee\":800.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:17:28.333\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10840\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"1d927bcc069d4c1bad895a09edda7fb6\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:47:22', NULL),
(1438, 68, 1286, 165, 'O01286', 'KES', '16927.00', '23626932nlXm', '2023-05-11 10:48:04', 'Paid', 1, 'Purchase', 'Debit', '1c725bcc-e0bb-4362-8152-f392ed83b8c7', '{\"TranID\":\"1c725bcc-e0bb-4362-8152-f392ed83b8c7\",\"OrderId\":\"1438\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":16927.0000,\"TranasctionFee\":1354.1600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:18:10.523\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10841\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"d721dfe2ba1d482d8d39168287aa49a2\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 10:48:04', NULL),
(1439, 68, 1287, 165, 'O01287', 'KES', '38887.00', '23199486cwWp', '2023-05-11 10:57:34', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-11 10:57:34', NULL),
(1440, 68, 1289, 165, 'O01289', 'KES', '14945.00', '23253773DG4H', '2023-05-11 11:01:37', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"e3494134-7047-42d4-b314-8a6e32358494\",\"OrderId\":\"1440\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":14945.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-11T08:31:47.197\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10842\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"33a3a39747e84d8fb0a8ff315424efe7\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:01:37', NULL),
(1441, 68, 1290, 165, 'O01290', 'KES', '14945.00', '23891648nsvw', '2023-05-11 11:01:38', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"09ce6e23-88b9-4ff5-a6b7-490f4d14a2d2\",\"OrderId\":\"1441\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":14945.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-11T08:32:03.43\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10844\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"9adbd7d9ed3e4bb786810a3c4dbb97f8\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:01:38', NULL),
(1442, 68, 1288, 165, 'O01288', 'KES', '14945.00', '23237665cN9o', '2023-05-11 11:01:39', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"30b7b36e-ae84-46d0-9c7f-4e9f19af1f16\",\"OrderId\":\"1442\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":14945.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-11T08:31:54.717\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10843\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"097fecd72bbc4c17af254514876e24bb\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:01:39', NULL),
(1443, 68, 1291, 165, 'O01291', 'KES', '14945.00', '23801483ASas', '2023-05-11 11:02:24', 'Paid', 1, 'Purchase', 'Debit', '7c8cbff2-8639-4c24-b4a7-7f36389cb08d', '{\"TranID\":\"7c8cbff2-8639-4c24-b4a7-7f36389cb08d\",\"OrderId\":\"1443\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":14945.0000,\"TranasctionFee\":1195.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:32:33.293\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10846\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"730d3890ddd84def860000e9beac9b02\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:02:24', NULL),
(1444, 68, 1292, 165, 'O01292', 'KES', '14945.00', '23338829GtNp', '2023-05-11 11:02:24', 'Pending', 1, 'Purchase', 'Debit', '', '{\"TranID\":\"a7329e8b-668a-499a-bad1-f5a6d6e63f86\",\"OrderId\":\"1444\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":14945.0000,\"TranasctionFee\":0.0,\"ShippingCharge\":0.0000,\"Status\":\"Pending\",\"TranDate\":\"2023-05-11T08:32:32.573\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10845\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":null,\"LipaLink\":\"2578a11962e34aeaa0af6a9744d32be5\",\"PaymentChannel\":null,\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:02:24', NULL),
(1445, 209, 1293, 158, 'O01293', 'KES', '14945.00', '2373940017NJ', '2023-05-11 11:03:05', 'Paid', 1, 'Purchase', 'Debit', 'fec9ebcc-3a57-41e5-9055-51c9199c6265', '{\"TranID\":\"fec9ebcc-3a57-41e5-9055-51c9199c6265\",\"OrderId\":\"1445\",\"MerchantId\":null,\"Payee\":\"aparnaawain001@gmail.com\",\"Amount\":14945.0000,\"TranasctionFee\":1195.6000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:33:13.763\",\"ClientIp\":\"157.48.198.172\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10847\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"aparnaawain001@gmail.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"e20990837d2442e994ee7fe46a761027\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:03:05', NULL),
(1446, 68, 1294, 165, 'O01294', 'KES', '64210.00', '23934121SLft', '2023-05-11 11:12:41', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-11 11:12:41', NULL),
(1447, 68, 0, 0, 'W01447', 'KES', '120000.00', '235899248kRU', '2023-05-11 11:22:25', 'Paid', 1, 'Wallet', 'Credit', '9858c3e8-8445-4a92-9487-fb2f210d6f30', '{\"TranID\":\"9858c3e8-8445-4a92-9487-fb2f210d6f30\",\"OrderId\":\"1447\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":120000.0000,\"TranasctionFee\":9600.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:52:34.843\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10848\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"6e5b02ac9ab343289eb9769426d8bdab\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:22:25', NULL),
(1448, 68, 0, 0, 'W01448', 'KES', '258000.00', '23459220CZRb', '2023-05-11 11:27:50', 'Paid', 1, 'Wallet', 'Credit', 'fbb3f4ef-081c-4603-8531-62794b0bd7b6', '{\"TranID\":\"fbb3f4ef-081c-4603-8531-62794b0bd7b6\",\"OrderId\":\"1448\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":258000.0000,\"TranasctionFee\":20640.0000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:57:58.71\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10849\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"88e91dc5c06743d8b5732471486e2366\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:27:50', NULL),
(1449, 68, 0, 0, 'W01449', 'KES', '548000.00', '23979565XJEx', '2023-05-11 11:28:25', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-05-11 11:28:25', NULL),
(1450, 68, 0, 0, 'W01450', 'KES', '545877.00', '23140317L01p', '2023-05-11 11:28:42', 'Pending', 1, 'Wallet', 'Credit', '', NULL, 0, NULL, '2023-05-11 11:28:42', NULL),
(1451, 68, 0, 0, 'W01451', 'KES', '214544.00', '23720868pAlN', '2023-05-11 11:29:02', 'Paid', 1, 'Wallet', 'Credit', '46a82b10-a09a-4d1a-acde-4620bbc7a09d', '{\"TranID\":\"46a82b10-a09a-4d1a-acde-4620bbc7a09d\",\"OrderId\":\"1451\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":214544.0000,\"TranasctionFee\":17163.5200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T08:59:11.327\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10850\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"f861682bc8724a1b8af267cb6657a506\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:29:02', NULL),
(1452, 68, 1295, 165, 'O01295', 'KES', '83774.00', '23149705FyKd', '2023-05-11 11:58:33', 'Paid', 1, 'Purchase', 'Debit', '665d0677-bbd0-49dc-a33d-de4645004b5e', '{\"TranID\":\"665d0677-bbd0-49dc-a33d-de4645004b5e\",\"OrderId\":\"1452\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":83774.0000,\"TranasctionFee\":6701.9200,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T09:28:40.5\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10851\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"fa8bab9291a346bc8f71509229839ac2\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 11:58:33', NULL),
(1453, 68, 1296, 165, 'O01296', 'KES', '85415.00', '23945821Vqv1', '2023-05-11 12:39:43', 'Paid', 1, 'Purchase', 'Debit', 'ecdd3aba-d3be-4b9a-b9a0-60779ce59ecb', '{\"TranID\":\"ecdd3aba-d3be-4b9a-b9a0-60779ce59ecb\",\"OrderId\":\"1453\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":85415.0000,\"TranasctionFee\":6833.2000,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-11T10:09:51.33\",\"ClientIp\":\"202.53.69.162\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10852\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"16821811eccc45589daf0f642e0efe79\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-11 12:39:43', NULL),
(1454, 68, 1297, 165, 'O01297', 'KES', '29483.00', '23421150XQvn', '2023-05-15 10:26:52', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-15 10:26:52', NULL),
(1455, 68, 1298, 165, 'O01298', 'KES', '80990.00', '23408399scOZ', '2023-05-15 10:27:20', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-15 10:27:20', NULL),
(1456, 68, 1299, 165, 'O01299', 'KES', '95612.00', '23653480hHJx', '2023-05-15 10:27:54', 'Paid', 1, 'Purchase', 'Debit', 'f5dc74b5-1f7d-455e-8892-7730b72a72e0', '{\"TranID\":\"f5dc74b5-1f7d-455e-8892-7730b72a72e0\",\"OrderId\":\"1456\",\"MerchantId\":null,\"Payee\":\"chaitanya.appdev@colourmoon.com\",\"Amount\":95612.0000,\"TranasctionFee\":7648.9600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-15T07:58:01.273\",\"ClientIp\":\"202.53.69.164\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-10916\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"chaitanya.appdev@colourmoon.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"VISA\",\"LipaLink\":\"cdebcf49a63b44b5b1ccdaa8a728a210\",\"PaymentChannel\":\"VISA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-15 10:27:54', NULL),
(1457, 68, 1300, 165, 'O01300', 'KES', '17211.00', '23730550BftL', '2023-05-19 15:20:57', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 15:20:57', NULL),
(1458, 68, 1301, 165, 'O01301', 'KES', '83357.00', '233352345XKQ', '2023-05-19 15:21:34', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 15:21:34', NULL),
(1459, 68, 1302, 165, 'O01302', 'KES', '46774.00', '23713266owde', '2023-05-19 15:22:56', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 15:22:56', NULL),
(1460, 68, 1303, 165, 'O01303', 'KES', '50215.00', '23131018I6Yg', '2023-05-19 16:24:51', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 16:24:51', NULL),
(1461, 68, 1304, 165, 'O01304', 'KES', '52292.00', '23545077s2y9', '2023-05-19 16:54:26', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 16:54:26', NULL),
(1462, 68, 1305, 165, 'O01305', 'KES', '63585.00', '231216820HQp', '2023-05-19 16:54:49', 'Paid', 1, 'Purchase', 'Wallet', '', NULL, 0, NULL, '2023-05-19 16:54:49', NULL),
(1463, 205, 1306, 156, 'O01306', 'KES', '9472.00', '23385507yOT0', '2023-05-19 19:27:16', 'Paid', 1, 'Purchase', 'Debit', '3a40dd37-81a3-4d61-b421-4e94ac9e4c07', '{\"TranID\":\"3a40dd37-81a3-4d61-b421-4e94ac9e4c07\",\"OrderId\":\"1463\",\"MerchantId\":null,\"Payee\":\"Jennifer.kamura@fanakamobile.com\",\"Amount\":9472.0000,\"TranasctionFee\":757.7600,\"ShippingCharge\":0.0000,\"Status\":\"Completed\",\"TranDate\":\"2023-05-19T16:57:25.81\",\"ClientIp\":\"102.216.154.4\",\"Currency\":\"KES\",\"SettlementStatus\":null,\"Description\":\"Purchase\",\"Rrn\":\"JPC-11001\",\"DateCompleted\":\"0001-01-01T00:00:00\",\"MerchantEmail\":\"eqwipetrol@jambopay.com\",\"CustomerEmail\":\"Jennifer.kamura@fanakamobile.com\",\"CustomerPhone\":null,\"CallBackUrl\":\"https://colormoon.in/eqwi_petrol/payment/success\",\"CancelledUrl\":\"https://colormoon.in/eqwi_petrol/payment/cancel\",\"Channel\":\"MPESA\",\"LipaLink\":\"43c25da191604057ba6064da61d21eb9\",\"PaymentChannel\":\"MPESA\",\"TransactionType\":\"Credit\"}', 0, NULL, '2023-05-19 19:27:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `transporter_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measurement` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(11,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transporter_not_available`
--

CREATE TABLE `transporter_not_available` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `set_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transporter_not_available`
--

INSERT INTO `transporter_not_available` (`id`, `user_id`, `set_date`, `status`, `created_date`, `updated_date`) VALUES
(44, 19, '2023-01-19', 1, '2023-01-12 12:45:51', NULL),
(53, 6, '2023-01-21', 1, '2023-01-12 16:13:35', NULL),
(59, 19, '2023-01-15', 1, '2023-01-12 18:42:11', NULL),
(62, 133, '2023-01-14', 1, '2023-01-13 13:03:17', NULL),
(67, 85, '2023-01-21', 1, '2023-01-14 11:40:36', NULL),
(69, 85, '2023-01-26', 1, '2023-01-14 11:46:23', NULL),
(70, 84, '2023-01-27', 1, '2023-01-14 12:17:15', NULL),
(71, 84, '2023-01-28', 1, '2023-01-14 12:17:15', NULL),
(73, 133, '2023-01-18', 1, '2023-01-17 12:45:23', NULL),
(99, 160, '2023-01-26', 1, '2023-01-20 11:57:24', NULL),
(100, 160, '2023-01-27', 1, '2023-01-20 11:57:24', NULL),
(133, 85, '2023-01-25', 1, '2023-01-25 15:16:02', NULL),
(145, 6, '2023-01-28', 1, '2023-01-27 20:06:24', NULL),
(146, 6, '2023-01-29', 1, '2023-01-27 20:06:40', NULL),
(165, 19, '2023-02-10', 1, '2023-02-10 18:01:05', NULL),
(167, 19, '2023-02-15', 1, '2023-02-10 18:09:54', NULL),
(173, 19, '2023-02-24', 1, '2023-02-17 18:35:43', NULL),
(174, 19, '2023-02-25', 1, '2023-02-17 18:35:43', NULL),
(178, 85, '2023-03-28', 1, '2023-03-28 16:07:11', NULL),
(179, 19, '2023-04-08', 1, '2023-04-07 16:57:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `login_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_code` int(11) DEFAULT NULL,
  `mobile_verified` tinyint(1) NOT NULL DEFAULT '0',
  `station_id` int(11) NOT NULL,
  `user_type` enum('Owner','Manager','Attendant','Transporter') COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geo_fencing_address` text COLLATE utf8mb4_unicode_ci,
  `pincode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `profile_pic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forgot_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transporter_available` tinyint(1) DEFAULT NULL,
  `employment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `payment_option` tinyint(1) NOT NULL DEFAULT '0',
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_balance` decimal(11,2) DEFAULT '0.00',
  `google_auth_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_auth_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_provider` enum('None','Google','Facebook') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `owner_id`, `login_id`, `name`, `email`, `password`, `mobile`, `address`, `otp_code`, `mobile_verified`, `station_id`, `user_type`, `latitude`, `longitude`, `geo_fencing_address`, `pincode`, `status`, `profile_pic`, `user_token`, `forgot_token`, `device_id`, `platform_type`, `transporter_available`, `employment_type`, `vehicle_id`, `payment_option`, `currency`, `wallet_balance`, `google_auth_id`, `facebook_auth_id`, `auth_provider`, `created_date`, `updated_date`) VALUES
(1, 3, 'dinesh12', 'dinesh', 'din@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567111', 'dwarakanagar,visakhapatnam', 0, 1, 2, 'Manager', '17.876767', '72.6565765', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-10-19 13:31:22', '2022-11-10 15:44:13'),
(4, 3, 'test12', 'test dinesh', 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567891', 'test address', NULL, 1, 2, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, 'l5ZjxclibORdGDSdZoaa', NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-10-20 13:11:04', '2022-11-02 15:03:51'),
(6, 0, 'transporter12', 'transporter test', 'dinesh@transporter.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567890', 'Transporter address test', 6380, 1, 0, 'Transporter', '21.1293401', '73.0325951', NULL, NULL, 1, 'pic_4871667822923.jpg', 'i55nMXMlejDHhs9SHnYH', NULL, 'eMXvrzl9S7KfJ78VV3kF6Q:APA91bHK14S0A1VB_LYF_7TXcv4dDDICNz28GzwCDnBinwVP_8SDZnh6HLlL_BPzJ31vKNLsEMIV5UhC_7kPcujEICTHdx1-RI5GPWEZ9GTvYLjvKNluR3mIZilTCpGkq08AQK7MPC5O', 'android', 1, 'Own Employee', 1, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-10-20 13:28:28', '2023-01-27 18:59:32'),
(19, 0, 'krishna', 'krishna', 'krishna@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9090909090', 'seethampeta,visakapatnam', 4774, 1, 0, 'Transporter', '17.7284868', '83.3055684', NULL, NULL, 1, 'pic_2201671430562.jpg', 'PKXatzbGSpzRJCG7izx5', NULL, 'null', 'ios', 1, 'Freelancer', 5, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-10-28 14:14:29', '2023-05-19 16:28:00'),
(42, 14, 'w245y', 'chaitu', 'team9@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9635580877', 'fhhvvgg', NULL, 1, 52, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-04 11:09:26', '2022-11-04 14:57:15'),
(50, 14, 'sfccc', 'chsfc', 'fgb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9325874144', 'dcvcx', NULL, 1, 52, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-04 14:02:17', '2022-11-10 16:16:58'),
(54, 53, 'manikanata', 'ManikantA', 'mani@mandk.com', '25f9e794323b453885f5181f1b624d0b', '9383828309792', 'kndkkwk', NULL, 1, 55, 'Manager', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-04 16:42:05', NULL),
(55, 53, 'vasujatteh', 'Attensder Vasu', 'vasu@jdjdj.com', '25a41cec631264f04815eda23dc6edd9', '9380820902171', 'kndksjkds', NULL, 1, 55, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-04 16:43:19', NULL),
(60, 14, 'rahul123', 'Rahul', 'rahu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9633696339', 'Madhurwada visakapatnam', NULL, 1, 63, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-14 12:52:18', NULL),
(68, 0, 'chaitu', 'chaitu', 'chaitanya.appdev@colourmoon.com', '63c4fd91cf4121bc58456784e41de4d1', '9966002347', '25/63,Allipuram,Visakhapatnam,India,530004', 5901, 1, 0, 'Owner', '17.717867905572472', '83.29382870346308', NULL, NULL, 1, 'pic_1541683526386.jpg', 'CH8ABhGbTx4DUc8U4eao', 't7xxgTjWPNfwt0gVOInC', 'drUsykcHTeyU0HatUlByew:APA91bEqooBFr3uhBjrg15g71TtqWn9csjxOOgoMS6gMTHzcn1TxEFt3ulkvGc_tNjAOD4FrBZBcb7C_Yhq4veKWkUc3SCvrKniLsnEB78jmKolsMAWOdgPxmZhqmIVZ-W1phkE6gGCZ', 'android', NULL, NULL, 0, 1, 'KES', '175539.00', NULL, NULL, 'None', '2022-11-21 14:11:08', '2023-05-11 10:21:48'),
(73, 70, 'Felix Njinu', 'Felix Njinu', 'njinufelix@gmail.com', '0c0f5f8018d383063c043eebfe98ce4e', '0724347822', '1838-0200 NAIROBI', NULL, 1, 70, 'Manager', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-23 16:52:35', NULL),
(74, 70, 'Anne', 'Anne', 'anne@gmail.com', '2ec5ada52c3a38ed0febfc910d7c6b11', '0724347822', '1838-0200 NAIROBI', NULL, 1, 70, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-23 16:54:08', '2022-11-23 16:56:17'),
(75, 0, 'JP Transporters', 'JP Transporters', 'jp@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0711223456', 'JP HOUSE', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Own Employee', 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-23 17:02:33', '2023-01-27 18:52:03'),
(79, 0, 'kishan', 'kishan', 'kishan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '7894561470', 'surat address', NULL, 1, 0, 'Transporter', '17.728609', '83.305107', NULL, NULL, 1, NULL, '530cdKtLvmFkakuoWeAB', NULL, '', 'android', 1, 'Own Employee', 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-28 16:01:20', '2023-01-27 18:51:54'),
(81, 0, 'sandya', 'sandhya', 'sandya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9633699639', '57-8-27A/B,Kancharapalem,Visakhapatnam,India,530008', 0, 1, 0, 'Owner', '17.733915353548944', '83.27246256172657', NULL, NULL, 1, 'pic_6391670232050.jpg', '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '-5800.00', NULL, NULL, 'None', '2022-11-28 17:31:38', '2022-12-05 14:50:52'),
(82, 81, 'chaitum', 'chaitu', 'chaitum@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632589638', 'thatichetlapalem visakapatnam', 0, 1, 85, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-28 17:36:13', '2022-12-02 18:59:19'),
(85, 0, 'manoj', 'manoj', 'manoj@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567899', 'akkayapalem, visakapatnam', NULL, 1, 0, 'Transporter', '17.7284844', '83.305553', NULL, NULL, 1, 'pic_5431674121839.jpg', 'bAKNc5rGqRc1qHGyymwX', NULL, 'fNXKq-WlR_2LcQjfuo21mD:APA91bEW_uDqN9xUuv_dul8Ozh5xCAuMezUW3LP_wsij5cw3GChQiKTqE8PtYj8aQM0761aTndKYav0psYqkJ2oUQP-yRuq14yA08LDUVLw-M45o4e6WGZlqdSb8vIpxjtlM90iKFJJJ', 'android', 1, 'Own Employee', 7, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-11-30 12:11:56', '2023-03-28 16:26:04'),
(107, 0, 'swathi', 'swathi', 'swathi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632580147', 'vip road,ramatakies visakapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, 'pic_4451670230221.jpg', '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '4576.00', NULL, NULL, 'None', '2022-12-05 14:18:12', '2022-12-05 14:20:21'),
(108, 107, 'gandhar', 'gangadhar', 'gangadhar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9332584487', 'madhurswada, visakapatnam', NULL, 1, 88, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-12-05 14:19:53', NULL),
(110, 109, 'sallem', 'saleem', 'saleemf@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632563259', 'dwarakanagar', 0, 1, 89, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-12-06 10:26:35', NULL),
(113, 3, '12333sdd', 'divya', 'divyfa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9876544343', 'surat', NULL, 1, 2, 'Attendant', '21.454852', '78.655655', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-12-08 14:59:19', NULL),
(116, 109, 'sowji', 'sowjanya', 'sowji@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9658099580', 'dwarakanagar', NULL, 1, 89, 'Attendant', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2022-12-08 18:45:57', NULL),
(119, 118, 'santosh', 'santosh', 'santosh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632155877', 'P78C+5QG,HPCL Steel Plant,Visakhapatnam,India,530014', 0, 1, 93, 'Manager', '17.714187415116704', '83.27330980449915', NULL, NULL, 1, 'pic_4341672738809.jpg', '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-03 14:11:04', '2023-01-03 15:10:20'),
(120, 118, 'chandu', 'chandu', 'chandhu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9547896554', 'visakapatnam', 0, 1, 94, 'Attendant', '', '', NULL, NULL, 1, NULL, 'Zy5mDeViqOuhLu507own', NULL, 'd80tmudnRjOfbUHnhAeNAd:APA91bHR5yP5E6MGel5DSi_VIc42c0erWgc0JOMacM87vHbW8UbdELlXGZ90vgnR87UuKxnGzLHRuUGl9QZI91qMX4mGQKXkXil8XkY3QRewTNBpZZLWWsnEo7lLoig4tv41mCGGHOJd', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-03 15:00:51', NULL),
(127, 126, '123567', 'hari', 'harig@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9587428874', 'siripuran, vizag', 0, 1, 98, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-04 18:35:17', NULL),
(133, 0, '81436019999', 'venkatesh hema venka', 'hemavenkatesh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143601999', 'dwaraka nagar   visakhapatnam', NULL, 1, 0, 'Transporter', '17.7285014', '83.3055482', NULL, NULL, 1, 'pic_8721673951987.jpg', 'U83AS24gowcVyr9HiF9W', NULL, 'dxVa1P98SgCfT1JYII9Egv:APA91bGSHagq6zbcAKsGmsPLnCRwuB_8RlrRUTA9D0kqaE1vp6UwdnMw23KtKC40BxlVojbQsVDhwRUV2Vu0EymQqjziOu6tTGRDkdUWizl6vSQq9gz9Pr2EpA2OBgJsK7iSyOlv1H-C', 'android', 1, 'Freelancer', 13, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-05 15:47:24', '2023-01-30 11:22:28'),
(137, 63, 'Jenshell', 'Jennifer', 'jen@gmail.com', '529b1fd83e9b9d478b471004f175a973', '0734567456', '411-01030,GATUNDU,HSE10,CLEEVELAND APARTMENT,CLAYWORKS GITHURAI 45', NULL, 1, 107, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-06 20:20:47', NULL),
(138, 63, 'okothshell', 'Tom', 'tomokoth@gmail.com', '529b1fd83e9b9d478b471004f175a973', '0723586985', 'hgfserttyh', NULL, 1, 107, 'Attendant', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-06 20:24:46', NULL),
(139, 63, 'petershell', 'peter', 'peterttt@gmail.com', '529b1fd83e9b9d478b471004f175a973', '0720736387', 'hgdaafgkkl', 0, 1, 107, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-06 20:28:31', '2023-01-06 20:30:39'),
(146, 121, '1236373', 'sreetham', 'sreetham@gmail.com', '25d55ad283aa400af464c76d713c07ad', '8143601224', 'dwaraka says I am', 0, 1, 102, 'Attendant', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-08 19:24:38', NULL),
(147, 121, '6363738383', 'bijay', 'bijay@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143601982', 'dwaraka nagar visakhapatnam dwaraka', 0, 1, 117, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-08 20:03:17', NULL),
(150, 148, '208208', 'nagendra', 'nagendra@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143601989', 'dwaraka nagar coloney 5 th line visakhapatnam', 4004, 1, 118, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, '', '26gDDQ1Z8Qri8VWUWu70', '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-09 15:13:28', '2023-01-09 15:40:18'),
(151, 149, '8143601', 'nagendra', 'hemavenkatesh208@gmail.com', '77fab95de2c362ba0ad0b1b27a9f058a', '8143601989', 'dwaraka nagar', NULL, 1, 121, 'Manager', NULL, NULL, NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-09 15:32:28', NULL),
(159, 0, 'praveen', 'praveen', 'prav@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9898909890', 'dwarakanagar,visakapatnam', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, 'Own Employee', 0, 0, NULL, '0.00', NULL, NULL, 'None', '2023-01-18 10:23:44', '2023-01-27 18:51:19'),
(160, 0, '155256', 'nagendra', 'nagendra208@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '97010098816', 'dwaraka nagar 5th line', NULL, 1, 0, 'Transporter', '17.728502', '83.3055178', NULL, NULL, 1, 'pic_3511674128229.jpg', '', NULL, '', 'android', 1, 'Own Employee', 11, 0, NULL, '0.00', NULL, NULL, 'None', '2023-01-19 16:57:17', '2023-01-27 18:51:09'),
(163, 152, '987654', 'manoj', 'manoj22@gmail.com', '6c44e5cd17f0019c64b042e4a745412a', '8144601989', 'dwaaraka nagar', 6774, 0, 124, 'Attendant', '', '', NULL, NULL, 1, NULL, 'MPxSmOVeL0xsohe8loND', NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-21 10:46:28', NULL),
(165, 152, '765765', 'praveen praveen practice practice practice practice practice practice', 'praven@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143601932', 'dwaraka nagar Visakhapatnam dwaraka nagar', NULL, 0, 124, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-23 18:14:37', NULL),
(172, 152, '654321', 'anil', 'anil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143600999', 'dwaraka Visakhapatnam', 0, 1, 124, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-25 14:09:47', '2023-01-25 14:10:49'),
(174, 162, '65432165', 'kumar', 'kumar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8143601729', 'dwaraka Visakhapatnam', 0, 1, 133, 'Manager', '', '', NULL, NULL, 1, 'pic_4771674825733.jpg', 'wu41esGZktPPznLdspct', NULL, 'ebds7EhkSeq4qL6S6iVDr8:APA91bH5q0aSTtmzqvayJJRy9Q5GeT1OvA64WPOlGaEvBazaoK2Cgqi57wL4tgaHC_cEv2quvzNDj314ig3vn4ojzWl_CK1ug9DSuc8kGibSFKxClZoqIHpB_6eReCQyU4Z4X69LvS8X', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-25 14:28:09', '2023-01-27 18:52:13'),
(175, 0, '28628775', 'Jennifer Kamura', 'kamurajennifer@gmail.com', 'be121740bf988b2225a313fa1f107ca1', '0715978789', '516', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, 'Own Employee', 12, 0, NULL, '0.00', NULL, NULL, 'None', '2023-01-25 17:28:56', '2023-01-27 18:50:59'),
(176, 70, '32243762', 'joseph mutunga', 'josephmutisya28@gmail.com', '51e2032a9bffee6013c5fcc825ea72fd', '0792646542', 'kma upperhill', NULL, 0, 70, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-01-25 17:48:00', NULL),
(182, 181, 'sankar@gmail.com', 'sankar', 'sankar@sankar.com', 'e10adc3949ba59abbe56e057f20f883e', '9876598543', 'dwarakanagar,visakapatnam', NULL, 1, 138, 'Manager', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-02-01 18:17:30', NULL),
(183, 181, 'rajeev', 'rajeev', 'rajjev@attender.com', 'a675ffb2ec24936fba6e16d5f384578f', '9885988512', 'testing', NULL, 1, 138, 'Attendant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-02-01 18:20:18', NULL),
(184, 0, 'btrans', 'Bounce Trans', 'btrams@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', '9676600666', 'dubi', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Own Employee', 0, 0, NULL, '0.00', NULL, NULL, 'None', '2023-02-01 18:21:45', NULL),
(202, 0, 'nelson', 'Nelson', 'muriuki.nelson@gmail.com', '82781f348dd9517506ed5b3ab105f4f1', '0718913404', 'Kenya', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '6ZVXnBcabS4YEB4LHYVq', '', 'd-EmrVKlTe-ipFosA-DrD_:APA91bHoR4dmrQMVQ5oHPnWwO2uOwlCYCTeXo0PPScRXwRMTTK5NdMhUv-doyYl3TzTq2pFQZkHnmHJUa0L8xRog6SQYDdPH4NM4st5uKDVAnN3haBxGfWJSvCIHS7_2hMTYvPlNpKfD', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-03-03 15:03:28', NULL),
(204, 0, '22740509', 'David Muhia mbucho', 'davidmbucho@gmail.com', 'aa3c299b0566946bb1ba3d76a5f9d6e6', '0722991883', '47 Gatundu', NULL, 1, 0, 'Owner', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 'KES', '0.00', NULL, NULL, 'None', '2023-03-31 14:20:21', NULL),
(205, 0, 'Jenny', 'jenny', 'Jennifer.kamura@fanakamobile.com', 'be121740bf988b2225a313fa1f107ca1', '0719585416', '516', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'oDZRMq60xLGSxt3sa1w7', NULL, 'cMN81b9UTjiC2h9fdAyhP-:APA91bF6zE4M0UJ4fOYERjUpKdUFSB_v-LP0WOqu6E0UWHt-QcwS_h3HBwQANFgklU5bkamuvcYanQUY1JD1IZZDRBug9EcyrmHokV_Q4zjvKh4JZ5eZT2d3yfuIsTnGArv2b3dsQCGN', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-03-31 15:47:19', NULL),
(206, 0, 'Dogoflani', 'Evan', 'uwaoevanz@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0707341617', 'Nrb', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, 'pic_7451680346402.jpg', 'wTSjQOzoaXyosQJ5eUT1', NULL, 'cB8u4kV1SQeFRqCvltnkRG:APA91bGuAJYsHiKbw3LInin4UZYUc3OmiP-qj4xBs_32igHDtIkcerGroaJUQxQzI6A4ZV5Llva56vxDDu1OT8nR2Z_fMuf24X7-iL7QxRGiMG0-sC52JsfeP0mufQJ99yNR-eCNYXnO', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-03-31 16:27:08', '2023-04-01 16:23:22'),
(207, 206, 'getty@gmail.com', 'Getty', 'getty@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0707341616', 'p.o box 13', 0, 1, 157, 'Manager', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-01 16:33:18', NULL),
(208, 206, 'dogo@gmail.com', 'Dogo', 'dogo@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0707341615', 'p.o box 13', 0, 1, 157, 'Attendant', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-01 16:35:41', NULL),
(209, 0, 'aparna', 'aparna swain', 'aparnaawain001@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9861977974', 'Visakhapatnam', 2533, 1, 0, 'Owner', '', '', NULL, NULL, 1, 'pic_1721680521184.jpg', 'duXhjoaZkcm2H7SUd6Lv', 'G2teN0wp1Vuevn43hAaA', 'fhTarJX1SMSfAUuwkx-467:APA91bEcd3sQpXMdWiC97LEjLK1J8E-fYrFfCUdsxJEANsvAM8I0fkJgx2sGyUQ2MOgISMXAN1jUWKOUBgA_Xx0Edi1GsMGIm7CXfIWWVu-HLc61J3jPZky7tvayMiw5GwzaIMqG_0Qv', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-03 15:22:15', '2023-04-03 16:56:24'),
(210, 0, 'gillian', 'gillian', 'ashyjillian@gmail.com', '01c5310a390f1815b90bbaedbc7564b3', '708549919', 'Nairobi', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'aHtj8nAA0pMRyRoKFDHP', NULL, 'f3d559BORTyhLuuar6rM0x:APA91bHu32B3oTCCScbPiTqH-nPP7jOSWUOmsRlx0xxE6flsFe1dA7eyudTB1SuntHfIe4cAhkmnNq3ZCMbmaaklygUrRxzY2h0FlvBpXNMcZPfKyEWQGHieICgprqFthV060t6UPfVc', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-03 17:19:58', NULL),
(211, 0, 'testone', 'test', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '4649548494', 'yhahahh', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-03 18:19:44', NULL),
(212, 202, 'muriuki.nelson@gmail.com', 'Kenya', 'kagirinelson@gmail.com', '82781f348dd9517506ed5b3ab105f4f1', '0114889330', 'Nairobi', NULL, 0, 162, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-03 23:03:59', NULL),
(213, 0, 'peter', 'peter', 'ceo@fanakamobile.com', '194012f1ea183bdbcfecc29ccf6f929f', '0110000888', 'nairobi', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'Ps36qoY1aMiAKiBkAdpp', NULL, 'c0D6FAlrSRmw0UNj1Xv0vs:APA91bGlVJ4yoOmQEHbx8bMiBLgW0tKy-qHGh3vWqTQm_xIa3xYvOHd8iRlsjTK1BiKawrfMQhlHog5iLQgT1uNJVVQ4WwXb6tSBmA1FFOQ7U5ze3r5KmFVKF5eoyEzE5C-LU3EXwCr8', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-04 03:00:44', NULL),
(214, 0, 'smileybalu', 'sowjanya', 'psowjanya101@gmail.com', 'cf5cdcc6c8d5690ab342eb92e14e6a42', '9014268684', 'amdihe', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'Vig2YzHhGYEVC3EUOhmr', NULL, 'f_q2NcF0SLOTo_dYTHZDsB:APA91bEFEGy30g4I_-emE9JJD5aKj6Qa0pyEfKrLIU2KNaHwQbP9_xTdnDv1W2TRagxVpmjkZwSNy42Pfp8Uqr-jiiH2CY5SB7KlRj1JTqtsxKOL7TmO22Z_QDUo-BXyeal9pEtpzqHm', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-05 17:43:52', NULL),
(215, 0, 'vyvVvab', 'vsvvs', 'caca@gma.com', 'e10adc3949ba59abbe56e057f20f883e', '5588888888', 'VvVyvVyv', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'gpyFElJuCsMZDUF4I8or', NULL, 'eVAlfXBySCyk6egDIaTDVg:APA91bHDPa0pk5AzlW9wVQ6eNX_0SZ8SmEx71M5ZwyFn8CAyRn3dwNvn3FnhkeyPginL-x0ykHR5Vuwdi4c8LoWSplmmHKOmEjPAW9sBqNiUm1I99OGm2YBInJsj3wAGmm9axtAhwpKM', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-05 17:46:27', NULL),
(216, 0, 'fagagag', 'ab', 'gags@g.com', 'e10adc3949ba59abbe56e057f20f883e', '8454646494', 'gagagshasbbs', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'nSS0XWuVql5WncziVuEN', NULL, 'c-zsPa-OQB-EsbBY4DCfgj:APA91bEAAZwJP59_kqTejXfhfiikSyi7YlGiFoeQPwn1h8BJuJQeIBJDpo6aLBsTFShWl5L4XneD-KzQCmXNYUHDR7kXzaVtln6c7kO9P0Rv5pP_gymGW3wZxOuaqVCp561N7fTumKIV', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-06 19:00:44', NULL),
(217, 0, 'cavababba', 'vsvsba', 'gavavba@g.mail', 'e10adc3949ba59abbe56e057f20f883e', '5464994949', 'gababbabb', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'IerQVA12pWw3R0JmqLyT', NULL, 'c-zsPa-OQB-EsbBY4DCfgj:APA91bEAAZwJP59_kqTejXfhfiikSyi7YlGiFoeQPwn1h8BJuJQeIBJDpo6aLBsTFShWl5L4XneD-KzQCmXNYUHDR7kXzaVtln6c7kO9P0Rv5pP_gymGW3wZxOuaqVCp561N7fTumKIV', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-06 19:02:02', NULL),
(218, 0, 'apfvcssg', 'ggggig', 'fhch@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2558825828', 'Visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'rPZ1G0H685SvUuTNfbql', NULL, 'cgS1R8YERiSoPoKKKm2c6Q:APA91bF-BQ1z7ewPjVbaCYoZDWf1tn1L_NwJOqLanRnunepSs42vbwfFHnUBErFzpoiAohiby9D9e0sSnmWovaPoJVn8fkUKrMETfVMU_ngbWI7ZB0L1MqBd-j0QVkkUhM_uVRR2MTpo', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 16:32:01', NULL),
(219, 0, 'yffxrdfxfd', 'cccccc', 'gcgcgc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8558286860', 'Visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 16:37:41', NULL),
(220, 0, 'vsvsgsvsvv', 'vsvsvgsgsg', 'Gfyfsf@gmail.com', '00c66aaf5f2c3f49946f15c1ad2ea0d3', '9494646488', 'Visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'IceXnvNJUmxfdSnvQhtn', NULL, 'cgS1R8YERiSoPoKKKm2c6Q:APA91bF-BQ1z7ewPjVbaCYoZDWf1tn1L_NwJOqLanRnunepSs42vbwfFHnUBErFzpoiAohiby9D9e0sSnmWovaPoJVn8fkUKrMETfVMU_ngbWI7ZB0L1MqBd-j0QVkkUhM_uVRR2MTpo', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 16:45:22', NULL),
(221, 0, 'bshsbwbebb', 'bsbsbsbbs', 'vsvscsc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9494949999', 'Visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '9KXI0FqrftLKL6RJ002m', NULL, 'cgS1R8YERiSoPoKKKm2c6Q:APA91bF-BQ1z7ewPjVbaCYoZDWf1tn1L_NwJOqLanRnunepSs42vbwfFHnUBErFzpoiAohiby9D9e0sSnmWovaPoJVn8fkUKrMETfVMU_ngbWI7ZB0L1MqBd-j0QVkkUhM_uVRR2MTpo', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 16:46:41', NULL),
(222, 0, 'ruhii', 'ruhi', 'ruhi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9890898088', 'visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 17:14:16', NULL),
(223, 0, 'radhika', 'radhika', 'radhi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9809809809', 'bangalore', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 17:15:43', NULL),
(224, 0, 'tayun', 'tatyn', 'tay@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8708541257', 'visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'GeRQB7gXVqkaGeCF9yul', NULL, 'fx5U1wZ_TmahrYQjD2C07p:APA91bGMVdO2khUdSPgFjJJeXXYnU2aqkh6qojG8pddyBvk38XSfP0BOIWZSapfISwrG0u9WW7-AkKxGzu-nBnNE-C6ic0__qoAX-YSdnSSedVNfTXqnk8FAYDjDar7gFYXndO4RgG88', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 17:17:21', NULL),
(225, 0, 'sathish', 'satish', 'satish@gmaio.com', 'e10adc3949ba59abbe56e057f20f883e', '9096588087', 'thatichetlapalem', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'CMXCHEAtwsKZ9hUoj12h', NULL, 'fx5U1wZ_TmahrYQjD2C07p:APA91bGMVdO2khUdSPgFjJJeXXYnU2aqkh6qojG8pddyBvk38XSfP0BOIWZSapfISwrG0u9WW7-AkKxGzu-nBnNE-C6ic0__qoAX-YSdnSSedVNfTXqnk8FAYDjDar7gFYXndO4RgG88', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 17:34:08', NULL),
(226, 0, 'fydydyfdgx', 'vvxgxx', 'cccgg@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '5858888768', 'Visakhapatnam', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-10 17:45:49', NULL),
(227, 0, 'chari', 'chari', 'chari@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9050402070', 'kakinada, Andhra Pradesh', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, '4K0dnLWeHoa1fMHMCRWt', NULL, 'cM3EPJUrRomxdwCUn-y6bs:APA91bGZpLRQJmiwMZBOY0WK1QK3FhEYgkQ4qAyLSSTiMZnane-eQXMN5vPblZ58hUv3lUKswX9IvFhSEbxkNKEOlNGWT8_0dUs8Cn0CCluWIBowRAY4CiSasbACm3QVdfzQFfYQglm9', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-17 17:36:26', NULL),
(232, 68, 'qwrrfdds', 'hari', 'gaerf@gmail.com', '86f9c9aec49dc53128103eafb6f0efcc', '9807745545', 'vizag', NULL, 0, 175, 'Attendant', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-21 12:16:21', NULL),
(233, 68, 'kiransai', 'saikiran', 'saikiran@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632580966', 'shantinagar, visakapatnam,530056', NULL, 0, 165, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-24 17:46:19', NULL),
(235, 68, 'santosh1', 'santosh', 'santoswh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9807458008', 'pmpalem, visakhapatnam,530098', NULL, 0, 165, 'Attendant', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-24 17:50:12', NULL),
(241, 68, 'satyakirs', 'satyakirsn', 'satykirsn@gmail.com', '25d55ad283aa400af464c76d713c07ad', '9807412848', 'Gopala patnam, visakapatnam,530034', NULL, 0, 165, 'Manager', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-24 18:37:27', NULL),
(242, 68, 'hariraj', 'hariraj', 'hariraj@gmail.com', '220466675e31b9d20c051d5e57974150', '9632580745', 'madhurawada,vizag,530098', NULL, 0, 175, 'Attendant', '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'KES', '0.00', NULL, NULL, 'None', '2023-04-24 18:38:21', NULL),
(243, 0, 'dineshdev', 'Dinesh', 'dinesh.dev@colourmoon.com', 'e10adc3949ba59abbe56e057f20f883e', '1234561230', 'surat', NULL, 1, 0, 'Owner', NULL, NULL, NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-04-27 11:24:32', NULL),
(244, 0, 'Dionne', 'Dionne', 'directortech@investafrica.co.ke', '174f3063dbafc5be3a5bc3bafea5148f', '0735644422', 'Nairobi', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'wYIXCB8pOc5aED7E08Wo', NULL, 'epcgn1ZjTDu6ju30Bn0fp-:APA91bGLD-PZNByiF_ZSdQILkBW5HFpy5i6jgg6s1OtzyINfZI5sS0O5ccdFHHcIJPrE4ZZMlZfldPKWtdHtP_4qoCKJGYUrhRMxBFx_FhXvSqnos8RAdTJ9psm9xf-pOs3KVqydirdQ', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-05-06 18:00:57', NULL),
(245, 0, 'admin@eqwipetrol.com', 'nagendra', 'nagendrababu1005@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '9676941819', 'somewhere in the world', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, '4CzD5lmexEBxmYHbPn3r', NULL, 'ebsAN7WLTn6miNBx_dDVDU:APA91bG3tOXzT-EHAt9S3M4dP41J1Cl-CcIjD4JvAApyfiLjq9pl2iLUvp052UzQJXTM3tOit19BJC4IGlyYHcueZ_lhFLoE2pl9FRWmNnT6gxDo8v6A5zG2SRBBZ7ElW87jfVzo3Mvc', 'android', NULL, 'Own Employee', 14, 0, NULL, '0.00', NULL, NULL, 'None', '2023-05-09 17:12:57', '2023-05-10 11:54:18'),
(246, 0, 'nayak', 'nayak', 'nayak@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9658077488', 'siripuram, visakapatnam,530016', 0, 1, 0, 'Owner', '', '', NULL, NULL, 1, NULL, 'RxviFtFDKAZBoCIud1Hk', NULL, 'cnzAekF8THaXRWo-sWfEzY:APA91bGgUzTVGFwBbqs9LSaVIDJrKcPm02y7r5bllZgq3-ZZMHz2CtXqvjR5CCDhGdSF3hhQIuznvl1joShLn6eW_onGKERmZygKIhiIvmRXEPCG05BJ1CyLDN787N0_zeVO9lZ9zEmj', 'android', NULL, NULL, 0, 1, 'KES', '0.00', NULL, NULL, 'None', '2023-05-09 17:13:08', NULL),
(247, 0, 'admin@gmail.com', 'yeah', 'yeah123@gmaol.com', 'fcea920f7412b5da7be0cf42b8c93759', '8555003133', 'some address', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, '', NULL, '', 'android', NULL, 'Own Employee', 15, 0, NULL, '0.00', NULL, NULL, 'None', '2023-05-11 09:41:32', '2023-05-11 09:49:23'),
(248, 0, 'zeak', 'zeak', 'zeak123@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '9000001819', 'some address', NULL, 1, 0, 'Transporter', NULL, NULL, NULL, NULL, 1, NULL, 'Cm7QrNA156CvAbL1uhg4', NULL, 'cPz98QxrTlGSU243e7SLR8:APA91bFYTjLzxVIqCppmDss4UB6jd4JkbqRsd3AIbUkDwSBspP3yCHjktg0pSac_76A0rxaLl4bhrZk5qYFNqAmGJm01Nl1b5-vO6ihTusd4YQEaYghaLI0foqNmKWdic8RBxsjc3MYH', 'android', NULL, 'Own Employee', 16, 0, NULL, '0.00', NULL, NULL, 'None', '2023-05-11 09:53:48', '2023-05-11 10:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `document_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `document_type`, `document_number`, `front_photo`, `status`, `created_date`, `updated_date`) VALUES
(1, 6, 'Driving License', '123456789012341', 'front_5011670398088.jpg', 1, '2022-10-21 10:20:08', '2023-03-28 11:53:32'),
(2, 58, 'Driving License', '123456', 'front_1891670322673.jpg', 1, '2022-11-11 19:11:33', '2022-12-07 14:33:09'),
(3, 80, 'Driving License', '78788889', 'front_9991670394824.jpg', 1, '2022-12-07 12:03:44', '2022-12-07 13:14:03'),
(4, 19, 'Driving License', '12345647891', 'front_6871671701841.jpg', 1, '2022-12-14 09:10:00', '2023-05-19 16:28:00'),
(5, 86, 'Driving License', '4554333', 'front_6701671698712.jpg', 1, '2022-12-14 10:22:47', '2022-12-22 15:38:26'),
(6, 85, 'Driving License', '9898998789', 'front_5101671700426.jpg', 1, '2022-12-22 14:43:50', '2023-03-28 16:26:04'),
(7, 130, 'Driving License', 'APECHJJSDKJAKMLKAMDL', 'front_6551672902214.png', 1, '0000-00-00 00:00:00', NULL),
(8, 132, 'Driving License', 'ap23as1232aas23ods', 'front_6571672913502.jpg', 1, '0000-00-00 00:00:00', NULL),
(9, 133, 'Driving License', '51346789009', 'front_5131675057946.jpg', 1, '0000-00-00 00:00:00', '2023-01-30 11:22:28'),
(10, 136, 'Driving License', 'Dfhff', 'front_1201673008536.jpg', 1, '0000-00-00 00:00:00', '2023-01-06 18:05:41'),
(11, 84, 'Driving License', 'ap232wsasd 3eidskk', 'front_8091673517440.png', 1, '2023-01-12 15:27:20', NULL),
(12, 155, 'Driving License', '12345', 'front_9951673872699.jpg', 1, '0000-00-00 00:00:00', NULL),
(13, 159, 'Driving License', 'etr3544435', 'front_3261674017624.jpg', 1, '0000-00-00 00:00:00', NULL),
(14, 160, 'Driving License', '98765899909ujhhuuii', 'front_5561674128046.jpg', 1, '0000-00-00 00:00:00', '2023-01-27 18:16:08'),
(15, 175, 'Driving License', 'fffg', 'front_4391674647937.jpeg', 1, '0000-00-00 00:00:00', '2023-01-25 18:03:08'),
(16, 79, 'Driving License', '', NULL, 1, '0000-00-00 00:00:00', NULL),
(17, 75, 'Driving License', '', NULL, 1, '0000-00-00 00:00:00', NULL),
(18, 184, 'Driving License', '2345688989898', 'front_1921675255905.jpg', 1, '0000-00-00 00:00:00', NULL),
(19, 245, 'Driving License', 'FHFVJGGHG', 'front_3481683632937.jpg', 1, '0000-00-00 00:00:00', '2023-05-10 11:54:18'),
(20, 247, 'Driving License', 'RED1332444', 'front_6201683778761.jpg', 1, '0000-00-00 00:00:00', '2023-05-11 09:49:23'),
(21, 248, 'Driving License', 'dd13323', 'front_9401683779482.jpg', 1, '0000-00-00 00:00:00', '2023-05-11 10:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_review`
--

CREATE TABLE `user_review` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `rating` decimal(4,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `feedback_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_type` enum('Review','Feedback') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `vehicle_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measurement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_capacity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_vehicle_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `back_vehicle_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `left_vehicle_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `right_vehicle_photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_compartment` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `user_id`, `vehicle_number`, `measurement`, `vehicle_capacity`, `front_vehicle_photo`, `back_vehicle_photo`, `left_vehicle_photo`, `right_vehicle_photo`, `vehicle_document`, `no_of_compartment`, `status`, `created_date`, `updated_date`) VALUES
(1, 6, 'GJ5-GL-1234', 'Litr', '10000', 'vehicle_3261666278217.jpg', NULL, NULL, NULL, 'document_2971666278217.jpg', 3, 1, '2022-10-20 20:33:37', '2023-03-28 11:53:32'),
(5, 19, 'GJ1234', 'Litr', '12000', 'front_5491674817123.jpg', 'back_5541674813315.jpg', 'left_6781674813336.jpg', 'left_6781674813336.jpg', 'document_8251674818081.jpg', 4, 1, '2022-12-20 16:16:42', '2023-05-19 16:28:00'),
(6, 86, '123444', 'Litr', '6000', 'vehicle_9771671698333.jpg', NULL, NULL, NULL, 'document_9241671698356.jpg', 5, 1, '2022-12-22 14:09:44', '2022-12-22 15:38:26'),
(7, 85, '45t45', 'Litr', '12000', 'front_4101675247096.jpg', 'back_6821675247108.jpg', 'left_4461674812145.jpg', 'left_4461674812145.jpg', 'document_9731671700373.jpg', 4, 1, '2022-12-22 14:43:50', '2023-03-28 16:26:04'),
(8, 133, 'p23as1234', 'Litr', '1000', 'vehicle_5891673186625.jpg', NULL, NULL, NULL, 'document_6691672980154.jpg', 3, 0, '2023-01-05 16:04:53', '2023-01-17 15:59:40'),
(9, 136, 'KDJ 4675', 'Litr', '10000', 'vehicle_7521673008490.jpg', NULL, NULL, NULL, 'document_4361673008502.jpg', 1, 1, '2023-01-06 18:05:41', NULL),
(10, 84, 'ap23as1234', '52', '1000', 'vehicle_5691673517440.png', NULL, NULL, NULL, 'document_7431673517440.png', 3, 1, '2023-01-12 15:27:20', NULL),
(11, 160, 'AS12As1234', 'Litr', '14500', 'vehicle_4801674128090.jpg', 'back_7041674797926.jpg', 'left_5551674797926.jpg', 'left_5551674797926.jpg', 'document_9351674128024.jpg', 1, 1, '2023-01-19 17:04:08', '2023-01-27 18:16:08'),
(12, 175, 'nbcgmjl', 'litres', '10000', 'vehicle_2751674649988.jpg', NULL, NULL, NULL, 'document_5391674649988.jpg', 1, 1, '2023-01-25 18:03:08', NULL),
(13, 133, 'AP23AS1234', 'Litr', '1000', 'front_3921675057911.jpg', 'front_1211675057915.jpg', 'front_2051675057919.jpg', 'front_2051675057919.jpg', 'document_1471675057929.jpg', 1, 1, '2023-01-30 11:22:28', NULL),
(14, 245, 'RDSFF1', 'Litr', '12000', 'front_5821683632880.jpg', 'front_1711683632886.jpg', 'front_8391683632892.jpg', 'front_8391683632892.jpg', 'document_6841683632903.jpg', 3, 1, '2023-05-09 17:19:01', '2023-05-10 11:54:18'),
(15, 247, 'FBDHVVF', 'Litr', '12000', 'front_9281683778692.jpg', 'front_6091683778702.jpg', 'front_8741683778709.jpg', 'front_8741683778709.jpg', 'document_7811683778723.jpg', 3, 1, '2023-05-11 09:49:23', NULL),
(16, 248, 'EFEGDF', 'Litr', '12000', 'front_4321683779378.jpg', 'front_4091683779384.jpg', 'front_9491683779391.jpg', 'front_9491683779391.jpg', 'document_1351683779404.jpg', 4, 1, '2023-05-11 10:01:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_detail`
--

CREATE TABLE `vehicle_detail` (
  `id` bigint(20) NOT NULL,
  `vehicle_id` bigint(20) NOT NULL,
  `compartment_no` int(11) NOT NULL,
  `compartment_capacity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_detail`
--

INSERT INTO `vehicle_detail` (`id`, `vehicle_id`, `compartment_no`, `compartment_capacity`) VALUES
(195, 6, 1, '2000'),
(196, 6, 2, '4000'),
(197, 6, 3, '5000'),
(198, 6, 4, '1000'),
(199, 6, 5, '1000'),
(208, 9, 1, '1000'),
(223, 10, 1, '100'),
(224, 10, 2, '100'),
(225, 10, 3, '100'),
(232, 8, 1, '1580'),
(233, 8, 2, '150'),
(234, 8, 3, '150'),
(249, 12, 1, '1000'),
(275, 11, 1, '1000'),
(279, 13, 1, '1000'),
(305, 1, 1, '2000'),
(306, 1, 2, '4000'),
(307, 1, 3, '4000'),
(317, 7, 1, '3000'),
(318, 7, 2, '3000'),
(319, 7, 3, '3000'),
(320, 7, 4, '3000'),
(323, 14, 1, '4000'),
(324, 14, 2, '4000'),
(325, 14, 3, '4000'),
(326, 15, 1, '4000'),
(327, 15, 2, '4000'),
(328, 15, 3, '4000'),
(329, 16, 1, '3000'),
(330, 16, 2, '3000'),
(331, 16, 3, '3000'),
(332, 16, 4, '3000'),
(337, 5, 1, '3000'),
(338, 5, 2, '3000'),
(339, 5, 3, '3000'),
(340, 5, 4, '3000');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `name`, `email`, `mobile`, `address`, `latitude`, `longitude`, `status`, `created_date`, `updated_date`) VALUES
(1, 'test vendor', 'test@vendor.com', '1234567890', 'test address', '17.684311382019164', '83.1860489038005', 1, '2022-10-20 17:14:29', '2022-11-16 15:16:38'),
(2, 'National Oil', 'national@gmail.com', '0799988222', 'KAWI HOUSE', '-1.288811', '36.823219', 1, '2022-11-23 17:20:28', NULL),
(3, 'venkatesh', 'hemavenkatsh@gmail.com', '8143601989', 'dwaaraka nagar  5th line visakapatnam', '17.728820', '83.307522', 1, '2023-01-05 15:52:45', '2023-01-06 19:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_purchase`
--

CREATE TABLE `vendor_purchase` (
  `id` bigint(20) NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `invoice_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `inward_date` date DEFAULT NULL,
  `invoice_attach` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL,
  `product_data` text COLLATE utf8mb4_unicode_ci,
  `vendor_data` text COLLATE utf8mb4_unicode_ci,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_purchase`
--

INSERT INTO `vendor_purchase` (`id`, `vendor_id`, `product_id`, `invoice_no`, `invoice_date`, `inward_date`, `invoice_attach`, `amount`, `product_data`, `vendor_data`, `created_date`, `updated_date`) VALUES
(1, 1, 2, 'INV0001', '2022-12-04', '2022-12-05', 'inv_5511670232417.jpg', '1000.00', '{\"category_id\":\"2\",\"name\":\"Petrol\",\"type\":\"Pms\",\"image\":\"product_5051666941331.png\",\"measurement\":\"Litr\",\"status\":\"1\",\"display_order\":\"1\",\"created_date\":\"2022-10-17 19:25:50\",\"updated_date\":\"2022-10-28 12:45:31\"}', '{\"vendor_id\":\"1\",\"name\":\"test vendor\",\"email\":\"test@vendor.com\",\"mobile\":\"1234567890\",\"address\":\"test address\",\"latitude\":\"17.684311382019164\",\"longitude\":\"83.1860489038005\",\"status\":\"1\",\"created_date\":\"2022-10-20 17:14:29\",\"updated_date\":\"2022-11-16 15:16:38\"}', '2022-12-05 13:38:44', '2022-12-05 14:58:02'),
(2, 2, 3, 'INV0002', '2022-12-05', '2022-12-05', 'inv_1751670227725.jpg', '1500.00', '{\"category_id\":\"3\",\"name\":\"Diesel\",\"type\":\"Ago\",\"image\":\"product_6011666941346.png\",\"measurement\":\"Litr\",\"status\":\"1\",\"display_order\":\"2\",\"created_date\":\"2022-10-17 19:26:28\",\"updated_date\":\"2022-10-28 12:45:45\"}', '{\"vendor_id\":\"2\",\"name\":\"National Oil\",\"email\":\"national@gmail.com\",\"mobile\":\"0799988222\",\"address\":\"KAWI HOUSE\",\"latitude\":\"-1.288811\",\"longitude\":\"36.823219\",\"status\":\"1\",\"created_date\":\"2022-11-23 17:20:28\",\"updated_date\":null}', '2022-12-05 13:38:45', '2022-12-05 14:59:14'),
(3, 3, 2, '123456789', '2023-01-05', '2023-01-01', 'inv_2521672914224.jpg', '500000.00', '{\"category_id\":\"2\",\"name\":\"Petrol\",\"type\":\"Pms\",\"image\":\"product_5051666941331.png\",\"measurement\":\"Litr\",\"status\":\"1\",\"display_order\":\"1\",\"created_date\":\"2022-10-17 19:25:50\",\"updated_date\":\"2022-10-28 12:45:31\"}', '{\"vendor_id\":\"3\",\"name\":\"venkatesh\",\"email\":\"hemavenkatsh@gmail.com\",\"mobile\":\"8143601989\",\"address\":\"dwaaraka nagar  5th line visakapatnam\",\"latitude\":\"17.728820\",\"longitude\":\"83.307522\",\"status\":\"1\",\"created_date\":\"2023-01-05 15:52:45\",\"updated_date\":null}', '2023-01-05 15:53:44', NULL),
(4, 3, 2, 'etfgc', '2023-01-06', '2023-01-06', 'inv_6461673014646.png', '12356790.00', '{\"category_id\":\"2\",\"name\":\"Petrol\",\"type\":\"Pms\",\"image\":\"product_5051666941331.png\",\"measurement\":\"Litr\",\"status\":\"1\",\"display_order\":\"1\",\"created_date\":\"2022-10-17 19:25:50\",\"updated_date\":\"2022-10-28 12:45:31\"}', '{\"vendor_id\":\"3\",\"name\":\"venkatesh\",\"email\":\"hemavenkatsh@gmail.com\",\"mobile\":\"8143601989\",\"address\":\"dwaaraka nagar  5th line visakapatnam\",\"latitude\":\"17.728820\",\"longitude\":\"83.307522\",\"status\":\"1\",\"created_date\":\"2023-01-05 15:52:45\",\"updated_date\":\"2023-01-06 19:37:51\"}', '2023-01-06 19:47:26', NULL),
(5, 2, 2, '7628728298', '2023-01-31', NULL, NULL, '28282929.00', '{\"category_id\":\"2\",\"name\":\"Petrol\",\"type\":\"Pms\",\"image\":\"product_5051666941331.png\",\"measurement\":\"Litr\",\"minimum_order_qty\":\"100\",\"status\":\"1\",\"display_order\":\"1\",\"created_date\":\"2022-10-17 19:25:50\",\"updated_date\":\"2023-01-30 12:58:29\"}', '{\"vendor_id\":\"2\",\"name\":\"National Oil\",\"email\":\"national@gmail.com\",\"mobile\":\"0799988222\",\"address\":\"KAWI HOUSE\",\"latitude\":\"-1.288811\",\"longitude\":\"36.823219\",\"status\":\"1\",\"created_date\":\"2022-11-23 17:20:28\",\"updated_date\":null}', '2023-02-01 18:26:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_dashboard_menu`
--
ALTER TABLE `admin_dashboard_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_privileges`
--
ALTER TABLE `admin_user_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_orders`
--
ALTER TABLE `assign_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_order_details`
--
ALTER TABLE `assign_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boarding_sliders`
--
ALTER TABLE `boarding_sliders`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_orders`
--
ALTER TABLE `cart_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_order_details`
--
ALTER TABLE `cart_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_price`
--
ALTER TABLE `category_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_support`
--
ALTER TABLE `help_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_ticket`
--
ALTER TABLE `help_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_order_notifications`
--
ALTER TABLE `new_order_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_setting`
--
ALTER TABLE `option_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reject_reason`
--
ALTER TABLE `reject_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`station_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transporter_not_available`
--
ALTER TABLE `transporter_not_available`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_review`
--
ALTER TABLE `user_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `vehicle_detail`
--
ALTER TABLE `vehicle_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_purchase`
--
ALTER TABLE `vendor_purchase`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_dashboard_menu`
--
ALTER TABLE `admin_dashboard_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `admin_user_privileges`
--
ALTER TABLE `admin_user_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assign_orders`
--
ALTER TABLE `assign_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=974;

--
-- AUTO_INCREMENT for table `assign_order_details`
--
ALTER TABLE `assign_order_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2509;

--
-- AUTO_INCREMENT for table `boarding_sliders`
--
ALTER TABLE `boarding_sliders`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=933;

--
-- AUTO_INCREMENT for table `cart_orders`
--
ALTER TABLE `cart_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1307;

--
-- AUTO_INCREMENT for table `cart_order_details`
--
ALTER TABLE `cart_order_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1388;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category_price`
--
ALTER TABLE `category_price`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `help_support`
--
ALTER TABLE `help_support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `help_ticket`
--
ALTER TABLE `help_ticket`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;

--
-- AUTO_INCREMENT for table `new_order_notifications`
--
ALTER TABLE `new_order_notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2892;

--
-- AUTO_INCREMENT for table `option_setting`
--
ALTER TABLE `option_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `reject_reason`
--
ALTER TABLE `reject_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `station_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1464;

--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transporter_not_available`
--
ALTER TABLE `transporter_not_available`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_review`
--
ALTER TABLE `user_review`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicle_detail`
--
ALTER TABLE `vehicle_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor_purchase`
--
ALTER TABLE `vendor_purchase`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
