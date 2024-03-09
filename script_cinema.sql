-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Création de la BDD
CREATE DATABASE IF NOT EXISTS `cinema_appli` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `cinema_appli`;

-- Listage de la structure de la table exercice_cinema. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.acteur : ~12 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(1, 2),
	(2, 3),
	(3, 4),
	(4, 5),
	(5, 6),
	(6, 7),
	(7, 8),
	(8, 9),
	(9, 10),
	(10, 11),
	(11, 13),
	(12, 14);

-- Listage de la structure de la table exercice_cinema. definir
CREATE TABLE IF NOT EXISTS `definir` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `definir_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `definir_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre_film` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.definir : ~11 rows (environ)
INSERT INTO `definir` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(3, 4),
	(7, 4),
	(4, 5),
	(5, 6),
	(3, 7),
	(6, 7),
	(8, 8),
	(7, 9);

-- Listage de la structure de la table exercice_cinema. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL,
  `titre_film` varchar(50) NOT NULL,
  `date_sortie_france_film` date NOT NULL,
  `duree_min_film` int NOT NULL,
  `affiche_film` varchar(50) NOT NULL,
  `synopsis_film` text,
  `note_film` int DEFAULT NULL,
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.film : ~8 rows (environ)
INSERT INTO `film` (`id_film`, `titre_film`, `date_sortie_france_film`, `duree_min_film`, `affiche_film`, `synopsis_film`, `note_film`, `id_realisateur`) VALUES
	(1, 'Thelma et Louise', '1991-05-29', 129, 'indisponible.jpg', 'Deux amies partent en virée dans le désert pour échapper à leur quotidien, mais leur voyage prend une tournure inattendue.', 5, 1),
	(2, 'Gladiator', '2000-06-20', 171, 'indisponible.jpg', 'Un général romain cherchant à venger la mort de sa famille se retrouve forcé de devenir un gladiateur dans l\'arène.', 5, 1),
	(3, 'Blade Runner', '1982-09-15', 117, 'indisponible.jpg', 'Dans un futur dystopique, un détective doit traquer des robots répliquants dangereux dans une ville en décadence.', 5, 1),
	(4, 'Le Dernier Duel', '2021-10-13', 152, 'indisponible.jpg', 'Deux hommes se battent pour leur honneur dans le dernier duel judiciaire autorisé en France au Moyen Âge.', 5, 1),
	(5, 'Virgin Suicides', '2000-09-27', 97, 'indisponible.jpg', 'Un groupe de filles adolescentes, fascinées par la mort, se retrouve dans une spirale de tragédie et de mystère.', 5, 2),
	(6, 'Taxi Driver', '1976-05-13', 113, 'indisponible.jpg', 'Un vétéran du Vietnam devenu chauffeur de taxi à New York devient obsédé par le nettoyage de la ville de la corruption.', 5, 4),
	(7, 'Le Parrain III', '1991-03-27', 170, 'indisponible.jpg', 'Le patriarche du crime Michael Corleone tente de réhabiliter sa famille tout en confrontant les fantômes du passé.', 2, 5),
	(8, 'Heaven', '1987-04-17', 80, 'indisponible.jpg', 'Une femme innocente meurt et se retrouve au paradis, où elle découvre que sa vie est liée à celle d\'un homme sur Terre.', 3, 3);

-- Listage de la structure de la table exercice_cinema. genre_film
CREATE TABLE IF NOT EXISTS `genre_film` (
  `id_genre` int NOT NULL,
  `nom_genre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.genre_film : ~9 rows (environ)
INSERT INTO `genre_film` (`id_genre`, `nom_genre`) VALUES
	(1, 'Road movie'),
	(2, 'Peplum dramatique'),
	(3, 'Science-fiction'),
	(4, 'Thriller'),
	(5, 'Drame historique'),
	(6, 'Drame'),
	(7, 'Néo-noir'),
	(8, 'Documentaire'),
	(9, 'Gangster');

-- Listage de la structure de la table exercice_cinema. jouer
CREATE TABLE IF NOT EXISTS `jouer` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_acteur` (`id_acteur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `jouer_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `jouer_ibfk_2` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `jouer_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.jouer : ~9 rows (environ)
INSERT INTO `jouer` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 1, 1),
	(1, 2, 2),
	(1, 3, 3),
	(6, 3, 12),
	(2, 4, 4),
	(2, 5, 5),
	(3, 6, 6),
	(3, 7, 7),
	(4, 8, 8),
	(4, 9, 9),
	(7, 10, 10),
	(7, 11, 11);

-- Listage de la structure de la table exercice_cinema. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL,
  `prenom_personne` varchar(50) NOT NULL,
  `nom_personne` varchar(50) NOT NULL,
  `sexe_personne` varchar(50) NOT NULL,
  `date_naissance_personne` date NOT NULL,
  `pays_naissance` varchar(100) DEFAULT NULL,
  `lieu_habitation` varchar(100) DEFAULT NULL,
  `informations_personnelles` text,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.personne : ~13 rows (environ)
