CREATE DATABASE IF NOT EXISTS lockout
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE lockout;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 12 mars 2026 à 14:17
-- Version du serveur : 5.7.43
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lockout`
--

-- --------------------------------------------------------

--
-- Structure de la table `acheter`
--

CREATE TABLE `acheter` (
  `id_client` int(11) NOT NULL,
  `id_version` int(11) NOT NULL,
  `date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_participant` int(5) NOT NULL,
  `reserver` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `acheter`
--

INSERT INTO `acheter` (`id_client`, `id_version`, `date`, `heure`, `nb_participant`, `reserver`) VALUES
(4, 1, '2026-03-19', '13:00', 2, 1),
(4, 2, '2026-03-03', '16:00', 2, 1),
(4, 4, '2026-03-13', '12:00', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `avis_escape`
--

CREATE TABLE `avis_escape` (
  `id_avis` int(11) NOT NULL,
  `id_escape` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `note` tinyint(4) NOT NULL,
  `commentaire` text,
  `date_avis` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `avis_escape`
--

INSERT INTO `avis_escape` (`id_avis`, `id_escape`, `id_client`, `note`, `commentaire`, `date_avis`) VALUES
(1, 2, 4, 1, 'test', '2026-03-12 11:50:31');

-- --------------------------------------------------------

--
-- Structure de la table `carte_cadeau`
--

CREATE TABLE `carte_cadeau` (
  `id_carte` int(11) NOT NULL,
  `valeur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validité` date NOT NULL,
  `nb_escape` int(10) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prénom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` int(5) NOT NULL,
  `adresse` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int(5) NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `téléphone` int(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prénom`, `mail`, `mdp`, `statut`, `adresse`, `code_postal`, `ville`, `téléphone`) VALUES
(1, 'R', 'Trystan', 'trystan@gmail.com', '$2y$10$z9/NEjogI2XQkyB76L8nJOwOVoDze7Pq4vVwN.IWsN0Rn/kO9SaeC', 2, '', 0, '', 0),
(2, 'R', 'Trystan', 'admin@gmail.com', '$2y$10$fnPO76kffmFsz7lKszrBZegagTYOpxONejR7AzjymVu1s9y9I.Afi', 1, '', 0, '', 0),
(4, 'test', 'test', 'test@gmail.com', '$2y$10$LpRWUa.SNpWFxx5aLPRNier3BEYz61z/Tey3lNIu6yEqUcx2gsPAm', 2, '', 0, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `escape_game`
--

CREATE TABLE `escape_game` (
  `id_escape` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `nb_participants_max` int(5) NOT NULL,
  `age_minimum` int(2) NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `difficultés` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `escape_game`
--

INSERT INTO `escape_game` (`id_escape`, `nom`, `description`, `longitude`, `latitude`, `nb_participants_max`, `age_minimum`, `ville`, `tags`, `difficultés`) VALUES
(1, 'L\'HORLOGE DU TEMPS SUSPENDU', 'test', 49.0000000, 8.0000000, 6, 12, 'Strasbourg', 'test', 5),
(2, 'LE SECRET DE LA PETITE VENISE', 'Les eaux de la Lauch cachent ce que l\'histoire a voulu oublier\r\n\r\nDepuis des siècles, une légende circule parmi les bateliers de la Lauch : un coffre scellé par la confrérie des Tanneurs reposerait au fond des canaux de Colmar. Récemment, le niveau de l\'eau a mystérieusement baissé, laissant apparaître des symboles gravés sur les fondations des maisons à colombages.\r\n\r\nVotre mission est de naviguer entre terre et eau pour récupérer ce secret avant que le courant ne l\'emporte. Infiltrez les venelles fleuries, décodez les reflets des ponts et suivez les traces de l\'ancien commerce des peaux. Ici, la subtilité est votre meilleure arme : soyez plus rapides que la marée pour percer le plus grand mystère de la cité de Bartholdi.', 48.0740410, 7.3572439, 6, 12, 'Colmar', 'test', 3),
(3, 'L’ALCHIMISTE DU QUARTIER SAINT ETIENNE', 'Derrière les façades bourgeoises du quartier Saint-Étienne, une lueur étrange émane d\'une lucarne que personne n\'avait remarquée. Les archives de l\'Agence mentionnent un savant ayant découvert le secret de la transmutation avant de s\'évaporer dans l\'histoire. Les murs de son laboratoire semblent aujourd\'hui murmurer des formules oubliées.\r\n\r\nVotre mission est de pénétrer dans l\'antre de l\'alchimiste et de stabiliser sa dernière expérience. Manipulez les fioles, déchiffrez les grimoires et comprenez l\'alignement des planètes avant que le laboratoire ne s\'auto-détruise dans une réaction en chaîne. Ici, la logique ne suffit pas : il faudra voir au-delà du visible pour transmuter le destin.', 47.7471202, 7.3387971, 5, 14, 'Mulhouse', 'test', 4);

-- --------------------------------------------------------

--
-- Structure de la table `mettre_favoris_carte`
--

CREATE TABLE `mettre_favoris_carte` (
  `id_carte` int(11) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mettre_favoris_version`
--

CREATE TABLE `mettre_favoris_version` (
  `id_client` int(11) NOT NULL,
  `id_version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mettre_favoris_version`
--

INSERT INTO `mettre_favoris_version` (`id_client`, `id_version`) VALUES
(2, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `version`
--

CREATE TABLE `version` (
  `id_version` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `durée` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(10) NOT NULL,
  `id_escape` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `version`
--

INSERT INTO `version` (`id_version`, `nom`, `description`, `durée`, `prix`, `id_escape`) VALUES
(1, 'Pack Télégraphe', 'Immersion Digitale : Votre smartphone est votre seul outil de décryptage.', '1h', 10, 1),
(3, 'Pack Archive', 'Vous imprimez vous-même vos documents pour une expérience personnalisée.', '1h', 15, 1),
(4, 'Pack Immersion', 'Mis en place par l\'équipe avec de vrais objets pour une immersion totale.', '1h', 25, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acheter`
--
ALTER TABLE `acheter`
  ADD PRIMARY KEY (`id_client`,`id_version`,`date`,`heure`);

--
-- Index pour la table `avis_escape`
--
ALTER TABLE `avis_escape`
  ADD PRIMARY KEY (`id_avis`),
  ADD UNIQUE KEY `unique_avis_escape_client` (`id_escape`,`id_client`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `carte_cadeau`
--
ALTER TABLE `carte_cadeau`
  ADD PRIMARY KEY (`id_carte`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `escape_game`
--
ALTER TABLE `escape_game`
  ADD PRIMARY KEY (`id_escape`);

--
-- Index pour la table `mettre_favoris_version`
--
ALTER TABLE `mettre_favoris_version`
  ADD PRIMARY KEY (`id_client`,`id_version`);

--
-- Index pour la table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id_version`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis_escape`
--
ALTER TABLE `avis_escape`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `carte_cadeau`
--
ALTER TABLE `carte_cadeau`
  MODIFY `id_carte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `escape_game`
--
ALTER TABLE `escape_game`
  MODIFY `id_escape` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `version`
--
ALTER TABLE `version`
  MODIFY `id_version` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis_escape`
--
ALTER TABLE `avis_escape`
  ADD CONSTRAINT `avis_escape_ibfk_1` FOREIGN KEY (`id_escape`) REFERENCES `escape_game` (`id_escape`) ON DELETE CASCADE,
  ADD CONSTRAINT `avis_escape_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
