USE jokd13;
 
--
-- Create table for my own movie database
--
DROP TABLE IF EXISTS Movie_kmom4;
CREATE TABLE Movie_kmom4
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  title VARCHAR(100) NOT NULL,
  director VARCHAR(100),
  LENGTH INT DEFAULT NULL, -- Length in minutes
  YEAR INT NOT NULL DEFAULT 1900,
  plot TEXT, -- Short intro to the movie
  image VARCHAR(100) DEFAULT NULL, -- Link to an image
  subtext CHAR(3) DEFAULT NULL, -- swe, fin, en, etc
  speech CHAR(3) DEFAULT NULL, -- swe, fin, en, etc
  quality CHAR(3) DEFAULT NULL,
  format CHAR(3) DEFAULT NULL -- mp4, divx, etc
) ENGINE INNODB CHARACTER SET utf8;
 
 
SHOW CHARACTER SET;
SHOW COLLATION LIKE 'utf8%';
 
INSERT INTO Movie_kmom4 (title, YEAR, image) VALUES
  ('Pulp fiction', 1994, 'img/movie/pulp-fiction.jpg'),
  ('American Pie', 1999, 'img/movie/american-pie.jpg'),
  ('Pokémon The Movie 2000', 1999, 'img/movie/pokemon.jpg'),  
  ('Kopps', 2003, 'img/movie/kopps.jpg'),
  ('From Dusk Till Dawn', 1996, 'img/movie/from-dusk-till-dawn.jpg')
;
 

--
-- Add tables for genre
--
DROP TABLE IF EXISTS Genre_kmom4;
CREATE TABLE Genre_kmom4
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name CHAR(20) NOT NULL -- crime, svenskt, college, drama, etc
) ENGINE INNODB CHARACTER SET utf8;
 
INSERT INTO Genre_kmom4 (name) VALUES 
  ('comedy'), ('romance'), ('college'), 
  ('crime'), ('drama'), ('thriller'), 
  ('animation'), ('adventure'), ('family'), 
  ('svenskt'), ('action'), ('horror')
;
 
DROP TABLE IF EXISTS Movie2Genre_kmom4;
CREATE TABLE Movie2Genre_kmom4
(
  idMovie INT NOT NULL,
  idGenre INT NOT NULL,
 
  FOREIGN KEY (idMovie) REFERENCES Movie_kmom4 (id),
  FOREIGN KEY (idGenre) REFERENCES Genre_kmom4 (id),
 
  PRIMARY KEY (idMovie, idGenre)
) ENGINE INNODB;
 
 
INSERT INTO Movie2Genre_kmom4 (idMovie, idGenre) VALUES
  (1, 1),
  (1, 5),
  (1, 6),
  (2, 1),
  (2, 2),
  (2, 3),
  (3, 7), 
  (3, 8), 
  (3, 9), 
  (4, 11),
  (4, 1),
  (4, 10),
  (4, 9),
  (5, 11),
  (5, 4),
  (5, 12)
;
 
DROP VIEW IF EXISTS VMovie_kmom4;
 
CREATE VIEW VMovie_kmom4
AS
SELECT 
  M.*,
  GROUP_CONCAT(G.name) AS genre
FROM Movie_kmom4 AS M
  LEFT OUTER JOIN Movie2Genre_kmom4 AS M2G
    ON M.id = M2G.idMovie
  LEFT OUTER JOIN Genre_kmom4 AS G
    ON M2G.idGenre = G.id
GROUP BY M.id
;
 
SELECT DISTINCT G.name
FROM Genre_kmom4 AS G
  INNER JOIN Movie2Genre_kmom4 AS M2G
    ON G.id = M2G.idGenre;



--
-- Table for user
--
DROP TABLE IF EXISTS USER_kmom4;
 
CREATE TABLE USER_kmom4
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  acronym CHAR(12) UNIQUE NOT NULL,
  name VARCHAR(80),
  password CHAR(32),
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;
 
INSERT INTO USER_kmom4 (acronym, name, salt) VALUES 
  ('doe', 'John/Jane Doe', unix_timestamp()),
  ('admin', 'Administrator', unix_timestamp())
;
 
UPDATE USER_kmom4 SET password = md5(concat('password', salt)) WHERE acronym = 'doe';
UPDATE USER_kmom4 SET password = md5(concat('password', salt)) WHERE acronym = 'admin';
 
