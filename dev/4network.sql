-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 15, 2017 at 02:49 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `4network`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `User_id` int(11) NOT NULL,
  `Age` int(6) NOT NULL,
  `Sports` int(6) NOT NULL,
  `Movies` int(6) NOT NULL,
  `Music` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `Message_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Message` mediumtext NOT NULL,
  `Send_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Comment_ID` int(11) NOT NULL,
  `Text` varchar(250) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Photo_ID` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friendgroup`
--

CREATE TABLE `friendgroup` (
  `Group_ID` int(11) NOT NULL,
  `Group_name` varchar(225) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Create_TIME` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `User_id1` int(11) NOT NULL,
  `User_id2` int(11) NOT NULL,
  `friendStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 is pending, 1 is accepted',
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grouprelation`
--

CREATE TABLE `grouprelation` (
  `Operation_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Operation_TIME` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `Photo_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `location` text NOT NULL COMMENT 'The location of the image ',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` mediumtext,
  `latestTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `First_name` varchar(20) NOT NULL,
  `Last_name` varchar(20) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `Password` mediumtext NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `activationToken` mediumtext NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `privacysetting` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `profilephoto` text COMMENT 'the location of the user profile will be stored here',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_name`, `Last_name`, `Username`, `dob`, `Password`, `Phone`, `Gender`, `activationToken`, `activated`, `privacysetting`, `profilephoto`, `Timestamp`) VALUES
(30, 'Darren', 'Lahr', 'darrenlahr@outlook.com', '1991-10-29', '5b227609682aab59d808bb1e971568e1', '07540223996', 'male', '', 1, '4', NULL, '2017-03-14 00:43:48'),
(31, 'Wang', 'Chin', 'darren.lahr.16@ucl.ac.uk', '2017-03-24', 'e74df496f5eab1c66b904548e3c01f1d', '', 'male', '', 1, '3', NULL, '2017-03-14 13:43:35'),
(32, 'JIALIN', 'YU', 'zhwysh@outlook.com', '2016-12-15', '2b15e296b879e1a51d09bda75f657a9d', '07518206827', 'male', '', 1, '2', NULL, '2017-03-15 00:40:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD UNIQUE KEY `User_ID` (`User_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `Group_ID` (`Group_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Comment_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Photo_ID` (`Photo_ID`);

--
-- Indexes for table `friendgroup`
--
ALTER TABLE `friendgroup`
  ADD PRIMARY KEY (`Group_ID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD UNIQUE KEY `User_id1` (`User_id1`,`User_id2`) USING BTREE;

--
-- Indexes for table `grouprelation`
--
ALTER TABLE `grouprelation`
  ADD PRIMARY KEY (`Operation_ID`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`Photo_id`),
  ADD KEY `Photo_id` (`Photo_id`),
  ADD KEY `User_id` (`User_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD KEY `PrivacySetting_FK` (`privacysetting`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friendgroup`
--
ALTER TABLE `friendgroup`
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `grouprelation`
--
ALTER TABLE `grouprelation`
  MODIFY `Operation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `Photo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `deleteWhenPhotoDelete` FOREIGN KEY (`Photo_ID`) REFERENCES `photos` (`Photo_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`User_id1`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
