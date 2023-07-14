CREATE TABLE  `antworten` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  `antwort` text,
  `id_stelle` int(255) unsigned NOT NULL,
  `id_frage` int(255) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT  FOREIGN KEY (id_frage) REFERENCES fragen(id) ON DELETE CASCADE
) ENGINE=InnoDB 