-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2020 at 07:38 PM
-- Server version: 5.7.19
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gops2`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Administrator', '1', 1602998454),
('ViewOnly', '2', 1603863337),
('ViewOnly', '3', 1603863303),
('ViewOnly', '7', 1603960382);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Administrator', 1, 'System Administrator', NULL, NULL, 1602981205, 1603350288),
('app_club_create', 2, 'app/club/create', NULL, NULL, 1602304300, 1602304300),
('app_club_delete', 2, 'app/club/delete', NULL, NULL, 1602304300, 1602304300),
('app_club_index', 2, 'app/club/index', NULL, NULL, 1602304300, 1602304300),
('app_club_update', 2, 'app/club/update', NULL, NULL, 1602304300, 1602304300),
('app_club_view', 2, 'app/club/view', NULL, NULL, 1602304300, 1602304300),
('app_contest_create', 2, 'app/contest/create', NULL, NULL, 1602304300, 1602304300),
('app_contest_delete', 2, 'app/contest/delete', NULL, NULL, 1602304300, 1602304300),
('app_contest_index', 2, 'app/contest/index', NULL, NULL, 1602304300, 1602304300),
('app_contest_update', 2, 'app/contest/update', NULL, NULL, 1602304300, 1602304300),
('app_contest_view', 2, 'app/contest/view', NULL, NULL, 1602304300, 1602304300),
('app_default-type_create', 2, 'app/default-type/create', NULL, NULL, 1603003850, 1603003850),
('app_default-type_delete', 2, 'app/default-type/delete', NULL, NULL, 1603003850, 1603003850),
('app_default-type_index', 2, 'app/default-type/index', NULL, NULL, 1603003850, 1603003850),
('app_default-type_update', 2, 'app/default-type/update', NULL, NULL, 1603003850, 1603003850),
('app_default-type_view', 2, 'app/default-type/view', NULL, NULL, 1603003850, 1603003850),
('app_landout_create', 2, 'app/landout/create', NULL, NULL, 1603350260, 1603350260),
('app_landout_delete', 2, 'app/landout/delete', NULL, NULL, 1603350260, 1603350260),
('app_landout_index', 2, 'app/landout/index', NULL, NULL, 1603350260, 1603350260),
('app_landout_update', 2, 'app/landout/update', NULL, NULL, 1603350260, 1603350260),
('app_landout_view', 2, 'app/landout/view', NULL, NULL, 1603350260, 1603350260),
('app_launch_create', 2, 'app/launch/create', NULL, NULL, 1602304300, 1602304300),
('app_launch_delete', 2, 'app/launch/delete', NULL, NULL, 1602304300, 1602304300),
('app_launch_index', 2, 'app/launch/index', NULL, NULL, 1602304300, 1602304300),
('app_launch_update', 2, 'app/launch/update', NULL, NULL, 1602304300, 1602304300),
('app_launch_view', 2, 'app/launch/view', NULL, NULL, 1602304300, 1602304300),
('app_pilot_create', 2, 'app/pilot/create', NULL, NULL, 1602304300, 1602304300),
('app_pilot_delete', 2, 'app/pilot/delete', NULL, NULL, 1602304300, 1602304300),
('app_pilot_index', 2, 'app/pilot/index', NULL, NULL, 1602304300, 1602304300),
('app_pilot_update', 2, 'app/pilot/update', NULL, NULL, 1602304300, 1602304300),
('app_pilot_view', 2, 'app/pilot/view', NULL, NULL, 1602304300, 1602304300),
('app_price_create', 2, 'app/price/create', NULL, NULL, 1602980834, 1602980834),
('app_price_delete', 2, 'app/price/delete', NULL, NULL, 1602980834, 1602980834),
('app_price_index', 2, 'app/price/index', NULL, NULL, 1602980834, 1602980834),
('app_price_update', 2, 'app/price/update', NULL, NULL, 1602980834, 1602980834),
('app_price_view', 2, 'app/price/view', NULL, NULL, 1602980834, 1602980834),
('app_retrieve_create', 2, 'app/retrieve/create', NULL, NULL, 1602304300, 1602304300),
('app_retrieve_delete', 2, 'app/retrieve/delete', NULL, NULL, 1602304300, 1602304300),
('app_retrieve_index', 2, 'app/retrieve/index', NULL, NULL, 1602304300, 1602304300),
('app_retrieve_update', 2, 'app/retrieve/update', NULL, NULL, 1602304300, 1602304300),
('app_retrieve_view', 2, 'app/retrieve/view', NULL, NULL, 1602304300, 1602304300),
('app_towplane_create', 2, 'app/towplane/create', NULL, NULL, 1602304301, 1602304301),
('app_towplane_delete', 2, 'app/towplane/delete', NULL, NULL, 1602304301, 1602304301),
('app_towplane_index', 2, 'app/towplane/index', NULL, NULL, 1602304301, 1602304301),
('app_towplane_update', 2, 'app/towplane/update', NULL, NULL, 1602304301, 1602304301),
('app_towplane_view', 2, 'app/towplane/view', NULL, NULL, 1602304301, 1602304301),
('app_transaction_create', 2, 'app/transaction/create', NULL, NULL, 1602304301, 1602304301),
('app_transaction_delete', 2, 'app/transaction/delete', NULL, NULL, 1602304301, 1602304301),
('app_transaction_index', 2, 'app/transaction/index', NULL, NULL, 1602304301, 1602304301),
('app_transaction_update', 2, 'app/transaction/update', NULL, NULL, 1602304301, 1602304301),
('app_transaction_view', 2, 'app/transaction/view', NULL, NULL, 1602304301, 1602304301),
('app_transaction-type_create', 2, 'app/transaction-type/create', NULL, NULL, 1602304300, 1602304300),
('app_transaction-type_delete', 2, 'app/transaction-type/delete', NULL, NULL, 1602304300, 1602304300),
('app_transaction-type_index', 2, 'app/transaction-type/index', NULL, NULL, 1602304300, 1602304300),
('app_transaction-type_update', 2, 'app/transaction-type/update', NULL, NULL, 1602304300, 1602304300),
('app_transaction-type_view', 2, 'app/transaction-type/view', NULL, NULL, 1602304300, 1602304300),
('AppClubEdit', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppClubFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppClubView', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppContestEdit', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppContestFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppContestView', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppDefaultTypeEdit', 1, NULL, NULL, NULL, 1603003850, 1603003850),
('AppDefaultTypeFull', 1, NULL, NULL, NULL, 1603003850, 1603003850),
('AppDefaultTypeView', 1, NULL, NULL, NULL, 1603003850, 1603003850),
('AppLandoutEdit', 1, NULL, NULL, NULL, 1603350260, 1603350260),
('AppLandoutFull', 1, NULL, NULL, NULL, 1603350260, 1603350260),
('AppLandoutView', 1, NULL, NULL, NULL, 1603350260, 1603350260),
('AppLaunchEdit', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppLaunchFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppLaunchView', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppPilotEdit', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppPilotFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppPilotView', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppRetrieveEdit', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppRetrieveFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppRetrieveView', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTowplaneEdit', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTowplaneFull', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTowplaneView', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTransactionEdit', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTransactionFull', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('AppTransactionTypeEdit', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppTransactionTypeFull', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppTransactionTypeView', 1, NULL, NULL, NULL, 1602304300, 1602304300),
('AppTransactionView', 1, NULL, NULL, NULL, 1602304301, 1602304301),
('ViewOnly', 1, 'Registered user with View Only Rights', NULL, NULL, 1603863283, 1603864191);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('AppClubEdit', 'app_club_create'),
('AppClubFull', 'app_club_create'),
('AppClubEdit', 'app_club_delete'),
('AppClubFull', 'app_club_delete'),
('AppClubFull', 'app_club_index'),
('AppClubView', 'app_club_index'),
('AppClubEdit', 'app_club_update'),
('AppClubFull', 'app_club_update'),
('AppClubFull', 'app_club_view'),
('AppClubView', 'app_club_view'),
('AppContestEdit', 'app_contest_create'),
('AppContestFull', 'app_contest_create'),
('AppContestEdit', 'app_contest_delete'),
('AppContestFull', 'app_contest_delete'),
('AppContestFull', 'app_contest_index'),
('AppContestView', 'app_contest_index'),
('AppContestEdit', 'app_contest_update'),
('AppContestFull', 'app_contest_update'),
('AppContestFull', 'app_contest_view'),
('AppContestView', 'app_contest_view'),
('AppDefaultTypeEdit', 'app_default-type_create'),
('AppDefaultTypeFull', 'app_default-type_create'),
('AppDefaultTypeEdit', 'app_default-type_delete'),
('AppDefaultTypeFull', 'app_default-type_delete'),
('AppDefaultTypeFull', 'app_default-type_index'),
('AppDefaultTypeView', 'app_default-type_index'),
('AppDefaultTypeEdit', 'app_default-type_update'),
('AppDefaultTypeFull', 'app_default-type_update'),
('AppDefaultTypeFull', 'app_default-type_view'),
('AppDefaultTypeView', 'app_default-type_view'),
('AppLandoutEdit', 'app_landout_create'),
('AppLandoutFull', 'app_landout_create'),
('AppLandoutEdit', 'app_landout_delete'),
('AppLandoutFull', 'app_landout_delete'),
('AppLandoutFull', 'app_landout_index'),
('AppLandoutView', 'app_landout_index'),
('AppLandoutEdit', 'app_landout_update'),
('AppLandoutFull', 'app_landout_update'),
('AppLandoutFull', 'app_landout_view'),
('AppLandoutView', 'app_landout_view'),
('AppLaunchEdit', 'app_launch_create'),
('AppLaunchFull', 'app_launch_create'),
('AppLaunchEdit', 'app_launch_delete'),
('AppLaunchFull', 'app_launch_delete'),
('AppLaunchFull', 'app_launch_index'),
('AppLaunchView', 'app_launch_index'),
('AppLaunchEdit', 'app_launch_update'),
('AppLaunchFull', 'app_launch_update'),
('AppLaunchFull', 'app_launch_view'),
('AppLaunchView', 'app_launch_view'),
('AppPilotEdit', 'app_pilot_create'),
('AppPilotFull', 'app_pilot_create'),
('AppPilotEdit', 'app_pilot_delete'),
('AppPilotFull', 'app_pilot_delete'),
('AppPilotFull', 'app_pilot_index'),
('AppPilotView', 'app_pilot_index'),
('AppPilotEdit', 'app_pilot_update'),
('AppPilotFull', 'app_pilot_update'),
('AppPilotFull', 'app_pilot_view'),
('AppPilotView', 'app_pilot_view'),
('AppRetrieveEdit', 'app_retrieve_create'),
('AppRetrieveFull', 'app_retrieve_create'),
('AppRetrieveEdit', 'app_retrieve_delete'),
('AppRetrieveFull', 'app_retrieve_delete'),
('AppRetrieveFull', 'app_retrieve_index'),
('AppRetrieveView', 'app_retrieve_index'),
('AppRetrieveEdit', 'app_retrieve_update'),
('AppRetrieveFull', 'app_retrieve_update'),
('AppRetrieveFull', 'app_retrieve_view'),
('AppRetrieveView', 'app_retrieve_view'),
('AppTowplaneEdit', 'app_towplane_create'),
('AppTowplaneFull', 'app_towplane_create'),
('AppTowplaneEdit', 'app_towplane_delete'),
('AppTowplaneFull', 'app_towplane_delete'),
('AppTowplaneFull', 'app_towplane_index'),
('AppTowplaneView', 'app_towplane_index'),
('AppTowplaneEdit', 'app_towplane_update'),
('AppTowplaneFull', 'app_towplane_update'),
('AppTowplaneFull', 'app_towplane_view'),
('AppTowplaneView', 'app_towplane_view'),
('AppTransactionEdit', 'app_transaction_create'),
('AppTransactionFull', 'app_transaction_create'),
('AppTransactionEdit', 'app_transaction_delete'),
('AppTransactionFull', 'app_transaction_delete'),
('AppTransactionFull', 'app_transaction_index'),
('AppTransactionView', 'app_transaction_index'),
('AppTransactionEdit', 'app_transaction_update'),
('AppTransactionFull', 'app_transaction_update'),
('AppTransactionFull', 'app_transaction_view'),
('AppTransactionView', 'app_transaction_view'),
('AppTransactionTypeEdit', 'app_transaction-type_create'),
('AppTransactionTypeFull', 'app_transaction-type_create'),
('AppTransactionTypeEdit', 'app_transaction-type_delete'),
('AppTransactionTypeFull', 'app_transaction-type_delete'),
('AppTransactionTypeFull', 'app_transaction-type_index'),
('AppTransactionTypeView', 'app_transaction-type_index'),
('AppTransactionTypeEdit', 'app_transaction-type_update'),
('AppTransactionTypeFull', 'app_transaction-type_update'),
('AppTransactionTypeFull', 'app_transaction-type_view'),
('AppTransactionTypeView', 'app_transaction-type_view'),
('Administrator', 'AppClubFull'),
('ViewOnly', 'AppClubView'),
('Administrator', 'AppContestFull'),
('ViewOnly', 'AppContestView'),
('Administrator', 'AppDefaultTypeFull'),
('Administrator', 'AppLandoutFull'),
('ViewOnly', 'AppLandoutView'),
('Administrator', 'AppLaunchFull'),
('ViewOnly', 'AppLaunchView'),
('Administrator', 'AppPilotFull'),
('Administrator', 'AppRetrieveFull'),
('ViewOnly', 'AppRetrieveView'),
('Administrator', 'AppTowplaneFull'),
('Administrator', 'AppTransactionFull'),
('Administrator', 'AppTransactionTypeFull');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Club Name',
  `address1` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Address Line 1',
  `address2` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 2',
  `address3` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 3',
  `postcode` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Post Code',
  `telephone` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Telephone',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

DROP TABLE IF EXISTS `contests`;
CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `gnz_id` int(11) DEFAULT NULL COMMENT 'GNZ Contest ID',
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Contest Name',
  `start` date NOT NULL COMMENT 'Start Date',
  `end` date NOT NULL COMMENT 'End Date',
  `igcfiles` varchar(12) COLLATE utf8mb4_bin NOT NULL COMMENT 'IGC Uploads Directory',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `club` (`club_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `defaultTypes`
