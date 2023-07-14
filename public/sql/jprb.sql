-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 05. Apr 2022 um 15:56
-- Server-Version: 5.5.57-MariaDB
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `jprb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stellen`
--

CREATE TABLE `stellen` (
  `id` int(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `stellen`
--

INSERT INTO `stellen` (`id`, `id_unternehmen`, `id_user`, `name`, `beschreibung`) VALUES
(1, 1, 1, 'Mediengestalter (M/W/D)', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.'),
(2, 2, 3, 'Elektriker (M/W/D)', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.'),
(3, 1, 1, 'Webentwickler(M/W/D)', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.'),
(4, 1, 2, 'Webdesigner (M/W/D)', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `unternehmen`
--

CREATE TABLE `unternehmen` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `strasse` varchar(255) NOT NULL,
  `plz` int(5) NOT NULL,
  `ort` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `apikey` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `unternehmen`
--

INSERT INTO `unternehmen` (`id`, `name`, `strasse`, `plz`, `ort`, `telefon`, `fax`, `email`, `apikey`) VALUES
(1, 'neuesMarketing KG', 'Robert-Koch-Straße 2', 59755, 'Arnsberg-Neheim', '02932/495533', '02932/495534', 'welcome@neuesmarketing.de', '72c83c275951bed69ca8e966c58e30cb'),
(2, 'Elektro Jörg Schmidt GmbH & Co.KG', 'Tiergartenstraße 35', 59821, 'Arnsberg', '0 29 31 / 21 466', '0 29 31 / 23 211', 'info@elektrobetrieb-schmidt.de', 'd04a3ea82d4c6b96917e513c120eb32e');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `anrede` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `vorname` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `nachname` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `id_unternehmen`, `anrede`, `vorname`, `nachname`, `username`, `password`, `email`, `status`) VALUES
(1, 1, 'Herr', 'Rene', 'Beckmann', 'Rene', 'f8d75688e9037d50f457055d2e08d630', 'rene@neuesmarketing.de', 1),
(2, 1, 'Herr', 'Robin', 'Lienig', 'Robin', 'f8d75688e9037d50f457055d2e08d630', 'robin@neuesmarketing.de', 1),
(3, 3, 'Frau', 'Anna', 'Schmidt', 'Anna', 'f8d75688e9037d50f457055d2e08d630', 'ana@neuesmarketing.de', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `stellen`
--
ALTER TABLE `stellen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `unternehmen`
--
ALTER TABLE `unternehmen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `stellen`
--
ALTER TABLE `stellen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `unternehmen`
--
ALTER TABLE `unternehmen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
