
USE jokd13;
 
SHOW CHARACTER SET;
SHOW COLLATION LIKE 'utf8%';


DROP TABLE IF EXISTS Movie_kmom07;
CREATE TABLE Movie_kmom07
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  title VARCHAR(100) NOT NULL,
  director VARCHAR(100) NULL DEFAULT NULL,
  price INT NOT NULL DEFAULT 50,
  length INT DEFAULT NULL,
  year INT NOT NULL DEFAULT 1900,
  plot TEXT, 
  image VARCHAR(100) DEFAULT NULL,
  trailer VARCHAR(100) DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8;


DROP TABLE IF EXISTS Genre_kmom07;
CREATE TABLE IF NOT EXISTS `Genre_kmom07` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumpning av Data i tabell `Genre_kmom4`
--

INSERT INTO `Genre_kmom07` (`id`, `name`) VALUES
(1, 'comedy'),
(2, 'romance'),
(3, 'college'),
(4, 'crime'),
(5, 'drama'),
(6, 'thriller'),
(7, 'animation'),
(8, 'adventure'),
(9, 'family'),
(10, 'svenskt'),
(11, 'action'),
(12, 'horror');

DROP TABLE IF EXISTS Movie2Genre_kmom07;
CREATE TABLE Movie2Genre_kmom07
(
  idMovie INT NOT NULL,
  idGenre INT NOT NULL,
 
  FOREIGN KEY (idMovie) REFERENCES Movie_kmom07 (id),
  FOREIGN KEY (idGenre) REFERENCES Genre_kmom07 (id),
 
  PRIMARY KEY (idMovie, idGenre)
) ENGINE INNODB;


DROP TABLE IF EXISTS Users_kmom07;
CREATE TABLE Users_kmom07
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  username VARCHAR(100) NOT NULL,
  password CHAR(32) NOT NULL,
  salt INT(11) NOT NULL,
  auth INT(1) NOT NULL DEFAULT 1
) ENGINE INNODB CHARACTER SET utf8;

INSERT INTO 