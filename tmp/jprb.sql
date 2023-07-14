-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 25. Jan 2023 um 16:09
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
-- Tabellenstruktur für Tabelle `antworten`
--

CREATE TABLE `antworten` (
  `id` int(20) UNSIGNED NOT NULL,
  `antwort` text,
  `id_stelle` int(255) UNSIGNED NOT NULL,
  `id_frage` int(255) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `antworten`
--

INSERT INTO `antworten` (`id`, `antwort`, `id_stelle`, `id_frage`) VALUES
(1, 'Gutes Team', 1, 2),
(2, 'Gute Bezahlung', 1, 2),
(3, 'Moderner Arbeitsplatz', 1, 2),
(4, 'Firmenwagen', 1, 2),
(5, '16 - 20', 1, 3),
(6, '20 - 30', 1, 3),
(7, '30 - 40', 1, 3),
(8, '40 - 60', 1, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragen`
--

CREATE TABLE `fragen` (
  `id` int(255) NOT NULL,
  `frage` text NOT NULL,
  `type` int(1) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `id_stelle` int(255) NOT NULL,
  `position` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stellen`
--

CREATE TABLE `stellen` (
  `id` int(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `stellenart` int(1) NOT NULL,
  `visible` int(11) NOT NULL,
  `slug` text NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `stellen`
--

INSERT INTO `stellen` (`id`, `id_unternehmen`, `id_user`, `name`, `beschreibung`, `stellenart`, `visible`, `slug`, `created_at`, `modified_at`) VALUES
(1, 1, 1, 'Webdesigner (M/W/D) - für 1 Jahr auf Probe', '<p>1996 ver&ouml;ffentlichte Microsoft seinen <strong>ersten wettbewerbsf&auml;higen Browser</strong>, der &uuml;ber eigene Eigenschaften und Elemente verf&uuml;gte. Das war auch der erste Browser, welcher&nbsp;<a href=\"https://de.wikipedia.org/wiki/Formatvorlage\">Formatvorlagen</a>&nbsp;unterst&uuml;tzte, die zu dieser Zeit nicht gern gesehen waren. Man begriff sehr schnell das Potenzial der HTML-Programmierung, um damit k<s>omplexe Mehrs&auml;ulenlayouts zu schaffen, d</s>ie sonst nicht m&ouml;glich waren. In dieser Zeit hatten Design und gute&nbsp;<a href=\"https://de.wikipedia.org/wiki/%C3%84sthetik\">&Auml;sthetik</a>&nbsp;den Vortritt, weswegen nur sehr wenig Aufmerksamkeit auf Schematik und&nbsp;<a href=\"https://de.wikipedia.org/wiki/Barrierefreiheit\">Webzug&auml;nglichkeit</a>&nbsp;gelegt wurde. HTML-Seiten wurden durch ihre Designoptionen noch mehr mit fr&uuml;heren Versionen des HTML beschr&auml;nkt. Um komplizierte Designs zu schaffen, mussten viele Webentwerfer komplizierte Tabellenstrukturen verwenden. Teilweise sogar eigene&nbsp;<a href=\"https://de.wikipedia.org/wiki/Graphics_Interchange_Format\">GIF</a>-Bilder verwenden, um leere Tabellenzellen daran zu hindern zusammenzubrechen.</p>\r\n', 2, 1, 'webdesigner-m-w-d-fur-1-jahr-auf-probe-1674629670', '2022-04-01', '2023-01-25'),
(16, 1, 1, ' Maurer (M/W/D) für sonderanLagen23', '<p>hgjhgjgh gfhfhfg</p>\r\n', 5, 1, 'maurer-m-w-d-fur-sonderanlagen23-1674629997', '2022-10-27', '2023-01-25'),
(17, 1, 1, 'Test123', '<p>cvcxvcxv bnbngfhgfh</p>\r\n', 3, 1, 'test123-1674629782', '2023-01-25', '2023-01-25');

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
  `url` varchar(255) NOT NULL,
  `bgColor` varchar(7) NOT NULL,
  `primaryColor` varchar(7) NOT NULL,
  `secondaryColor` varchar(7) NOT NULL,
  `fontColor` varchar(7) NOT NULL,
  `apikey` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `unternehmen`
--

INSERT INTO `unternehmen` (`id`, `name`, `strasse`, `plz`, `ort`, `telefon`, `fax`, `email`, `url`, `bgColor`, `primaryColor`, `secondaryColor`, `fontColor`, `apikey`) VALUES
(1, 'neuesMarketing KG', 'Robert-Koch-Straße 2', 59755, 'Arnsberg-Neheim', '02932/495533', '02932/495534', 'welcome@neuesmarketing.de', 'https://www.neuesmarketing.de', '#CC2136', '#CC2136', '#aaaaaa', '#000000', '72c83c275951bed69ca8e966c58e30cb'),
(2, 'Elektro Jörg Schmidt GmbH & Co.KG', 'Tiergartenstraße 35', 59821, 'Arnsberg', '0 29 31 / 21 466', '0 29 31 / 23 211', 'info@elektrobetrieb-schmidt.de', 'https://www.elektrobetrieb-schmidt.de', '', '', '', '', 'd04a3ea82d4c6b96917e513c120eb32e');

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
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `id_unternehmen`, `anrede`, `vorname`, `nachname`, `password`, `email`) VALUES
(1, 1, 'Herr', 'Rene', 'Beckmann', 'f8d75688e9037d50f457055d2e08d630', 'rene@neuesmarketing.de'),
(2, 1, 'Herr', 'Robin', 'Lienig', 'f8d75688e9037d50f457055d2e08d630', 'robin@neuesmarketing.de'),
(3, 2, 'Frau', 'Anna', 'Schmidt', 'f8d75688e9037d50f457055d2e08d630', 'anna@neuesmarketing.de');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `antworten`
--
ALTER TABLE `antworten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_frage` (`id_frage`);

--
-- Indizes für die Tabelle `fragen`
--
ALTER TABLE `fragen`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT für Tabelle `antworten`
--
ALTER TABLE `antworten`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `stellen`
--
ALTER TABLE `stellen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
