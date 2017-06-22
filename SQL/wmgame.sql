-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Mai 2014 um 18:04
-- Server Version: 5.6.16
-- PHP-Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `wmgame`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL,
  `friendid` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`,`friendid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KickOff` datetime NOT NULL,
  `Name` text NOT NULL,
  `Location` text NOT NULL,
  `Team1` int(11) DEFAULT NULL,
  `Team2` int(11) DEFAULT NULL,
  `Goal1` int(11) DEFAULT NULL,
  `Goal2` int(11) DEFAULT NULL,
  `Austragungsort-foto` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Daten für Tabelle `game`
--

INSERT INTO `game` (`ID`, `KickOff`, `Name`, `Location`, `Team1`, `Team2`, `Goal1`, `Goal2`, `Austragungsort-foto`) VALUES
(1, '2014-06-12 22:00:00', 'A', 'Sao Paulo', 1, 28, 1, 1, 'images/Stadien/Sao_Paulo.jpg'),
(2, '2014-06-13 18:00:00', 'A', 'Natal', 31, 24, NULL, NULL, 'images/Stadien/Natal.jpg'),
(3, '2014-06-17 21:00:00', 'A', 'Fortaleza', 1, 31, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(4, '2014-06-19 00:00:00', 'A', 'Manaus', 24, 28, NULL, NULL, 'images/Stadien/Manaus.jpg'),
(5, '2014-06-23 22:00:00', 'A', 'Brasilia', 24, 1, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(6, '2014-06-23 22:00:00', 'A', 'Recife', 28, 31, NULL, NULL, 'images/Stadien/Recife.jpg'),
(7, '2014-06-13 21:00:00', 'B', 'Salvador', 18, 6, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(8, '2014-06-14 00:00:00', 'B', 'Cuiaba', 19, 3, NULL, NULL, 'images/Stadien/Cuiaba.jpg'),
(9, '2014-06-18 18:00:00', 'B', 'Porto Alegre', 3, 6, NULL, NULL, 'images/Stadien/Porto_Alegre.jpg'),
(10, '2014-06-18 21:00:00', 'B', 'Rio de Janeiro', 18, 19, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(11, '2014-06-23 18:00:00', 'B', 'Curitiba', 3, 18, NULL, NULL, 'images/Stadien/Curitiba.jpg'),
(12, '2014-06-23 18:00:00', 'B', 'Sao Paulo', 6, 19, NULL, NULL, 'images/Stadien/Sao_Paulo.jpg'),
(13, '2014-06-14 18:00:00', 'C', 'Belo Horizonte', 14, 27, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(14, '2014-06-15 03:00:00', 'C', 'Recife', 23, 2, NULL, NULL, 'images/Stadien/Recife.jpg'),
(15, '2014-06-19 18:00:00', 'C', 'Brasilia', 14, 23, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(16, '2014-06-20 00:00:00', 'C', 'Natal', 2, 27, NULL, NULL, 'images/Stadien/Natal.jpg'),
(17, '2014-06-24 22:00:00', 'C', 'Cuiaba', 2, 14, NULL, NULL, 'images/Stadien/Cuiaba.jpg'),
(18, '2014-06-24 22:00:00', 'C', 'Fortaleza', 27, 23, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(19, '2014-06-14 21:00:00', 'D', 'Fortaleza', 32, 9, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(20, '2014-06-15 00:00:00', 'D', 'Manaus', 17, 7, NULL, NULL, 'images/Stadien/Manaus.jpg'),
(21, '2014-06-19 21:00:00', 'D', 'Sao Paulo', 32, 17, NULL, NULL, 'images/Stadien/Sao_Paulo.jpg'),
(22, '2014-06-24 18:00:00', 'D', 'Recife', 7, 9, NULL, NULL, 'images/Stadien/Recife.jpg'),
(23, '2014-06-24 18:00:00', 'D', 'Natal', 9, 17, NULL, NULL, 'images/Stadien/Natal.jpg'),
(24, '2014-06-24 18:00:00', 'D', 'Belo Horizonte', 7, 32, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(25, '2014-06-15 18:00:00', 'E', 'Brasilia', 12, 20, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(26, '2014-06-15 21:00:00', 'E', 'Porto Alegre', 30, 21, NULL, NULL, 'images/Stadien/Porto_Alegre.jpg'),
(27, '2014-06-20 21:00:00', 'E', 'Salvador', 12, 30, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(28, '2014-06-21 00:00:00', 'E', 'Curitiba', 21, 20, NULL, NULL, 'images/Stadien/Curitiba.jpg'),
(29, '2014-06-25 22:00:00', 'E', 'Manaus', 21, 12, NULL, NULL, 'images/Stadien/Manaus.jpg'),
(30, '2014-06-25 22:00:00', 'E', 'Rio de Janeiro', 20, 30, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(31, '2014-06-16 00:00:00', 'F', 'Rio de Janeiro', 10, 15, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(32, '2014-06-16 21:00:00', 'F', 'Curitiba', 4, 22, NULL, NULL, 'images/Stadien/Curitiba.jpg'),
(33, '2014-06-21 21:00:00', 'F', 'Belo Horizonte', 10, 4, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(34, '2014-06-22 00:00:00', 'F', 'Cuiaba', 22, 15, NULL, NULL, 'images/Stadien/Cuiaba.jpg'),
(35, '2014-06-25 18:00:00', 'F', 'Porto Alegre', 22, 10, NULL, NULL, 'images/Stadien/Porto_Alegre.jpg'),
(36, '2014-06-25 18:00:00', 'F', 'Salvador', 15, 4, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(37, '2014-06-16 18:00:00', 'G', 'Salvador', 13, 29, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(38, '2014-06-17 00:00:00', 'G', 'Natal', 25, 8, NULL, NULL, 'images/Stadien/Natal.jpg'),
(39, '2014-06-21 21:00:00', 'G', 'Fortaleza', 13, 25, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(40, '2014-06-23 00:00:00', 'G', 'Manaus', 8, 29, NULL, NULL, 'images/Stadien/Manaus.jpg'),
(41, '2014-06-26 18:00:00', 'G', 'Brasilia', 29, 25, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(42, '2014-06-26 18:00:00', 'G', 'Recife', 8, 13, NULL, NULL, 'images/Stadien/Recife.jpg'),
(43, '2014-06-17 18:00:00', 'H', 'Belo Horizonte', 11, 26, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(44, '2014-06-18 00:00:00', 'H', 'Cuiaba', 16, 5, NULL, NULL, 'images/Stadien/Cuiaba.jpg'),
(45, '2014-06-22 21:00:00', 'H', 'Porto Alegre', 5, 26, NULL, NULL, 'images/Stadien/Porto_Alegre.jpg'),
(46, '2014-06-22 18:00:00', 'H', 'Rio de Janeiro', 11, 16, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(47, '2014-06-26 22:00:00', 'H', 'Sao Paulo', 26, 16, NULL, NULL, 'images/Stadien/Sao_Paulo.jpg'),
(48, '2014-06-26 22:00:00', 'H', 'Curitiba', 5, 11, NULL, NULL, 'images/Stadien/Curitiba.jpg'),
(49, '2014-06-28 18:00:00', 'AF1', 'Belo Horizonte', 10, 1, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(50, '2014-06-28 22:00:00', 'AF2', 'Rio de Janeiro', NULL, NULL, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(51, '2014-06-29 18:00:00', 'AF3', 'Fortaleza', NULL, NULL, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(52, '2014-06-29 22:00:00', 'AF4', 'Recife', NULL, NULL, NULL, NULL, 'images/Stadien/Recife.jpg'),
(53, '2014-06-30 18:00:00', 'AF5', 'Brasilia', NULL, NULL, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(54, '2014-06-30 22:00:00', 'AF6', 'Porto Alegre', NULL, NULL, NULL, NULL, 'images/Stadien/Porto_Alegre.jpg'),
(55, '2014-07-01 18:00:00', 'AF7', 'Sao Paulo', NULL, NULL, NULL, NULL, 'images/Stadien/Sao_Paulo.jpg'),
(56, '2014-07-01 22:00:00', 'AF8', 'Salvador', NULL, NULL, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(57, '2014-07-04 22:00:00', 'VF1', 'Fortaleza', NULL, NULL, NULL, NULL, 'images/Stadien/Fortaleza.jpg'),
(58, '2014-07-04 18:00:00', 'VF3', 'Rio de Janeiro', NULL, NULL, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg'),
(59, '2014-07-05 22:00:00', 'VF2', 'Salvador', NULL, NULL, NULL, NULL, 'images/Stadien/Salvador_de_Bahia.jpg'),
(60, '2014-07-05 18:00:00', 'VF4', 'Brasilia', NULL, NULL, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(61, '2014-07-08 22:00:00', 'HF1', 'Belo Horizonte', NULL, NULL, NULL, NULL, 'images/Stadien/Belo_Horizonte.jpg'),
(62, '2014-07-09 22:00:00', 'HF2', 'Sao Paulo', NULL, NULL, NULL, NULL, 'images/Stadien/Sao_Paulo.jpg'),
(63, '2014-07-12 22:00:00', 'SpuP3', 'Brasilia', NULL, NULL, NULL, NULL, 'images/Stadien/Brasilia.jpg'),
(64, '2014-07-13 21:00:00', 'FINALE', 'Rio de Janeiro', NULL, NULL, NULL, NULL, 'images/Stadien/Rio_de_Janeiro.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message_system`
--

