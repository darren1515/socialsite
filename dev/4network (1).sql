-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 17, 2017 at 05:36 PM
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

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`Message_ID`, `Group_ID`, `User_ID`, `Message`, `Send_TIME`) VALUES
(1, 1, 30, 'Welcome to chat', '2017-03-15 20:42:01');

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
(2, 'NFL amazing match', 31, 2, '2017-03-15 20:08:18'),
(3, 'To avoid the queue, check in online. Be smart, be like me :)', 34, 3, '2017-03-15 20:11:34'),
(4, 'Wonderful photo', 30, 1, '2017-03-15 21:05:06'),
(5, 'Look intersting', 30, 2, '2017-03-15 21:05:43');

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

--
-- Dumping data for table `friendgroup`
--

INSERT INTO `friendgroup` (`Group_ID`, `Group_name`, `User_ID`, `Create_TIME`) VALUES
(1, 'Test', 30, '2017-03-15 20:42:01.892405');

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
(31, 30, 1, '2017-03-15 19:40:27'),
(34, 30, 1, '2017-03-15 19:40:31');

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

--
-- Dumping data for table `grouprelation`
--

INSERT INTO `grouprelation` (`Operation_ID`, `Group_ID`, `User_ID`, `Operation_TIME`) VALUES
(1, 1, 30, '2017-03-15 20:42:01.908659'),
(2, 1, 31, '2017-03-15 20:42:01.944439'),
(3, 1, 34, '2017-03-15 20:42:01.955928');

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
(1, 30, '8ffb30e6-8238-41a1-bc14-d938c11f4bfe/han.jpg', '2017-03-15 20:04:59'),
(2, 31, '80a51b68-c8a7-47b6-98bb-dea2e9db4b09/nfl.jpg', '2017-03-15 20:07:56'),
(3, 34, '51dee866-274a-4a46-82b5-6a09d87b0830/airport.jpg', '2017-03-15 20:11:28'),
(4, 34, '2a3cff6d-d7c9-45ff-a422-c7d6e0358f26/football.jpg', '2017-03-15 20:12:27');

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
(1, 30, 'Man, LIFE is always struggling.\\nHowever what relieves us is that, Any plan is the Best plan！\\n\\nHello', '2017-03-15 21:04:14'),
(3, 31, 'Great website, I am sure you will get a high mark.', '2017-03-15 20:09:22'),
(4, 34, 'Off on holiday at long last.', '2017-03-15 20:11:47'),
(5, 30, 'This is some test text', '2017-03-15 21:04:31');

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
  `Phone` varchar(20) DEFAULT NULL,
  `Gender` varchar(20) NOT NULL,
  `activationToken` mediumtext,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `privacysetting` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `profilephoto` text COMMENT 'the location of the user profile will be stored here',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_name`, `Last_name`, `Username`, `dob`, `Password`, `Phone`, `Gender`, `activationToken`, `activated`, `privacysetting`, `profilephoto`, `Timestamp`) VALUES
(30, 'Robert', 'Wu', 'darrenlahr@outlook.com', '1991-10-29', '5b227609682aab59d808bb1e971568e1', '07540223996', 'male', '', 1, '2', NULL, '2017-03-15 19:32:44'),
(31, 'Wang', 'Chin', 'darren.lahr.16@ucl.ac.uk', '2017-03-24', 'e74df496f5eab1c66b904548e3c01f1d', '', 'male', '', 1, '3', '90115a89-9704-422f-9856-197f8ff0480c/image.jpg', '2017-03-15 19:45:28'),
(34, 'Max', 'Smith', 'maxrogers12345123@gmail.com', '1993-05-10', 'a407e86902e4208951d2d32b556fa497', '07540663596', 'male', 'f29920facee07b9fd6150b36c2de351017825b81e3e111a8f068b23ea8482274', 1, '4', NULL, '2017-03-15 19:00:37'),
(35, 'Jenny', 'Li', 'zhwysh@outlook.com', '1995-08-10', '4fae5571104bdb0e915b9370ab2c816c', '', 'female', '94a2b56f31df53a7c2142b389e2010220eb2edfe033897bc70a1454178760290', 1, '1', '13c0b0dc-18d0-4bd2-9cd1-65043fd94e0a/hqdefault.jpg', '2017-03-15 19:59:54');

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
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `friendgroup`
--
ALTER TABLE `friendgroup`
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grouprelation`
--
ALTER TABLE `grouprelation`
  MODIFY `Operation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `Photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
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