--

DROP TABLE IF EXISTS `defaultTypes`;
CREATE TABLE IF NOT EXISTS `defaultTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(12) COLLATE utf8mb4_bin NOT NULL COMMENT 'Short Name',
  `description` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Item Description',
  `price` decimal(8,2) DEFAULT NULL COMMENT 'Usual Price',
  `credit` enum('Debit','Credit') COLLATE utf8mb4_bin NOT NULL COMMENT 'Debit or Credit Item',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `defaultTypes`
--

INSERT INTO `defaultTypes` (`id`, `name`, `description`, `price`, `credit`) VALUES
(1, 'LAUNCH', 'Contest Launch', '65.00', 'Debit'),
(2, 'RETRIEVE', 'Aero Tow Retrieve', '0.00', 'Debit'),
(3, 'EFTPOS', 'EFT Payment Received - Thankyou', '0.00', 'Credit'),
(4, 'CREDIT', 'Credit Card Payment Received - Thankyou', '0.00', 'Credit'),
(5, 'DIRECT', 'Direct Credit Payment Received - Thankyou', '0.00', 'Credit'),
(6, 'ENTRY', 'Contest Entry Fee', '220.00', 'Debit'),
(7, 'EARLY', 'Contest Early Entry Discount', '-40.00', 'Credit'),
(8, 'BFAST', 'Kitchen - Breakfast', '10.00', 'Debit'),
(9, 'LUNCH', 'Kitchen - Lunch', '10.00', 'Debit'),
(10, 'DINNER', 'Kitchen - Dinner', '25.00', 'Debit'),
(11, 'CAMP', 'Camp Site', '10.00', 'Debit'),
(12, 'BUNK', 'Bunk House', '15.00', 'Debit'),
(13, 'INTERNET', 'Internet Access', '10.00', 'Debit');

-- --------------------------------------------------------

--
-- Table structure for table `landouts`
--

DROP TABLE IF EXISTS `landouts`;
CREATE TABLE IF NOT EXISTS `landouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Land Out',
  `pilot_id` int(11) NOT NULL COMMENT 'Pilot',
  `date` date NOT NULL COMMENT 'Landout Date',
  `landed_at` time NOT NULL COMMENT 'Landout Time',
  `departed_at` time DEFAULT NULL COMMENT 'Crew Departed At',
  `returned_at` time DEFAULT NULL COMMENT 'Pilot Returned At',
  `lat` decimal(12,8) DEFAULT NULL COMMENT 'Latitude',
  `lng` decimal(12,8) DEFAULT NULL COMMENT 'Longitude',
  `address` tinytext COLLATE utf8mb4_bin COMMENT 'Address',
  `trailer` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Trailer Details',
  `plate` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Car Plate',
  `crew` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Crew Name',
  `crew_phone` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Crew Phone',
  `notes` tinytext COLLATE utf8mb4_bin COMMENT 'Notes',
  `status` enum('Awaiting Crew','Crew Departed','Returned') COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Status',
  PRIMARY KEY (`id`),
  KEY `pilot_id` (`pilot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `launches`
--

DROP TABLE IF EXISTS `launches`;
CREATE TABLE IF NOT EXISTS `launches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `towplane_id` int(11) NOT NULL COMMENT 'Towplane',
  `pilot_id` int(11) NOT NULL COMMENT 'Glider',
  `date` date NOT NULL COMMENT 'Launch Date',
  `transaction_id` int(11) DEFAULT NULL COMMENT 'Account Transaction ID',
  PRIMARY KEY (`id`),
  KEY `towplane_id` (`towplane_id`),
  KEY `pilot_id` (`pilot_id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('Da\\User\\Migration\\m000000_000001_create_user_table', 1601097150),
('Da\\User\\Migration\\m000000_000002_create_profile_table', 1601097150),
('Da\\User\\Migration\\m000000_000003_create_social_account_table', 1601097150),
('Da\\User\\Migration\\m000000_000004_create_token_table', 1601097150),
('Da\\User\\Migration\\m000000_000005_add_last_login_at', 1601097151),
('Da\\User\\Migration\\m000000_000006_add_two_factor_fields', 1601097151),
('Da\\User\\Migration\\m000000_000007_enable_password_expiration', 1601097151),
('Da\\User\\Migration\\m000000_000008_add_last_login_ip', 1601097151),
('Da\\User\\Migration\\m000000_000009_add_gdpr_consent_fields', 1601097151),
('m000000_000000_base', 1601097139),
('m140506_102106_rbac_init', 1601097151),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1601097151),
('m180523_151638_rbac_updates_indexes_without_prefix', 1601097151),
('m200409_110543_rbac_update_mssql_trigger', 1601097151),
('m201010_041900_Pilot_access', 1602304300),
('m201010_042500_TransactionType_access', 1602304300),
('m201010_042600_Club_access', 1602304300),
('m201010_042700_Contest_access', 1602304300),
('m201010_042700_Launch_access', 1602304300),
('m201010_042700_Retrieve_access', 1602304301),
('m201010_042800_Towplane_access', 1602304301),
('m201010_042900_Transaction_access', 1602304301),
('m201018_002700_Price_access', 1602980834),
('m201018_065000_DefaultType_access', 1603003850),
('m201022_065900_Landout_access', 1603350260);

-- --------------------------------------------------------

--
-- Table structure for table `pilots`
--

DROP TABLE IF EXISTS `pilots`;
CREATE TABLE IF NOT EXISTS `pilots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `gnz_id` int(11) DEFAULT NULL COMMENT 'GNZ Pilot ID',
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Name',
  `address1` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Address Line 1',
  `address2` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 2',
  `address3` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 3',
  `postcode` varchar(12) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Post Code',
  `telephone` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Telephone',
  `rego` varchar(6) COLLATE utf8mb4_bin NOT NULL COMMENT 'Glider Registration',
  `rego_short` varchar(2) COLLATE utf8mb4_bin NOT NULL COMMENT 'Glider Contest ID',
  `entry_date` datetime NOT NULL COMMENT 'Entry Date',
  `trailer` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Car & Trailer',
  `plate` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Car Plate',
  `crew` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Crew Name',
  `crew_phone` varchar(16) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Crew Phone',
  PRIMARY KEY (`id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `club_id` int(11) DEFAULT NULL COMMENT 'Default Club',
  `contest_id` int(11) DEFAULT NULL COMMENT 'Default Contest',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `timezone`, `bio`, `club_id`, `contest_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `retrieves`
--

DROP TABLE IF EXISTS `retrieves`;
CREATE TABLE IF NOT EXISTS `retrieves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `towplane_id` int(11) NOT NULL COMMENT 'Towplane',
  `pilot_id` int(11) NOT NULL COMMENT 'Glider',
  `date` date NOT NULL COMMENT 'Retrieve Date',
  `duration` int(11) NOT NULL COMMENT 'Retrive Duration',
  `price` decimal(6,2) NOT NULL COMMENT 'Retrieve Cost',
  `transaction_id` int(11) DEFAULT NULL COMMENT 'Transaction',
  PRIMARY KEY (`id`),
  KEY `towplane_id` (`towplane_id`),
  KEY `pilot_id` (`pilot_id`) USING BTREE,
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
CREATE TABLE IF NOT EXISTS `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
  UNIQUE KEY `idx_social_account_code` (`code`),
  KEY `fk_social_account_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL,
  UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `towplanes`
--

DROP TABLE IF EXISTS `towplanes`;
CREATE TABLE IF NOT EXISTS `towplanes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL COMMENT 'Contest',
  `rego` varchar(3) COLLATE utf8mb4_bin NOT NULL COMMENT 'Towplane Registration',
  `description` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Description',
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Name',
  `address1` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Address Line 1',
  `address2` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 2',
  `address3` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Address Line 3',
  `postcode` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Post Code',
  `telephone` varchar(12) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Phone',
  PRIMARY KEY (`id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pilot_id` int(11) NOT NULL COMMENT 'Pilot',
  `type_id` int(11) NOT NULL COMMENT 'Transaction Type',
  `details` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Details',
  `amount` decimal(8,2) NOT NULL COMMENT 'Amount',
  `date` date NOT NULL COMMENT 'Date',
  PRIMARY KEY (`id`),
  KEY `pilot_id` (`pilot_id`),
  KEY `type_id` (`type_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `transactionTypes`
--

DROP TABLE IF EXISTS `transactionTypes`;
CREATE TABLE IF NOT EXISTS `transactionTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL COMMENT 'Contest',
  `name` varchar(12) COLLATE utf8mb4_bin NOT NULL COMMENT 'Short Name',
  `description` varchar(80) COLLATE utf8mb4_bin NOT NULL COMMENT 'Item Description',
  `price` decimal(8,2) DEFAULT NULL COMMENT 'Usual Price',
  `credit` enum('Debit','Credit') COLLATE utf8mb4_bin NOT NULL COMMENT 'Debit or Credit Item',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `confirmed_at` int(11) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_key` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_enabled` tinyint(1) DEFAULT '0',
  `password_changed_at` int(11) DEFAULT NULL,
  `gdpr_consent` tinyint(1) DEFAULT '0',
  `gdpr_consent_date` int(11) DEFAULT NULL,
  `gdpr_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_username` (`username`),
  UNIQUE KEY `idx_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `unconfirmed_email`, `registration_ip`, `flags`, `confirmed_at`, `blocked_at`, `updated_at`, `created_at`, `last_login_at`, `last_login_ip`, `auth_tf_key`, `auth_tf_enabled`, `password_changed_at`, `gdpr_consent`, `gdpr_consent_date`, `gdpr_deleted`) VALUES
(1, 'admin', 'admin@localhost.com', '$2y$10$/dKgRuvcLp9XUon2m3Y2j.hR4ROI9V4avtbosjkDru/KmSv0SsiNW', '-RSinOixXZ4o7o0TSx9uyKA5-m5tM88t', NULL, '::1', 0, 1601097191, NULL, 1601097191, 1601097191, 1603961753, '::1', '', 0, 1601097191, 0, NULL, 0),
(5, 'rob', 'info@lymac.co.nz', '$2y$10$R/wIDQ2xHxA3imDHFTK/iOKo6XmL/.G00fgfno.jSdE9hhjDFgO3a', '55-rIyHaK7q0PupDy2tgYw_GfNL_cx2i', NULL, '::1', 0, 1603864051, NULL, 1603864051, 1603864051, 1603864104, '::1', '', 0, 1603864051, 0, NULL, 0),
(6, 'joe', 'joe@soap.com', '$2y$10$M/3jVnk/yLYi9RKDf0ga..3LK363qBmixH7gQSOT.EFyj12ZU.Ree', 'wpXnJSuFWbwHs4pD6WsCc7wHE9qw8i_6', NULL, '::1', 0, 1603864423, NULL, 1603864423, 1603864423, NULL, NULL, '', 0, 1603864423, 0, NULL, 0),
(7, 'Taupo', 'infor@taupoglidingclub.co.nz', '$2y$10$CjpHrWG.cJzFm3I8pviRPuzAycdSJ1t0YmdKfDwSuAZk4C2X0goEC', 'n7MnZOLDD9j0lUUR60pTDLXKg62qF4YT', NULL, '::1', 0, 1603960314, NULL, 1603960314, 1603960314, 1603960414, '::1', '', 0, 1603960314, 0, NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contests`
--
ALTER TABLE `contests`
  ADD CONSTRAINT `contests_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`);

--
-- Constraints for table `landouts`
--
ALTER TABLE `landouts`
  ADD CONSTRAINT `landouts_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`);

--
-- Constraints for table `launches`
--
ALTER TABLE `launches`
  ADD CONSTRAINT `launches_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`),
  ADD CONSTRAINT `launches_ibfk_2` FOREIGN KEY (`towplane_id`) REFERENCES `towplanes` (`id`),
  ADD CONSTRAINT `launches_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pilots`
--
ALTER TABLE `pilots`
  ADD CONSTRAINT `pilots_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `retrieves`
--
ALTER TABLE `retrieves`
  ADD CONSTRAINT `retrieves_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`),
  ADD CONSTRAINT `retrieves_ibfk_2` FOREIGN KEY (`towplane_id`) REFERENCES `towplanes` (`id`),
  ADD CONSTRAINT `retrieves_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `towplanes`
--
ALTER TABLE `towplanes`
  ADD CONSTRAINT `towplanes_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `transactionTypes` (`id`);

--
-- Constraints for table `transactionTypes`
--
ALTER TABLE `transactionTypes`
  ADD CONSTRAINT `transactiontypes_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
