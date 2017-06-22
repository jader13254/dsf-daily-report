-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Jun 2017 um 12:22
-- Server-Version: 10.1.13-MariaDB
-- PHP-Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dailyreport`
--

CREATE TABLE `dailyreport` (
  `reportID` int(11) NOT NULL,
  `timeTableID` int(11) NOT NULL,
  `schoolCode` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `class` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `module` varchar(20) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userID` varchar(10) NOT NULL,
  `fromTime` datetime NOT NULL,
  `toTime` datetime NOT NULL,
  `remarks` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `dailyreport`
--

INSERT INTO `dailyreport` (`reportID`, `timeTableID`, `schoolCode`, `date`, `class`, `strength`, `subject`, `module`, `userName`, `userID`, `fromTime`, `toTime`, `remarks`) VALUES
(1, 1, '1', '2017-06-20 16:16:33', 5, 30, 'Computer', '1', 'jader13254', '2', '2017-06-20 17:00:00', '2017-06-20 19:00:00', 'Hello World!'),
(2, 2, '1', '2017-06-20 15:59:07', 5, 1, 'Maths', '101', 'jader13254', '2', '2017-06-20 07:00:00', '2017-06-20 01:00:00', 'sds'),
(3, 3, '1', '2017-06-20 16:16:00', 10, 40, 'English', '1', 'jader13254', '2', '2017-06-20 10:00:00', '2017-06-20 13:00:00', 'Kids were loud.'),
(7, 8, '2', '2017-06-21 13:51:54', 12, 15, 'Arts', '', 'jader13254', '2', '2017-06-21 13:00:00', '2017-06-21 15:00:00', ''),
(8, 14, '1', '2017-06-21 13:55:31', 12, 15, 'English', '', 'kilian', '4', '2017-06-21 12:00:00', '2017-06-21 13:00:00', ''),
(9, 15, '2', '2017-06-21 16:03:25', 10, 12, 'Math', '', 'helfrich', '3', '2017-06-21 10:00:00', '2017-06-21 11:00:00', ''),
(12, 0, '2', '2017-06-21 16:51:23', 12, 14, 'Math', '', 'jader13254', '2', '2017-06-21 12:00:00', '2017-06-21 13:00:00', 'Hi World'),
(13, 13, '2', '2017-06-21 17:14:54', 11, 80, 'Computer Science', '', 'jader13254', '2', '2017-06-21 11:00:00', '2017-06-21 12:00:00', ''),
(15, 50, '1', '2017-06-21 17:49:46', 11, 16, 'Math', '11', 'helfrich', '3', '2017-06-21 08:00:00', '2017-06-21 12:00:00', 'Superb Math Session Kids Were Great Mate'),
(16, 51, '2', '2017-06-21 17:53:59', 12, 100, 'Mathematics', '10', 'kilian', '4', '2017-06-21 07:00:00', '2017-06-21 10:00:00', 'Class was great. I thnk all my teachers.');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `rangliste`
--
CREATE TABLE `rangliste` (
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schoolmaster`
--

CREATE TABLE `schoolmaster` (
  `schoolCode` varchar(11) NOT NULL,
  `DSFCoord` int(11) NOT NULL,
  `clusterID` varchar(3) NOT NULL,
  `clusterName` varchar(25) NOT NULL,
  `locationID` varchar(3) NOT NULL,
  `location` varchar(25) NOT NULL,
  `schoolID` varchar(5) NOT NULL,
  `schoolName` varchar(70) NOT NULL,
  `schoolCategory` varchar(5) NOT NULL,
  `schoolHM` varchar(50) NOT NULL,
  `contactNo` varchar(11) NOT NULL,
  `totalStrength` int(11) DEFAULT NULL,
  `schoolStaff` int(11) DEFAULT NULL,
  `latitude` int(11) DEFAULT NULL,
  `longitude` int(11) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `schoolmaster`
--

INSERT INTO `schoolmaster` (`schoolCode`, `DSFCoord`, `clusterID`, `clusterName`, `locationID`, `location`, `schoolID`, `schoolName`, `schoolCategory`, `schoolHM`, `contactNo`, `totalStrength`, `schoolStaff`, `latitude`, `longitude`, `address`) VALUES
('1', 1, '1', 'RTN', '1', 'JC Nagar', '1', 'GUHMPS', 'HS', 'Ishrat', '123456', 123, 12, 1212, 1212, NULL),
('2', 2, '3', 'MWM', 'XYZ', 'MSLane School', '', 'New School', 'IDK', 'SOME person', '4916392721', 500, 1, 12, 12, 'Some adress in bangalore but 50 signs');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schooltt`
--

CREATE TABLE `schooltt` (
  `serialNo` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `schoolCode` varchar(11) NOT NULL,
  `class` int(11) NOT NULL,
  `activityType` varchar(15) NOT NULL,
  `classType` varchar(20) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `module` varchar(40) NOT NULL,
  `userID` int(11) NOT NULL,
  `assignedByID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `schooltt`
--

INSERT INTO `schooltt` (`serialNo`, `date`, `schoolCode`, `class`, `activityType`, `classType`, `subject`, `module`, `userID`, `assignedByID`) VALUES
(1, '2017-06-30 17:00:00', '1', 5, 'Academic', 'Computer Setup', 'Computer', '1', 2, 3),
(2, '2016-11-26 07:00:00', '1', 5, 'Non academic', 'Serious', 'Maths', '101', 2, 3),
(3, '2016-11-26 11:00:00', '1', 10, 'Support', 'Q and A', 'English', '1', 2, 3),
(7, '2017-06-18 10:00:00', '1', 5, 'BSugar', 'Pook', 'Georgraphy', '16', 2, 3),
(8, '2017-06-21 13:00:00', '2', 12, 'Arts & Craft', '', 'Arts', '', 2, 5),
(13, '2017-06-22 11:00:00', '2', 11, 'Lesson', 'Computer Lab', 'Computer Science', '', 2, 2),
(14, '2017-06-22 12:00:00', '1', 12, 'Fun', '', 'English', '', 4, 2),
(15, '2017-08-12 10:00:00', '2', -1, '', '', '', '', 3, 2),
(49, '2017-03-12 08:00:00', '1', -1, '', '', '', '', 2, 2),
(50, '2017-03-12 08:00:00', '1', -1, '', '', '', '', 3, 2),
(51, '2017-08-12 07:00:00', '2', 12, 'Serious', '', 'Mathematics', '10', 4, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `subjectID` varchar(20) NOT NULL,
  `subjectName` varchar(40) NOT NULL,
  `moduleName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userID`, `userName`, `password`, `email`, `role`, `confirmed`, `code`, `date`, `status`) VALUES
(1, 'fakeUserForNews', 'e92172b66cee187c9870fc08d5ef7e68a12b8fb92f10f6860d76d75f880df50e', 'felix@felix.com', 0, 1, 'Adi and Jan started working on the DSF Daily Reports App.', '0000-00-00', ''),
(2, 'jader13254', '1c666d3c24be6c9262f048cb6b05701f8f74281d0b571e31b11c91e10b9dd852', 'janmariusme@gmail.com', 2, 1, '', '0000-00-00', 'Hi whoever reads this.'),
(3, 'helfrich', '1c666d3c24be6c9262f048cb6b05701f8f74281d0b571e31b11c91e10b9dd852', 'helfrich@kepi.de', 1, 1, '', '0000-00-00', 'Love the new DSF APP!'),
(4, 'kilian', '1c666d3c24be6c9262f048cb6b05701f8f74281d0b571e31b11c91e10b9dd852', 'ruesski@gmail.com', 0, 1, '1234', '0000-00-00', ''),
(5, 'BlueFirefly', '1c666d3c24be6c9262f048cb6b05701f8f74281d0b571e31b11c91e10b9dd852', 'Jan-Povolni@gmx.de', 0, 1, '', '0000-00-00', ''),
(6, 'Tabea Redl', '0956eefca78aaf08f6c4319bd9c5553823322043e3f1033469b78af9e750b6fa', 'tabea.redl@t-online.de', 0, 0, '', '0000-00-00', ''),
(7, 'fussball', 'e92172b66cee187c9870fc08d5ef7e68a12b8fb92f10f6860d76d75f880df50e', 'rar@ara.com', 2, 1, '', '0000-00-00', ''),
(8, 'NewUser', 'e92172b66cee187c9870fc08d5ef7e68a12b8fb92f10f6860d76d75f880df50e', 'newuser@new.com', 2, 1, '', '0000-00-00', ''),
(10, 'user1', 'c7f26212fd5bef5fe7143b6a0db123372781df6d840d836943a15e73cd4906c6', 'sas@dasd.com', 2, 1, '', '0000-00-00', ''),
(11, 'ssdsafsa', 'c7f26212fd5bef5fe7143b6a0db123372781df6d840d836943a15e73cd4906c6', 'ss@ss.com', 2, 1, '', '0000-00-00', ''),
(12, 'test123', '1c666d3c24be6c9262f048cb6b05701f8f74281d0b571e31b11c91e10b9dd852', 'ss@ss1.com', 2, 1, '', '0000-00-00', ''),
(13, 'demouser', '46c3f68d7c2da6db9268509d24b79e21c4ba6b7f1420017b6d031d5b22e6a3d3', 'demo@demo.com', 0, 1, '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Struktur des Views `rangliste`
--
DROP TABLE IF EXISTS `rangliste`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rangliste`  AS  select `user`.`ID` AS `id`,sum((case when ((`tip`.`Home` = `game`.`Goal1`) and (`tip`.`Away` = `game`.`Goal2`)) then 3 when ((`tip`.`Home` - `tip`.`Away`) = (`game`.`Goal1` - `game`.`Goal2`)) then 2 when (sign((`tip`.`Home` - `tip`.`Away`)) = sign((`game`.`Goal1` - `game`.`Goal2`))) then 1 else 0 end)) AS `points` from ((`user` left join `tip` on((`tip`.`UID` = `user`.`ID`))) left join `game` on((`tip`.`GID` = `game`.`ID`))) group by `user`.`ID` order by sum((case when ((`tip`.`Home` = `game`.`Goal1`) and (`tip`.`Away` = `game`.`Goal2`)) then 3 when ((`tip`.`Home` - `tip`.`Away`) = (`game`.`Goal1` - `game`.`Goal2`)) then 2 when (sign((`tip`.`Home` - `tip`.`Away`)) = sign((`game`.`Goal1` - `game`.`Goal2`))) then 1 else 0 end)) desc ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `dailyreport`
--
ALTER TABLE `dailyreport`
  ADD PRIMARY KEY (`reportID`),
  ADD UNIQUE KEY `timeTableID` (`timeTableID`);

--
-- Indizes für die Tabelle `schoolmaster`
--
ALTER TABLE `schoolmaster`
  ADD PRIMARY KEY (`schoolCode`);

--
-- Indizes für die Tabelle `schooltt`
--
ALTER TABLE `schooltt`
  ADD PRIMARY KEY (`serialNo`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectID`(10));

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `UName` (`userName`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `dailyreport`
--
ALTER TABLE `dailyreport`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT für Tabelle `schooltt`
--
ALTER TABLE `schooltt`
  MODIFY `serialNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
