-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 23, 2017 at 06:32 PM
-- Server version: 5.6.35-log
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csf`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Example entries for table `attendance`
--

-- INSERT INTO `attendance` (`id`, `meeting_id`, `student_id`, `timestamp`) VALUES
-- (1, 1, 000000000, '2017-09-16 07:34:03'),
-- (2, 1, 123456789, '2017-09-16 07:34:04'),
-- (3, 1, 101112131, '2017-09-16 07:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(11) NOT NULL,
  `date` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Example entries for table `meetings`
--

-- INSERT INTO `meetings` (`id`, `date`, `description`) VALUES
-- (1, 'September 12, 2017', 'Sample description.'),
-- (2, 'September 26, 2017', ''),
-- (3, 'October 10, 2017', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `student_id` int(9) NOT NULL,
  `grade` int(2) NOT NULL,
  `terms` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Example entries for table `students`
--

-- INSERT INTO `students` (`id`, `name`, `student_id`, `grade`, `terms`) VALUES
-- (1, 'Student Name', 373001009, 10, 1),
-- (2, 'Sample Student', 373001225, 11, 0),
-- (3, 'First Last', 143001237, 12, 5),

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `access_level` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Example entries for table `users`
--

-- INSERT INTO `users` (`id`, `username`, `password`, `name`, `access_level`) VALUES
-- (1, 'user1', '------------------ bcrypt password hash  -------------------', 'Officer Name', 'development'),
-- (2, 'user2', '------------------ bcrypt password hash  -------------------', 'First Last', 'advisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
