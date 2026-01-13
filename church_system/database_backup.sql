-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 01:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `church_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:9:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:9:\"tenant_id\";s:1:\"c\";s:7:\"user_id\";s:1:\"d\";s:4:\"name\";s:1:\"e\";s:10:\"guard_name\";s:1:\"f\";s:6:\"module\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:5:\"title\";s:1:\"k\";s:11:\"description\";}s:11:\"permissions\";a:65:{i:0;a:7:{s:1:\"a\";i:1;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:10:\"view users\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:7:{s:1:\"a\";i:2;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"create users\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:7:{s:1:\"a\";i:3;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"update users\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:7:{s:1:\"a\";i:4;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"delete users\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:7:{s:1:\"a\";i:5;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:10:\"view roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:7:{s:1:\"a\";i:6;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"create roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:7:{s:1:\"a\";i:7;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"update roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:7:{s:1:\"a\";i:8;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"delete roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:7:{s:1:\"a\";i:9;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:16:\"view permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:7:{s:1:\"a\";i:10;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"create permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:7:{s:1:\"a\";i:11;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"update permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:7:{s:1:\"a\";i:12;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"delete permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:7:{s:1:\"a\";i:13;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"view tenants\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Tenants\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:7:{s:1:\"a\";i:14;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"create tenants\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Tenants\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:7:{s:1:\"a\";i:15;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"update tenants\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Tenants\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:7:{s:1:\"a\";i:16;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"delete tenants\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Tenants\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:7:{s:1:\"a\";i:17;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:19:\"view main dashboard\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:9:\"Dashboard\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:7:{s:1:\"a\";i:18;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:21:\"view tenant dashboard\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:9:\"Dashboard\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:7:{s:1:\"a\";i:19;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"manage users\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Users\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:7:{s:1:\"a\";i:20;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"assign roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:7:{s:1:\"a\";i:21;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"assign permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:7:{s:1:\"a\";i:22;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"manage roles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:5:\"Roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:7:{s:1:\"a\";i:23;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"manage permissions\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:7:{s:1:\"a\";i:24;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:11:\"view church\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Church\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:7:{s:1:\"a\";i:25;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:11:\"edit church\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Church\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:7:{s:1:\"a\";i:26;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"manage church\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Church\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:7:{s:1:\"a\";i:27;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"view members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:7:{s:1:\"a\";i:28;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"create members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:7:{s:1:\"a\";i:29;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"update members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:7:{s:1:\"a\";i:30;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"delete members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:7:{s:1:\"a\";i:31;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"manage members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:31;a:7:{s:1:\"a\";i:32;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:20:\"assign roles members\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Members\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:7:{s:1:\"a\";i:33;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:11:\"view events\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Events\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:7:{s:1:\"a\";i:34;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"create events\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Events\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:7:{s:1:\"a\";i:35;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"update events\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Events\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:35;a:7:{s:1:\"a\";i:36;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"delete events\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Events\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:36;a:7:{s:1:\"a\";i:37;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"manage events\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:6:\"Events\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:7:{s:1:\"a\";i:38;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"view announcements\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:13:\"Announcements\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:38;a:7:{s:1:\"a\";i:39;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:20:\"create announcements\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:13:\"Announcements\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:7:{s:1:\"a\";i:40;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:20:\"update announcements\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:13:\"Announcements\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:40;a:7:{s:1:\"a\";i:41;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:20:\"delete announcements\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:13:\"Announcements\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:41;a:7:{s:1:\"a\";i:42;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"view reports\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Reports\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:7:{s:1:\"a\";i:43;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:16:\"generate reports\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Reports\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:43;a:7:{s:1:\"a\";i:44;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"view finance\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Finance\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:44;a:7:{s:1:\"a\";i:45;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"record finance\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Finance\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:45;a:7:{s:1:\"a\";i:46;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"manage finance\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Finance\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:46;a:7:{s:1:\"a\";i:47;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:12:\"view profile\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Profile\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:7:{s:1:\"a\";i:48;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"update profile\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Profile\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:7:{s:1:\"a\";i:49;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:23:\"change password profile\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Profile\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:7:{s:1:\"a\";i:50;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:14:\"manage profile\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:7:\"Profile\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:7:{s:1:\"a\";i:51;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"view settings\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:8:\"Settings\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:51;a:7:{s:1:\"a\";i:52;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:15:\"update settings\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:8:\"Settings\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:52;a:7:{s:1:\"a\";i:53;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"view profiles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:8:\"Profiles\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:53;a:7:{s:1:\"a\";i:54;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:15:\"update profiles\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:8:\"Profiles\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:54;a:7:{s:1:\"a\";i:55;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:21:\"view church dashboard\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:9:\"Dashboard\";s:1:\"r\";a:1:{i:0;i:2;}}i:55;a:7:{s:1:\"a\";i:56;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:16:\"manage dashboard\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:9:\"Dashboard\";s:1:\"r\";a:1:{i:0;i:2;}}i:56;a:7:{s:1:\"a\";i:57;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:16:\"view departments\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Departments\";s:1:\"r\";a:1:{i:0;i:2;}}i:57;a:7:{s:1:\"a\";i:58;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"create departments\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Departments\";s:1:\"r\";a:1:{i:0;i:2;}}i:58;a:7:{s:1:\"a\";i:59;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"update departments\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Departments\";s:1:\"r\";a:1:{i:0;i:2;}}i:59;a:7:{s:1:\"a\";i:60;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"delete departments\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Departments\";s:1:\"r\";a:1:{i:0;i:2;}}i:60;a:7:{s:1:\"a\";i:61;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:18:\"manage departments\";s:1:\"e\";s:3:\"web\";s:1:\"f\";s:11:\"Departments\";s:1:\"r\";a:1:{i:0;i:2;}}i:61;a:7:{s:1:\"a\";i:62;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"create member\";s:1:\"e\";s:3:\"web\";s:1:\"f\";N;s:1:\"r\";a:1:{i:0;i:5;}}i:62;a:7:{s:1:\"a\";i:63;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"update member\";s:1:\"e\";s:3:\"web\";s:1:\"f\";N;s:1:\"r\";a:1:{i:0;i:5;}}i:63;a:7:{s:1:\"a\";i:64;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"delete member\";s:1:\"e\";s:3:\"web\";s:1:\"f\";N;s:1:\"r\";a:1:{i:0;i:5;}}i:64;a:7:{s:1:\"a\";i:65;s:1:\"b\";N;s:1:\"c\";N;s:1:\"d\";s:13:\"manage member\";s:1:\"e\";s:3:\"web\";s:1:\"f\";N;s:1:\"r\";a:1:{i:0;i:5;}}}s:5:\"roles\";a:4:{i:0;a:7:{s:1:\"a\";i:1;s:1:\"b\";N;s:1:\"c\";N;s:1:\"j\";s:20:\"System Administrator\";s:1:\"k\";s:48:\"Full access to all system features and settings.\";s:1:\"d\";s:11:\"super-admin\";s:1:\"e\";s:3:\"web\";}i:1;a:7:{s:1:\"a\";i:2;s:1:\"b\";N;s:1:\"c\";N;s:1:\"j\";s:21:\"Church Administrator \";s:1:\"k\";s:29:\"Manage all church oparations.\";s:1:\"d\";s:12:\"church-admin\";s:1:\"e\";s:3:\"web\";}i:2;a:7:{s:1:\"a\";i:4;s:1:\"b\";i:1;s:1:\"c\";N;s:1:\"j\";s:16:\"Church Treasurer\";s:1:\"k\";s:57:\"Manages church finances, tithes, offerings, and expenses.\";s:1:\"d\";s:16:\"church-treasurer\";s:1:\"e\";s:3:\"web\";}i:3;a:7:{s:1:\"a\";i:5;s:1:\"b\";i:1;s:1:\"c\";N;s:1:\"j\";s:11:\"Church Lead\";s:1:\"k\";s:63:\"Manages all human resources, member records, and pastoral care.\";s:1:\"d\";s:11:\"church-lead\";s:1:\"e\";s:3:\"web\";}}}', 1766577698);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `leader_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `tenant_id`, `name`, `description`, `status`, `leader_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Eagle  Department', 'Married men group. They met every third  Sunday if the month', 'Active', NULL, 7, NULL, '2025-11-25 09:59:31', '2025-11-25 09:59:31', NULL),
(2, 1, 'Daught Of Faith Department', 'DOF is a ladies Group, from the age of 18years and above. They met every second church of the month.', 'Active', NULL, 7, NULL, '2025-11-25 10:02:09', '2025-11-25 10:02:09', NULL),
(3, 1, 'AGAPE Department', 'Its a youth group. They met every first Sunday of the month', 'Active', NULL, 7, NULL, '2025-11-25 10:24:08', '2025-11-25 10:24:08', NULL),
(4, 1, 'Children Mininistry Department', 'Its a children ministry department.Sunday school classes are  available in both services', 'Active', NULL, 7, NULL, '2025-11-25 10:25:06', '2025-11-25 10:25:06', NULL),
(5, 1, 'Media Team Department ', 'Media team .', 'Active', NULL, 7, NULL, '2025-11-25 10:25:43', '2025-11-25 10:25:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `payment_method` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `donor_name` varchar(255) DEFAULT NULL,
  `donor_contact` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `capacity` int(10) UNSIGNED DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `created_by`, `updated_by`, `tenant_id`, `name`, `slug`, `description`, `location`, `start_at`, `end_at`, `capacity`, `is_public`, `metadata`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 7, NULL, 1, 'Children End of Year Party', 'children-end-of-year-party-1764582415', 'This is  children ministry end of year party. All children has be provided for lunch. All teachers will be available too. The party starts at 10 am till 6 pm . Parents are to drop their children in then church and later pick them up too.', 'Santuary', '2025-12-06 07:00:00', '2025-12-06 15:00:00', 250, 1, NULL, '2025-12-01 06:46:55', '2025-12-01 06:46:55', NULL),
(2, 7, NULL, 1, 'Youths End of Year Bash ', 'youths-end-of-year-bash-1764583654', 'The youth end-of-year celebration unfolded as an all-night gathering in the church hall, blending worship, fellowship, and entertainment. The evening opened with a lively praise session and a short reflection on gratitude for the year. Afterwards, the group enjoyed team games, talent presentations, and interactive discussions that encouraged bonding and personal sharing. A midnight prayer segment marked the transition into the new year, followed by a communal meal and light refreshments. Music, relaxed conversations, and quiet devotion periods carried the group through the early hours, creating a warm, spiritually uplifting, and memorable close to the year.', 'Santuary', '2025-12-06 17:00:00', '2025-12-07 02:00:00', 100, 1, NULL, '2025-12-01 07:07:34', '2025-12-01 07:07:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event__members`
--

