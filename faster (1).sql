-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 04:25 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faster`
--

-- --------------------------------------------------------

--
-- Table structure for table `playerdata`
--

CREATE TABLE `playerdata` (
  `teamcode` varchar(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `points` int(11) NOT NULL,
  `time` double NOT NULL,
  `attempted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `playerdata`
--

INSERT INTO `playerdata` (`teamcode`, `userid`, `name`, `batch`, `points`, `time`, `attempted`) VALUES
('abc', 0, 'as', 'batch1', 2, 2.5, 0),
('abc', 1, 'sd', 'batch1', 0, 0, 0),
('abc', 2, 'wd', 'batch1', 0, 0, 0),
('abc', 3, 'ad', 'batch1', 0, 0, 0),
('abc123', 0, 'Praneel', 'batch1', 0, 0, 0),
('abc123', 1, 'Kaavish', 'batch1', 0, 0, 0),
('abc123', 2, 'Someone', 'batch1', 0, 0, 0),
('abc123', 3, 'Anyone', 'batch1', 0, 0, 0),
('ad', 0, 'sda', 'batch1', 3, 0, 0),
('ad', 1, 'dsad', 'batch1', 0, 0, 0),
('ad', 2, 'dsadsa', 'batch1', 0, 0, 1),
('ad', 3, 'dsada', 'batch1', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `batch` varchar(10) NOT NULL,
  `qno` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `opt1` varchar(500) NOT NULL,
  `opt2` varchar(500) NOT NULL,
  `opt3` varchar(500) NOT NULL,
  `opt4` varchar(500) NOT NULL,
  `choice1` varchar(500) NOT NULL,
  `choice2` varchar(500) NOT NULL,
  `choice3` varchar(500) NOT NULL,
  `choice4` varchar(500) NOT NULL,
  `correctans` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`batch`, `qno`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `choice1`, `choice2`, `choice3`, `choice4`, `correctans`) VALUES
('batch1', 1, 'Arrange these colors in alphabetical order:', 'A) Blue', ' B) Green', 'C) Red', 'D) Yellow', 'A,B,D,C', 'A,D,C,B', 'D,A,C,B', 'D,A,B,C', 'D,A,B,C'),
('batch1', 2, 'Arrange these historical events chronologically:', 'A) World War I', 'B) French Revolution', 'C) Moon Landing', 'D) Renaissance', 'B,D,A,C', 'C,B,A,D', 'A,D,B,C', 'A,C,B,D', 'B,D,A,C'),
('batch1', 3, 'Arrange these animals in decreasing order of their average lifespan:', 'A) Elephant', ' B) Dog', 'C) Rabbit', 'D) Turtle', 'B,D,A,C', 'A,B,C,D', 'A,D,B,C', 'A,C,B,D', 'B,D,A,C'),
('batch1', 4, 'Arrange these countries in descending order of their population:', 'A) China', 'B) Brazil', 'C) India', 'D) Russia', 'C,A,D,B', 'A,B,C,D', 'A,C,D,B', 'A,C,B,D', 'A,C,B,D'),
('batch1', 5, 'Arrange these actors in alphabetical order:', 'A) Leonardo DiCaprio', 'B) Brad Pitt', 'C) Angelina Jolie', 'D) Meryl Streep', 'D,A,C,B', 'B,A,C,D', 'D,B,A,C', 'D,C,A,B', 'D,B,A,C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `playerdata`
--
ALTER TABLE `playerdata`
  ADD PRIMARY KEY (`teamcode`,`userid`),
  ADD KEY `batch_fk1` (`batch`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`batch`,`qno`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `playerdata`
--
ALTER TABLE `playerdata`
  ADD CONSTRAINT `batch_fk1` FOREIGN KEY (`batch`) REFERENCES `questions` (`batch`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
