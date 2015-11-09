-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.25-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table task.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table task.categories: ~4 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `title`, `description`) VALUES
	(1, 'Sports', 'Anything Sports goes here'),
	(2, 'Gaming', 'Anything Gaming Goes here'),
	(3, 'IT', 'Anything about IT Goes Here'),
	(4, 'Hardware', 'Anything about hardware goes here');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Dumping structure for table task.login_attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table task.login_attempts: ~5 rows (approximately)
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` (`id`, `time`) VALUES
	(1, '1446914366'),
	(1, '1446914392'),
	(1, '1446914402'),
	(1, '1446914411'),
	(NULL, '1447045690');
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;


-- Dumping structure for table task.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` longtext,
  `user_id` int(11) DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `primary_post` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- Dumping data for table task.posts: ~31 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `body`, `user_id`, `thread_id`, `primary_post`, `time`) VALUES
	(1, 'Testing', 1, 1, 0, '2015-11-07 10:37:47'),
	(2, 'Testing123', 1, 1, 1, '2015-11-07 10:17:49'),
	(3, 'Testing', 1, 2, 0, '2015-11-07 10:37:56'),
	(4, 'Testing123', 1, 2, 1, '2015-11-07 10:07:57'),
	(6, 'Testing123', 1, 3, 1, '2015-11-07 09:38:06'),
	(7, '<p>Testing</p>\r\n', 1, 4, 1, '2015-11-09 02:41:29'),
	(8, '<p>I edited this</p>\r\n', 1, 4, 0, '2015-11-09 02:41:33'),
	(11, '<p>Testing</p>\r\n', 1, 9, 1, '2015-11-09 06:25:15'),
	(12, '<p>Jordan makes weird noises</p>\r\n', 1, 10, 1, '2015-11-09 06:25:32'),
	(28, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:47'),
	(29, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:48'),
	(30, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:50'),
	(31, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:52'),
	(32, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:54'),
	(33, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:55'),
	(34, '<p>Pagination</p>\r\n', 1, 10, 0, '2015-11-09 07:24:57'),
	(35, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:02:52'),
	(36, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:02:54'),
	(37, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:02:56'),
	(38, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:02:58'),
	(39, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:00'),
	(40, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:02'),
	(41, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:04'),
	(42, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:06'),
	(43, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:08'),
	(44, '<p>test</p>\r\n', 1, 3, 0, '2015-11-09 08:03:17'),
	(45, '<p>Updating</p>\r\n', 1, 10, 0, '2015-11-09 21:12:58'),
	(46, '<p>updated</p>\r\n', 1, 9, 0, '2015-11-09 21:15:16'),
	(47, '<p>Test</p>\r\n', 1, 10, 0, '2015-11-09 21:15:36'),
	(48, '<p>Test</p>\r\n', 1, 10, 0, '2015-11-09 21:15:38'),
	(49, '<p>Test</p>\r\n', 1, 10, 0, '2015-11-09 21:15:41'),
	(50, '<p>test</p>\r\n', 1, 10, 0, '2015-11-09 11:23:36'),
	(51, '<p>test</p>\r\n', 1, 10, 0, '2015-11-09 09:25:29');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;


-- Dumping structure for table task.threads
CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table task.threads: ~10 rows (approximately)
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` (`id`, `title`, `category_id`, `user_id`, `time`, `updated`) VALUES
	(1, 'Test', 1, 1, '2015-11-08 17:00:16', '2015-11-09 09:08:12'),
	(2, 'Test', 1, 1, '2015-11-08 17:00:17', '2015-11-09 09:08:14'),
	(3, 'Test', 2, 1, '2015-11-08 17:00:18', '2015-11-09 09:08:14'),
	(4, 'Test', 2, 1, '2015-11-08 17:00:19', '2015-11-09 09:08:15'),
	(5, 'Test', 3, 1, '2015-11-08 17:00:22', '2015-11-09 09:08:17'),
	(6, 'Test', 3, 1, '2015-11-08 17:00:22', '2015-11-09 09:08:16'),
	(7, 'Test', 4, 1, '2015-11-08 17:00:23', '2015-11-09 09:08:18'),
	(8, 'Test', 4, 1, '2015-11-08 17:00:24', '2015-11-09 09:08:18'),
	(9, 'Testing', 1, 1, '2015-11-09 06:25:15', '2015-11-09 21:15:16'),
	(10, 'Jordan is weird', 1, 1, '2015-11-09 06:25:32', '2015-11-09 09:25:29');
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;


-- Dumping structure for table task.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL DEFAULT '0',
  `last_name` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(128) NOT NULL DEFAULT '0',
  `admin` int(1) NOT NULL DEFAULT '0',
  `readonly` int(1) NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Dumping data for table task.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `first_name`, `last_name`, `password`, `admin`, `readonly`, `last_login`) VALUES
	(1, 'MasterYodA', 'beachman4@hotmail.com', 'Aylon', 'Armstrong', '39eb101542f59231dfbc52245b93903a', 1, 0, NULL),
	(3, 'test', 'test@test.com', 'test', 'test', '39eb101542f59231dfbc52245b93903a', 0, 0, NULL),
	(8, 'test123', 'test@test.comasd', 'test', 'test', '39eb101542f59231dfbc52245b93903a', 0, 0, NULL),
	(12, 'SmartMan', 'nick.parker132@gmail.com', 'Nick', 'Parker', 'c723c5049b83b9047e23cf12dd1822a9', 0, 0, NULL),
	(16, 'Beachman4', 'beachman19@gmail.com', 'Aylon', 'Armstrong', 'cfa3209b24f5b060aec035e96a11b6df', 1, 0, NULL),
	(17, 'Groupm7', 'jason@groupm7.com', 'Group', 'M7', '1df0682aa7243c95724338505178e724', 1, 0, '2015-11-09 09:35:23'),
	(18, 'TestUser', 'testuser@me.com', 'Test', 'User', 'ae2b1fca515949e5d54fb22b8ed95575', 1, 1, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