INSERT INTO `personne` (`id_personne`, `prenom_personne`, `nom_personne`, `sexe_personne`, `date_naissance_personne`, `pays_naissance`, `lieu_habitation`, `informations_personnelles`) VALUES
	(1, 'Ridley', 'SCOTT', 'Masculin', '1937-11-30', 'Angleterre', 'Londres', 'Ridley Scott est un réalisateur, producteur et scénariste britannique. Il est surtout connu pour ses films de science-fiction et de fantastique.'),
	(2, 'Susan', 'SARANDON', 'Féminin', '1946-10-04', 'États-Unis', 'New York', 'Susan Sarandon est une actrice américaine primée, connue pour ses rôles dans des films tels que "Thelma et Louise" et "Dead Man Walking".'),
	(3, 'Geena', 'DAVIS', 'Féminin', '1956-01-21', 'États-Unis', 'New York', 'Geena Davis est une actrice et activiste américaine, surtout connue pour ses rôles dans des films tels que "Beetlejuice" et "A League of Their Own".'),
	(4, 'Harvey', 'KEITEL', 'Masculin', '1939-05-13', 'Nouvelle-Zélande', 'Wellington', 'Harvey Keitel est un acteur américano-néozélandais, connu pour ses rôles dans des films de Martin Scorsese et Quentin Tarantino.'),
	(5, 'Russell', 'CROWE', 'Masculin', '1964-04-07', 'Nouvelle-Zélande', 'Wellington', 'Russell Crowe est un acteur néo-zélandais primé, connu pour ses rôles dans des films tels que "Gladiator" et "A Beautiful Mind".'),
	(6, 'Joaquin', 'PHOENIX', 'Masculin', '1974-11-28', 'Nouvelle-Zélande', 'Wellington', 'Joaquin Phoenix est un acteur américain lauréat d\'un Oscar, connu pour ses performances dans des films tels que "Joker" et "Walk the Line".'),
	(7, 'Sean', 'YOUNG', 'Féminin', '1959-11-19', 'États-Unis', 'Louisville', 'Sean Young est une actrice américaine qui a joué dans plusieurs films populaires dans les années 1980 et 1990.'),
	(8, 'Harrison', 'FORD', 'Masculin', '1942-07-13', 'États-Unis', 'Los Angeles', 'Harrison Ford est un acteur et producteur américain. Il est surtout connu pour ses rôles dans la saga "Star Wars" et la saga "Indiana Jones".'),
	(9, 'Jodie', 'COMER', 'Féminin', '1993-03-11', 'Angleterre', 'Liverpool', 'Jodie Comer est une actrice britannique surtout connue pour son rôle dans la série télévisée "Killing Eve".'),
	(10, 'Adam', 'DRIVER', 'Masculin', '1983-11-19', 'États-Unis', 'San Diego', 'Adam Driver est un acteur américain qui s\'est fait connaître pour son rôle dans la série télévisée "Girls" et la saga "Star Wars".'),
	(11, 'Sofia', 'COPPOLA', 'Féminin', '1971-05-14', 'États-Unis', 'New York', 'Sofia Coppola est une réalisatrice, scénariste et actrice américaine. Elle est notamment connue pour son film "Lost in Translation".'),
	(12, 'Francis Ford', 'COPPOLA', 'Masculin', '1939-04-07', 'États-Unis', 'Los Angeles', 'Francis Ford Coppola est un réalisateur, scénariste et producteur de cinéma américain, largement reconnu pour son travail sur "The Godfather" et "Apocalypse Now".'),
	(13, 'Diane', 'KEATON', 'Féminin', '1946-01-05', 'États-Unis', 'Los Angeles', 'Diane Keaton est une actrice, réalisatrice et productrice américaine, célèbre pour ses rôles dans des films tels que "Annie Hall" et "The Godfather" de Coppola.'),
	(14, 'Alfredo James', 'PACINO', 'Masculin', '1940-04-25', 'Non défini', 'Non défini', 'Al Pacino est un acteur américain légendaire, célèbre pour ses performances dans de nombreux films classiques.'),
	(15, 'Martin ', 'SCORSESE', 'Masculin', '1942-11-17', 'Non défini', 'Non défini', 'Martin Scorsese est un réalisateur, producteur et scénariste américain, largement reconnu comme l\'un des plus grands réalisateurs de tous les temps.');

-- Listage de la structure de la table exercice_cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.realisateur : ~3 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 11),
	(5, 12),
	(3, 13),
	(4, 15);

-- Listage de la structure de la table exercice_cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL,
  `nom_personnage` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table exercice_cinema.role : ~9 rows (environ)
INSERT INTO `role` (`id_role`, `nom_personnage`) VALUES
	(1, 'Louise SAWYER'),
	(2, 'Thelma DICKINSON'),
	(3, 'Hal SLOCOMBE'),
	(4, 'Maximus DECIMUS MERIDIUS'),
	(5, 'Commode'),
	(6, 'Rick DECKARD'),
	(7, 'Sean YOUNG'),
	(8, 'Marguerite de CARROUGES'),
	(9, 'Jacques le GRIS'),
	(10, 'Mary CORLEONE'),
	(11, 'Kay ADAMS'),
	(12, '"Sport" MATTHEW');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