CREATE TABLE `event__members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `invited` tinyint(1) NOT NULL DEFAULT 0,
  `invited_at` timestamp NULL DEFAULT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT 0,
  `notified_at` timestamp NULL DEFAULT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  `attended_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `expense_number` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_category_id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `paid_to` varchar(200) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by_2` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `receipt_available` tinyint(1) NOT NULL DEFAULT 0,
  `receipt_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','paid','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `tenant_id`, `expense_date`, `expense_number`, `amount`, `expense_category_id`, `description`, `paid_to`, `payment_method`, `reference_number`, `approved_by`, `approved_by_2`, `approved_at`, `receipt_available`, `receipt_path`, `status`, `notes`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-12-05', 'EXP-2025-0001', 2000.00, 4, '3 Toilet cleaner harpic 1 litre ,1 cartoon of toilet paper', 'Cleanshelve supermarket', 'cash', '1234KTN', 13, NULL, '2025-12-23 14:53:14', 1, NULL, 'approved', 'Nick purchased the cleaning supplies', 7, 13, '2025-12-05 13:31:47', '2025-12-23 14:53:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `tenant_id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Food & Refreshments', 'Sunday tea, bread, milk for pastoral team', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(2, 1, 'Utilities', 'Water, electricity, internet bills', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(3, 1, 'Salaries', 'Watch lady, watch man, staff salaries', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(4, 1, 'Cleaning Supplies', 'Detergents, brooms, cleaning materials', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(5, 1, 'Maintenance', 'Church building repairs and maintenance', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(6, 1, 'Transport', 'Pastor travel, fuel, transport costs', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(7, 1, 'Hospitality', 'Guest accommodation, meals', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(8, 1, 'Equipment', 'Sound system, musical instruments', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(9, 1, 'Office Supplies', 'Stationery, printing, office materials', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(10, 1, 'Loan Repayment', 'Church loan repayments', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(11, 1, 'Pastor Appreciation', 'Tokens of appreciation for pastor', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(12, 1, 'Outreach', 'Community outreach programs', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(13, 1, 'Conference & Seminars', 'Church conferences and seminars', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(14, 1, 'Insurance', 'Church property insurance', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49'),
(15, 1, 'Miscellaneous', 'Other unclassified expenses', 1, '2025-12-05 13:25:49', '2025-12-05 13:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `leader_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group__members`
--

CREATE TABLE `group__members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT NULL,
  `left_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(7, 'default', '{\"uuid\":\"ee0fc3bc-7c2e-4856-9ff3-5ae7815388ba\",\"displayName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\SendOtpSmsJob\\\":2:{s:8:\\\"\\u0000*\\u0000phone\\\";s:10:\\\"0700222333\\\";s:7:\\\"\\u0000*\\u0000code\\\";s:6:\\\"971744\\\";}\"},\"createdAt\":1765883195,\"delay\":null}', 0, NULL, 1765883195, 1765883195),
(8, 'default', '{\"uuid\":\"40c9edf7-2eee-4cc1-9297-03145e82b9f9\",\"displayName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\SendOtpSmsJob\\\":2:{s:8:\\\"\\u0000*\\u0000phone\\\";s:10:\\\"0700999888\\\";s:7:\\\"\\u0000*\\u0000code\\\";s:6:\\\"429649\\\";}\"},\"createdAt\":1765883645,\"delay\":null}', 0, NULL, 1765883645, 1765883645),
(9, 'default', '{\"uuid\":\"29d28873-00e1-461e-ae7e-3724908dbe55\",\"displayName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOtpSmsJob\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\SendOtpSmsJob\\\":2:{s:8:\\\"\\u0000*\\u0000phone\\\";s:10:\\\"0701999888\\\";s:7:\\\"\\u0000*\\u0000code\\\";s:6:\\\"847772\\\";}\"},\"createdAt\":1765884682,\"delay\":null}', 0, NULL, 1765884682, 1765884682);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `membership_no` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `status` enum('active','inactive','visitor','transferred','deceased') NOT NULL DEFAULT 'active',
  `baptism_date` date DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `tenant_id`, `department_id`, `membership_no`, `first_name`, `last_name`, `gender`, `date_of_birth`, `phone`, `email`, `address`, `date_joined`, `status`, `baptism_date`, `confirmed_at`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, NULL, '1-001', 'Moses', 'Admin', NULL, NULL, '0722333444', 'mosesadmin@gmail.com', NULL, '2025-11-03', 'active', NULL, NULL, '2025-11-03 08:30:19', '2025-11-03 08:30:19', NULL, NULL, NULL),
(2, 1, NULL, '2', 'Joshua', 'New', 'male', '1983-02-01', '0710222333', 'joshuanew@gmail.com', 'P.O.BOX 12 THIKA', '2000-02-06', 'active', '2001-05-13', '2001-07-14 21:00:00', '2025-11-25 07:28:00', '2025-12-01 10:11:55', '2025-12-01 10:11:55', 7, NULL),
(3, 1, NULL, '1-003', 'Hadassah', 'Neema', 'female', '1994-01-10', '0720333444', 'hadassah@gmail.com', 'P.O.BOX 2 RUIRU', '2007-06-10', 'active', '2008-09-21', '2008-11-22 21:00:00', '2025-11-25 07:49:27', '2025-11-25 07:49:27', NULL, 7, NULL),
(4, 1, NULL, '1-004', 'Mirriam', 'Neema', 'female', '2002-01-06', '0799123456', 'mirriam25@gmail.com', 'P.O.BOX 12 NAIROBI', '2007-05-06', 'active', '2019-10-20', '2019-11-09 21:00:00', '2025-12-03 10:03:24', '2025-12-10 15:24:36', NULL, 7, 7),
(5, 1, NULL, '1-005', 'Adam', 'Tall', 'male', '2001-05-14', '0755444333', 'adamtall@gmail.com', 'P.O.BOX 3 Mombasa', '2010-09-12', 'inactive', '2007-09-16', '2008-01-05 21:00:00', '2025-12-15 10:42:43', '2025-12-15 10:45:49', NULL, 7, 7),
(6, 1, NULL, '1-006', 'Wilson', 'Joshua', NULL, NULL, '0700111222', 'wilson@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 10:05:45', '2025-12-16 10:05:45', NULL, 7, NULL),
(7, 1, NULL, '1-007', 'Wilson', 'Money', NULL, NULL, '0700111333', 'money@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 10:42:29', '2025-12-16 10:42:29', NULL, 7, NULL),
(8, 1, NULL, '1-008', 'Mr', 'Money', NULL, NULL, '0700111444', 'money25@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 10:48:43', '2025-12-16 10:48:43', NULL, 7, NULL),
(9, 1, NULL, '1-009', 'Test', 'Wilson', NULL, NULL, '0700222333', 'testmoney@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 11:06:35', '2025-12-16 11:06:35', NULL, 7, NULL),
(10, 1, NULL, '1-010', 'Ruth', 'Money', NULL, NULL, '0700999888', 'ruthmoney@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 11:14:04', '2025-12-16 11:14:04', NULL, 7, NULL),
(11, 1, NULL, '1-011', 'Ruth', 'Cash', NULL, NULL, '0701999888', 'cash@gmail.com', NULL, '2025-12-16', 'active', NULL, NULL, '2025-12-16 11:31:21', '2025-12-16 11:31:21', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'sms',
  `subject` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `status` enum('draft','queued','sent','failed') NOT NULL DEFAULT 'draft',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_recipients`
