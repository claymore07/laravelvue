-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2019 at 07:22 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `research`
--

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

DROP TABLE IF EXISTS `degrees`;
CREATE TABLE IF NOT EXISTS `degrees` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'مدرک',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'کارشناسی', NULL, NULL),
(2, 'کارشناسی ارشد', NULL, NULL),
(3, 'دکتری', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام گروه',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'مهندسی کامپیوتر', NULL, NULL),
(2, 'مهندسی صنایع', NULL, NULL),
(3, 'مهندسی برق', NULL, NULL),
(4, 'مهندسی معماری', NULL, NULL),
(5, 'مهندسی عمران', NULL, NULL),
(6, 'حقوق', NULL, NULL),
(7, 'جغرافیا', NULL, NULL),
(8, 'پزشکی', NULL, NULL),
(9, 'پیراپزشکی', NULL, NULL),
(10, 'روانشناسی', NULL, NULL),
(11, 'مدیریت', NULL, NULL),
(12, 'شیمی', NULL, NULL),
(13, 'کشاورزی', NULL, NULL),
(14, 'محیط زیست', NULL, NULL),
(15, 'علوم تربیتی', NULL, NULL),
(16, 'ریاضی', NULL, NULL),
(17, 'فیزیک', NULL, NULL),
(18, 'زیست شناسی', NULL, NULL),
(19, 'حسابداری', NULL, NULL),
(20, 'علوم ارتباطات اجتماعی', NULL, NULL),
(21, 'زبان و ادبیات فارسی', NULL, NULL),
(22, 'زبان و ادبیات انگلیسی', NULL, NULL),
(23, 'تربیت بدنی', NULL, NULL),
(24, 'الهیات و معارف اسلامی', NULL, NULL),
(25, 'معارف اسلامی', NULL, '2018-04-04 10:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام دانشکده',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'دانشکده فنی و مهندسی', NULL, '2018-04-04 10:37:10'),
(2, 'دانشکده علوم انسانی', NULL, NULL),
(3, 'دانشکده علوم پایه', NULL, NULL),
(4, 'دانشکده علوم پزشکی', NULL, NULL),
(6, 'کشاورزی و محیط زیست', '2018-04-01 15:13:47', '2018-04-03 11:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'عضویت در باشگاه',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'عضو باشگاه پژوهشگران جوان', NULL, NULL),
(2, 'استعداد درخشان', NULL, NULL),
(3, 'عدم عضویت', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'نوع همکاری',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'عضو هیات علمی تمام وقت', NULL, NULL),
(2, 'عضو هیات علمی نیمه وقت', NULL, NULL),
(3, 'حق التدریس', NULL, NULL),
(4, 'بورسیه', NULL, NULL),
(5, 'کارمند', NULL, NULL),
(6, 'دانشجو', NULL, NULL),
(7, 'فارغ التحصیل', NULL, NULL),
(8, 'سایر', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

DROP TABLE IF EXISTS `ranks`;
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_persian_ci NOT NULL COMMENT 'رتبه علمی',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'دانشجو', NULL, NULL),
(2, 'مربی', NULL, NULL),
(3, 'استادیار', NULL, NULL),
(4, 'دانشیار', NULL, NULL),
(5, 'استاد', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
