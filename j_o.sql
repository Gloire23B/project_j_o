-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 nov. 2023 à 20:52
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : 23_24_b2_jeux_olympiques
--

-- --------------------------------------------------------

--
-- Structure de la table admin
--

DROP TABLE IF EXISTS admin;
CREATE TABLE IF NOT EXISTS admin (
  id int NOT NULL AUTO_INCREMENT,
  login varchar(50) DEFAULT NULL,
  mdp varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table equipe
--

DROP TABLE IF EXISTS equipe;
CREATE TABLE IF NOT EXISTS equipe (
  id_equipe int NOT NULL AUTO_INCREMENT,
  nom_equipe varchar(50) NOT NULL,
  PRIMARY KEY (id_equipe),
  UNIQUE KEY nom_equipe (nom_equipe)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table equipe
--

INSERT INTO equipe (id_equipe, nom_equipe) VALUES
(1, 'ALLEMAGNE'),
(2, 'ANGLETERRE'),
(3, 'ARGENTINE'),
(4, 'AUSTRALIE'),
(5, 'BELGIQUE'),
(6, 'BOLIVIE'),
(7, 'BRESIL'),
(8, 'CAMEROUN'),
(9, 'CANADA'),
(10, 'CHINE'),
(11, 'COLOMBIE'),
(12, 'CONGO'),
(13, 'COREE'),
(14, 'EGYPTE'),
(15, 'ESPAGNE'),
(16, 'FRANCE'),
(17, 'GHANA'),
(18, 'IRAN'),
(19, 'ITALIE'),
(20, 'JAPON'),
(21, 'MAROC'),
(22, 'MEXIQUE'),
(23, 'NIGERIA'),
(24, 'POLOGNE'),
(25, 'PORTUGAL'),
(26, 'QATAR'),
(27, 'RUISSIE'),
(28, 'SENEGAL'),
(29, 'SUISSE'),
(30, 'TOGO'),
(31, 'TUNISIE'),
(32, 'TURQUIE');

-- --------------------------------------------------------

--
-- Structure de la table personnel
--

DROP TABLE IF EXISTS personnel;
CREATE TABLE IF NOT EXISTS personnel (
  id_personnel int NOT NULL AUTO_INCREMENT,
  prenom varchar(50) DEFAULT NULL,
  nom varchar(50) DEFAULT NULL,
  sexe varchar(50) DEFAULT NULL,
  role varchar(50) DEFAULT NULL,
  id_equipe int NOT NULL,
  PRIMARY KEY (id_personnel),
  KEY id_equipe (id_equipe)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table personnel
--

INSERT INTO personnel (id_personnel, prenom, nom, sexe, role, id_equipe) VALUES
(59, 'Arthur', 'Ayoub', 'homme', 'joueur', 28),
(60, 'Mamadou', 'Dia', 'homme', 'joueur', 6),
(61, 'Emilie', 'Divine', 'femme', 'medecin', 25),
(62, 'Anna', 'Apolline', 'femme', 'entraineur', 28),
(63, 'Arthur', 'Nathan', 'homme', 'entraineur', 6),
(64, 'Arthur', 'Félix', 'homme', 'arbitre', 10),
(65, 'Candice', 'Alicia', 'femme', 'joueur', 10),
(66, 'Arthur', 'Jacob', 'homme', 'joueur', 10),
(67, 'Salim', 'Ayoub', 'homme', 'joueur', 10),
(68, 'Charline', 'Elise', 'femme', 'joueur', 28),
(69, 'Chloé', 'Clémence', 'femme', 'joueur', 28),
(70, 'Aminata', 'Kane', 'femme', 'joueur', 28),
(71, 'Arthur', 'Kamal', 'homme', 'joueur', 6),
(72, 'Adam', 'Alexandre', 'homme', 'joueur', 6),
(73, 'Jean', 'Jacob', 'homme', 'joueur', 6),
(74, 'Neith', 'Illunga', 'homme', 'joueur', 6);

-- --------------------------------------------------------

--
-- Structure de la table rencontre
--

DROP TABLE IF EXISTS rencontre;
CREATE TABLE IF NOT EXISTS rencontre (
  id_rencontre int NOT NULL AUTO_INCREMENT,
  lieu varchar(50) DEFAULT NULL,
  type varchar(50) NOT NULL,
  id_equipe_a int NOT NULL,
  id_equipe_b int NOT NULL,
  date_rencontre datetime NOT NULL,
  PRIMARY KEY (id_rencontre),
  KEY type (type),
  KEY id_equipe_a (id_equipe_a),
  KEY id_equipe_b (id_equipe_b)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table rencontre
--

INSERT INTO rencontre (id_rencontre, lieu, type, id_equipe_a, id_equipe_b, date_rencontre) VALUES
(1, 'Paris', 'FOOTBALL', 17, 5, '2023-11-15 21:50:12'),
(2, 'Rabat', 'FOOTBALL', 21, 22, '1900-02-07 21:50:24'),
(3, 'Nairobi', 'FOOTBALL', 11, 28, '1899-12-05 21:50:41');

-- --------------------------------------------------------

--
-- Structure de la table resultat_match
--

DROP TABLE IF EXISTS resultat_match;
CREATE TABLE IF NOT EXISTS resultat_match (
  id_match int NOT NULL AUTO_INCREMENT,
  score_equipe_a int NOT NULL,
  score_equipe_b int NOT NULL,
  id_rencontre int NOT NULL,
  PRIMARY KEY (id_match),
  KEY id_rencontre (id_rencontre)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table resultat_match
--

INSERT INTO resultat_match (id_match, score_equipe_a, score_equipe_b, id_rencontre) VALUES
(1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table type_discipline
--

DROP TABLE IF EXISTS type_discipline;
CREATE TABLE IF NOT EXISTS type_discipline (
  type varchar(50) NOT NULL,
  PRIMARY KEY (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table type_discipline
--

INSERT INTO type_discipline (type) VALUES
('BSKETBALL'),
('FOOTBALL'),
('HANDBALL'),
('RUGBY'),
('TENNIS'),
('VOLLEYBALL');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table personnel
--
ALTER TABLE personnel
  ADD CONSTRAINT personnel_ibfk_1 FOREIGN KEY (id_equipe) REFERENCES equipe (id_equipe);

--
-- Contraintes pour la table rencontre
--
ALTER TABLE rencontre
  ADD CONSTRAINT rencontre_ibfk_1 FOREIGN KEY (type) REFERENCES type_discipline (type),
  ADD CONSTRAINT rencontre_ibfk_2 FOREIGN KEY (id_equipe_a) REFERENCES equipe (id_equipe),
  ADD CONSTRAINT rencontre_ibfk_3 FOREIGN KEY (id_equipe_b) REFERENCES equipe (id_equipe);

--
-- Contraintes pour la table resultat_match
--
ALTER TABLE resultat_match
  ADD CONSTRAINT resultat_match_ibfk_1 FOREIGN KEY (id_rencontre) REFERENCES rencontre (id_rencontre);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;