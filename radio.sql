-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost:3306
-- Timp de generare: mart. 18, 2022 la 12:54 PM
-- Versiune server: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- Versiune PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `radio`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(300) NOT NULL,
  `usrtoken` varchar(100) NOT NULL,
  `rank` int(5) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(55) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `data` int(55) DEFAULT NULL,
  `contry` varchar(55) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `ip` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `admins`
--

INSERT INTO `admins` (`id`, `user`, `pass`, `usrtoken`, `rank`, `email`, `mobile`, `Name`, `data`, `contry`, `city`, `ip`) VALUES
(1, 'admin', '89c057/61eddc5a/6cced957/635a66572a69a2a02c2d74892d', 'vZgc609ZapkA720mezIBXMFxDhObCBi5suXSgSKQzF2U0LFV8DHagxA2CZwCGbD77FhDIN2XNhS1vEVG3tkqB', 1, 'test@test.com', '0722222222', 'Administrator', 1647592681, '', '', '');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `title` varchar(55) NOT NULL DEFAULT 'Radio Panel',
  `display_limit` int(10) NOT NULL DEFAULT '100',
  `host_add` varchar(55) NOT NULL,
  `os` varchar(55) NOT NULL DEFAULT 'linux',
  `dir_to_cpanel` varchar(100) NOT NULL,
  `scs_config` int(10) NOT NULL DEFAULT '1',
  `adj_config` int(10) NOT NULL DEFAULT '1',
  `php_mp3` int(10) NOT NULL DEFAULT '20',
  `php_exe` int(20) NOT NULL DEFAULT '250',
  `update_check` int(5) NOT NULL DEFAULT '0',
  `ssh_user` varchar(55) NOT NULL,
  `ssh_pass` varchar(55) NOT NULL,
  `ssh_port` int(10) NOT NULL DEFAULT '22',
  `shellset` varchar(55) NOT NULL DEFAULT 'ssh2',
  `server_news` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `config`
--

