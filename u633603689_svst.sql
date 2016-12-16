
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 16 Dec 2016 la 11:34
-- Versiune server: 10.0.20-MariaDB
-- Versiune PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza de date: `u633603689_svst`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `server_activations`
--

CREATE TABLE IF NOT EXISTS `server_activations` (
  `tokenID` bigint(200) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tokenID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Salvarea datelor din tabel `server_activations`
--

INSERT INTO `server_activations` (`tokenID`, `server_name`, `token`, `expire_time`) VALUES
(15, 'ANGELS.DARKNIGHT.RO', '0k4nryqoqvrbuqyta5wue22a56jnhfwq', '2016-12-15');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `server_stats`
--

CREATE TABLE IF NOT EXISTS `server_stats` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `server_ip` text COLLATE utf8_unicode_ci NOT NULL,
  `server_port` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `server_slots` int(2) NOT NULL,
  `server_mode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `server_active` int(1) NOT NULL DEFAULT '0',
  `server_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `server_votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sv_name` (`server_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Salvarea datelor din tabel `server_stats`
--

INSERT INTO `server_stats` (`id`, `server_name`, `server_ip`, `server_port`, `server_slots`, `server_mode`, `server_active`, `server_contact`, `server_votes`) VALUES
(1, ' STAR.UXG.RO', '93.119.24.190', '27015', 32, 'Clasic', 1, 'llg_staark@yahoo.com', 0),
(2, 'ANGELS.DARKNIGHT.RO', '93.119.24.96', '27015', 32, 'Clasic', 1, 'llg_staark@yahoo.com', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `server_votes`
--

CREATE TABLE IF NOT EXISTS `server_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_server` int(11) NOT NULL,
  `vote_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `vote_rate` int(11) NOT NULL,
  `vote_time` text COLLATE utf8_unicode_ci NOT NULL,
  `vote_end` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
