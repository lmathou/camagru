-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2017 at 08:05 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--
CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `camagru`;

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
CREATE TABLE `Comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_id` int(11) NOT NULL,
  `liker_id` varchar(8) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`id`, `description`, `image_id`, `liker_id`, `creation_date`) VALUES
(1, 'Space cat', 1, 'admin', '2017-05-30 13:37:09'),
(2, 'Moustache man le retour', 3, 'toto', '2017-05-30 17:47:05'),
(3, 'Modern Classic', 4, 'admin', '2017-05-30 18:02:06'),
(4, 'Joli cadre', 2, 'admin', '2017-05-30 18:02:29'),
(5, 'Ã  Ã©tÃ© dÃ©Ã§Ã¼', 4, 'admin', '2017-05-30 19:27:05'),
(6, '2--&gt;Ã  Ã©tÃ© dÃ©Ã§Ã¼', 4, 'admin', '2017-05-30 19:34:11'),
(7, '3--&gt;Ã  Ã©tÃ© dÃ©Ã§Ã¼', 4, 'admin', '2017-05-30 19:39:24'),
(8, 'Ã  Ã©tÃ© dÃ©Ã§Ã¼', 4, 'admin', '2017-05-30 19:40:36'),
(9, 'Ã  Ã©tÃ© dÃ©Ã§Ã¼', 3, 'admin', '2017-05-30 19:41:24'),
(10, 'c flou', 13, 'admin', '2017-06-06 18:09:32'),
(11, 'Photo sans intÃ©rÃªt', 14, 'toto', '2017-06-06 21:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `Image`
--

DROP TABLE IF EXISTS `Image`;
CREATE TABLE `Image` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Image`
--

INSERT INTO `Image` (`id`, `user_id`, `image_name`, `creation_date`) VALUES
(1, 'admin', 'chat1.jpg', '2017-05-30 13:37:09'),
(5, 'admin', '1496174287.png', '2017-05-30 21:58:07'),
(6, 'admin', '1496174371.png', '2017-05-30 21:59:31'),
(9, 'toto', '1496416200.png', '2017-06-02 17:10:02'),
(11, 'toto', '1496418158.png', '2017-06-02 17:42:38'),
(12, 'toto', '1496418648.png', '2017-06-02 17:50:48'),
(13, 'toto', '1496419541.png', '2017-06-02 18:05:41'),
(14, 'tata', '1496774070.png', '2017-06-06 20:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `Like_table`
--

DROP TABLE IF EXISTS `Like_table`;
CREATE TABLE `Like_table` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_id` int(11) NOT NULL,
  `liker_id` varchar(8) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Like_table`
--

INSERT INTO `Like_table` (`id`, `image_id`, `liker_id`, `creation_date`) VALUES
(1, 1, 'admin', '2017-05-30 13:37:09'),
(3, 2, 'toto', '2017-05-30 17:44:41'),
(4, 3, 'toto', '2017-05-30 17:46:45'),
(5, 4, 'admin', '2017-05-30 18:01:19'),
(7, 3, 'admin', '2017-05-30 18:01:23'),
(8, 2, 'admin', '2017-05-30 18:01:24'),
(9, 12, 'toto', '2017-06-02 17:56:49'),
(10, 11, 'toto', '2017-06-02 17:57:00'),
(11, 13, 'admin', '2017-06-06 18:09:24'),
(14, 13, 'toto', '2017-06-06 21:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `login` varchar(10) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `profile` enum('USER','ADMIN') NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('NOT_ACTIVATED','ACTIVATED') NOT NULL,
  `cle` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`login`, `mail`, `passwd`, `profile`, `creation_date`, `status`, `cle`) VALUES
('admin', 'l.mathou@laposte.net', '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94', 'ADMIN', '2017-05-30 13:37:09', 'ACTIVATED', NULL),
('tata', 'electrikrainbow@gmail.com', '66bd631dfd505122209d9456122c63bbc8433a17d933b455b5c21330f4a85e86aba509d2a5b2b781dd5514ac5f444fcc657f3818a6ba8672163d3156e5066998', 'USER', '2017-06-06 20:31:29', 'ACTIVATED', 'b79f1f45c5fdbcd644c3535987c729a4'),
('toto', 'lmathou@free.fr', '6806efdb00f16ffc9e39cd3b8fcdce1a1fd66ef016766702e1a073895acd92d2862e0de969240a39dee50242b5febc141cb7578d86af139644cd9fcc50600f22', 'USER', '2017-06-06 18:12:25', 'ACTIVATED', 'd8c47149ec2800f2e99b78665a7dac4d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Like_table`
--
ALTER TABLE `Like_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_image_liker` (`image_id`,`liker_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `uc_mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `Image`
--
ALTER TABLE `Image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `Like_table`
--
ALTER TABLE `Like_table`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
