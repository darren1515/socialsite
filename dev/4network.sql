-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 13, 2017 at 06:09 PM
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
  `User_id` int(6) NOT NULL,
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_ID`, `Text`, `User_ID`, `Photo_ID`, `TimeStamp`) VALUES
(1, 'Great photo', 24, 1, '2017-03-12 18:45:57'),
(2, 'test text', 26, 1, '2017-03-12 18:45:57'),
(3, 'I don\'t like this shit', 26, 32, '2017-03-13 02:09:20'),
(4, 'Market risk :(', 24, 32, '2017-03-13 02:09:50');

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

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`User_id1`, `User_id2`, `friendStatus`, `time_added`) VALUES
(24, 27, 1, '2017-03-04 16:41:00'),
(24, 28, 1, '2017-03-04 16:41:43'),
(24, 30, 0, '2017-03-09 23:34:56'),
(25, 24, 1, '2017-03-04 16:41:00'),
(27, 26, 1, '2017-03-08 15:12:06'),
(30, 26, 1, '2017-03-08 15:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `Group_ID` int(11) NOT NULL,
  `Group_Name` varchar(50) NOT NULL,
  `Date_Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`Group_ID`, `Group_Name`, `Date_Created`) VALUES
(1, 'The best group', '2017-03-07 02:41:18'),
(2, 'Second Group', '2017-03-07 02:41:18'),
(3, 'Another Random Group', '2017-03-07 02:41:34'),
(4, 'Databases!', '2017-03-07 02:41:34');

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

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`Photo_id`, `User_id`, `location`, `Timestamp`) VALUES
(31, 30, 'a06aeb03-ed6a-4773-bc85-10e5068b0378/image.jpg', '2017-03-12 23:23:44'),
(32, 30, 'aa01a9a8-a9d4-47ec-8a22-6a0fb6b4682b/sample1_l.jpg', '2017-03-13 02:06:32');

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

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `message`, `latestTime`) VALUES
(34, 24, 'hello max', '2017-03-02 15:16:56'),
(35, 24, 'DASDFAFDA', '2017-03-04 17:30:55'),
(37, 30, 'hello chw are you', '2017-03-10 22:20:14'),
(39, 31, 'dsafsad', '2017-03-10 15:26:52'),
(40, 31, 'hasdfasdf', '2017-03-10 15:26:56'),
(41, 31, 'asdfasd', '2017-03-10 15:32:52'),
(42, 30, 'asdfasdfa', '2017-03-13 00:02:08');

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
(24, 'Han', 'Wang', 'darrenlahr@gmail.com', '2017-02-09', '97f9ea49cd34ce6e52c4a49b7f4aeec1', '', 'male', '', 1, '4', NULL, '2017-03-08 15:17:12'),
(25, 'Bob', 'Marin', '', '0000-00-00', '', '', '', '', 0, '', NULL, '2017-03-03 23:59:48'),
(26, 'Rod', 'Smith', '', '0000-00-00', '', '', '', '', 0, '4', NULL, '2017-03-08 15:15:01'),
(27, 'Bob', 'Smith', '', '0000-00-00', '', '', '', '', 0, '3', NULL, '2017-03-08 15:10:18'),
(30, 'Darren', 'Lahr', 'darrenlahr@outlook.com', '1991-10-29', '5b227609682aab59d808bb1e971568e1', '07540223996', 'male', '', 1, '4', NULL, '2017-03-09 19:04:09'),
(31, 'Wang', 'Chin', 'darren.lahr.16@ucl.ac.uk', '2017-03-24', 'e74df496f5eab1c66b904548e3c01f1d', '', 'male', '', 1, '3', '30d4f7a7-c67f-463b-9b27-9e7233ca4541/image.jpg', '2017-03-10 22:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `User_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`User_ID`, `Group_ID`) VALUES
(24, 1),
(24, 2),
(25, 4);

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
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD UNIQUE KEY `User_id1` (`User_id1`,`User_id2`) USING BTREE;

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`Group_ID`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`Photo_id`),
  ADD KEY `Photo_id` (`Photo_id`);

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
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD UNIQUE KEY `Grouped FK` (`User_ID`,`Group_ID`) USING BTREE,
  ADD KEY `Group_ID` (`Group_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `Photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`Group_ID`) REFERENCES `groups` (`Group_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`User_id1`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`Group_ID`) REFERENCES `groups` (`Group_ID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
