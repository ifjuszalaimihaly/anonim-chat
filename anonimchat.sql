-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3308
-- Létrehozás ideje: 2021. Már 20. 09:02
-- Kiszolgáló verziója: 5.7.28
-- PHP verzió: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `anonimchat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` int(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `partner` varchar(6) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `partner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

DELIMITER $$
--
-- Események
--
DROP EVENT `cleaning`$$
CREATE DEFINER=`root`@`localhost` EVENT `cleaning` ON SCHEDULE EVERY 1 SECOND STARTS '2021-03-12 11:53:38' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM users
  WHERE `updated_at` < CURRENT_TIMESTAMP - INTERVAL 60 SECOND$$

DROP EVENT `cleaning messages`$$
CREATE DEFINER=`root`@`localhost` EVENT `cleaning messages` ON SCHEDULE EVERY 1 SECOND STARTS '2021-03-12 13:46:04' ON COMPLETION NOT PRESERVE ENABLE DO DELETE messages FROM messages LEFT JOIN users as outgoing ON outgoing.unique_id = messages.outgoing_msg_id LEFT JOIN users AS incoming ON incoming.unique_id = messages.incoming_msg_id WHERE outgoing.user_id IS NULL AND incoming.user_id IS NULL$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
