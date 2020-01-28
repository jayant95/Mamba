-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2020 at 05:38 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mamba`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `hearts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `hearts`
--

CREATE TABLE `hearts` (
  `heartID` int(11) NOT NULL,
  `storyID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `hearts`
--

INSERT INTO `hearts` (`heartID`, `storyID`, `memberID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 1),
(4, 3, 1),
(5, 4, 1),
(6, 2, 2),
(7, 4, 2),
(8, 1, 2),
(9, 5, 2),
(10, 6, 2),
(11, 5, 1),
(12, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `firstName`, `lastName`, `email`, `username`, `password`) VALUES
(1, 'Jayant', 'Tailor', 'jht1995@hotmail.com', 'jayant95', '$2y$10$F99Rdi1MU7IjWfcpV6jukeE8KhOfAV9IWmpvOSBlxTux6hF0Dwoki'),
(2, 'Jay', 'Tailor', 'jayant@deltoyd.com', 'Deltoyd', '$2y$10$5eRl.rZtwXjh0tMmunOSAeNQtQwiBl5JhN36igK3hMAb0GVl.Ve7e');

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `storyID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `story` text NOT NULL,
  `heart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`storyID`, `memberID`, `timestamp`, `username`, `title`, `story`, `heart`) VALUES
(1, 1, '1580092265', 'jayant95', 'Children', 'Jellybean was here', 4),
(2, 1, '1580148886', 'jayant95', 'Sample Post from John Celestand', 'â€œWhen I went out to warm up Kobe looked at me and he was so disappointed,â€ Celestand said. â€œHe said, â€˜Now that youâ€™re going to play a lot today, you donâ€™t come early anymore?â€™â€\r\n\r\nThe comment pierced Celestand like an arrow.\r\n\r\nâ€œIâ€™ll never forget feeling so ashamed because he was right,â€ Celestand said. â€œI had put in all that work and now that I was going to get in, I stopped working.â€\r\n\r\nOver the years, that shame morphed into motivation.\r\n\r\nâ€œThere are days I think about him, just as a person not even playing basketball: What would Kobe do?â€ Celestand said. â€œIf I donâ€™t feel like getting up early, or staying late at work, I ask myself that question.â€\r\n\r\nCelestand knew about Kobe well before the general public. As a freshman at Villanova in 1995, he heard the buzz surrounding this phenom at nearby Lower Merion High School (Pa.).\r\n\r\nâ€œWe were recruiting him, and I remember he was at one of our games and afterward he comes into the locker room,â€ Celestand said. â€œI said, â€˜What are you going to do next?â€™ He said, \'Iâ€™m thinking about skipping college altogether.â€™â€\r\n\r\nCelestand said he and teammate Howard Brown laughed about it later that night.\r\n\r\nâ€œWe said, â€˜Who does that as a guard?â€™â€ Celestand said. â€œThe next year, he was in the NBA.â€', 2),
(3, 1, '1580161456', 'jayant95', 'Another Snippet', 'But for Bryant, the move -- particularly publishing books -- just made sense to him.\r\n\r\n\"You got to do what you love to do,\" he said. \"I love telling stories. I love inspiring kids or providing them with tools that are going to help them.\"', 1),
(4, 1, '1580162946', 'jayant95', 'A true inspiration', 'Everything negative - pressure, challenges - is all an opportunity for me to rise.\r\nI\'ll do whatever it takes to win games, whether it\'s sitting on a bench waving a towel, handing a cup of water to a teammate, or hitting the game-winning shot.\r\nThese young guys are playing checkers. I\'m out there playing chess.\r\nMy parents are my backbone. Still are. They\'re the only group that will support you if you score zero or you score 40.\r\nI don\'t want to be the next Michael Jordan, I only want to be Kobe Bryant.\r\nThere\'s been a lot of talk of me being a one-man show but that\'s simply not the case. We win games when I score 40 points and we\'ve won when I score 10.', 2),
(5, 1, '1580165225', 'jayant95', 'One of the greatest ', 'Kobe Bean Bryant was an American professional basketball player. A shooting guard, Bryant played his entire 20-season career in the National Basketball Association with the Los Angeles Lakers. He entered the NBA directly from high school and won five NBA championships', 2),
(6, 2, '1580174635', 'Deltoyd', 'New Post', 'Bryant\'s fortunes would improve when Phil Jackson took over as coach of the Lakers in 1999.[62] After years of steady improvement, Bryant became one of the premier shooting guards in the league, earning appearances in the league\'s All-NBA,[63] All-Star, and All-Defensive teams.[64] \r\n\r\nThe Lakers became championship contenders under Bryant and O\'Neal, who formed a legendary center-guard combination. Jackson utilized the triangle offense that he implemented to win six championships with the Chicago Bulls; this offense would help both Bryant and O\'Neal rise to the elite class of the NBA. Three championships were won consecutively in 2000, 2001, and 2002, further cementing this view.[65]', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `hearts`
--
ALTER TABLE `hearts`
  ADD PRIMARY KEY (`heartID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`storyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hearts`
--
ALTER TABLE `hearts`
  MODIFY `heartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `story`
--
ALTER TABLE `story`
  MODIFY `storyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
