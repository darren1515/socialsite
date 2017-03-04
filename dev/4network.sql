-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 04, 2017 at 02:40 PM
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
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `Chat_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Send_TIME` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friendgroup`
--

CREATE TABLE `friendgroup` (
  `Group_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Create_TIME` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friendgroup`
--

INSERT INTO `friendgroup` (`Group_ID`, `User_ID`, `Create_TIME`) VALUES
(1, 24, '2017-02-12 18:52:15.634871'),
(2, 0, '2017-02-15 16:49:05.635621'),
(3, 0, '2017-02-15 16:49:23.004734');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `User_id` int(11) NOT NULL,
  `Friend_id` int(11) NOT NULL,
  `friendStatus` varchar(10) NOT NULL COMMENT 'Either accepted or pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `User_id` int(11) NOT NULL,
  `Photo_id` int(11) NOT NULL,
  `Privacy` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `latestTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `message`, `latestTime`) VALUES
(33, 24, 'hjgjhghjgjh', '2017-03-02 15:16:00'),
(34, 24, 'hello max', '2017-03-02 15:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `privacysettings`
--

CREATE TABLE `privacysettings` (
  `privacyID` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privacysettings`
--

INSERT INTO `privacysettings` (`privacyID`, `description`) VALUES
(1, 'private'),
(2, 'friends'),
(3, 'friends of friends'),
(4, 'all');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `First_name` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Last_name` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Username` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `dob` date NOT NULL,
  `Password` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Gender` varchar(20) CHARACTER SET ucs2 NOT NULL,
  `activationToken` text NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `privacysettings_fk` int(11) NOT NULL COMMENT 'Links to primary key in privacysettings table',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `First_name`, `Last_name`, `Username`, `dob`, `Password`, `Phone`, `Gender`, `activationToken`, `activated`, `privacysettings_fk`, `Timestamp`) VALUES
(24, 'Darren', 'Lahr', 'darrenlahr@gmail.com', '2017-02-09', '97f9ea49cd34ce6e52c4a49b7f4aeec1', '', 'male', '', 1, 0, '2017-02-24 18:05:37'),
(25, 'Bob', 'Marin', '', '0000-00-00', '', '', '', '', 0, 0, '2017-03-03 23:59:48'),
(26, 'BOBBY', 'Smith', '', '0000-00-00', '', '', '', '', 0, 0, '2017-03-03 23:59:48'),
(27, 'Bob', 'Smith', '', '0000-00-00', '', '', '', '', 0, 0, '2017-03-04 00:00:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`Chat_ID`);

--
-- Indexes for table `friendgroup`
--
ALTER TABLE `friendgroup`
  ADD PRIMARY KEY (`Group_ID`);

--
-- Indexes for table `grouprelation`
--
ALTER TABLE `grouprelation`
  ADD PRIMARY KEY (`Operation_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `privacysettings`
--
ALTER TABLE `privacysettings`
  ADD PRIMARY KEY (`privacyID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `Chat_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friendgroup`
--
ALTER TABLE `friendgroup`
  MODIFY `Group_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grouprelation`
--
ALTER TABLE `grouprelation`
  MODIFY `Operation_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `privacysettings`
--
ALTER TABLE `privacysettings`
  MODIFY `privacyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
