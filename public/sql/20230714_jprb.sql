-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 14. Jul 2023 um 11:34
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
-- Tabellenstruktur für Tabelle `ansprechpartner`
--

CREATE TABLE `ansprechpartner` (
  `id` int(255) NOT NULL,
  `vorname` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `nachname` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_unternehmen` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `ansprechpartner`
--

INSERT INTO `ansprechpartner` (`id`, `vorname`, `nachname`, `telefon`, `email`, `id_unternehmen`) VALUES
(6, 'Rene', 'Beckmann', '3857', 'rene@neuesmarketing.de', 1),
(8, 'Robin', 'Lienig', '38947398', 'robin@neuesmarketing.de', 1);

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
(1, 'Fussball', 1, 2),
(2, 'Handball', 1, 2),
(3, 'Schwimmen', 1, 2),
(4, 'Tennis', 1, 2),
(5, 'Morgens', 1, 3),
(6, 'Mittags', 1, 3),
(7, 'Abends', 1, 3),
(8, 'Nachts', 1, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `branchen`
--

CREATE TABLE `branchen` (
  `id` int(20) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `branchen`
--

INSERT INTO `branchen` (`id`, `name`) VALUES
(1, 'E-Commerce und Einzelhandel'),
(2, 'Technologie und Softwareentwicklung'),
(3, 'Finanzdienstleistungen und Bankwesen'),
(4, 'Gesundheitswesen und Medizin'),
(5, 'Bildung und Schulungen'),
(6, 'Unterhaltung und Medien'),
(7, 'Gastgewerbe und Tourismus'),
(8, 'Immobilien und Bauwesen'),
(9, 'Automobilindustrie und Transport'),
(10, 'Marketing und Werbung'),
(11, 'Sport und Fitness'),
(12, 'Kunst und Kultur'),
(13, 'Recht und Gerichtsbarkeit'),
(14, 'Landwirtschaft und Lebensmittelproduktion'),
(15, 'Energie und Umwelt'),
(16, 'Telekommunikation und Netzwerktechnik'),
(17, 'Regierungs- und öffentlicher Sektor'),
(18, 'Schönheits- und Wellnessbranche'),
(19, 'Versicherungen'),
(20, 'Personalwesen und Arbeitsvermittlung');

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

--
-- Daten für Tabelle `fragen`
--

INSERT INTO `fragen` (`id`, `frage`, `type`, `id_unternehmen`, `id_stelle`, `position`) VALUES
(1, 'Hast du eine Ausbildung', 1, 1, 1, 0),
(2, 'Was sind deine Hobbys', 2, 1, 1, 1),
(3, 'Wann können wir dich erreichen?', 3, 1, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `prices`
--

CREATE TABLE `prices` (
  `id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `price` int(10) NOT NULL,
  `anzJobs` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `prices`
--

INSERT INTO `prices` (`id`, `name`, `price`, `anzJobs`) VALUES
(1, 'Basic', 99, 3),
(2, 'Pro', 299, 10),
(3, 'Business', 499, 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `standorte`
--

CREATE TABLE `standorte` (
  `id` int(255) NOT NULL,
  `strasse` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `plz` int(5) NOT NULL,
  `ort` varchar(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `standorte`
--

INSERT INTO `standorte` (`id`, `strasse`, `plz`, `ort`, `id_unternehmen`) VALUES
(1, 'Hauptstrasse 5', 46294, 'Wuppertal', 1),
(2, 'Feldweg 4', 194723, 'München', 1),
(4, 'Teststraße 5', 39842, 'Testhausen', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stellen`
--

CREATE TABLE `stellen` (
  `id` int(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `id_stellenart` int(1) NOT NULL,
  `id_ansprechpartner` int(255) NOT NULL,
  `id_standort` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `start_date` date NOT NULL,
  `visible` int(11) NOT NULL,
  `slug` text NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `stellen`
--

INSERT INTO `stellen` (`id`, `id_unternehmen`, `id_user`, `id_stellenart`, `id_ansprechpartner`, `id_standort`, `name`, `beschreibung`, `start_date`, `visible`, `slug`, `created_at`, `modified_at`) VALUES
(1, 1, 1, 1, 6, 2, 'Webdesigner (M/W/D) - für 1 Jahr auf Probe', '<p>1996 ver&ouml;ffentlichte Microsoft seinen <strong>ersten wettbewerbsf&auml;higen Browser</strong>, der &uuml;ber eigene Eigenschaften und Elemente verf&uuml;gte. Das war auch der erste Browser, welcher&nbsp;<a href=\"https://de.wikipedia.org/wiki/Formatvorlage\">Formatvorlagen</a>&nbsp;unterst&uuml;tzte, die zu dieser Zeit nicht gern gesehen waren. Man begriff sehr schnell das Potenzial der HTML-Programmierung, um damit k<s>omplexe Mehrs&auml;ulenlayouts zu schaffen, d</s>ie sonst nicht m&ouml;glich waren. In dieser Zeit hatten Design und gute&nbsp;<a href=\"https://de.wikipedia.org/wiki/%C3%84sthetik\">&Auml;sthetik</a>&nbsp;den Vortritt, weswegen nur sehr wenig Aufmerksamkeit auf Schematik und&nbsp;<a href=\"https://de.wikipedia.org/wiki/Barrierefreiheit\">Webzug&auml;nglichkeit</a>&nbsp;gelegt wurde. HTML-Seiten wurden durch ihre Designoptionen noch mehr mit fr&uuml;heren Versionen des HTML beschr&auml;nkt. Um komplizierte Designs zu schaffen, mussten viele Webentwerfer komplizierte Tabellenstrukturen verwenden. Teilweise sogar eigene&nbsp;<a href=\"https://de.wikipedia.org/wiki/Graphics_Interchange_Format\">GIF</a>-Bilder verwenden, um leere Tabellenzellen daran zu hindern zusammenzubrechen.</p>\r\n', '2023-05-01', 1, 'webdesigner-m-w-d-fur-1-jahr-auf-probe-1681983790', '2022-04-01', '2023-04-20'),
(16, 1, 1, 5, 6, 1, ' Maurer (M/W/D) für sonderanLagen23', '<p>hgjhgjgh gfhfhfg</p>\r\n', '0000-00-00', 0, 'maurer-m-w-d-fur-sonderanlagen23-1674629997', '2022-10-27', '2023-01-25'),
(17, 1, 1, 4, 6, 1, 'Test123', '<p>cvcxvcxv bnbngfhgfh</p>\r\n', '0000-00-00', 1, 'test123-1675171697', '2023-01-25', '2023-01-31'),
(18, 1, 1, 3, 6, 1, 'Fliesenleger', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'fliesenleger-1678965024', '2023-03-16', '2023-03-16'),
(19, 1, 1, 4, 6, 1, 'LKW Fahrer', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eo<strong>s et accusam et justo duo dolores et ea reb</strong>um. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'lkw-fahrer-1678965094', '2023-03-16', '2023-03-16'),
(20, 1, 1, 2, 6, 1, 'Elektriker ', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 0, 'elektriker-1678965125', '2023-03-16', '2023-03-16'),
(21, 1, 1, 2, 6, 1, 'Aushilfe', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'aushilfe-1678965138', '2023-03-16', '2023-03-16'),
(22, 1, 1, 5, 6, 1, 'Friseurin', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'friseurin-1678965159', '2023-03-16', '2023-03-16'),
(23, 1, 1, 3, 6, 1, 'Kindergärtnerin', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'kindergartnerin-1678965172', '2023-03-16', '2023-03-16'),
(24, 1, 1, 4, 6, 1, 'Krankenschwester', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n', '0000-00-00', 1, 'krankenschwester-1678965192', '2023-03-16', '2023-03-16');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stellenart`
--

CREATE TABLE `stellenart` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `stellenart`
--

INSERT INTO `stellenart` (`id`, `name`) VALUES
(1, 'Vollzeit'),
(2, 'Halbtags'),
(3, 'Ausbildung'),
(4, 'Duales Studium'),
(5, 'Praktikum');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tokensystem`
--

CREATE TABLE `tokensystem` (
  `id` int(255) NOT NULL,
  `id_unternehmen` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `art` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tokensystem`
--

INSERT INTO `tokensystem` (`id`, `id_unternehmen`, `id_user`, `art`, `token`, `date`) VALUES
(19, 1, 1, 'SESSION_TOKEN', 'ST_64b11400a769d4.71940807', '2023-07-14 11:30:31');

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
  `urlDisclaimer` varchar(255) NOT NULL,
  `kurzinfo` text NOT NULL,
  `gruendungsjahr` int(4) NOT NULL,
  `anzMitarbeiter` int(10) NOT NULL,
  `id_branche` int(10) NOT NULL,
  `tags` text NOT NULL,
  `bgColor` varchar(7) NOT NULL,
  `primaryColor` varchar(7) NOT NULL,
  `secondaryColor` varchar(7) NOT NULL,
  `fontColor` varchar(7) NOT NULL,
  `linkColor` varchar(7) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `status` int(5) NOT NULL,
  `verified` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `unternehmen`
--

INSERT INTO `unternehmen` (`id`, `name`, `strasse`, `plz`, `ort`, `telefon`, `fax`, `email`, `url`, `urlDisclaimer`, `kurzinfo`, `gruendungsjahr`, `anzMitarbeiter`, `id_branche`, `tags`, `bgColor`, `primaryColor`, `secondaryColor`, `fontColor`, `linkColor`, `apikey`, `status`, `verified`) VALUES
(1, 'neuesMarketing KG', 'Robert-Koch-Straße 2', 59755, 'Arnsberg-Neheim', '02932/495533', '02932/495534', 'welcome@neuesmarketing.de', 'https://www.neuesmarketing.de', 'https://neuesmarketing.de/datenschutz', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\n\n<p>ghgjhgjgh</p>\n', 1960, 46, 10, '', '#f7f7f7', '#ffe175', '', '#000000', '#f00000', '72c83c275951bed69ca8e966c58e30cb', 3, 1),
(2, 'Elektro Jörg Schmidt GmbH & Co.KG', 'Tiergartenstraße 35', 59821, 'Arnsberg', '0 29 31 / 21 466', '0 29 31 / 23 211', 'info@elektrobetrieb-schmidt.de', 'https://www.elektrobetrieb-schmidt.de', '', '', 0, 0, 0, '', '', '', '', '', '', 'd04a3ea82d4c6b96917e513c120eb32e', 0, 0);

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
(1, 1, 'Herr', 'Rene', 'Beckmann', '$2y$10$qz9Nu25oTHIJDD3vs52BxuPhBQhLEhN8/mpXfvc4VPh3xFNOP.WBm', 'rene@neuesmarketing.de'),
(2, 1, 'Herr', 'Robin', 'Lienig', '$2y$10$qz9Nu25oTHIJDD3vs52BxuPhBQhLEhN8/mpXfvc4VPh3xFNOP.WBm', 'robin@neuesmarketing.de'),
(3, 2, 'Frau', 'Anna', 'Schmidt', '$2y$10$qz9Nu25oTHIJDD3vs52BxuPhBQhLEhN8/mpXfvc4VPh3xFNOP.WBm', 'anna@neuesmarketing.de');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ansprechpartner`
--
ALTER TABLE `ansprechpartner`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `antworten`
--
ALTER TABLE `antworten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_frage` (`id_frage`);

--
-- Indizes für die Tabelle `branchen`
--
ALTER TABLE `branchen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `fragen`
--
ALTER TABLE `fragen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `standorte`
--
ALTER TABLE `standorte`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `stellen`
--
ALTER TABLE `stellen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `stellenart`
--
ALTER TABLE `stellenart`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tokensystem`
--
ALTER TABLE `tokensystem`
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
-- AUTO_INCREMENT für Tabelle `ansprechpartner`
--
ALTER TABLE `ansprechpartner`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `antworten`
--
ALTER TABLE `antworten`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `branchen`
--
ALTER TABLE `branchen`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `standorte`
--
ALTER TABLE `standorte`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `stellen`
--
ALTER TABLE `stellen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `stellenart`
--
ALTER TABLE `stellenart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tokensystem`
--
ALTER TABLE `tokensystem`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT für Tabelle `unternehmen`
--
ALTER TABLE `unternehmen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
