SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


--
-- Struktur-dump for tabellen `ecv`
--

CREATE TABLE IF NOT EXISTS `ecv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edu` varchar(255) COLLATE utf8_danish_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_danish_ci NOT NULL,
  `syear` int(11) NOT NULL,
  `eyear` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `ecv`
--

INSERT INTO `ecv` (`id`, `edu`, `location`, `syear`, `eyear`, `uid`) VALUES
(1, 'IngeniÃ¸r', 'Danmarks Tekniske Universitet', 2006, 2009, 9);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` bigint(20) NOT NULL,
  `recipient` bigint(20) NOT NULL,
  `sendername` varchar(255) NOT NULL,
  `recipientname` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `msg` longtext NOT NULL,
  `sdate` varchar(255) NOT NULL,
  `stime` varchar(255) NOT NULL,
  `nmsg` int(11) NOT NULL DEFAULT '1',
  `sactive` int(11) NOT NULL DEFAULT '1',
  `ractive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pcv`
--

CREATE TABLE IF NOT EXISTS `pcv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8_danish_ci NOT NULL,
  `business` varchar(255) COLLATE utf8_danish_ci NOT NULL,
  `syear` int(11) NOT NULL,
  `eyear` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `budget` varchar(255) NOT NULL,
  `deadline` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `comp` varchar(255) NOT NULL,
  `desc` longtext NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `postal` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `competencies` varchar(255) NOT NULL,
  `a_userid` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `register_date` varchar(255) NOT NULL,
  `level` int(2) NOT NULL DEFAULT '0',
  `actcode` varchar(15) NOT NULL,
  `approval` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `phone`, `website`, `postal`, `city`, `address`, `competencies`, `a_userid`, `ip`, `time`, `last_login`, `register_date`, `level`, `actcode`, `approval`) VALUES
(1, 'Admin', 'admin', 'abe51283967590ae0b987571b4ae28bc0a91e8435a97edb8e8949ae1f3a32760afbed9a6c', 'kontakt@aftalt.dk', '', '', '', '', '', '', 'e5a5ca2008f3d210fc674bf8e52319987192539d3606ec5aca27943b1172854f33e861243', '5.56.146.72', '1370352788', '04-06-2013 15:33:08', '14-12-2012 10:41:10', 5, 'FXogIE1AnV6J5tU', 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