--

CREATE TABLE `message_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_contact` varchar(255) NOT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `delivered_at` timestamp NULL DEFAULT NULL,
  `failure_reason` varchar(255) DEFAULT NULL,
  `attempts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_02_203434_create_personal_access_tokens_table', 1),
(5, '2025_09_02_205237_create_permission_tables', 1),
(6, '2025_09_03_111744_add_phone_to_users_table', 1),
(7, '2025_09_03_121527_add_opt_token_to_users_table', 1),
(8, '2025_09_10_103039_create_otps_table', 1),
(9, '2025_09_10_111524_alter_phone_length_in_otp_table', 1),
(10, '2025_09_12_113802_tenant', 1),
(11, '2025_10_03_111950_create_members_table', 1),
(12, '2025_10_03_114226_add_member_id_to_users_table', 1),
(13, '2025_10_03_121903_create_events_table', 1),
(14, '2025_10_03_131513_create_event__members_table', 1),
(15, '2025_10_03_131849_create_donations_table', 1),
(16, '2025_10_03_132702_create_funds_table', 1),
(17, '2025_10_03_134559_create_groups_table', 1),
(18, '2025_10_03_135126_create_group__members_table', 1),
(19, '2025_10_03_135433_create_messages_table', 1),
(20, '2025_10_03_140342_create_message_recipients_table', 1),
(21, '2025_10_07_102559_add_tenant_id_to_roles_table', 1),
(22, '2025_10_07_112315_add_tenant_id_user_id_and_module_to_permissions_table', 2),
(23, '2025_10_14_110439_add_softdelete_column_in_permissions_table', 3),
(24, '2025_10_14_110523_add_softdelete_column_in_roles_table', 3),
(25, '2025_10_14_114327_modify_tenant_id_on_users_table', 4),
(26, '2025_10_14_191920_add_soft_delete_and_created_by_and_updated_by_to_users_table', 5),
(27, '2025_10_14_192231_add_soft_delete_and_created_by_and_updated_by_to_tenants_table', 6),
(28, '2025_11_03_111332_add_church_mobile_to_tenants_table', 7),
(29, '2025_11_03_112649_alter_user_id_nullable_in_tenants_table', 8),
(30, '2025_11_17_111704_change_email_verified_at_to_phone_verified_at_and_last_login_at_to_user_table', 9),
(31, '2025_11_18_103845_add_profile_photo_path_to_users_table', 10),
(32, '2025_11_18_122049_add_preferences_to_users_table', 11),
(33, '2025_11_20_133201_create_offerings_table', 12),
(34, '2025_11_25_102050_add_tracking_columns_to_members_table', 13),
(35, '2025_11_25_111350_create_departments_table', 14),
(36, '2025_11_25_111544_add_department_id_to_members_table', 14),
(37, '2025_11_26_111650_add_created_by_and_updated_by_to_events_table', 15),
(38, '2025_12_04_112429_create_sunday_collections_table', 16),
(39, '2025_12_04_114915_create_expense_categories_table', 17),
(40, '2025_12_04_113924_create_expenses_table', 18),
(41, '2025_12_17_133122_remove_role_column_from_member_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13);

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

CREATE TABLE `offerings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'offering',
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`id`, `tenant_id`, `amount`, `type`, `payment_method`, `notes`, `recorded_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 1, 9000.00, 'Offering', 'Cash', 'FIRST SERVICE OFFERING', '2025-11-29 21:00:00', NULL, NULL, '2025-12-03 10:48:20', '2025-12-03 10:48:20'),
(8, 1, 5000.00, 'Tithe', 'Mobile Money', 'first service mobile tithe.', '2025-11-29 21:00:00', 7, NULL, '2025-12-03 11:06:02', '2025-12-03 11:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(32) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `secret` varchar(64) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `phone`, `code_hash`, `secret`, `provider`, `attempts`, `used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, '0702987654', '$2y$12$klhahbHGWGAQa/62shsb7OTeO5UzW4SqNhRNfQlKVsf3pvICP0svW', 'QIApHlHvpXfPbPxj1t9z1OV7WiVuwUSe', 'fakesms', 1, '2025-10-14 17:13:09', '2025-10-14 17:17:42', '2025-10-14 17:12:42', '2025-10-14 17:13:09'),
(2, '0722333444', '$2y$12$mB/EQy5zJbA5wE4MiuGAouqclFSXqM8b3wSgZ1S.DcwUdoAuYggfO', 'wGk9btEx9i5gt1FeCggkRYKmXWa9Xy1V', 'fakesms', 1, '2025-11-03 08:32:13', '2025-11-03 08:35:20', '2025-11-03 08:30:20', '2025-11-03 08:32:13'),
(3, '0700111333', '$2y$12$44ptVDAXy/oqu8dAtpTCnuikUIb2kwPH4KBR6gB7NkMb1Hsh8WEfy', '2vQjBOjerFU0hLIJAOUtEs5nRkhUkkIB', 'fakesms', 0, NULL, '2025-12-16 10:59:49', '2025-12-16 10:54:49', '2025-12-16 10:54:49'),
(4, '0700111444', '$2y$12$muPsGfhbDvxJgcPZGbEQ8OluuZUgZk90CWxCAKDEWuvsXRGBBPvba', 'DY7mnPr1BBYRKVURdYfH5p7RuLwbGBGC', 'fakesms', 0, NULL, '2025-12-16 10:59:50', '2025-12-16 10:54:50', '2025-12-16 10:54:50'),
(5, '0700222333', '$2y$12$vz0lbElF/gHX2E8B5/XZC.bN7MnGwjOkRgqgpSI1AZGu508WKDXHe', 'pGqiLCL9krHZAJhgybsZkZNRVDBxirao', 'fakesms', 0, NULL, '2025-12-16 11:11:35', '2025-12-16 11:06:35', '2025-12-16 11:06:35'),
(6, '0700999888', '$2y$12$HBdVJipmiUWJ1KGWlJ3lWO9ugqBVF7mIq4E1drEF30ugS01CgABL.', 'XwH4K9X3ajDaoMM49WnwUdMH3C0sOLrh', 'fakesms', 1, '2025-12-16 11:15:22', '2025-12-16 11:19:05', '2025-12-16 11:14:05', '2025-12-16 11:15:22'),
(7, '0701999888', '$2y$12$QPG6RyEXRg8n5AytzKI1xOx22wMokZA9.3v1k1JkU5giOQ2fKTpky', 'njVBxZMedtNiPbvCFjVK0HWafehzUBvl', 'fakesms', 1, '2025-12-16 11:32:53', '2025-12-16 11:36:22', '2025-12-16 11:31:22', '2025-12-16 11:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `tenant_id`, `user_id`, `name`, `guard_name`, `module`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'view users', 'web', 'Users', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(2, NULL, NULL, 'create users', 'web', 'Users', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(3, NULL, NULL, 'update users', 'web', 'Users', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(4, NULL, NULL, 'delete users', 'web', 'Users', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(5, NULL, NULL, 'view roles', 'web', 'Roles', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(6, NULL, NULL, 'create roles', 'web', 'Roles', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(7, NULL, NULL, 'update roles', 'web', 'Roles', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(8, NULL, NULL, 'delete roles', 'web', 'Roles', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(9, NULL, NULL, 'view permissions', 'web', 'Permissions', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(10, NULL, NULL, 'create permissions', 'web', 'Permissions', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(11, NULL, NULL, 'update permissions', 'web', 'Permissions', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(12, NULL, NULL, 'delete permissions', 'web', 'Permissions', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(13, NULL, NULL, 'view tenants', 'web', 'Tenants', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(14, NULL, NULL, 'create tenants', 'web', 'Tenants', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(15, NULL, NULL, 'update tenants', 'web', 'Tenants', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(16, NULL, NULL, 'delete tenants', 'web', 'Tenants', '2025-10-14 08:07:03', '2025-10-14 08:07:03', NULL),
(17, NULL, NULL, 'view main dashboard', 'web', 'Dashboard', '2025-11-06 06:35:38', '2025-11-06 06:35:38', NULL),
(18, NULL, NULL, 'view tenant dashboard', 'web', 'Dashboard', '2025-11-06 06:35:38', '2025-11-06 06:35:38', NULL),
(19, NULL, NULL, 'manage users', 'web', 'Users', '2025-11-10 06:08:19', '2025-11-10 06:08:19', NULL),
(20, NULL, NULL, 'assign roles', 'web', 'Roles', '2025-11-10 06:08:20', '2025-11-10 06:08:20', NULL),
(21, NULL, NULL, 'assign permissions', 'web', 'Permissions', '2025-11-10 06:08:20', '2025-11-10 06:08:20', NULL),
(22, NULL, NULL, 'manage roles', 'web', 'Roles', '2025-11-10 10:38:34', '2025-11-10 10:38:34', NULL),
(23, NULL, NULL, 'manage permissions', 'web', 'Permissions', '2025-11-10 10:38:34', '2025-11-10 10:38:34', NULL),
(24, NULL, NULL, 'view church', 'web', 'Church', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(25, NULL, NULL, 'edit church', 'web', 'Church', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(26, NULL, NULL, 'manage church', 'web', 'Church', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(27, NULL, NULL, 'view members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(28, NULL, NULL, 'create members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(29, NULL, NULL, 'update members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(30, NULL, NULL, 'delete members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(31, NULL, NULL, 'manage members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(32, NULL, NULL, 'assign roles members', 'web', 'Members', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(33, NULL, NULL, 'view events', 'web', 'Events', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(34, NULL, NULL, 'create events', 'web', 'Events', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(35, NULL, NULL, 'update events', 'web', 'Events', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(36, NULL, NULL, 'delete events', 'web', 'Events', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(37, NULL, NULL, 'manage events', 'web', 'Events', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(38, NULL, NULL, 'view announcements', 'web', 'Announcements', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(39, NULL, NULL, 'create announcements', 'web', 'Announcements', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(40, NULL, NULL, 'update announcements', 'web', 'Announcements', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(41, NULL, NULL, 'delete announcements', 'web', 'Announcements', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(42, NULL, NULL, 'view reports', 'web', 'Reports', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(43, NULL, NULL, 'generate reports', 'web', 'Reports', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(44, NULL, NULL, 'view finance', 'web', 'Finance', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(45, NULL, NULL, 'record finance', 'web', 'Finance', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(46, NULL, NULL, 'manage finance', 'web', 'Finance', '2025-11-14 11:24:51', '2025-11-14 11:24:51', NULL),
(47, NULL, NULL, 'view profile', 'web', 'Profile', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(48, NULL, NULL, 'update profile', 'web', 'Profile', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(49, NULL, NULL, 'change password profile', 'web', 'Profile', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(50, NULL, NULL, 'manage profile', 'web', 'Profile', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(51, NULL, NULL, 'view settings', 'web', 'Settings', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(52, NULL, NULL, 'update settings', 'web', 'Settings', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(53, NULL, NULL, 'view profiles', 'web', 'Profiles', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(54, NULL, NULL, 'update profiles', 'web', 'Profiles', '2025-11-17 10:10:44', '2025-11-17 10:10:44', NULL),
(55, NULL, NULL, 'view church dashboard', 'web', 'Dashboard', '2025-11-19 09:55:09', '2025-11-19 09:55:09', NULL),
(56, NULL, NULL, 'manage dashboard', 'web', 'Dashboard', '2025-11-19 09:55:09', '2025-11-19 09:55:09', NULL),
(57, NULL, NULL, 'view departments', 'web', 'Departments', '2025-11-25 08:30:05', '2025-11-25 08:30:05', NULL),
(58, NULL, NULL, 'create departments', 'web', 'Departments', '2025-11-25 08:30:05', '2025-11-25 08:30:05', NULL),
(59, NULL, NULL, 'update departments', 'web', 'Departments', '2025-11-25 08:30:05', '2025-11-25 08:30:05', NULL),
(60, NULL, NULL, 'delete departments', 'web', 'Departments', '2025-11-25 08:30:05', '2025-11-25 08:30:05', NULL),
(61, NULL, NULL, 'manage departments', 'web', 'Departments', '2025-11-25 08:30:05', '2025-11-25 08:30:05', NULL),
(62, NULL, NULL, 'create member', 'web', NULL, '2025-12-15 12:13:58', '2025-12-15 12:13:58', NULL),
(63, NULL, NULL, 'update member', 'web', NULL, '2025-12-15 12:13:58', '2025-12-15 12:13:58', NULL),
(64, NULL, NULL, 'delete member', 'web', NULL, '2025-12-15 12:13:58', '2025-12-15 12:13:58', NULL),
(65, NULL, NULL, 'manage member', 'web', NULL, '2025-12-15 12:13:58', '2025-12-15 12:13:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `tenant_id`, `user_id`, `title`, `description`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'System Administrator', 'Full access to all system features and settings.', 'super-admin', 'web', '2025-10-14 08:31:16', '2025-10-14 08:31:16', NULL),
(2, NULL, NULL, 'Church Administrator ', 'Manage all church oparations.', 'church-admin', 'web', '2025-10-20 08:49:33', '2025-10-20 08:49:33', NULL),
(4, 1, NULL, 'Church Treasurer', 'Manages church finances, tithes, offerings, and expenses.', 'church-treasurer', 'web', '2025-12-15 11:53:07', '2025-12-15 11:53:07', NULL),
(5, 1, NULL, 'Church Lead', 'Manages all human resources, member records, and pastoral care.', 'church-lead', 'web', '2025-12-15 11:53:07', '2025-12-15 11:53:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(17, 2),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(44, 4),
(45, 1),
(45, 2),
(45, 4),
(46, 1),
(46, 2),
(46, 4),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 5),
(63, 5),
(64, 5),
(65, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fyNrnvV6cZYv3Eayl8MOJGfbT5McRSPc1ZzxKMOp', 702987654, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR0ZRWkVac2g5aTN0cEtnUnNBdUt6a0tyZWJUT1hZN3BmRmlGS211dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjEwOiIwNzAyOTg3NjU0Ijt9', 1762179872);

-- --------------------------------------------------------

--
-- Table structure for table `sunday_collections`
--

CREATE TABLE `sunday_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED NOT NULL,
  `collection_date` date NOT NULL,
  `first_service_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `second_service_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `children_service_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mobile_mpesa_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `counted_by` varchar(100) NOT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_by_2` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_deposit_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bank_deposit_date` date DEFAULT NULL,
  `bank_slip_number` varchar(50) DEFAULT NULL,
  `status` enum('pending','counted','verified','banked','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sunday_collections`
--

INSERT INTO `sunday_collections` (`id`, `tenant_id`, `collection_date`, `first_service_amount`, `second_service_amount`, `children_service_amount`, `mobile_mpesa_amount`, `total_amount`, `counted_by`, `verified_by`, `verified_by_2`, `bank_deposit_amount`, `bank_deposit_date`, `bank_slip_number`, `status`, `notes`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-12-04', 20000.00, 0.00, 3000.00, 4000.00, 27000.00, 'Wilson', 13, NULL, 27000.00, '2025-12-17', '', 'banked', 'Thanksgiving Sunday', 7, 13, '2025-12-04 11:42:17', '2025-12-17 13:56:54', NULL),
(2, 1, '2025-12-14', 8000.00, 5000.00, 3500.00, 4000.00, 20500.00, 'Ruth', 13, NULL, 20500.00, '2025-12-17', 'COP-123', 'banked', 'Glory to God', 13, 13, '2025-12-18 09:26:10', '2025-12-18 09:44:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `church_name` varchar(255) NOT NULL,
  `church_mobile` varchar(20) DEFAULT NULL,
  `chuech_mobile` varchar(255) DEFAULT NULL,
  `church_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `logo_image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `vat_pin` varchar(255) DEFAULT NULL,
  `kra_pin` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `user_id`, `church_name`, `church_mobile`, `chuech_mobile`, `church_email`, `address`, `logo_image`, `location`, `website`, `vat_pin`, `kra_pin`, `domain`, `is_active`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, 7, 'Deliverance church kahawa wendani', '0709888777', NULL, 'deliverancekahawawendani@gmail.com', 'P.O.BOX 123 00100 NAIROBI', NULL, 'KAHAWA WENDANI', 'https://deliverancekahawawendani.org', '102030340', 'A09845671', 'delivarancekahawawendi.org', 1, '2025-11-03 08:30:19', '2025-11-03 09:59:04', 702987654, 702987654, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferences`)),
  `otp_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `tenant_id`, `member_id`, `first_name`, `last_name`, `email`, `profile_photo_path`, `phone`, `phone_verified_at`, `password`, `last_login_at`, `remember_token`, `preferences`, `otp_token`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(2, NULL, NULL, 'System', 'Administrator', 'superadmin@churchapp.com', NULL, '+254704248752', NULL, '$2y$12$8osWe4vziChOrubCjBKZuuTQjBG2SQGCLxc/cNrRctK3n5PuFmnci', NULL, NULL, NULL, 'E80MO0', '2025-10-14 09:16:36', '2025-10-14 09:16:36', NULL, NULL, NULL),
(6, NULL, NULL, 'Hellen', 'Admin', 'adminhellen@gmail.com', 'profile-photos/A8EiLumFW8kJKMovfXniotiTbrC86bQkpuOw48Xa.jpg', '0702987654', NULL, '$2y$12$BRIyN4KPR9.nl3vcH1vHVevxsjgT/OaC5XBsqoia/7WMGf/rIZMqS', '2025-11-19 09:20:12', NULL, '{\"theme\":\"light\",\"notifications_enabled\":true}', '193402', '2025-10-14 17:12:40', '2025-11-19 09:20:12', NULL, 6, NULL),
(7, 1, NULL, 'Moses', 'Admin', 'mosesadmin@gmail.com', NULL, '0722333444', NULL, '$2y$12$QRidb1hfuKuIh1McuQW7POcE1.i13KC.rZX4nsjC/5dBcUXml/Rw.', '2025-12-16 11:29:51', NULL, NULL, '294230', '2025-11-03 08:30:19', '2025-12-16 11:29:51', 702987654, 7, NULL),
(8, 1, 6, 'Wilson', 'Joshua', 'wilson@gmail.com', NULL, '0700111222', NULL, '$2y$12$PEYJxV7sJqhkm/npUN.7we5aLvGnaUdDtF.nqWUZHkvVuelccAtIi', NULL, NULL, NULL, NULL, '2025-12-16 10:05:46', '2025-12-16 10:05:46', 722333444, NULL, NULL),
(9, 1, 7, 'Wilson', 'Money', 'money@gmail.com', NULL, '0700111333', NULL, '$2y$12$1FuzApjUgFSaMEDCkJ8YA..5ZS5SYdGFa3sY.9pgccGj6H3cmBL9K', NULL, NULL, NULL, NULL, '2025-12-16 10:42:30', '2025-12-16 10:42:30', 722333444, NULL, NULL),
(10, 1, 8, 'Mr', 'Money', 'money25@gmail.com', NULL, '0700111444', NULL, '$2y$12$r24YD8WoidutckVHAwkbxuucONzCzwxJulup2dqjZPXpdblkBAP1W', NULL, NULL, NULL, NULL, '2025-12-16 10:48:43', '2025-12-16 11:12:32', 722333444, NULL, '2025-12-16 11:12:32'),
(11, 1, 9, 'Test', 'Wilson', 'testmoney@gmail.com', NULL, '0700222333', NULL, '$2y$12$A8fDty0NQqfGQ7iT1BPov.OD/zeLv0ZtDOSzQzVfNAMRZFbRrSV6O', NULL, NULL, NULL, NULL, '2025-12-16 11:06:35', '2025-12-16 11:11:39', 722333444, NULL, '2025-12-16 11:11:39'),
(12, 1, 10, 'Ruth', 'Money', 'ruthmoney@gmail.com', NULL, '0700999888', NULL, '$2y$12$59dH5LNxZLXREAnup9R0TOA0JJTzJfv1w2eNnS9PULOrBNKprQRtC', '2025-12-16 11:16:09', NULL, NULL, NULL, '2025-12-16 11:14:05', '2025-12-16 11:16:09', 722333444, 12, NULL),
(13, 1, 11, 'Ruth', 'Cash', 'cash@gmail.com', NULL, '0701999888', NULL, '$2y$12$eFRunFD8Cn0Y.oQ/7gIx/u.gt7d3OfBruw0Ms2/b3e7dYyAx9Gz9S', '2025-12-23 10:38:41', NULL, NULL, NULL, '2025-12-16 11:31:21', '2025-12-23 10:38:41', 722333444, 13, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_tenant_id_name_unique` (`tenant_id`,`name`),
  ADD KEY `departments_leader_id_foreign` (`leader_id`),
  ADD KEY `departments_created_by_foreign` (`created_by`),
  ADD KEY `departments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `donations_reference_unique` (`reference`),
  ADD KEY `donations_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_tenant_id_foreign` (`tenant_id`),
  ADD KEY `events_created_by_foreign` (`created_by`),
  ADD KEY `events_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `event__members`
--
ALTER TABLE `event__members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event__members_event_id_member_id_unique` (`event_id`,`member_id`),
  ADD KEY `event__members_member_id_foreign` (`member_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_expense_number_unique` (`expense_number`),
  ADD KEY `expenses_tenant_id_foreign` (`tenant_id`),
  ADD KEY `expenses_expense_category_id_foreign` (`expense_category_id`),
  ADD KEY `expenses_approved_by_foreign` (`approved_by`),
  ADD KEY `expenses_approved_by_2_foreign` (`approved_by_2`),
  ADD KEY `expenses_created_by_foreign` (`created_by`),
  ADD KEY `expenses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_categories_tenant_id_name_unique` (`tenant_id`,`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `funds_slug_unique` (`slug`),
  ADD KEY `funds_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_slug_unique` (`slug`),
  ADD KEY `groups_tenant_id_foreign` (`tenant_id`),
  ADD KEY `groups_leader_id_foreign` (`leader_id`);

--
-- Indexes for table `group__members`
--
ALTER TABLE `group__members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group__members_group_id_member_id_unique` (`group_id`,`member_id`),
  ADD KEY `group__members_member_id_foreign` (`member_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_tenant_id_foreign` (`tenant_id`),
  ADD KEY `members_created_by_foreign` (`created_by`),
  ADD KEY `members_updated_by_foreign` (`updated_by`),
  ADD KEY `members_department_id_foreign` (`department_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_tenant_id_foreign` (`tenant_id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_recipients_message_id_foreign` (`message_id`),
  ADD KEY `message_recipients_member_id_foreign` (`member_id`),
  ADD KEY `message_recipients_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `offerings`
--
ALTER TABLE `offerings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offerings_tenant_id_foreign` (`tenant_id`),
  ADD KEY `offerings_created_by_foreign` (`created_by`),
  ADD KEY `offerings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_phone_expires_at_index` (`phone`,`expires_at`),
  ADD KEY `otps_phone_index` (`phone`),
  ADD KEY `otps_expires_at_index` (`expires_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_tenant_id_foreign` (`tenant_id`),
  ADD KEY `permissions_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_tenant_id_foreign` (`tenant_id`),
  ADD KEY `roles_user_id_foreign` (`user_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sunday_collections`
--
ALTER TABLE `sunday_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sunday_collections_created_by_foreign` (`created_by`),
  ADD KEY `sunday_collections_updated_by_foreign` (`updated_by`),
  ADD KEY `sunday_collections_verified_by_foreign` (`verified_by`),
  ADD KEY `sunday_collections_verified_by_2_foreign` (`verified_by_2`),
  ADD KEY `sunday_collections_tenant_id_collection_date_index` (`tenant_id`,`collection_date`),
  ADD KEY `sunday_collections_tenant_id_status_index` (`tenant_id`,`status`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenants_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_member_id_foreign` (`member_id`),
  ADD KEY `users_tenant_id_foreign` (`tenant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event__members`
--
ALTER TABLE `event__members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group__members`
--
ALTER TABLE `group__members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_recipients`
--
ALTER TABLE `message_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `offerings`
--
ALTER TABLE `offerings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sunday_collections`
--
ALTER TABLE `sunday_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `departments_leader_id_foreign` FOREIGN KEY (`leader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `departments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event__members`
--
ALTER TABLE `event__members`
  ADD CONSTRAINT `event__members_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event__members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_approved_by_2_foreign` FOREIGN KEY (`approved_by_2`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`),
  ADD CONSTRAINT `expenses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD CONSTRAINT `expense_categories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `funds`
--
ALTER TABLE `funds`
  ADD CONSTRAINT `funds_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_leader_id_foreign` FOREIGN KEY (`leader_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `groups_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group__members`
--
ALTER TABLE `group__members`
  ADD CONSTRAINT `group__members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group__members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `members_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `members_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD CONSTRAINT `message_recipients_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `message_recipients_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_recipients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offerings`
--
ALTER TABLE `offerings`
  ADD CONSTRAINT `offerings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `offerings_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offerings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sunday_collections`
--
ALTER TABLE `sunday_collections`
  ADD CONSTRAINT `sunday_collections_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sunday_collections_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sunday_collections_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sunday_collections_verified_by_2_foreign` FOREIGN KEY (`verified_by_2`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sunday_collections_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