INSERT INTO `config` (`id`, `title`, `display_limit`, `host_add`, `os`, `dir_to_cpanel`, `scs_config`, `adj_config`, `php_mp3`, `php_exe`, `update_check`, `ssh_user`, `ssh_pass`, `ssh_port`, `shellset`, `server_news`) VALUES
(1, 'Radio Panel', 10, 'site.com', 'linux', '/var/www/vhosts/site.com/httpdocs/', 0, 1, 20, 250, 0, '', '', 22, 'shellexec', 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `dj`
--

CREATE TABLE `dj` (
  `id` int(10) NOT NULL,
  `login` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `djpriority` int(10) NOT NULL DEFAULT '0',
  `server` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `owner` varchar(100) NOT NULL DEFAULT '',
  `maxuser` varchar(100) NOT NULL DEFAULT '',
  `portbase` int(11) NOT NULL DEFAULT '0',
  `bitrate` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT 'testing',
  `adminpassword` varchar(100) NOT NULL DEFAULT '',
  `sitepublic` varchar(100) NOT NULL DEFAULT '1',
  `logfile` varchar(400) NOT NULL DEFAULT '../temp/{port}/logs/sc_{port}.log',
  `realtime` varchar(100) NOT NULL DEFAULT '1',
  `screenlog` varchar(100) NOT NULL DEFAULT '0',
  `showlastsongs` varchar(100) NOT NULL DEFAULT '10',
  `tchlog` varchar(100) NOT NULL DEFAULT 'no',
  `weblog` varchar(100) NOT NULL DEFAULT 'no',
  `w3cenable` varchar(100) NOT NULL DEFAULT 'no',
  `w3clog` varchar(400) NOT NULL DEFAULT '../temp/{port}/w3c/sc_w3c.log',
  `banfile` varchar(400) NOT NULL DEFAULT '../temp/{port}/logs/banfile.ban',
  `ripfile` varchar(400) NOT NULL DEFAULT '../temp/{port}/logs/ripfile.rip',
  `yp2` varchar(100) NOT NULL DEFAULT '1',
  `uvox2sourcedebug` varchar(100) NOT NULL DEFAULT '1',
  `srcip` varchar(100) NOT NULL DEFAULT 'ANY',
  `destip` varchar(100) NOT NULL DEFAULT 'ANY',
  `yport` varchar(100) NOT NULL DEFAULT '80',
  `namelookups` varchar(100) NOT NULL DEFAULT '0',
  `relayport` varchar(100) NOT NULL DEFAULT '0',
  `relayserver` varchar(100) NOT NULL DEFAULT 'empty',
  `autodumpusers` varchar(100) NOT NULL DEFAULT '0',
  `autodumpsourcetime` varchar(100) NOT NULL DEFAULT '30',
  `contentdir` varchar(100) NOT NULL DEFAULT '',
  `introfile` varchar(100) NOT NULL DEFAULT '',
  `titleformat` varchar(100) NOT NULL DEFAULT '',
  `urlformat` varchar(400) NOT NULL DEFAULT 'http://',
  `publicserver` varchar(100) NOT NULL DEFAULT 'default',
  `allowrelay` varchar(100) NOT NULL DEFAULT 'Yes',
  `allowpublicrelay` varchar(100) NOT NULL DEFAULT 'Yes',
  `metainterval` varchar(100) NOT NULL DEFAULT '8192',
  `abuse` int(11) NOT NULL DEFAULT '0',
  `pid` varchar(100) NOT NULL DEFAULT '',
  `autopid` varchar(100) NOT NULL,
  `webspace` varchar(100) NOT NULL,
  `serverip` varchar(100) NOT NULL DEFAULT '127.0.0.1',
  `serverport` varchar(100) NOT NULL,
  `streamtitle` varchar(100) NOT NULL,
  `streamurl` varchar(400) NOT NULL,
  `shuffle` int(1) NOT NULL DEFAULT '1',
  `samplerate` varchar(100) NOT NULL,
  `channels` int(1) NOT NULL DEFAULT '2',
  `genre` varchar(100) NOT NULL,
  `public` int(1) NOT NULL DEFAULT '1',
  `aim` varchar(100) DEFAULT NULL,
  `icq` varchar(100) DEFAULT NULL,
  `irc` varchar(100) DEFAULT NULL,
  `encoder` varchar(100) NOT NULL DEFAULT 'aacp',
  `mp3quality` varchar(100) NOT NULL DEFAULT '0',
  `mp3mode` varchar(100) NOT NULL DEFAULT '0',
  `calendarrewrite` varchar(100) NOT NULL DEFAULT '0',
  `calendarfile` varchar(400) NOT NULL DEFAULT '../temp/{port}/calendar/calendar.xml',
  `outprotocol` varchar(100) NOT NULL DEFAULT '1',
  `log` varchar(100) NOT NULL DEFAULT '0',
  `displaymetadatapattern` varchar(100) NOT NULL DEFAULT '%R [-] %N',
  `useMetadata` varchar(100) NOT NULL DEFAULT '1',
  `xfade` varchar(100) NOT NULL DEFAULT '4',
  `xfadethreshol` varchar(100) NOT NULL DEFAULT '20',
  `uvoxradiometadata` varchar(100) NOT NULL DEFAULT '0',
  `uvoxnewmetadata` varchar(100) NOT NULL DEFAULT '1',
  `djcapture` varchar(100) NOT NULL DEFAULT '0',
  `djport_1` varchar(100) NOT NULL DEFAULT '21000',
  `djbroadcasts` varchar(400) NOT NULL DEFAULT '../temp/{port}/record',
  `unlockkeyname` varchar(100) NOT NULL DEFAULT 'Ronny Shippo21',
  `unlockkeycode` varchar(100) NOT NULL DEFAULT '482QP-480TU-J4MFD-VF4YK'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `ticket`
--

CREATE TABLE `ticket` (
  `id` int(10) NOT NULL,
  `user` varchar(55) NOT NULL,
  `subiect` varchar(55) NOT NULL,
  `departament` varchar(55) NOT NULL,
  `mesaje` text NOT NULL,
  `data` int(55) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `dj`
--
ALTER TABLE `dj`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pentru tabele `dj`
--
ALTER TABLE `dj`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pentru tabele `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