CREATE TABLE IF NOT EXISTS `message_system` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `realdate` datetime NOT NULL,
  `date` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `del_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `del_sender` tinyint(1) NOT NULL DEFAULT '0',
  `message_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_date` datetime NOT NULL,
  `IP` varchar(15) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `message_system`
--

INSERT INTO `message_system` (`message_id`, `realdate`, `date`, `message`, `sender`, `receiver`, `del_receiver`, `del_sender`, `message_read`, `read_date`, `IP`) VALUES
(1, '2014-05-30 09:04:05', 1212121, 'Hi! Dies ist ein Beispiel für die News-Spalte. Der Text kann beliebig sein.', 0, 0, 0, 0, 0, '2014-05-30 00:00:00', '::1');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `rangliste`
--
CREATE TABLE IF NOT EXISTS `rangliste` (
`id` int(11)
,`points` decimal(23,0)
);
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Flaggen` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Daten für Tabelle `team`
--

INSERT INTO `team` (`ID`, `Name`, `Flaggen`) VALUES
(1, 'Brasilien', 'images/flags/Brasilien.png'),
(2, 'Japan', 'images/flags/Japan.png'),
(3, 'Australien', 'images/flags/Australien.png'),
(4, 'Iran', 'images/flags/Iran.png'),
(5, 'Südkorea', 'images/flags/Suedkorea.png'),
(6, 'Niederlande', 'images/flags/Holland.png'),
(7, 'Italien', 'images/flags/Italien.png'),
(8, 'Vereinigte Staaten', 'images/flags/USA.png'),
(9, 'Costa Rica', 'images/flags/Costa_Rica.png'),
(10, 'Argentinien', 'images/flags/Argentinien.png'),
(11, 'Belgien', 'images/flags/Belgien.png'),
(12, 'Schweiz', 'images/flags/Schweiz.png'),
(13, 'Deutschland', 'images/flags/Deutschland.png'),
(14, 'Kolumbien', 'images/flags/Kolumbien.png'),
(15, 'Bosnien und Herzegowina', 'images/flags/Bosnien_und_Herzogowina.png'),
(16, 'Russland', 'images/flags/Russland.png'),
(17, 'England', 'images/flags/England.png'),
(18, 'Spanien', 'images/flags/Spanien.png'),
(19, 'Chile', 'images/flags/Chile.png'),
(20, 'Ecuador', 'images/flags/Ecuador.png'),
(21, 'Honduras', 'images/flags/Honduras.png'),
(22, 'Nigeria', 'images/flags/Nigeria.png'),
(23, 'Elfenbeinküste', 'images/flags/Elfenbeinkueste.png'),
(24, 'Kamerun', 'images/flags/Kamerun.png'),
(25, 'Ghana', 'images/flags/Ghana.png'),
(26, 'Algerien', 'images/flags/Algerien.png'),
(27, 'Griechenland', 'images/flags/Griechenland.png'),
(28, 'Kroatien', 'images/flags/Kroatien.png'),
(29, 'Portugal', 'images/flags/Portugal.png'),
(30, 'Frankreich', 'images/flags/Frankreich.png'),
(31, 'Mexiko', 'images/flags/Mexiko.png'),
(32, 'Uruguay', 'images/flags/Uruguay.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tip`
--

CREATE TABLE IF NOT EXISTS `tip` (
  `UID` int(11) NOT NULL,
  `GID` int(11) NOT NULL,
  `Home` int(11) NOT NULL,
  `Away` int(11) NOT NULL,
  PRIMARY KEY (`UID`,`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Admin` tinyint(4) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UName` (`username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `Email`, `Admin`, `confirmed`, `code`, `date`, `status`) VALUES
(1, 'Felix', '6435304d57f3d997094e221d2a9c9039bb37f1ba', 'felix.gabler98@gmail.com', 1, 1, '', '0000-00-00 00:00:00', ''),
(2, 'jader13254', 'e180e2c7d18caa6cef8c126370c2daaf29781557', 'janmariusme@gmail.com', 1, 1, '', '2014-05-30 00:00:00', 'Hi'),
(3, 'helfrich', '0719708d1cc814839bd818fdc27d446652f03383', 'helfrich@kepi.de', 1, 1, '', '0000-00-00 00:00:00', ''),
(4, 'kilian', '2e2b6533a81bc15430cf65de46dc097eeb5ba70c', 'ruesski@gmail.com', 1, 1, '1234', '0000-00-00 00:00:00', ''),
(5, 'BlueFirefly', '0719708d1cc814839bd818fdc27d446652f03383', 'Jan-Povolni@gmx.de', 1, 1, '', '0000-00-00 00:00:00', ''),
(6, 'Tabea Redl', '0719708d1cc814839bd818fdc27d446652f03383', 'tabea.redl@t-online.de', 1, 0, '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Struktur des Views `rangliste`
--
DROP TABLE IF EXISTS `rangliste`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rangliste` AS select `user`.`ID` AS `id`,sum((case when ((`tip`.`Home` = `game`.`Goal1`) and (`tip`.`Away` = `game`.`Goal2`)) then 3 when ((`tip`.`Home` - `tip`.`Away`) = (`game`.`Goal1` - `game`.`Goal2`)) then 2 when (sign((`tip`.`Home` - `tip`.`Away`)) = sign((`game`.`Goal1` - `game`.`Goal2`))) then 1 else 0 end)) AS `points` from ((`user` left join `tip` on((`tip`.`UID` = `user`.`ID`))) left join `game` on((`tip`.`GID` = `game`.`ID`))) group by `user`.`ID` order by sum((case when ((`tip`.`Home` = `game`.`Goal1`) and (`tip`.`Away` = `game`.`Goal2`)) then 3 when ((`tip`.`Home` - `tip`.`Away`) = (`game`.`Goal1` - `game`.`Goal2`)) then 2 when (sign((`tip`.`Home` - `tip`.`Away`)) = sign((`game`.`Goal1` - `game`.`Goal2`))) then 1 else 0 end)) desc;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
