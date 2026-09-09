-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 sep. 2026 à 12:26
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chaussettes_orphelinesv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `chaussette`
--

DROP TABLE IF EXISTS `chaussette`;
CREATE TABLE IF NOT EXISTS `chaussette` (
  `id_chaussette` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `couleur` varchar(100) NOT NULL,
  `motif` varchar(150) DEFAULT NULL,
  `pointure` varchar(20) NOT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` enum('disponible','echangee') NOT NULL DEFAULT 'disponible',
  PRIMARY KEY (`id_chaussette`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proposition`
--

DROP TABLE IF EXISTS `proposition`;
CREATE TABLE IF NOT EXISTS `proposition` (
  `id_proposition` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur_emetteur` int NOT NULL,
  `id_utilisateur_receveur` int NOT NULL,
  `id_chaussette_offerte` int NOT NULL,
  `id_chaussette_convoitee` int NOT NULL,
  `message` text,
  `statut` enum('en_attente','acceptee','refusee') NOT NULL DEFAULT 'en_attente',
  `date_proposition` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proposition`),
  KEY `id_utilisateur_emetteur` (`id_utilisateur_emetteur`),
  KEY `id_utilisateur_receveur` (`id_utilisateur_receveur`),
  KEY `id_chaussette_offerte` (`id_chaussette_offerte`),
  KEY `id_chaussette_convoitee` (`id_chaussette_convoitee`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `email`, `mot_de_passe`, `date_inscription`) VALUES
(10, 'jean', 'jean@test.com', '$2y$10$OZAdUaLw69CnvE6wew7RUuCAwaGjvhHV/ef6KhxM9vSwpFSxFzMOq', '2026-09-07 11:36:47');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chaussette`
--
ALTER TABLE `chaussette`
  ADD CONSTRAINT `chaussette_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `proposition`
--
ALTER TABLE `proposition`
  ADD CONSTRAINT `proposition_ibfk_1` FOREIGN KEY (`id_utilisateur_emetteur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposition_ibfk_2` FOREIGN KEY (`id_utilisateur_receveur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposition_ibfk_3` FOREIGN KEY (`id_chaussette_offerte`) REFERENCES `chaussette` (`id_chaussette`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposition_ibfk_4` FOREIGN KEY (`id_chaussette_convoitee`) REFERENCES `chaussette` (`id_chaussette`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
