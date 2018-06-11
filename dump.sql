-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 10, 2018 at 08:59 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `MYL`
--

-- --------------------------------------------------------

--
-- Table structure for table `contributors`
--

CREATE TABLE `contributors` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contributors`
--

INSERT INTO `contributors` (`id`, `language_id`, `user_id`, `type`) VALUES
(1, 35, 10, 'owner'),
(2, 36, 10, 'owner'),
(3, 37, 10, 'owner'),
(4, 38, 10, 'owner'),
(5, 39, 10, 'owner'),
(6, 40, 10, 'owner'),
(7, 41, 10, 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `words_count` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `rank` varchar(2) DEFAULT 'F'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `user_id`, `words_count`, `description`, `name`, `rank`) VALUES
(32, 10, 0, '1234\r\n', 'sam', '0'),
(33, 10, 0, 'asdfasdfasf', 'teadsfasdf', '0'),
(34, 10, 0, 'sdfasfasdf', 'asdfasf', '0'),
(35, 10, 0, 'sadfasf', 'asdfasfa', '0'),
(36, 10, 0, 'This is amharic', 'Amharic', '0'),
(37, 10, 0, 'This is Desc', 'Richs Language', '0'),
(38, 10, 0, 'asdfasdf', 'Llll', '0'),
(39, 10, 0, 'asdfasdf', 'new lang', '0'),
(40, 10, 6, '', 'Lets test', 'D-'),
(41, 10, 0, '', 'asdfasdfasdf', '0');

-- --------------------------------------------------------

--
-- Table structure for table `language_grade_rules`
--

CREATE TABLE `language_grade_rules` (
  `id` int(11) NOT NULL,
  `words_count` int(11) NOT NULL,
  `grade` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language_grade_rules`
--

INSERT INTO `language_grade_rules` (`id`, `words_count`, `grade`) VALUES
(1, 5, 'D-'),
(2, 10, 'D'),
(3, 15, 'D+'),
(4, 20, 'C-'),
(5, 25, 'C'),
(6, 30, 'C+'),
(7, 40, 'B-'),
(8, 55, 'B'),
(9, 70, 'A-'),
(10, 85, 'A'),
(11, 100, 'A+'),
(12, 0, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `timestamp` bigint(20) NOT NULL,
  `text` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `password`, `email`, `rank`) VALUES
(1, 'test', 'test user', '1234567', 'sami@gmail.com', 0),
(2, 'sam', '', 'samisami', 'sam@gmail.com', 0),
(10, 'rich', 'rich rich', 'richrich', 'rich@bla.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `translation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `user_id`, `language_id`, `word`, `translation`) VALUES
(6, 10, 35, 'Dimet', 'cat'),
(7, 10, 35, 'tota', 'ape'),
(8, 10, 35, 'rahel', 'Rachel'),
(9, 10, 36, 'Cat', 'Demit'),
(10, 10, 36, 'Wesha', 'Dog'),
(11, 10, 35, 'Chala', 'Belete'),
(12, 10, 37, 'Cat', 'adure'),
(13, 10, 37, 'Dog', 'Sere'),
(14, 10, 37, 'adure', 'Cat'),
(15, 10, 37, 'sere', 'Dog'),
(16, 10, 36, 'demet', 'Cat'),
(17, 10, 40, 'cat', 'cat'),
(18, 10, 41, 'sdfadsf', 'asdfasf'),
(19, 10, 40, 'asdad', 'asdasd'),
(20, 10, 40, 'asfasdf', 'aa'),
(21, 10, 40, 'asfdf', 'asfasf'),
(22, 10, 40, 'safasdf', 'adsfasf'),
(23, 10, 40, 'sdfadfa', 'sdfasdfasdf'),
(24, 10, 40, 'dsfasdf', 'asdfasdf'),
(25, 10, 40, 'asdfadsf', 'asdfasdfasdf'),
(26, 10, 40, 'asdfasdf', 'asdfasdfasdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributors`
--
ALTER TABLE `contributors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `languages_ibfk_1` (`user_id`);

--
-- Indexes for table `language_grade_rules`
--
ALTER TABLE `language_grade_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lang_id` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contributors`
--
ALTER TABLE `contributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `language_grade_rules`
--
ALTER TABLE `language_grade_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contributors`
--
ALTER TABLE `contributors`
  ADD CONSTRAINT `contributors_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contributors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `words_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
